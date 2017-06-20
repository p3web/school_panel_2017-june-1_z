<?php
ob_start();
session_cache_expire();
session_start();
?>
<?php
	$adminid = $_SESSION['emailid']; 

		include 'connection.php';
		
		
		$queryp = "select * from school where adminemailid = '".$adminid."'";
		$resultp = mysql_query($queryp);
		$adminName = $schoolName = $city = $suburb = "";
		$schoolId = "";
		while ($rowp = mysql_fetch_array($resultp)){
			
			$adminName = $rowp["firstname"]." ".$rowp["lastname"];
			$schoolName = $rowp["schoolname"];
			$city = $rowp["city"];
			$suburb = $rowp["suburb"];
			$schoolId = $rowp["schoolid"];
		}
		mysql_close($con);



?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Admin Panel</title>
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

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
 <script type="text/javascript">
	
	  // Load Charts and the corechart package.
      google.charts.load('current', {'packages':['corechart']});
	  google.charts.setOnLoadCallback(drawRegionsMap);
	
	 
  function drawRegionsMap() {
        var data = google.visualization.arrayToDataTable([
          	['Country','NumberofPersons'],
			
			<?php 
			include 'connection.php';
			  if (!empty($_POST['classnamedropdown']))
			  {
				$className= $_POST['classnamedropdown'];
			  }
		
		    $unionAllOption = 0;
			//starting query
			$querytest ="";
			
		
		    if (!empty($_POST['formDoor'])){
				$querytest .= "select x , COUNT( * )  from(";
				$aDoor = $_POST['formDoor'];
				$N = count($aDoor);
				for($i=0; $i < $N; $i++){
					if($aDoor[$i] == 'S'){
						$querytest .= " select `studentbirthplace` as x from studentbirthdetails where studentemailid IN(SELECT studentemailid FROM student where schoolid='".$schoolId."'  AND classname='".$className."')";
						$unionAllOption = 1;
					}
					if($aDoor[$i] == 'F'){
						if($unionAllOption==1){$querytest .= " UNION ALL";}
						$querytest .= " select `studentfatherbirthplace` as x from studentbirthdetails  where studentemailid IN(SELECT studentemailid FROM student where schoolid='".$schoolId."'  AND classname='".$className."')";
						$unionAllOption = 1;
					}
					if($aDoor[$i] == 'M'){
						if($unionAllOption==1){$querytest .= " UNION ALL";}
						$querytest .= " select `studentmotherbirthplace` as x from studentbirthdetails  where studentemailid IN(SELECT studentemailid FROM student where schoolid='".$schoolId."'  AND classname='".$className."')";
						$unionAllOption = 1;
					}
					if($aDoor[$i] == 'GFFS'){
						if($unionAllOption==1){$querytest .= " UNION ALL";}
						$querytest .= " select `studentfathersfatherbirthplace` as x from studentbirthdetails  where studentemailid IN(SELECT studentemailid FROM student where schoolid='".$schoolId."'  AND classname='".$className."')";
						$unionAllOption = 1;
					}
					if($aDoor[$i] == 'GMFS'){
						if($unionAllOption==1){$querytest .= " UNION ALL";}
						$querytest .= " select `studentfathersmotherbirthplace` as x from studentbirthdetails  where studentemailid IN(SELECT studentemailid FROM student where schoolid='".$schoolId."'  AND classname='".$className."')";
						$unionAllOption = 1;
					}
					if($aDoor[$i] == 'GFMS'){
						if($unionAllOption==1){$querytest .= " UNION ALL";}
						$querytest .= " select `studentmothersfatherbirthplace` as x from studentbirthdetails  where studentemailid IN(SELECT studentemailid FROM student where schoolid='".$schoolId."'  AND classname='".$className."')";
						$unionAllOption = 1;
					}
					if($aDoor[$i] == 'GMMS'){
						if($unionAllOption==1){$querytest .= " UNION ALL";}
						$querytest .= " select `studentmothersmotherbirthplace` as x from studentbirthdetails  where studentemailid IN(SELECT studentemailid FROM student where schoolid='".$schoolId."'  AND classname='".$className."')";
						$unionAllOption = 1;
					}
				}
				
				$querytest .= " ) as temptable group by x";
			  }
		
			
			
			
			
			
			
			// Default values goes here
			if($querytest==""){
				
				$querytest = "select x , COUNT( * )  from( select `studentbirthplace` as x from studentbirthdetails where studentemailid IN(SELECT studentemailid FROM student where schoolid='".$schoolId."'  AND classname='".$className."') ) as temptable group by x";
			
			
				}
			
			$currentQuerry = $querytest;
			
			$result = mysql_query($currentQuerry); 
			
			while($row = mysql_fetch_assoc($result)) { 
			
			?> 
			['<?php echo $row['x']; ?>',<?php echo $row['COUNT( * )']; ?>], <?php } ?>
        
        ]);

        var options = { 
			
		
			
			colorAxis: {minValue: 0, colors: ['#f6cbcb','#af3634']},
			displayMode: 'regions',
			width: 900,
			height: 500,
			backgroundColor: { fill:'transparent' }
			
			
		};

        var chart = new google.visualization.GeoChart(document.getElementById('regions_div'));

        chart.draw(data, options);
      }
	 
	</script>
