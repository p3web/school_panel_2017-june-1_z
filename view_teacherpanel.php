<?php
/**
 * Created by PhpStorm.
 * User: peymanvalikhanli
 * Date: 6/2/17 AD
 * Time: 11:17
 */
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

    <link rel="stylesheet" type="text/css" href="css/style.css">

    <!--  AUTO COMPLETE MATERIAL -->
    <link rel="stylesheet" href="css/jquery-ui.css">
    <script src="scripts/jquery-ui.js"></script>
    <!--Jquery function to autocomplete country name -->
    <script src="template/js/teacherpanel/country_name.js"></script>

    <script src="template/js/teacherpanel/main.js"></script>

    <link rel="stylesheet" href="template/css/teacherpanel/main.css">

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script type="text/javascript">
        var google_chart_data = <?php control_teacherpanel::get_data_chart_religion_count(); ?>;
    </script>

    <script src="template/js/teacherpanel/google_chart.js"></script>




