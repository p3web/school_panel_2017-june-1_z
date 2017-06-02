<?php
/**
 * Created by PhpStorm.
 * User: peymanvalikhanli
 * Date: 6/2/17 AD
 * Time: 11:09
 */

class control_teacherpanel
{

    public static $adminName;
    public static $schoolId;
    public static $adminid;
    public static $schoolName;
    public static $city;
    public static $suburb;
    public static $className;


    public static function init()
    {

        $adminid = $_SESSION['emailid'];


        //______________ init admin name & school id

        $result = access_teacherpanel::get_teacher_by_teacheremailid($adminid);
        self::$adminName = $result[0]["firstname"] . " " . $result[0]["lastname"];
        self::$schoolId = $result[0]["schoolid"];

        //______________ init   (schoolName & city & suburb)

        $result = access_teacherpanel::get_school_by_schoolid(self::$schoolId);
        self::$schoolName = $result[0]["schoolname"];
        self:: $city = $result[0]["city"];
        self::$suburb = $result[0]["suburb"];

        //______________init class details

        $result = access_teacherpanel::get_classteacher_by_schoolid_teacheremailid(self::$schoolId,self::$adminid);
        $className = $result[0]["classname"];

    }

    public static function generateRandomColor()
    {
        $randomcolor = '#' . strtoupper(dechex(rand(0, 10000000)));
        if (strlen($randomcolor) != 7) {
            $randomcolor = str_pad($randomcolor, 10, '0', STR_PAD_RIGHT);
            $randomcolor = substr($randomcolor, 0, 7);
        }
        return $randomcolor;

    }

    public static function get_data_chart_religion_count(){

        $className=self::$className;

        if (!empty($_REQUEST['classnamedropdownbeltab']))
        {
            $className= $_REQUEST['classnamedropdownbeltab'];
        }

        $result = access_teacherpanel::get_religion($className,self::$schoolId);
        $string_result = '[["Religion", "NumberOfStudent" ], ';
        for($index = 0 ; $index < count($result) ; $index++){
            $string_result .= "['".$result[$index]['religion']."',".$result[$index]['count']."],";

        }
        $string_result .= ']';

        csv_file::makecsv($result, "teacherreligonout.csv", false);

        return $string_result ;
    }

    public static function get_(){

    if (!empty($_REQUEST['classnamedropdown']))
    {
        $className= $_REQUEST['classnamedropdown'];
    }

    $unionAllOption = 0;
    //starting query
    $querytest ="";


    if (!empty($_REQUEST['formDoor'])){
        $querytest .= "select x , COUNT( * )  from(";
        $aDoor = $_REQUEST['formDoor'];
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

    $currentQuerry = $querytest;

    $result = mysql_query($currentQuerry);
    $result1 = mysql_query($currentQuerry);

    while($row = mysql_fetch_assoc($result)) {

        ?>
        ['<?php echo $row['x']; ?>',<?php echo $row['COUNT( * )']; ?>], <?php } ?>

]
    }

}