</head>
<body id="adminpanel">


<?php
$combineErr="";
	$emailErr = $classErr ="";
	$email = $name = $class ="";
	
	if (isset($_REQUEST['invite'])) {
		
		//name
		 $name = test_input($_POST["name"]);
	
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
			
				//admin email check
				$query = "select adminemailid from school";
				$result = mysql_query($query);
				
				$dataMatched = "no";
				while ($row=mysql_fetch_array($result))
				{
					
					
					if(strtolower($email) == strtolower($row["adminemailid"])){
						$dataMatched = "yes";
						$email = $row["adminemailid"];
						
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

	
	
	//CLASS VALIDATION
	 if (empty($_POST["class"])) {
			$classErr = "Class name is required";
			$combineErr = $combineErr."<br>".$classErr;
			echo "<script type='text/javascript'>
				$(document).ready(function()
				{
					$('#class').css('background-color', '#ffb0b0');
				}); </script>";
	   }else{
		   
		$class = test_input($_POST["class"]);   
		
		
		
		include 'connection.php';
			
				//class check
				$query = "select classname from class where schoolid='".$schoolId."'";
				$result = mysql_query($query);
				
				$dataMatchedClass = "no";
				while ($row=mysql_fetch_array($result))
				{
					
					
					if(strtolower($class) == strtolower($row["classname"])){
						$dataMatchedClass = "yes";
						$class = $row["classname"];
						
						}
				
				}
				
				mysql_close($con);
				
				if( $dataMatchedClass == "yes"){
					$classErr = "Class name already registered.";
					$combineErr = $combineErr."<br>".$classErr;
					echo "<script type='text/javascript'>
						$(document).ready(function()
						{
							$('#class').css('background-color', '#ffb0b0');
						}); </script>";
				}	
				
		
		
		
		   
	   }
	
					
	//EVERTHING IS OK NOW
	 if((empty($emailErr) and empty($classErr))){
		 
		   
		 
		  
		  if($name == ""){
			  $name="NULL";
			  }
		  
		  
		    
        		
			$bytes = openssl_random_pseudo_bytes(32);
			$token = bin2hex($bytes);
				
				include 'connection.php';
				$allDataInsertedSuccessful = "no";
				if(!mysql_query("insert into teacher(teacheremailid, schoolid, token, status) values('$email','$schoolId','$token','pending')",$con)){
						$allDataInsertedSuccessful = "no";
						die("ERROR: Data not inserted".mysql_error());
					}
				else{
					
					if(!mysql_query("insert into class(schoolid, classname) values('$schoolId','$class')",$con)){
						$allDataInsertedSuccessful = "no";
						die("ERROR: Data not inserted".mysql_error());
					}else{
							if(!mysql_query("insert into classteacher(schoolid, teacheremailid, classname) values('$schoolId','$email','$class')",$con)){
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
									$mail->Body    = "  
											  Your School administrator ".$adminid."  has signed you up for Ancestry Atlas powered by <a href='http://culturalinfusion.org.au/'>Cultural Infusion</a>. Start your journey here!
                                                                                          <br>											
											  <ol>
											  	<li>Activate this registration by selecting this <a href='http://www.ancestryatlas.com/verifyteacher.php?email=".$email."&token=".$token."'>LINK</a></li>
											  	<li>After activation you can log in to www.ancestryatlas.com</li>
											  	<li>Under the tab labelled Classes, enter the email address for the students you wish to invite</li>
											  	<li>Each student will receive an email with an activation link</li>
											  	<li>As a Teacher, you can view the dashboard and see the progress of data being collected</li>
											  </ol>
											  
											  <br>For further instruction please see our <a href='http://www.ancestryatlas.com/faq.php'>How to Guide and FAQ</a>.
											  <br>Please do let us know if you require any further assistance or help and we will respond rapidly via our <a href='http://www.ancestryatlas.com/contactus.php'>Contact Page</a>.
											  <br><br>
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
										$query= "DELETE FROM school WHERE adminemailid = '".$email."' ";
										$result = mysql_query($query);
										echo '<script type="text/javascript">'; 
										echo 'alert("Email Unsuccessful. please try again. or contact us  ");' ;
										echo 'window.location.href = "adminpanel.php";';  
										echo '</script>'; 
									   exit;
									}else{
									
									
										echo '<script type="text/javascript">'; 
										echo 'alert("Email has been sent successfully.");'; 
										echo 'window.location.href = "adminpanel.php";';
										echo '</script>';
									
									}
									
									
									
									
									
									
									
									
							}
					}
                
					if($allDataInsertedSuccessful == "no"){
						$query= "DELETE FROM class WHERE schoolid = '".$schoolId."' and classname='".$class."' ";
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
                             <h5>Admin -> &nbsp;<b><?php echo $adminName; ?></b></h5> 
                             
                         </div>
                     
                     	<div class="col-sm-6 text-right">                     
                         	<h2><?php echo $schoolName; ?></h2>
                         	<h5><?php echo $city." / ".$suburb; ?></h5>
                       </div>
                       
                       <div class="col-sm-12" style="margin-top:4em;">
                           <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#teachers">Teachers</a></li>
                            <li><a data-toggle="tab" href="#classes">Classes</a></li>
                            <li><a data-toggle="tab" href="#maps">Maps</a></li>
                          </ul>
                        
                          <div class="tab-content">
                            <div id="teachers" class="tab-pane fade in active">
                              
                              <p style="margin-top:1em;">As school administrator, you can now invite teachers to register for Ancestry Atlas<br>
                                 <b>How?</b> <br>
			         Enter each teacher&apos;s email address, their class name and hit INVITE. <br>
			        Teachers can now  register and start mapping their classroom cultural diversity</p>
			
                              
                              <?php
							  
							  		include 'connection.php';
									$queryteachers = "select * from teacher where schoolid = '".$schoolId."'";
									$resultteachers = mysql_query($queryteachers);
									if($resultteachers == TRUE){
										$j=1;
										$k=1;
										echo "<table style='width:100%;' border='1'>";
										echo "<tr>";
										/* echo "<th>Teachers Name</th>"; */
										echo "<th>Email Id*</th>";
										echo "<th>Class Name*</th>";
										echo "<th>Status</th>";
										echo "</tr>";
										
										while ($rowj=mysql_fetch_array($resultteachers)){
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
											echo "<span>".$rowj['teacheremailid']."</span>";
											echo "</td>";
											echo "<td style='padding:1%;'>";
											
											
											
											$query = "select classname from classteacher where schoolid = '".$schoolId."' AND teacheremailid = '".$rowj['teacheremailid']."'";
											$result = mysql_query($query);
											$className = "";
											
											while ($rowp = mysql_fetch_array($result)){
												$className = $rowp["classname"];
											}
											
											echo "<span>".$className."</span>";
											echo "</td>";
											echo "<td  style='padding:1%;'>";
											echo "<span>".$rowj['status']."</span>";
											echo "</td>";
											echo "</tr>";
										}
										?>
                                        <form method="post">
										<tr>
                                        <!--<td><input type="text" class="form-control" name="name" id="name" placeholder="Waiting class assignment" value="<?php echo $name; ?>" > 
                                        </td>--> 
                                        <td><input type="email" class="form-control" id="email" name="email" placeholder="Click here to add email address" value="<?php echo $email; ?>" >
                                        </td>
                                        <td><input type="text" class="form-control" id="class" name="class" placeholder="Add Class to Invite" value="<?php echo $class; ?>" >
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
                            
                            
                            <div id="classes" class="tab-pane fade">
                              <h3>Classes</h3>
                              <p>Under process</p>
                            </div>
                            
                            
                            
                            <!--Draw maps--> 
                            <div id="maps" class="tab-pane fade">
                               <br>
                          <div>
                              <div id="regions_div" style="width:900px; height: 500px; float:left;"></div>
                               
                               <div style="float:right;">
                               
                               		<div>
                               <form method="post">
                              
                              <?php 
							  		include 'connection.php';
							        $queryp = "select classname from classteacher where schoolid = '".$schoolId."'";
									$resultp = mysql_query($queryp);
									echo "Class Name:";
									echo '<select name="classnamedropdown">';
									while ($rowp = mysql_fetch_array($resultp)){
										$selected = ($rowp['classname'] == $currentClassName) ? 'selected="selected"' : '';
										echo '<option value="'.$rowp['classname'].'"'.$selected.' >'.$rowp['classname'].'</option>';
									}
									 echo '</select>';// Close your drop down box
							  		mysql_close($con);
									
									
									
							  ?>
                            
                              
                              <br><br>
                             
										<input type="checkbox" name="formDoor[]" value="S" <?php if(isset($_POST['formDoor'])){ $aDoor = $_POST['formDoor'];$N = count($aDoor);for($i=0; $i < $N; $i++){if($aDoor[$i] == 'S'){echo "checked='checked'";}}} ?>/>&nbsp;Student<br />
                                        <input type="checkbox" name="formDoor[]" value="F" <?php if(isset($_POST['formDoor'])){ $aDoor = $_POST['formDoor'];$N = count($aDoor);for($i=0; $i < $N; $i++){if($aDoor[$i] == 'F'){echo "checked='checked'";}}} ?>/>&nbsp;Father<br />
                                        <input type="checkbox" name="formDoor[]" value="M" <?php if(isset($_POST['formDoor'])){ $aDoor = $_POST['formDoor'];$N = count($aDoor);for($i=0; $i < $N; $i++){if($aDoor[$i] == 'M'){echo "checked='checked'";}}} ?>/>&nbsp;Mother<br />
                                        <input type="checkbox" name="formDoor[]" value="GFFS" <?php if(isset($_POST['formDoor'])){ $aDoor = $_POST['formDoor'];$N = count($aDoor);for($i=0; $i < $N; $i++){if($aDoor[$i] == 'GFFS'){echo "checked='checked'";}}} ?> />&nbsp;Paternal GrandFather<br />
                                        <input type="checkbox" name="formDoor[]" value="GMFS" <?php if(isset($_POST['formDoor'])){ $aDoor = $_POST['formDoor'];$N = count($aDoor);for($i=0; $i < $N; $i++){if($aDoor[$i] == 'GMFS'){echo "checked='checked'";}}} ?>/>&nbsp;Paternal GrandMother<br />
                                        <input type="checkbox" name="formDoor[]" value="GFMS" <?php if(isset($_POST['formDoor'])){ $aDoor = $_POST['formDoor'];$N = count($aDoor);for($i=0; $i < $N; $i++){if($aDoor[$i] == 'GFMS'){echo "checked='checked'";}}} ?> />&nbsp;Maternal GrandFather<br />
                                        <input type="checkbox" name="formDoor[]" value="GMMS" <?php if(isset($_POST['formDoor'])){ $aDoor = $_POST['formDoor'];$N = count($aDoor);for($i=0; $i < $N; $i++){if($aDoor[$i] == 'GMMS'){echo "checked='checked'";}}} ?>/>&nbsp;Maternal GrandMother<br />
                                        
                                        
                                        
                                        
                                        <br>
                                <input type="submit" id="submitval" name="submitval" value="SUBMIT">
                              </form>
                              <br><br>
                              
                              
                              		</div>
                                    <br><br>
                             
                            
                              
                              <div>
                               <?php 
								include 'connection.php';
							
								$unionAllOption = 0;
			//starting query
			$querytest ="";
			
		
		    if (!empty($_POST['formDoor'])){
				$querytest .= "select x , COUNT( * )  from(";
				$aDoor = $_POST['formDoor'];
				$N = count($aDoor);
				for($i=0; $i < $N; $i++){
					if($aDoor[$i] == 'S'){
						$querytest .= " select `studentbirthplace` as x from studentbirthdetails where studentemailid IN(SELECT studentemailid FROM student where schoolid='".$schoolId."'  AND classname='".$className."')";
						$unionAllOption = 1;
					}
					if($aDoor[$i] == 'F'){
						if($unionAllOption==1){$querytest .= " UNION ALL";}
						$querytest .= " select `studentfatherbirthplace` as x from studentbirthdetails  where studentemailid IN(SELECT studentemailid FROM student where schoolid='".$schoolId."'  AND classname='".$className."')";
						$unionAllOption = 1;
					}
					if($aDoor[$i] == 'M'){
						if($unionAllOption==1){$querytest .= " UNION ALL";}
						$querytest .= " select `studentmotherbirthplace` as x from studentbirthdetails  where studentemailid IN(SELECT studentemailid FROM student where schoolid='".$schoolId."'  AND classname='".$className."')";
						$unionAllOption = 1;
					}
					if($aDoor[$i] == 'GFFS'){
						if($unionAllOption==1){$querytest .= " UNION ALL";}
						$querytest .= " select `studentfathersfatherbirthplace` as x from studentbirthdetails  where studentemailid IN(SELECT studentemailid FROM student where schoolid='".$schoolId."'  AND classname='".$className."')";
						$unionAllOption = 1;
					}
					if($aDoor[$i] == 'GMFS'){
						if($unionAllOption==1){$querytest .= " UNION ALL";}
						$querytest .= " select `studentfathersmotherbirthplace` as x from studentbirthdetails  where studentemailid IN(SELECT studentemailid FROM student where schoolid='".$schoolId."'  AND classname='".$className."')";
						$unionAllOption = 1;
					}
					if($aDoor[$i] == 'GFMS'){
						if($unionAllOption==1){$querytest .= " UNION ALL";}
						$querytest .= " select `studentmothersfatherbirthplace` as x from studentbirthdetails  where studentemailid IN(SELECT studentemailid FROM student where schoolid='".$schoolId."'  AND classname='".$className."')";
						$unionAllOption = 1;
					}
					if($aDoor[$i] == 'GMMS'){
						if($unionAllOption==1){$querytest .= " UNION ALL";}
						$querytest .= " select `studentmothersmotherbirthplace` as x from studentbirthdetails  where studentemailid IN(SELECT studentemailid FROM student where schoolid='".$schoolId."'  AND classname='".$className."')";
						$unionAllOption = 1;
					}
				}
				
				$querytest .= " ) as temptable group by x";
			  }
		
		    // Default values goes here
			if($querytest==""){
				
				$querytest = "select x , COUNT( * )  from( select `studentbirthplace` as x from studentbirthdetails where studentemailid IN(SELECT studentemailid FROM student where schoolid='".$schoolId."'  AND classname='".$className."') ) as temptable group by x";
				}
			
			
			
								
							$result = mysql_query($querytest);
								while($row = mysql_fetch_assoc($result)) { 
									echo "<b>";
									echo $row['x'];
									echo ": </b>&nbsp;"; 
									echo $row['COUNT( * )'];
									echo "<br/>"; 
									} ?>
                              
                              </div>
                              </div>
                         </div>

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
<script type="text/javascript">
  
		  function activaTab(tabID){
			$('.nav-tabs a[href="#' + tabID + '"]').tab('show');
		};
		
  </script>
</body>
</html>


<?php

if (isset($_GET['logoutreq'])) {
	
	session_destroy();
	//header('Location:index.php');
	header('Location:www.ancestryatlas.com');
}



if(!isset($_SESSION['admin'])){
	
	
	header('Location:index.php');
}


?>

<?php

if(isset($_POST['submitval'])){
	
	//$rr = $_REQUEST['qw'];
	$currentClassName = $_POST['classnamedropdown'];
	echo '<script>activaTab("maps");</script>';
	$className = $_POST['classnamedropdown'];
	
	
	
}
if(isset($_POST['submitvalstutab'])){
	
	
	$currentClassName = $_POST['classnamedropdownstutab'];
	$className = $_POST['classnamedropdownstutab'];
	echo '<script>activaTab("students");</script>';
	
	
}

if(isset($_POST['submitvallantab'])){
	
	
	$currentClassName = $_POST['classnamedropdownlantab'];
	$className = $_POST['classnamedropdownlantab'];
	echo '<script>activaTab("language");</script>';
	
	
}
if(isset($_POST['submitvalbeltab'])){
	
	
	$currentClassName = $_POST['classnamedropdownbeltab'];
	$className = $_POST['classnamedropdownbeltab'];
	echo '<script>activaTab("religion");</script>';
	
	
}

?>



