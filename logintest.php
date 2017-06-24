<?php
ob_start();
session_cache_expire();
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Ancestry Atlas - Login</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="css/style.css">

  
</head>
<body>


<div id="wrap">
	
	<div class="container-fluid">
    	<?php include 'header.php';?>
        
        
        <div class="row" >
        	<div class="col-sm-4"></div>
            <div class="col-sm-4 text-center">
                        <br>    <br>
                         <br>                   
                        <h3  class="text-center">LOGIN</h3>

                        
                        <br>
                        
    					<div class="row">
                        	<div class="col-sm-12 text-center">
                                  
                                  <ul class="nav nav-tabs nav-justified">
                                  
                                             <li class="active"><a data-toggle="tab" href="#school">SCHOOL</a></li>
                                             <li><a data-toggle="tab" href="#org">ORGANISATION</a></li>
                                        
                                    
                                  </ul>
  										<div class="tab-content">
                                            <div id="school" class="tab-pane fade in active">
                                                            <div class="col-sm-12 text-center" style="background-color:#FFF; margin-bottom:30px; padding-bottom:30px;">
                                                                   <img src="images/mainlogo.png" alt="" title="" width="73" height="73" class="loglogo"> 
                                                                   <form action="" method="post">
                                                                        <div class="form-group">
                                                                          <input type="email" class="form-control inputfield" id="email" name="email" value="" placeholder="Email address" >
                                                                        </div>
                                                                        <div class="form-group">
                                                                          <input type="password" class="form-control inputfield" id="passwd" name="passwd" value=""  placeholder="Password">
                                                                        </div>
                                                                        <button type="submit" class="btn btn-default loginbutton" name="login" id="login" title="Login" style="  ">LOGIN</button>
                                                                  </form>
                                                                  <br>
                                                                    <span class="logforget"><a href="forgetpassword.php">Forget your password?</a></span>
                                                            </div>
                                                            
                                            </div>
                                            <div id="org" class="tab-pane fade">
                                                          <div class="col-sm-12 text-center" style="background-color:#FFF; margin-bottom:30px; padding-bottom:30px;">
                                                                   <img src="images/mainlogo.png" alt="" title="" width="73" height="73" class="loglogo"> 
                                                                   <form action="" method="post">
                                                                        <div class="form-group">
                                                                          <input type="email" class="form-control inputfield" id="emailorg" name="emailorg" value="" placeholder="Email address" >
                                                                        </div>
                                                                        <div class="form-group">
                                                                          <input type="password" class="form-control inputfield" id="passwdorg" name="passwdorg" value=""  placeholder="Password">
                                                                        </div>
                                                                        <button type="submit" class="btn btn-default loginbutton" name="loginorg" id="loginorg" title="Login" style="  ">LOGIN</button>
                                                                  </form>
                                                                  <br>
                                                                    <span class="logforget"><a href="forgetpassword.php">Forget your password?</a></span>
                                                            </div>
                                             
                                             
                                             
                                            </div>
                                         </div>
                                       
                            </div>
    					</div>
        
              
            </div>
            <div class="col-sm-4"></div>
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

<?php

if(isset($_REQUEST['login'])){
	
	echo '<script>activaTab("school");</script>';
	$email = $_REQUEST['email'];
	$paswd = $_REQUEST['passwd'];
	
	if($email == null || $paswd == null){
		
		echo '<script>alert("Please fill both login details.")</script>';
	}else{
		
		
		include 'connection.php';
		
		
		$queryp = "select * from school where adminemailid = '".$email."'";
		$resultp = mysql_query($queryp);
		$hasandsalted = "";
		$status = "";
		while ($rowp = mysql_fetch_array($resultp)){
			
			$hasandsalted = $rowp["password"];
			$status = $rowp["status"];
		}
		mysql_close($con);
		
		
		if (password_verify($paswd, $hasandsalted) and $status == "active") {
			
			  if(isset($_SESSION['admin'])){
				  
					$_SESSION['admin'] = $_SESSION['admin'] +1 ;
				  
			  }else{
			  
					$_SESSION['admin'] = 1;
			  
			  }
			  $_SESSION['emailid'] = $email;
			  header('location:adminpanel.php');
		
		}else{
			
				include 'connection.php';
		
		
				$queryp = "select * from teacher where 	teacheremailid = '".$email."'";
				$resultp = mysql_query($queryp);
				$hasandsalted = "";
				$status = "";
				while ($rowp = mysql_fetch_array($resultp)){
					
					$hasandsalted = $rowp["password"];
					$status = $rowp["status"];
				}
				mysql_close($con);
		
		
				if (password_verify($paswd, $hasandsalted) and $status == "active") {
			
					  if(isset($_SESSION['teacher'])){
						  
							$_SESSION['teacher'] = $_SESSION['teacher'] +1 ;
						  
					  }else{
					  
							$_SESSION['teacher'] = 1;
					  
					  }
				  $_SESSION['emailid'] = $email;
				  header('location:teacherpanel.php');
				  
			  }else{
			
            
            		echo '<script>alert("Wrong email id or password.")</script>';
			  }
			
			}
		
		
		mysql_close($con);
	}
	
}


