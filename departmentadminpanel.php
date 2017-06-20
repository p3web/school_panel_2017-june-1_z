<?php
ob_start();
session_cache_expire();
session_start();
?>
<?php
	$adminid = $_SESSION['deptemailidorg']; 

		include 'connection.php';
		
		
		$queryp = "select * from deptadmin where deptemailid = '".$adminid."'";
		
		$resultp = mysql_query($queryp);
		$adminName = "";
		$orgId = "";
		while ($rowp = mysql_fetch_array($resultp)){
			
			$adminName = $rowp["firstname"]." ".$rowp["lastname"];
			
			$orgId = $rowp["orgid"];
		}
		
		
		
		
		//organisation details
		$queryp = "select * from organisationadmin where orgid = '".$orgId."'";
		$resultp = mysql_query($queryp);
		$orgName = $city = $suburb = "";
		
		while ($rowp = mysql_fetch_array($resultp)){
			
			
			$orgName = $rowp["orgname"];
			$city = $rowp["city"];
			$suburb = $rowp["suburb"];
			
		}
		
		//Department details
		$query = "select deptname from orgdeptdetail where orgid = '".$orgId."' AND deptemailid = '".$adminid."'";
		$result = mysql_query($query);
		$deptName = "";
		
		//while ($rowp = mysql_fetch_array($result)){
			//$className = $rowp["classname"];
		//}
		
		//Select only first class
		$rowp = mysql_fetch_array($result);
			$deptName = $rowp["deptname"];
		
		
		mysql_close($con);



