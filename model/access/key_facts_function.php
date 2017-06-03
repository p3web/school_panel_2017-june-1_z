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
        $result = "In total , people in this $class can $understand  up to  ".$A[0]['count']." languages.";
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

        $result = "In total, people in this $class believe in ".$A[0]['count']." different faiths.";
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
        $result = "Most $spoken languages in this $class are: ".$A[0]['languagename']."(".$A[0]['count']."), ".$A[1]['languagename']."(".$A[1]['count'].") and ".$A[2]['languagename']."(".$A[2]['count'].")";

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
        $result = "Among the $staff , there is one person who can speak up to ".$A[0]['count']." languages.";
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
        $result = $A[0]['count']." $staff did not want to disclose their Beliefs.";
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
            default:
        }

        if (count($result[0]) != 0) {
            return $result;
        } else {
            return false;
        }



    }


}






