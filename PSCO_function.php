<?php
/**
 * Created by PhpStorm.
 * User: peymanvalikhanli
 * Date: 5/30/17 AD
 * Time: 22:25
 */

require_once 'PSCO_data.php';

class PSCO_func
{

    public static function languages($id ,$name , $deptname = false){
        //In Total , people in this class\team can speak\understand  up to  A languages

        if($deptname != false ){
            $class="team";
            $understand="speak";
            //SELECT count( DISTINCT languagename) FROM stafflanguage , staff  where orgid="1" AND teamname="CiTeam" AND deptname="Database"
            $A = data::selects_col("stafflanguage , staff","count( DISTINCT languagename) as count", "orgid='$id' AND teamname='$name' AND deptname='$deptname'");
            // $A = data::selects("`stafflanguage`","");

        }else{
            $class="class";
            $understand="understand";
            //SELECT count( DISTINCT languagename) FROM studentlanguage , student  where schoolid="14" AND classname="S1"
            $A = data::selects_col("studentlanguage , student" , "count( DISTINCT languagename) as count", "schoolid='$id' AND classname='$name'");
        }
        // print_r($A);
        $result = "In total, people in this $class can $understand  up to  ".$A[0]['count']." languages.";
        return $result ;
    }

    public static function different_faiths($id ,$name , $deptname = false){
        //   In total, people in this class\team believe in A different faiths
        if($deptname != false){
            $class="team";
            //SELECT count( DISTINCT religion) FROM staff where orgid="1" AND teamname="CiTeam" AND deptname="Database"
            // $A = data::selects_col("staff", "count( DISTINCT religion) as count",'orgid="'.$id.'" AND teamname="'.$name.'" AND deptname="'.$depname.'"');
            $A = data::selects_col("staff", "count( DISTINCT religion) as count","orgid='$id' AND teamname='$name' AND deptname='$deptname'");


        }else{
            $class="class";
            //SELECT count( DISTINCT religion) FROM student  where schoolid="14" AND classname="S1"
            $A = data::selects_col("student","count( DISTINCT religion) as count" , 'schoolid="'.$id.'" AND classname="'.$name.'"');
        }

        $result = "In total, people in this $class believe in ".$A[0]['count']." different beliefs.";
        return $result ;

    }
    public static function count_Languages($id ,$name , $deptname = false){
        //   Languages A, B and C are the most spoken\understood languages in this class\team
        if($deptname != false){
            $class="team";
            $spoken = "spoken";
            //SELECT languagename ,count(*) FROM `stafflanguage` where staffemailid IN(SELECT staffemailid FROM staff where orgid="1" AND teamname="CiTeam" AND deptname="Database") group by languagename order by COUNT(*) desc LIMIT 3
            $A = data::selects_col('`stafflanguage`','languagename ,count(*) as count', 'staffemailid IN(SELECT staffemailid FROM staff where orgid="'.$id.'" AND teamname="'.$name.'" AND deptname="'.$deptname.'") group by languagename order by COUNT(*) desc LIMIT 3');

        }else{
            $class="class";
            $spoken = "understood";
            //SELECT languagename ,count(*) FROM `studentlanguage` where studentemailid IN(SELECT studentemailid FROM student where schoolid="14" AND classname="S1") group by languagename order by COUNT(*) desc LIMIT 3
            $A = data::selects_col('`studentlanguage`','languagename ,count(*) as count' , 'studentemailid IN(SELECT studentemailid FROM student where schoolid="'.$id.'" AND classname="'.$name.'") group by languagename order by COUNT(*) desc LIMIT 3');
        }
        //print_r($A);
        //Most spoken languages in this team are : English(42 ), Spanish (9) and French(8)
        $result = "The most $spoken languages in this $class are: ".$A[0]['languagename']."(".$A[0]['count']."), ".$A[1]['languagename']."(".$A[1]['count'].") and ".$A[2]['languagename']."(".$A[2]['count'].")";

        return $result ;

    }

