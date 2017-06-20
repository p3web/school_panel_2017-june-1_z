<?php
ob_start();
session_cache_expire();
session_start();
?>
<?php
	$adminid = $_SESSION['emailid']; 

		include 'connection.php';
		
		
		$queryp = "select * from teacher where 	teacheremailid = '".$adminid."'";
		
		$resultp = mysql_query($queryp);
		$adminName = "";
		$schoolId = "";
		while ($rowp = mysql_fetch_array($resultp)){
			
			$adminName = $rowp["firstname"]." ".$rowp["lastname"];
			
			$schoolId = $rowp["schoolid"];
		}
		
		
		
		
		//school details
		$queryp = "select * from school where 	schoolid = '".$schoolId."'";
		$resultp = mysql_query($queryp);
		$schoolName = $city = $suburb = "";
		
		while ($rowp = mysql_fetch_array($resultp)){
			
			
			$schoolName = $rowp["schoolname"];
			$city = $rowp["city"];
			$suburb = $rowp["suburb"];
			
		}
		
		//class details
		$query = "select classname from classteacher where schoolid = '".$schoolId."' AND teacheremailid = '".$adminid."'";
		$result = mysql_query($query);
		$className = "";
		
		//while ($rowp = mysql_fetch_array($result)){
			//$className = $rowp["classname"];
		//}
		
		//Select only first class
		$rowp = mysql_fetch_array($result);
			$className = $rowp["classname"];
		
		
		mysql_close($con);



?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Teacher Panel</title>
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
	  
	  // Draw the donut chart .
      google.charts.setOnLoadCallback(drawLanguageChart);
	
	//Draw religion bar chart
	google.charts.setOnLoadCallback(drawReligionChart);
	
	
    function drawReligionChart() {
      var data = google.visualization.arrayToDataTable([
        ["Religion", "NumberOfStudent" ],
		 <?php 
			include 'connection.php';
			
			  if (!empty($_POST['classnamedropdownbeltab']))
			  {
				$className= $_POST['classnamedropdownbeltab'];
			  }
			
			$result = mysql_query("SELECT religion, COUNT( religion ) FROM student where schoolid='".$schoolId."' AND classname='".$className."' AND status='active' GROUP BY religion");
			
			
			while($row = mysql_fetch_assoc($result)) { 
			
			?> 
			['<?php echo $row['religion']; ?>',<?php echo $row['COUNT( religion )']; ?>], 
			
			
			<?php  } ?>
        
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" }
                       ]);

      var options = {
        title: "",
        width: 600,
        height: 400,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
		backgroundColor: { fill:'transparent' }
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("barchart_values"));
      chart.draw(view, options);
  }
	  

	


	  
	  
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
	  
//function to draw language chart	
var languagechart;  
function drawLanguageChart() {
		
		var data = google.visualization.arrayToDataTable([
          ['Language', 'NumberOfStudent'],
          
		  
		  <?php 
			include 'connection.php';
			
			if (!empty($_POST['classnamedropdownlantab']))
			  {
				$className= $_POST['classnamedropdownlantab'];
			  }
	
			$result = mysql_query("SELECT languagename, COUNT( languagename ) FROM studentlanguage where studentemailid IN(SELECT studentemailid FROM student where schoolid='".$schoolId."' AND classname='".$className."') GROUP BY languagename");
			
			
			while($row = mysql_fetch_assoc($result)) { 
			
			?> 
			['<?php echo $row['languagename']; ?>',<?php echo $row['COUNT( languagename )']; ?>], 
			
			
			<?php  } ?>
			
			
			
		  
        ]);

        var options = {
          
          pieHole: 0.4,
		  width: '900',
		  height:'500',
		  backgroundColor: { fill:'transparent' }
        };

        languagechart = new google.visualization.PieChart(document.getElementById('languagechart'));
        languagechart.draw(data, options);
      }




    </script>
</head>
<body id="adminpanel">

<?php 

$currentClassName='';
if(isset($_POST['classnamedropdown'])){ $currentClassName = $_POST['classnamedropdown']; } 
 ?>

