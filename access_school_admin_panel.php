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
        $data = data::selects_join("`teacher`", "`teacher`.`teacheremailid`, `classteacher`.`classname`, `teacher`.`status`", " INNER JOIN `classteacher` on `classteacher`.`schoolid` =`teacher`.`schoolid` and `teacher`.`teacheremailid` =  `classteacher`.`teacheremailid` WHERE `classteacher`.`schoolid` = '$schoolId'");
        if (count($data[0]) != 0) {
            return $data;
        } else {
            return false;
        }
    }

    public static function get_class_by_schoolId($schoolId)
    {
        $data = data::selects_col("`class`"," `classname`", "`schoolid` = '$schoolId'");
        if (count($data[0]) != 0) {
            return $data;
        } else {
            return false;
        }
    }

}