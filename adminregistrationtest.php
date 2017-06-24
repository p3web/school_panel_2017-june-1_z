<!DOCTYPE html>
<html lang="en">
<head>
  <title>Ancestry Atlas - Admin Registration</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="css/style.css">
  
 
    <!--  AUTO COMPLETE MATERIAL -->
    <link rel="stylesheet" href="css/jquery-ui.css">
    <script src="scripts/jquery-1.10.2.js"></script>
    <script src="scripts/jquery-ui.js"></script>
  
  <style>
    	#error{ color:red;}
    	
    	@font-face {	
	font-family:MuseoSans_300;
    src:url(fonts/MuseoSans_300.ttf);
	font-weight: normal;
	font-style: normal;
	
	}	
    </style>
    <!--Jquery function to autocomplete country name -->
	<script>
		$(function() {
			$( "#country" ).autocomplete({
			source: 'autocompletecountry.php'
			});
		});
		$(function() {
			$( "#countryorg" ).autocomplete({
			source: 'autocompletecountry.php'
			});
		});

		$(document).ready(function(){
		    $('[data-toggle="tooltip"]').tooltip();   
		});
		
	</script>


</head>
<body id="adminreg">

<?php

$combineErr="";
	$firstNameErr = $lastNameErr = $emailErr = $schoolOrgNameErr = $passErr = $passConErr = $countryErr = "";
	$firstName = $lastName = $email = $stateProvince = $city = $suburb = $postcode =  $schoolOrgName=  $pass = $passCon = $country ="";
	
	
