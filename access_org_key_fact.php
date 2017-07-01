<?php
/**
 * Created for Cultural Infusion under the project AncestryAtlas
 * File: team_admin_key_fact.php
 * User: Nabi
 * Date: 22/06/2017
 * Time: 11:15
 */

require_once 'PSCO_data.php';


class access_org_key_fact {
    public static function key_facts_to_string($orgid){

        $string_fact = "<ul style='color: black; line-height: 200%; font-size: medium;'>";

        //$data = self::registered_count($orgid);
        // print_r($data); exit; //this line braekpoint for debuging

        //$string_fact .= "<li> In total, there are ".$data[0]['count']." students registered on AncestryAtlas from this school.</li>";
        $string_fact .= "<br>";

        //Country count
        $data = self::country_count($orgid);
        $string_fact .= "<li> In total, staff in this organization are from ".$data[0]['count']." different countries. (including students, their parents and grandparents ).</li>";
        //Birth country
        $data = self::born_country($orgid);
        $string_fact .= "<li>".number_format($data[0]['percent'], 2, '.', ',' )."% of staff in this organisation are born in \"First Country\"</li>";
        $string_fact .= "<li> Only ".number_format($data[0]['percentParents'], 2, '.', ',' )."% of staff in this organisation have both parents born in \"First country \"</li>";
        $string_fact .= "<li>".number_format($data[0]['percentGParents'], 2, '.', ',' )."% of staff in this organisation are from \"First Country\" for the last two generations ( All parents and grandparents are born in \"first country \"  ).</li>";
        //Cultures influence
        $data = self::cultures_country_influence($orgid);
        $string_fact .= "<li> Cultures from countries ".$data[0]['country'].", ".$data[1]['country'].", ".$data[2]['country']." have the most influence in this organisation.</li>";
        //Born overseas
        //$data = self::languages($orgid);
        //$string_fact .= "<li>"/*.number_format($data[0]['percent'], 2, '.', ',' )*/."% of students in this school have at least one parent born overseas.</li>";
        //$string_fact .= "<li>"/*.number_format($data[0]['percentGParents'], 2, '.', ',' )*/."% of students in this school have at least one Grandparent born overseas.</li>";
        //Parent born overseas
        $data = self::parent_born_overseas($orgid);
        $string_fact .= "<li>".number_format($data[0]['percent'], 2, '.', ',' )."% have at least one parent born overseas.</li>";
        $data = self::gparent_born_overseas($orgid);
        $string_fact .= "<li>".number_format($data[0]['percent'], 2, '.', ',' )."% have at least one Grandparent born overseas.</li>";
        $string_fact .= "<br>";
        //Total number of spoken languages
        $data = self::languages($orgid);
        $string_fact .= "<li> In total, people in this organisation can speak up to ".$data[0]['count']." languages.</li>";
        //most spoken language
        $data = self::count_Languages($orgid);
        //organisation
        $string_fact .= "<li>".$data[0]['languagename']."(".$data[0]['count']."), ".$data[1]['languagename']."(".$data[1]['count']."), ".$data[2]['languagename']."(".$data[2]['count'].") are the most spoken languages in this organisation.</li>";
        ////max language
        //$data = self::Highest_number($orgid);
        //$string_fact .= "<li> The maximum number of languages spoken by a student in this school is ".$data[0]['count'].".</li>";
        ////Born overseas
        //$data = self::born_overseas($orgid);
        //$string_fact .= "<li> The maximum number of languages spoken by a student in this school is ".$data[0]['count'].".</li>";
        ////male female language known
        $data = self::male_female_know_language($orgid);
        $string_fact .= "<li> As an average female staff understand ".number_format($data[0][0]['averageLanguage'], 2, '.', ',' )." languages while male staff  know ".number_format($data[1][0]['averageLanguage'], 2, '.', ',' )." number of languages in this organisation.</li>";
        //how many people spoken 1,2,3 lang
        $data = self::num_of_language_spoken($orgid);
        $string_fact .= "<li>".number_format($data[0][0]['percent'], 2, '.', ',' )."% of people in this organization ( ".number_format($data[0][0]['numberStaff'], 0, '.', ',' )." people ) can speak only one language.</li>";
        $string_fact .= "<li>".number_format($data[1][0]['percent'], 2, '.', ',' )."% of people in this organization ( ".number_format($data[1][0]['numberStaff'], 0, '.', ',' )." people ) can speak two or more languages.</li>";
        $string_fact .= "<li>".number_format($data[2][0]['percent'], 2, '.', ',' )."% of people in this organization ( ".number_format($data[2][0]['numberStaff'], 0, '.', ',' )." people ) can speak three or more languages.</li>";
        $string_fact .= "<br>";
        //different faiths
        $data = self::different_faiths($orgid);
        $string_fact .= "<li> In total, people in this organisation believe in ".number_format($data[0]['count'], 2, '.', ',' )." different beliefs.</li>";
        //non-disclosed beliefs
        $data = self::unclear_faiths($orgid);
        //•	In this organisation  A%  of staff are not willing to revile their belief.
        $string_fact .= "<li> In this organisation ".number_format($data[0]['count'], 2, '.', ',' ). "%  of staff are not willing to revile their belief.</li>";


        $string_fact.="</ul>";
        return $string_fact;

    }

