<?php
/**
 * Created by PhpStorm.
 * User: peymanvalikhanli
 * Date: 6/15/17 AD
 * Time: 12:42
 */


ob_start();
session_cache_expire();
session_start();




$adminid = $_SESSION['emailid'];

include 'connection.php';


$queryp = "select * from school where adminemailid = '".$adminid."'";
$resultp = mysql_query($queryp);
$adminName = $schoolName = $city = $suburb = "";
$schoolId = "";
while ($rowp = mysql_fetch_array($resultp)){

    $adminName = $rowp["firstname"]." ".$rowp["lastname"];
    $schoolName = $rowp["schoolname"];
    $city = $rowp["city"];
    $suburb = $rowp["suburb"];
    $schoolId = $rowp["schoolid"];
}
mysql_close($con);
