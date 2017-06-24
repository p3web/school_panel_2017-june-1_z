<?php  


$connect = mysqli_connect("localhost", "ancestry_atlas", "]?7W%4yATmA?", "ancestry_atlas");

if(!empty($_POST)){

    $error ="";
    
    $studentemailid = mysqli_real_escape_string($connect, $_POST["studentemailindiv"]);
    
    $firstName = mysqli_real_escape_string($connect, $_POST["firstnameindiv"]);   
    $lastName = mysqli_real_escape_string($connect, $_POST["lastnameindiv"]);
    $gender = mysqli_real_escape_string($connect, $_POST["genderindiv"]);
    $religion = mysqli_real_escape_string($connect, $_POST["beliefreligionindiv"]);
     
    $country = mysqli_real_escape_string($connect, $_POST["sbindiv"]);
    $countrym = mysqli_real_escape_string($connect, $_POST["mindiv"]);
    $countrygfm = mysqli_real_escape_string($connect, $_POST["gfmindiv"]);
    $countrygmm = mysqli_real_escape_string($connect, $_POST["gmmindiv"]);
    $countryf = mysqli_real_escape_string($connect, $_POST["findiv"]);
    $countrygff = mysqli_real_escape_string($connect, $_POST["gffindiv"]);
    $countrygmf = mysqli_real_escape_string($connect, $_POST["gmfindiv"]);
    
    //religion 
    if($religion == NULL or $religion == 'Belief/Religion'){
    	$religion = "Non Disclosed";  		
    }
    
   
   /*
    include 'connection.php';
	
	if(!mysql_query("insert into student(studentemailid, schoolid, classname, firstname, token, status) values('$email','$schoolId','$className','$name','$token','pending')",$con)){
						
						$error = "ERROR: Data not Updated ".mysql_error();
	}else{
	    $error = "No error";
	
	}



*/
	/*
	
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
	*/
	echo $error;
}







 ?>