    public static function grandparents($id ,$name , $deptname = false){
        //  In total, people in this class\team are from A different countries, which includes country of birth of all(staff/student, mother, father, grandparents )
        if($deptname != false){
            $class="team";
            $staff = "staff";
            /*select count(DISTINCT x) from
            (
            SELECT staffbirthplace as x ,count(*)  from `staffbirthdetails` where staffemailid IN(SELECT staffemailid FROM staff where orgid="1" AND teamname="CiTeam" AND deptname="Database") group by staffbirthplace
            union all
            SELECT  stafffatherbirthplace as x ,count(*)  from `staffbirthdetails` where staffemailid IN(SELECT staffemailid FROM staff where orgid="1" AND teamname="CiTeam" AND deptname="Database") group by stafffatherbirthplace
            union ALL
            SELECT  staffmotherbirthplace as x,count(*)  from `staffbirthdetails` where staffemailid IN(SELECT staffemailid FROM staff where orgid="1" AND teamname="CiTeam" AND deptname="Database") group by staffmotherbirthplace
            union ALL
            SELECT  stafffathersfatherbirthplace as x,count(*)  from `staffbirthdetails` where staffemailid IN(SELECT staffemailid FROM staff where orgid="1" AND teamname="CiTeam" AND deptname="Database") group by stafffathersfatherbirthplace
            union ALL
            SELECT  stafffathersmotherbirthplace as x,count(*)  from `staffbirthdetails` where staffemailid IN(SELECT staffemailid FROM staff where orgid="1" AND teamname="CiTeam" AND deptname="Database") group by stafffathersmotherbirthplace
            union ALL
            SELECT  staffmothersfatherbirthplace as x,count(*)  from `staffbirthdetails` where staffemailid IN(SELECT staffemailid FROM staff where orgid="1" AND teamname="CiTeam" AND deptname="Database") group by staffmothersfatherbirthplace
            union ALL
            SELECT  staffmothersmotherbirthplace as x,count(*)  from `staffbirthdetails` where staffemailid IN(SELECT staffemailid FROM staff where orgid="1" AND teamname="CiTeam" AND deptname="Database") group by staffmothersmotherbirthplace)as t1
            */
            $A = data::selects_col('(SELECT staffbirthplace as x ,count(*)  from `staffbirthdetails` where staffemailid IN(SELECT staffemailid FROM staff where orgid="'.$id.'" AND teamname="'.$name.'" AND deptname="'.$deptname.'") group by staffbirthplace union all SELECT  stafffatherbirthplace as x ,count(*)  from `staffbirthdetails` where staffemailid IN(SELECT staffemailid FROM staff where orgid="'.$id.'" AND teamname="'.$name.'" AND deptname="'.$deptname.'") group by stafffatherbirthplace union ALL SELECT  staffmotherbirthplace as x,count(*)  from `staffbirthdetails` where staffemailid IN(SELECT staffemailid FROM staff where orgid="'.$id.'" AND teamname="'.$name.'" AND deptname="'.$deptname.'") group by staffmotherbirthplace union ALL SELECT  stafffathersfatherbirthplace as x,count(*)  from `staffbirthdetails` where staffemailid IN(SELECT staffemailid FROM staff where orgid="'.$id.'" AND teamname="'.$name.'" AND deptname="'.$deptname.'") group by stafffathersfatherbirthplace union ALL SELECT  stafffathersmotherbirthplace as x,count(*)  from `staffbirthdetails` where staffemailid IN(SELECT staffemailid FROM staff where orgid="'.$id.'" AND teamname="'.$name.'" AND deptname="'.$deptname.'") group by stafffathersmotherbirthplace union ALL SELECT  staffmothersfatherbirthplace as x,count(*)  from `staffbirthdetails` where staffemailid IN(SELECT staffemailid FROM staff where orgid="'.$id.'" AND teamname="'.$name.'" AND deptname="'.$deptname.'") group by staffmothersfatherbirthplace union ALL SELECT  staffmothersmotherbirthplace as x,count(*)  from `staffbirthdetails` where staffemailid IN(SELECT staffemailid FROM staff where orgid="'.$id.'" AND teamname="'.$name.'" AND deptname="'.$deptname.'") group by staffmothersmotherbirthplace)as t1','count(DISTINCT x) as count',"");

        }else{
            $class="class";
            $staff = "student";
            /*
            select count(DISTINCT x) from
            (
               SELECT studentbirthplace as x ,count(*)  from `studentbirthdetails`  where studentemailid IN(SELECT studentemailid FROM student where schoolid="14" AND classname="S1")  group by studentbirthplace
            union all
            SELECT  studentfatherbirthplace as x ,count(*)  from `studentbirthdetails`  where studentemailid IN(SELECT studentemailid FROM student where schoolid="14" AND classname="S1") group by studentfatherbirthplace
            union ALL
            SELECT  studentmotherbirthplace as x,count(*)  from `studentbirthdetails`  where studentemailid IN(SELECT studentemailid FROM student where schoolid="14" AND classname="S1") group by studentmotherbirthplace
            union ALL
            SELECT  studentfathersfatherbirthplace as x,count(*)  from `studentbirthdetails`  where studentemailid IN(SELECT studentemailid FROM student where schoolid="14" AND classname="S1") group by studentfathersfatherbirthplace
            union ALL
            SELECT  studentfathersmotherbirthplace as x,count(*)  from `studentbirthdetails`  where studentemailid IN(SELECT studentemailid FROM student where schoolid="14" AND classname="S1") group by studentfathersmotherbirthplace
            union ALL
            SELECT  studentmothersfatherbirthplace as x,count(*)  from `studentbirthdetails`  where studentemailid IN(SELECT studentemailid FROM student where schoolid="14" AND classname="S1") group by studentmothersfatherbirthplace
            union ALL
            SELECT  studentmothersmotherbirthplace as x,count(*)  from `studentbirthdetails`  where studentemailid IN(SELECT studentemailid FROM student where schoolid="14" AND classname="S1") group by studentmothersmotherbirthplace)as t1
            */

            $A = data::selects_col('(SELECT studentbirthplace as x ,count(*)  from `studentbirthdetails`  where studentemailid IN(SELECT studentemailid FROM student where schoolid="'.$id.'" AND classname="'.$name.'")  group by studentbirthplace union all SELECT  studentfatherbirthplace as x ,count(*)  from `studentbirthdetails`  where studentemailid IN(SELECT studentemailid FROM student where schoolid="'.$id.'" AND classname="'.$name.'") group by studentfatherbirthplace union ALL SELECT  studentmotherbirthplace as x,count(*)  from `studentbirthdetails`  where studentemailid IN(SELECT studentemailid FROM student where schoolid="'.$id.'" AND classname="'.$name.'") group by studentmotherbirthplace union ALL SELECT  studentfathersfatherbirthplace as x,count(*)  from `studentbirthdetails`  where studentemailid IN(SELECT studentemailid FROM student where schoolid="'.$id.'" AND classname="'.$name.'") group by studentfathersfatherbirthplace union ALL SELECT  studentfathersmotherbirthplace as x,count(*)  from `studentbirthdetails`  where studentemailid IN(SELECT studentemailid FROM student where schoolid="'.$id.'" AND classname="'.$name.'") group by studentfathersmotherbirthplace union ALL SELECT  studentmothersfatherbirthplace as x,count(*)  from `studentbirthdetails`  where studentemailid IN(SELECT studentemailid FROM student where schoolid="'.$id.'" AND classname="'.$name.'") group by studentmothersfatherbirthplace union ALL SELECT  studentmothersmotherbirthplace as x,count(*)  from `studentbirthdetails`  where studentemailid IN(SELECT studentemailid FROM student where schoolid="'.$id.'" AND classname="'.$name.'") group by studentmothersmotherbirthplace)as t1','count(DISTINCT x) as count','');
        }
        //In total, people in this team are from 30 different countries. (Including staff, their parents and grandparents)
        $result = "In total, people in this $class are from ".$A[0]['count']." different countries. (including $staff, their parents and grandparents )";
        return $result ;

    }
    public static function Highest_number($id ,$name , $deptname = false){
        //   Highest number of language count spoken by a particular staff or student.
        if($deptname != false){
            $class="team";
            $staff = "staff";
            //SELECT staffemailid as s, count(*) FROM stafflanguage where staffemailid IN(SELECT staffemailid FROM staff where orgid="1" AND teamname="CiTeam" AND deptname="Database") group by staffemailid order by count(*) DESC LIMIT 1
            $A = data::selects_col('stafflanguage','staffemailid as s, count(*) as count','staffemailid IN(SELECT staffemailid FROM staff where orgid="'.$id.'" AND teamname="'.$name.'" AND deptname="'.$deptname.'") group by staffemailid order by count(*) DESC LIMIT 1');

        }else{
            $class="class";
            $staff = "student";
            //SELECT studentemailid as s, count(*) FROM studentlanguage where studentemailid IN(SELECT studentemailid FROM student where schoolid="14" AND classname="S1") group by studentemailid order by count(*) DESC LIMIT 1
            $A = data::selects_col('studentlanguage','studentemailid as s, count(*) as count','studentemailid IN(SELECT studentemailid FROM student where schoolid="'.$id.'" AND classname="'.$name.'") group by studentemailid order by count(*) DESC LIMIT 1');

        }
        //There is one staff who can speak up to 5 languages.
        $result = "Among the $staff , there is one person who can speak ".$A[0]['count']." languages.";
        return $result ;

    }
    public static function How_many_number ($id ,$name , $deptname = false){
        //  How many number  of students/staff are not willing to revile their belief.
        if($deptname != false){
            $class="team";
            $staff = "staff";
            //SELECT count(*) FROM `staff`  where staffemailid IN(SELECT staffemailid FROM staff where orgid="1" AND teamname="CiTeam" AND deptname="Database") and religion='no religion'
            $A= data::selects_col('`staff` ','count(*) as count','staffemailid IN(SELECT staffemailid FROM staff where orgid="'.$id.'" AND teamname="'.$name.'" AND deptname="'.$deptname.'") and religion="no religion"');

        }else{
            $class="class";
            $staff = "student";
            //SELECT count(*) FROM `student`  where studentemailid IN(SELECT studentemailid FROM student where schoolid="14" AND classname="S1") and religion='no religion'
            $A = data::selects_col('`student`','count(*) as count','studentemailid IN(SELECT studentemailid FROM student where schoolid="'.$id.'" AND classname="'.$name.'") and religion="no religion"');

        }
        //9 people did not want to disclosure their believes.
        $result = $A[0]['count']." $staff did not want to disclose their beliefs.";
        return $result ;

    }
	public static function born_country ($id ,$name , $deptname = false){
        //  %A of people are born in (First country - 'Australia' ), while %B of their parents are born in (First country) but only %C of Grand Parents are  born here ( First Country )
        if($deptname != false){
            $class="team";
            $staff = "staff";
			//SELECT allStaff, count(born.staffCountry) as numberStaffCountry, (100*count(born.staffCountry))/allstaff as percentStaff, sum(born.father+born.mother)/2 as parents, (100*(sum(born.father+born.mother)/2)/allstaff) as percentParents, sum(born.grandfather1+born.grandmother1+born.grandfather2+born.grandmother2)/4 as gparents, (100*(sum(born.grandfather1+born.grandmother1+born.grandfather2+born.grandmother2)/4)/(allStaff)) as percentGParents FROM born where (orgid = 1) and deptname = 'Database' and teamname = 'CITeam'
            $A= data::selects_col('`born` ','allStaff , staffCountry ,  count(born.staffCountry) as numberStaffCountry, (100*count(born.staffCountry))/allstaff as percentStaff, sum(born.father+born.mother)/2 as parents, (100*(sum(born.father+born.mother)/2)/allstaff) as percentParents, sum(born.grandfather1+born.grandmother1+born.grandfather2+born.grandmother2)/4 as gparents, (100*(sum(born.grandfather1+born.grandmother1+born.grandfather2+born.grandmother2)/4)/(allStaff)) as percentGParents', 'orgid="'.$id.'" AND teamname="'.$name.'" AND deptname="'.$deptname.'"');
		//4.19 % of staff are born in "First Country"
        //Only 14.51 % of staff have both parents born in "First country 
        //12.09 % of staff in this community are from "First Country" for the last two generations ( All parents and grandparents are born in "first country "  )
       $result[0] = number_format($A[0]['percentStaff'], 2, '.', ',' )."%"." of $staff are born in ".$A[0]['staffCountry'].".";
       $result[1] = "Only ".number_format($A[0]['percentParents'], 0, '.', ',' )."%"." of $staff have both parents born in  ".$A[0]['staffCountry'].".";
       $result[2] = number_format($A[0]['percentGParents'], 2, '.', ',' )."%"." of $staff in this community are from ".$A[0]['staffCountry']." for the last two generations ( All parents and grandparents are born in ".$A[0]['staffCountry'].").";

        }else{
            $class="class";
            $staff = "student";
            //SELECT b.allStudent, count(b.studentCountry) as numberStudentCountry, (100*count(b.studentCountry))/allStudent as percentStudent, sum(b.father+b.mother)/2 as parents, (100*(sum(b.father+b.mother)/2)/allStudent) as percentParents, sum(b.grandfather1+b.grandmother1+b.grandfather2+b.grandmother2)/4  as gparents, (100*(sum(b.grandfather1+b.grandmother1+b.grandfather2+b.grandmother2)/4)/(allStudent)) as percentGParents  FROM bornSchool b where (b.schoolid = 14) and b.classname = 'S2'
			$A= data::selects_col('`bornSchool` b','b.allStudent, studentCountry, count(b.studentCountry) as numberStudentCountry, (100*count(b.studentCountry))/allStudent as percentStudent, sum(b.father+b.mother)/2 as parents, (100*(sum(b.father+b.mother)/2)/allStudent) as percentParents, sum(b.grandfather1+b.grandmother1+b.grandfather2+b.grandmother2)/4  as gparents, (100*(sum(b.grandfather1+b.grandmother1+b.grandfather2+b.grandmother2)/4)/(allStudent)) as percentGParents', 'schoolid="'.$id.'" AND classname="'.$name.'"');
		//4.19 % of student are born in "First Country"
        //Only 14.51 % of staff have both parents born in "First country 
        //12.09 % of staff in this community are from "First Country" for the last two generations ( All parents and grandparents are born in "first country "  )
		$result[0]= number_format($A[0]['percentStudent'], 2, '.', ',' )."%"." of $staff are born in ".$A[0]['studentCountry'].".";
		$result[1]= "Only ".number_format($A[0]['percentParents'], 0, '.', ',' )."%"." of $staff have both parents born in  ".$A[0]['studentCountry'].".";
		$result[2]= number_format($A[0]['percentGParents'], 2, '.', ',' )."%"." of $staff in this community are from ".$A[0]['staffCountry']." for the last two generations ( All parents and grandparents are born in ".$A[0]['studentCountry'].").";
       
        }
        return $result ;

    }
	public static function male_female_know_language ($id ,$name , $deptname = false){
        //  As an average female staff\students understand A languages while male staff\students know B number of languages
		
        if($deptname != false){
            $class="team";
            $staff = "staff";
            //SELECT (numberLanguagesKnown/genderNumber) as averageLanguage FROM `numberLanguageGender` where team = 'CITeam' and orgid = 1 and deptname = 'Database' and gender = 'female'
			// SELECT (numberLanguagesKnown/genderNumber) as averageLanguage FROM `numberLanguageGender` where team = 'CITeam' and orgid = 1 and deptname = 'Database' and gender = 'male'
            $A= data::selects_col('`numberLanguageGender` ','(numberLanguagesKnown/genderNumber) as averageLanguage', 'orgid="'.$id.'" AND team="'.$name.'" AND deptname="'.$deptname.'" AND gender ="female"');
            $B= data::selects_col('`numberLanguageGender` ','(numberLanguagesKnown/genderNumber) as averageLanguage', 'orgid="'.$id.'" AND team="'.$name.'" AND deptname="'.$deptname.'" AND gender ="male"');

        }else{
            $class="class";
            $staff = "student";
            //SELECT (numberLanguagesKnown/genderNumber) as averageLanguage FROM `numberLanguageGenderSchool` where class = 's2' and schoolid = 14 and gender = 'female'
                                                                                   
			//SELECT numberLanguagesKnown FROM `numberLanguageGenderSchool` where class = 's1' and schoolid = 14 and gender = 'male'

			$A= data::selects_col('`numberLanguageGenderSchool` ','(numberLanguagesKnown/genderNumber) as averageLanguage', 'schoolid="'.$id.'" AND classname="'.$name.'" AND gender ="female"');
            $B= data::selects_col('`numberLanguageGenderSchool` ','(numberLanguagesKnown/genderNumber) as averageLanguage', 'schoolid="'.$id.'" AND classname="'.$name.'" AND gender ="male"');

        }
        //As an average female staff\students understand A languages while male staff\students know B number of languages
        $result = "As an average female $staff understand ". number_format($A[0]['averageLanguage'], 2, '.', ',' )." languages while male $staff know ".number_format($B[0]['averageLanguage'], 2, '.', ',' )." number of languages";
        return $result ;

    }
	
