<html>
  <head>


    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('upcoming', {'packages':['geochart']});
      google.charts.setOnLoadCallback(drawRegionsMap);



      function drawRegionsMap() {
		  
	

        var data = google.visualization.arrayToDataTable([
          	['Country','NumberofEmployee'],
			
			<?php 
			include 'connection.php';
			$result = mysql_query("SELECT Country_of_Birth, COUNT( Country_of_Birth ) FROM culinfo GROUP BY Country_of_Birth"); 
			while($row = mysql_fetch_assoc($result)) { 
			
			?> 
			['<?php echo $row['Country_of_Birth']; ?>',<?php echo $row['COUNT( Country_of_Birth )']; ?>], <?php } ?>
			
			
			
			
        
        ]);

        var options = { 
			
		
			
			colorAxis: {colors: ['#f6cbcb','#af3634']},
			displayMode: 'regions',
			
			backgroundColor: { fill:'transparent' }
			
			
		};

        var chart = new google.visualization.GeoChart(document.getElementById('regions_div'));

        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div id="regions_div" style="width: 900px; height: 500px;">
    
   
    </div>
    <div>
    
    <?php 
			include 'connection.php';
			$result = mysql_query("SELECT Country_of_Birth, COUNT( Country_of_Birth ) FROM culinfo GROUP BY Country_of_Birth"); 
			
			while($row = mysql_fetch_assoc($result)) { 
				echo "<b>";
				echo $row['Country_of_Birth'];
				echo ": </b>&nbsp;"; 
				echo $row['COUNT( Country_of_Birth )'];
				echo "<br/>"; 
				} ?>
			
    </div>
    
    
  </body>
</html>