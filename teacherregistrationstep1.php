<?php
session_cache_expire();
session_start();
ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Ancestry Atlas - Teacher Registration</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="css/style.css">
<style>
@font-face {	
	font-family:MuseoSans_300;
    src:url(fonts/MuseoSans_300.ttf);
	font-weight: normal;
	font-style: normal;
}

</style>
<!--  AUTO COMPLETE MATERIAL -->
    <link rel="stylesheet" href="css/jquery-ui.css">
    <script src="scripts/jquery-1.10.2.js"></script>
    <script src="scripts/jquery-ui.js"></script>
  
    

</head>
<body style="font-family:MuseoSans_300;">

<?php
$combineErr="";
$firstNameErr = $lastNameErr = $passErr = $passConErr = "";
$firstName = $lastName =  $pass = $passCon = $option  = "";


$email="";
$schoolName = "";






if(isset($_GET['u']) && !empty($_GET['u']) AND isset($_GET['t']) && !empty($_GET['t'])){
    // Verify data
	 
	$email = mysql_escape_string($_GET['u']); // Set email variable
    $token = mysql_escape_string($_GET['t']); // 	
	
	    include 'connection.php';
		
		
		$queryp = "select schoolid from teacher where teacheremailid = '".$email."'";
		$resultp = mysql_query($queryp);
		
		$schoolId = "";
		while ($rowp = mysql_fetch_array($resultp)){
			$schoolId = $rowp["schoolid"];
		}
		
		
		$query = "select schoolname from school where schoolid = '".$schoolId."'";
		$result = mysql_query($query);
		
		
		while ($rowp = mysql_fetch_array($result)){
			$schoolName = $rowp["schoolname"];
		}
		
		
		mysql_close($con);	


}


//Storing session values

if(isset($_SESSION['fn'])){ $firstName = $_SESSION["fn"];}
if(isset($_SESSION['ln'])){ $lastName = $_SESSION["ln"];}

if(isset($_SESSION['o'])){ $option = $_SESSION["o"];}
if(isset($_SESSION['p'])){ $pass = $_SESSION["p"];}
if(isset($_SESSION['u']) and empty($email)){ $email = $_SESSION["u"];}
if(isset($_SESSION['s'])){ $schoolName = $_SESSION["s"];}
if(isset($_SESSION['t'])){ $token = $_SESSION["t"];}



//validating INVALID USER

if(empty($token)){header('location:index.php');}



//works when Next button pressed
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
		  
		  
		  
	
	
	
	    //option
		$option = $_POST["option"];

	$age = $_POST["age"];
	
	
	
	
		//PASSWORD
		$passPolicy = "[Password must be at least 8 characters, containing numbers, lower and upper case letters. Such as H3llo246]";
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
			  else if(strlen($_POST["password"]) > 25){
				  
				   
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
	 if((empty($firstNameErr)) and (empty($lastNameErr)) and (empty($passErr)) and (empty($passConErr))  ){
		 
		 $_SESSION["fn"] = $firstName;
		 $_SESSION["ln"] = $lastName;
		 
		 $_SESSION["o"] = $option;
		 $_SESSION["p"] = $pass;
		 $_SESSION["u"] = $email;
		 $_SESSION["s"] = $schoolName;
		 $_SESSION["t"] = $token;
		 $_SESSION["schoolid"] = $schoolId;

		 $_SESSION["age"] =$age;
		 
		 
	     header('location:teacherregistrationstep2.php');	 
		 
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
                <br>
                <br>
            <h3  class="text-center">REGISTRATION</h3>
                       
            
            
            
            	<br>
                <span>Please fill up the form.</span>
            
                <div class="col-sm-12 text-center" style="background-color:#FFF; margin-bottom:30px; margin-top:2em; padding-bottom:30px;">
    				
                		<div class="row">
                        <div class="col-sm-4 text-left" style="margin-left:1.5%; margin-top:3.5%;"><span style=" font-weight:bold; font-size:1.2em; color:#71908a;">1. PERSONAL DETAILS</span>
                        </div>
                         <div class="col-sm-4 text-center"> <img src="images/mainlogo.png" alt="" title="" width="73" height="73" class="loglogo" style="">
                        </div>
                         <div class="col-sm-4">
                        </div>
                        </div>
                        
                       
                        
                       <form action="" method="post" >
                       		
                            <div class="form-group form-inline">
                            
                             <input type="text" class="form-control inputfield" style="margin-left:1.5%; width:45%; background-color:#6f9693; color:#000;" name="username" id="username" placeholder="Username*" disabled value="<?php echo $email; ?>"  >
                               <input type="text" class="form-control inputfield" style="margin-left:0%; width:45%; background-color:#6f9693;" name="schoolname"  id="schoolname" placeholder="School*" disabled value="<?php echo $schoolName; ?>" >
                            </div>
                            <div class="form-group form-inline" >
                              <input type="text" class="form-control inputfield" style="margin-left:1.5%; width:45%;" name="firstName" id="firstName" placeholder="First Name*" value="<?php echo $firstName; ?>" >
                               <input type="text" class="form-control inputfield" style="margin-left:0%; width:45%;" name="lastName" id="lastName" placeholder="Last Name" value="<?php echo $lastName; ?>" >
                            </div>
                            
                            
                            <div class="form-group form-inline">
                            
                             
                               
                               <select required class="form-control inputfield" style="margin-left:1.5%; width:45%;" name="option" id="option">
                                  <option value="">Gender</option>
                                  <option <?php if ($option=="male") echo "selected";?> value="male">Male</option>
                                  <option <?php if ($option=="female") echo "selected";?> value="female">Female</option>
                                  <option <?php if ($option=="others") echo "selected";?> value="others">Others</option>
                                </select>

							</div>

						   <div class="form-group form-inline">

							   <select required class="form-control inputfield" style="float:left; margin-left:5.5%; width:45%;" name="age" id="age">

							   </select>
						   </div>

						   <script type="text/javascript">
							   $('#age').load("page/data_value/age_group_60.html");
						   </script>

						   <div class="form-group form-inline">

                                <input type="password" class="form-control inputfield" style=" margin-left:0.1%; width:45%;" name="password" id="password" placeholder="Password*"  value="<?php echo $pass; ?>" >
                            </div>
                           
                             <div class="form-group form-inline">
                            
                            <input type="password" class="form-control inputfield" style=" float:left; width:45%;" name="confirmPassword" id="confirmPassword" placeholder="Confirm Password*" value="<?php echo $passCon; ?>">
                            
                            
                            </div>
                            <span style=" clear:both; float:left; margin-left:3em;">* Mandatory fields</span>
                            
                            <div class="col-sm-12 text-left">
                                <span style="clear:both; float:left; margin-left:3em; color:red;"  id="error">
                                
                                <?php 
                                    echo $combineErr;
									
								?>
                                </span>
                            
                            </div>
                            
                            
                              
                              <?php 
							  	//if(empty($email) or empty($schoolName)){
									?>
									<!--<button type="button" class="btn btn-default loginbutton" disabled title="NEXT" style=" float:right; margin-right:2.5em; margin-top:3em; width:15%; height:6%;">NEXT</button>-->
								<?php
                               // }else{
							  ?>
                              <button type="submit" class="btn btn-default loginbutton" title="NEXT" style=" float:right; margin-right:2.5em; margin-top:3em; width:15%; height:6%;">NEXT</button>
                              
                              <?php //}?>
                             
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
