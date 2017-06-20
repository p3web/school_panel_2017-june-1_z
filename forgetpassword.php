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
    	#error{ color:red;}
    	
    	@font-face {	
	font-family:MuseoSans_300;
    src:url(fonts/MuseoSans_300.ttf);
	font-weight: normal;
	font-style: normal;
	
	}	
    </style>
 
</head>
<body id="adminreg">

<?php

$combineErr="";
	 $emailErr = "";
	 $email = "";
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		
	
		  
		  
		  
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
			}
		  }
		  
		  
		  
		  
	   
				
				
	//EVERTHING IS OK NOW
	 if( (empty($emailErr)) ){
		 	
						
						
				include 'connection.php';
			
				//admin email check
				$query = "select adminemailid,firstname from school";
				$result = mysql_query($query);
				
				$dataMatched = "no";
				$tableName ="";
				$columnName="";
				$firstName ="";
				while ($row=mysql_fetch_array($result))
				{
					
					
					if(strtolower($email) == strtolower($row["adminemailid"])){
						$dataMatched = "yes";
						$tableName = "school";
						$columnName = "adminemailid";
						$email = $row["adminemailid"];
						$firstName = $row["firstname"];
						
						}
				
				}
				
				//teacher email check
				if($dataMatched == "no"){
					$queryt = "select teacheremailid,firstname from teacher";
					$resultt = mysql_query($queryt);
					
					while ($rowt=mysql_fetch_array($resultt))
					{
						if(strtolower($email) == strtolower($rowt["teacheremailid"])){
							$dataMatched = "yes";
							$tableName = "teacher";
							$columnName = "teacheremailid";
							$email = $rowt["teacheremailid"];
							$firstName = $rowt["firstname"];	
							}
					}
				}
				
				
				
				mysql_close($con);
				
				if( $dataMatched == "no"){
					$emailErr = "You are not registered with us.";
					$combineErr = $combineErr."<br>".$emailErr;
					echo "<script type='text/javascript'>
						$(document).ready(function()
						{
							$('#email').css('background-color', '#ffb0b0');
						}); </script>";
				}else{
				
						$bytes = openssl_random_pseudo_bytes(32);
						$resettoken = bin2hex($bytes);	
					
						
						include 'connection.php';
						
						$query ="UPDATE $tableName SET resetpassword='".$resettoken."', resetpasswordstatus='active' WHERE $columnName ='".$email."'";
						
						$result = mysql_query($query);
						if($result){
						
							 
					
								require("/home/ancestryatlas/public_html/phpmailertesting/PHPMailer_5.2.0/class.phpmailer.php");
									
									$mail = new PHPMailer();
									
									$mail->IsSMTP();                                      // set mailer to use SMTP
									$mail->Host = "localhost";  // specify main and backup server
									$mail->SMTPAuth = true;     // turn on SMTP authentication
									$mail->Username = "resetpassword@ancestryatlas.com";  // SMTP username
									$mail->Password = "Password456!"; // SMTP password
									
									$mail->From = "resetpassword@ancestryatlas.com";
									$mail->FromName = "Ancestry Atlas";
									
									$mail->Timeout = 120;
									
									//to whom you want to send an email
									$mail->AddAddress($email);                  // name is optional
									
									                                // set word wrap to 50 characters
									$mail->IsHTML(true);                                  // set email format to HTML
									
									$mail->Subject = "Password Reset - Ancestry Atlas";
									$mail->Body    = "
											  
											  Hi $firstName, 
											  <br><br>
											  You recently requested to reset your password for your Ancestry Atlas Account.Click the below link to reset it.
											  <br>
											  <a href='http://www.ancestryatlas.com/backend/verifyforgetpassword.php?email=".$email."&t=".$tableName."&c=".$columnName."&resettoken=".$resettoken."'>LINK</a>
											  <br>
											  If you did not request a password reset, please ignore this email or reply to let us know.
											  
											  
											 
											  <br><br><br>
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
										$query ="UPDATE $tableName SET resetpasswordstatus='error' WHERE $columnName ='".$email."'";
										$result = mysql_query($query);
										echo '<script type="text/javascript">'; 
										echo 'alert("Reset password email unsuccessful. Please try again or contact us.");' ;
										echo 'window.location.href = "forgetpassword.php";';  
										echo '</script>'; 
									   exit;
									}else{
									
									
										echo '<script type="text/javascript">'; 
										echo 'alert("Password Reset link has been sent to your email id.");'; 
										echo 'window.location.href = "index.php";';
										echo '</script>';
									
									}
					
					     mysql_close($con);
						}else{
							
							echo "Database error. Please try again";
							  
						}
						   
		
					}//else closing
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
                <span>Please enter your email id.</span>
                <br><br>
                
                
            
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
                               <input type="email" class="form-control inputfield" style="margin-left:1.5%; width:90%;" name="email" id="email" placeholder="Email Id*" value="<?php echo $email; ?>" >
                            </div>
                          
                            <span style="float:left; margin-left:2.5em;">* Mandatory fields</span><br>
                            
                            <div class="col-sm-12 text-left">
                                <span style="clear:both; float:left; margin-left:3em;" id="error">
                                
                                <?php 
                                    echo $combineErr;
									
								?>
                                
                            
                            </div>
                            
                            
                            
                            
                            
                            <button type="submit" class="btn btn-default loginbutton" title="RESET" style=" float:right; margin-right:2em; width:20%; height:6%;">RESET</button>
                            
                      </form>
                      
                     
                </div>
            </div>
            <div class="col-sm-4"></div>
         </div>
        
  
    </div>
    
</div>
   
<?php 
include 'footer.php';
?>

</body>
</html>
