<?php
/**
 * Created by PhpStorm.
 * User: peymanvalikhanli
 * Date: 6/11/17 AD
 * Time: 19:57
 */

require_once 'PSCO_data.php';
require_once 'csv_file.php';


class religion {
// SELECT  FROM staff where orgid='".$orgId."' AND deptname='".$deptName."' AND teamname='".$teamName."' AND status='active' GROUP BY religion ORDER BY COUNT( religion ) DESC");

    private static function get_religion($orgId, $deptName, $teamName)
    {
        $data = data::selects_col("staff","religion, COUNT( religion ) as count", "orgid='$orgId' AND deptname='$deptName' AND teamname='$teamName' AND status='active' GROUP BY religion ORDER BY COUNT( religion ) DESC");
        if (count($data[0]) != 0) {
            return $data;
        } else {
            return false;


        }
    }

    public static function get_table_religion($orgId, $deptName, $teamName)
    {
        // religen
        // $data = data::selects_col("staff","religion, COUNT( religion ) as count", "orgid='$orgId' AND deptname='$deptName' AND teamname='$teamName' AND status='active' GROUP BY religion ORDER BY COUNT( religion ) DESC");

        $data = self::get_religion($orgId, $deptName, $teamName);

        csv_file::makecsv($data , 'teamadminreligonout.csv', false);

        $result = array();

        for ($i = 0; $i < count($data); $i++) {

            $result[] = array($data[$i]['religion'], $data[$i]['count']);
        }


        return json_encode($result);


    }

    public static function get_chart_donut_religion($orgId, $deptName, $teamName)
    {
        // religen
        // $data = data::selects_col("staff","religion, COUNT( religion ) as count", "orgid='$orgId' AND deptname='$deptName' AND teamname='$teamName' AND status='active' GROUP BY religion ORDER BY COUNT( religion ) DESC");

        $data = self::get_religion($orgId, $deptName, $teamName);


        $result = array();

        for ($i = 0; $i < count($data); $i++) {

            $result[] = array($data[$i]['religion'], ($data[$i]['count']*1));
        }



        $result[] = array('name'=>'Proprietary or Undetectable' , 'y'=> 0.2 , 'dataLabels'=> array('enabled'=>false));

        return json_encode($result);


    }

    public static function get_chart_religion($orgId, $deptName, $teamName)
    {

        $data = self::get_religion($orgId, $deptName, $teamName);
        $result = array();

        for ($i = 0; $i < count($data); $i++) {

            $result[] = array('name'=>$data[$i]['religion'], 'y'=>$data[$i]['count']);
        }

        return json_encode($result);
    }

    private static function get_religion_teacher($schoolId, $className)
    {
        $data = data::selects_col("`student`","religion, COUNT( religion ) as count", "schoolid='" . $schoolId . "' AND classname='" . $className . "' AND status='active' GROUP BY religion");
        if (count($data[0]) != 0) {
            return $data;
        } else {
            return false;


        }
    }

    public static function get_table_religion_teacher($schoolId, $className)
    {
        // religen
        // $data = data::selects_col("staff","religion, COUNT( religion ) as count", "orgid='$orgId' AND deptname='$deptName' AND teamname='$teamName' AND status='active' GROUP BY religion ORDER BY COUNT( religion ) DESC");

        $data = self::get_religion_teacher($schoolId, $className);

        csv_file::makecsv($data , 'teacherreligonout.csv', false);

        $result = array();

        for ($i = 0; $i < count($data); $i++) {

            $result[] = array($data[$i]['religion'], $data[$i]['count']);
        }


        return json_encode($result);


    }

    public static function get_chart_donut_religion_teacher($schoolId, $className)
    {
        // religen
        // $data = data::selects_col("staff","religion, COUNT( religion ) as count", "orgid='$orgId' AND deptname='$deptName' AND teamname='$teamName' AND status='active' GROUP BY religion ORDER BY COUNT( religion ) DESC");

        $data = self::get_religion_teacher($schoolId, $className);


        $result = array();

        for ($i = 0; $i < count($data); $i++) {

            $result[] = array($data[$i]['religion'], ($data[$i]['count']*1));
        }



        $result[] = array('name'=>'Proprietary or Undetectable' , 'y'=> 0.2 , 'dataLabels'=> array('enabled'=>false));

        return json_encode($result);


    }

    public static function get_chart_religion_teacher($schoolId, $className)
    {

        $data = self::get_religion_teacher($schoolId, $className);
        $result = array();

        for ($i = 0; $i < count($data); $i++) {

            $result[] = array('name'=>$data[$i]['religion'], 'y'=>$data[$i]['count']);
        }

        return json_encode($result);
    }


}