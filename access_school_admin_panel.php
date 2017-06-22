<?php
/**
 * Created by PhpStorm.
 * User: peymanvalikhanli
 * Date: 6/15/17 AD
 * Time: 14:42
 */

require_once 'PSCO_data.php';


class access_school_admin_panel
{

    public static function get_school_by_adminemailid($adminid)
    {
        $data = data::selects("`school`", "`adminemailid` = '$adminid'");
        if (count($data[0]) != 0) {
            return $data;
        } else {
            return false;
        }
    }

    public static function get_school_profile_by_adminemailid($adminemailid)
    {
        $data = data::selects_col("`school`", "`schoolid`, `schoolname`, `adminemailid`, `firstname`, `lastname`, `country`, `state`, `city`, `suburb`, `postcode`", "`adminemailid` = '$adminemailid'");
        if (count($data[0]) != 0) {
            return $data;
        } else {
            return false;
        }
    }

    public static function edit_school_profile_by_adminemailid($schoolid, $schoolname, $adminemailid, $firstname, $lastname, $country, $state, $city, $suburb, $postcode)
    {
        return data::update("`school`", "`schoolid`= '$schoolid' ,`schoolname` = '$schoolname' , `firstname`='$firstname',`lastname`='$lastname' , `country`= '$country' , `state` = '$state' , `city` = '$city' , `suburb` = '$suburb' , `postcode` = '$postcode'", "`adminemailid` = '$adminemailid'");
    }

    public static function get_teacher_by_schoolId($schoolId)
    {
        $data = data::selects_join("`teacher`", "`teacher`.`teacheremailid`,CONCAT(`teacher`.`firstname`, ' ', `teacher`.`lastname`) As name ,`classteacher`.`classname`, `teacher`.`status`", " INNER JOIN `classteacher` on `classteacher`.`schoolid` =`teacher`.`schoolid` and `teacher`.`teacheremailid` =  `classteacher`.`teacheremailid` WHERE `classteacher`.`schoolid` = '$schoolId'");
        if (count($data[0]) != 0) {
            return $data;
        } else {
            return false;
        }
    }

    public static function get_teacher_by_teacherEmailId($teacheremailid)
    {
        $data = data::selects("`teacher`", "`teacheremailid` = '$teacheremailid'");
        if (count($data[0]) != 0) {
            return $data;
        } else {
            return false;
        }
    }

    public static function delete_teacher_by_teacherEmailId($teacheremailid)
    {
        return data::delete("`teacher`", "`teacheremailid` = '$teacheremailid'");
    }

    public static function edit_teacher_by_teacherEmailId($teacheremailid, $firstname, $lastname, $gender, $religion)
    {
        return data::update("`teacher`", "`firstname`='$firstname',`lastname`='$lastname',`gender`='$gender',`religion`='$religion'", "`teacheremailid` = '$teacheremailid'");
    }

    public static function get_teacher_lang_by_teacherEmailId($teacheremailid)
    {
        $data = data::selects("`teacher_language`", "`teacheremailid` = '$teacheremailid'");
        if (count($data[0]) != 0) {
            return $data;
        } else {
            return false;
        }
    }

    public static function delete_teacher_lang_by_langID($id)
    {
        return data::delete("`teacher_language`", "`id`= $id");
    }

    public static function edit_teacher_lang_bylangId($id, $languagename, $languagelevel)
    {
        return data::update("`teacher_language`", "`languagename`='$languagename',`languagelevel`= '$languagelevel' ", "`id`= $id");
    }

    public static function set_teacher_lang_bylangId($teacheremailid, $languagename, $languagelevel)
    {
        return data::insertinto("`teacher_language`", "`teacheremailid`,`languagename`,`languagelevel`' ", "'$teacheremailid' , '$languagename' , '$languagelevel'");
    }

    public static function get_teacher_birthDetails_by_teacherEmailId($teacheremailid)
    {
        $data = data::selects("`teacherbirthdetails`", "`teacheremailid` = '$teacheremailid'");
        if (count($data[0]) != 0) {
            return $data;
        } else {
            return false;
        }
    }

    public static function delete_teacher_birthDetails_by_teacherEmailId($teacheremailid)
    {
        return data::delete("`teacherbirthdetails`", "`teacheremailid` = '$teacheremailid'");
    }

    public static function edit_teacher_birthDetails_by_teacherEmailId($teacheremailid, $birthplace, $fatherbirthplace, $motherbirthplace, $fatherfatherbirthplace, $fathermotherbirthplace, $motherfatherbirthplace, $mothermotherbirthplace)
    {
        return data::update("`teacherbirthdetails`", "`birthplace`='$birthplace',`fatherbirthplace`='$fatherbirthplace',`motherbirthplace`='$motherbirthplace',`fatherfatherbirthplace`='$fatherfatherbirthplace',`fathermotherbirthplace`='$fathermotherbirthplace',`motherfatherbirthplace`='$motherfatherbirthplace',`mothermotherbirthplace`='$mothermotherbirthplace'", "`teacheremailid` = '$teacheremailid'");
    }

    public static function get_class_by_schoolId($schoolId)
    {
        $data = data::selects_col("`class`", " `classname`", "`schoolid` = '$schoolId'");
        if (count($data[0]) != 0) {
            return $data;
        } else {
            return false;
        }
    }

    public static function edit_class_by_schoolId($schoolId, $current_name, $name)
    {
        return data::update("`class`", "`classname`='$name'", "`schoolid` = '$schoolId' and `classname`='$current_name'");
    }

