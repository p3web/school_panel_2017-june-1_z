<?php
ob_start();
session_cache_expire();
session_start();

require_once 'PSCO_function.php';
require_once 'invite.php';
require_once 'user_profile.php';
require_once 'language.php';
require_once 'religion.php';
?>
<?php
$adminid = $_SESSION['emailid'];

include 'connection.php';


$queryp = "select * from teacher where 	teacheremailid = '" . $adminid . "'";

$resultp = mysql_query($queryp);
$adminName = "";
$schoolId = "";
while ($rowp = mysql_fetch_array($resultp)) {

    $adminName = $rowp["firstname"] . " " . $rowp["lastname"];

    $schoolId = $rowp["schoolid"];
}

function generateRandomColor()
{
    $randomcolor = '#' . strtoupper(dechex(rand(0, 10000000)));
    if (strlen($randomcolor) != 7) {
        $randomcolor = str_pad($randomcolor, 10, '0', STR_PAD_RIGHT);
        $randomcolor = substr($randomcolor, 0, 7);
    }
    return $randomcolor;
}


//school details
$queryp = "select * from school where 	schoolid = '" . $schoolId . "'";
$resultp = mysql_query($queryp);
$schoolName = $city = $suburb = "";

while ($rowp = mysql_fetch_array($resultp)) {


    $schoolName = $rowp["schoolname"];
    $city = $rowp["city"];
    $suburb = $rowp["suburb"];

}

//class details
$query = "select classname from classteacher where schoolid = '" . $schoolId . "' AND teacheremailid = '" . $adminid . "'";
$result = mysql_query($query);
$className = "";

//while ($rowp = mysql_fetch_array($result)){
//$className = $rowp["classname"];
//}

//Select only first class
$rowp = mysql_fetch_array($result);
$className = $rowp["classname"];


mysql_close($con);


