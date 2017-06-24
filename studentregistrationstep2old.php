<?php
session_start();
ob_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Ancestry Atlas - Student Registration</title>
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
  
    <!--Jquery function to autocomplete country name -->
	<script>
		$(function() {
			$( "#language" ).autocomplete({
			source: 'autocompletelanguage.php'
			});
		});
	</script>
</head>
<body style="font-family:MuseoSans_300;">
<?php
$combineErr="";
	$languageErr = $languageLevelErr  = "";
	$language = $languageLevel  ="";
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		
		 //language validation
		   if (empty($_POST["language"])) {
			$languageErr = "Language is required";
			$combineErr = $combineErr."<br>".$languageErr;
			echo "<script type='text/javascript'>
				$(document).ready(function()
				{
					$('#language').css('background-color', '#ffb0b0');
				}); </script>";
		  } else {
			$language = test_input($_POST["language"]);
			
		  }
		  
		  
		  
	//language level			  
	$languageLevel = $_POST["languagelevel"];
				
			  
			  
			  
			  		
     //EVERTHING IS OK NOW
	 if((empty($languageErr)) and (empty($languageLevelErr))){
		 
		 $_SESSION["lan"] = $language;
		 $_SESSION["lanlevel"] = $languageLevel;
	
		 
	     header('location:studentregistrationstep3.php');	 
		 
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
    	<?php include 'header.php';
		
		
		?>
        
        
        <div class="row" >
        	<div class="col-sm-3"></div>
            <div class="col-sm-6 text-center">
            <canvas id="myCanvas1" style="width:13.75em;" >
                       Your browser does not support the canvas element.
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
                            
                           
                               
                                <input type="text" class="form-control inputfield" style=" float:left; margin-left:1.5%; width:45%;" name="language" id="language" placeholder="Choose Language and Level*" value="<?php echo $language; ?>"  >
                            
                                
                               <input type="radio" style="height:2em; width:3em; vertical-align: middle;" name="languagelevel" id="languagelevel" <?php if ($languageLevel=="fluent") echo "checked";?> value="advanced" required> 
                                <label style=" font-size:small;"> Advanced </label>
                                <input type="radio" style="height:2em; width:3em; vertical-align: middle;" name="languagelevel" id="languagelevel" <?php if ($languageLevel=="WorkingProficiency") echo "checked";?> value="intermediate"> 
                                <label style=" font-size:small;"> Intermediate </label>
                                <input type="radio" style="height:2em; width:3em; vertical-align: middle;" name="languagelevel" id="languagelevel" <?php if ($languageLevel=="basic") echo "checked";?> value="basic"> 
                                <label style=" font-size:small;"> Basic </label>
                                
                        
                           
                            </div>
                            
                            
                            
                            <div class="col-sm-12 text-left">
                             
                                
                            
                            
                      <span style="float:left;  margin-top:0.5em;">* Mandatory fields</span>
                            
                            <div class="col-sm-12 text-left">
                                <span style="clear:both; float:left;  color:red;"  id="error">
                                
                                <?php 
                                    echo $combineErr;
									
								?>
                                </span>
                            
                            </div>
                     
                     
                     
                     
                     </div>
                            <a href="teacherregistrationstep1.php">
                            <button type="button" class="btn btn-default loginbutton" title="PREVIOUS" style=" float:left; margin-left:2.5em; margin-top:3em; width:15%; height:6%;">PREVIOUS</button></a>
                            
                           <button type="submit" class="btn btn-default loginbutton" title="NEXT" style=" float:right; margin-right:2.5em; margin-top:3em; width:15%; height:6%;">NEXT</button>
                             
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
