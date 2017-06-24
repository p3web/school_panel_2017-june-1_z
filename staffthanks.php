<!DOCTYPE html>
<html lang="en">
<head>
  <title>Ancestry Atlas</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <!-- Add venobox -->
  <link rel="stylesheet" href="venobox/venobox.css" type="text/css" media="screen" />
  <script type="text/javascript" src="venobox/venobox.min.js"></script>
  <link rel="stylesheet" type="text/css" href="css/style.css">
  
  <style>
  @font-face {	
	font-family:'MuseoSans_300';
    src:url('fonts/MuseoSans_300.ttf') format('truetype');
	font-weight: normal;
	font-style: normal;
	
}
.btnspecial{
	color:#000;
	background-color:#cfe3d2;
	
	}
 .btnspecial:hover{
	background-color:#99b48c;
	color:#000;
	}
.gradientcolorone{
	/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#ffffff+0,ffffff+49,ff8c87+49,ff8c87+100 */
background: #ffffff; /* Old browsers */
background: -moz-linear-gradient(top, #ffffff 0%, #ffffff 49%, #ff8c87 49%, #ff8c87 100%); /* FF3.6-15 */
background: -webkit-linear-gradient(top, #ffffff 0%,#ffffff 49%,#ff8c87 49%,#ff8c87 100%); /* Chrome10-25,Safari5.1-6 */
background: linear-gradient(to bottom, #ffffff 0%,#ffffff 49%,#ff8c87 49%,#ff8c87 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#ff8c87',GradientType=0 ); /* IE6-9 */
}
  </style>
<script>
	$(document).ready(function(){
		/* default settings */
		$('.venobox').venobox(); 
		

		$('.demo').venobox({
			framewidth: 'auto',
			frameheight: 'auto',
			titleattr: '',
			border: '2px',
			bgcolor: '#fff',
			numeratio: true,
			overlayclose: true 
		});
		/* auto-open #firstlink on page load */
		$("#firstlink").venobox().trigger('click');
	})
</script>
</head>
<body>


<div id="wrap">
	
	<div class="container-fluid">
    	<?php include 'header.php';?>
        
        <div class="row" >
        	<div class="col-sm-2"></div>
            <div class="col-sm-8">
            	<div class="row">
                	<div class="col-sm-12 text-center welcome" style="font-size:1.500em; padding:3.250em 0em 3.250em 0em;" >
                    
	
				Thank you! You have finished! <br>
Your team admin will collect all of the answers and show you your team Ancestry Atlas when it is completed.

                    		
                            	
							
                 
                    </div>
                </div>

                <div class="row text-center">
                	<div class="col-sm-4 " >
                       </div></div>
                   
        	</div>
            
			<div class="col-sm-2"></div>

        </div>
        
     
    </div></div></body>
    
  <?php 
include 'footer.php';
?>

</body>
</html>
