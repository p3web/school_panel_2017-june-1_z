<?php
ob_start();
session_cache_expire();
session_start();
?>
<?php
	$adminid = $_SESSION['teamemailidorg']; 

		include 'connection.php';
		
		
		$queryp = "select * from teamadmin where teamemailid = '".$adminid."'";
		
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
		$query = "select deptname from orgteamdetail where orgid = '".$orgId."' AND teamemailid = '".$adminid."'";
		$result = mysql_query($query);
		$deptName = "";
		
		//Select only first department
		$rowp = mysql_fetch_array($result);
		$deptName = $rowp["deptname"];
		
		
		
		
		//Team details
		$query = "select teamname from orgteamdetail where orgid = '".$orgId."' AND teamemailid = '".$adminid."'";
		$result = mysql_query($query);
		$teamName = "";
		
		//Select only first department
		$rowp = mysql_fetch_array($result);
		$teamName = $rowp["teamname"];
		
		function makecsv($data, $csvfilename)		
		{
			$list = $data;

			$file = fopen($csvfilename,"w");

			foreach ($list as $line)
			{
				fputcsv($file,$line);
			}

			fclose($file);
			echo "<script type='text/javascript'>
			location.replace($csvfilename);
			</script>";
		}
		mysql_close($con);



?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Team Admin Panel</title>
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
table.borderless td,table.borderless th{
     border: none !important; height:0% auto !important; padding:0% !important;
}
table{ border:none !important;}


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
        ["Religion", "NumberOfStaff" ],
		 <?php 
			include 'connection.php';
			
			  if (!empty($_POST['classnamedropdownbeltab']))
			  {
				$teamName= $_POST['classnamedropdownbeltab'];
			  }
			
			$result = mysql_query("SELECT religion, COUNT( religion ) FROM staff where orgid='".$orgId."' AND deptname='".$deptName."' AND teamname='".$teamName."' AND status='active' GROUP BY religion ORDER BY COUNT( religion ) DESC");
			
			
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
				$teamName= $_POST['classnamedropdown'];
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
						$querytest .= " select `staffbirthplace` as x from staffbirthdetails where staffemailid IN(SELECT staffemailid FROM staff where orgid='".$orgId."'  AND deptname='".$deptName."' AND teamname='".$teamName."')";
						$unionAllOption = 1;
					}
					if($aDoor[$i] == 'F'){
						if($unionAllOption==1){$querytest .= " UNION ALL";}
						$querytest .= " select `stafffatherbirthplace` as x from staffbirthdetails where staffemailid IN(SELECT staffemailid FROM staff where orgid='".$orgId."'  AND deptname='".$deptName."' AND teamname='".$teamName."')";
						$unionAllOption = 1;
					}
					if($aDoor[$i] == 'M'){
						if($unionAllOption==1){$querytest .= " UNION ALL";}
						$querytest .= " select `staffmotherbirthplace` as x from staffbirthdetails where staffemailid IN(SELECT staffemailid FROM staff where orgid='".$orgId."'  AND deptname='".$deptName."' AND teamname='".$teamName."')";
						$unionAllOption = 1;
					}
					if($aDoor[$i] == 'GFFS'){
						if($unionAllOption==1){$querytest .= " UNION ALL";}
						$querytest .= " select `stafffathersfatherbirthplace` as x from staffbirthdetails where staffemailid IN(SELECT staffemailid FROM staff where orgid='".$orgId."'  AND deptname='".$deptName."' AND teamname='".$teamName."')";
						$unionAllOption = 1;
					}
					if($aDoor[$i] == 'GMFS'){
						if($unionAllOption==1){$querytest .= " UNION ALL";}
						$querytest .= " select `stafffathersmotherbirthplace` as x from staffbirthdetails where staffemailid IN(SELECT staffemailid FROM staff where orgid='".$orgId."'  AND deptname='".$deptName."' AND teamname='".$teamName."')";
						$unionAllOption = 1;
					}
					if($aDoor[$i] == 'GFMS'){
						if($unionAllOption==1){$querytest .= " UNION ALL";}
						$querytest .= " select `staffmothersfatherbirthplace` as x from staffbirthdetails where staffemailid IN(SELECT staffemailid FROM staff where orgid='".$orgId."'  AND deptname='".$deptName."' AND teamname='".$teamName."')";
						$unionAllOption = 1;
					}
					if($aDoor[$i] == 'GMMS'){
						if($unionAllOption==1){$querytest .= " UNION ALL";}
						$querytest .= " select `staffmothersmotherbirthplace` as x from staffbirthdetails where staffemailid IN(SELECT staffemailid FROM staff where orgid='".$orgId."'  AND deptname='".$deptName."' AND teamname='".$teamName."')";
						$unionAllOption = 1;
					}
				}
				
				$querytest .= " ) as temptable group by x";
			  }
		
			
			
			
			
			
			
			// Default values goes here
			if($querytest==""){
				
				$querytest = "select x , COUNT( * )  from( select `staffbirthplace` as x from staffbirthdetails where staffemailid IN(SELECT staffemailid FROM staff where orgid='".$orgId."'  AND deptname='".$deptName."' AND teamname='".$teamName."') ) as temptable group by x";
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
       document.getElementById('png').outerHTML = '<a href="' + chart.getImageURI() + '" target="_blank">Printable version</a>';
       
      });


        chart.draw(data, options);
      }

