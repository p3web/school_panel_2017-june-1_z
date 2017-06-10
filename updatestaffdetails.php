<?php
require_once 'user_profile.php';

$connect = mysqli_connect("localhost", "ancestry_atlas", "]?7W%4yATmA?", "ancestry_atlas");

if(!empty($_POST)){

    $error ="";
    
    $staffemailid = mysqli_real_escape_string($connect, $_POST["staffemail"]);
    
    $firstName = mysqli_real_escape_string($connect, $_POST["firstname"]);   
    $lastName = mysqli_real_escape_string($connect, $_POST["lastname"]);
    $gender = mysqli_real_escape_string($connect, $_POST["gender"]);
    $religion = mysqli_real_escape_string($connect, $_POST["beliefreligion"]);
     
    $country = mysqli_real_escape_string($connect, $_POST["sb"]);
    $countrym = mysqli_real_escape_string($connect, $_POST["m"]);
    $countrygfm = mysqli_real_escape_string($connect, $_POST["gfm"]);
    $countrygmm = mysqli_real_escape_string($connect, $_POST["gmm"]);
    $countryf = mysqli_real_escape_string($connect, $_POST["f"]);
    $countrygff = mysqli_real_escape_string($connect, $_POST["gff"]);
    $countrygmf = mysqli_real_escape_string($connect, $_POST["gmf"]);


    //peyman code  start region
   // print_r($_REQUEST);exit;
    foreach($_REQUEST as $key => $value){
        $exp_key = explode('_', $key);
        if($exp_key[0] == 'lang'){
            $arr_lang[] = $value;
            $arr_lang_id[] =$exp_key[1];
        }
    }

    foreach($_REQUEST as $key => $value){
        $exp_key = explode('_', $key);
        if($exp_key[0] == 'langlevel'){
            $arr_lang_level[] = $value;
        }
    }

    for($i=0 ; $i<count($arr_lang);$i++){

        $lang[] = array('id'=>$arr_lang_id[$i],'lang'=>$arr_lang[$i],'level'=>$arr_lang_level[$i]);
    }

    //print_r($lang); exit;

    user_profile::edit_staff_language($lang);

    // peyman code end region



    //religion 
    if($religion == NULL or $religion == 'Belief/Religion'){
    	$religion = "Non Disclosed";  		
    }
    
    include 'connection.php';
	
	
	
	if(!mysql_query("UPDATE staff SET firstname='".$firstName."', lastname='".$lastName."', religion='".$religion."', gender='".$gender."' WHERE staffemailid='".$staffemailid."'",$con)){ 
	
		//die("ERROR: Data not inserted".mysql_error());
		$error = "ERROR: Data not Updated ".mysql_error();
		
	}
	
	
	if(!mysql_query("UPDATE staffbirthdetails SET staffbirthplace ='".$country."',  staffmotherbirthplace='".$countrym."', staffmothersfatherbirthplace='".$countrygfm."', staffmothersmotherbirthplace='".$countrygmm."', stafffatherbirthplace='".$countryf."', stafffathersfatherbirthplace='".$countrygff."', stafffathersmotherbirthplace='".$countrygmf."'  WHERE staffemailid='".$staffemailid."'",$con)){ 
	
		//die("ERROR: Data not inserted".mysql_error());
		$error = "ERROR: Data not Updated ".mysql_error();
		
	}else{
    
      $error = "No error";
	}
	
	echo $error;
}







 ?>