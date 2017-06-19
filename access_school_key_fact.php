<?php
/**
 * Created by PhpStorm.
 * User: peymanvalikhanli
 * Date: 6/19/17 AD
 * Time: 11:06
 */

require_once 'PSCO_data.php';


class access_school_key_fact {

    public static function key_facts_to_string($schoolid , $classname){

        $string_fact = "<ul style='color: black; line-height: 200%; font-size: medium;'>";


        $data = self::exam1($schoolid , $classname);
       // print_r($data); exit; //this line braekpoint for debuging

        $string_fact .= "<li> There are ".$data[0]['count']." students in the class, of which D are still awaiting to accept the invitation</li>";


        $string_fact.="</ul>";
        return $string_fact;

    }

    private static function exam1 ($schoolid , $classname){
        //SELECT count( DISTINCT studentemailid) FROM student where schoolid=&quot;14&quot; AND classname=&quot;S1&quot;
        $data = data::selects_col("`student`","count( DISTINCT studentemailid) as count", "schoolid= '$schoolid' AND classname='$classname'");
        if (count($data[0]) != 0) {
            return $data;
        } else {
            return false;
        }
    }


}