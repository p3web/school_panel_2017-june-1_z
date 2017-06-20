<?php
session_cache_expire();
session_start();
ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Ancestry Atlas - Forget Password</title>
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
	$passErr = $passConErr ="";
	$pass = $passCon ="";

$email= $resettoken= $tableName= $columnName="";






if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['resettoken']) && !empty($_GET['resettoken']) AND isset($_GET['t']) && !empty($_GET['t']) AND isset($_GET['c']) && !empty($_GET['c'])){
    // Verify data
	 
	$email = mysql_escape_string($_GET['email']); // Set email variable
        $resettoken = mysql_escape_string($_GET['resettoken']); // Set hash variable
	$tableName = mysql_escape_string($_GET['t']);
	$columnName = mysql_escape_string($_GET['c']);
	
	
	$_SESSION['email'] = $email;
	$_SESSION['resettoken'] = $resettoken;
	$_SESSION['tableName'] = $tableName;
	$_SESSION['columnName'] = $columnName;
	
 

	
}





//validating INVALID USER

if(empty($resettoken)){header('location:index.php');}



//works when Update button pressed
if ($_SERVER["REQUEST_METHOD"] == "POST") {


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
	 if( (empty($passErr)) and (empty($passConErr))  ){
		 
		   $hashAndSaltedPassword = password_hash($pass, PASSWORD_BCRYPT);
		 
		  
        		
			//$bytes = openssl_random_pseudo_bytes(32);
			//$token = bin2hex($bytes);
				
				include 'connection.php';
				
				$email = $_SESSION['email'];
				$tableName = $_SESSION['tableName'];
				$columnName = $_SESSION['columnName'];
				
				$query ="UPDATE $tableName SET password='".$hashAndSaltedPassword."',resetpasswordstatus='expired'  WHERE $columnName ='".$email."'  AND resetpasswordstatus='active'";
						
				$result = mysql_query($query);
						
						
						
				if(!$result){
						
						die("ERROR: Password not updated".mysql_error());
						
					}
				else{
					
							echo '<script type="text/javascript">'; 
							echo 'alert("Password reset successfully.");'; 
							echo 'window.location.href = "login.php";';
							echo '</script>';
						
						
					
					
					
		
                
					
					
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
        	<div class="col-sm-4"></div>
            <div class="col-sm-4 text-center">
             <canvas id="myCanvas1" style="width:13.75em;" >
                       <h2>RESET PASSWORD</h2>
                       </canvas>
                       
                       <script>
                       var canvas = document.getElementById("myCanvas1");
                       var ctx = canvas.getContext("2d");
                       ctx.fillStyle = "#ff8b88 ";
                       ctx.fillRect(30,131,210,23);
                       
                       ctx.font="30px Comic Sans MS";
                       ctx.fillStyle = "black";
                       ctx.textAlign = "center";
                       ctx.fillText("RESET PASSWORD",140,140);
                       </script>
                        
                        <br>
           
            
         
            	<br>
                <br>
                
                
            
                <div class="col-sm-12 text-center" style="background-color:#FFF; margin-bottom:30px;  padding-bottom:30px;">
    				
                		<div class="row">
                        <br>
                        <div class="col-sm-4 text-left" style="margin-left:1.5%; margin-top:3.5%;"><span style=" font-weight:bold; font-size:1.5em; color:#71908a;"></span>
                        </div>
                         <div class="col-sm-4 text-center"> <img src="images/mainlogo.png" alt="" title="" width="73" height="73" class="loglogo" style="">
                        </div>
                         <div class="col-sm-4">
                        </div>
                        </div>
                        
                       
                        
                        
                       <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                       		
                            <div class="form-group form-inline" >
                              <br>
                             
                               
                               <input type="password" class="form-control inputfield" style="margin-left:1.5%; width:90%;" name="password" id="password" placeholder="New Password*"  value="<?php echo $pass; ?>" >
                               <input type="password" class="form-control inputfield" style="margin-left:1.5%; width:90%;" name="confirmPassword" id="confirmPassword" placeholder="Confirm New Password*" value="<?php echo $passCon; ?>">
                            </div>
                          
                            <span style="float:left; margin-left:2.5em;">* Mandatory fields</span><br>
                            
                            <div class="col-sm-12 text-left">
                                <span style="clear:both; float:left; margin-left:3em;" id="error">
                                
                                <?php 
                                    echo $combineErr;
									
								?>
                                
                            
                            </div>
                            
                            
                            
                            
                            
                            <button type="submit" class="btn btn-default loginbutton" title="UPDATE" style=" float:right; margin-right:2em; width:20%; height:6%;">UPDATE</button>
                            
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
