<?php
ob_start();
session_cache_expire();
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Organisation Admin Panel</title>
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
</head>
<body id="adminpanel">

<?php
	$adminidorg = $_SESSION['emailidorg']; 

		include 'connection.php';
		
		
		$queryp = "select * from organisationadmin where orgadminemailid = '".$adminidorg."'";
		$resultp = mysql_query($queryp);
		$adminNameorg = $orgName = $city = $suburb = "";
		$orgId = "";
		while ($rowp = mysql_fetch_array($resultp)){
			
			$adminNameorg = $rowp["firstname"]." ".$rowp["lastname"];
			$orgName = $rowp["orgname"];
			$city = $rowp["city"];
			$suburb = $rowp["suburb"];
			$orgId = $rowp["orgid"];
		}
		mysql_close($con);



?>
<?php
$combineErr="";
	$emailErr = $deptErr ="";
	$email = $name = $dept ="";
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		
		//name
		// $name = test_input($_POST["name"]);
	
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
			
				
				//organisation admin email check
				$queryo = "select orgadminemailid from organisationadmin";
				$resulto = mysql_query($queryo);
				
				
				$dataMatched ="no";
				while ($rowo=mysql_fetch_array($resulto))
				{
					if(strtolower($emailorg) == strtolower($rowo["orgadminemailid"])){
						$dataMatched ="yes";
						$emailorg = $rowo["orgadminemailid"];
						
						}
				
				}
				
				//admin email check
				if($dataMatched == "no"){
					$queryd = "select deptemailid from deptadmin";
					$resultd = mysql_query($queryd);
					
					while ($rowd=mysql_fetch_array($resultd))
					{
						if(strtolower($email) == strtolower($rowd["deptemailid"])){
							$dataMatched = "yes";
							$email = $rowd["deptemailid"];
							
							}
					
					}
				}
				
				/// ADD LATERTRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRR      TEAM, STAFF
				
				//admin email check
				if($dataMatched == "no"){
					$query = "select adminemailid from school";
					$result = mysql_query($query);
					
					while ($row=mysql_fetch_array($result))
					{
						if(strtolower($email) == strtolower($row["adminemailid"])){
							$dataMatched = "yes";
							$email = $row["adminemailid"];
							
							}
					
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

	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	//DEPT VALIDATION
	 if (empty($_POST["department"])) {
			$deptErr = "Department name is required";
			$combineErr = $combineErr."<br>".$deptErr;
			echo "<script type='text/javascript'>
				$(document).ready(function()
				{
					$('#department').css('background-color', '#ffb0b0');
				}); </script>";
	   }else{
		   
		$dept = test_input($_POST["department"]);   
		
		
		
		include 'connection.php';
			
				//class check
				$query = "select deptname from orgdept where orgid='". $orgId."'";
				$result = mysql_query($query);
				
				$dataMatchedDept = "no";
				while ($row=mysql_fetch_array($result))
				{
					
					
					if(strtolower($dept) == strtolower($row["deptname"])){
						$dataMatchedDept = "yes";
						$dept = $row["deptname"];
						
						}
				
				}
				
				mysql_close($con);
				
				if( $dataMatchedDept == "yes"){
					$deptErr = "Department name already registered.";
					$combineErr = $combineErr."<br>".$deptErr;
					echo "<script type='text/javascript'>
						$(document).ready(function()
						{
							$('#department').css('background-color', '#ffb0b0');
						}); </script>";
				}	
				
		
		
		
		   
	   }
	
					
	//EVERTHING IS OK NOW
	 if((empty($emailErr) and empty($deptErr))){
		 
		   
		 
		  
		  if($name == ""){
			  $name="NULL";
			  }
		  
		  
		    
        		
			$bytes = openssl_random_pseudo_bytes(32);
			$token = bin2hex($bytes);
				
				include 'connection.php';
				$allDataInsertedSuccessful = "no";
				if(!mysql_query("insert into deptadmin(deptemailid, orgid, token, status) values('$email','$orgId','$token','pending')",$con)){
						$allDataInsertedSuccessful = "no";
						die("ERROR: Data not inserted".mysql_error());
					}
				else{
					
					if(!mysql_query("insert into orgdept(orgid, deptname) values('$orgId','$dept')",$con)){
						$allDataInsertedSuccessful = "no";
						die("ERROR: Data not inserted".mysql_error());
					}else{
							if(!mysql_query("insert into orgdeptdetail(orgid, deptemailid, deptname) values('$orgId','$email','$dept')",$con)){
								$allDataInsertedSuccessful = "no";
								die("ERROR: Data not inserted".mysql_error());
							}else{
					                $allDataInsertedSuccessful = "yes";
									
									
									require("/home/ancestryatlas/public_html/phpmailertesting/PHPMailer_5.2.0/class.phpmailer.php");
						
									$mail = new PHPMailer();
									
									$mail->IsSMTP();                                      // set mailer to use SMTP
									$mail->Host = "localhost";  // specify main and backup server
									$mail->SMTPAuth = true;     // turn on SMTP authentication
									$mail->Username = "test@ancestryatlas.com";  // SMTP username
									$mail->Password = "Password456!"; // SMTP password
									
									$mail->From = "test@ancestryatlas.com";
									$mail->FromName = "Ancestry Atlas";
									
									$mail->Timeout = 120;
									
									//to whom you want to send an email
									$mail->AddAddress($email);                  // name is optional
									
									                                // set word wrap to 50 characters
									$mail->IsHTML(true);                                  // set email format to HTML
									
								
									$mail->Subject = "Account Confirmation";
									include 'emailbodycontent.php'; 
						            $ccvv = emailbodyadmintodeptadmin($adminid,$email,$token);
						            $mail->Body    = "".$ccvv."";
									
									$mail->AltBody = "This is the body in plain text for non-HTML mail clients";
									
									if(!$mail->Send())
									{
										//echo "Message could not be sent. <p>";
										//echo "Mailer Error: " . $mail->ErrorInfo;
									   
										include 'connection.php';
										$query= "DELETE FROM deptadmin WHERE deptemailid = '".$email."' ";
										$result = mysql_query($query);
										echo '<script type="text/javascript">'; 
										echo 'alert("Email Unsuccessful. please try again. or contact us  ");' ;
										echo 'window.location.href = "organisationadminpanel.php";';  
										echo '</script>'; 
									   exit;
									}else{
									
									
										echo '<script type="text/javascript">'; 
										echo 'alert("Email has been sent successfully.");'; 
										echo 'window.location.href = "organisationadminpanel.php";';
										echo '</script>';
									
									}
									
									
									
									
									
									
									
									
							}
					}
                
					if($allDataInsertedSuccessful == "no"){
						$query= "DELETE FROM orgdept WHERE orgid = '".$orgId."' and deptname='".$dept."' ";
						$result = mysql_query($query);
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
            <?php include 'headeradmin.php';?>
            
            
            <div class="row" >
                
                <div class="col-sm-2">
                </div>
                
                <div class="col-sm-8" style="margin-top:2em;">
                   <div class="col-sm-12">  
                     	<div class="col-sm-6">
                        	 <h2>Welcome to your Ancestry Atlas</h2>
                             <h5>Organisation Admin -> &nbsp;<b><?php echo $adminNameorg; ?></b></h5> 
                             
                         </div>
                     
                     	<div class="col-sm-6 text-right">                     
                         	<h2><?php echo $orgName; ?></h2>
                         	<h5><?php echo $city." / ".$suburb; ?></h5>
                       </div>
                       <br><br>
                       <div class="col-sm-12" style="margin-top:4em;">
                           <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#deptadmin">Department Admin</a></li>
                            <li><a data-toggle="tab" href="#dept">Departments</a></li>
                            <li><a data-toggle="tab" href="#maps">Maps</a></li>
                          </ul>
                        
                          <div class="tab-content">
                            <div id="deptadmin" class="tab-pane fade in active">
                              
                              
								<br><br>
                              
                              <?php
							  
							  		include 'connection.php';
									$querydept = "select * from deptadmin where orgid = '".$orgId."'";
									$resultdept = mysql_query($querydept);
									if($resultdept == TRUE){
										$j=1;
										$k=1;
										echo "<table style='width:100%;' border='1'>";
										echo "<tr style='padding:1%;'>";
										/* echo "<th>Teachers Name</th>"; */
										echo "<th>Department Email ID*</th>";
										echo "<th>Department Name*</th>";
										echo "<th>Status</th>";
										echo "</tr>";
										
										while ($rowj=mysql_fetch_array($resultdept)){
											/* $teacherNameTemp = "";
											if($rowj['firstname'] == "NULL"){
												$teacherNameTemp = "Waiting acceptance";
											}else{
												$teacherNameTemp =	$rowj['firstname'];	
											}*/
											echo "<tr>";
											/*echo "<td style='padding:1%;'>";
											echo "<span style='padding:0.7%;' id='j".$j."' >".$teacherNameTemp." ".$rowj['lastname']."</span>&nbsp;&nbsp;&nbsp;";
											$j = ++$j;
											$k = ++$k;
											echo "</td>"; */
											echo "<td  style='padding:1%;'>";
											echo "<span>".$rowj['deptemailid']."</span>";
											echo "</td>";
											echo "<td style='padding:1%;'>";
											
											
											
											$query = "select deptname from orgdeptdetail where orgid = '".$orgId."' AND deptemailid = '".$rowj['deptemailid']."'";
											$result = mysql_query($query);
											
											$deptName = "";
											
											while ($rowp = mysql_fetch_array($result)){
												$deptName = $rowp["deptname"];
											}
											
											echo "<span>".$deptName."</span>";
											echo "</td>";
											echo "<td  style='padding:1%;'>";
											echo "<span>".$rowj['status']."</span>";
											echo "</td>";
											echo "</tr>";
										}
										?>
                                        <form method="post">
										<tr>
                                        <!--<td><input type="text" class="form-control" name="name" id="name" placeholder="Waiting class assignment" value="<?php //echo $name; ?>" > 
                                        </td>--> 
                                        <td><input type="email" class="form-control" id="email" name="email" placeholder="Click here to add department admin email address" value="<?php echo $email; ?>" >
                                        </td>
                                        <td><input type="text" class="form-control" id="department" name="department" placeholder="Add Department Name to Invite" value="<?php echo $dept; ?>" >
                                        </td>
                                        <td><button type="submit" class="btn btn-default" name="invite" id="invite" title="INVITE">INVITE</button></td>
                                        </tr>
                                        </form>
										<?php
										echo "</table>";
									}else{
										echo "data fetching fail from teacher table.";
									}
												  
                            ?>
                            
                            <span style="clear:both; float:left;  color:red;" id="error"><?php 
                                    echo $combineErr;
									
								?></span>
                            
                      
                            
                            
                            </div>
                            <div id="dept" class="tab-pane fade">
                              <h3>Department</h3>
                              <p>Under process</p>
                            </div>
                            <div id="maps" class="tab-pane fade">
                              <h3>maps</h3>
                              <p>Under process</p>
                            </div>
                          </div>
                       </div>
                       
                       
                       
                   </div>
                   
                     
                </div>
                
                <div class="col-sm-2">
                </div>
                
           </div>
        </div>
         
    </div>
  
            
            

<?php 
include 'footeradmin.php';
?>
</body>
</html>


<?php

if (isset($_GET['logoutreq'])) {
	
	session_destroy();
	header('Location:../index.php');
	
}



if(!isset($_SESSION['adminorg'])){
	
	
	header('Location:index.php');
}


?>


