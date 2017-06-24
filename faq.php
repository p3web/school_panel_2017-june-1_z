<!DOCTYPE html>
<html lang="en">
<head>
  <title>Ancestry Atlas</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="css/style.css">
<style>
  @font-face {	
	font-family:'MuseoSans_300';
    src:url('fonts/MuseoSans_300.ttf') format('truetype');
	font-weight: normal;
	font-style: normal;
	
}

  </style>
</head>
<body id="home">


<div id="wrap">
	
	<div class="container-fluid">
    	<?php include 'header.php';?>
        
        <div class="row" >
        	<div class="col-sm-2"></div>
            <div class="col-sm-8">
            	<div class="row">
                	<h3 style="font-weight:bold; margin-top:1.5em;">FAQ of AncestryAtlas:</h3>
                	<p style="font-size:1.2em; margin-top:1%;">These are the common FAQ&apos;s for visitors to Ancestry Atlas. For further enquiries, please use the contact us form on the menu bar. We are continually improving the Ancestry Atlas website so would be happy to hear from you. 
<a href="http://www.ancestryatlas.com/contactus.php">Contact here</a>
</p><br>
					<?php
                    	include 'connection.php';
                        $queryp = "select * from faq";
                        
                        $resultp = mysql_query($queryp);
                        $count = 1;
						?>
                        
                        <table style="font-size:1.2em;">
						<?php
                        while ($rowp = mysql_fetch_array($resultp)){
                            
                            ?> 
                            <tr>
                            	<td style="font-weight:bold;"><b><?php echo $count.". ";
								          echo $rowp["question"];?></b>
                                </td>
                            </tr>
                            
                            <tr>
                            	<td> <?php echo $rowp["answer"];
								echo "<br><br>";?></td>
                            </tr>
                            <?php
							$count = $count + 1;
                        }
                        mysql_close($con);
                    ?>
                         </table>       
                </div>
            </div>
			<div class="col-sm-2"></div>

        </div>
        
     

  
  
    </div>
    
   </div>
    
<?php 
include 'footer.php';
?>

</body>
</html>