	public static function cultures_country_influence ($id ,$name , $deptname = false){
        //  Cultures from countries A, B and C have the most influence in this team\class
		
        if($deptname != false){
            $class="team";
            $staff = "staff";
            //SELECT n.staffbirthplace as country, (n.numberPeopleCountry*100)/n.numberStaff as percent, n.teamname, n.deptname, n.orgid FROM `numberStaffCountry` n where (n.teamname = 'CITeam') and(n.orgid = 1) and (n.deptname = 'Database') order by n.orgid, n.teamname, n.numberPeopleCountry DESC LIMIT 3
            $A= data::selects_col('`numberStaffCountry` ','staffbirthplace as country,(numberPeopleCountry*100)/numberStaff as percent,teamname, deptname, orgid', 'orgid="'.$id.'" AND teamname="'.$name.'" AND deptname="'.$deptname.'" order by orgid, teamname, numberPeopleCountry DESC LIMIT 3');
            
        }else{
            $class="class";
            $staff = "student";
            //   SELECT n.studentbirthplace as country, (n.numberPeopleCountry*100)/n.numberStudent as percent, n.classname, n.schoolid FROM `numberStudentCountry` n where (n.classname = 's1') and(n.schoolid = 14) order by n.schoolid, n.classname, n.numberPeopleCountry DESC LIMIT 3
			$A= data::selects_col('`numberStudentCountry` ','studentbirthplace as country,(numberPeopleCountry*100)/numberStudent as percent, classname, schoolid', 'schoolid="'.$id.'" AND classname="'.$name.'" order by schoolid, classname, numberPeopleCountry DESC LIMIT 3');

        }
        //Cultures from countries A, B and C have the most influence in this team\class
        $result = "Cultures from countries ".$A[0]['country'].", ".$A[1]['country']." and ".$A[2]['country']." have the most influence on the $staff .";
        return $result ;

    }
	public static function num_of_language_spoken ($id ,$name , $deptname = false){
        //		%A of people in this class\team ( B people ) can speak only one language
		//		%A of people in this class\team ( B people ) can speak two or more languages
		//		%A of people in this class\team ( B people ) can speak three or more languages

		
        if($deptname != false){
            $class="team";
            $staff = "staff";
			//SELECT count(numberL) numberStaff, (count(numberL)*100)/allStaff as percent FROM `viewLanguageTeam` WHERE teamname = 'CITeam' and orgid = '1' and deptname = 'Database' and numberL = 1
			//speak >=2 Team: 
			//SELECT count(numberL) numberStaff, (count(numberL)*100)/allStaff as percent FROM `viewLanguageTeam` WHERE teamname = 'CITeam' and orgid = '1' and deptname = 'Database' and numberL >= 2
			//speak >=3 Team: 
			//SELECT count(numberL) numberStaff, (count(numberL)*100)/allStaff as percent FROM `viewLanguageTeam` WHERE teamname = 'CITeam' and orgid = '1' and deptname = 'Database' and numberL >= 3
            $A= data::selects_col('`viewLanguageTeam` ','count(numberL) number,(count(numberL)*100)/allStaff as percent', 'orgid="'.$id.'" AND teamname="'.$name.'" AND deptname="'.$deptname.'" and numberL = 1');
            $B= data::selects_col('`viewLanguageTeam` ','count(numberL) number,(count(numberL)*100)/allStaff as percent', 'orgid="'.$id.'" AND teamname="'.$name.'" AND deptname="'.$deptname.'" and numberL >= 2');
            $C= data::selects_col('`viewLanguageTeam` ','count(numberL) number,(count(numberL)*100)/allStaff as percent', 'orgid="'.$id.'" AND teamname="'.$name.'" AND deptname="'.$deptname.'" and numberL >= 3');
            
        }else{
            $class="class";
            $staff = "student";
            //SELECT count(numberL) numberStudents, (count(numberL)*100)/allStudents as percent FROM `viewLanguageSchool` WHERE class = 'S1' and school = '14' and numberL = 1 
			//speak >=2 School:
			//SELECT count(numberL) numberStudents, (count(numberL)*100)/allStudents as percent FROM `viewLanguageSchool` WHERE class = 'S1' and school = '14' and numberL >= 2
			//speak >=3 school:
			//SELECT count(numberL) numberStudents, (count(numberL)*100)/allStudents as percent FROM `viewLanguageSchool` WHERE class = 'S1' and school = '14' and numberL >= 3
			$A= data::selects_col('`viewLanguageSchool` ','count(numberL) number,(count(numberL)*100)/allStudents as percent', 'school="'.$id.'" AND class="'.$name.'" and numberL = 1');
			$B= data::selects_col('`viewLanguageSchool` ','count(numberL) number,(count(numberL)*100)/allStudents as percent', 'school="'.$id.'" AND class="'.$name.'" and numberL >= 2');
			$C= data::selects_col('`viewLanguageSchool` ','count(numberL) number,(count(numberL)*100)/allStudents as percent', 'school="'.$id.'" AND class="'.$name.'" and numberL >= 3');

        }
        //		%A of people in this class\team ( B people ) can speak only one language
		//		%A of people in this class\team ( B people ) can speak two or more languages
		//		%A of people in this class\team ( B people ) can speak three or more languages
        $result[0] = number_format($A[0]['percent'], 2, '.', ',' )." % of people in this $class ( ".$A[0]['number']." people ) can speak only one language.";
        $result[1] = number_format($B[0]['percent'], 2, '.', ',' )."  % of people in this $class ( ".$B[0]['number']." people ) can speak two or more languages.";
        $result[2] = number_format($C[0]['percent'], 2, '.', ',' )." % of people in this $class ( ".$C[0]['number']." people ) can speak three or more languages.";
		
        return $result ;

    }
	
