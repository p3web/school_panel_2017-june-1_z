<?php
/**
 * Created by PhpStorm.
 * User: peymanvalikhanli
 * Date: 6/19/17 AD
 * Time: 11:06
 */

require_once 'PSCO_data.php';

class access_school_key_fact {

    public static function key_facts_to_string(){

        $string_fact = "";


        $data = self::exam1();
       // print_r($data); exit; //this line braekpoint for debuging

        $string_fact .= $data[0]['count'];


        return $string_fact;

    }

    private static function exam1 (){
        //SELECT count( DISTINCT studentemailid) FROM student where schoolid=&quot;14&quot; AND classname=&quot;S1&quot;
        $data = data::selects_col("`student`","count( DISTINCT studentemailid) as count", "schoolid=14 AND classname='S1'");
        if (count($data[0]) != 0) {
            return $data;
        } else {
            return false;
        }
    }


}