$combineErrorg="";
	$firstNameErrorg = $lastNameErrorg = $emailErrorg = $schoolOrgNameErrorg = $passErrorg = $passConErrorg = $countryErrorg = "";
	$firstNameorg = $lastNameorg = $emailorg = $stateProvinceorg = $cityorg = $suburborg = $postcodeorg =  $schoolOrgNameorg=  $passorg = $passConorg = $countryorg ="";
	
	$activeTabName ="school";
		
	if(isset($_REQUEST['schoolsubmit'])){
			
		echo '<script>activaTab("school");</script>';
		$activeTabName="school";
		 if (empty($_POST["firstName"])) {
			$firstNameErr = "First Name is required";
			$combineErr = $firstNameErr;
				echo "<script type='text/javascript'>
				$(document).ready(function()
				{
					$('#firstName').css('background-color', '#ffb0b0');
				}); </script>";
						
            
		  } else {
			$firstName = test_input($_POST["firstName"]);
			// check if name only contains letters and whitespace
			if (!preg_match("/^[a-zA-Z ]*$/",$firstName)) {
			  $firstNameErr = "Only letters and white space allowed in first name."; 
			  	$combineErr = $firstNameErr;
				echo "<script type='text/javascript'>
				$(document).ready(function()
				{
					$('#firstName').css('background-color', '#ffb0b0');
				}); </script>";
			
			}
		  }
		  
		  
		  //LAST NAME VALIDATION
		  
		  if (empty($_POST["lastName"])) {
			  
            
		  } else {
			$lastName = test_input($_POST["lastName"]);
			// check if name only contains letters and whitespace
			if (!preg_match("/^[a-zA-Z ]*$/",$lastName)) {
			  $lastNameErr = "Only letters and white space allowed in last name."; 
			  	$combineErr = $combineErr."<br>".$lastNameErr;
				echo "<script type='text/javascript'>
				$(document).ready(function()
				{
					$('#lastName').css('background-color', '#ffb0b0');
				}); </script>";
		
			}
		  }
		  
		  //EMAIL VALIDATION
		   if (empty($_POST["email"])) {
			$emailErr = "Email is required";
			$combineErr = $combineErr."<br>".$emailErr;
			echo "<script type='text/javascript'>
				$(document).ready(function()
				{
					$('#email').css('background-color', '#ffb0b0');
				}); </script>";
		  } else {
			$email = test_input($_POST["email"]);
			// check if e-mail address is well-formed
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			  $emailErr = "Invalid email format"; 
			  $combineErr = $combineErr."<br>".$emailErr;
			  echo "<script type='text/javascript'>
				$(document).ready(function()
				{
					$('#email').css('background-color', '#ffb0b0');
				}); </script>";
			}else{
				
				
				include 'connection.php';
			
				$query = "select adminemailid from school";
				$result = mysql_query($query);
				
				$dataMatched = "no";
				while ($row=mysql_fetch_array($result))
				{
					
					
					if(strtolower($email) == strtolower($row["adminemailid"])){
						$dataMatched = "yes";
						$email = $row["adminemailid"];
						
						}
				
				}
				//teacher email check
				if($dataMatched == "no"){
					$queryt = "select teacheremailid from teacher";
					$resultt = mysql_query($queryt);
					
					while ($rowt=mysql_fetch_array($resultt))
					{
						if(strtolower($email) == strtolower($rowt["teacheremailid"])){
							$dataMatched = "yes";
							$email = $rowt["teacheremailid"];	
							}
					}
				}
				
				//student email check
				if($dataMatched == "no"){
					$querys = "select studentemailid from student";
					$results = mysql_query($querys);
					
					while ($rows=mysql_fetch_array($results))
					{
						if(strtolower($email) == strtolower($rows["studentemailid"])){
							$dataMatched = "yes";
							$email = $rows["studentemailid"];	
							}
					}
				}
				mysql_close($con);
				
				if( $dataMatched == "yes"){
					$emailErr = "Email already registered.";
					$combineErr = $combineErr."<br>".$emailErr;
					echo "<script type='text/javascript'>
						$(document).ready(function()
						{
							$('#email').css('background-color', '#ffb0b0');
						}); </script>";
					
				}
					
					
			}
		  }
		  
		  //COUNTRY NAME	
		   if (empty($_POST["country"])) {
			$countryErr = "Country Name is required";
			$combineErr = $combineErr."<br>".$countryErr;
			echo "<script type='text/javascript'>
				$(document).ready(function()
				{
					$('#country').css('background-color', '#ffb0b0');
				}); </script>";
		  } else {
			$country = test_input($_POST["country"]);
			
			include 'connection.php';
		
			$query = "select countryname from countries";
			$result = mysql_query($query);
			
			$dataMatched = "no";
			while ($row=mysql_fetch_array($result))
			{
				
				
				if(strtolower($country) == strtolower($row["countryname"])){
					$dataMatched = "yes";
					$country = $row["countryname"];
					
					}
			
			}
			mysql_close($con);
			
		    if( $dataMatched == "no"){
				$countryErr = "Country name not found.";
				$combineErr = $combineErr."<br>".$countryErr;
				echo "<script type='text/javascript'>
					$(document).ready(function()
					{
						$('#country').css('background-color', '#ffb0b0');
					}); </script>";
				
			}	
		  }
		  
		  
		  
		  //state and province
		  $stateProvince = test_input($_POST["state"]);
		  //city
		  $city = test_input($_POST["city"]);
		  //suburb
		  $suburb = test_input($_POST["suburb"]);
		  //postcode
		  $postcode = test_input($_POST["postcode"]);
	
	      
		 //school organization name validation
		   if (empty($_POST["schoolName"])) {
			$schoolOrgNameErr = "School/Organisation is required";
			$combineErr = $combineErr."<br>".$schoolOrgNameErr;
			echo "<script type='text/javascript'>
				$(document).ready(function()
				{
					$('#schoolName').css('background-color', '#ffb0b0');
				}); </script>";
		  } else {
			$schoolOrgName = test_input($_POST["schoolName"]);
			
		  }
									
		//PASSWORD
		$passPolicy = "[Password must be at least 8 characters, containing numbers, lower and  upper case letters. Such as H3llo246]";
		   if (empty($_POST["password"])) {
			$passErr = "Password is required";
			$combineErr = $combineErr."<br>".$passErr."<br>".$passPolicy;
			echo "<script type='text/javascript'>
				$(document).ready(function()
				{
					$('#password').css('background-color', '#ffb0b0');
				}); </script>";
			  }
			  
			  else if(strlen($_POST["password"]) < 8){
				  
				   
				  $passErr = "Password is too short!";
				  $combineErr = $combineErr."<br>".$passErr."<br>".$passPolicy;
				  $pass = $_POST["password"];
				  echo "<script type='text/javascript'>
					$(document).ready(function()
					{
						$('#password').css('background-color', '#ffb0b0');
					}); </script>";
			  
				  
				  }
			  else if(strlen($_POST["password"]) > 36){
				  
				   
				  $passErr = "Password is too long!";
				  $combineErr = $combineErr."<br>".$passErr."<br>".$passPolicy;
				  $pass = $_POST["password"];
				  echo "<script type='text/javascript'>
					$(document).ready(function()
					{
						$('#password').css('background-color', '#ffb0b0');
					}); </script>";
				  
				  }
			  else if( !preg_match("#[0-9]+#", $_POST["password"])){
				  
				   
				  $passErr = "Password must include at least one number!";
				  $combineErr = $combineErr."<br>".$passErr."<br>".$passPolicy;
				  $pass = $_POST["password"];
				  echo "<script type='text/javascript'>
					$(document).ready(function()
					{
						$('#password').css('background-color', '#ffb0b0');
					}); </script>";
				  
				  }
			  else if(  !preg_match("#[a-z]+#", $_POST["password"])){
				  
				   
				  $passErr = "Password must include at least one small letter!";
				  $combineErr = $combineErr."<br>".$passErr."<br>".$passPolicy;
				  $pass = $_POST["password"];
				  echo "<script type='text/javascript'>
					$(document).ready(function()
					{
						$('#password').css('background-color', '#ffb0b0');
					}); </script>";
				  
				  }
				  
			    else if(   !preg_match("#[A-Z]+#", $_POST["password"])){
				  
				   
				  $passErr = "Password must include at least one CAPS!";
				  $combineErr = $combineErr."<br>".$passErr."<br>".$passPolicy;
				  $pass = $_POST["password"];
				  echo "<script type='text/javascript'>
					$(document).ready(function()
					{
						$('#password').css('background-color', '#ffb0b0');
					}); </script>";
				  
				  }
				  
				
				  else{
					  
					  $pass = $_POST["password"];
					  $passCon = $_POST["confirmPassword"];
					  
					  if($_POST["password"] != $_POST["confirmPassword"]){
						  $passConErr = "Confirm password not matched with Password.";
						  $combineErr = $combineErr."<br>".$passConErr;
						  echo "<script type='text/javascript'>
							$(document).ready(function()
							{
								$('#confirmPassword').css('background-color', '#ffb0b0');
							}); </script>";
						  
					   }
					     
			       }
				  
		
				
				
	//EVERTHING IS OK NOW
	 if((empty($firstNameErr)) and (empty($lastNameErr)) and (empty($emailErr)) and (empty($countryErr)) and (empty($schoolOrgNameErr)) and (empty($passErr)) and (empty($passConErr))  ){
		 
		   $hashAndSaltedPassword = password_hash($pass, PASSWORD_BCRYPT);
		 
		  
		  if($lastName == ""){
			  $lastName="null";
			  }
		  if($stateProvince == ""){
			  $stateProvince="null";
			  }
		   if($city == ""){
		  	$city="null";
		      }
		  if($suburb == ""){
			  $suburb="null";
			  }
		   if($postcode == ""){
		  	$postcode="null";
		      }
		  
		  
		 //require_once('functions.php');
			//	insertSchoolValues($schoolOrgName,$country,$stateProvince,$city,$suburb,$postcode,$email,$firstName,$lastName,$hashAndSaltedPassword);
        		
			$bytes = openssl_random_pseudo_bytes(32);
			$token = bin2hex($bytes);
				
				include 'connection.php';
				
				if(!mysql_query("insert into school(schoolname, country, state, city, suburb, postcode,	adminemailid, firstname, lastname, password, token, status) values('$schoolOrgName','$country','$stateProvince','$city','$suburb', '$postcode','$email','$firstName','$lastName','$hashAndSaltedPassword','$token','pending')",$con)){
						
						die("ERROR: Data not inserted".mysql_error());
					}
				else{
					
					
					
					
						require("/home/ancestryatlas/public_html/phpmailertesting/PHPMailer_5.2.0/class.phpmailer.php");
						
						$mail = new PHPMailer();
						
						$mail->IsSMTP();                                      // set mailer to use SMTP
						$mail->Host = "localhost";  // specify main and backup server
						$mail->SMTPAuth = true;     // turn on SMTP authentication
						$mail->Username = "test@ancestryatlas.com";  // SMTP username
						$mail->Password = "Password456!"; // SMTP password
						
						$mail->From = "test@ancestryatlas.com";
						$mail->FromName = "Ancestry Atlas";
						
						$mail->Timeout = 60;
						
						//to whom you want to send an email
						$mail->AddAddress($email);                  // name is optional
						
						                                // set word wrap to 50 characters
						$mail->IsHTML(true);                                  // set email format to HTML
						
					
						$mail->Subject = "Account Confirmation";
						$mail->Body    = "
                                                                  Thanks for signing up with <a href='http://www.ancestryatlas.com/'>Ancestry Atlas</a> powered by <a href='http://culturalinfusion.org.au/'>Cultural Infusion</a>. Start your journey here!
                                                                  <br>You have now completed the setup phase for Ancestry Atlas and are ready to go. Your school has a private group for your whole school to collect data.  When you log in to the website you will see the Administrator Dashboard.  The next step in this process is to register an unlimited number of teachers. 
                                                                  <br>
                                                                  <ol>
                                                                  	<li>Activate this registration by selecting this <a href='http://www.ancestryatlas.com/verify.php?email=".$email."&token=".$token."'>LINK</a></li>
                                                                  	<li>After activation you can log in to www.ancestryatlas.com</li>
                                                                  	<li>Under the tab labelled Teachers, enter the email address for the teachers you wish to invite</li>
                                                                  	<li>The teacher will receive an email with an activation link and will be responsible for inviting students within their classes</li>
                                                                  	<li>As an Administrator you can view the dashboard and see the progress of data being collected</li>
                                                                  </ol>


								  <br>For further instruction please see our <a href='http://www.ancestryatlas.com/faq.php'>How to Guide and FAQ</a>.
								  <br>Please do let us know if you require any further assistance or help and we will respond rapidly via our <a href='http://www.ancestryatlas.com/contactus.php'>Contact Page</a>.
								  <br><br>
								  <br>Kind Regards
								  <br>
								  <br>Ancestry Atlas Team
								  <br>www.ancestryatlas.com


						
						";
						$mail->AltBody = "This is the body in plain text for non-HTML mail clients";
						
						if(!$mail->Send())
						{
							//echo "Message could not be sent. <p>";
							//echo "Mailer Error: " . $mail->ErrorInfo;
						   
							include 'connection.php';
							$query= "DELETE FROM school WHERE adminemailid = '".$email."' ";
							$result = mysql_query($query);
							echo '<script type="text/javascript">'; 
							echo 'alert("Email Unsuccessful. please try again. or contact us  ");' ;
							echo 'window.location.href = "adminregistration.php";';  
							echo '</script>'; 
						   exit;
						}else{
						
						
							echo '<script type="text/javascript">'; 
							echo 'alert("Thank you for registering with Ancestry Atlas! Check your E-mail for the activation link");'; 
							echo 'window.location.href = "adminthanks.php";';
							echo '</script>';
						
						}
					
					
					
		
                
					
					
			}
						
			mysql_close($con);	
		 
		 
		 }		
				

	}

	function test_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}
	
	
	
	// ORGANISATION STARTS

