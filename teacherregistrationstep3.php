<?php
session_start();
ob_start();
require_once "PSCO_data.php";
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
  
	<style>
    	#error{ color:red;}	
    </style>
<!--Jquery function to autocomplete country name -->
	<script>
		$(function() {
			$( "#tbp" ).autocomplete({
			source: 'autocompletecountry.php'
			});
		});
		//father birth place auto complete
		$(function() {
			$( "#fbp" ).autocomplete({
			source: 'autocompletecountry.php'
			});
		});
		$(function() {
			$( "#mbp" ).autocomplete({
			source: 'autocompletecountry.php'
			});
		});
		$(function() {
			$( "#gbpfs" ).autocomplete({
			source: 'autocompletecountry.php'
			});
		});
		$(function() {
			$( "#gbpms" ).autocomplete({
			source: 'autocompletecountry.php'
			});
		});
		$(function() {
			$( "#gmbpfs" ).autocomplete({
			source: 'autocompletecountry.php'
			});
		});
		$(function() {
			$( "#gmbpms" ).autocomplete({
			source: 'autocompletecountry.php'
			});
		});
	</script>
</head>
<body style="font-family:MuseoSans_300;">


<?php

$howmanylanguages = $_SESSION["howmanylanguages"];							
for($i=0; $i<$howmanylanguages;$i++){	
	${'finallanguagename'.$i} = $_SESSION["lanname".$i];
	${'finallanguagelevel'.$i} = $_SESSION["lanlevel".$i];
}