?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Department Admin Panel</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
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
	
	
	$(window).resize(function(){	
		drawRegionsMap();
		drawLanguageChart();
		drawReligionChart();
		
	});
	
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
        //width: 600,
        width: "55%",
        height: "55%",
        //height: 400,
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
			//width: 900,
			//height: 500,
			width: "100%",
		    height:'500',
			backgroundColor: { fill:'transparent' }
			
			
		};

        var chart = new google.visualization.GeoChart(document.getElementById('regions_div'));
        
        
         // Wait for the chart to finish drawing before calling the getImageURI() method.
        google.visualization.events.addListener(chart, 'ready', function () {
       document.getElementById('png').outerHTML = '<a href="' + chart.getImageURI() + '">Printable version</a>';
       
      });


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
		  //width: '900',
		  width: "100%",
		  height:'500',
		  //height:'500',
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
	$emailErr = $nameErr= "";
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
			
				$dataMatched ="no";
				
				
				//Team admin email check
				$queryo = "select teamemailid from teamadmin";
				$resulto = mysql_query($queryo);
				
				while ($rowo=mysql_fetch_array($resulto))
				{
					if(strtolower($email) == strtolower($rowo["teamemailid"])){
						$dataMatched ="yes";
						$email = $rowo["teamemailid"];
						
						}
				
				}
				
				
				
				
				//organisation admin email check
				if($dataMatched == "no"){
					
					$queryo = "select orgadminemailid from organisationadmin";
					$resulto = mysql_query($queryo);
					
					
					
					while ($rowo=mysql_fetch_array($resulto))
					{
						if(strtolower($email) == strtolower($rowo["orgadminemailid"])){
							$dataMatched ="yes";
							$email = $rowo["orgadminemailid"];
							
							}
					
					}
				}
				
				//dept email check
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
				
				/// ADD LATERTRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRR       STAFF
				
				//School admin email check
				
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

	
	 
		//TEAM VALIDATION
	 if (empty($_POST["name"])) {
			$nameErr = "Team name is required";
			$combineErr = $combineErr."<br>".$nameErr;
			echo "<script type='text/javascript'>
				$(document).ready(function()
				{
					$('#name').css('background-color', '#ffb0b0');
				}); </script>";
	   }else{
		   
		$name = test_input($_POST["name"]);   
		
		
		
		include 'connection.php';
			
				//Team name check
				$queryt = "select teamname from orgteam where orgid='".$orgId."'";
				$resultt = mysql_query($queryt);
				
				$dataMatchedTeam = "no";
				while ($rowt=mysql_fetch_array($resultt))
				{
					
					
					if(strtolower($name) == strtolower($rowt["teamname"])){
						$dataMatchedTeam = "yes";
						$name = $rowt["teamname"];
						
						}
				
				}
				
				mysql_close($con);
				
				if( $dataMatchedTeam == "yes"){
					$nameErr = "Team Name already registered.";
					$combineErr = $combineErr."<br>".$nameErr;
					echo "<script type='text/javascript'>
						$(document).ready(function()
						{
							$('#name').css('background-color', '#ffb0b0');
						}); </script>";
				}	
		   
	   }
	
	
	
	
	
	
					
	//EVERTHING IS OK NOW
	 if((empty($emailErr) and empty($nameErr))){
		 
	
	
		    
        		
			$bytes = openssl_random_pseudo_bytes(32);
			$token = bin2hex($bytes);
			
			
					//Department Name
					$deptName = "";
					include 'connection.php';
					$querypp = "select * from orgdeptdetail where deptemailid = '".$adminid."' AND orgid = '".$orgId."'";
					$resultpp = mysql_query($querypp);
					while ($rowpp = mysql_fetch_array($resultpp)){
						$deptName = $rowpp['deptname'];
					}
					mysql_close($con);
			
				
				include 'connection.php';
				$allDataInsertedSuccessful = "no";
				if(!mysql_query("insert into teamadmin(teamemailid, orgid, deptname, token, status) values('$email','$orgId','$deptName','$token','pending')",$con)){
						$allDataInsertedSuccessful = "no";
						die("ERROR: Data not inserted".mysql_error());
					}
				else{
					if(!mysql_query("insert into orgteam(orgid, deptname, teamname) values('$orgId','$deptName','$name')",$con)){
						$allDataInsertedSuccessful = "no";
						die("ERROR: Data not inserted".mysql_error());
					}else{
							if(!mysql_query("insert into orgteamdetail(orgid, teamemailid, deptname, teamname) values('$orgId','$email','$deptName','$name')",$con)){
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
					            	$ccvv = emailbodydeptadmintoteamadmin($adminid,$email,$token);
						            $mail->Body    = "".$ccvv."";
									$mail->AltBody = "This is the body in plain text for non-HTML mail clients";
									
									if(!$mail->Send())
									{
										//echo "Message could not be sent. <p>";
										//echo "Mailer Error: " . $mail->ErrorInfo;
									   
										include 'connection.php';
										$query= "DELETE FROM teamadmin WHERE  teamemailid = '".$email."' ";
										$result = mysql_query($query);
										echo '<script type="text/javascript">'; 
										echo 'alert("Email Unsuccessful. please try again. or contact us  ");' ;
										echo 'window.location.href = "departmentadminpanel.php";';  
										echo '</script>'; 
									   exit;
									}else{
									
									
										echo '<script type="text/javascript">'; 
										echo 'alert("Email has been sent successfully.");'; 
										echo 'window.location.href = "departmentadminpanel.php";';
										echo '</script>';
									
									}
									
									
									
									
									
									
									
									
							}
					}
                
					if($allDataInsertedSuccessful == "no"){
						$query= "DELETE FROM orgteam WHERE orgid = '".$orgId."' and deptname='".$deptName."' and teamname='".$name."' ";
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
            <?php include 'headerteacher.php';?>
            
            
            <div class="row" >
                
                <div class="col-sm-1">
                </div>
                
                <div class="col-sm-10" style="margin-top:2em;">
                   <div class="col-sm-12">  
                     	<div class="col-sm-6">
                         	<h2>Welcome to your Ancestry Atlas</h2>
                             <h5>Department Admin -> &nbsp;<b><?php echo $adminName; ?></b></h5> 
                             <!--
                             <p style="margin-top:1.5em;">As a teacher, you can now invite your students to register for Ancestry Atlas. <br>
							
				Track student registration below.<br>
				Preview your diversity maps at anytime 
			</p>-->
                         </div>
                     
                     	<div class="col-sm-6 text-right">                     
                         	<h2><?php echo $orgName; ?></h2>
                         	<h5><?php echo $city." / ".$suburb; ?></h5>
                       </div>
                       
                       <div class="col-sm-12" style="margin-top:2em;">
                           <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#students">Team Admin</a></li>
                            <li><a data-toggle="tab" href="#maps">Maps</a></li>
                            <li><a data-toggle="tab" href="#language">Language</a></li>
                            <li><a data-toggle="tab" href="#religion">Belief</a></li>
                            <li><a data-toggle="tab" href="#export">Export</a></li>
                          </ul>
                        
                          <div class="tab-content">
                            <div id="students" class="tab-pane fade in active">
                             <br><br>
                              
                              
                             
                              <form method="post">
							  <?php 
							  
							  if (!empty($_POST['classnamedropdownstutab']))
							  {
							    $deptName = $_POST['classnamedropdownstutab'];
								$currentClassName = $_POST['classnamedropdownstutab'];
							  }
							  		include 'connection.php';
							        $queryp = "select deptname from orgdeptdetail where deptemailid = '".$adminid."' AND orgid = '".$orgId."'";
									$resultp = mysql_query($queryp);
									echo "Department Name: ";
									echo '<select name="classnamedropdownstutab" >';
									while ($rowp = mysql_fetch_array($resultp)){
										$selected = ($rowp['deptname'] == $currentClassName) ? 'selected="selected"' : '';
										echo '<option value="'.$rowp['deptname'].'"'.$selected.' >'.$rowp['deptname'].'</option>';
									}
									 echo '</select>';// Close your drop down box
							  		mysql_close($con);
									 ?>
									<input type="submit" id="submitvalstutab" name="submitvalstutab" value="SUBMIT">
									
									


							 
                              </form>
                              <br><br>
                              <?php
							  
							  		include 'connection.php';
									
									$queryteachers = "select * from teamadmin where orgid = '".$orgId."' AND deptname = '".$deptName."'" ;
									$resultteachers = mysql_query($queryteachers);
									if($resultteachers == TRUE){
										$j=1;
										$k=1;
										echo "<table class='table table-striped table-bordered' cellspacing='0' width='100%'>";
										echo "<thead>";
										echo "<tr>";
										echo "<th>Team Admin Email ID*</th>";
										echo "<th>Team Name*</th>";
										echo "<th>Belief</th>";
										echo "<th>Team Admin Birthplace</th>";
										echo "<th>Father Birthplace</th>";
										echo "<th>Mother Birthplace</th>";
										echo "<th>Grandfather (Father) Birthplace</th>";
										echo "<th>Grandmother (Father) Birthplace</th>";
										echo "<th>Grandfather (Mother) Birthplace</th>";
										echo "<th>Grandmother (Mother)Birthplace</th>";
										echo "<th>Status</th>";
										echo "</tr>";
										echo "</thead>";
										
										while ($rowj=mysql_fetch_array($resultteachers)){
											/*
											$studentNameTemp = "";
											if($rowj['firstname'] == "NULL"){
												$studentNameTemp = "Waiting acceptance";
											}else{
												$studentNameTemp =	$rowj['firstname'];	
											}*/
											echo "<tr>";
											/*
											echo "<td style='padding:1%;'>";
											echo "<span style='padding:0.7%;' id='j".$j."' >".$studentNameTemp." ".$rowj['lastname']."</span>&nbsp;&nbsp;&nbsp;";
											$j = ++$j;
											$k = ++$k;
											echo "</td>";
											*/
											
											echo "<td  style='padding:1%;'>";
											echo "<span>".$rowj['teamemailid']."</span>";
											echo "</td>";
											
											
											
											// TEAM NAME
											$queryrr = "select teamname from orgteamdetail where teamemailid = '".$rowj['teamemailid']."' ";
											$resultrr = mysql_query($queryrr);
											$individualTeamName = "";
											while ($rowrr = mysql_fetch_array($resultrr)){
												$individualTeamName = $rowrr["teamname"];
											}
											
											echo "<td  style='padding:1%;'>";
											echo "<span>".$individualTeamName."</span>";
											echo "</td>";
											
											
											
											//religion or belief
											echo "<td  style='padding:1%;'>";
											$religion="";
											if($rowj['religion'] == "" or $rowj['religion'] == "NULL"){
												echo "<span> Waiting acceptance</span>";
											}else{
											
											echo "<span>".$rowj['religion']."</span>";
											}
											echo "</td>";
											
											
											
											
											
											
											$query = "select * from teamadminbirthdetails where teamemailid = '".$rowj['teamemailid']."' ";
											$result = mysql_query($query);
											$birthplace = $father = $mother = $grandfatherfatherside = $grandmotherfatherside = $grandfathermotherside = $grandmothermotherside="";
											
											while ($rowp = mysql_fetch_array($result)){
												$birthplace = $rowp["birthplace"];
												$father = $rowp["fatherbirthplace"];
												$mother= $rowp["motherbirthplace"];
												$grandfatherfatherside= $rowp["fatherfatherbirthplace"];
												$grandmotherfatherside= $rowp["motherfatherbirthplace"];
												$grandfathermotherside= $rowp["fathermotherbirthplace"];
												$grandmothermotherside= $rowp["mothermotherbirthplace"];
												
												
												
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
                                        
                                        <td><input type="email" class="form-control" id="email" name="email" placeholder="Click here to add email address" value="<?php echo $email; ?>" >
                                        </td>
                                        <td><input type="text" class="form-control" name="name" id="name" placeholder="Team Name" value="<?php echo $name; ?>" > 
                                        </td>
                                        <td>Belief</td>
                                        <td>Student</td>
                                        <td>Father</td>
                                        <td>Mother</td>
                                        <td>grandfather (father)</td>
                                        <td>grandmother (father)</td>
                                        <td>grandfather (mother)</td>
                                        <td>grandfather (mother)</td>
                                        
                                        <td><button type="submit" class="btn btn-default" name="invite" id="invite" title="INVITE">INVITE</button>
                                        	
                                        </td>
                                        
                                        </tr>
                                        </form>
										<?php
										echo "</table>";
									}else{
										echo "data fetching fail from teacher table.";
									}
												  
                            ?>
                            
                            <span style="clear:both; float:left; margin-left:3em; color:red;" id="error"><?php 
                                    echo $combineErr;
									
								?></span>
                            
                      
                            
                            
                            </div>
                            
                            <div id="maps" class="tab-pane fade">
                              <br>
                          <div>
                              <div id="regions_div" style="float:left;"></div>
                               
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
                            
                            <div id="language" class="tab-pane fade">
                              
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
                              
                         
                               <div id="languagechart" style="width: '100%'; clear:both; height:auto;"> 
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
                               <div id="barchart_values" style="width: '100%'; clear:both; height:auto;"></div>
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

                            
                            
                            
                      

                            <div id="export" class="tab-pane fade">
                             
                              <br>
                                <form action="exportteacher.php" target="_blank" method="post">
                                
					<br>                                			
                                	<div id='png'></div>
                                	<br>
                                	<input type="submit" value="Export"> 
                                </form>
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



if(!isset($_SESSION['deptorg'])){
	
	
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
			  //width: '900',
			  width: "100%",
			  height:'500',
			  //height:'500',
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
			  //width: '900',
			  width: "100%",
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
			  //width: '900',
			  width: "100%",
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
			  //width: '900',
			  width: "100%",
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