?>


<!-- FOR ORGANISATION -->
<?php

if(isset($_REQUEST['loginorg'])){
	
	echo '<script>activaTab("org");</script>';
	
	$emailorg = $_REQUEST['emailorg'];
	$paswdorg = $_REQUEST['passwdorg'];
	
	if($emailorg == null || $paswdorg == null){
		
		echo '<script>alert("Please fill both login details.")</script>';
	}else{
		
		
		include 'connection.php';
		
		
		$queryp = "select * from organisationadmin where orgadminemailid = '".$emailorg."'";
		$resultp = mysql_query($queryp);
		$hasandsalted = "";
		$status = "";
		while ($rowp = mysql_fetch_array($resultp)){
			
			$hasandsalted = $rowp["password"];
			$status = $rowp["status"];
		}
		mysql_close($con);
		
		
		if (password_verify($paswdorg, $hasandsalted) and $status == "active") {
			
			  if(isset($_SESSION['adminorg'])){
				  
					$_SESSION['adminorg'] = $_SESSION['adminorg'] +1 ;
				  
			  }else{
			  
					$_SESSION['adminorg'] = 1;
			  
			  }
			  $_SESSION['emailidorg'] = $emailorg;
			  header('location:organisationadminpanel.php');
			 
		
		}else{
			
				include 'connection.php';
		
		
				$queryd = "select * from deptadmin where deptemailid = '".$emailorg."'";
				$resultd = mysql_query($queryd);
				$hasandsalted = "";
				$status = "";
				while ($rowp = mysql_fetch_array($resultd)){
					
					$hasandsalted = $rowp["password"];
					$status = $rowp["status"];
				}
				mysql_close($con);
		
		
				if (password_verify($paswdorg, $hasandsalted) and $status == "active") {
			
					  if(isset($_SESSION['deptorg'])){
						  
							$_SESSION['deptorg'] = $_SESSION['deptorg'] +1 ;
						  
					  }else{
					  
							$_SESSION['deptorg'] = 1;
					  
					  }
				  $_SESSION['deptemailidorg'] = $emailorg;
				  header('location:departmentadminpanel.php');
				  
				}else{
				
				
					include 'connection.php';
			
			
					$queryd = "select * from teamadmin where teamemailid = '".$emailorg."'";
					$resultd = mysql_query($queryd);
					$hasandsalted = "";
					$status = "";
					while ($rowp = mysql_fetch_array($resultd)){
						
						$hasandsalted = $rowp["password"];
						$status = $rowp["status"];
					}
					mysql_close($con);
			
			
					if (password_verify($paswdorg, $hasandsalted) and $status == "active") {
				
						  if(isset($_SESSION['teamorg'])){
							  
								$_SESSION['teamorg'] = $_SESSION['teamorg'] +1 ;
							  
						  }else{
						  
								$_SESSION['teamorg'] = 1;
						  
						  }
					  $_SESSION['teamemailidorg'] = $emailorg;
					  header('location:teamadminpanel.php');
					 }else{
	            
	            				echo '<script>alert("Wrong email id or password.")</script>';
				  	}
				 //DID it
				  //upto 
				  //here
				}
		}
		
		mysql_close($con);
	}
	
}


?>