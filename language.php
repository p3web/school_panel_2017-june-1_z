<?php
/**
 * Created by PhpStorm.
 * User: peymanvalikhanli
 * Date: 6/10/17 AD
 * Time: 21:58
 */

require_once 'PSCO_data.php';
require_once 'csv_file.php';

class language
{

    private static function get_lang($orgId, $deptName, $teamName,$genderMode='A')
    {

        switch($genderMode) {
            case 'F':
                $gen="female";
                $data = data::selects_col('`staff_language` ','languagename, COUNT( languagename ) as count',"staffemailid IN(SELECT staffemailid FROM staff where orgid='".$orgId."' AND teamname='".$teamName."' AND deptname='".$deptName."' AND gender='".$gen."') GROUP BY languagename ORDER BY COUNT( languagename ) DESC");
                break;

            case 'M':
                $gen="male";
                $data = data::selects_col('`staff_language` ','languagename, COUNT( languagename ) as count',"staffemailid IN(SELECT staffemailid FROM staff where orgid='".$orgId."' AND teamname='".$teamName."' AND deptname='".$deptName."' AND gender='".$gen."') GROUP BY languagename ORDER BY COUNT( languagename ) DESC");
                break;

            case 'O':
                $gen="others";
                $data = data::selects_col('`staff_language` ','languagename, COUNT( languagename ) as count',"staffemailid IN(SELECT staffemailid FROM staff where orgid='".$orgId."' AND teamname='".$teamName."' AND deptname='".$deptName."' AND gender='".$gen."') GROUP BY languagename ORDER BY COUNT( languagename ) DESC");
                break;

            default:
                $data = data::selects_col("staff_language", "languagename, COUNT( languagename ) as count", "staffemailid IN(SELECT staffemailid FROM staff where orgid='$orgId' AND teamname='$teamName' AND deptname='$deptName') GROUP BY languagename ORDER BY COUNT( languagename ) DESC");

        }

        if (count($data[0]) != 0) {
            return $data;
        } else {
            return false;


        }
    }

    public static function get_table_language($orgId, $deptName, $teamName,$genderMode='A')
    {

        $data = self::get_lang($orgId, $deptName, $teamName,$genderMode);

        csv_file::makecsv($data , 'teamadminlangout.csv', false);

        $result = array();

        for ($i = 0; $i < count($data); $i++) {

            $result[] = array($data[$i]['languagename'], $data[$i]['count']);
        }


        return json_encode($result);


    }

    public static function get_chart_donut_language($orgId, $deptName, $teamName,$genderMode='A')
    {

        $data = self::get_lang($orgId, $deptName, $teamName,$genderMode);

        $result = array();

        for ($i = 0; $i < count($data); $i++) {

            $result[] = array($data[$i]['languagename'], ($data[$i]['count']*1));
        }



        $result[] = array('name'=>'Proprietary or Undetectable' , 'y'=> 0.2 , 'dataLabels'=> array('enabled'=>false));

        return json_encode($result);


    }

    public static function get_chart_language($orgId, $deptName, $teamName,$genderMode='A')
    {

        $data = self::get_lang($orgId, $deptName, $teamName,$genderMode);
        $result = array();

        for ($i = 0; $i < count($data); $i++) {

            $result[] = array('name'=>$data[$i]['languagename'], 'y'=>$data[$i]['count']);
        }

        return json_encode($result);
    }

    private static function get_lang_teacher($schoolId, $className,$genderMode='A')
    {

        switch($genderMode) {
            case 'F':
                $gen="female";

                $data = data::selects_col('`student_language` ','languagename, COUNT( languagename ) as count',"studentemailid IN(SELECT studentemailid FROM student where schoolid='".$schoolId."' AND classname='".$className."' AND gender='".$gen."') GROUP BY languagename ORDER BY COUNT( languagename ) DESC");
                break;

            case 'M':
                $gen="male";
                $data = data::selects_col('`student_language` ','languagename, COUNT( languagename ) as count',"studentemailid IN(SELECT studentemailid FROM student where schoolid='".$schoolId."' AND classname='".$className."' AND gender='".$gen."') GROUP BY languagename ORDER BY COUNT( languagename ) DESC");
                break;

            case 'O':
                $gen="others";
                $data = data::selects_col('`student_language` ','languagename, COUNT( languagename ) as count',"studentemailid IN(SELECT studentemailid FROM student where schoolid='".$schoolId."' AND classname='".$className."' AND gender='".$gen."') GROUP BY languagename ORDER BY COUNT( languagename ) DESC");
                break;

            default:
                $data = data::selects_col("student_language", "languagename, COUNT( languagename ) as count", "studentemailid IN(SELECT studentemailid FROM student where schoolid='" . $schoolId . "' AND classname='" . $className . "' ) GROUP BY languagename ORDER BY COUNT( languagename ) DESC ");

        }

        if (count($data[0]) != 0) {
            return $data;
        } else {
            return false;


        }
    }

    public static function get_table_language_teacher($schoolId, $className,$genderMode='A')
    {

        $data = self::get_lang_teacher($schoolId, $className,$genderMode);

        csv_file::makecsv($data , 'teacherlangout.csv', false);

        $result = array();

        for ($i = 0; $i < count($data); $i++) {

            $result[] = array($data[$i]['languagename'], $data[$i]['count']);
        }


        return json_encode($result);


    }

    public static function get_chart_donut_language_teacher($schoolId, $className,$genderMode='A')
    {

        $data = self::get_lang_teacher($schoolId, $className,$genderMode);

        $result = array();

        for ($i = 0; $i < count($data); $i++) {

            $result[] = array($data[$i]['languagename'], ($data[$i]['count']*1));
        }



        $result[] = array('name'=>'Proprietary or Undetectable' , 'y'=> 0.2 , 'dataLabels'=> array('enabled'=>false));

        return json_encode($result);


    }

    public static function get_chart_language_teacher($schoolId, $className,$genderMode='A')
    {

        $data = self::get_lang_teacher($schoolId, $className,$genderMode);
        $result = array();

        for ($i = 0; $i < count($data); $i++) {

            $result[] = array('name'=>$data[$i]['languagename'], 'y'=>$data[$i]['count']);
        }

        return json_encode($result);
    }



}