function makecsv($data, $csvfilename, $scriptrun = null)
{
    if (null === $scriptrun) {
        $scriptrun = true;
    }
    $list = $data;

    $file = fopen($csvfilename, "w");
    fputcsv($file, array($GLOBALS['schoolName'],
            $GLOBALS['suburb'] . "/" . $GLOBALS['city'] . "/Australia")
    );

    foreach ($list as $line) {
        fputcsv($file, $line);
    }

    fclose($file);
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
    <title>Teacher Panel</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>

    <!--
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css">

    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
    -->

    <link rel="stylesheet" type="text/css" href="css/style.css">

    <!--  AUTO COMPLETE MATERIAL -->
    <link rel="stylesheet" href="css/jquery-ui.css">
    <script src="scripts/jquery-ui.js"></script>


    <script src="page/js/ajax.js"></script>


    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/data.js"></script>
    <script src="https://code.highcharts.com/modules/drilldown.js"></script>

    <script src="page/js/chart.js"></script>

    <!--Jquery function to autocomplete country name -->
    <script>
        $(function () {

            $("#sb").autocomplete({
                source: 'autocompletecountry.php'
            });

            $("#m").autocomplete({
                source: 'autocompletecountry.php'
            });

            $("#gfm").autocomplete({
                source: 'autocompletecountry.php'
            });

            $("#gmm").autocomplete({
                source: 'autocompletecountry.php'
            });

            $("#f").autocomplete({
                source: 'autocompletecountry.php'
            });

            $("#gff").autocomplete({
                source: 'autocompletecountry.php'
            });

            $("#gmf").autocomplete({
                source: 'autocompletecountry.php'
            });
        });


    </script>
    <!--Jquery function to autocomplete country name -->
    <script>
        $(function () {
            $("#beliefreligion").autocomplete({
                source: 'autocompletereligion.php'
            });
        });

    </script>
    <script>
        $(document).ready(function () {

            $('#checko').change(function () {


                if ($(this).prop("checked") == true) {

                    $("#beliefreligion").prop("readonly", true);
                    $('#beliefreligion').val('Belief/Religion');
                    $('#beliefreligion').css('color', '#CCC');

                }
                else if ($(this).prop("checked") == false) {
                    $("#beliefreligion").prop("readonly", false);
                    $('#beliefreligion').val('');
                    $('#beliefreligion').css('color', '#000');
                }

            });
        });
    </script>

    <style>

        @font-face {
            font-family: MuseoSans_300;
            src: url(fonts/MuseoSans_300.ttf);
            font-weight: normal;
            font-style: normal;

        }

        table.borderless td, table.borderless th {
            border: none !important;
            height: 0% auto !important;
            padding: 0% !important;
        }

        table {
            border: none !important;
        }

        .ui-autocomplete {
            z-index: 5000;
        }

    </style>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">

        // Load Charts and the corechart package.
        google.charts.load('current', {'packages': ['corechart']});
        google.charts.setOnLoadCallback(drawRegionsMap);

        // Draw the donut chart .
        google.charts.setOnLoadCallback(drawLanguageChart);

        //Draw religion bar chart
        google.charts.setOnLoadCallback(drawReligionChart);


        $(window).resize(function () {
            drawRegionsMap();
            drawLanguageChart();
            drawReligionChart();

        });

        <?php
        function mysqlquery_religion($className, $schoolId)
        {
            include 'connection.php';
            $result = mysql_query("SELECT religion, COUNT( religion ) FROM student where schoolid='" . $schoolId . "' AND classname='" . $className . "' AND status='active' GROUP BY religion ORDER BY COUNT( religion ) DESC");
            return $result;
        }
        ?>

        function drawReligionChart() {
            var data = google.visualization.arrayToDataTable([
                ["Religion", "NumberOfStudent"],
                <?php
                include 'connection.php';

                if (!empty($_POST['classnamedropdownbeltab'])) {
                    $className = $_POST['classnamedropdownbeltab'];
                }

                $result = mysql_query("SELECT religion, COUNT( religion ) FROM student where schoolid='" . $schoolId . "' AND classname='" . $className . "' AND status='active' GROUP BY religion ORDER BY COUNT( religion ) DESC");
                $result1 = mysql_query("SELECT religion, COUNT( religion ) FROM student where schoolid='" . $schoolId . "' AND classname='" . $className . "' AND status='active' GROUP BY religion ORDER BY COUNT( religion ) DESC");


                while($row = mysql_fetch_assoc($result)) {

                ?>
                ['<?php echo $row['religion']; ?>', <?php echo $row['COUNT( religion )']; ?>],


                <?php  } ?>

            ]);

            var view = new google.visualization.DataView(data);
            view.setColumns([0, 1,
                {
                    calc: "stringify",
                    sourceColumn: 1,
                    type: "string",
                    role: "annotation"
                }
            ]);

            var options = {
                pieHole: 0.4,
                width: screen.width * 0.9,
                height: screen.height / 2,
                backgroundColor: {fill: 'transparent'}
            };
            var chart = new google.visualization.PieChart(document.getElementById("barchart_values"));
            chart.draw(view, options);
            <?php
            $output = array();
            while ($row = mysql_fetch_assoc($result1)) {
                $output[] = $row;
            }
            makecsv($output, "teacherreligonout.csv", false);
            ?>
            //var religonchart = (chart.getImageURI());
            document.getElementById('pngaddresstoexport').value = ' + chart.getImageURI() + ';
            //document.getElementById("pngaddresstoexport").value = chart.getImageURI();

        }


        function drawRegionsMap() {
            var data = google.visualization.arrayToDataTable([
                ['Country', 'NumberofPersons'],

                <?php
                include 'connection.php';
                if (!empty($_POST['classnamedropdown'])) {
                    $className = $_POST['classnamedropdown'];
                }

                $unionAllOption = 0;
                //starting query
                $querytest = "";


                if (!empty($_POST['formDoor'])) {
                    $querytest .= "select x , COUNT( * )  from(";
                    $aDoor = $_POST['formDoor'];
                    $N = count($aDoor);
                    for ($i = 0; $i < $N; $i++) {
                        if ($aDoor[$i] == 'S') {
                            $querytest .= " select `studentbirthplace` as x from studentbirthdetails where studentemailid IN(SELECT studentemailid FROM student where schoolid='" . $schoolId . "'  AND classname='" . $className . "')";
                            $unionAllOption = 1;
                        }
                        if ($aDoor[$i] == 'F') {
                            if ($unionAllOption == 1) {
                                $querytest .= " UNION ALL";
                            }
                            $querytest .= " select `studentfatherbirthplace` as x from studentbirthdetails  where studentemailid IN(SELECT studentemailid FROM student where schoolid='" . $schoolId . "'  AND classname='" . $className . "')";
                            $unionAllOption = 1;
                        }
                        if ($aDoor[$i] == 'M') {
                            if ($unionAllOption == 1) {
                                $querytest .= " UNION ALL";
                            }
                            $querytest .= " select `studentmotherbirthplace` as x from studentbirthdetails  where studentemailid IN(SELECT studentemailid FROM student where schoolid='" . $schoolId . "'  AND classname='" . $className . "')";
                            $unionAllOption = 1;
                        }
                        if ($aDoor[$i] == 'GFFS') {
                            if ($unionAllOption == 1) {
                                $querytest .= " UNION ALL";
                            }
                            $querytest .= " select `studentfathersfatherbirthplace` as x from studentbirthdetails  where studentemailid IN(SELECT studentemailid FROM student where schoolid='" . $schoolId . "'  AND classname='" . $className . "')";
                            $unionAllOption = 1;
                        }
                        if ($aDoor[$i] == 'GMFS') {
                            if ($unionAllOption == 1) {
                                $querytest .= " UNION ALL";
                            }
                            $querytest .= " select `studentfathersmotherbirthplace` as x from studentbirthdetails  where studentemailid IN(SELECT studentemailid FROM student where schoolid='" . $schoolId . "'  AND classname='" . $className . "')";
                            $unionAllOption = 1;
                        }
                        if ($aDoor[$i] == 'GFMS') {
                            if ($unionAllOption == 1) {
                                $querytest .= " UNION ALL";
                            }
                            $querytest .= " select `studentmothersfatherbirthplace` as x from studentbirthdetails  where studentemailid IN(SELECT studentemailid FROM student where schoolid='" . $schoolId . "'  AND classname='" . $className . "')";
                            $unionAllOption = 1;
                        }
                        if ($aDoor[$i] == 'GMMS') {
                            if ($unionAllOption == 1) {
                                $querytest .= " UNION ALL";
                            }
                            $querytest .= " select `studentmothersmotherbirthplace` as x from studentbirthdetails  where studentemailid IN(SELECT studentemailid FROM student where schoolid='" . $schoolId . "'  AND classname='" . $className . "')";
                            $unionAllOption = 1;
                        }
                    }

                    $querytest .= " ) as temptable group by x";
                }







                // Default values goes here
                if ($querytest == "") {

                    $querytest = "select x , COUNT( * )  from( select `studentbirthplace` as x from studentbirthdetails where studentemailid IN(SELECT studentemailid FROM student where schoolid='" . $schoolId . "'  AND classname='" . $className . "') ) as temptable group by x";
                }

                $currentQuerry = $querytest;

                $result = mysql_query($currentQuerry);
                $result1 = mysql_query($currentQuerry);

                while($row = mysql_fetch_assoc($result)) {

                ?>
                ['<?php echo $row['x']; ?>', <?php echo $row['COUNT( * )']; ?>], <?php } ?>

            ]);

            var options = {


                colorAxis: {minValue: 0, colors: ['#f6cbcb', '#af3634']},
                displayMode: 'regions',
                //width: 900,
                //height: 500,
                width: "80%",
                height: "500px",
                backgroundColor: {fill: 'transparent'}


            };

            var chart = new google.visualization.GeoChart(document.getElementById('regions_div'));


            // Wait for the chart to finish drawing before calling the getImageURI() method.
            google.visualization.events.addListener(chart, 'ready', function () {
                var imgUri = chart.getImageURI();
                document.getElementById('png').innerHTML = '<a href="' + imgUri + '" target="_blank">Printable version</a>';

            });


            chart.draw(data, options);
            <?php
            $output = array();
            while ($row = mysql_fetch_assoc($result1)) {
                $output[] = $row;
            }
            makecsv($output, "teacherregionmapdataout.csv", false);
            ?>
        }


        //function to draw language chart
        var languagechart;
        function drawLanguageChart() {

            var data = google.visualization.arrayToDataTable([
                ['Language', 'NumberOfStudent', {role: 'style'}],


                <?php
                include 'connection.php';

                if (!empty($_POST['classnamedropdownlantab'])) {
                    $className = $_POST['classnamedropdownlantab'];
                }

                $result = mysql_query("SELECT languagename, COUNT( languagename ) FROM studentlanguage where studentemailid IN(SELECT studentemailid FROM student where schoolid='" . $schoolId . "' AND classname='" . $className . "') GROUP BY languagename ORDER BY COUNT( languagename ) DESC");
                $result1 = mysql_query("SELECT languagename, COUNT( languagename ) FROM studentlanguage where studentemailid IN(SELECT studentemailid FROM student where schoolid='" . $schoolId . "' AND classname='" . $className . "') GROUP BY languagename ORDER BY COUNT( languagename ) DESC");


                while($row = mysql_fetch_assoc($result)) {

                ?>
                ['<?php echo $row['languagename']; ?>', <?php echo $row['COUNT( languagename )']; ?>, '<?php echo generateRandomColor(); ?>'],


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
                    bottom: 90,
                    //height: screen.height * 0.8
                },
                bar: {groupWidth: "95%"},
                legend: {position: "none"},
                backgroundColor: {fill: 'transparent'}
            };

            languagechart = new google.visualization.ColumnChart(document.getElementById('languagechart'));
            languagechart.draw(data, options);
            <?php
            $output = array();
            while ($row = mysql_fetch_assoc($result1)) {
                $output[] = $row;
            }
            makecsv($output, 'teacherlangout.csv', false);
            ?>
        }

        /*
         $(document).ready(function() {
         $('a[data-toggle="tab"]').on( 'shown.bs.tab', function (e) {
         $.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust();
         } );
         $('table.table').DataTable( {
         scrollY:        200,
         scrollCollapse: true,
         paging:         false
         } );
         } );
         */
    </script>

    <script>
        $(document).ready(function () {
            $('#checkoall').change(function () {
                ($(this).is(":checked") ? $('.checkboxes').prop("checked", true) : $('.checkboxes').prop("checked", false))

            });
        });
    </script>
    <!--adminPanel Css-->
    <link rel="stylesheet" type="text/css" href="css/AdminPanel.css">
</head>
<body id="adminpanel">

<?php

$currentClassName = '';
if (isset($_POST['classnamedropdown'])) {
    $currentClassName = $_POST['classnamedropdown'];
}
?>

<?php
invite::invite_student($schoolId, $adminid);

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>


<div id="wrap">
    <i class="glyphicon glyphicon-menu-hamburger" data-show="false" onclick="ToggleMenu(this)" id="menuIcon"></i>
    <div class="container-fluid">
        <?php include 'headerteacher.php'; ?>
        <!--Tab Control-->
        <div class="panelControl" id="MenuPanel">
            <a href="#"><img src="images/MenuIcons/MenuLogo.png" title="Ancestry Atlas" alt="Ancestry Atlas"></a>
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#students"><img src="images/MenuIcons/person.png">Students</a>
                </li>
                <li><a data-toggle="tab" href="#maps"><img src="images/MenuIcons/Map.png">Maps</a></li>
                <li><a data-toggle="tab" href="#language"><img src="images/MenuIcons/comment.png"> Language</a></li>
                <li><a data-toggle="tab" href="#religion"><img src="images/MenuIcons/heart.png">Belief</a></li>
                <li><a data-toggle="tab" href="#lessonplans"><i class="glyphicon glyphicon-blackboard"></i>Lesson Plans</a>
                </li>
                <li><a data-toggle="tab" href="#key_facts"><img src="images/MenuIcons/star.png"> Key Facts</a></li>
                <li><a data-toggle="tab" href="#export"><img src="images/MenuIcons/Compass.png">Export</a></li>


            </ul>

        </div>


        <div class="row">

            <div class="col-sm-1">
            </div>

            <div class="col-sm-10" style="margin-top:2em;">
                <div class="col-sm-12">
<!--                    <div class="col-sm-6">
                        <h2>Welcome to your Ancestry Atlas</h2>
                        <h5>Teacher -> &nbsp;<b><?php /*echo $adminName; */?></b></h5>
                        <!--
                        <p style="margin-top:1.5em;">As a teacher, you can now invite your students to register for Ancestry Atlas. <br>

           Track student registration below.<br>
           Preview your diversity maps at anytime
       </p>-->
             <!--       </div>

                    <div class="col-sm-6 text-right">
                        <h2><?php /*echo $schoolName; */?></h2>
                        <h5><?php /*echo $city . " / " . $suburb; */?></h5>
                    </div>
-->
                    <div class="col-sm-12" style="margin-top:2em;">

                        <div class="tab-content Lightbackground">
                            <div id="students" class="tab-pane fade in active">
                                <div class="headerContent">STUDENT</div>


                                <form method="post">
                                    <?php

                                    if (!empty($_POST['classnamedropdownstutab'])) {
                                        $className = $_POST['classnamedropdownstutab'];
                                        $currentClassName = $_POST['classnamedropdownstutab'];
                                    }
                                    include 'connection.php';
                                    $queryp = "select classname from classteacher where teacheremailid = '" . $adminid . "' AND schoolid = '" . $schoolId . "'";
                                    $resultp = mysql_query($queryp);
                                    echo "Class Name: ";
                                    echo '<select name="classnamedropdownstutab" >';
                                    while ($rowp = mysql_fetch_array($resultp)) {
                                        $selected = ($rowp['classname'] == $currentClassName) ? 'selected="selected"' : '';
                                        echo '<option value="' . $rowp['classname'] . '"' . $selected . ' >' . $rowp['classname'] . '</option>';
                                    }
                                    echo '</select>';// Close your drop down box
                                    mysql_close($con);
                                    ?>
                                    <input type="submit" id="submitvalstutab" name="submitvalstutab" value="SUBMIT">
                                    <a href="studentform/AA_Printable form.pdf" target="_blank"
                                       title="please click here for printable vesion of student form"
                                       style="color:#000;float:right; font-weight:bold; text-decoration:underline;">Printable
                                        Form</a>


                                    <br><br>
                                    <?php

                                    include 'connection.php';

                                    $queryteachers = "select * from student where schoolid = '" . $schoolId . "' AND classname = '" . $className . "'";
                                    $resultteachers = mysql_query($queryteachers);
                                    if ($resultteachers == TRUE){
                                    $j = 1;
                                    $k = 1;

                                    echo "<table class='table table-striped table-bordered' cellspacing='0' width='100%' >";
                                    echo "<thead style='background-color: #FFD799 !important;'>";
                                    echo "<tr>";
                                    echo "<th style='width:1%;'>S.No</th>";
                                    echo "<th>Student Name</th>";
                                    echo "<th>Email ID*</th>";

                                    /*
                                    echo "<th>Religion</th>";
                                    echo "<th>Student Birthplace</th>";
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
                                    ?>
                                    <tr style="background-color:#CCC;">
                                        <td></td>
                                        <td><input type="text" class="form-control" name="name" id="name"
                                                   placeholder="Waiting student" value="<?php echo $name; ?>">
                                        </td>
                                        <td><input type="email" class="form-control" id="email" name="email"
                                                   placeholder="Click here to add email address"
                                                   value="<?php echo $email; ?>">
                                        </td>

                                        <!--
                                        <td>Religion</td>
                                        <td>Student</td>
                                        <td>Father</td>
                                        <td>Mother</td>
                                        <td>grandfather (father)</td>
                                        <td>grandmother (father)</td>
                                        <td>grandfather (mother)</td>
                                        <td>grandfather (mother)</td>
                                        -->
                                        <td></td>
                                        <td></td>

                                        <td>
                                            <button type="submit" class="btn btn-default" name="invite" id="invite"
                                                    title="INVITE">INVITE
                                            </button>
                                        </td>

                                    </tr>
                                </form>
                                <?php
                                $countnum = 1;
                                while ($rowj = mysql_fetch_array($resultteachers)) {
                                    $Temp1 = "";
                                    if ($rowj['SNO'] == "NULL") {
                                        $Temp1 = "Waiting acceptance";
                                    } else {
                                        $Temp1 = $rowj['SNO'];
                                    }
                                    echo "<tr>";
                                    $studentNameTemp = "";
                                    if ($rowj['firstname'] == "NULL") {
                                        $studentNameTemp = "Waiting acceptance";
                                    } else {
                                        $studentNameTemp = $rowj['firstname'];
                                    }
                                    echo "<tr>";

                                    echo "<td  style='padding:1%;' class='text-center'>";
                                    echo "<span>" . $countnum . "</span>";
                                    echo "</td>";

                                    echo "<td style='padding:1%;'>";
                                    $lname = '';
                                    if ($rowj['lastname'] != 'null') {
                                        $lname = $rowj['lastname'];
                                    }
                                    echo "<span style='padding:0.7%;' id='j" . $j . "' >" . $studentNameTemp . " " . $lname . "</span>&nbsp;&nbsp;&nbsp;";
                                    $j = ++$j;
                                    $k = ++$k;
                                    echo "</td>";

                                    echo "<td  style='padding:1%;'>";
                                    echo "<span>" . $rowj['studentemailid'] . "</span>";
                                    echo "</td>";


                                    /*
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
                                    */


                                    //CLICK FOR INFORMATION LINK
                                    echo "<td  style='padding:1%; '>";
                                    if ($rowj['status'] == 'active') {

                                        echo '<a style="text-decoration:underline; cursor:pointer;" name="view" id="' . $rowj['studentemailid'] . '" data-toggle="modal" data-target="#dataModal" class="view_data"> View Profile</a>';
                                    } else {
                                        echo "Waiting approval";//<button class='btn btn-default' style='background-color:#A1C564; color:#FFF;'>Resned</button>";
                                    }
                                    echo "</td>";


                                    //STATUS
                                    echo "<td  style='padding:1%;'>";
                                    if ($rowj['status'] == 'active') {
                                        echo "<span> <img src='images/active.png'>&nbsp;active</span>";
                                    } else if ($rowj['status'] == 'pending') {
                                        echo "<span> <img src='images/pending.png'>&nbsp;pending</span>";
                                    } else {
                                        echo "<span>" . $rowj['status'] . "</span>";
                                    }
                                    echo "</td>";


                                    //EDIT and DELETE
                                    echo "<td  style='padding:1%;'>";

                                    ?>


                                    <a href="#" data-href="deletestudent.php?id=<?php echo $rowj['studentemailid']; ?>"
                                       data-id="<?php echo $studentNameTemp . " " . $lname; ?>" class="staffinfo"
                                       data-toggle="modal" data-target="#confirm-delete">
                                        <img src='images/deletehover.png' width='16' height='16'
                                             onmouseover="this.src='images/delete.png';"
                                             onmouseout="this.src='images/deletehover.png';"/>
                                    </a>

                                    <?php
                                    if ($rowj['status'] == 'active') {
                                        ?> <a style="text-decoration:underline;cursor:pointer;" name="editstaff"
                                              id="<?php echo $rowj['studentemailid'] ?>" class="editstaff_data">
                                            <img src='images/edit.png' width='16' height='16'
                                                 onmouseover="this.src='images/edithover.png';"
                                                 onmouseout="this.src='images/edit.png';"/>
                                        </a>

                                        <?php
                                    }


                                    ?>


                                    <!-- <a style="text-decoration:underline;cursor:pointer;" name="editstaff" id="<?php echo $rowj['studentemailid'] ?>"  class="editstaff_data"> Edit</a> -->

                                    <?php
                                    echo "</td>";
                                    echo "</tr>";

                                    $countnum++;
                                }

                                echo "</table>";
                                } else {
                                    echo "data fetching fail from teacher table.";
                                }

                                ?>

                                <span style="clear:both; float:left; margin-left:3em;" id="error"><?php
                                    echo $combineErr;

                                    ?></span>


                            </div>

                            <div id="maps" class="tab-pane fade">
                                <div class="headerContent">MAPS</div>

                                <div>
                                    <iframe src="page/TeacherPanelMap.html" style="width:75%;height:500px;border:none;"></iframe>
                                    <div  id="regions_div" style="display: none;float:left;"></div>

                                    <div style="float:right;">

                                        <div>
                                            <form method="post">

                                                <?php
                                                include 'connection.php';
                                                $queryp = "select classname from classteacher where teacheremailid = '" . $adminid . "' AND schoolid = '" . $schoolId . "'";
                                                $resultp = mysql_query($queryp);
                                                echo "Class Name:";
                                                echo '<select name="classnamedropdown">';
                                                while ($rowp = mysql_fetch_array($resultp)) {
                                                    $selected = ($rowp['classname'] == $currentClassName) ? 'selected="selected"' : '';
                                                    echo '<option value="' . $rowp['classname'] . '"' . $selected . ' >' . $rowp['classname'] . '</option>';
                                                }
                                                echo '</select>';// Close your drop down box
                                                mysql_close($con);


                                                ?>


                                                <br><br>
                                                <input type="checkbox" id="checkoall"/>&nbsp;All (select/unselect)<br/>
                                                <input type="checkbox" class="checkboxes" name="formDoor[]"
                                                       value="S" <?php if (isset($_POST['formDoor'])) {
                                                    $aDoor = $_POST['formDoor'];
                                                    $N = count($aDoor);
                                                    for ($i = 0; $i < $N; $i++) {
                                                        if ($aDoor[$i] == 'S') {
                                                            echo "checked='checked'";
                                                        }
                                                    }
                                                } ?>/>&nbsp;Student<br/>
                                                <input type="checkbox" class="checkboxes" name="formDoor[]"
                                                       value="F" <?php if (isset($_POST['formDoor'])) {
                                                    $aDoor = $_POST['formDoor'];
                                                    $N = count($aDoor);
                                                    for ($i = 0; $i < $N; $i++) {
                                                        if ($aDoor[$i] == 'F') {
                                                            echo "checked='checked'";
                                                        }
                                                    }
                                                } ?>/>&nbsp;Father<br/>
                                                <input type="checkbox" class="checkboxes" name="formDoor[]"
                                                       value="M" <?php if (isset($_POST['formDoor'])) {
                                                    $aDoor = $_POST['formDoor'];
                                                    $N = count($aDoor);
                                                    for ($i = 0; $i < $N; $i++) {
                                                        if ($aDoor[$i] == 'M') {
                                                            echo "checked='checked'";
                                                        }
                                                    }
                                                } ?>/>&nbsp;Mother<br/>
                                                <input type="checkbox" class="checkboxes" name="formDoor[]"
                                                       value="GFFS" <?php if (isset($_POST['formDoor'])) {
                                                    $aDoor = $_POST['formDoor'];
                                                    $N = count($aDoor);
                                                    for ($i = 0; $i < $N; $i++) {
                                                        if ($aDoor[$i] == 'GFFS') {
                                                            echo "checked='checked'";
                                                        }
                                                    }
                                                } ?> />&nbsp;Paternal GrandFather<br/>
                                                <input type="checkbox" class="checkboxes" name="formDoor[]"
                                                       value="GMFS" <?php if (isset($_POST['formDoor'])) {
                                                    $aDoor = $_POST['formDoor'];
                                                    $N = count($aDoor);
                                                    for ($i = 0; $i < $N; $i++) {
                                                        if ($aDoor[$i] == 'GMFS') {
                                                            echo "checked='checked'";
                                                        }
                                                    }
                                                } ?>/>&nbsp;Paternal GrandMother<br/>
                                                <input type="checkbox" class="checkboxes" name="formDoor[]"
                                                       value="GFMS" <?php if (isset($_POST['formDoor'])) {
                                                    $aDoor = $_POST['formDoor'];
                                                    $N = count($aDoor);
                                                    for ($i = 0; $i < $N; $i++) {
                                                        if ($aDoor[$i] == 'GFMS') {
                                                            echo "checked='checked'";
                                                        }
                                                    }
                                                } ?> />&nbsp;Maternal GrandFather<br/>
                                                <input type="checkbox" class="checkboxes" name="formDoor[]"
                                                       value="GMMS" <?php if (isset($_POST['formDoor'])) {
                                                    $aDoor = $_POST['formDoor'];
                                                    $N = count($aDoor);
                                                    for ($i = 0; $i < $N; $i++) {
                                                        if ($aDoor[$i] == 'GMMS') {
                                                            echo "checked='checked'";
                                                        }
                                                    }
                                                } ?>/>&nbsp;Maternal GrandMother<br/>


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
                                            $querytest = "";


                                            if (!empty($_POST['formDoor'])) {
                                                $querytest .= "select x , COUNT( * )  from(";
                                                $aDoor = $_POST['formDoor'];
                                                $N = count($aDoor);
                                                for ($i = 0; $i < $N; $i++) {
                                                    if ($aDoor[$i] == 'S') {
                                                        $querytest .= " select `studentbirthplace` as x from studentbirthdetails where studentemailid IN(SELECT studentemailid FROM student where schoolid='" . $schoolId . "'  AND classname='" . $className . "')";
                                                        $unionAllOption = 1;
                                                    }
                                                    if ($aDoor[$i] == 'F') {
                                                        if ($unionAllOption == 1) {
                                                            $querytest .= " UNION ALL";
                                                        }
                                                        $querytest .= " select `studentfatherbirthplace` as x from studentbirthdetails  where studentemailid IN(SELECT studentemailid FROM student where schoolid='" . $schoolId . "'  AND classname='" . $className . "')";
                                                        $unionAllOption = 1;
                                                    }
                                                    if ($aDoor[$i] == 'M') {
                                                        if ($unionAllOption == 1) {
                                                            $querytest .= " UNION ALL";
                                                        }
                                                        $querytest .= " select `studentmotherbirthplace` as x from studentbirthdetails  where studentemailid IN(SELECT studentemailid FROM student where schoolid='" . $schoolId . "'  AND classname='" . $className . "')";
                                                        $unionAllOption = 1;
                                                    }
                                                    if ($aDoor[$i] == 'GFFS') {
                                                        if ($unionAllOption == 1) {
                                                            $querytest .= " UNION ALL";
                                                        }
                                                        $querytest .= " select `studentfathersfatherbirthplace` as x from studentbirthdetails  where studentemailid IN(SELECT studentemailid FROM student where schoolid='" . $schoolId . "'  AND classname='" . $className . "')";
                                                        $unionAllOption = 1;
                                                    }
                                                    if ($aDoor[$i] == 'GMFS') {
                                                        if ($unionAllOption == 1) {
                                                            $querytest .= " UNION ALL";
                                                        }
                                                        $querytest .= " select `studentfathersmotherbirthplace` as x from studentbirthdetails  where studentemailid IN(SELECT studentemailid FROM student where schoolid='" . $schoolId . "'  AND classname='" . $className . "')";
                                                        $unionAllOption = 1;
                                                    }
                                                    if ($aDoor[$i] == 'GFMS') {
                                                        if ($unionAllOption == 1) {
                                                            $querytest .= " UNION ALL";
                                                        }
                                                        $querytest .= " select `studentmothersfatherbirthplace` as x from studentbirthdetails  where studentemailid IN(SELECT studentemailid FROM student where schoolid='" . $schoolId . "'  AND classname='" . $className . "')";
                                                        $unionAllOption = 1;
                                                    }
                                                    if ($aDoor[$i] == 'GMMS') {
                                                        if ($unionAllOption == 1) {
                                                            $querytest .= " UNION ALL";
                                                        }
                                                        $querytest .= " select `studentmothersmotherbirthplace` as x from studentbirthdetails  where studentemailid IN(SELECT studentemailid FROM student where schoolid='" . $schoolId . "'  AND classname='" . $className . "')";
                                                        $unionAllOption = 1;
                                                    }
                                                }

                                                $querytest .= " ) as temptable group by x";
                                            }

                                            // Default values goes here
                                            if ($querytest == "") {

                                                $querytest = "select x , COUNT( * )  from( select `studentbirthplace` as x from studentbirthdetails where studentemailid IN(SELECT studentemailid FROM student where schoolid='" . $schoolId . "'  AND classname='" . $className . "') ) as temptable group by x";
                                            }

                                            $result = mysql_query($querytest);
                                            while ($row = mysql_fetch_assoc($result)) {
                                                echo "<b>";
                                                echo $row['x'];
                                                echo ": </b>&nbsp;";
                                                echo $row['COUNT( * )'];
                                                echo "<br/>";
                                            }
                                            $result1 = mysql_query($querytest);
                                            $output = array();
                                            while ($row = mysql_fetch_assoc($result1)) {
                                                $output[] = $row;
                                            }
                                            makecsv($output, "regionout.csv")


                                            ?>

                                            <a href="regionout.csv" id="CSVFILE">EXPORT To CSV</a> <br>

                                        </div>
                                    </div>
                                </div>


                            </div>

                            <script type="text/javascript">

                                //_____ set base var
                                window.schoolId = '<?php echo $schoolId ?>';
                                window.className = '<?php echo 'S1'; $className = 'S1'; ?>';

                                //_____ exampel Chart Data

                                var donutSeries = {
                                    name: 'Language',
                                    data: <?php
                                    $result = language::get_chart_donut_language_teacher($schoolId, $className);
                                    echo $result;
                                    ?>
                                };

                                for (var i = 0; i < donutSeries.data.length; i++) {
                                    donutSeries.data[i][1] = parseFloat(donutSeries.data[i][1]);
                                }

                                var series = [{
                                    name: 'Language',
                                    colorByPoint: true,
                                    data: <?php
                                    $result = language::get_chart_language_teacher($schoolId, $className);
                                    echo $result;
                                    ?>
                                }];

                                for (var i = 0; i < series[0].data.length; i++) {
                                    series[0].data[i].y = parseFloat(series[0].data[i].y);
                                }

                                //_____ table Func
                                var TableData = {
                                    thName: ['Language', 'Count'],
                                    trData:<?php
                                    $result = language::get_table_language_teacher($schoolId, $className);

                                    echo $result;
                                    ?>
                                };
                            </script>

                            <div id="language" class="tab-pane fade">
                                <div class="headerContent">LANGUAGE</div>
                                <div class="TABContent">

                                </div>
                            </div>

                            <script type="text/javascript">
                                var flag = true;
                                function init_PSCO_chart() {
                                    $("#PSCO_chart").ready(function () {
                                        try {
                                            flag = false;
                                            TabelCreateor(TableData, 'langTable');
                                            BarChart('ChartContainer', series);

                                        } catch (e) {
                                            console.log(e);
                                        }
                                    });
                                    if (flag) {
                                        setTimeout(function () {
                                            init_PSCO_chart();
                                        }, 1000);
                                    }
                                }
                                $('#language .TABContent').load('page/Chart_teacher.html' , function () {
                                    setTimeout(function () {
                                        init_PSCO_chart();
                                    }, 1000);
                                });

                            </script>


                            <!-- ganerat data religion chart -->

                            <script type="text/javascript">

                                //_____ exampel Chart Data
                                var donutSeries_religion = {
                                    name: 'Religion',
                                    data: <?php
                                    $result = religion::get_chart_donut_religion_teacher($schoolId, $className);
                                    echo $result;
                                    ?>
                                };

                                for (var i = 0; i < donutSeries_religion.data.length; i++) {
                                    donutSeries_religion.data[i][1] = parseFloat(donutSeries_religion.data[i][1]);
                                }

                                var series_religion = [{
                                    name: 'Religion',
                                    colorByPoint: true,
                                    data: <?php
                                    $result = religion::get_chart_religion_teacher($schoolId, $className);
                                    echo $result;
                                    ?>
                                }];

                                for (var i = 0; i < series_religion[0].data.length; i++) {
                                    series_religion[0].data[i].y = parseFloat(series_religion[0].data[i].y);
                                }

                                //_____ table Func
                                var TableData_religion = {
                                    thName: ['Religion', 'Count'],
                                    trData:<?php
                                    $result = religion::get_table_religion_teacher($schoolId, $className);
                                    echo $result;
                                    ?>
                                };
                            </script>


                            <div id="religion" class="tab-pane fade">
                                <div class="headerContent">BELIEF</div>
                                <div class="TABContent">

                                </div>
                            </div>

                            <script type="text/javascript">
                                var flag = true;
                                function init_PSCO_chart_religion() {
                                    $("#PSCO_chart").ready(function () {
                                        try {
                                            flag = false;
                                            TabelCreateor(TableData_religion, 'langTable_religion');
                                            PieChart('ChartContainer_religion', series_religion);

                                        } catch (e) {
                                            console.log(e);
                                        }
                                    });
                                    if (flag) {
                                        setTimeout(function () {
                                            init_PSCO_chart_religion();
                                        }, 1000);
                                    }
                                }
                                $('#religion .TABContent').load('page/Belief_chart_teacher.html',function () {
                                    setTimeout(function () {
                                        init_PSCO_chart_religion();
                                    }, 1000);
                                });

                            </script>


                            <div id="key_facts" class="tab-pane fade">
<<<<<<< HEAD

=======
                                <div class="headerContent">KEY FACTS</div>
>>>>>>> b002a728f4dcec2aa087814e06be3fc5418d47a1
                                <br><br>
                                <!-- <br>
                      <strong> The description of the Key Facts goes here.</strong>
                    <br>
                                    <ul style="list-style-image:url(images/lkeyfactsicon.png);">
                       <li><a href="#" target="_blank" style="color:#000;">Fact 1</a></li><br>
                                      <li><a href="#" target="_blank" style="color:#000;">Fact 2</a></li><br>
                                      <li><a href="#" target="_blank" style="color:#000;">Fact 3</a></li><br>
                                      <li><a href="#" target="_blank" style="color:#000;">Fact 4</a></li><br>
                                    </ul>-->


                                <?php
                                //$result_num_of_language_spoken = num_of_language_spoken($schoolId,$className,$deptName);
                                echo "<ul style='color: black; line-height: 200%; font-size: medium;'>";
<<<<<<< HEAD
                                echo "<li>";
                                echo PSCO_func::languages($schoolId, $className);
                                echo "</li>";
                                echo "<li>";
                                echo PSCO_func::different_faiths($schoolId, $className);
                                echo "</li>";
                                echo "<li>";
                                echo PSCO_func::count_Languages($schoolId, $className);
                                echo "</li>";
                                echo "<li>";
                                echo PSCO_func::grandparents($schoolId, $className);
                                echo "</li>";
                                echo "<li>";
                                echo PSCO_func::Highest_number($schoolId, $className);
                                echo "</li>";
                                echo "<li>";
                                echo PSCO_func::How_many_number($schoolId, $className);
                                echo "</li>";
                                echo "<li>";
                                echo PSCO_func::born_country($schoolId, $className)[0];
                                echo "</li>";
                                echo "<li>";
                                echo PSCO_func::born_country($schoolId, $className)[1];
                                echo "</li>";
                                echo "<li>";
                                echo PSCO_func::born_country($schoolId, $className)[2];
                                echo "</li>";
                                echo "<li>";
                                echo PSCO_func::male_female_know_language($schoolId, $className);
                                echo "</li>";
                                echo "<li>";
                                echo PSCO_func::cultures_country_influence($schoolId, $className);
                                echo "</li>";
                                echo "<li>";
                                echo PSCO_func::top_migrant($schoolId, $className);
                                echo "</li>";
                                echo "<li>";
                                echo PSCO_func::num_of_language_spoken($schoolId, $className)[0];
                                echo "</li>";
                                echo "<li>";
                                echo PSCO_func::num_of_language_spoken($schoolId, $className)[1];
                                echo "</li>";
                                echo "<li>";
                                echo PSCO_func::num_of_language_spoken($schoolId, $className)[2];
                                echo "</li>";
                                echo "<li>";
                                echo PSCO_func::invitation_status($schoolId, $className);
                                echo "</li>";
                                echo "<li>";
                                echo PSCO_func::parent_born_overseas($schoolId, $className);
                                echo "</li>";
                                echo "<li>";
                                echo PSCO_func::gparent_born_overseas($schoolId, $className);
                                echo "</li>";
                                echo "<li>";
                                echo PSCO_func::age_language_stats($schoolId, $className);
                                echo "</li>";
                                echo "<li>";
                                echo PSCO_func::age_belief_stats($schoolId, $className);
                                echo "</li>";


=======
                                echo "<li>";//16
                                echo PSCO_func::invitation_status($schoolId, $className);
                                echo "</li>";
                                // spacer between key fact section one and two.
                                echo "<br><br>";
                                //the second section of key facts.
                                echo "<li>";//1
                                echo PSCO_func::languages($schoolId, $className);
                                echo "</li>";
                                echo "<li>";//4
                                echo PSCO_func::grandparents($schoolId, $className);
                                echo "</li>";
                                echo "<li>";//7
                                echo PSCO_func::born_country($schoolId, $className)[0];
                                echo "</li>";
                                echo "<li>";//8
                                echo PSCO_func::born_country($schoolId, $className)[1];
                                echo "</li>";
                                echo "<li>";//12
                                echo PSCO_func::top_migrant($schoolId, $className);
                                echo "</li>";
                                echo "<li>";//9
                                echo PSCO_func::born_country($schoolId, $className)[2];
                                echo "</li>";
                                echo "<li>";//11
                                echo PSCO_func::cultures_country_influence($schoolId, $className);
                                echo "</li>";
                                echo "<li>";//17
                                echo PSCO_func::parent_born_overseas($schoolId, $className);
                                echo "</li>";
                                echo "<li>";//18
                                echo PSCO_func::gparent_born_overseas($schoolId, $className);
                                echo "</li>";
                                // spacer between key fact section two and three.
                                echo "<br><br>";
                                //the third section of key facts.
                                echo "<li>";//1
                                echo PSCO_func::languages($schoolId, $className);
                                echo "</li>";
                                echo "<li>";//3
                                echo PSCO_func::count_Languages($schoolId, $className);
                                echo "</li>";
                                echo "<li>";//5
                                echo PSCO_func::Highest_number($schoolId, $className);
                                echo "</li>";
                                echo "<li>";//10
                                echo PSCO_func::male_female_know_language($schoolId, $className);
                                echo "</li>";
                                echo "<li>";//13
                                echo PSCO_func::num_of_language_spoken($schoolId, $className)[0];
                                echo "</li>";
                                echo "<li>";//14
                                echo PSCO_func::num_of_language_spoken($schoolId, $className)[1];
                                echo "</li>";
                                echo "<li>";//15
                                echo PSCO_func::num_of_language_spoken($schoolId, $className)[2];
                                echo "</li>";
                                // spacer between key fact section three and four.
                                echo "<br><br>";
                                //the forth section of key facts.
                                echo "<li>";//2
                                echo PSCO_func::different_faiths($schoolId, $className);
                                echo "</li>";
                                echo "<li>";//6
                                echo PSCO_func::How_many_number($schoolId, $className);
                                echo "</li>";
                                // spacer between key fact section four and five.
                                echo "<br><br>";
                                //the fifth section of key facts.
                                echo "<li>";//19
                                echo PSCO_func::age_language_stats($schoolId, $className);
                                echo "</li>";
                                echo "<li>";//20
                                echo PSCO_func::age_belief_stats($schoolId, $className);
                                echo "</li>";

>>>>>>> b002a728f4dcec2aa087814e06be3fc5418d47a1
                                echo "</ul>";

                                ?>
                            </div>


                            <div id="export" class="tab-pane fade">
                                <div class="headerContent">EXPORT</div>
                                <iframe src="page/TeacherMapChart.html"
                                        style="width: 100%;min-height: 1200px;border: none;"></iframe>
                            </div>

                            <!-- <script type="text/javascript">
                                 $('#export').load('page/TeacherMapChart.html');
                             </script>-->


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

    function activaTab(tabID) {
        $('.nav-tabs a[href="#' + tabID + '"]').tab('show');
    }
    ;

</script>
</body>
</html>


<?php

if (isset($_GET['logoutrequest'])) {

    session_destroy();
    header('Location:../index.php');

}


if (!isset($_SESSION['teacher'])) {


    header('Location:index.php');
}


?>
<script type="text/javascript">

    $(document).ready(function () {

        //ALL OPTION
        $(".all-btn").click(function () {

            $("#genderbtn").html("All&nbsp;<span class='caret'></span>");
            var data = google.visualization.arrayToDataTable([
                ['Language', 'NumberOfStudent', {role: 'style'}],


                <?php
                include 'connection.php';


                $result = mysql_query("SELECT languagename, COUNT( languagename ) FROM studentlanguage where studentemailid IN(SELECT studentemailid FROM student where schoolid='" . $schoolId . "' AND classname='" . $className . "' ) GROUP BY languagename ORDER BY COUNT( languagename ) DESC");


                while($row = mysql_fetch_assoc($result)) {

                ?>
                ['<?php echo $row['languagename']; ?>', <?php echo $row['COUNT( languagename )']; ?>, '<?php echo generateRandomColor(); ?>'],


                <?php  }

                mysql_close($con);
                ?>


            ]);

            var options = {

                pieHole: 0.4,
                //width: '900',
                width: "100%",
                height: '500',
                //height:'500',
                backgroundColor: {fill: 'transparent'}
            };
            languagechart.draw(data, options);


            $("#languagetext").html("<?php
                include 'connection.php';

                $result = mysql_query("SELECT languagename, COUNT( languagename ) FROM studentlanguage where studentemailid IN(SELECT studentemailid FROM student where schoolid='" . $schoolId . "' AND classname='" . $className . "') GROUP BY languagename ORDER BY COUNT( languagename ) DESC");





                while ($row = mysql_fetch_assoc($result)) {
                    echo "<b>";
                    echo $row['languagename'];
                    echo ": </b>&nbsp;";
                    echo $row['COUNT( languagename )'];
                    echo "<br/>";
                } mysql_close($con);?>");

        });


        //MALE OPTION
        $(".male-btn").click(function () {
            $("#genderbtn").html("Male&nbsp;<span class='caret'></span>");
            var data = google.visualization.arrayToDataTable([
                ['Language', 'NumberOfStudent', {role: 'style'}],


                <?php
                include 'connection.php';
                $gen = "male";

                $result = mysql_query("SELECT languagename, COUNT( languagename ) FROM studentlanguage where studentemailid IN(SELECT studentemailid FROM student where schoolid='" . $schoolId . "' AND classname='" . $className . "' AND gender='" . $gen . "') GROUP BY languagename ORDER BY COUNT( languagename ) DESC");


                while($row = mysql_fetch_assoc($result)) {

                ?>
                ['<?php echo $row['languagename']; ?>', <?php echo $row['COUNT( languagename )']; ?>, '<?php echo generateRandomColor(); ?>'],


                <?php  } mysql_close($con);?>


            ]);

            var options = {

                pieHole: 0.4,
                //width: '900',
                width: "100%",
                height: '500',
                backgroundColor: {fill: 'transparent'}
            };
            languagechart.draw(data, options);

            $("#languagetext").html("<?php
                include 'connection.php';

                $result = mysql_query("SELECT languagename, COUNT( languagename ) FROM studentlanguage where studentemailid IN(SELECT studentemailid FROM student where schoolid='" . $schoolId . "' AND classname='" . $className . "' AND gender='" . $gen . "') GROUP BY languagename ORDER BY COUNT( languagename ) DESC");





                while ($row = mysql_fetch_assoc($result)) {
                    echo "<b>";
                    echo $row['languagename'];
                    echo ": </b>&nbsp;";
                    echo $row['COUNT( languagename )'];
                    echo "<br/>";
                } mysql_close($con);?>");

        });


        // FEMALE OPTION
        $(".female-btn").click(function () {

            $("#genderbtn").html("Female&nbsp;<span class='caret'></span>");
            var data = google.visualization.arrayToDataTable([
                ['Language', 'NumberOfStudent', {role: 'style'}],


                <?php
                include 'connection.php';
                $gen = "female";

                $result = mysql_query("SELECT languagename, COUNT( languagename ) FROM studentlanguage where studentemailid IN(SELECT studentemailid FROM student where schoolid='" . $schoolId . "' AND classname='" . $className . "' AND gender='" . $gen . "') GROUP BY languagename ORDER BY COUNT( languagename ) DESC");


                while($row = mysql_fetch_assoc($result)) {

                ?>
                ['<?php echo $row['languagename']; ?>', <?php echo $row['COUNT( languagename )']; ?>, '<?php echo generateRandomColor(); ?>'],


                <?php  }mysql_close($con); ?>


            ]);

            var options = {

                pieHole: 0.4,
                //width: '900',
                width: "100%",
                height: '500',
                backgroundColor: {fill: 'transparent'}
            };
            languagechart.draw(data, options);
            $("#languagetext").html("<?php
                include 'connection.php';

                $result = mysql_query("SELECT languagename, COUNT( languagename ) FROM studentlanguage where studentemailid IN(SELECT studentemailid FROM student where schoolid='" . $schoolId . "' AND classname='" . $className . "' AND gender='" . $gen . "') GROUP BY languagename ORDER BY COUNT( languagename ) DESC");





                while ($row = mysql_fetch_assoc($result)) {
                    echo "<b>";
                    echo $row['languagename'];
                    echo ": </b>&nbsp;";
                    echo $row['COUNT( languagename )'];
                    echo "<br/>";
                } mysql_close($con);?>");

        });


        //OTHER OPTION
        $(".others-btn").click(function () {

            $("#genderbtn").html("Others&nbsp;<span class='caret'></span>");
            var data = google.visualization.arrayToDataTable([
                ['Language', 'NumberOfStudent', {role: 'style'}],


                <?php
                include 'connection.php';
                $gen = "others";

                $result = mysql_query("SELECT languagename, COUNT( languagename ) FROM studentlanguage where studentemailid IN(SELECT studentemailid FROM student where schoolid='" . $schoolId . "' AND classname='" . $className . "' AND gender='" . $gen . "') GROUP BY languagename ORDER BY COUNT( languagename ) DESC");


                while($row = mysql_fetch_assoc($result)) {

                ?>
                ['<?php echo $row['languagename']; ?>', <?php echo $row['COUNT( languagename )']; ?>, '<?php echo generateRandomColor(); ?>'],


                <?php  } mysql_close($con);?>


            ]);

            var options = {

                pieHole: 0.4,
                //width: '900',
                width: "100%",
                height: '500',
                backgroundColor: {fill: 'transparent'}
            };
            languagechart.draw(data, options);

            $("#languagetext").html("<?php
                include 'connection.php';

                $result = mysql_query("SELECT languagename, COUNT( languagename ) FROM studentlanguage where studentemailid IN(SELECT studentemailid FROM student where schoolid='" . $schoolId . "' AND classname='" . $className . "' AND gender='" . $gen . "') GROUP BY languagename ORDER BY COUNT( languagename ) DESC");





                while ($row = mysql_fetch_assoc($result)) {
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

if (isset($_POST['submitval'])) {

    //$rr = $_REQUEST['qw'];
    $currentClassName = $_POST['classnamedropdown'];
    echo '<script>activaTab("maps");</script>';
    $className = $_POST['classnamedropdown'];


}
if (isset($_POST['submitvalstutab'])) {


    $currentClassName = $_POST['classnamedropdownstutab'];
    $className = $_POST['classnamedropdownstutab'];
    echo '<script>activaTab("students");</script>';


}

if (isset($_POST['submitvallantab'])) {


    $currentClassName = $_POST['classnamedropdownlantab'];
    $className = $_POST['classnamedropdownlantab'];
    echo '<script>activaTab("language");drawLanguageChart();</script>';


}
if (isset($_POST['submitvalbeltab'])) {


    $currentClassName = $_POST['classnamedropdownbeltab'];
    $className = $_POST['classnamedropdownbeltab'];
    echo '<script>activaTab("religion");drawReligionChart();</script>';


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
    $(document).ready(function () {
        $(".view_data").click(function () {

            var employee_id = $(this).attr("id");
            $.ajax({
                url: "selectstudentinfo.php",
                method: "post",
                data: {employee_id: employee_id},
                success: function (data) {
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

                echo user_profile::get_profile($_SESSION['emailid'], 'teacheradmin');
                ?>
            </div>

        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#btn_user_profile').click(function () {
            $('#modal_user_profile').modal("show");
        });
    });
</script>

<!-- change pass -->
<div id="modal_change_pass_user" class="modal fade">

</div>
<script type="text/javascript">
    $("#modal_change_pass_user").load("page/modal_change_pass_teacher.html");
</script>


<!-- DELETE STAFF MODAL -->
<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 style="font-weight:bold;">Delete Staff</h3>
            </div>
            <div class="modal-body">
                <h3>Are you sure you want to delete <span style="font-weight:bold;" id="specstaffinfo"
                                                          name="specstaffinfo"></span> ?</h3>
                <br>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok" id="deleteitnow">Delete</a>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function () {


        $('#confirm-delete').on('show.bs.modal', function (e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        });


        $(document).on("click", ".staffinfo", function () {
            var myspecstaffinfo = $(this).data('id');
            $(".modal-body #specstaffinfo").text(myspecstaffinfo);

        });
    });
</script>


<!-- EDIT STUDENT MODAL  -->


<div id="edit_data_Modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="text-align:center; " font-weight:bold; ">Update Student Details</h4>
            </div>
            <div class="modal-body">

                <form method="post" id="update_form" class="form-horizontal">
                    <h3 style="padding: 1% 0%; background-color:#FE8885; color:#FFF; text-align:center;  border-radius: 8px;">
                        PERSONAL DETAILS</h3>

                    <div class="form-group">
                        <label class="control-label col-sm-3" for="studentemail">Email ID:</label>

                        <div class="col-sm-9">
                            <input type="email" class="form-control" id="studentemail" name="studentemail" readonly
                                   style="background-color:#e2e2e2;">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="firstname">First Name:</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="firstname" name="firstname">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="lastname">Last Name:</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="lastname" name="lastname">
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
                        <label class="control-label col-sm-3" for="age">Age Group:</label>

                        <div class="col-sm-9">
                            <select name="age" id="age" class="form-control">

                            </select>
                            <script type="text/javascript">
                                $('#age').load("page/data_value/age_group_60.html");
                            </script>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="beliefreligion">Belief/Religion:</label>

                        <div class="col-sm-9">
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="beliefreligion" name="beliefreligion">
                            </div>
                            <div class="col-sm-6">
                                <input id="checko" type="checkbox">
                                <label style="margin-top:0.5em">&nbsp;Don&apos;t want to answer</label>
                            </div>
                        </div>
                    </div>
                    <h3 style="padding: 1% 0%; background-color:#FE8885; color:#FFF; text-align:center;  border-radius: 8px;">
                        BIRTH COUNTRIES</h3>

                    <div class="form-group">
                        <label class="control-label col-sm-3" for="sb">Student:</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="sb" name="sb">
                        </div>
                    </div>

                    <hr>
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="m">Mother:</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="m" name="m">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="gfm">GrandFather:</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="gfm" name="gfm">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="gmm">GrandMother:</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="gmm" name="gmm">
                        </div>
                    </div>

                    <hr>
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="f">Father:</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="f" name="f">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="gff">GrandFather:</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="gff" name="gff">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="gmf">GrandMother:</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="gmf" name="gmf">
                        </div>


                    </div>


                    <h3 style="padding: 1% 0%; background-color:#FE8885; color:#FFF; text-align:center;  border-radius: 8px;">
                        LANGUAGES</h3>

                    <div class="form-group">
                        <div class="col-sm-9">
                            <table class='table borderless table-responsive ' id="employee_lang">

                            </table>
                        </div>
                    </div>

                    <br>
                    <input type="submit" name="update" id="update" value="Save" class="btn btn-success "/>

                </form>

            </div>

        </div>
    </div>
</div>
<!--NEW UI SCRIPTS-->
<script type="text/javascript">
    function ToggleMenu(elem) {
        var flag = elem.getAttribute('data-show');
        if (flag == 'true') {
            document.getElementById('MenuPanel').style.cssText = '';
            elem.style.cssText = '';
            elem.setAttribute('data-show', 'false');
        } else {
            document.getElementById('MenuPanel').style.cssText = 'height:100vh;width:30vw';
            elem.setAttribute('data-show', 'true');
            elem.style.left = '31.5vw';
        }
    }
</script>
<script>

    $(document).ready(function () {
        $('#add').click(function () {
            $('#insert').val("Insert");
            $('#insert_form')[0].reset();
        });

        $(document).on('click', '.editstaff_data', function () {
            var employee_id = $(this).attr("id");
            $.ajax({
                url: "fetchstudentinfo.php",
                method: "POST",
                data: {employee_id: employee_id},
                dataType: "json",
                success: function (data) {
                    var datastaff = data['arr1'];
                    var datastaffbirth = data['arr2'];
                    var lang = data['arr4'];
                    $('#studentemail').val(datastaff.studentemailid);
                    $('#firstname').val(datastaff.firstname);
                    $('#lastname').val(datastaff.lastname);
                    $('#gender').val(datastaff.gender);

                    if (datastaff.religion == 'Non Disclosed') {
                        $('#checko').prop('checked', true);
                        $('#beliefreligion').prop('readonly', true);
                        $('#beliefreligion').val('Belief/Religion');
                        $('#beliefreligion').css('color', '#CCC');

                    } else {
                        $('#checko').prop('checked', false);
                        $('#beliefreligion').prop("readonly", false);
                        $('#beliefreligion').val(datastaff.religion);
                        $('#beliefreligion').css('color', '#000');
                    }

                    $('#sb').val(datastaffbirth.studentbirthplace);
                    $('#m').val(datastaffbirth.studentmotherbirthplace);
                    $('#gfm').val(datastaffbirth.studentmothersfatherbirthplace);
                    $('#gmm').val(datastaffbirth.studentmothersmotherbirthplace);
                    $('#f').val(datastaffbirth.studentfatherbirthplace);
                    $('#gff').val(datastaffbirth.studentfathersfatherbirthplace);
                    $('#gmf').val(datastaffbirth.studentfathersmotherbirthplace);
                    $('#employee_lang').html(lang.data);

                    $('#edit_data_Modal').modal('show');
                }
            });
        });

        $('#update_form').on("submit", function (event) {
            event.preventDefault();
            if ($('#studentemail').val() == "") {
                alert("Email ID is required");
            }
            else if ($('#firstname').val() == '') {
                alert("First Name is required");
            }
            else if ($('#gender').val() == '') {
                alert("Gender is required");
            }
            else if ($('#beliefreligion').val() == '') {
                alert("Belief/Religion is required");
            }
            else if ($('#sb').val() == '') {
                alert("Staff Birthplace is required");
            }
            else if ($('#m').val() == '') {
                alert("Mother's Birthplace is required");
            }
            else if ($('#gfm').val() == '') {
                alert("Grandfather (Mother's side) Birthplace is required");
            }
            else if ($('#gmm').val() == '') {
                alert("Grandmother (Mother's side) Birthplace is required");
            }
            else if ($('#f').val() == '') {
                alert("Father's Birthplace is required");
            }
            else if ($('#gff').val() == '') {
                alert("Grandfather (Father's side) Birthplace is required");
            }
            else if ($('#gmf').val() == '') {
                alert("Grandmother (Father's side) Birthplace is required");
            }
            else {


                $.ajax({
                    url: "validatecountryname.php",
                    method: "POST",
                    data: $('#update_form').serialize(),
                    success: function (data) {

                        if (data == "No error") {

                            //SECOND CALL
                            $.ajax({

                                url: "updatestudentdetails.php",
                                method: "POST",
                                data: $('#update_form').serialize(),
                                success: function (data) {

                                    if (data == "No error") {

                                        $('#edit_data_Modal').modal('hide');
                                        alert("Data updation successfull.");
                                        window.location.reload(true);


                                    } else {
                                        alert(data);
                                    }


                                }
                            });


                        } else {
                            //Displays error message of first call
                            alert(data);
                        }
                        /*$('#insert_form')[0].reset();
                         $('#add_data_Modal').modal('hide');
                         $('#employee_table').html(data)alert(data);;  */
                    }
                });


            }
        });

    });
</script>
 
 
 