$combineErr="";
	$teacherBirthCountryErr = $fatherBirthCountryErr = $motherBirthCountryErr = $grandfatherBirthCountryFatherSideErr = $grandfatherBirthCountryMotherSideErr = $grandmotherBirthCountryMotherSideErr = $grandmotherBirthCountryFatherSideErr = "";
	$teacherBirthCountry = $fatherBirthCountry = $motherBirthCountry = $grandfatherBirthCountryFatherSide= $grandfatherBirthCountryMotherSide = $grandmotherBirthCountryFatherSide = $grandmotherBirthCountryMotherSide = "";
	
	
				$allDataInserted = "no";
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		
		
		//TEACHER birth COUNTRY NAME	
		   if (empty($_POST["tbp"])) {
			$teacherBirthCountryErr = "Teacher birth Country Name is required";
			$combineErr = $combineErr."<br>".$teacherBirthCountryErr;
			echo "<script type='text/javascript'>
				$(document).ready(function()
				{
					$('#tbp').css('background-color', '#ffb0b0');
				}); </script>";
		  } else {
			$teacherBirthCountry = test_input($_POST["tbp"]);
			
			
		    if( check_country($teacherBirthCountry) == "no"){
				$teacherBirthCountryErr = "Teacher birth Country name not found.";
				$combineErr = $combineErr."<br>".$teacherBirthCountryErr;
				echo "<script type='text/javascript'>
					$(document).ready(function()
					{
						$('#tbp').css('background-color', '#ffb0b0');
					}); </script>";
				
			}else{
				
				$teacherBirthCountry = $select;
				}	
		  }
		  
		  
		  //father birth COUNTRY NAME	
		   if (empty($_POST["fbp"])) {
			$fatherBirthCountryErr = "Father birth Country Name is required";
			$combineErr = $combineErr."<br>".$fatherBirthCountryErr;
			echo "<script type='text/javascript'>
				$(document).ready(function()
				{
					$('#fbp').css('background-color', '#ffb0b0');
				}); </script>";
		  } else {
			$fatherBirthCountry = test_input($_POST["fbp"]);
			
			
		    if( check_country($fatherBirthCountry) == "no"){
				$fatherBirthCountryErr = "Father birth Country name not found.";
				$combineErr = $combineErr."<br>".$fatherBirthCountryErr;
				echo "<script type='text/javascript'>
					$(document).ready(function()
					{
						$('#fbp').css('background-color', '#ffb0b0');
					}); </script>";
				
			}else{
				
				$fatherBirthCountry = $select;
				}	
		  }
		  
		  //mother birth COUNTRY NAME	
		   if (empty($_POST["mbp"])) {
			$motherBirthCountryErr = "Mother birth Country Name is required";
			$combineErr = $combineErr."<br>".$motherBirthCountryErr;
			echo "<script type='text/javascript'>
				$(document).ready(function()
				{
					$('#mbp').css('background-color', '#ffb0b0');
				}); </script>";
		  } else {
			$motherBirthCountry = test_input($_POST["mbp"]);
			
			
		    if( check_country($motherBirthCountry) == "no"){
				$motherBirthCountryErr = "Mother birth Country name not found.";
				$combineErr = $combineErr."<br>".$motherBirthCountryErr;
				echo "<script type='text/javascript'>
					$(document).ready(function()
					{
						$('#mbp').css('background-color', '#ffb0b0');
					}); </script>";
				
			}else{
				
				$motherBirthCountry = $select;
				}	
		  }
		  
		  
		  //grand father birth COUNTRY NAME (father side)	
		   if (empty($_POST["gbpfs"])) {
			$grandfatherBirthCountryFatherSideErr = "Grandfather birth (father side) country Name is required";
			$combineErr = $combineErr."<br>".$grandfatherBirthCountryFatherSideErr;
			echo "<script type='text/javascript'>
				$(document).ready(function()
				{
					$('#gbpfs').css('background-color', '#ffb0b0');
				}); </script>";
		  } else {
			$grandfatherBirthCountryFatherSide = test_input($_POST["gbpfs"]);
			
			
		    if( check_country($grandfatherBirthCountryFatherSide) == "no"){
				$grandfatherBirthCountryFatherSideErr = "Grandfather birth (father side) Country name not found.";
				$combineErr = $combineErr."<br>".$grandfatherBirthCountryFatherSideErr;
				echo "<script type='text/javascript'>
					$(document).ready(function()
					{
						$('#gbpfs').css('background-color', '#ffb0b0');
					}); </script>";
				
			}else{
				
				$grandfatherBirthCountryFatherSide = $select;
				}	
		  }
		  
		 //grand father birth COUNTRY NAME (mother side)	
		   if (empty($_POST["gbpms"])) {
			$grandfatherBirthCountryMotherSideErr = "Grandfather birth (Mother side) country Name is required";
			$combineErr = $combineErr."<br>".$grandfatherBirthCountryMotherSideErr;
			echo "<script type='text/javascript'>
				$(document).ready(function()
				{
					$('#gbpms').css('background-color', '#ffb0b0');
				}); </script>";
		  } else {
			$grandfatherBirthCountryMotherSide = test_input($_POST["gbpms"]);
			
			
		    if( check_country($grandfatherBirthCountryMotherSide) == "no"){
				$grandfatherBirthCountryMotherSideErr = "Grandfather birth (Mother side) Country name not found.";
				$combineErr = $combineErr."<br>".$grandfatherBirthCountryMotherSideErr;
				echo "<script type='text/javascript'>
					$(document).ready(function()
					{
						$('#gbpms').css('background-color', '#ffb0b0');
					}); </script>";
				
			}else{
				
				$grandfatherBirthCountryMotherSide = $select;
				}	
		  }
		  
		  
		    //grand mother birth COUNTRY NAME (father side)	
		   if (empty($_POST["gmbpfs"])) {
			$grandmotherBirthCountryFatherSideErr = "Grandmother birth (father side) country Name is required";
			$combineErr = $combineErr."<br>".$grandmotherBirthCountryFatherSideErr;
			echo "<script type='text/javascript'>
				$(document).ready(function()
				{
					$('#gmbpfs').css('background-color', '#ffb0b0');
				}); </script>";
		  } else {
			$grandmotherBirthCountryFatherSide = test_input($_POST["gmbpfs"]);
			
			
		    if( check_country($grandmotherBirthCountryFatherSide) == "no"){
				$grandmotherBirthCountryFatherSideErr = "Grandmother birth (father side) Country name not found.";
				$combineErr = $combineErr."<br>".$grandmotherBirthCountryFatherSideErr;
				echo "<script type='text/javascript'>
					$(document).ready(function()
					{
						$('#gmbpfs').css('background-color', '#ffb0b0');
					}); </script>";
				
			}else{
				
				$grandmotherBirthCountryFatherSide = $select;
				}	
		  }
		  
		   //grand mother birth COUNTRY NAME (mother side)	
		   if (empty($_POST["gmbpms"])) {
			$grandmotherBirthCountryMotherSideErr = "Grandmother birth (Mother side) country Name is required";
			$combineErr = $combineErr."<br>".$grandmotherBirthCountryMotherSideErr;
			echo "<script type='text/javascript'>
				$(document).ready(function()
				{
					$('#gmbpms').css('background-color', '#ffb0b0');
				}); </script>";
		  } else {
			$grandmotherBirthCountryMotherSide = test_input($_POST["gmbpms"]);
			
			
		    if( check_country($grandmotherBirthCountryMotherSide) == "no"){
				$grandmotherBirthCountryMotherSideErr = "Grandmother birth (Mother side) Country name not found.";
				$combineErr = $combineErr."<br>".$grandmotherBirthCountryMotherSideErr;
				echo "<script type='text/javascript'>
					$(document).ready(function()
					{
						$('#gmbpms').css('background-color', '#ffb0b0');
					}); </script>";
				
			}else{
				
				$grandmotherBirthCountryMotherSide = $select;
				}	
		  }
		  
		  
		  
		  
		//EVERYTHING is OK
		if(empty($teacherBirthCountryErr) and empty($fatherBirthCountryErr)and empty($motherBirthCountryErr)and empty($grandfatherBirthCountryFatherSideErr)and empty($grandfatherBirthCountryMotherSideErr)and empty($grandmotherBirthCountryMotherSideErr)and empty($grandmotherBirthCountryFatherSideErr)){
			
			
			$firstName = $_SESSION["fn"];
			$lastName = $_SESSION["ln"];
			$religion = $_SESSION["r"];
			$gender = $_SESSION["o"];
			$pass = $_SESSION["p"];
			$email = $_SESSION["u"];
			$token = $_SESSION["t"];
			//$language = $_SESSION["lan"];
			//$languageLevel = $_SESSION["lanlevel"];
			$schooId = $_SESSION["schoolid"];

			$age = $_SESSION["age"];
			
			/*
			$howmanylanguages = $_SESSION["howmanylanguages"];
			for($i=0; $i<$howmanylanguages;$i++){	
				echo ${'finallanguagename'.$i};
				echo ${'finallanguagelevel'.$i};
			}*/

			
			if(empty($firstName) or empty($gender) or empty($pass) or empty($email) or empty($token)){
			echo "<script type='text/javascript'>
					alert('Some data is missing. <br>Please follow the email link step by step<br> '); </script>";
			}else{
				
				
				$hashAndSaltedPassword = password_hash($pass, PASSWORD_BCRYPT);
		 
		  
		  if($lastName == ""){
			  $lastName="null";
			  }
		  if($religion == ""){
			  $religion="null";
			  }

				data::insertinto('`age_group`','`age`, `user_id`, `type`',"'$age' , '$email', 4 ");
			  
			  include 'connection.php';
				$allDataInserted ="no";
				$languageerror="no";
				if(!mysql_query("UPDATE teacher SET status='active', firstname='".$firstName."', lastname='".$lastName."', religion='".$religion."', gender='".$gender."', password='".$hashAndSaltedPassword."' WHERE teacheremailid='".$email."' AND token='".$token."' AND status='pending'",$con)){ 
					$allDataInserted ="no";
					die("ERROR: Data not inserted".mysql_error());
					
				}else{
					
					
					$howmanylanguages = $_SESSION["howmanylanguages"];
				
					for($i=0; $i<$howmanylanguages;$i++){			
						$language = ${'finallanguagename'.$i};
						$languageLevel = ${'finallanguagelevel'.$i};
				         
						if(!mysql_query("insert into teacherlanguage(teacheremailid, languagename, languagelevel) values('$email','$language','$languageLevel')",$con)){
								$allDataInserted ="no";
								$languageerror="yes";
								die("ERROR: Data not inserted".mysql_error());
								break;
						}
					}// for loop ends
					
					if( $languageerror == "yes"){
						$allDataInserted ="no";
						die("ERROR: Data not inserted".mysql_error());				
						
					}else{
							if(!mysql_query("insert into teacherbirthdetails(teacheremailid, birthplace, fatherbirthplace, motherbirthplace, fatherfatherbirthplace, fathermotherbirthplace, motherfatherbirthplace, mothermotherbirthplace) values('$email','$teacherBirthCountry','$fatherBirthCountry','$motherBirthCountry','$grandfatherBirthCountryFatherSide','$grandmotherBirthCountryFatherSide','$grandfatherBirthCountryMotherSide','$grandmotherBirthCountryMotherSide')",$con)){
								$allDataInserted ="no";
								die("ERROR: Data not inserted".mysql_error());
								
								
								}
							else{
								
								$allDataInserted ="yes";
								}
						}
				}
				
				
								
				if($allDataInserted == "no"){
					
					mysql_query("delete from teacher where teacheremailid='".$email."'",$con);
					
					mysql_query("insert into teacher(teacheremailid, schoolid, firstname, token, status) values('$email','$schooId','$firstName','$token','pending')",$con);
					
					
					
					echo '<script type="text/javascript">'; 
							echo 'alert("Teacher Registration UnSuccessfull.<br>Please follow registration link again from the email.");'; 
							echo 'window.location.href = "index.php";';
							echo '</script>';
					
					
				}else{				
						// remove all session variables
						session_unset(); 
						
						// destroy the session 
						session_destroy(); 
							
							
							
							echo '<script type="text/javascript">'; 
							echo 'alert("Teacher Registration Successfull.");'; 
							echo 'window.location.href = "teacherthanks.php";';
							echo '</script>';
				}
				
				
			  mysql_close($con);
			
			}
			
			}
	
	
}
	
	function test_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}
	
	
	function check_country($birtdata){
		
		include 'connection.php';
	
		$query = "select countryname from countries";
		$result = mysql_query($query);
		
		$dataMatched = "no";
		while ($row=mysql_fetch_array($result))
		{
			
			
			if(strtolower($birtdata) == strtolower($row["countryname"])){
				$dataMatched = "yes";
				$GLOBALS['select'] = $row["countryname"];
				//$birtdata = $row["countryname"];
				}
		
		}
		mysql_close($con);
		return $dataMatched;
  }
