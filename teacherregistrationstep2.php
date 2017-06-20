<?php
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
.ui-autocomplete { max-height: 200px; overflow-y: scroll; overflow-x: hidden;}

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
	
	<!--Jquery function to autocomplete country name -->
	<script>
		$(function() {
			$( "#religion" ).autocomplete({
			source: 'autocompletereligion.php'
			});
		});

	</script>
   
   <script>
    $(document).ready(function() {
    var max_fields      = 8; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
   
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            
            $(wrapper).append('<div><input type="text" name="mytext[]" id="language'+x+'" class="form-control inputfield" required style="clear:both; float:left; margin-left:1.5%; width:45%;" placeholder="Choose Language and Level*"/><input type="radio" style="height:4.3em; width:1.5em; vertical-align: middle;" name="lan'+x+'" value="advanced" required><label style=" font-size:small;"> Advanced&nbsp;&nbsp;&nbsp;&nbsp; </label><input type="radio" style="height:4.3em; width:1.5em; vertical-align: middle;" name="lan'+x+'" value="intermediate"><label style=" font-size:small;"> Intermediate&nbsp;&nbsp;&nbsp;&nbsp; </label><input type="radio" style="height:4em; width:1.5em; vertical-align: middle;" name="lan'+x+'" value="basic"> <label style=" font-size:small;"> Basic&nbsp;&nbsp;&nbsp; </label>  <a href="#"  style="height:4.3em; width:1.5em;" class="remove_field"><img src="images/crossy2.png"/></a></div>'); //add input box
		 
		
                     x++; //text box increment           
		          $(wrapper).find('input[type=text]:last').autocomplete({
				source: 'autocompletelanguage.php'
			});	
                            
		
		}else{
			$("#maxlanerror").text("Only 8 languages maximum");
			 
			}
    });
    
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })
});
</script>
</head>
<body style="font-family:MuseoSans_300;">
<?php
$combineErr="";
	$languageErr = $religionErr = "";
	$language = $languageLevel =$religion  ="";
	
	if(isset($_SESSION['r'])){ $religion = $_SESSION["r"];}
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
				
		  //religion
		  $religion = test_input($_POST["religion"]);
		  if( $religion == 'Belief/Religion'){
				$religion = "Non Disclosed";  		
		   }else if($religion == NULL){
		       $religion = "No Answer";
		   }
		   if( check_religion($religion) == "no"){
				$religionErr = "Religion name not found.";
				$combineErr = $combineErr."<br>".$religionErr;
				echo "<script type='text/javascript'>
					$(document).ready(function()
					{
						$('#religion').css('background-color', '#ffb0b0');
					}); </script>";
				
			}else{
			  		
     	 
		  $_SESSION["r"] = $religion;
		 
	     
		 if(isset($_POST["mytext"]) && is_array($_POST["mytext"])){  
			$capture_field_vals ="";
			//$capture_lanlevel_vals ="";
			$howmanyfields = 0;
			foreach($_POST["mytext"] as $key => $text_field){
				$capture_field_vals .= $text_field .", ";
				
				$_SESSION["lanname".$howmanyfields] = $text_field;
				
				$howmanyfields++;
			}
			
			echo $capture_field_vals;
			echo $howmanyfields;
			//echo $_POST['lan0'];
			for( $i=0; $i<$howmanyfields;$i++){
				echo $_POST['lan'.$i];
				$_SESSION['lanlevel'.$i] = $_POST['lan'.$i];
			}
			$_SESSION['howmanylanguages'] = $howmanyfields;
			
			
			
			header('location:teacherregistrationstep3.php');	
			
			
		}
	    
		
	}
	
		  
		
    }
    
    
	function test_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}
   
function check_religion($religion){
		
		include 'connection.php';
	
		$query = "select religion from religions";
		$result = mysql_query($query);
		
		$dataMatched = "no";
		while ($row=mysql_fetch_array($result))
		{
			
			
			if(strtolower($religion) == strtolower($row["religion"])){
				$dataMatched = "yes";
				}
		
		}
		mysql_close($con);
		return $dataMatched;
  }	
	?>
<div id="wrap">
	
	<div class="container-fluid">
    	<?php include 'header.php';
		
		
		?>
        
        
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
                      <input type="text" class="form-control inputfield" style="float:left; margin-left:1.5%; width:97%; clear:right;" name="religion" id="religion" placeholder="Belief" value="<?php echo $religion; ?>" >
                               <br>
                        
                                
                                    <!-- Add more languages START-->
									<div class="input_fields_wrap">
                                        
                                       <!-- <div><input type="text" name="mytext[]"></div>-->
                                        
                                        <div><input type="text" class="form-control inputfield" required style="clear:both; float:left; margin-left:1.5%; width:45%;" name="mytext[]" id="language"  placeholder="Choose Language and Level*" value="<?php echo $language; ?>"  >
                                        
                                        
                                        
                                        <input type="radio" style="height:3em; width:1.5em;   vertical-align: middle;" name="lan0" <?php if ($languageLevel=="advanced") echo "checked";?> value="advanced" required>
                                        <label style=" font-size:small;"> Advanced &nbsp;&nbsp;&nbsp; </label>
                                        <input type="radio" style="height:3em; width:1.5em; vertical-align: middle;" name="lan0" <?php if ($languageLevel=="Intermediate") echo "checked";?> value="intermediate"> 
                                        <label style=" font-size:small;"> Intermediate &nbsp;&nbsp;&nbsp;</label>
                                        <input type="radio" style="height:3em; width:1.5em; vertical-align: middle;" name="lan0" <?php if ($languageLevel=="basic") echo "checked";?> value="basic"> 
                                        <label style=" font-size:small;"> Basic </label>
                                        
                                        
                                        </div>
                                        
                                    </div> 
                                     <div id="maxlanerror"  style="color:red; clear:both; float:left; margin-bottom:0.5em; margin-left:1.5%;"></div>
                                          <button class="add_field_button btn btn-default loginbutton center-block" style="clear:both; width:30%; height:3em; background-color:#a3c366;">Add More Languages</button>   
                                    <!-- Add mor languages ENDs-->
                                                           
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
                            <button type="button" class="btn btn-default loginbutton" title="BACK" style=" float:left; margin-left:2.5em; margin-top:3em; width:15%; height:6%;">BACK</button></a>
                            
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