//function to draw language chart	
var languagechart;  
function drawLanguageChart() {
		
		var data = google.visualization.arrayToDataTable([
          ['Language', 'NumberOfStaff'],
          
		  
		  <?php 
			include 'connection.php';
			
			if (!empty($_POST['classnamedropdownlantab']))
			  {
				$teamName= $_POST['classnamedropdownlantab'];
			  }
	
			$result = mysql_query("SELECT languagename, COUNT( languagename ) FROM stafflanguage where staffemailid IN(SELECT staffemailid FROM staff where orgid='".$orgId."' AND teamname='".$teamName."' AND deptname='".$deptName."') GROUP BY languagename ORDER BY COUNT( languagename ) DESC");
			
			
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
    
    <script type="text/javascript">
  
		  function activaTab(tabID){
			$('.nav-tabs a[href="#' + tabID + '"]').tab('show');
		};
		
  </script>
  
  
<script>
$(document).ready(function(){
    $('#checkoall').change(function() {
    	
	    
	    //$(".formDoor").prop('checked', true);
	    
	    ($(this).is(":checked") ? $('.checkboxes').prop("checked", true) :    $('.checkboxes').prop("checked", false))
	
	});
});
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
			
				$dataMatched ="no";
				
				
				//staff email check
				$querys = "select staffemailid from staff";
				$results = mysql_query($querys);
				
				while ($rows=mysql_fetch_array($results))
				{
					if(strtolower($email) == strtolower($rows["staffemailid"])){
						$dataMatched ="yes";
						$email = $rows["staffemailid"];
						
						}
				
				}
				
				
				
				//Team admin email check
				if($dataMatched == "no"){
					$queryo = "select teamemailid from teamadmin";
					$resulto = mysql_query($queryo);
					
					while ($rowo=mysql_fetch_array($resulto))
					{
						if(strtolower($email) == strtolower($rowo["teamemailid"])){
							$dataMatched ="yes";
							$email = $rowo["teamemailid"];
							
							}
					
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

	
	 
		
	
	
	
	
	
	
					
	//EVERTHING IS OK NOW
	 if((empty($emailErr) )){
		 
		   
		 
		  
		  if($name == ""){
			  $name="NULL";
			  }
		  
		  
		   $teamName = $_POST['classnamedropdownstutab'];
        		
			$bytes = openssl_random_pseudo_bytes(32);
			$token = bin2hex($bytes);
				
				include 'connection.php';
				
				
					
				if(!mysql_query("insert into staff(staffemailid, orgid, deptname, teamname, firstname, token, status) values('$email','$orgId','$deptName','$teamName','$name','$token','pending')",$con)){
						
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
									
									$mail->Subject = "Account Confirmation";
									$mail->Body    = "
											  The Ancestry Atlas is a fun activity that can be done by any group, organisation or community. Our website helps you begin discussions around culture by creating a beautiful infographic that helps you discover the richness and diversity within your community.
											  
											  <br>
											  <br>Your team admin ".$adminid." has signed you up for Ancestry Atlas powered by <a href='http://culturalinfusion.org.au/'>Cultural Infusion</a>. Start your journey here!
											  <br><br>
											  
											  
											  <ol>
											  	<li>Activate this registration by selecting this <a href='http://www.ancestryatlas.com/backend/verifystaff.php?email=".$email."&token=".$token."'>LINK</a></li>
											  	<li>Enter your place of birth and, if you want to, you can enter the place of birth or your parents, paternal and maternal grandparents. The results automatically map the location to a world map. Don&#39;t worry if you can&#39;t complete all of these answers. We are working as a team so just answer what you know and are willing to share. As long as each person enters at least one place of birth the map will look awesome!</li>
											  	<li>You are invited to share information about the languages you speak and your religion or beliefs. If you would prefer to keep this private we do understand.</li>
											  </ol>
											  
											  

                                                                                          <br>Please do let your Team Admin know if you require any further assistance or help. 
											 
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
										$query= "DELETE FROM staff WHERE staffemailid = '".$email."' ";
										$result = mysql_query($query);
										echo '<script type="text/javascript">'; 
										echo 'alert("Email Unsuccessful. please try again. or contact us  ");' ;
										echo 'window.location.href = "teamadminpanel.php";';  
										echo '</script>'; 
									   exit;
									}else{
									
									
										echo '<script type="text/javascript">'; 
										echo 'alert("Email sent Successfully. Staff can check their email and fill data.");'; 
										echo 'window.location.href = "teamadminpanel.php";';
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
                             <h5>Team admin -> &nbsp;<b><?php echo $adminName; ?></b></h5> 
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
                            <li class="active"><a data-toggle="tab" href="#students">Staff Members</a></li>
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
							    $teamName = $_POST['classnamedropdownstutab'];
								$currentClassName = $_POST['classnamedropdownstutab'];
							  }
							  		include 'connection.php';
							        $queryp = "select teamname from orgteamdetail where teamemailid = '".$adminid."' AND orgid = '".$orgId."'";
									$resultp = mysql_query($queryp);
									echo "Team Name: ";
									echo '<select name="classnamedropdownstutab" >';
									while ($rowp = mysql_fetch_array($resultp)){
										$selected = ($rowp['teamname'] == $currentClassName) ? 'selected="selected"' : '';
										echo '<option value="'.$rowp['teamname'].'"'.$selected.' >'.$rowp['teamname'].'</option>';
										//$teamName = $rowp['teamname'];
									}
									 echo '</select>';// Close your drop down box
									 
									 
							  		mysql_close($con);
									 ?>
									<input type="submit" id="submitvalstutab" name="submitvalstutab" value="SUBMIT">
									
									


							 
                            
                              <br><br>
                              <?php
							  
							  		include 'connection.php';
									
									
									
									
						
									$queryteachers = "select * from staff where orgid = '".$orgId."' AND deptname = '".$deptName."' AND teamname ='".$teamName."' order by firstname" ;
									$resultteachers = mysql_query($queryteachers);
									if($resultteachers == TRUE){
										$j=1;
										$k=1;
										echo "<table class='table table-striped table-bordered' cellspacing='0' width='100%'>";
										echo "<thead>";
										echo "<tr>";
										echo "<th>Staff Name</th>";
										echo "<th>Staff Email ID*</th>";
										
										/*
										echo "<th>Belief</th>";
										echo "<th>Staff Member Birthplace</th>";
										echo "<th>Father Birthplace</th>";
										echo "<th>Mother Birthplace</th>";
										echo "<th>Grandfather (Father) Birthplace</th>";
										echo "<th>Grandmother (Father) Birthplace</th>";
										echo "<th>Grandfather (Mother) Birthplace</th>";
										echo "<th>Grandmother (Mother)Birthplace</th>";
										*/
										
										echo "<th>Info</th>";
										echo "<th>Status</th>";
										echo "<th>Options</th>";
										echo "</tr>";
										echo "</thead>";
										
										while ($rowj=mysql_fetch_array($resultteachers)){
											
											$studentNameTemp = "";
											if($rowj['firstname'] == "NULL"){
												$studentNameTemp = "Waiting acceptance";
											}else{
												$studentNameTemp =	$rowj['firstname'];	
											}
											echo "<tr>";
											
											echo "<td style='padding:1%;'>";
											$lname='';
											if($rowj['lastname'] != 'null'){
											    $lname = $rowj['lastname'];
											}
											
											echo "<span style='padding:0.7%;' id='j".$j."' >".$studentNameTemp." ".$lname."</span>&nbsp;&nbsp;&nbsp;";
											$j = ++$j;
											$k = ++$k;
											echo "</td>";
											
											
											echo "<td  style='padding:1%;'>";
											echo "<span>".$rowj['staffemailid']."</span>";
											echo "</td>";
											
											
											
											/*
											//religion or belief
											echo "<td  style='padding:1%;'>";
											$religion="";
											if($rowj['religion'] == "" or $rowj['religion'] == "NULL"){
												echo "<span> Waiting acceptance</span>";
											}else{
											
											echo "<span>".$rowj['religion']."</span>";
											}
											echo "</td>";
											
											
											
											
											
											
											$query = "select * from staffbirthdetails where staffemailid = '".$rowj['staffemailid']."' ";
											$result = mysql_query($query);
											$birthplace = $father = $mother = $grandfatherfatherside = $grandmotherfatherside = $grandfathermotherside = $grandmothermotherside="";
											
											while ($rowp = mysql_fetch_array($result)){
												$birthplace = $rowp["staffbirthplace"];
												$father = $rowp["stafffatherbirthplace"];
												$mother= $rowp["staffmotherbirthplace"];
												$grandfatherfatherside= $rowp["stafffathersfatherbirthplace"];
												$grandmotherfatherside= $rowp["staffmothersfatherbirthplace"];
												$grandfathermotherside= $rowp["stafffathersmotherbirthplace"];
												$grandmothermotherside= $rowp["staffmothersmotherbirthplace"];
												
												
												
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
											
											
											*/
											
											//CLICK FOR INFORMATION LINK
											echo "<td  style='padding:1%; '>";
											if($rowj['status'] == 'active'){
											    echo '<a style="text-decoration:underline; cursor:pointer;" name="view" id="'.$rowj['staffemailid'].'" data-toggle="modal" data-target="#dataModal" class="view_data">View</a>';
											}else{
											    echo "Waiting approval";
											}
											echo "</td>";
											
											//STATUS
											echo "<td  style='padding:1%;'>";
											if($rowj['status'] == 'active'){
											    echo "<span> <img src='images/active.png'>&nbsp;active</span>";
											}else if($rowj['status'] == 'pending'){
											    echo "<span> <img src='images/pending.png'>&nbsp;pending</span>";
											}else{
											    echo "<span>".$rowj['status']."</span>";
											}
											echo "</td>";
											
											
											
											//EDIT and DELETE
											echo "<td  style='padding:1%;'>";
											
                                            ?>
                                            <a href="#" data-href="deletestaff.php?id=<?php echo $rowj['staffemailid']; ?>" data-id="<?php echo $studentNameTemp." ".$lname; ?>" class="staffinfo" data-toggle="modal" data-target="#confirm-delete">
                                                <img src='images/deletehover.png' width='16' height='16' onmouseover="this.src='images/delete.png';" onmouseout="this.src='images/deletehover.png';" />
                                            </a>
                                            <!-- <input type="button" name="editstaff" value="Edit" id="<?php echo $row["id"]; ?>" class="btn btn-info btn-xs edit_data" />-->
                                            
                                            <a style="text-decoration:underline;" name="editstaff" id="<?php echo $rowj['staffemailid'] ?>"  class="editstaff_data"> Edit</a>
                                            
                                            <?php
											echo "</td>";
											
											echo "</tr>";
										}
										?>
                   
										<tr style="background-color:#CCC;">
                                         <td><input type="text" class="form-control" name="name" id="name" placeholder="Staff Name" value="<?php echo $name; ?>" > 
                                        </td>
                                        <td><input type="email" class="form-control" id="email" name="email" placeholder="Click here to add email address" value="<?php echo $email; ?>" >
                                        </td>
                                       
                                       <!--
                                        <td>Belief</td>
                                        <td>Staff</td>
                                        <td>Father</td>
                                        <td>Mother</td>
                                        <td>grandfather (father)</td>
                                        <td>grandmother (father)</td>
                                        <td>grandfather (mother)</td>
                                        <td>grandfather (mother)</td>
                                        -->
                                        
                                        <td></td>
                                        <td></td>
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
							        $queryp = "select teamname from orgteamdetail where teamemailid	= '".$adminid."' AND orgid = '".$orgId."'";
									$resultp = mysql_query($queryp);
									echo "Team Name:";
									echo '<select name="classnamedropdown">';
									while ($rowp = mysql_fetch_array($resultp)){
										$selected = ($rowp['teamname'] == $currentClassName) ? 'selected="selected"' : '';
										echo '<option value="'.$rowp['teamname'].'"'.$selected.' >'.$rowp['teamname'].'</option>';
									}
									 echo '</select>';// Close your drop down box
							  		mysql_close($con);
									
									
									
							  ?>
                            
                              
                              <br><br>
                                        
                                        <input type="checkbox" id="checkoall" />&nbsp;All (select/unselect)<br />
										<input type="checkbox" class="checkboxes" name="formDoor[]" value="S" <?php if(isset($_POST['formDoor'])){ $aDoor = $_POST['formDoor'];$N = count($aDoor);for($i=0; $i < $N; $i++){if($aDoor[$i] == 'S'){echo "checked='checked'";}}} ?>/>&nbsp;Staff<br />
                                        <input type="checkbox" class="checkboxes" name="formDoor[]" value="F" <?php if(isset($_POST['formDoor'])){ $aDoor = $_POST['formDoor'];$N = count($aDoor);for($i=0; $i < $N; $i++){if($aDoor[$i] == 'F'){echo "checked='checked'";}}} ?>/>&nbsp;Father<br />
                                        <input type="checkbox" class="checkboxes" name="formDoor[]" value="M" <?php if(isset($_POST['formDoor'])){ $aDoor = $_POST['formDoor'];$N = count($aDoor);for($i=0; $i < $N; $i++){if($aDoor[$i] == 'M'){echo "checked='checked'";}}} ?>/>&nbsp;Mother<br />
                                        <input type="checkbox" class="checkboxes" name="formDoor[]" value="GFFS" <?php if(isset($_POST['formDoor'])){ $aDoor = $_POST['formDoor'];$N = count($aDoor);for($i=0; $i < $N; $i++){if($aDoor[$i] == 'GFFS'){echo "checked='checked'";}}} ?> />&nbsp;Paternal GrandFather<br />
                                        <input type="checkbox" class="checkboxes" name="formDoor[]" value="GMFS" <?php if(isset($_POST['formDoor'])){ $aDoor = $_POST['formDoor'];$N = count($aDoor);for($i=0; $i < $N; $i++){if($aDoor[$i] == 'GMFS'){echo "checked='checked'";}}} ?>/>&nbsp;Paternal GrandMother<br />
                                        <input type="checkbox" class="checkboxes" name="formDoor[]" value="GFMS" <?php if(isset($_POST['formDoor'])){ $aDoor = $_POST['formDoor'];$N = count($aDoor);for($i=0; $i < $N; $i++){if($aDoor[$i] == 'GFMS'){echo "checked='checked'";}}} ?> />&nbsp;Maternal GrandFather<br />
                                        <input type="checkbox" class="checkboxes" name="formDoor[]" value="GMMS" <?php if(isset($_POST['formDoor'])){ $aDoor = $_POST['formDoor'];$N = count($aDoor);for($i=0; $i < $N; $i++){if($aDoor[$i] == 'GMMS'){echo "checked='checked'";}}} ?>/>&nbsp;Maternal GrandMother<br />
                                        
                                        
                                        
                                        
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
						$querytest .= " select `staffbirthplace` as x from staffbirthdetails where staffemailid IN(SELECT staffemailid FROM staff where orgid='".$orgId."'  AND deptname='".$deptName."' AND teamname='".$teamName."')";
						$unionAllOption = 1;
					}
					if($aDoor[$i] == 'F'){
						if($unionAllOption==1){$querytest .= " UNION ALL";}
						$querytest .= " select `stafffatherbirthplace` as x from staffbirthdetails where staffemailid IN(SELECT staffemailid FROM staff where orgid='".$orgId."'  AND deptname='".$deptName."' AND teamname='".$teamName."')";
						$unionAllOption = 1;
					}
					if($aDoor[$i] == 'M'){
						if($unionAllOption==1){$querytest .= " UNION ALL";}
						$querytest .= " select `staffmotherbirthplace` as x from staffbirthdetails where staffemailid IN(SELECT staffemailid FROM staff where orgid='".$orgId."'  AND deptname='".$deptName."' AND teamname='".$teamName."')";
						$unionAllOption = 1;
					}
					if($aDoor[$i] == 'GFFS'){
						if($unionAllOption==1){$querytest .= " UNION ALL";}
						$querytest .= " select `stafffathersfatherbirthplace` as x from staffbirthdetails where staffemailid IN(SELECT staffemailid FROM staff where orgid='".$orgId."'  AND deptname='".$deptName."' AND teamname='".$teamName."')";
						$unionAllOption = 1;
					}
					if($aDoor[$i] == 'GMFS'){
						if($unionAllOption==1){$querytest .= " UNION ALL";}
						$querytest .= " select `stafffathersmotherbirthplace` as x from staffbirthdetails where staffemailid IN(SELECT staffemailid FROM staff where orgid='".$orgId."'  AND deptname='".$deptName."' AND teamname='".$teamName."')";
						$unionAllOption = 1;
					}
					if($aDoor[$i] == 'GFMS'){
						if($unionAllOption==1){$querytest .= " UNION ALL";}
						$querytest .= " select `staffmothersfatherbirthplace` as x from staffbirthdetails where staffemailid IN(SELECT staffemailid FROM staff where orgid='".$orgId."'  AND deptname='".$deptName."' AND teamname='".$teamName."')";
						$unionAllOption = 1;
					}
					if($aDoor[$i] == 'GMMS'){
						if($unionAllOption==1){$querytest .= " UNION ALL";}
						$querytest .= " select `staffmothersmotherbirthplace` as x from staffbirthdetails where staffemailid IN(SELECT staffemailid FROM staff where orgid='".$orgId."'  AND deptname='".$deptName."' AND teamname='".$teamName."')";
						$unionAllOption = 1;
					}
				}
				
				$querytest .= " ) as temptable group by x";
			  }
		
		    // Default values goes here
			if($querytest==""){
				
				$querytest = "select x , COUNT( * )  from( select `staffbirthplace` as x from staffbirthdetails where staffemailid IN(SELECT staffemailid FROM staff where orgid='".$orgId."'  AND deptname='".$deptName."' AND teamname='".$teamName."') ) as temptable group by x";
				}
			
			
			
								
							$result = mysql_query($querytest);
							$result1 = mysql_query($querytest);
								while($row = mysql_fetch_assoc($result)) { 
									echo "<b>";
									echo $row['x'];
									echo ": </b>&nbsp;"; 
									echo $row['COUNT( * )'];
									echo "<br/>"; 
									} 			
								$output = array();
								while($row = mysql_fetch_assoc($result1)) { 
									$output[] = $row;
								} 
								makecsv($output, "teamadminregionout.csv");
									?>
								<a href="teamadminregionout.csv" id="CSVFILE">EXPORT To CSV</a>
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
								$teamName= $_POST['classnamedropdownlantab'];
								$currentClassName = $_POST['classnamedropdownlantab'];
							  }
							  		include 'connection.php';
							       
							        $queryp = "select teamname from orgteamdetail where teamemailid	= '".$adminid."' AND orgid = '".$orgId."'";
									$resultp = mysql_query($queryp);
									echo "Team Name: ";
									echo '<select name="classnamedropdownlantab" >';
									while ($rowp = mysql_fetch_array($resultp)){
										$selected = ($rowp['teamname'] == $currentClassName) ? 'selected="selected"' : '';
										echo '<option value="'.$rowp['teamname'].'"'.$selected.' >'.$rowp['teamname'].'</option>';
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
								
								
								$result = mysql_query("SELECT languagename, COUNT( languagename ) FROM stafflanguage where staffemailid IN(SELECT staffemailid FROM staff where orgid='".$orgId."' AND teamname='".$teamName."' AND deptname='".$deptName."') GROUP BY languagename ORDER BY COUNT( languagename ) DESC");
								$result1 = mysql_query("SELECT languagename, COUNT( languagename ) FROM stafflanguage where staffemailid IN(SELECT staffemailid FROM staff where orgid='".$orgId."' AND teamname='".$teamName."' AND deptname='".$deptName."') GROUP BY languagename ORDER BY COUNT( languagename ) DESC");
							

								
								
								while($row = mysql_fetch_assoc($result)) { 
									echo "<b>";
									echo $row['languagename'];
									echo ": </b>&nbsp;"; 
									echo $row['COUNT( languagename )'];
									echo "<br/>"; 
									}
								$output = array();
								while($row = mysql_fetch_assoc($result1)) { 
									$output[] = $row;
								} 
								makecsv($output, "teamadminlangout.csv");
									?>

						<a href="teamadminlangout.csv" id="CSVFILE">EXPORT To CSV</a>                             
					</div>
                            
                            </div>

                            
                            <div id="religion" class="tab-pane fade">
                             
                              <br>
                              <form method="post">
							  <?php 
							  
							  if (!empty($_POST['classnamedropdownbeltab']))
							  {
								$teamName= $_POST['classnamedropdownbeltab'];
								$currentClassName = $_POST['classnamedropdownbeltab'];
							  }
							  		include 'connection.php';
							        $queryp = "select teamname from orgteamdetail where teamemailid	= '".$adminid."' AND orgid = '".$orgId."'";
									$resultp = mysql_query($queryp);
									echo "Team Name: ";
									echo '<select name="classnamedropdownbeltab" >';
									while ($rowp = mysql_fetch_array($resultp)){
										$selected = ($rowp['teamname'] == $currentClassName) ? 'selected="selected"' : '';
										echo '<option value="'.$rowp['teamname'].'"'.$selected.' >'.$rowp['teamname'].'</option>';
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
									
									
									$result = mysql_query("SELECT religion, COUNT( religion ) FROM staff where orgid='".$orgId."' AND deptname='".$deptName."' AND teamname='".$teamName."' AND status='active' GROUP BY religion ORDER BY COUNT( religion ) DESC");
									$result1 = mysql_query("SELECT religion, COUNT( religion ) FROM staff where orgid='".$orgId."' AND deptname='".$deptName."' AND teamname='".$teamName."' AND status='active' GROUP BY religion ORDER BY COUNT( religion ) DESC");
								
			
									
									
									while($row = mysql_fetch_assoc($result)) { 
										echo "<b>";
										echo $row['religion'];
										echo ": </b>&nbsp;"; 
										echo $row['COUNT( religion )'];
										echo "<br/>"; 
										}
										$output = array();
								while($row = mysql_fetch_assoc($result1)) { 
									$output[] = $row;
								} 
								makecsv($output, "teamadminreligonout.csv");
									?>

						<a href="teamadminreligonout.csv" id="CSVFILE">EXPORT To CSV</a>   									
									 

                             
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

</body>
</html>


<?php

if (isset($_GET['logoutrequest'])) {
	
	session_destroy();
	header('Location:index.php');
	
}



if(!isset($_SESSION['teamorg'])){
	
	
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
				
				
				
				$result = mysql_query("SELECT languagename, COUNT( languagename ) FROM stafflanguage where staffemailid IN(SELECT staffemailid FROM staff where orgid='".$orgId."' AND teamname='".$teamName."' AND deptname='".$deptName."') GROUP BY languagename ORDER BY COUNT( languagename ) DESC");
				
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
								
								 
								$result = mysql_query("SELECT languagename, COUNT( languagename ) FROM stafflanguage where staffemailid IN(SELECT staffemailid FROM staff where orgid='".$orgId."' AND teamname='".$teamName."' AND deptname='".$deptName."') GROUP BY languagename ORDER BY COUNT( languagename ) DESC");
							

								
								
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
				
				$result = mysql_query("SELECT languagename, COUNT( languagename ) FROM stafflanguage where staffemailid IN(SELECT staffemailid FROM staff where orgid='".$orgId."' AND teamname='".$teamName."' AND deptname='".$deptName."' AND gender='".$gen."') GROUP BY languagename ORDER BY COUNT( languagename ) DESC");
				
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
								
								$result = mysql_query("SELECT languagename, COUNT( languagename ) FROM stafflanguage where staffemailid IN(SELECT staffemailid FROM staff where orgid='".$orgId."' AND teamname='".$teamName."' AND deptname='".$deptName."' AND gender='".$gen."') GROUP BY languagename ORDER BY COUNT( languagename ) DESC");
								
							

								
								
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
				
				$result = mysql_query("SELECT languagename, COUNT( languagename ) FROM stafflanguage where staffemailid IN(SELECT staffemailid FROM staff where orgid='".$orgId."' AND teamname='".$teamName."' AND deptname='".$deptName."' AND gender='".$gen."') GROUP BY languagename ORDER BY COUNT( languagename ) DESC");
				
				
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
								
								$result = mysql_query("SELECT languagename, COUNT( languagename ) FROM stafflanguage where staffemailid IN(SELECT staffemailid FROM staff where orgid='".$orgId."' AND teamname='".$teamName."' AND deptname='".$deptName."' AND gender='".$gen."') GROUP BY languagename ORDER BY COUNT( languagename ) DESC");
								
							

								
								
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
				
				$result = mysql_query("SELECT languagename, COUNT( languagename ) FROM stafflanguage where staffemailid IN(SELECT staffemailid FROM staff where orgid='".$orgId."' AND teamname='".$teamName."' AND deptname='".$deptName."' AND gender='".$gen."') GROUP BY languagename ORDER BY COUNT( languagename ) DESC");
				
				
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
								
								$result = mysql_query("SELECT languagename, COUNT( languagename ) FROM stafflanguage where staffemailid IN(SELECT staffemailid FROM staff where orgid='".$orgId."' AND teamname='".$teamName."' AND deptname='".$deptName."' AND gender='".$gen."') GROUP BY languagename ORDER BY COUNT( languagename ) DESC");
								
							

								
								
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
	$teamName = $_POST['classnamedropdown'];
	
	
	
}
if(isset($_POST['submitvalstutab'])){
	
	
	$currentClassName = $_POST['classnamedropdownstutab'];
	$teamName = $_POST['classnamedropdownstutab'];
	echo '<script>activaTab("students");</script>';
	
	
}

if(isset($_POST['submitvallantab'])){
	
	
	$currentClassName = $_POST['classnamedropdownlantab'];
	$teamName = $_POST['classnamedropdownlantab'];
	echo '<script>activaTab("language");</script>';
	
	
}
if(isset($_POST['submitvalbeltab'])){
	
	
	$currentClassName = $_POST['classnamedropdownbeltab'];
	$teamName = $_POST['classnamedropdownbeltab'];
	echo '<script>activaTab("religion");</script>';
	
	
}

?>
 <!-- View Staff info MODAL  -->
<div id="dataModal" class="modal fade">  
      <div class="modal-dialog">  
           <div class="modal-content">  
                
                <div class="modal-body" id="employee_detail">  
                </div>  
                
           </div>  
      </div>  
 </div>  
 <script>  
 $(document).ready(function(){  
      $('.view_data').click(function(){  
           var employee_id = $(this).attr("id");  
           $.ajax({  
                url:"selectstaffinfo.php",  
                method:"post",  
                data:{employee_id:employee_id},  
                success:function(data){  
                     $('#employee_detail').html(data);  
                     $('#dataModal').modal("show");  
                }  
           });  
      });  
      
       
      
 });  
 </script>
 
 
 
 
 <!-- DELETE STAFF MODAL -->
<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                 <h3 style="font-weight:bold;">Delete Staff</h3>
            </div>
            <div class="modal-body">
                <h3>Are you sure you want to delete <span style="font-weight:bold;" id="specstaffinfo" name="specstaffinfo"></span> ?</h3>
                <br>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok">Delete</a>
            </div>
        </div>
    </div>
</div>

<script>  
 $(document).ready(function(){  
      
      
      $('#confirm-delete').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        });
        
        
        $(document).on("click", ".staffinfo", function () {
             var myspecstaffinfo = $(this).data('id');
             $(".modal-body #specstaffinfo").text( myspecstaffinfo );
             
        });
 });  
 </script>
 
 
 