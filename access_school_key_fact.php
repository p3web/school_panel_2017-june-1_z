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


        $data = self::registered_count($schoolid , $classname);
        // print_r($data); exit; //this line braekpoint for debuging

        $string_fact .= "<li> In total, there are ".$data[0]['count']." students registered on AncestryAtlas from this school.</li>";
        //Country count
        $data = self::country_count($schoolid , $classname);
        $string_fact .= "<li> In total, students in this school are from ".$data[0]['count']." different countries. (including students, their parents and grandparents ).</li>";
        //Birth country
        $data = self::born_country($schoolid , $classname);
        $string_fact .= "<li>".number_format($data[0]['percent'], 2, '.', ',' )."% of students in this school are born in Australia.</li>";
        $string_fact .= "<li> Only ".number_format($data[0]['percentParents'], 2, '.', ',' )."% of students have both parents born in Australia.</li>";
        $string_fact .= "<li>".number_format($data[0]['percentGParents'], 2, '.', ',' )."% of students in this school are from Australia for the last two generations (All parents and grandparents are born in Australia).</li>";
        //Cultures influence
        $data = self::cultures_country_influence($schoolid , $classname);
        $string_fact .= "<li> Cultures for ".$data[0]['country'].", ".$data[1]['country'].", ".$data[2]['country']." have most influence on the school.</li>";
        //Born overseas
        $data = self::born_overseas($schoolid , $classname);
        $string_fact .= "<li>"/*.number_format($data[0]['percent'], 2, '.', ',' )*/."% of students in this school have at least one parent born overseas.</li>";
        $string_fact .= "<li>"/*.number_format($data[0]['percentGParents'], 2, '.', ',' )*/."% of students in this school have at least one Grandparent born overseas.</li>";
        $string_fact .= "<li> In total, students in this school can speak up to ".$data[0]['count']." languages.</li>";
        //most spoken language
        $data = self::count_Languages($schoolid , $classname);
        $string_fact .= "<li> The most spoken languages in this school are: ".$data[0]['languagename']."(".$data[0]['count']."), ".$data[1]['languagename']."(".$data[1]['count']."), ".$data[2]['languagename']."(".$data[2]['count'].") .</li>";
        //max language
        $data = self::Highest_number($schoolid , $classname);
        //The maximum number of languages spoken by a student in this school is  “ MAX languages”.
        $string_fact .= "<li> The maximum number of languages spoken by a student in this school is ".$data[0]['count'].".</li>";
        //male female language known
        $data = self::male_female_know_language($schoolid , $classname);
        //As an average girls understand 6.00 languages while boys  know 4.50 number of languages.
        $string_fact .= "<li> As an average girls understand ".number_format($data[0][0]['averageLanguage'], 2, '.', ',' )." languages while boys  know ".number_format($data[1][0]['averageLanguage'], 2, '.', ',' )." number of languages.</li>";


        $string_fact.="</ul>";
        return $string_fact;

    }

    private static function registered_count ($schoolid , $classname){
        //this function is just same asgrandparents in PSCO_function.php. of course that function should be renamed to this one.
        $data = data::selects_col("`student`","count(studentemailid) as count", "schoolid= '$schoolid'");
        if (count($data[0]) != 0) {
            return $data;
        } else {
            return false;
        }
    }

    private static function country_count ($schoolid , $classname){
        $data = data::selects_col("(
        SELECT studentbirthplace as x ,count(*)  from `studentbirthdetails`  where studentemailid IN(SELECT studentemailid FROM student where schoolid=\"14\" )  group by studentbirthplace
        union all
        SELECT  studentfatherbirthplace as x ,count(*)  from `studentbirthdetails`  where studentemailid IN(SELECT studentemailid FROM student where schoolid=\"14\") group by studentfatherbirthplace
        union ALL
        SELECT  studentmotherbirthplace as x,count(*)  from `studentbirthdetails`  where studentemailid IN(SELECT studentemailid FROM student where schoolid=\"14\" ) group by studentmotherbirthplace
        union ALL
        SELECT  studentfathersfatherbirthplace as x,count(*)  from `studentbirthdetails`  where studentemailid IN(SELECT studentemailid FROM student where schoolid=\"14\" ) group by studentfathersfatherbirthplace
        union ALL
        SELECT  studentfathersmotherbirthplace as x,count(*)  from `studentbirthdetails`  where studentemailid IN(SELECT studentemailid FROM student where schoolid=\"14\" ) group by studentfathersmotherbirthplace
        union ALL
        SELECT  studentmothersfatherbirthplace as x,count(*)  from `studentbirthdetails`  where studentemailid IN(SELECT studentemailid FROM student where schoolid=\"14\") group by studentmothersfatherbirthplace
        union ALL
        SELECT  studentmothersmotherbirthplace as x,count(*)  from `studentbirthdetails`  where studentemailid IN(SELECT studentemailid FROM student where schoolid=\"14\" ) group by studentmothersmotherbirthplace) as t1","count(DISTINCT x) as count", "");
        if (count($data[0]) != 0) {
            return $data;
        } else {
            return false;
        }
    }

    private static function born_country ($schoolid , $classname){
        //SELECT b.allStudent, count(b.studentCountry) as numberStudentCountry, (100*count(b.studentCountry))/allStudent as percentStudent, sum(b.father+b.mother)/2 as parents, (100*(sum(b.father+b.mother)/2)/allStudent) as percentParents, sum(b.grandfather1+b.grandmother1+b.grandfather2+b.grandmother2)/4  as gparents, (100*(sum(b.grandfather1+b.grandmother1+b.grandfather2+b.grandmother2)/4)/(allStudent)) as percentGParents  FROM bornSchool b where (b.schoolid = 14)
        $data = data::selects_col("`bornSchool` b","b.allStudent, count(b.studentCountry) as numberStudentCountry, (100*count(b.studentCountry))/allStudent as percent, sum(b.father+b.mother)/2 as parents, (100*(sum(b.father+b.mother)/2)/allStudent) as percentParents, sum(b.grandfather1+b.grandmother1+b.grandfather2+b.grandmother2)/4  as gparents, (100*(sum(b.grandfather1+b.grandmother1+b.grandfather2+b.grandmother2)/4)/(allStudent)) as percentGParents", "b.schoolid= '$schoolid'");
        if (count($data[0]) != 0) {
            return $data;
        } else {
            return false;
        }
    }
    private static function cultures_country_influence ($schoolid , $classname){
        //SELECT n.studentbirthplace as country, (n.numberPeopleCountry*100)/n.numberStudent as percent, n.classname, n.schoolid FROM `numberStudentCountry` n where (n.schoolid = 14) order by n.schoolid, n.classname, n.numberPeopleCountry DESC LIMIT 3
        $data = data::selects_col("`numberStudentCountry` n","n.studentbirthplace as country, (n.numberPeopleCountry*100)/n.numberStudent as percent, n.classname, n.schoolid", "n.schoolid= '$schoolid' order by n.schoolid, n.classname, n.numberPeopleCountry DESC LIMIT 3");
        if (count($data[0]) != 0) {
            return $data;
        } else {
            return false;
        }
    }
    private static function born_overseas ($schoolid , $classname){
        //SELECT COUNT( languagename ) FROM studentlanguage where studentemailid IN(SELECT studentemailid FROM student where schoolid='14')
        $data = data::selects_col("`studentlanguage`","COUNT( languagename ) as count", "studentemailid IN (SELECT studentemailid FROM student where schoolid= '$schoolid')");
        if (count($data[0]) != 0) {
            return $data;
        } else {
            return false;
        }
    }
    private static function count_Languages ($schoolid , $classname){
        //SELECT languagename ,count(*) as count FROM `studentlanguage` where studentemailid IN(SELECT studentemailid FROM student where schoolid="14") group by languagename order by COUNT(*) desc LIMIT 3
        $data = data::selects_col("`studentlanguage`","languagename ,count(*) as count", "studentemailid IN (SELECT studentemailid FROM student where schoolid= '$schoolid') group by languagename order by COUNT(*) desc LIMIT 3");
        if (count($data[0]) != 0) {
            return $data;
        } else {
            return false;
        }
    }
    private static function Highest_number ($schoolid , $classname){
        //SELECT studentemailid as s, count(*) FROM studentlanguage where studentemailid IN(SELECT studentemailid FROM student where schoolid="14" ) group by studentemailid order by count(*) DESC LIMIT 1
        $data = data::selects_col("`studentlanguage`","studentemailid as s, count(*) as count", "studentemailid IN(SELECT studentemailid FROM student where schoolid= '$schoolid' ) group by studentemailid order by count(*) DESC LIMIT 1");
        if (count($data[0]) != 0) {
            return $data;
        } else {
            return false;
        }
    }
    private static function male_female_know_language ($schoolid , $classname){
        //SELECT MAX(numberLanguagesKnown/genderNumber) as averageLanguage FROM `numberLanguageGenderSchool` where schoolid = 14 and gender = 'female'
        //SELECT MAX(numberLanguagesKnown/genderNumber) as averageLanguage FROM `numberLanguageGenderSchool` where schoolid = 14 and gender = 'male'
        $data[0] = data::selects_col("`numberLanguageGenderSchool`","MAX(numberLanguagesKnown/genderNumber) as averageLanguage", "schoolid= '$schoolid' and gender = 'female'");
        $data[1] = data::selects_col("`numberLanguageGenderSchool`","MAX(numberLanguagesKnown/genderNumber) as averageLanguage", "schoolid= '$schoolid' and gender = 'male'");
        if (count($data[0][0]) != 0) {
            return $data;
        } else {
            return false;
        }
    }

    ///end of class
}