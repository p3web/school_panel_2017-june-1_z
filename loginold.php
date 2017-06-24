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

<?php 
$l=''; 
if(isset($_GET['l'])){ $l = $_GET['l']; } 
if($l == ''){$l = "s";}
?>
<div id="wrap">
	
	<div class="container-fluid">
    	<?php include 'header.php';?>
        
        
        <div class="row" >
        	<div class="col-sm-4"></div>
            <div class="col-sm-4 text-center">
                       
                       <canvas id="myCanvas1" style="width:13.75em;" >
                       Your browser does not support the canvas element.
                       </canvas>
                       
                       <script>
                       var canvas = document.getElementById("myCanvas1");
                       var ctx = canvas.getContext("2d");
                       ctx.fillStyle = "#ff8b88 ";
                       ctx.fillRect(30,131,195,23);
                       
                       ctx.font="30px Comic Sans MS";
                       ctx.fillStyle = "black";
                       ctx.textAlign = "center";
                       ctx.fillText("LOGIN",130,140);
                       </script>
                        <br>
                        <br>
                         <br>
                        <br>
                        
    					<div class="row">
                        	<div class="col-sm-12 text-center">
                                  
                          <ul class="nav nav-tabs nav-justified">
                            <?php 
								if($l == 's'){
									 ?>
									 <li class="active"><a data-toggle="tab">SCHOOL</a></li>
                           			 <li><a data-toggle="tab">ORGANISATION</a></li>
								<?php
								}else{
								?>
									<li><a data-toggle="tab">SCHOOL</a></li>
                           			 <li class="active"><a data-toggle="tab">ORGANISATION</a></li>
								<?php
                                }
							
							?>
                            
                          </ul>
  
                                       
                            </div>
    					</div>
        
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
            <div class="col-sm-4"></div>
         </div>
        
  
    </div>
    
</div>
   
<?php 
include 'footer.php';
?>

</body>
</html>

<?php

if(isset($_REQUEST['login'])){
	
	$email = $_REQUEST['email'];
	$paswd = $_REQUEST['passwd'];
	
	if($email == null || $paswd == null){
		
		echo '<script>alert("Please fill both login details")</script>';
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