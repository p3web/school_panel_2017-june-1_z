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

    public static function a()
    {
/*
        //Staff:
        $querytest .= " select staffbirthplace as x from staffbirthdetails where staffemailid IN(SELECT staffemailid FROM staff where orgid='" . $orgId . "' AND deptname='" . $deptName . "' AND teamname='" . $teamName . "')";
        $unionAllOption = 1;
        //Father:
        $querytest .= " select stafffatherbirthplace as x from staffbirthdetails where staffemailid IN(SELECT staffemailid FROM staff where orgid='" . $orgId . "' AND deptname='" . $deptName . "' AND teamname='" . $teamName . "')";
        $unionAllOption = 1;
        //Mother:
        $querytest .= " select staffmotherbirthplace as x from staffbirthdetails where staffemailid IN(SELECT staffemailid FROM staff where orgid='" . $orgId . "' AND deptname='" . $deptName . "' AND teamname='" . $teamName . "')";
        $unionAllOption = 1;
        //Paternal GrandFather:
        $querytest .= " select stafffathersfatherbirthplace as x from staffbirthdetails where staffemailid IN(SELECT staffemailid FROM staff where orgid='" . $orgId . "' AND deptname='" . $deptName . "' AND teamname='" . $teamName . "')"; $unionAllOption = 1; Paternal GrandMother: $querytest .= " select stafffathersmotherbirthplace as x from staffbirthdetails where staffemailid IN(SELECT staffemailid FROM staff where orgid='" . $orgId . "' AND deptname='" . $deptName . "' AND teamname='" . $teamName . "')"; $unionAllOption = 1; Maternal GrandFather: $querytest .= " select staffmothersfatherbirthplace as x from staffbirthdetails where staffemailid IN(SELECT staffemailid FROM staff where orgid='" . $orgId . "' AND deptname='" . $deptName . "' AND teamname='" . $teamName . "')"; $unionAllOption = 1; Maternal GrandMother: $querytest .= " select staffmothersmotherbirthplace as x from staffbirthdetails where staffemailid IN(SELECT staffemailid FROM staff where orgid='" . $orgId . "' AND deptname='" . $deptName . "' AND teamname='" . $teamName . "')"; $unionAllOption = 1;}
*/}
}