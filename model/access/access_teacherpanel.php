<?php
/**
 * Created by PhpStorm.
 * User: peymanvalikhanli
 * Date: 6/2/17 AD
 * Time: 12:28
 */

class access_teacherpanel {


    public static function get_teacher_by_teacheremailid($adminid){
        $data = data::selects('`teacher`', "teacheremailid = '$adminid'" );

        if (count($data[0]) != 0) {
            return $data;
        } else {
            return false;
        }
    }

    public static function get_school_by_schoolid($schoolId){

        $data = data::selects('`school`', "schoolid = '$schoolId'" );

        if (count($data[0]) != 0) {
            return $data;
        } else {
            return false;
        }
    }

    public static function get_classteacher_by_schoolid_teacheremailid($schoolId,$adminid){

        $data = data::selects('`classteacher`', "schoolid = '$schoolId' AND teacheremailid = '$adminid'" );

        if (count($data[0]) != 0) {
            return $data;
        } else {
            return false;
        }
    }


    public static function get_religion($className,$schoolId) {

        $result = data::selects_col("student","religion, COUNT( religion ) as count", "schoolid='$schoolId' AND classname='$className' AND status='active' GROUP BY religion ORDER BY COUNT( religion ) DESC");

        if (count($result[0]) != 0) {
            return $result;
        } else {
            return false;
        }

    }

}