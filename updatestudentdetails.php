<?php  


$connect = mysqli_connect("localhost", "ancestry_atlas", "]?7W%4yATmA?", "ancestry_atlas");

if(!empty($_POST)){

    $error ="";
    
    $studentemailid = mysqli_real_escape_string($connect, $_POST["studentemail"]);
    
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

    user_profile::edit_student_language($lang);

    user_profile::edit_age_user($_POST["age"],$staffemailid , 3 ) ;


    // peyman code end region


    //religion 
    if($religion == NULL or $religion == 'Belief/Religion'){
    	$religion = "Non Disclosed";  		
    }
    
    include 'connection.php';
	
	
	
	if(!mysql_query("UPDATE student SET firstname='".$firstName."', lastname='".$lastName."', religion='".$religion."', gender='".$gender."' WHERE studentemailid='".$studentemailid."'",$con)){ 
	
		//die("ERROR: Data not inserted".mysql_error());
		$error = "ERROR: Data not Updated ".mysql_error();
		
	}
	
	
	if(!mysql_query("UPDATE studentbirthdetails SET studentbirthplace ='".$country."',  studentmotherbirthplace='".$countrym."', studentmothersfatherbirthplace='".$countrygfm."', studentmothersmotherbirthplace='".$countrygmm."', studentfatherbirthplace='".$countryf."', studentfathersfatherbirthplace='".$countrygff."', studentfathersmotherbirthplace='".$countrygmf."'  WHERE studentemailid='".$studentemailid."'",$con)){ 
	
		//die("ERROR: Data not inserted".mysql_error());
		$error = "ERROR: Data not Updated ".mysql_error();
		
	}else{
    
      $error = "No error";
	}
	
	echo $error;
}







 ?>