<?php
$combineErr="";
	$emailErr = "";
	$email = $name = "";
	
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

	
	
	
	
	
					
	//EVERTHING IS OK NOW
	 if((empty($emailErr))){
		 
		   
		 
		  
		  if($name == ""){
			  $name="NULL";
			  }
		  
		  
		
        		
			$bytes = openssl_random_pseudo_bytes(32);
			$token = bin2hex($bytes);
				
				include 'connection.php';
				
				if(!mysql_query("insert into student(studentemailid, schoolid, classname, firstname, token, status) values('$email','$schoolId','$className','$name','$token','pending')",$con)){
						
						die("ERROR: Data not inserted".mysql_error());
					}
				else{
					
					
				
				
				
				
				
				
								require("/home/ancestryatlas/public_html/phpmailertesting/PHPMailer_5.2.0/class.phpmailer.php");
						
									$mail = new PHPMailer();
									
									$mail->IsSMTP();                                      // set mailer to use SMTP
									$mail->Host = "localhost";  // specify main and backup server
									$mail->SMTPAuth = true;     // turn on SMTP authentication
									$mail->Username = "test@ancestryatlas.com";  // SMTP username
									$mail->Password = "Password456!"; // SMTP password
									
									$mail->From = "test@ancestryatlas.com";
									$mail->FromName = "Ancestry atlas";
									
									$mail->Timeout = 120;
									
									//to whom you want to send an email
									$mail->AddAddress($email);                  // name is optional
									
									                                // set word wrap to 50 characters
									$mail->IsHTML(true);                                  // set email format to HTML
									
								
									$mail->Subject = "Signup | Verification";
									$mail->Body    = "Student Registration <br> Thanks for signing up with cultural infusion!<br>
									Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.
									<br>------------------------
									<br>Username: ".$email." 
									<br>------------------------
									<br>Please click this link to activate your account:
									<br><br>http://www.ancestryatlas.com/verifystudent.php?email=".$email."&token=".$token."
									<br><br> From: Ancestry Atlas
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
										echo 'window.location.href = "teacherpanel.php";';  
										echo '</script>'; 
									   exit;
									}else{
									
									
										echo '<script type="text/javascript">'; 
										echo 'alert("Email sent Successful, student can check their email and fill data.");'; 
										echo 'window.location.href = "teacherpanel.php";';
										echo '</script>';
									
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
            <?php include 'headerteacher.php';?>
            
            
            <div class="row" >
                
                <div class="col-sm-1">
                </div>
                
                <div class="col-sm-10" style="margin-top:2em;">
                   <div class="col-sm-12">  
                     	<div class="col-sm-6">
                         	<h2>Welcome to your Ancestry Atlas</h2>
                             <h5>Teacher -> &nbsp;<b><?php echo $adminName; ?></b></h5> 
                             
                             <!--
                             <p style="margin-top:1.5em;">As a teacher, you can now invite your students to register for Ancestry Atlas. <br>
							
				Track student registration below.<br>
				Preview your diversity maps at anytime 
				
				-->
			</p>
                         </div>
                     
                     	<div class="col-sm-6 text-right">                     
                         	<h2><?php echo $schoolName; ?></h2>
                         	<h5><?php echo $city." / ".$suburb; ?></h5>
                       </div>
                       
                       <div class="col-sm-12" style="margin-top:2em;">
                           <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#students">Students</a></li>
                            <li><a data-toggle="tab" href="#maps">Maps</a></li>
                            <li><a data-toggle="tab" href="#language">Language</a></li>
                            <li><a data-toggle="tab" href="#religion">Belief</a></li>
                            <li><a data-toggle="tab" href="#lessonplans">Lesson Plans</a></li>
                          </ul>
                        
                          <div class="tab-content">
                            <div id="students" class="tab-pane fade in active">
                             <br><br>
                              
                              
                             
                              <form method="post">
							  <?php 
							  
							  if (!empty($_POST['classnamedropdownstutab']))
							  {
								$className= $_POST['classnamedropdownstutab'];
								$currentClassName = $_POST['classnamedropdownstutab'];
							  }
							  		include 'connection.php';
							        $queryp = "select classname from classteacher where teacheremailid = '".$adminid."' AND schoolid = '".$schoolId."'";
									$resultp = mysql_query($queryp);
									echo "Class Name: ";
									echo '<select name="classnamedropdownstutab" >';
									while ($rowp = mysql_fetch_array($resultp)){
										$selected = ($rowp['classname'] == $currentClassName) ? 'selected="selected"' : '';
										echo '<option value="'.$rowp['classname'].'"'.$selected.' >'.$rowp['classname'].'</option>';
									}
									 echo '</select>';// Close your drop down box
							  		mysql_close($con);
									 ?>
									<input type="submit" id="submitvalstutab" name="submitvalstutab" value="SUBMIT">
									
									


							 
                              </form>
                              <br><br>
                              <?php
							  
							  		include 'connection.php';
									
									$queryteachers = "select * from student where schoolid = '".$schoolId."' AND classname = '".$className."'" ;
									$resultteachers = mysql_query($queryteachers);
									if($resultteachers == TRUE){
										$j=1;
										$k=1;
										echo "<table style='width:100%;' border='1'>";
										echo "<tr>";
										echo "<th>Student Name</th>";
										echo "<th>Email Id</th>";
										echo "<th>Religion</th>";
										echo "<th>Student Birthplace</th>";
										echo "<th>Father Birthplace</th>";
										echo "<th>Mother Birthplace</th>";
										echo "<th>Grandfather (Father) Birthplace</th>";
										echo "<th>Grandmother (Father) Birthplace</th>";
										echo "<th>Grandfather (Mother) Birthplace</th>";
										echo "<th>Grandmother (Mother)Birthplace</th>";
										echo "<th>Status</th>";
										echo "</tr>";
										
										while ($rowj=mysql_fetch_array($resultteachers)){
											$studentNameTemp = "";
											if($rowj['firstname'] == "NULL"){
												$studentNameTemp = "Waiting acceptance";
											}else{
												$studentNameTemp =	$rowj['firstname'];	
											}
											echo "<tr>";
											echo "<td style='padding:1%;'>";
											echo "<span style='padding:0.7%;' id='j".$j."' >".$studentNameTemp." ".$rowj['lastname']."</span>&nbsp;&nbsp;&nbsp;";
											$j = ++$j;
											$k = ++$k;
											echo "</td>";
											
											echo "<td  style='padding:1%;'>";
											echo "<span>".$rowj['studentemailid']."</span>";
											echo "</td>";
											
											echo "<td  style='padding:1%;'>";
											$religion="";
											if($rowj['religion'] == "" or $rowj['religion'] == "NULL"){
												echo "<span> Waiting acceptance</span>";
											}else{
											
											echo "<span>".$rowj['religion']."</span>";
											}
											echo "</td>";
											
											
											
											
											$query = "select * from studentbirthdetails where studentemailid = '".$rowj['studentemailid']."' ";
											$result = mysql_query($query);
											$birthplace = $father = $mother = $grandfatherfatherside = $grandmotherfatherside = $grandfathermotherside = $grandmothermotherside="";
											
											while ($rowp = mysql_fetch_array($result)){
												$birthplace = $rowp["studentbirthplace"];
												$father = $rowp["studentfatherbirthplace"];
												$mother= $rowp["studentmotherbirthplace"];
												$grandfatherfatherside= $rowp["studentfathersfatherbirthplace"];
												$grandmotherfatherside= $rowp["studentmothersfatherbirthplace"];
												$grandfathermotherside= $rowp["studentfathersmotherbirthplace"];
												$grandmothermotherside= $rowp["studentmothersmotherbirthplace"];
												
												
												
											}
											if($birthplace == ""){$birthplace="Waiting acceptance";}
											if($father == ""){$father="Waiting acceptance";}
											if($mother == ""){$mother="Waiting acceptance";}
											if($grandfatherfatherside == ""){$grandfatherfatherside="Waiting acceptance";}
											if($grandmotherfatherside == ""){$grandmotherfatherside="Waiting acceptance";}
											if( $grandfathermotherside== ""){$grandfathermotherside="Waiting acceptance";}
											if($grandmothermotherside == ""){$grandmothermotherside="Waiting acceptance";}
											
											
											
											echo "<td  style='padding:1%;'>";
											echo "<span>".$birthplace."</span>";
											echo "</td>";
											
											echo "<td  style='padding:1%;'>";
											echo "<span>".$father."</span>";
											echo "</td>";
											
											echo "<td  style='padding:1%;'>";
											echo "<span>".$mother."</span>";
											echo "</td>";
											
											echo "<td  style='padding:1%;'>";
											echo "<span>".$grandfatherfatherside."</span>";
											echo "</td>";
											
											echo "<td  style='padding:1%;'>";
											echo "<span>".$grandmotherfatherside."</span>";
											echo "</td>";
											
											echo "<td  style='padding:1%;'>";
											echo "<span>".$grandfathermotherside."</span>";
											echo "</td>";
											
											echo "<td  style='padding:1%;'>";
											echo "<span>".$grandmothermotherside."</span>";
											echo "</td>";
											
											echo "<td  style='padding:1%;'>";
											echo "<span>".$rowj['status']."</span>";
											echo "</td>";
											echo "</tr>";
										}
										?>
                                        <form method="post">
										<tr style="background-color:#CCC;">
                                        <td><input type="text" class="form-control" name="name" id="name" placeholder="Waiting student" value="<?php echo $name; ?>" > 
                                        </td>
                                        <td><input type="email" class="form-control" id="email" name="email" placeholder="Click here to add email address" value="<?php echo $email; ?>" >
                                        </td>
                                        <td>Religion</td>
                                        <td>Student</td>
                                        <td>Father</td>
                                        <td>Mother</td>
                                        <td>grandfather (father)</td>
                                        <td>grandmother (father)</td>
                                        <td>grandfather (mother)</td>
                                        <td>grandfather (mother)</td>
                                        
                                        <td><button type="submit" class="btn btn-default" name="invite" id="invite" title="INVITE">INVITE</button></td>
                                        </tr>
                                        </form>
										<?php
										echo "</table>";
									}else{
										echo "data fetching fail from teacher table.";
									}
												  
                            ?>
                            
                            <span style="clear:both; float:left; margin-left:3em;" id="error"><?php 
                                    echo $combineErr;
									
								?></span>
                            
                      
                            
                            
                            </div>
                            
                            <div id="maps" class="tab-pane fade">
                              <br>
                          <div>
                              <div id="regions_div" style="width:900px; height: 500px; float:left;"></div>
                               
                               <div style="float:right;">
                               
                               		<div>
                               <form method="post">
                              
                              <?php 
							  		include 'connection.php';
							        $queryp = "select classname from classteacher where teacheremailid = '".$adminid."' AND schoolid = '".$schoolId."'";
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
                                        <input type="checkbox" name="formDoor[]" value="GFFS" <?php if(isset($_POST['formDoor'])){ $aDoor = $_POST['formDoor'];$N = count($aDoor);for($i=0; $i < $N; $i++){if($aDoor[$i] == 'GFFS'){echo "checked='checked'";}}} ?> />&nbsp;GrandFather<br />
                                        <input type="checkbox" name="formDoor[]" value="GMFS" <?php if(isset($_POST['formDoor'])){ $aDoor = $_POST['formDoor'];$N = count($aDoor);for($i=0; $i < $N; $i++){if($aDoor[$i] == 'GMFS'){echo "checked='checked'";}}} ?>/>&nbsp;GrandMother<br />
                                        <input type="checkbox" name="formDoor[]" value="GFMS" <?php if(isset($_POST['formDoor'])){ $aDoor = $_POST['formDoor'];$N = count($aDoor);for($i=0; $i < $N; $i++){if($aDoor[$i] == 'GFMS'){echo "checked='checked'";}}} ?> />&nbsp;GrandFather<br />
                                        <input type="checkbox" name="formDoor[]" value="GMMS" <?php if(isset($_POST['formDoor'])){ $aDoor = $_POST['formDoor'];$N = count($aDoor);for($i=0; $i < $N; $i++){if($aDoor[$i] == 'GMMS'){echo "checked='checked'";}}} ?>/>&nbsp;GrandMother<br />
                                        
                                        
                                        
                                        
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
                            
                            <div id="language" class="tab-pane fade">
                              <h3>Language Map</h3>
                              <br>
                              <form method="post">
							  <?php 
							  
							  if (!empty($_POST['classnamedropdownlantab']))
							  {
								$className= $_POST['classnamedropdownlantab'];
								$currentClassName = $_POST['classnamedropdownlantab'];
							  }
							  		include 'connection.php';
							        $queryp = "select classname from classteacher where teacheremailid = '".$adminid."' AND schoolid = '".$schoolId."'";
									$resultp = mysql_query($queryp);
									echo "Class Name: ";
									echo '<select name="classnamedropdownlantab" >';
									while ($rowp = mysql_fetch_array($resultp)){
										$selected = ($rowp['classname'] == $currentClassName) ? 'selected="selected"' : '';
										echo '<option value="'.$rowp['classname'].'"'.$selected.' >'.$rowp['classname'].'</option>';
									}
									 echo '</select>';// Close your drop down box
							  		mysql_close($con);
									 ?>
									<input type="submit" id="submitvallantab" name="submitvallantab" value="SUBMIT">
									
									


							 
                              </form>
                              
                              
                              
                              
                              &nbsp;&nbsp;<br><br>
                              <div class="btn-group">
                                      <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" style="width:10em;" aria-expanded="false" id="genderbtn" name="genderbtn">
                                                    Select Gender <span class="caret"></span>
                                       </button>
                                       <ul class="dropdown-menu" role="menu">
                                          <li><a class="all-btn">All</a></li>
                                          <li><a class="male-btn">Male</a></li>
                                          <li><a class="female-btn">Female</a></li>
                                          <li><a class="others-btn">Others</a></li>
                                       </ul>
                            </div>
																  
                                          
                                          
                                          
                                          
                                          
                                          
                              
                               
                              
                              <br><br>
                              
                         
                               <div id="languagechart" style="width:100%; height:auto;"> 
                               </div>
                               <div id="languagetext">
                               <?php
                                include 'connection.php';
								
								$result = mysql_query("SELECT languagename, COUNT( languagename ) FROM studentlanguage where studentemailid IN(SELECT studentemailid FROM student where schoolid='".$schoolId."' AND classname='".$className."' ) GROUP BY languagename "); 
								
							

								
								
								while($row = mysql_fetch_assoc($result)) { 
									echo "<b>";
									echo $row['languagename'];
									echo ": </b>&nbsp;"; 
									echo $row['COUNT( languagename )'];
									echo "<br/>"; 
									} mysql_close($con);?>
                              </div>
                            
                            </div>

                            
                            <div id="religion" class="tab-pane fade">
                              <h3>Belief Bar Chart</h3>
                              <br>
                              <form method="post">
							  <?php 
							  
							  if (!empty($_POST['classnamedropdownbeltab']))
							  {
								$className= $_POST['classnamedropdownbeltab'];
								$currentClassName = $_POST['classnamedropdownbeltab'];
							  }
							  		include 'connection.php';
							        $queryp = "select classname from classteacher where teacheremailid = '".$adminid."' AND schoolid = '".$schoolId."'";
									$resultp = mysql_query($queryp);
									echo "Class Name: ";
									echo '<select name="classnamedropdownbeltab" >';
									while ($rowp = mysql_fetch_array($resultp)){
										$selected = ($rowp['classname'] == $currentClassName) ? 'selected="selected"' : '';
										echo '<option value="'.$rowp['classname'].'"'.$selected.' >'.$rowp['classname'].'</option>';
									}
									 echo '</select>';// Close your drop down box
							  		mysql_close($con);
									 ?>
									<input type="submit" id="submitvalbeltab" name="submitvalbeltab" value="SUBMIT">
									
									


							 
                              </form>
                               <div id="barchart_values" style="width: 900px; height: 300px; clear:both; height:auto;"></div>
                              <div style="clear:both;">
                               <?php 
									include 'connection.php';
									
									$result = mysql_query("SELECT religion, COUNT( religion ) FROM student where schoolid='".$schoolId."' AND classname='".$className."' AND status='active' GROUP BY religion");
								
			
									
									
									while($row = mysql_fetch_assoc($result)) { 
										echo "<b>";
										echo $row['religion'];
										echo ": </b>&nbsp;"; 
										echo $row['COUNT( religion )'];
										echo "<br/>"; 
										} ?>
                             
                              </div>
                            
                            </div>

                            
                            
                            
                            <div id="lessonplans" class="tab-pane fade">
                             
                              <br>
                                <ul style="list-style-image:url(images/lessonplanicon.png);">
									<li><a href="lessonplans/UNIT 1.pdf" target="_blank" style="color:#000;">Unit 1 - Level 3</a></li><br>
                                    <li><a href="lessonplans/UNIT 2.pdf" target="_blank" style="color:#000;">Unit 2 - Level 4</a></li><br>
                                    <li><a href="lessonplans/UNIT 3.pdf" target="_blank" style="color:#000;">Unit 3 - Level 5/6</a></li><br>
                                    <li><a href="lessonplans/UNIT 4.pdf" target="_blank" style="color:#000;">Unit 4 - Level All</a></li><br>                              
                              	</ul>
                            </div>

                            
                            
                            
                            
                            
			
			
			
			
			
                            
                          </div>
                       </div>
                       
                       
                       
                   </div>
                   
                     
                </div>
                
                <div class="col-sm-1">
                </div>
                
           </div>
        </div>
         
    </div>
  
            
            

<?php 
include 'footerteacher.php';
?>
<script type="text/javascript">
  
		  function activaTab(tabID){
			$('.nav-tabs a[href="#' + tabID + '"]').tab('show');
		};
		
  </script>
</body>
</html>


<?php

if (isset($_GET['logoutrequest'])) {
	
	session_destroy();
	header('Location:index.php');
	
}



if(!isset($_SESSION['teacher'])){
	
	
	header('Location:index.php');
}


?>
 <script type="text/javascript">
										  
	$(document).ready(function(){
		
		//ALL OPTION
		$(".all-btn").click(function(){
			
			$("#genderbtn").html("All&nbsp;<span class='caret'></span>");
			var data = google.visualization.arrayToDataTable([
			  ['Language', 'NumberOfStudent'],
			  
			  
			  <?php 
				include 'connection.php';
				
				
				$result = mysql_query("SELECT languagename, COUNT( languagename ) FROM studentlanguage where studentemailid IN(SELECT studentemailid FROM student where schoolid='".$schoolId."' AND classname='".$className."' ) GROUP BY languagename");
				
				
				while($row = mysql_fetch_assoc($result)) { 
				
				?> 
				['<?php echo $row['languagename']; ?>',<?php echo $row['COUNT( languagename )']; ?>], 
				
				
				<?php  }
				
				mysql_close($con);
				 ?>
				
				
				
			  
			]);
	
			var options = {
			  
			  pieHole: 0.4,
			  width: '900',
			  height:'500',
			  backgroundColor: { fill:'transparent' }
			};    
			languagechart.draw(data, options);
			
			
			$("#languagetext").html("<?php 
								include 'connection.php';
								
								$result = mysql_query("SELECT languagename, COUNT( languagename ) FROM studentlanguage where studentemailid IN(SELECT studentemailid FROM student where schoolid='".$schoolId."' AND classname='".$className."') GROUP BY languagename"); 
								
							

								
								
								while($row = mysql_fetch_assoc($result)) { 
									echo "<b>";
									echo $row['languagename'];
									echo ": </b>&nbsp;"; 
									echo $row['COUNT( languagename )'];
									echo "<br/>"; 
									} mysql_close($con);?>");
		
		});
		
		
		
		
		//MALE OPTION
		$(".male-btn").click(function(){
			$("#genderbtn").html("Male&nbsp;<span class='caret'></span>");
			var data = google.visualization.arrayToDataTable([
			  ['Language', 'NumberOfStudent'],
			  
			  
			  <?php 
				include 'connection.php';
				$gen="male";
				
				$result = mysql_query("SELECT languagename, COUNT( languagename ) FROM studentlanguage where studentemailid IN(SELECT studentemailid FROM student where schoolid='".$schoolId."' AND classname='".$className."' AND gender='".$gen."') GROUP BY languagename");
				
				
				while($row = mysql_fetch_assoc($result)) { 
				
				?> 
				['<?php echo $row['languagename']; ?>',<?php echo $row['COUNT( languagename )']; ?>], 
				
				
				<?php  } mysql_close($con);?>
				
				
				
			  
			]);
	
			var options = {
			  
			  pieHole: 0.4,
			  width: '900',
			  height:'500',
			  backgroundColor: { fill:'transparent' }
			};    
			languagechart.draw(data, options);
			
			$("#languagetext").html("<?php 
								include 'connection.php';
								
								$result = mysql_query("SELECT languagename, COUNT( languagename ) FROM studentlanguage where studentemailid IN(SELECT studentemailid FROM student where schoolid='".$schoolId."' AND classname='".$className."' AND gender='".$gen."') GROUP BY languagename"); 
								
							

								
								
								while($row = mysql_fetch_assoc($result)) { 
									echo "<b>";
									echo $row['languagename'];
									echo ": </b>&nbsp;"; 
									echo $row['COUNT( languagename )'];
									echo "<br/>"; 
									} mysql_close($con);?>");
		
		});
		
		
	
		
		
		// FEMALE OPTION
		$(".female-btn").click(function(){
			
			$("#genderbtn").html("Female&nbsp;<span class='caret'></span>");
			var data = google.visualization.arrayToDataTable([
			  ['Language', 'NumberOfStudent'],
			  
			  
			  <?php 
				include 'connection.php';
				$gen="female";
				
				$result = mysql_query("SELECT languagename, COUNT( languagename ) FROM studentlanguage where studentemailid IN(SELECT studentemailid FROM student where schoolid='".$schoolId."' AND classname='".$className."' AND gender='".$gen."') GROUP BY languagename");
				
				
				while($row = mysql_fetch_assoc($result)) { 
				
				?> 
				['<?php echo $row['languagename']; ?>',<?php echo $row['COUNT( languagename )']; ?>], 
				
				
				<?php  }mysql_close($con); ?>
				
				
				
			  
			]);
	
			var options = {
			  
			  pieHole: 0.4,
			  width: '900',
			  height:'500',
			  backgroundColor: { fill:'transparent' }
			};    
			languagechart.draw(data, options);
			$("#languagetext").html("<?php 
								include 'connection.php';
								
								$result = mysql_query("SELECT languagename, COUNT( languagename ) FROM studentlanguage where studentemailid IN(SELECT studentemailid FROM student where schoolid='".$schoolId."' AND classname='".$className."' AND gender='".$gen."') GROUP BY languagename"); 
								
							

								
								
								while($row = mysql_fetch_assoc($result)) { 
									echo "<b>";
									echo $row['languagename'];
									echo ": </b>&nbsp;"; 
									echo $row['COUNT( languagename )'];
									echo "<br/>"; 
									} mysql_close($con);?>");
		
		});
	
				
				
	    //OTHER OPTION
		$(".others-btn").click(function(){
			
			$("#genderbtn").html("Others&nbsp;<span class='caret'></span>");
			var data = google.visualization.arrayToDataTable([
			  ['Language', 'NumberOfStudent'],
			  
			  
			  <?php 
				include 'connection.php';
				$gen="others";
				
				$result = mysql_query("SELECT languagename, COUNT( languagename ) FROM studentlanguage where studentemailid IN(SELECT studentemailid FROM student where schoolid='".$schoolId."' AND classname='".$className."' AND gender='".$gen."') GROUP BY languagename");
				
				
				while($row = mysql_fetch_assoc($result)) { 
				
				?> 
				['<?php echo $row['languagename']; ?>',<?php echo $row['COUNT( languagename )']; ?>], 
				
				
				<?php  } mysql_close($con);?>
				
				
				
			  
			]);
	
			var options = {
			  
			  pieHole: 0.4,
			  width: '900',
			  height:'500',
			  backgroundColor: { fill:'transparent' }
			};    
			languagechart.draw(data, options);
			
		$("#languagetext").html("<?php 
								include 'connection.php';
								
								$result = mysql_query("SELECT languagename, COUNT( languagename ) FROM studentlanguage where studentemailid IN(SELECT studentemailid FROM student where schoolid='".$schoolId."' AND classname='".$className."' AND gender='".$gen."') GROUP BY languagename"); 
								
							

								
								
								while($row = mysql_fetch_assoc($result)) { 
									echo "<b>";
									echo $row['languagename'];
									echo ": </b>&nbsp;"; 
									echo $row['COUNT( languagename )'];
									echo "<br/>"; 
									} mysql_close($con);?>");
		});
		
							
		
		
	});
																											  
                                          
   
 </script>        
                                          
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


