<?php
ob_start();
session_cache_expire();
session_start();
require_once 'PSCO_function.php';
require_once 'invite.php';
?>
<?php
//print_r($_SESSION);exit;
$adminid = $_SESSION['teamemailidorg'];
include 'connection.php';


$queryp = "select * from teamadmin where teamemailid = '".$adminid."'";

$resultp = mysql_query($queryp);
$adminName = "";
$orgId = "";
while ($rowp = mysql_fetch_array($resultp)){

	$adminName = $rowp["firstname"]." ".$rowp["lastname"];

	$orgId = $rowp["orgid"];
	//print_r($rowp);exit;
}


function generateRandomColor(){
	$randomcolor = '#' . strtoupper(dechex(rand(0,10000000)));
	if (strlen($randomcolor) != 7){
		$randomcolor = str_pad($randomcolor, 10, '0', STR_PAD_RIGHT);
		$randomcolor = substr($randomcolor,0,7);
	}
	return $randomcolor;
}

//organisation details
$queryp = "select * from organisationadmin where orgid = '".$orgId."'";
$resultp = mysql_query($queryp);
$orgName = $state = $city = $suburb = "";

while ($rowp = mysql_fetch_array($resultp)){


	$orgName = $rowp["orgname"];
	$city = $rowp["city"];
	$suburb = $rowp["suburb"];
	$state = $rowp["state"];

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


mysql_close($con);
function makecsv($data, $csvfilename,$scriptrun = null)
{
	if (null === $scriptrun){
		$scriptrun = true;
	}
	$list = $data;
	$file = fopen($csvfilename,"w");

	fputcsv($file,array($GLOBALS['orgName'],
			$GLOBALS['suburb']."/".$GLOBALS['city']."/".$GLOBALS['state']."/Australia")
	);
	foreach ($list as $line)
	{
		fputcsv($file,$line);
	}
	if ($scriptrun) {
		echo "<script type='text/javascript'>
				location.replace($csvfilename);
				</script>";
	}
}
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


	<!--  AUTO COMPLETE MATERIAL -->
	<link rel="stylesheet" href="css/jquery-ui.css">
	<script src="scripts/jquery-ui.js"></script>





	</script>

	<!--Jquery function to autocomplete country name -->
	<script>
	$(function() {

		$( "#sb" ).autocomplete({
			source: 'autocompletecountry.php'
		});

		$( "#m" ).autocomplete({
			source: 'autocompletecountry.php'
		});

		$( "#gfm" ).autocomplete({
			source: 'autocompletecountry.php'
		});

		$( "#gmm" ).autocomplete({
			source: 'autocompletecountry.php'
		});

		$( "#f" ).autocomplete({
			source: 'autocompletecountry.php'
		});

		$( "#gff" ).autocomplete({
			source: 'autocompletecountry.php'
		});

		$( "#gmf" ).autocomplete({
			source: 'autocompletecountry.php'
		});
	});



	</script>




	</script>

	<!--Jquery function to autocomplete country name -->
	<script>
	$(function() {
		$( "#beliefreligion" ).autocomplete({
			source: 'autocompletereligion.php'
		});
	});
	</script>
	<script>
		$(document).ready(function(){

			$('#checko').change(function() {


				if($(this).prop("checked") == true){

					$("#beliefreligion").prop("readonly",true);
					$('#beliefreligion').val('Belief/Religion');
					$('#beliefreligion').css('color','#CCC');

				}
				else if($(this).prop("checked") == false){
					$("#beliefreligion").prop("readonly",false);
					$('#beliefreligion').val('');
					$('#beliefreligion').css('color','#000');
				}

			});
		});
	</script>

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
		.ui-autocomplete {
			z-index: 5000;
		}
		.table-hover tbody tr:hover td, .table-hover tbody tr:hover th {
			background-color:#e3f3f4;
		}
		.submitbtunnew, .submitbtunnew:link, .submitbtunnew:visited{ font-weight:bold; background-color:#ff8a87; color:#fff; padding:0.3em; border:none; width:6em; border-radius:5px;}
		.submitbtunnew:hover, .submitbtunnew:active{ background-color:#000 !important; font-weight:bold; color:#ff8a87; padding:0.3em; border:none; width:6em;  border-radius:5px;}
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
				["Religion", "NumberOfStaff"],
				<?php
                    include 'connection.php';

                      if (!empty($_POST['classnamedropdownbeltab']))
                      {
                        $teamName= $_POST['classnamedropdownbeltab'];
                      }

                    $result = mysql_query("SELECT religion, COUNT( religion ) FROM staff where orgid='".$orgId."' AND deptname='".$deptName."' AND teamname='".$teamName."' AND status='active' GROUP BY religion ORDER BY COUNT( religion ) DESC");
                    $result1 = mysql_query("SELECT religion, COUNT( religion ) FROM staff where orgid='".$orgId."' AND deptname='".$deptName."' AND teamname='".$teamName."' AND status='active' GROUP BY religion ORDER BY COUNT( religion ) DESC");



                    while($row = mysql_fetch_assoc($result)) {

                    ?>
				['<?php echo $row['religion']; ?>', <?php echo $row['COUNT( religion )']; ?>],


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
				/* title: "",
				 //width: 600,
				 width: "100%",
				 height: "500",
				 //height: 400,
				 bar: {groupWidth: "95%"},
				 legend: { position: "none" },
				 backgroundColor: { fill:'transparent' }*/
				pieHole: 0.4,
				//width: '900',
				width: screen.width * 0.9,
				//height:"100%",
				height: screen.height/2,
				backgroundColor: { fill:'transparent' }
			};
			var chart = new google.visualization.PieChart(document.getElementById("barchart_values"));
			//var chart = new google.visualization.ColumnChart(document.getElementById("barchart_values"));
			chart.draw(view, options);
			<?php
                    $output = array();
                    while($row = mysql_fetch_assoc($result1)) {
                        $output[] = $row;
                    }
                    makecsv($output, "teamadminreligonout.csv", false);
              ?>
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

                    $querytest = "select x , COUNT( * )  from( select `staffbirthplace` as x from staffbirthdetails where staffemailid IN(SELECT staffemailid FROM staff where orgid='".$orgId."'  AND deptname='".$deptName."' AND teamname='".$teamName."') ) as temptable group by x ";
                    }

                $currentQuerry = $querytest;

                $result = mysql_query($currentQuerry);
                $result1 = mysql_query($currentQuerry);

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

			chart.draw(data, options);
			<?php
                    $output = array();
                    while($row = mysql_fetch_assoc($result1)) {
                        $output[] = $row;
                    }
                    makecsv($output, 'teamadminregionout.csv', false);
              ?>
		}

		//function to draw language chart
		var languagechart;

		function drawLanguageChart() {

			var data = google.visualization.arrayToDataTable([
				['Language', 'NumberOfStaff',{ role: 'style' }],


				<?php
                    include 'connection.php';

                    if (!empty($_POST['classnamedropdownlantab']))
                      {
                        $teamName= $_POST['classnamedropdownlantab'];
                      }

                    $result = mysql_query("SELECT languagename, COUNT( languagename ) FROM stafflanguage where staffemailid IN(SELECT staffemailid FROM staff where orgid='".$orgId."' AND teamname='".$teamName."' AND deptname='".$deptName."') GROUP BY languagename ORDER BY COUNT( languagename ) DESC");
                    $result1 = mysql_query("SELECT languagename, COUNT( languagename ) FROM stafflanguage where staffemailid IN(SELECT staffemailid FROM staff where orgid='".$orgId."' AND teamname='".$teamName."' AND deptname='".$deptName."') GROUP BY languagename ORDER BY COUNT( languagename ) DESC");


                    while($row = mysql_fetch_assoc($result)) {

                    ?>
				//
				['<?php echo $row['languagename']; ?>',<?php echo $row['COUNT( languagename )']; ?>,'<?php echo generateRandomColor(); ?>'],


				<?php  } ?>




			]);
			var options = {

				title: "",
				width: screen.width * 0.9,
				hAxis: {
					title: '',
					slantedText: true,
				},
				chartArea: {
					bottom: 88,
					//height: screen.height * 0.8
				},
				bar: {groupWidth: "95%"},
				legend: { position: "none" },
				backgroundColor: { fill:'transparent' }
			};
			languagechart = new google.visualization.ColumnChart(document.getElementById('languagechart'));
			languagechart.draw(data, options);
			<?php
                $output = array();
                while($row = mysql_fetch_assoc($result1)) {
                    $output[] = $row;
                }
                makecsv($output, 'teamadminlangout.csv', false);

         $femalecount =  count(PSCO_func::get_lang_count_all_male_fmale($orgId ,$teamName , $deptName , 'f'));
         $malecount = count(PSCO_func::get_lang_count_all_male_fmale($orgId ,$teamName , $deptName , 'm'));
         $totalcount = $femalecount + $malecount;
         $temp  =array();
         $temp  =array(
            array($totalcount , 'Total number of employees'),
            array($malecount , 'Number of Males'),
            array($femalecount, 'Number of Females')
                 );
         makecsv($temp, "staffcount.csv", false);
          ?>
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
<body id="adminpanel" >

<?php
$currentClassName='';
if(isset($_POST['classnamedropdown'])){ $currentClassName = $_POST['classnamedropdown']; }
?>

<?php

invite::invite_staff($orgId,$deptName,$adminid);

function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
?>



<div id="wrap">

	<div class="container-fluid">
		<?php include 'headerteamadmin.php';?>


		<div class="row" >

			<div class="col-sm-1">
			</div>

			<div class="col-sm-10" style="margin-top:2em;">
				<div class="col-sm-12" >
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
							<li style="width:10em; text-align:center;" class="active"><a data-toggle="tab" href="#students">STAFF</a></li>
							<li style="width:10em; text-align:center;"><a data-toggle="tab" href="#maps">MAPS</a></li>
							<li style="width:10em; text-align:center;"><a data-toggle="tab" href="#language">LANGUAGE</a></li>
							<li style="width:10em; text-align:center;"><a data-toggle="tab" href="#religion">BELIEF</a></li>
							<li style="width:10em; text-align:center;"><a data-toggle="tab" href="#key_facts">KEY FACTS</a></li>
							<li style="width:10em; text-align:center;"><a data-toggle="tab" href="#export">EXPORT</a></li>

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
									echo "<b> Team Name: </b>";
									echo '<select name="classnamedropdownstutab" style="padding:0.3em;" >';
									while ($rowp = mysql_fetch_array($resultp)){
										$selected = ($rowp['teamname'] == $currentClassName) ? 'selected="selected"' : '';
										echo '<option value="'.$rowp['teamname'].'"'.$selected.' >'.$rowp['teamname'].'</option>';
										//$teamName = $rowp['teamname'];
									}
									echo '</select>';// Close your drop down box


									mysql_close($con);
									?>
									<input type="submit" id="submitvalstutab" class="submitbtunnew" name="submitvalstutab" value="SUBMIT">






									<br><br>
									<?php

									include 'connection.php';





									$queryteachers = "select * from staff where orgid = '".$orgId."' AND deptname = '".$deptName."' AND teamname ='".$teamName."' order by firstname" ;
									$resultteachers = mysql_query($queryteachers);
									if($resultteachers == TRUE){
									$j=1;
									$k=1;
									echo "<table class='table table-striped table-bordered table-hover' cellspacing='0' width='100%'  >";
									echo "<thead style='background-color:#FFD799 !important;'>";
									echo "<tr>";
									echo "<th style='padding:1%; '>S.No</th>";
									echo "<th style='padding:1%;'>Employee Name</th>";
									echo "<th style='padding:1%;'>Employee Email ID*</th>";

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

									echo "<th style='padding:1%;'>Info</th>";
									echo "<th style='padding:1%;'>Status</th>";
									echo "<th style='padding:1%;'>Options</th>";
									echo "</tr>";
									echo "</thead>";
									?>

									<tr style="background-color:#CCC;">
										<td></td>
										<td><input type="text" class="form-control" name="name" id="name" placeholder="Employee Name" value="<?php echo $name; ?>" >
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
										<td><button type="submit" class="btn btn-default" name="invite" id="invite" style="background-color:#A1C564; color:#FFF;" title="INVITE">INVITE</button>

										</td>

									</tr>
									<?php

									$countnum = 1;
									while ($rowj=mysql_fetch_array($resultteachers)){

										$studentNameTemp = "";
										if($rowj['firstname'] == "NULL"){
											$studentNameTemp = "Waiting acceptance";
										}else{
											$studentNameTemp =	$rowj['firstname'];
										}
										echo "<tr>";

										echo "<td  style='padding:1%;' class='text-center'>";
										echo "<span>".$countnum."</span>";
										echo "</td>";

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
										/*echo "<span>".$rowj['staffemailid']."</span>";
                                        echo "</td>";*/
										$p_staff_email = $rowj['staffemailid'] ;
										if($rowj['firstname'] == "*******"){$p_staff_email="****@****";}
										echo "<span>".$p_staff_email."</span>";
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
										// peyman code
										if($rowj['status'] == 'active' && $rowj['firstname'] != "*******" ){
											echo '<a style="text-decoration:underline; cursor:pointer;" name="view" id="'.$rowj['staffemailid'].'" data-toggle="modal" data-target="#dataModal" class="view_data"> View Profile</a>';
										}else if($rowj['firstname'] == "*******"){
											echo "";
										}else{
											echo "Waiting approval <button class='btn btn-default' style='background-color:#A1C564; color:#FFF;'>Resned</button>";
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
										echo "<td  style='padding:1%; '>";

										?>
										<a href="#" data-href="deletestaff.php?id=<?php echo $rowj['staffemailid']; ?>" data-id="<?php echo $studentNameTemp." ".$lname; ?>" class="staffinfo" data-toggle="modal" data-target="#confirm-delete">
											<img src='images/deletehover.png' width='16' height='16' onmouseover="this.src='images/delete.png';" onmouseout="this.src='images/deletehover.png';" />
										</a>

										<?php
										if($rowj['status'] == 'active' && $rowj['firstname'] != "*******" ){
											?> <a style="text-decoration:underline;cursor:pointer;" name="editstaff" id="<?php echo $rowj['staffemailid'] ?>"  class="editstaff_data">
												<img src='images/edit.png' width='16' height='16' onmouseover="this.src='images/edithover.png';" onmouseout="this.src='images/edit.png';" />
											</a>

										<?php
										}
										?>


										<?php
										echo "</td>";

										echo "</tr>";

										$countnum++;
									}
									?>

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
											while($row = mysql_fetch_assoc($result)) {
												echo "<b>";
												echo $row['x'];
												echo ": </b>&nbsp;";
												echo $row['COUNT( * )'];
												echo "<br/>";
											} ?>

										</div>
										<a href="teamadminregionout.csv" id="CSVFILE">EXPORT To CSV</a>
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
								<div class="btn-group">
									<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" style="width:10em;" aria-expanded="false" id="charttypebtn" name="charttypebtn">
										Select chart type <span class="caret"></span>
									</button>
									<ul class="dropdown-menu" role="menu">
										<li><a class="pie-btn">Pie chart</a></li>
										<li><a class="bar-btn">Bar chart</a></li>
									</ul>
								</div>










								<br><br>


								<div id="languagechart" style="width: '100%'; clear:both; height:auto;">
								</div>
								<div id="languagetext">
									<?php
									include 'connection.php';


									$result = mysql_query("SELECT languagename, COUNT( languagename ) FROM stafflanguage where staffemailid IN(SELECT staffemailid FROM staff where orgid='".$orgId."' AND teamname='".$teamName."' AND deptname='".$deptName."') GROUP BY languagename ORDER BY COUNT( languagename ) DESC");



									while($row = mysql_fetch_assoc($result)) {
										echo "<b>";
										echo $row['languagename'];
										echo ": </b>&nbsp;";
										echo $row['COUNT( languagename )'];
										echo "<br/>";
									} mysql_close($con);?>
								</div>
								<a href="teamadminlangout.csv" id="CSVFILE">EXPORT To CSV</a>

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




									while($row = mysql_fetch_assoc($result)) {
										echo "<b>";
										echo $row['religion'];
										echo ": </b>&nbsp;";
										echo $row['COUNT( religion )'];
										echo "<br/>";
									} ?>

								</div>
								<a href="teamadminreligonout.csv" id="CSVFILE">EXPORT To CSV</a>
							</div>




							<div id="key_facts" class="tab-pane fade">


								<br><br>
								<!--<br>
                        <strong> The description of the Key Facts goes here.</strong>
                      <br>
                                       <ul style="list-style-image:url(images/lkeyfactsicon.png);">
                         <li><a href="#" target="_blank" style="color:#000;">Fact 1</a></li><br>
                                        <li><a href="#" target="_blank" style="color:#000;">Fact 2</a></li><br>
                                        <li><a href="#" target="_blank" style="color:#000;">Fact 3</a></li><br>
                                        <li><a href="#" target="_blank" style="color:#000;">Fact 4</a></li><br>
                                      </ul>-->


								<?php
								//$result_num_of_language_spoken = num_of_language_spoken($orgId,$teamName,$deptName);
								echo "<ul style='color: black; line-height: 200%; font-size: medium;'>";															echo "<li>";
								echo PSCO_func::languages($orgId,$teamName,$deptName);
								echo "</li>";
								echo "<li>";
								echo PSCO_func::different_faiths($orgId,$teamName,$deptName);
								echo "</li>";
								echo "<li>";
								echo PSCO_func::count_Languages($orgId,$teamName,$deptName);
								echo "</li>";
								echo "<li>";
								echo PSCO_func::grandparents($orgId,$teamName,$deptName);
								echo "</li>";
								echo "<li>";
								echo PSCO_func::Highest_number($orgId,$teamName,$deptName);
								echo "</li>";
								echo "<li>";
								echo PSCO_func::How_many_number($orgId,$teamName,$deptName);
								echo "</li>";
								echo "<li>";
								echo PSCO_func::born_country($orgId,$teamName,$deptName);
								echo "</li>";
								echo "<li>";
								echo PSCO_func::male_female_know_language($orgId,$teamName,$deptName);
								echo "</li>";
								echo "<li>";
								echo PSCO_func::cultures_country_influence($orgId,$teamName,$deptName);
								echo "</li>";
								echo "<li>";
								echo PSCO_func::num_of_language_spoken($orgId,$teamName,$deptName)[0];
								echo "</li>";
								echo "<li>";
								echo PSCO_func::num_of_language_spoken($orgId,$teamName,$deptName)[1];
								echo "</li>";
								echo "<li>";
								echo PSCO_func::num_of_language_spoken($orgId,$teamName,$deptName)[2];
								echo "</li>";
								echo "<li>";
								echo PSCO_func::invitation_status($orgId,$teamName,$deptName);
								echo "</li>";


								echo "</ul>";

								?>
							</div>



							<div id="export" class="tab-pane fade">
								<div class="infogram-embed" data-id="ancestryatlas-536" data-type="interactive" data-title="AncestryAtlas"></div><script>!function(e,t,s,i){var n="InfogramEmbeds",o=e.getElementsByTagName("script"),d=o[0],r=/^http:/.test(e.location)?"http:":"https:";if(/^\/{2}/.test(i)&&(i=r+i),window[n]&&window[n].initialized)window[n].process&&window[n].process();else if(!e.getElementById(s)){var a=e.createElement("script");a.async=1,a.id=s,a.src=i,d.parentNode.insertBefore(a,d)}}(document,0,"infogram-async","//e.infogr.am/js/dist/embed-loader-min.js");</script>                              <br>
								<form action="exportteacher.php" target="_blank" method="post">

									<br>
									<div id='png'></div>
									<br>
									<input type="submit" value="Export">
									<br>






									<!-- AddToAny BEGIN -->
									<br>

									<div class="a2a_kit a2a_kit_size_32 a2a_default_style">
										<a class="a2a_dd" href="https://www.addtoany.com/share"></a>
										<a class="a2a_button_email"></a>
										<a class="a2a_button_facebook"></a>
										<a class="a2a_button_linkedin"></a>
										<a class="a2a_button_twitter"></a>
									</div>
									<script>
										var a2a_config = a2a_config || {};
										a2a_config.linkname = "Cultural Diversity Map";
										a2a_config.linkurl = "https://infogr.am/ancestryatlas-536";
										a2a_config.color_main = "D7E5ED";
										a2a_config.color_border = "AECADB";
										a2a_config.color_link_text = "333333";
										a2a_config.color_link_text_hover = "333333";
									</script>
									<script async src="https://static.addtoany.com/menu/page.js"></script>
									<!-- AddToAny END -->   </form>
							</div>











						</div>
					</div>



				</div>


			</div>

			<div class="col-sm-1" >

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
	header('Location:../index.php');

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
				['Language', 'NumberOfStudent',{ role: 'style' }],


				<?php
                    include 'connection.php';



                    $result = mysql_query("SELECT languagename, COUNT( languagename ) FROM stafflanguage where staffemailid IN(SELECT staffemailid FROM staff where orgid='".$orgId."' AND teamname='".$teamName."' AND deptname='".$deptName."') GROUP BY languagename ORDER BY COUNT( languagename ) DESC");

                    while($row = mysql_fetch_assoc($result)) {

                    ?>
				['<?php echo $row['languagename']; ?>',<?php echo $row['COUNT( languagename )']; ?>,'<?php echo generateRandomColor(); ?>'],


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
				['Language', 'NumberOfStudent',{ role: 'style' }],


				<?php
                    include 'connection.php';
                    $gen="male";

                    $result = mysql_query("SELECT languagename, COUNT( languagename ) FROM stafflanguage where staffemailid IN(SELECT staffemailid FROM staff where orgid='".$orgId."' AND teamname='".$teamName."' AND deptname='".$deptName."' AND gender='".$gen."') GROUP BY languagename ORDER BY COUNT( languagename ) DESC");

                    while($row = mysql_fetch_assoc($result)) {

                    ?>
				['<?php echo $row['languagename']; ?>',<?php echo $row['COUNT( languagename )']; ?>,'<?php echo generateRandomColor(); ?>'],


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
				['Language', 'NumberOfStudent',{ role: 'style' }],


				<?php
                    include 'connection.php';
                    $gen="female";

                    $result = mysql_query("SELECT languagename, COUNT( languagename ) FROM stafflanguage where staffemailid IN(SELECT staffemailid FROM staff where orgid='".$orgId."' AND teamname='".$teamName."' AND deptname='".$deptName."' AND gender='".$gen."') GROUP BY languagename ORDER BY COUNT( languagename ) DESC");


                    while($row = mysql_fetch_assoc($result)) {

                    ?>
				['<?php echo $row['languagename']; ?>',<?php echo $row['COUNT( languagename )']; ?>,'<?php echo generateRandomColor(); ?>'],


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
				['Language', 'NumberOfStudent',{ role: 'style' }],


				<?php
                    include 'connection.php';
                    $gen="others";

                    $result = mysql_query("SELECT languagename, COUNT( languagename ) FROM stafflanguage where staffemailid IN(SELECT staffemailid FROM staff where orgid='".$orgId."' AND teamname='".$teamName."' AND deptname='".$deptName."' AND gender='".$gen."') GROUP BY languagename ORDER BY COUNT( languagename ) DESC");


                    while($row = mysql_fetch_assoc($result)) {

                    ?>
				['<?php echo $row['languagename']; ?>',<?php echo $row['COUNT( languagename )']; ?>,'<?php echo generateRandomColor(); ?>'],


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

<!-- view profile MODAL-->
<div id="modal_user_profile" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">

			<div class="modal-body" id="user_profile">
				<?php
				require_once 'user_profile.php';
				echo user_profile::get_profile($_SESSION['teamemailidorg']);
				?>
			</div>

		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('#btn_user_profile').click(function(){
			$('#modal_user_profile').modal("show");
		});
	});
</script>

<!-- change pass -->
<div id="modal_change_pass_user" class="modal fade">

</div>
<script type="text/javascript">
	$( "#modal_change_pass_user" ).load( "page/modal_change_pass_user.html" );
	setTimeout(function(){$("#change_pass_act").attr('value','team_user_change_pass');console.log($("#change_pass_act"));},1000);
</script>


<!-- DELETE STAFF MODAL -->
<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h3 style="font-weight:bold;">Delete Employee details</h3>
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



<!-- EDIT STAFF MODAL  -->


<div id="edit_data_Modal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" style="text-align:center; "font-weight:bold; ">Update Employee's Details</h4>
			</div>
			<div class="modal-body">

				<form  method="post" id="update_form" class="form-horizontal">
					<h3 style="padding: 1% 0%; background-color:#FE8885; color:#FFF; text-align:center;  border-radius: 8px;">PERSONAL DETAILS</h3>
					<div class="form-group">
						<label class="control-label col-sm-3" for="staffemail" style="visibility: hidden;">Email ID:</label>
						<div class="col-sm-9">
							<input type="email" class="form-control" id="staffemail" name="staffemail" readonly style="background-color:#e2e2e2;visibility: hidden;">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-3" for="firstname" >First Name:</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="firstname" name="firstname" readonly >
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-3" for="lastname">Last Name:</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="lastname" name="lastname" readonly >
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-3" for="gender">Gender:</label>
						<div class="col-sm-9">
							<select name="gender" id="gender" class="form-control">
								<option value="male">Male</option>
								<option value="female">Female</option>
								<option value="others">Others</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-3" for="beliefreligion">Belief/Religion:</label>
						<div class="col-sm-9">
							<div class="col-sm-6" >
								<input type="text" class="form-control" id="beliefreligion" name="beliefreligion" >
							</div>
							<div class="col-sm-6">
								<input id="checko" type="checkbox" >
								<label style="margin-top:0.5em">&nbsp;Don&apos;t want to answer</label>
							</div>
						</div>
					</div>
					<h3 style="padding: 1% 0%; background-color:#FE8885; color:#FFF; text-align:center;  border-radius: 8px;">BIRTH COUNTRIES</h3>
					<div class="form-group">
						<label class="control-label col-sm-3" for="sb">Employee:</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="sb" name="sb" >
						</div>
					</div>

					<hr>
					<div class="form-group">
						<label class="control-label col-sm-3" for="m">Mother:</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="m" name="m" >
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-3" for="gfm">GrandFather:</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="gfm" name="gfm" >
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-3" for="gmm">GrandMother:</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="gmm" name="gmm" >
						</div>
					</div>

					<hr>
					<div class="form-group">
						<label class="control-label col-sm-3" for="f">Father:</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="f" name="f" >
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-3" for="gff">GrandFather:</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="gff" name="gff" >
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-3" for="gmf">GrandMother:</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="gmf" name="gmf" >
						</div>


					</div>

					<br>
					<input type="submit" name="update" id="update" value="Save" class="btn btn-success "  />
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>


				</form>

			</div>

		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		var $vvpat;
		$('#add').click(function(){
			$('#insert').val("Insert");
			$('#insert_form')[0].reset();
		});

		$(document).on('click', '.editstaff_data', function(){
			var employee_id = $(this).attr("id");
			$.ajax({
				url:"fetchstaffinfo.php",
				method:"POST",
				data:{employee_id:employee_id},
				dataType:"json",
				success:function(data){
					var datastaff=data['arr1'];
					var datastaffbirth=data['arr2'];
					$('#staffemail').val(datastaff.staffemailid);
					$('#firstname').val(datastaff.firstname);
					$('#lastname').val(datastaff.lastname);
					$('#gender').val(datastaff.gender);

					if(datastaff.religion == 'Non Disclosed'){
						$('#checko').prop('checked', true);
						$('#beliefreligion').prop('readonly',true);
						$('#beliefreligion').val('Belief/Religion');
						$('#beliefreligion').css('color','#CCC');

					}else{
						$('#checko').prop('checked', false);
						$('#beliefreligion').prop("readonly",false);
						$('#beliefreligion').val(datastaff.religion);
						$('#beliefreligion').css('color','#000');
					}


					$('#sb').val(datastaffbirth.staffbirthplace);
					$('#m').val(datastaffbirth.staffmotherbirthplace);
					$('#gfm').val(datastaffbirth.staffmothersfatherbirthplace);
					$('#gmm').val(datastaffbirth.staffmothersmotherbirthplace);
					$('#f').val(datastaffbirth.stafffatherbirthplace);
					$('#gff').val(datastaffbirth.stafffathersfatherbirthplace);
					$('#gmf').val(datastaffbirth.stafffathersmotherbirthplace);

					$('#edit_data_Modal').modal('show');
				}
			});
		});

		$('#update_form').on("submit", function(event){
			event.preventDefault();
			if($('#staffemail').val() == "")
			{
				alert("Email ID is required");
			}
			else if($('#firstname').val() == '')
			{
				alert("First Name is required");
			}
			else if($('#gender').val() == '')
			{
				alert("Gender is required");
			}
			else if($('#beliefreligion').val() == '')
			{
				alert("Belief/Religion is required");
			}
			else if($('#sb').val() == '')
			{
				alert("Staff Birthplace is required");
			}
			else if($('#m').val() == '')
			{
				alert("Mother's Birthplace is required");
			}
			else if($('#gfm').val() == '')
			{
				alert("Grandfather (Mother's side) Birthplace is required");
			}
			else if($('#gmm').val() == '')
			{
				alert("Grandmother (Mother's side) Birthplace is required");
			}
			else if($('#f').val() == '')
			{
				alert("Father's Birthplace is required");
			}
			else if($('#gff').val() == '')
			{
				alert("Grandfather (Father's side) Birthplace is required");
			}
			else if($('#gmf').val() == '')
			{
				alert("Grandmother (Father's side) Birthplace is required");
			}
			else
			{



				$.ajax({
					url:"validatecountryname.php",
					method:"POST",
					data:$('#update_form').serialize(),
					success:function(data){

						if(data == "No error"){

							//SECOND CALL
							$.ajax({
								url:"updatestaffdetails.php",
								method:"POST",
								data:$('#update_form').serialize(),
								success:function(data){

									if(data == "No error"){

										$('#edit_data_Modal').modal('hide');
										alert("Data updation successfull.");
										window.location.reload(true);


									}else{
										alert(data);
									}



								}
							});


						}else{
							//Displays error message of first call
							alert(data);
						}
						/*$('#insert_form')[0].reset();
						 $('#add_data_Modal').modal('hide');
						 $('#employee_table').html(data)alert(data);;  */
					}
				});

				/*
				 $.ajax({
				 url:"validatecountryname.php",
				 method:"POST",
				 data:$('#insert_form').serialize(),
				 beforeSend:function(){
				 $('#insert').val("Inserting");
				 },
				 success:function(data){
				 $('#insert_form')[0].reset();
				 $('#add_data_Modal').modal('hide');
				 $('#employee_table').html(data);
				 }
				 });*/
			}
		});

	});
</script>