	public static function parent_born_overseas ($id ,$name , $deptname = false){
        //		A% have at least one parent born overseas

		
        if($deptname != false){
            $class="team";
            $staff = "staff";
			//SELECT count(b.staffemailid) as numberStaffAnotherCountry, (count(b.staffemailid)*100)/b.allstaff as percent FROM `bornGrandParentsInAnotherCountryStaff` b where b.orgid = 1 and b.deptname = 'Database' and b.teamname = 'CITeam'

            $A= data::selects_col('`bornGrandParentsInAnotherCountryStaff` b','count(b.staffemailid) as numberStaffAnotherCountry, (count(b.staffemailid)*100)/b.allstaff as percent', 'orgid="'.$id.'" AND teamname="'.$name.'" AND deptname="'.$deptname.'"');
			
        }else{
            $class="class";
            $staff = "student";
            //SELECT count(b.staffemailid) as numberStaffAnotherCountry, (count(b.staffemailid)*100)/b.allstaff as percent FROM `bornGrandParentsInAnotherCountryStaff` b where b.orgid = 1 and b.deptname = 'Database' and b.teamname = 'CITeam'

            //$A= data::selects_col('`bornGrandParentsInAnotherCountryStaff`','count(b.staffemailid) as numberStaffAnotherCountry, (count(b.staffemailid)*100)/b.allstaff as percent', 'orgid="'.$id.'" AND teamname="'.$name.'" AND deptname="'.$deptname.'"');
			
        }
        //		A% have at least one parent born overseas
        $result = number_format($A[0]['percent'], 2, '.', ',' )." % have at least one parent born overseas.";
        return $result ;

    }
	public static function gparent_born_overseas ($id ,$name , $deptname = false){
        //		A% have at least one Grandparent born overseas
 

		
        if($deptname != false){
            $class="team";
            $staff = "staff";
			//SELECT count(b.staffemailid) as numberStaffAnotherCountry, (count(b.staffemailid)*100)/b.allstaff as percent FROM `bornParentsInAnotherCountryStaff` b where b.orgid = 1 and b.deptname = 'Database' and b.teamname = 'CITeam'


            $A= data::selects_col('`bornParentsInAnotherCountryStaff` b','count(b.staffemailid) as numberStaffAnotherCountry, (count(b.staffemailid)*100)/b.allstaff as percent', 'orgid="'.$id.'" AND teamname="'.$name.'" AND deptname="'.$deptname.'"');
			
        }else{
            $class="class";
            $staff = "student";
            //SELECT count(b.staffemailid) as numberStaffAnotherCountry, (count(b.staffemailid)*100)/b.allstaff as percent FROM `bornParentsInAnotherCountryStaff` b where b.orgid = 1 and b.deptname = 'Database' and b.teamname = 'CITeam'


            //$A= data::selects_col('`bornParentsInAnotherCountryStaff` b','count(b.staffemailid) as numberStaffAnotherCountry, (count(b.staffemailid)*100)/b.allstaff as percent', 'orgid="'.$id.'" AND teamname="'.$name.'" AND deptname="'.$deptname.'"');
			
        }
        //		A% have at least one Grandparent born overseas
        $result = number_format($A[0]['percent'], 2, '.', ',' )." % have at least one Grandparent born overseas.";
        return $result ;

    }
	public static function invitation_status ($id ,$name , $deptname = false){
        //		There are A staff in the team, of which B are still awaiting to accept the invitation
		
        if($deptname != false){
            $class="team";
            $staff = "staff";
			//A - SELECT count( DISTINCT staffemailid) FROM staff   where orgid="1" AND teamname="CiTeam"
			//B - SELECT count( DISTINCT staffemailid) FROM staff   where orgid="1" AND teamname="CiTeam" AND status="pending"

            $A= data::selects_col('`staff`','count( DISTINCT staffemailid) as statusNumber', 'orgid="'.$id.'" AND teamname="'.$name.'"');
            $B= data::selects_col('`staff`','count( DISTINCT staffemailid) as statusNumber', 'orgid="'.$id.'" AND teamname="'.$name.'" AND status="pending"');
            
            
        }else{
            $class="class";
            $staff = "student";
            //C- SELECT count( DISTINCT studentemailid) FROM student   where schoolid="14" AND classname="S1"
			//D- SELECT count( DISTINCT studentemailid) FROM student   where schoolid="14" AND classname="S1" AND status="pending"

			$A= data::selects_col('`student`','count( DISTINCT studentemailid) as statusNumber', 'school="'.$id.'" AND class="'.$name.'"');
			$B= data::selects_col('`student`','count( DISTINCT studentemailid) as statusNumber', 'school="'.$id.'" AND class="'.$name.'" AND status="pending"');

        }
        //		There are A staff in the team, of which B are still awaiting to accept the invitation
        $result = "There are ".$A[0]['statusNumber']." $staff in the $class, of which ".$B[0]['statusNumber']." are still awaiting to accept the invitation.";
		
        return $result ;

    }
	public static function top_migrant ($id ,$name , $deptname = false){
        //		Top Migrants to Australia are from United Kingdom, New Zealand, China
		
        if($deptname != false){
            $class="team";
            $staff = "staff";
        }else{
            $class="class";
            $staff = "student";
        }
        $result = "Top Migrants to Australia are from United Kingdom, New Zealand, China.";
        return $result ;

    }
	
