<!DOCTYPE html>
<html lang="en">
<head>
  <title>Ancestry Atlas - Contact Us</title>
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
	$firstNameErr = $emailErr = $messageErr = "";
	$firstName =  $email = $message = "";
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		
		 if (empty($_POST["firstName"])) {
			$firstNameErr = "Name is required";
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
		  
		  
		  
		  
	      
		 // message name validation
		   if (empty($_POST["message"])) {
			$messageErr = "Message is required";
			$combineErr = $combineErr."<br>".$messageErr;
			echo "<script type='text/javascript'>
				$(document).ready(function()
				{
					$('#message').css('background-color', '#ffb0b0');
				}); </script>";
		  } else {
			$message = test_input($_POST["message"]);
			
		  }
									
				  
		
				
				
	//EVERTHING IS OK NOW
	 if((empty($firstNameErr))  and (empty($emailErr)) and (empty($messageErr)) ){
		 	
				
				
					
					
					
					
						require("/home/ancestryatlas/public_html/phpmailertesting/PHPMailer_5.2.0/class.phpmailer.php");
						
						$mail = new PHPMailer();
						
						$mail->IsSMTP();                                      // set mailer to use SMTP
						$mail->Host = "localhost";  // specify main and backup server
						$mail->SMTPAuth = true;     // turn on SMTP authentication
						$mail->Username = "test@ancestryatlas.com";  // SMTP username
						$mail->Password = "Password456!"; // SMTP password
						
						$mail->From =  $email;
						$mail->FromName = $email;
						
						$mail->Timeout = 60;
						
						
						//to whom you want to send an email
						$mail->AddAddress("info@ancestryatlas.com");                  // name is optional
						
						$mail->WordWrap = 50;                                 // set word wrap to 50 characters
						$mail->IsHTML(true);                                  // set email format to HTML
						
					
						$mail->Subject = "Contacted for Information";
						$mail->Body    = "Following was the query of User.<br>
						".$message."
						<br><br><br>
						From:<br>
						Name: ".$firstName."
						<br>Email id: ".$email."
						";
						$mail->AltBody = "This is the body in plain text for non-HTML mail clients";
						
						if(!$mail->Send())
						{
							
							echo '<script type="text/javascript">'; 
							echo 'alert("Contact us Email Unsuccessful. please try again.");' ;
							echo 'window.location.href = "contactusteacher.php";';  
							echo '</script>'; 
						   exit;
						}else{
						
						
							echo '<script type="text/javascript">'; 
							echo 'alert("Email sent Successful, we will address your query soon.");'; 
							echo 'window.location.href = "teacherpanel.php";';
							echo '</script>';
						
						}
					
					
					
		
                
					
					
			
						
			
		 
		 
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
   <?php include 'headerteacher.php';?>
        
        
        <div class="row" >
        	<div class="col-sm-3"></div>
            <div class="col-sm-6 text-center">
            <br> <br>
            <h3  class="text-center">CONTACT US</h3>
         
            	<br>
                <span>Please fill in the form.</span>
                <br><br>
                
                
            
                <div class="col-sm-12 text-center" style="background-color:#FFF; margin-bottom:30px;  padding-bottom:30px;">
    				
                		<div class="row">
                        <div class="col-sm-4 text-left" style="margin-left:1.5%; margin-top:3.5%;"><span style=" font-weight:bold; font-size:1.5em; color:#71908a;"></span>
                        </div>
                         <div class="col-sm-4 text-center"> <img src="images/mainlogo.png" alt="" title="" width="73" height="73" class="loglogo" style="">
                        </div>
                         <div class="col-sm-4">
                        </div>
                        </div>
                        
                       
                        
                        
                       <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                       		
                            <div class="form-group form-inline" >
                              <input type="text" class="form-control inputfield" style="margin-left:1.5%; width:45%;" name="firstName" id="firstName" placeholder="Your Name*" value="<?php echo $firstName; ?>" >
                               <input type="email" class="form-control inputfield" style="margin-left:1.5%; width:45%;" name="email" id="email" placeholder="Email Id*" value="<?php echo $email; ?>" >
                            </div>
                            
                             <div class="form-group form-inline">
                            	<textarea class="form-control inputfield"  style="margin-left:1.5%; width:92%;" rows="7" name="message" id="message" placeholder="Message*"><?php echo $message; ?></textarea>
                             
                             
                            </div>
                            <span style="float:left; margin-left:3em;">* Mandatory fields</span><br>
                            
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
include 'footerteacher.php';
?>

</body>
</html>