?>


<div id="wrap">
	
	<div class="container-fluid">
    	<?php include 'header.php';?>
        
        
        <div class="row" >
        	<div class="col-sm-3"></div>
            <div class="col-sm-6 text-center">
                <br>     <br>
           <h3  class="text-center">REGISTRATION</h3>
                   
            
            	
            	<br>
                <span>Please fill up the form.</span>
            
                <div class="col-sm-12 text-center" style="background-color:#FFF; margin-bottom:30px; margin-top:2em; padding-bottom:30px;">
    				
                		<div class="row">
                        <div class="col-sm-4 text-left" style="margin-left:1.5%; margin-top:3.5%;"><span style=" font-weight:bold; font-size:1.2em; color:#71908a;">3. THE COUNTRY OF YOUR BIRTH</span>
                        </div>
                         <div class="col-sm-4 text-center"> <img src="images/mainlogo.png" alt="" title="" width="73" height="73" class="loglogo" style="">
                        </div>
                         <div class="col-sm-4">
                        </div>
                        </div>
                        
                       
                        
                        
                       <form action="" method="post" >
                       		
                            <div class="form-group form-inline">
                            
                             <input type="text" class="form-control inputfield" style="margin-left:0.5%; width:93%;" id="tbp" name="tbp"  placeholder="Teacher birthplace*" value="<?php echo $teacherBirthCountry; ?>" >                                                          
                             <input type="text" class="form-control inputfield" style="margin-left:0.5%; width:46%;" id="fbp" name="fbp" placeholder="Father's birthplace*" value="<?php echo $fatherBirthCountry; ?>"  >
                              <input type="text" class="form-control inputfield" style="margin-left:0.5%; width:46%;" id="mbp" name="mbp" placeholder="Mother's birthplace*" value="<?php echo $motherBirthCountry; ?>">
                               <input type="text" class="form-control inputfield" style="margin-left:0.5%; width:46%;" id="gbpfs" name="gbpfs" placeholder="Grandfather's birthplace (Father's side)*"  value="<?php echo $grandfatherBirthCountryFatherSide; ?>">
                             
                               <input type="text" class="form-control inputfield" style="margin-left:0.5%; width:46%;" id="gbpms" name="gbpms" placeholder="Grandfather's birthplace (Mother's side)*" value="<?php echo $grandfatherBirthCountryMotherSide; ?>"  >
                                <input type="text" class="form-control inputfield" style="margin-left:0.5%; width:46%;" id="gmbpfs" name="gmbpfs" placeholder="Grandmother's birthplace (Father's side)*" value="<?php echo $grandmotherBirthCountryFatherSide;?>" >
                              <input type="text" class="form-control inputfield" style="margin-left:0.5%; width:46%;" id="gmbpms" name="gmbpms" placeholder="Grandmother's birthplace (Mother's side)*" value="<?php echo $grandmotherBirthCountryMotherSide; ?>" >
                               
                            </div>    
                            
                            
                            <span style="float:left; margin-left:3em;">* Mandatory fields</span><br>
                          
                            
                            
                            
                            <div class="col-sm-12 text-left">
                                <span style="clear:both; float:left; color:red; margin-left:2.8em;" id="error">
                                
                                <?php 
                                    echo $combineErr;
									
								?>
                                
                               </span>
                            </div>
                            
                            
                                                      
                          <button type="submit" class="btn btn-default loginbutton" title="SUBMIT" style=" float:right; margin-right:2.5em;background-color:6e9643; margin-top:1em; width:15%; height:6%;">SUBMIT</button>
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