//ORGANISATION
if(isset($_REQUEST['orgsubmit'])){
			
		echo '<script>activaTab("org");</script>';
		$activeTabName ="org";
		
		 if (empty($_POST["firstNameorg"])) {
			$firstNameErrorg = "First Name is required";
			$combineErrorg = $firstNameErrorg;
				echo "<script type='text/javascript'>
				$(document).ready(function()
				{
					$('#firstNameorg').css('background-color', '#ffb0b0');
				}); </script>";
						
            
		  } else {
			$firstNameorg = test_input($_POST["firstNameorg"]);
			// check if name only contains letters and whitespace
			if (!preg_match("/^[a-zA-Z ]*$/",$firstNameorg)) {
			  $firstNameErrorg = "Only letters and white space allowed in first name."; 
			  	$combineErrorg = $firstNameErrorg;
				echo "<script type='text/javascript'>
				$(document).ready(function()
				{
					$('#firstNameorg').css('background-color', '#ffb0b0');
				}); </script>";
			
			}
		  }
		  
		 
		  //LAST NAME VALIDATION
		  
		  if (empty($_POST["lastNameorg"])) {
			  
            
		  } else {
			$lastNameorg = test_input($_POST["lastNameorg"]);
			// check if name only contains letters and whitespace
			if (!preg_match("/^[a-zA-Z ]*$/",$lastNameorg)) {
			  $lastNameErrorg = "Only letters and white space allowed in last name."; 
			  	$combineErrorg = $combineErrorg."<br>".$lastNameErrorg;
				echo "<script type='text/javascript'>
				$(document).ready(function()
				{
					$('#lastNameorg').css('background-color', '#ffb0b0');
				}); </script>";
		
			}
		  }
		  
		  //EMAIL VALIDATION
		   if (empty($_POST["emailorg"])) {
			$emailErrorg = "Email is required";
			$combineErrorg = $combineErrorg."<br>".$emailErrorg;
			echo "<script type='text/javascript'>
				$(document).ready(function()
				{
					$('#emailorg').css('background-color', '#ffb0b0');
				}); </script>";
		  } else {
			$emailorg = test_input($_POST["emailorg"]);
			// check if e-mail address is well-formed
			if (!filter_var($emailorg, FILTER_VALIDATE_EMAIL)) {
			  $emailErrorg = "Invalid email format"; 
			  $combineErrorg = $combineErrorg."<br>".$emailErrorg;
			  echo "<script type='text/javascript'>
				$(document).ready(function()
				{
					$('#emailorg').css('background-color', '#ffb0b0');
				}); </script>";
			}else{
				
				
				include 'connection.php';
			
				//organisation admin email check
				$queryo = "select orgadminemailid from organisationadmin";
				$resulto = mysql_query($queryo);
				
				
				$dataMatchedorg ="no";
				while ($rowo=mysql_fetch_array($resulto))
				{
					
					
					if(strtolower($emailorg) == strtolower($rowo["orgadminemailid"])){
						$dataMatchedorg ="yes";
						$emailorg = $rowo["orgadminemailid"];
						
						}
				
				}
				
				
				//school admin email check
				if($dataMatchedorg == "no"){
				$query = "select adminemailid from school";
				$result = mysql_query($query);
				
				
					while ($row=mysql_fetch_array($result))
					{
						
						
						if(strtolower($emailorg) == strtolower($row["adminemailid"])){
							$dataMatchedorg = "yes";
							$emailorg = $row["adminemailid"];
							
							}
					
					}
				}
				
				//teacher email check
				if($dataMatchedorg == "no"){
					$queryt = "select teacheremailid from teacher";
					$resultt = mysql_query($queryt);
					
					while ($rowt=mysql_fetch_array($resultt))
					{
						if(strtolower($emailorg) == strtolower($rowt["teacheremailid"])){
							$dataMatchedorg = "yes";
							$emailorg = $rowt["teacheremailid"];	
							}
					}
				}
				
				//student email check
				if($dataMatchedorg == "no"){
					$querys = "select studentemailid from student";
					$results = mysql_query($querys);
					
					while ($rows=mysql_fetch_array($results))
					{
						if(strtolower($emailorg) == strtolower($rows["studentemailid"])){
							$dataMatchedorg = "yes";
							$emailorg = $rows["studentemailid"];	
							}
					}
				}
				mysql_close($con);
				
				if( $dataMatchedorg == "yes"){
					$emailErrorg = "Email already registered.";
					$combineErrorg = $combineErrorg."<br>".$emailErrorg;
					echo "<script type='text/javascript'>
						$(document).ready(function()
						{
							$('#emailorg').css('background-color', '#ffb0b0');
						}); </script>";
					
				}
			
					
					
			}
		  }
		  
		  //COUNTRY NAME	
		   if (empty($_POST["countryorg"])) {
			$countryErrorg = "Country Name is required";
			$combineErrorg = $combineErrorg."<br>".$countryErrorg;
			echo "<script type='text/javascript'>
				$(document).ready(function()
				{
					$('#countryorg').css('background-color', '#ffb0b0');
				}); </script>";
		  } else {
			$countryorg = test_input($_POST["countryorg"]);
			

			include 'connection.php';
		
			$query = "select countryname from countries";
			$result = mysql_query($query);
			
			$dataMatched = "no";
			while ($row=mysql_fetch_array($result))
			{
				
				
				if(strtolower($countryorg) == strtolower($row["countryname"])){
					$dataMatched = "yes";
					$countryorg = $row["countryname"];
					
					}
			
			}
			mysql_close($con);
			
		    if( $dataMatched == "no"){
				$countryErrorg = "Country name not found.";
				$combineErrorg = $combineErrorg."<br>".$countryErrorg;
				echo "<script type='text/javascript'>
					$(document).ready(function()
					{
						$('#countryorg').css('background-color', '#ffb0b0');
					}); </script>";
				
			}	
		  }
		  
		  
		  
		  //state and province
		  $stateProvinceorg = test_input($_POST["stateorg"]);
		  //city
		  $cityorg = test_input($_POST["cityorg"]);
		  //suburb
		  $suburborg = test_input($_POST["suburborg"]);
		  //postcode
		  $postcodeorg = test_input($_POST["postcodeorg"]);
	
	      
		 //school organization name validation
		   if (empty($_POST["schoolNameorg"])) {
			$schoolOrgNameErrorg = "Organisation is required";
			$combineErrorg = $combineErrorg."<br>".$schoolOrgNameErrorg;
			echo "<script type='text/javascript'>
				$(document).ready(function()
				{
					$('#schoolNameorg').css('background-color', '#ffb0b0');
				}); </script>";
		  } else {
			$schoolOrgNameorg = test_input($_POST["schoolNameorg"]);
			
		  }
									
		//PASSWORD
		$passPolicy = "[Password must be at least 8 characters, containing numbers, lower and  upper case letters. Such as H3llo246]";
		   if (empty($_POST["passwordorg"])) {
			$passErrorg = "Password is required";
			$combineErrorg = $combineErrorg."<br>".$passErrorg."<br>".$passPolicy;
			echo "<script type='text/javascript'>
				$(document).ready(function()
				{
					$('#passwordorg').css('background-color', '#ffb0b0');
				}); </script>";
			  }
			  
			  else if(strlen($_POST["passwordorg"]) < 8){
				  
				   
				  $passErrorg = "Password is too short!";
				  $combineErrorg = $combineErrorg."<br>".$passErrorg."<br>".$passPolicy;
				  $passorg = $_POST["passwordorg"];
				  echo "<script type='text/javascript'>
					$(document).ready(function()
					{
						$('#passwordorg').css('background-color', '#ffb0b0');
					}); </script>";
			  
				  
				  }
			  else if(strlen($_POST["passwordorg"]) > 36){
				  
				   
				  $passErrorg = "Password is too long!";
				  $combineErrorg = $combineErrorg."<br>".$passErrorg."<br>".$passPolicy;
				  $passorg = $_POST["passwordorg"];
				  echo "<script type='text/javascript'>
					$(document).ready(function()
					{
						$('#passwordorg').css('background-color', '#ffb0b0');
					}); </script>";
				  
				  }
			  else if( !preg_match("#[0-9]+#", $_POST["passwordorg"])){
				  
				   
				  $passErrorg = "Password must include at least one number!";
				  $combineErrorg = $combineErrorg."<br>".$passErrorg."<br>".$passPolicy;
				  $passorg = $_POST["passwordorg"];
				  echo "<script type='text/javascript'>
					$(document).ready(function()
					{
						$('#passwordorg').css('background-color', '#ffb0b0');
					}); </script>";
				  
				  }
			  else if(  !preg_match("#[a-z]+#", $_POST["passwordorg"])){
				  
				   
				  $passErrorg = "Password must include at least one small letter!";
				  $combineErrorg = $combineErrorg."<br>".$passErrorg."<br>".$passPolicy;
				  $passorg = $_POST["passwordorg"];
				  echo "<script type='text/javascript'>
					$(document).ready(function()
					{
						$('#passwordorg').css('background-color', '#ffb0b0');
					}); </script>";
				  
				  }
				  
			    else if(   !preg_match("#[A-Z]+#", $_POST["passwordorg"])){
				  
				   
				  $passErrorg = "Password must include at least one CAPS!";
				  $combineErrorg = $combineErrorg."<br>".$passErrorg."<br>".$passPolicy;
				  $passorg = $_POST["passwordorg"];
				  echo "<script type='text/javascript'>
					$(document).ready(function()
					{
						$('#passwordorg').css('background-color', '#ffb0b0');
					}); </script>";
				  
				  }
				  
				
				  else{
					  
					  $passorg = $_POST["passwordorg"];
					  $passConorg = $_POST["confirmPasswordorg"];
					  
					  if($_POST["passwordorg"] != $_POST["confirmPasswordorg"]){
						  $passConErrorg = "Confirm password not matched with Password.";
						  $combineErrorg = $combineErrorg."<br>".$passConErrorg;
						  echo "<script type='text/javascript'>
							$(document).ready(function()
							{
								$('#confirmPasswordorg').css('background-color', '#ffb0b0');
							}); </script>";
						  
					   }
					     
			       }
				  
		
				
				
	//EVERTHING IS OK NOW
	 if((empty($firstNameErrorg)) and (empty($lastNameErrorg)) and (empty($emailErrorg)) and (empty($countryErrorg)) and (empty($schoolOrgNameErrorg)) and (empty($passErrorg)) and (empty($passConErrorg))  ){
		 
		   $hashAndSaltedPassword = password_hash($pass, PASSWORD_BCRYPT);
		 
		/////////////////////////////////////////////////DID UPTO HEEEEEEEEEEEEEEEEEEEEEERRRRRRRRRRRRRRRRRRRRRRRRRRRREEEEEEEEEEEEEEEEEEEEE   UPside upside upside  
		  if($lastName == ""){
			  $lastName="null";
			  }
		  if($stateProvince == ""){
			  $stateProvince="null";
			  }
		   if($city == ""){
		  	$city="null";
		      }
		  if($suburb == ""){
			  $suburb="null";
			  }
		   if($postcode == ""){
		  	$postcode="null";
		      }
		  
		  
		 //require_once('functions.php');
			//	insertSchoolValues($schoolOrgName,$country,$stateProvince,$city,$suburb,$postcode,$email,$firstName,$lastName,$hashAndSaltedPassword);
        		
			$bytes = openssl_random_pseudo_bytes(32);
			$token = bin2hex($bytes);
				
				include 'connection.php';
				
				if(!mysql_query("insert into schoolmmmmmmmmmmmmmmmmmmmmmmmmmmmm(schoolname, country, state, city, suburb, postcode,	adminemailid, firstname, lastname, password, token, status) values('$schoolOrgName','$country','$stateProvince','$city','$suburb', '$postcode','$email','$firstName','$lastName','$hashAndSaltedPassword','$token','pending')",$con)){
						
						die("ERROR: Data not inserted".mysql_error());
					}
				else{
					
					
					
					
						require("/home/ancestryatlas/public_html/phpmailertesting/PHPMailer_5.2.0/class.phpmailer.php");
						
						$mail = new PHPMailer();
						
						$mail->IsSMTP();                                      // set mailer to use SMTP
						$mail->Host = "localhost";  // specify main and backup server
						$mail->SMTPAuth = true;     // turn on SMTP authentication
						$mail->Username = "test@ancestryatlas.com";  // SMTP username
						$mail->Password = "Password456!"; // SMTP password
						
						$mail->From = "test@ancestryatlas.com";
						$mail->FromName = "Ancestry Atlas";
						
						$mail->Timeout = 60;
						
						//to whom you want to send an email
						$mail->AddAddress($email);                  // name is optional
						
						                                // set word wrap to 50 characters
						$mail->IsHTML(true);                                  // set email format to HTML
						
					
						$mail->Subject = "Account Confirmation";
						$mail->Body    = "
                                                                  Thanks for signing up with <a href='http://www.ancestryatlas.com/'>Ancestry Atlas</a> powered by <a href='http://culturalinfusion.org.au/'>Cultural Infusion</a>. Start your journey here!
                                                                  <br>You have now completed the setup phase for Ancestry Atlas and are ready to go. Your school has a private group for your whole school to collect data.  When you log in to the website you will see the Administrator Dashboard.  The next step in this process is to register an unlimited number of teachers. 
                                                                  <br>
                                                                  <ol>
                                                                  	<li>Activate this registration by selecting this <a href='http://www.ancestryatlas.com/verify.php?email=".$email."&token=".$token."'>LINK</a></li>
                                                                  	<li>After activation you can log in to www.ancestryatlas.com</li>
                                                                  	<li>Under the tab labelled Teachers, enter the email address for the teachers you wish to invite</li>
                                                                  	<li>The teacher will receive an email with an activation link and will be responsible for inviting students within their classes</li>
                                                                  	<li>As an Administrator you can view the dashboard and see the progress of data being collected</li>
                                                                  </ol>


								  <br>For further instruction please see our <a href='http://www.ancestryatlas.com/faq.php'>How to Guide and FAQ</a>.
								  <br>Please do let us know if you require any further assistance or help and we will respond rapidly via our <a href='http://www.ancestryatlas.com/contactus.php'>Contact Page</a>.
								  <br><br>
								  <br>Kind Regards
								  <br>
								  <br>Ancestry Atlas Team
								  <br>www.ancestryatlas.com


						
						";
						$mail->AltBody = "This is the body in plain text for non-HTML mail clients";
						
						if(!$mail->Send())
						{
							//echo "Message could not be sent. <p>";
							//echo "Mailer Error: " . $mail->ErrorInfo;
						   
							include 'connection.php';
							$query= "DELETE FROM school WHERE adminemailid = '".$email."' ";
							$result = mysql_query($query);
							echo '<script type="text/javascript">'; 
							echo 'alert("Email Unsuccessful. please try again. or contact us  ");' ;
							echo 'window.location.href = "adminregistration.php";';  
							echo '</script>'; 
						   exit;
						}else{
						
						
							echo '<script type="text/javascript">'; 
							echo 'alert("Thank you for registering with Ancestry Atlas! Check your E-mail for the activation link");'; 
							echo 'window.location.href = "adminthanks.php";';
							echo '</script>';
						
						}
					
					
					
		
                
					
					
			}
						
			mysql_close($con);	
		 
		 
		 }		
				

	}
	
	
	
	
	if($activeTabName=""){$activeTabName="school";}
	
	