    private static function registered_count ($orgid){
        //this function is just same as grandparents in PSCO_function.php. of course that function should be renamed to this one.
        $data = data::selects_col("`student`","count(studentemailid) as count", "schoolid= '$orgid'");
        if (count($data[0]) != 0) {
            return $data;
        } else {
            return false;
        }
    }
    private static function country_count ($orgid){

        $data = data::selects_col("(
        SELECT staffbirthplace as x ,count(*)  from `staffbirthdetails` where staffemailid IN(SELECT staffemailid FROM staff where orgid=$orgid ) group by staffbirthplace 
    union all 
    SELECT  stafffatherbirthplace as x ,count(*)  from `staffbirthdetails` where staffemailid IN(SELECT staffemailid FROM staff where orgid=$orgid ) group by stafffatherbirthplace
    union ALL
    SELECT  staffmotherbirthplace as x,count(*)  from `staffbirthdetails` where staffemailid IN(SELECT staffemailid FROM staff where orgid=$orgid ) group by staffmotherbirthplace
    union ALL
    SELECT  stafffathersfatherbirthplace as x,count(*)  from `staffbirthdetails` where staffemailid IN(SELECT staffemailid FROM staff where orgid=$orgid ) group by stafffathersfatherbirthplace
    union ALL
    SELECT  stafffathersmotherbirthplace as x,count(*)  from `staffbirthdetails` where staffemailid IN(SELECT staffemailid FROM staff where orgid=$orgid ) group by stafffathersmotherbirthplace
    union ALL
    SELECT  staffmothersfatherbirthplace as x,count(*)  from `staffbirthdetails` where staffemailid IN(SELECT staffemailid FROM staff where orgid=$orgid ) group by staffmothersfatherbirthplace
    union ALL
    SELECT  staffmothersmotherbirthplace as x,count(*)  from `staffbirthdetails` where staffemailid IN(SELECT staffemailid FROM staff where orgid=$orgid ) group by staffmothersmotherbirthplace) as t1","count(DISTINCT x) as count", "");
        if (count($data[0]) != 0) {
            return $data;
        } else {
            return false;
        }
    }
    private static function born_country ($orgid){
        $data = data::selects_col("born","allStaff, count(born.staffCountry) as numberStaffCountry, (100*count(born.staffCountry))/allstaff as percent, sum(born.father+born.mother)/2 as parents, (100*(sum(born.father+born.mother)/2)/allstaff) as percentParents, sum(born.grandfather1+born.grandmother1+born.grandfather2+born.grandmother2)/4 as gparents, (100*(sum(born.grandfather1+born.grandmother1+born.grandfather2+born.grandmother2)/4)/(allStaff)) as percentGParents", " orgid = $orgid");
        if (count($data[0]) != 0) {
            return $data;
        } else {
            return false;
        }
    }
    private static function cultures_country_influence ($orgid){
        $data = data::selects_col("`numberStaffCountry` n","n.staffbirthplace as country, (n.numberPeopleCountry*100)/n.numberStaff  as percent, n.teamname, n.teamname", "n.orgid = '$orgid' order by n.orgid, n.teamname, n.numberPeopleCountry DESC LIMIT 3");
        if (count($data[0]) != 0) {
            return $data;
        } else {
            return false;
        }
    }
    private static function languages ($orgid){
        $data = data::selects_col("stafflanguage , staff","count( DISTINCT languagename) as count", "orgid= '$orgid'");
        if (count($data[0]) != 0) {
            return $data;
        } else {
            return false;
        }
    }
    private static function born_overseas ($orgid){
        //SELECT count(b.staffemailid) as numberStaffAnotherCountry, (count(b.staffemailid)*100)/b.allstaff as percent FROM `bornGrandParentsInAnotherCountryStaff` b where b.orgid = 1
        //SELECT count(b.staffemailid) as numberStaffAnotherCountry, (count(b.staffemailid)*100)/b.allstaff as percent FROM `bornParentsInAnotherCountryStaff` b where b.orgid = 1

        $data = data::selects_col("bornGrandParentsInAnotherCountryStaff b","count(b.staffemailid) as numberStaffAnotherCountry, (count(b.staffemailid)*100)/b.allstaff as percent", " b.orgid = $orgid");
        if (count($data[0]) != 0) {
            return $data;
        } else {
            return false;
        }
    }
    private static function parent_born_overseas ($orgid){
        $data = data::selects_col("bornGrandParentsInAnotherCountryStaff b","count(b.staffemailid) as numberStaffAnotherCountry, (count(b.staffemailid)*100)/b.allstaff as percent", " b.orgid = $orgid");
        if (count($data[0]) != 0) {
            return $data;
        } else {
            return false;
        }
    }
    private static function gparent_born_overseas ($orgid){

        $data = data::selects_col("bornParentsInAnotherCountryStaff b","count(b.staffemailid) as numberStaffAnotherCountry, (count(b.staffemailid)*100)/b.allstaff as percent", " b.orgid = $orgid");
        if (count($data[0]) != 0) {
            return $data;
        } else {
            return false;
        }
    }
    private static function count_Languages ($orgid){
        //SELECT languagename ,count(*) FROM `stafflanguage` where staffemailid IN(SELECT staffemailid FROM staff where orgid="1" ) group by languagename order by COUNT(*) desc LIMIT 3
        $data = data::selects_col("`stafflanguage`","languagename ,count(*) as count", "staffemailid IN(SELECT staffemailid FROM staff where orgid= '$orgid' ) group by languagename order by COUNT(*) desc LIMIT 3");
        if (count($data[0]) != 0) {
            return $data;
        } else {
            return false;
        }
    }
    private static function Highest_number ($orgid){
        //SELECT studentemailid as s, count(*) FROM studentlanguage where studentemailid IN(SELECT studentemailid FROM student where schoolid="14" ) group by studentemailid order by count(*) DESC LIMIT 1
        $data = data::selects_col("`studentlanguage`","studentemailid as s, count(*) as count", "studentemailid IN(SELECT studentemailid FROM student where schoolid= '$orgid' ) group by studentemailid order by count(*) DESC LIMIT 1");
        if (count($data[0]) != 0) {
            return $data;
        } else {
            return false;
        }
    }
    private static function male_female_know_language ($orgid){
        //SELECT (numberLanguagesKnown/genderNumber) as averageLanguage FROM `numberLanguageGender` where orgid = 1 and gender = 'female'
        // SELECT (numberLanguagesKnown/genderNumber) as averageLanguage FROM `numberLanguageGender` where  orgid = 1  and gender = 'male'


        $data[0] = data::selects_col("`numberLanguageGender`","(numberLanguagesKnown/genderNumber) as averageLanguage", "orgid= '$orgid' and gender = 'female'");
        $data[1] = data::selects_col("`numberLanguageGender`","(numberLanguagesKnown/genderNumber) as averageLanguage", "orgid= '$orgid' and gender = 'male'");
        if (count($data[0][0]) != 0) {
            return $data;
        } else {
            return false;
        }
    }
    private static function num_of_language_spoken ($orgid){
        $data[0] = data::selects_col("`viewLanguageTeam`","count(numberL) numberStaff, (count(numberL)*100)/allStaff as percent", "orgid= '$orgid' and numberL = 1");
        $data[1] = data::selects_col("`viewLanguageTeam`","count(numberL) numberStaff, (count(numberL)*100)/allStaff as percent", "orgid= '$orgid' and numberL >= 2");
        $data[2] = data::selects_col("`viewLanguageTeam`","count(numberL) numberStaff, (count(numberL)*100)/allStaff as percent", "orgid= '$orgid' and numberL >= 3");
        if (count($data[0][0]) != 0) {
            return $data;
        } else {
            return false;
        }
    }
    private static function different_faiths ($orgid){
        $data = data::selects_col("`staff`","count( DISTINCT religion) as count", "orgid= '$orgid'");
        if (count($data[0]) != 0) {
            return $data;
        } else {
            return false;
        }
    }
    private static function unclear_faiths ($orgid){
        $data = data::selects_col("`staff`","count(*) as count", "staffemailid IN(SELECT staffemailid FROM staff where orgid='$orgid') and religion='no religion'");
        if (count($data[0]) != 0) {
            return $data;
        } else {
            return false;
        }
    }

    //end of class
}