    public static function get_lang_count_all_male_fmale ($orgId ,$teamName , $deptName , $mode = 'a'){
        //  How many number  of students/staff are not willing to revile their belief.

        switch($mode){
            case 'a':
                //"SELECT  FROM stafflanguage where staffemailid IN(SELECT staffemailid FROM staff where orgid='".$orgId."' AND teamname='".$teamName."' AND deptname='".$deptName."') GROUP BY languagename ORDER BY COUNT( languagename ) DESC"
                $result= data::selects_col('`stafflanguage` ','languagename, COUNT( languagename ) as count',"staffemailid IN(SELECT staffemailid FROM staff where orgid='".$orgId."' AND teamname='".$teamName."' AND deptname='".$deptName."') GROUP BY languagename ORDER BY COUNT( languagename ) DESC");
                break;
            case 'm':
                $gen="male";
                $result= data::selects_col('`stafflanguage` ','languagename, COUNT( languagename ) as count',"staffemailid IN(SELECT staffemailid FROM staff where orgid='".$orgId."' AND teamname='".$teamName."' AND deptname='".$deptName."' AND gender='".$gen."') GROUP BY languagename ORDER BY COUNT( languagename ) DESC");
                break;
            case 'f':
                $gen="female";
                //SELECT languagename, COUNT( languagename ) FROM stafflanguage where staffemailid IN(SELECT staffemailid FROM staff where orgid='1' AND teamname='CITeam' AND deptname='Database' AND gender='others') GROUP BY languagename ORDER BY COUNT( languagename ) DESC
                //"SELECT languagename, COUNT( languagename ) FROM stafflanguage where staffemailid IN(SELECT staffemailid FROM staff where orgid='".$orgId."' AND teamname='".$teamName."' AND deptname='".$deptName."' AND gender='".$gen."') GROUP BY languagename ORDER BY COUNT( languagename ) DESC"
                $result= data::selects_col('`stafflanguage` ','languagename, COUNT( languagename ) as count',"staffemailid IN(SELECT staffemailid FROM staff where orgid='".$orgId."' AND teamname='".$teamName."' AND deptname='".$deptName."' AND gender='".$gen."') GROUP BY languagename ORDER BY COUNT( languagename ) DESC");
                break;
        }

        if (count($result[0]) != 0) {
            return $result;
        } else {
            return false;
        }

    }
}







//1.	A% have at least one parent born overseas