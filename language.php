<?php
/**
 * Created by PhpStorm.
 * User: peymanvalikhanli
 * Date: 6/10/17 AD
 * Time: 21:58
 */

require_once 'PSCO_data.php';

class language
{
    // SELECT  FROM staff where orgid='".$orgId."' AND deptname='".$deptName."' AND teamname='".$teamName."' AND status='active' GROUP BY religion ORDER BY COUNT( religion ) DESC");

    private static function get_lang($orgId, $deptName, $teamName)
    {
        $data = data::selects_col("staff_language", "languagename, COUNT( languagename ) as count", "staffemailid IN(SELECT staffemailid FROM staff where orgid='$orgId' AND teamname='$teamName' AND deptname='$deptName') GROUP BY languagename ORDER BY COUNT( languagename ) DESC");
        if (count($data[0]) != 0) {
            return $data;
        } else {
            return false;


        }
    }

    public static function get_table_language($orgId, $deptName, $teamName)
    {
        // religen
        // $data = data::selects_col("staff","religion, COUNT( religion ) as count", "orgid='$orgId' AND deptname='$deptName' AND teamname='$teamName' AND status='active' GROUP BY religion ORDER BY COUNT( religion ) DESC");

        $data = self::get_lang($orgId, $deptName, $teamName);


        $result = array();

        for ($i = 0; $i < count($data); $i++) {

            $result[] = array($data[$i]['languagename'], $data[$i]['count']);
        }


        return json_encode($result);


    }

    public static function get_chart_language($orgId, $deptName, $teamName)
    {

        $data = self::get_lang($orgId, $deptName, $teamName);
        $result = array();

        for ($i = 0; $i < count($data); $i++) {

            $result[] = array('name'=>$data[$i]['languagename'], 'y'=>$data[$i]['count']);
        }

        return json_encode($result);
    }
}