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
	
	.speccolor{color:#bcbbbb !important;}
.speccolor:hover{color:#BDE1DF !important;}
    </style>
    <!--Jquery function to autocomplete country name -->
	<script>
		$(function() {
			$( "#country" ).autocomplete({
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
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		
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
				
				date_default_timezone_set("Australia/Melbourne");
            	$datetime = date_create()->format('Y-m-d H:i:s');
				
				include 'connection.php';
				
				if(!mysql_query("insert into organisationadmin(orgname, country, state, city, suburb, postcode,	orgadminemailid, firstname, lastname, password, token, status, dateofregistration) values('$schoolOrgName','$country','$stateProvince','$city','$suburb', '$postcode','$email','$firstName','$lastName','$hashAndSaltedPassword','$token','pending','$datetime')",$con)){
						
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
						include 'emailbodycontent.php'; 
						$ccvv = emailbodytoorgadmin($adminid,$email,$token);
						$mail->Body    = "".$ccvv."";
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
?>

<div id="wrap">
	
	<div class="container-fluid">
    	<?php include 'header.php';?>
        
        
        <div class="row" >
        	<div class="col-sm-3"></div>
            <div class="col-sm-6 text-center">
                <br> <br> <br>
             <h3  class="text-center">ORGANISATION REGISTRATION</h3>
                        
           
            
         
            	<br>
                <span>Please fill in the form.</span>
                <br><br>
                
                
            
                <div class="col-sm-12 text-center" style="background-color:#FFF; margin-bottom:30px;  padding-bottom:30px;">
    				
                		<div class="row">
                        <div class="col-sm-4 text-left" style="margin-left:1.5%; margin-top:3.5%;"><span style=" font-weight:bold; font-size:1.5em; color:#71908a;">ADMIN PROFILE</span>
                        </div>
                         <div class="col-sm-4 text-center"> <img src="images/mainlogo.png" alt="" title="" width="73" height="73" class="loglogo" style="">
                        </div>
                         <div class="col-sm-4">
                        </div>
                        </div>
                        
                       
                        
                        
                       <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                       		
                            <div class="form-group form-inline" >
                              <input type="text" class="form-control inputfield" style="margin-left:1.5%; width:45%;" name="firstName" id="firstName" placeholder="First Name*" value="<?php echo $firstName; ?>" >
                               <input type="text" class="form-control inputfield" style="margin-left:0%; width:45%;"  name="lastName" id="lastName" placeholder="Last Name" value="<?php echo $lastName; ?>" >
                            </div>
                            <div class="form-group form-inline">
                            
                             <input type="email" class="form-control inputfield" style="margin-left:1.5%; width:45%;" name="email" id="email" placeholder="Email/Username*" value="<?php echo $email; ?>" >
                               <input type="text" class="form-control inputfield" style="margin-left:0%; width:40%;"  name="country" id="country" placeholder="Country of Residence*" value="<?php echo $country; ?>" >
                               <a href="#" style="margin-right:2em; " data-toggle="tooltip" data-placement="top" title="Can't find your Country, please read FAQ.">
                              <span style="font-size:20px; " class="glyphicon glyphicon-question-sign speccolor"  ></span> 
                              </a>
                            </div>
                            
                            <div class="form-group form-inline">
                            
                             <input type="text" class="form-control inputfield" style="margin-left:1.5%; width:45%;"  name="state" id="state" placeholder="State/Province" value="<?php echo $stateProvince; ?>" >
                               <input type="text" class="form-control inputfield" style="margin-left:0%; width:45%;" name="city" id="city" placeholder="City" value="<?php echo $city; ?>" >
                            </div>
                            <div class="form-group form-inline">
                            
                             <input type="text" class="form-control inputfield" style="margin-left:1.5%; width:26%;" name="suburb" id="suburb" placeholder="Suburb" value="<?php echo $suburb; ?>" >
                             <input type="text" class="form-control inputfield" style="margin-left:1.5%; width:17%;" name="postcode" id="postcode" placeholder="Postcode" value="<?php echo $postcode; ?>" >
                               <input type="text" class="form-control inputfield" style="margin-left:0%; width:45%;" name="schoolName" id="schoolName" placeholder="Organisation Name*" value="<?php echo $schoolOrgName; ?>" >
                            </div>
                             <div class="form-group form-inline">
                            
                             <input type="password" class="form-control inputfield" style="margin-left:1.5%; width:45%;" name="password" id="password" placeholder="Password*"  value="<?php echo $pass; ?>" >
                             <input type="password" class="form-control inputfield" style="margin-left:0%; width:45%;" name="confirmPassword" id="confirmPassword" placeholder="Confirm Password*" value="<?php echo $passCon; ?>">
                            </div>
                            
                            
                            <div class="form-group form-inline text-left">
                            
                             <input type="checkbox"  style="margin-left:3.5em;"  name="confirmadmin" required> I confirm that I am the Organisation Administrator<br><br>
                             
                             <a href="#" style="margin-left:3.5em; color:#000;" data-toggle="tooltip" data-placement="top" title="If you are a employee,  please contact your organisation administrator to get access to this product.">Not a Organisation admin? </a> 
                            
                             </div>
                            
                            
                            <span style="float:left; margin-left:3.5em;">* Mandatory fields</span><br>
                            
                            <div class="col-sm-12 text-left">
                                <span style="clear:both; float:left; margin-left:3em;" id="error">
                                
                                <?php 
                                    echo $combineErr;
									
								?>
                                
                            
                            </div>
                            
                            
                            
                            
                            
                            <button type="submit" class="btn btn-default loginbutton" title="SUBMIT" style=" float:right; margin-right:2.5em; width:15%; height:6%;">SUBMIT</button>
                      </form>
                      
				
                     
                </div>
            </div>
            <div class="col-sm-3"></div>
         </div>
        
  
    </div>
    
</div>
   
<?php 
include 'footer.php';
?>

</body>
</html>