    public static function set_class_by_schoolId($schoolId, $name)
    {
        return data::insertinto("`class`", "`classname`, `schoolid`","'$name','$schoolId'");
    }


    public static function get_religions($schoolId)
    {
        $data = data::selects_col("`student`", "religion, COUNT( religion ) as count", "schoolid='$schoolId'  AND status='active' GROUP BY religion ORDER BY COUNT( religion ) DESC");
        if (count($data[0]) != 0) {
            return $data;
        } else {
            return false;
        }
    }

    public static function get_languge_by_gender($schoolId, $genderMode)
    {
        switch ($genderMode) {
            case 'F':
                $gen = "female";

                $data = data::selects_col('`student_language` ', 'languagename, COUNT( languagename ) as count', "studentemailid IN(SELECT studentemailid FROM student where schoolid='" . $schoolId . "' AND gender='" . $gen . "') GROUP BY languagename ORDER BY COUNT( languagename ) DESC");
                break;

            case 'M':
                $gen = "male";
                $data = data::selects_col('`student_language` ', 'languagename, COUNT( languagename ) as count', "studentemailid IN(SELECT studentemailid FROM student where schoolid='" . $schoolId . "' AND gender='" . $gen . "') GROUP BY languagename ORDER BY COUNT( languagename ) DESC");
                break;

            case 'O':
                $gen = "others";
                $data = data::selects_col('`student_language` ', 'languagename, COUNT( languagename ) as count', "studentemailid IN(SELECT studentemailid FROM student where schoolid='" . $schoolId . "' AND gender='" . $gen . "') GROUP BY languagename ORDER BY COUNT( languagename ) DESC");
                break;

            default:
                $data = data::selects_col("student_language", "languagename, COUNT( languagename ) as count", "studentemailid IN(SELECT studentemailid FROM student where schoolid='" . $schoolId . "' ) GROUP BY languagename ORDER BY COUNT( languagename ) DESC ");
        }
        return $data;
    }

    public static function get_teacher_age_group_by_teacherEmailId($teacheremailid)
    {

        $data = data::selects("`age_group`", "`user_id` = '$teacheremailid' and `type` = 4 ");
        if (count($data[0]) != 0) {
            return $data;
        } else {
            return false;
        }
    }

    public static function edit_teacher_age_group_by_id($id, $age)
    {

        return $data = data::update("`age_group`", "`age`= '$age'", "`id` = '$id' and `type` = 4 ");

    }

    public static function get_map($schoolId ,$aDoor )
    {
        $unionAllOption = 0;
        //starting query
        $querytest = "";

        if (!empty($aDoor)) {
            $querytest .= "select x , COUNT( * ) as count from(";

            $N = count($aDoor);
            for ($i = 0; $i < $N; $i++) {
                if ($aDoor[$i] == 'S') {
                    $querytest .= " select `studentbirthplace` as x from studentbirthdetails where studentemailid IN(SELECT studentemailid FROM student where schoolid='$schoolId')";
                    $unionAllOption = 1;
                }
                if ($aDoor[$i] == 'F') {
                    if ($unionAllOption == 1) {
                        $querytest .= " UNION ALL";
                    }
                    $querytest .= " select `studentfatherbirthplace` as x from studentbirthdetails  where studentemailid IN(SELECT studentemailid FROM student where schoolid='$schoolId')";
                    $unionAllOption = 1;
                }
                if ($aDoor[$i] == 'M') {
                    if ($unionAllOption == 1) {
                        $querytest .= " UNION ALL";
                    }
                    $querytest .= " select `studentmotherbirthplace` as x from studentbirthdetails  where studentemailid IN(SELECT studentemailid FROM student where schoolid='$schoolId')";
                    $unionAllOption = 1;
                }
                if ($aDoor[$i] == 'GFFS') {
                    if ($unionAllOption == 1) {
                        $querytest .= " UNION ALL";
                    }
                    $querytest .= " select `studentfathersfatherbirthplace` as x from studentbirthdetails  where studentemailid IN(SELECT studentemailid FROM student where schoolid='$schoolId')";
                    $unionAllOption = 1;
                }
                if ($aDoor[$i] == 'GMFS') {
                    if ($unionAllOption == 1) {
                        $querytest .= " UNION ALL";
                    }
                    $querytest .= " select `studentfathersmotherbirthplace` as x from studentbirthdetails  where studentemailid IN(SELECT studentemailid FROM student where schoolid='$schoolId')";
                    $unionAllOption = 1;
                }
                if ($aDoor[$i] == 'GFMS') {
                    if ($unionAllOption == 1) {
                        $querytest .= " UNION ALL";
                    }
                    $querytest .= " select `studentmothersfatherbirthplace` as x from studentbirthdetails  where studentemailid IN(SELECT studentemailid FROM student where schoolid='$schoolId')";
                    $unionAllOption = 1;
                }
                if ($aDoor[$i] == 'GMMS') {
                    if ($unionAllOption == 1) {
                        $querytest .= " UNION ALL";
                    }
                    $querytest .= " select `studentmothersmotherbirthplace` as x from studentbirthdetails  where studentemailid IN(SELECT studentemailid FROM student where schoolid='$schoolId')";
                    $unionAllOption = 1;
                }
            }

            $querytest .= " ) as temptable group by x";
        }

        // Default values goes here
        if ($querytest == "") {

            $querytest = "select x , COUNT( * ) as count  from( select `studentbirthplace` as x from studentbirthdetails where studentemailid IN(SELECT studentemailid FROM student where schoolid='$schoolId') ) as temptable group by x";
        }

        return data::execute_non_qury($querytest);
    }

}


