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

    public static function get_student_parameter($aDoor,$schoolId,$className){


        $unionAllOption = 0;
        //starting query
        $querytest ="";


        if (!empty($_REQUEST['formDoor'])){
            $querytest .= "select x , COUNT( * )  from(";

            $N = count($aDoor);
            for($i=0; $i < $N; $i++){
                if($aDoor[$i] == 'S'){
                    $querytest .= " select `studentbirthplace` as x from studentbirthdetails where studentemailid IN(SELECT studentemailid FROM student where schoolid='".$schoolId."'  AND classname='".$className."')";
                    $unionAllOption = 1;
                }
                if($aDoor[$i] == 'F'){
                    if($unionAllOption==1){$querytest .= " UNION ALL";}
                    $querytest .= " select `studentfatherbirthplace` as x from studentbirthdetails  where studentemailid IN(SELECT studentemailid FROM student where schoolid='".$schoolId."'  AND classname='".$className."')";
                    $unionAllOption = 1;
                }
                if($aDoor[$i] == 'M'){
                    if($unionAllOption==1){$querytest .= " UNION ALL";}
                    $querytest .= " select `studentmotherbirthplace` as x from studentbirthdetails  where studentemailid IN(SELECT studentemailid FROM student where schoolid='".$schoolId."'  AND classname='".$className."')";
                    $unionAllOption = 1;
                }
                if($aDoor[$i] == 'GFFS'){
                    if($unionAllOption==1){$querytest .= " UNION ALL";}
                    $querytest .= " select `studentfathersfatherbirthplace` as x from studentbirthdetails  where studentemailid IN(SELECT studentemailid FROM student where schoolid='".$schoolId."'  AND classname='".$className."')";
                    $unionAllOption = 1;
                }
                if($aDoor[$i] == 'GMFS'){
                    if($unionAllOption==1){$querytest .= " UNION ALL";}
                    $querytest .= " select `studentfathersmotherbirthplace` as x from studentbirthdetails  where studentemailid IN(SELECT studentemailid FROM student where schoolid='".$schoolId."'  AND classname='".$className."')";
                    $unionAllOption = 1;
                }
                if($aDoor[$i] == 'GFMS'){
                    if($unionAllOption==1){$querytest .= " UNION ALL";}
                    $querytest .= " select `studentmothersfatherbirthplace` as x from studentbirthdetails  where studentemailid IN(SELECT studentemailid FROM student where schoolid='".$schoolId."'  AND classname='".$className."')";
                    $unionAllOption = 1;
                }
                if($aDoor[$i] == 'GMMS'){
                    if($unionAllOption==1){$querytest .= " UNION ALL";}
                    $querytest .= " select `studentmothersmotherbirthplace` as x from studentbirthdetails  where studentemailid IN(SELECT studentemailid FROM student where schoolid='".$schoolId."'  AND classname='".$className."')";
                    $unionAllOption = 1;
                }
            }

            $querytest .= " ) as temptable group by x";
        }

        // Default values goes here
        if($querytest==""){

            $querytest = "select x , COUNT( * )  from( select `studentbirthplace` as x from studentbirthdetails where studentemailid IN(SELECT studentemailid FROM student where schoolid='".$schoolId."'  AND classname='".$className."') ) as temptable group by x";
        }

        $result = data::run_query($querytest);

        if (count($result[0]) != 0) {
            return $result;
        } else {
            return false;
        }

    }


}