?>

<div id="wrap">
	
	<div class="container-fluid">
    	<?php include 'header.php';?>
        
        
        <div class="row" >
        	<div class="col-sm-3"></div>
            <div class="col-sm-6 text-center">
             <canvas id="myCanvas1" style="width:13.75em;" >
                       <h2>REGISTRATION</h2>
                       </canvas>
                       
                       <script>
                       var canvas = document.getElementById("myCanvas1");
                       var ctx = canvas.getContext("2d");
                       ctx.fillStyle = "#ff8b88 ";
                       ctx.fillRect(30,131,210,23);
                       
                       ctx.font="30px Comic Sans MS";
                       ctx.fillStyle = "black";
                       ctx.textAlign = "center";
                       ctx.fillText("REGISTRATION",140,140);
                       </script>
                        
                        <br>
           
            
         
            	<br>
                <span>Please fill in the form.</span>
                <br><br>
                
                
                 <ul class="nav nav-tabs nav-justified">
                       <li class="active"><a data-toggle="tab" href="#school">SCHOOL</a></li>
                       <li><a data-toggle="tab" href="#org">ORGANISATION</a></li>            
                 </ul>
             	<div class="tab-content">
                		   
                      <div id="school" class="tab-pane fade in active "><!--SCHOOL STARTS -->
                      
                          <div class="col-sm-12 text-center" style="background-color:#FFF; margin-bottom:30px;  padding-bottom:30px;">
                        
                            <div class="row">
                            <div class="col-sm-4 text-left" style="margin-left:1.5%; margin-top:3.5%;"><span style=" font-weight:bold; font-size:1.5em; color:#71908a;">ADMIN PROFILE</span>
                            </div>
                             <div class="col-sm-4 text-center"> <img src="images/mainlogo.png" alt="" title="" width="73" height="73" class="loglogo" style="">
                            </div>
                             <div class="col-sm-4">
                            </div>
                            </div>
                            
                          
                            
                            
                           <form method="post" action="">
                                
                                <div class="form-group form-inline" >
                                
                                  <input type="text" class="form-control inputfield" style="margin-left:1.5%; width:45%;" name="firstName" id="firstName" placeholder="First Name*" value="<?php echo $firstName; ?>" >
                                   <input type="text" class="form-control inputfield" style="margin-left:0%; width:45%;" name="lastName" id="lastName" placeholder="Last Name" value="<?php echo $lastName; ?>" >
                                </div>
                                <div class="form-group form-inline">
                                
                                 <input type="email" class="form-control inputfield" style="margin-left:1.5%; width:45%;" name="email" id="email" placeholder="Email/Username*" value="<?php echo $email; ?>" >
                                   <input type="text" class="form-control inputfield" style="margin-left:0%; width:45%;" name="country" id="country" placeholder="Country of Residence*" value="<?php echo $country; ?>" >
                                </div>
                                
                                <div class="form-group form-inline">
                                
                                 <input type="text" class="form-control inputfield" style="margin-left:1.5%; width:45%;" name="state" id="state" placeholder="State/Province" value="<?php echo $stateProvince; ?>" >
                                   <input type="text" class="form-control inputfield" style="margin-left:0%; width:45%;" name="city" id="city" placeholder="City" value="<?php echo $city; ?>" >
                                </div>
                                <div class="form-group form-inline">
                                
                                 <input type="text" class="form-control inputfield" style="margin-left:1.5%; width:26%;" name="suburb" id="suburb" placeholder="Suburb" value="<?php echo $suburb; ?>" >
                                 <input type="text" class="form-control inputfield" style="margin-left:1.5%; width:17%;" name="postcode" id="postcode" placeholder="Postcode" value="<?php echo $postcode; ?>" >
                                   <input type="text" class="form-control inputfield" style="margin-left:0%; width:45%;" name="schoolName" id="schoolName" placeholder="School/Organisation Name*" value="<?php echo $schoolOrgName; ?>" >
                                </div>
                                 <div class="form-group form-inline">
                                
                                 <input type="password" class="form-control inputfield" style="margin-left:1.5%; width:45%;" name="password" id="password" placeholder="Password*"  value="<?php echo $pass; ?>" >
                                 <input type="password" class="form-control inputfield" style="margin-left:0%; width:45%;" name="confirmPassword" id="confirmPassword" placeholder="Confirm Password*" value="<?php echo $passCon; ?>">
                                </div>
                                
                                
                                <div class="form-group form-inline text-left">
                                
                                 <input type="checkbox"  style="margin-left:3.5em;"  name="confirmadmin" required> I confirm that I am the School Administrator<br><br>
                                 
                                 <a href="#" style="margin-left:3.5em; color:#000;" data-toggle="tooltip" data-placement="top" title="If you are a teacher, student or parent,  please contact your school administrator to get access to this product.">Not a school admin? </a> 
                                
                                 </div>
                                
                                
                                <span style="float:left; margin-left:3.5em;">* Mandatory fields</span><br>
                                
                                <div class="col-sm-12 text-left">
                                    <span style="clear:both; float:left; margin-left:3em;" id="error">
                                    
                                    <?php 
                                        echo $combineErr;
										echo "ACTIVE TAB NAME:::".$activeTabName."<br>". $GLOBALS['activeTabName'];
										 if($activeTabName == "school"){echo 'activvveeeee'; }else{ echo "orrrrrrrrrrrrrrrrrrrrrrrrrrrrrrther; "; echo $activeTabName;}
                                        
                                    ?>
                                    
                                
                                </div>
                                
                                
                                
                                
                                
                                <button type="submit" class="btn btn-default loginbutton" name="schoolsubmit" id="schoolsubmit" title="SUBMIT" style=" float:right; margin-right:2.5em; width:15%; height:6%;">SUBMIT</button>
                          </form>
                          
                    
                         
                    </div>

                     
                     
                      </div><!-- SCHOOL ENDS -->
                      
                   
                      <div id="org" class="tab-pane fade "><!--ORGANISATION STARTS -->
                      
                             <div class="col-sm-12 text-center" style="background-color:#FFF; margin-bottom:30px;  padding-bottom:30px;">
                            
                                <div class="row">
                                <div class="col-sm-4 text-left" style="margin-left:1.5%; margin-top:3.5%;"><span style=" font-weight:bold; font-size:1.5em; color:#71908a;">ADMIN PROFILE</span>
                                </div>
                                 <div class="col-sm-4 text-center"> <img src="images/mainlogo.png" alt="" title="" width="73" height="73" class="loglogo" style="">
                                </div>
                                 <div class="col-sm-4">
                                </div>
                                </div>
                                
                              
                                
                                
                               <form method="post" action="">
                                    
                                    <div class="form-group form-inline" >
                                      <input type="text" class="form-control inputfield" style="margin-left:1.5%; width:45%;" name="firstNameorg" id="firstNameorg" placeholder="First Name*" value="<?php echo $firstNameorg; ?>" >
                                       <input type="text" class="form-control inputfield" style="margin-left:0%; width:45%;" name="lastNameorg" id="lastNameorg" placeholder="Last Name" value="<?php echo $lastNameorg; ?>" >
                                    </div>
                                    <div class="form-group form-inline">
                                    
                                     <input type="email" class="form-control inputfield" style="margin-left:1.5%; width:45%;" name="emailorg" id="emailorg" placeholder="Email/Username*" value="<?php echo $emailorg; ?>" >
                                       <input type="text" class="form-control inputfield" style="margin-left:0%; width:45%;" name="countryorg" id="countryorg" placeholder="Country of Residence*" value="<?php echo $countryorg; ?>" >
                                    </div>
                                    
                                    <div class="form-group form-inline">
                                    
                                     <input type="text" class="form-control inputfield" style="margin-left:1.5%; width:45%;" name="stateorg" id="stateorg" placeholder="State/Province" value="<?php echo $stateProvinceorg; ?>" >
                                       <input type="text" class="form-control inputfield" style="margin-left:0%; width:45%;" name="cityorg" id="cityorg" placeholder="City" value="<?php echo $cityorg; ?>" >
                                    </div>
                                    <div class="form-group form-inline">
                                    
                                     <input type="text" class="form-control inputfield" style="margin-left:1.5%; width:26%;" name="suburborg" id="suburborg" placeholder="Suburb" value="<?php echo $suburborg; ?>" >
                                     <input type="text" class="form-control inputfield" style="margin-left:1.5%; width:17%;" name="postcodeorg" id="postcodeorg" placeholder="Postcode" value="<?php echo $postcodeorg; ?>" >
                                       <input type="text" class="form-control inputfield" style="margin-left:0%; width:45%;" name="schoolNameorg" id="schoolNameorg" placeholder="Organisation Name*" value="<?php echo $schoolOrgNameorg; ?>" >
                                    </div>
                                     <div class="form-group form-inline">
                                    
                                     <input type="password" class="form-control inputfield" style="margin-left:1.5%; width:45%;" name="passwordorg" id="passwordorg" placeholder="Password*"  value="<?php echo $passorg; ?>" >
                                     <input type="password" class="form-control inputfield" style="margin-left:0%; width:45%;" name="confirmPasswordorg" id="confirmPasswordorg" placeholder="Confirm Password*" value="<?php echo $passConorg; ?>">
                                    </div>
                                    
                                    
                                    <div class="form-group form-inline text-left">
                                    
                                     <input type="checkbox"  style="margin-left:3.5em;"  name="confirmadmin" required> I confirm that I am the Organisation Administrator<br><br>
                                     
                                     <a href="#" style="margin-left:3.5em; color:#000;" data-toggle="tooltip" data-placement="top" title="If you are a department head, team leader or staff members,  please contact your organisation administrator to get access to this product.">Not a organisation admin? </a> 
                                    
                                     </div>
                                    
                                    
                                    <span style="float:left; margin-left:3.5em;">* Mandatory fields</span><br>
                                    
                                    <div class="col-sm-12 text-left">
                                        <span style="clear:both; float:left; margin-left:3em;" id="error">
                                        
                                        <?php 
                                            echo $combineErrorg;
                                            
                                        ?>
                                        
                                    
                                    </div>
                                    
                                    
                                    
                                    
                                    
                                    <button type="submit" class="btn btn-default loginbutton" name="orgsubmit" id="orgsubmit" title="SUBMIT" style=" float:right; margin-right:2.5em; width:15%; height:6%;">SUBMIT</button>
                              </form>
                              
                        
                             
                        </div>
                        
                        
                      </div><!-- ORGANISATION ENDS -->
                </div>
                
                
                
                
                           </div>
            <div class="col-sm-3"></div>
         </div>
        
  
    </div>
    
</div>
   
<?php 
include 'footer.php';
?>
    <script type="text/javascript">
		  function activaTab(tabID){
			$('.nav-tabs a[href="#' + tabID + '"]').tab('show');
		};
		
  </script>
</body>
</html>


<?php /*
if($activeTabName == "school"){
	echo '<script>activaTab("school");</script>';
	
}else{
	echo '<script>activaTab("org");</script>';
} */
?>