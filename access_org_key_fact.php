<?php
/**
 * Created by PhpStorm.
 * User: peymanvalikhanli
 * Date: 6/20/17 AD
 * Time: 13:32
 */


require_once 'PSCO_data.php';


class access_org_key_fact {
    public static function key_facts_to_string($orgid){

        $string_fact = "<ul style='color: black; line-height: 200%; font-size: medium;'>";


        $data = self::exam1($orgid);
        // print_r($data); exit; //this line braekpoint for debuging

        $string_fact .= "<li> There are ".$data[0]['count']." students in the class, of which D are still awaiting to accept the invitation</li>";


        $string_fact.="</ul>";
        return $string_fact;

    }

    private static function exam1 ($orgid){

        $data = data::selects_col("bornGrandParentsInAnotherCountryStaff b","count(b.staffemailid) as numberStaffAnotherCountry, (count(b.staffemailid)*100)/b.allstaff as percent", " b.orgid = $orgid");
        if (count($data[0]) != 0) {
            return $data;
        } else {
            return false;
        }
    }
}