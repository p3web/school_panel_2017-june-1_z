<?php
/**
 * Created by PhpStorm.
 * User: peymanvalikhanli
 * Date: 5/30/17 AD
 * Time: 23:15
 */

require_once 'PSCO_function.php';




function get_count_gender($orgId,$teamName,$deptName,$gender = 'a'){
$result =  PSCO_func::get_lang_count_all_male_fmale($orgId ,$teamName , $deptName , 'f');
$result1 =  PSCO_func::get_lang_count_all_male_fmale($orgId ,$teamName , $deptName , 'm');


/*$femalecount =  count(PSCO_func::get_lang_count_all_male_fmale($orgId ,$teamName , $deptName , 'f'));
$malecount = count(PSCO_func::get_lang_count_all_male_fmale($orgId ,$teamName , $deptName , 'm'));
$totalcount = $femalecount + $malecount;
$temp  =array();
$temp  =array(
		array('All',$totalcount),
		array('Male',$malecount),
		array('Female',$femalecount)
			 );*/
/*
switch($gender){
    case 'a':
       $temp  = ['All',count($result)+count($result1)];
       break;
    case 'm':
        $temp  =['Male',count($result1)];
        break;
    case 'f':
        $temp  =['Female',count($result)];
        break;
    default:
        $temp  =array(
				array('All',count($result)+count($result1)),
				array('Male',count($result1)),
				array('Female',count($result))
					 );
        
}*/
/*$output = array();
$output[0] = ["All",count($result)+count($result1)];
$output[1] = ["Male",count($result1)];
$output[2] = ["Female",count($result)];
*/

//makecsv($temp, "staffcount.csv", false);
//echo json_encode($temp);
}

$orgId = '1';
$teamName = 'CITeam';
$deptName = 'Database';

get_count_gender($orgId,$teamName,$deptName,$_REQUEST['gender']);
echo '<br>'; 

