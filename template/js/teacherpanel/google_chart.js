/**
 * Created by peymanvalikhanli on 6/2/17 AD.
 */

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
    var data = google.visualization.arrayToDataTable(google_chart_data);

    var view = new google.visualization.DataView(data);
    view.setColumns([0, 1,
        { calc: "stringify",
            sourceColumn: 1,
            type: "string",
            role: "annotation" }
    ]);

    var options = {
        pieHole: 0.4,
        width: screen.width * 0.9,
        height: screen.height/2,
        backgroundColor: { fill:'transparent' }
    };
    var chart = new google.visualization.PieChart(document.getElementById("barchart_values"));
    chart.draw(view, options);

    //var religonchart = (chart.getImageURI());
    document.getElementById('pngaddresstoexport').value  = ' + chart.getImageURI() + ';
    //document.getElementById("pngaddresstoexport").value = chart.getImageURI();

}


function drawRegionsMap() {
    var data = google.visualization.arrayToDataTable([
        ['Country','NumberofPersons'],
            //TODO:  insert data
   );

    var options = {



        colorAxis: {minValue: 0, colors: ['#f6cbcb','#af3634']},
        displayMode: 'regions',
        //width: 900,
        //height: 500,
        width: "80%",
        height: "500px",
        backgroundColor: { fill:'transparent' }


    };

    var chart = new google.visualization.GeoChart(document.getElementById('regions_div'));


    // Wait for the chart to finish drawing before calling the getImageURI() method.
    google.visualization.events.addListener(chart, 'ready', function () {
        var imgUri = chart.getImageURI();
        document.getElementById('png').innerHTML  = '<a href="' + imgUri + '" target="_blank">Printable version</a>';

    });


    chart.draw(data, options);
<?php
        $output = array();
    while($row = mysql_fetch_assoc($result1)) {
        $output[] = $row;
    }
    makecsv($output, "teacherregionmapdataout.csv", false);
    ?>
}