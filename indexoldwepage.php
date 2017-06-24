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
	background-color:#CFE3D2 !important;

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
        	<div class="col-sm-1"></div>
            <div class="col-sm-10">
            	<div class="row">
                	<div class="col-sm-12 text-center welcome" style="font-size:1.500em; padding:3.250em 0em 3.250em 0em;" >



                    		Welcome to Ancestry Atlas.<br>
                            Discover the diversity of your community with our simple tool.

                    </div>
                </div>

                <div class="row text-center">
                	<div class="col-sm-4 " >
                       <br>
                       <h2  class="text-center">SCHOOL</h2>
                        <a href="login.php?l=<?php echo "s";?>"><input type="button" class="indexbuttons" value="LOGIN" title="LOGIN" ></a>
                        <br>
                        <a href="adminregistration.php"><input type="button" class="indexbuttons" value="REGISTER" title="REGISTER" ></a>

                        <br><br>
                        <a class="demo btnspecial" data-type="inline" href="#inlinecontentschool" style="padding:0.3em 1em; height:2em;text-decoration:none;" >ABOUT SCHOOL</a>
                        <br>

						<!-- School lightbox -->
                        <div id="inlinecontentschool" style="display:none; height:100%; float:left; padding:20px;">
                        	<div style="float:left; padding:2em; text-align:justify;">

                                <h3><span class="gradientcolorone" style="font-weight:bold;">ANCESTRY ATLAS FOR PRIMARY AND SECONDARY SCHOOL GROUPS</span></h3>
															   								<br>
															   								<p>The Ancestry Atlas makes learning more about your student population simple. Students answer questions about their birthplaces and those of their family, the languages that are spoken at home and their religious beliefs. These answers are combined within our website to generate an eye-catching infographic that tells the story of your school visually. The aim is to move towards Intercultural understanding rather than simply co-existing with little knowledge or understanding of other cultures and beliefs.
															                                   </p>	<br>

															                                   <p>Ancestry Atlas is a conversation starter. Our Cultural Infusion teachers have used this type of visual mapping technique in a number of school workshops and it has been one of the most effective techniques we've seen for beginning the conversation around culture. Ancestry Atlas challenges an 'us versus them' mentality that can develop amongst students (Steinbach, 2010). The first step in facilitating positive change is getting to know one another and Ancestry Atlas facilitates this in a fun and engaging way. We are pleased to be able to share our proven techniques with other teachers using this online version of Ancestry Atlas.</p>
															                                   <br>
															                                   <h4 style="font-weight:bold; margin-bottom:0.1em;">Teaching resources</h4>
															                                   <br>
															   <p>Free teaching resources to assist teachers in facilitating learning objectives such as:</p>
															   								<p>
															                                   		<ul style="float:left;">
															                                           <li>Reflect on Intercultural experiences</li>
															                                           <li>Empathize with others</li>
															                                           </ul>

															                                   		<ul style="float:left;">
															                                           <li>Develop Respect for Cultural Diversity</li>
															                                           <li>Investigate Culture and Cultural Identity</li>
															                                           </ul>
															                                   </p>
															                               </div>
                        </div><!--lightbox ends-->


                    </div>
                    <div class="col-sm-4 "  >

                    	<img src="images/AA-logo-animations.png" class="mainlogo img-responsive " style=" vertical-align:middle; margin-top:1em; width:100%; height:100%; " >
                    </div>
                    <div class="col-sm-4 text-center" >
                       <br>
                       <h2  class="text-center" >ORGANISATION</h2>

                        <a href="login.php?l=<?php echo "o";?>"><input type="button" class="indexbuttons" value="LOGIN" title="LOGIN"  ></a>
                        <br>
                        <a href="adminregistration.php"><input type="button" class="indexbuttons" value="REGISTER" title="REGISTER" ></a>
                        <br><br>
                        <a class="demo btnspecial" data-type="inline" href="#inlinecontentorg" style="padding:0.3em 2.3em; height:2em;text-decoration:none;" >ABOUT ORGANISATION</a>
                        <br>


                               <!-- ORG lightbox -->
                        <div id="inlinecontentorg" style="display:none; height:100%; float:left; padding:20px;">
                        	<div style="float:left; padding:2em; text-align:justify;">

                                <h3><span class="gradientcolorone" style="font-weight:bold;">ANCESTRY ATLAS FOR CORPORATE GROUPS</span></h3>
								                                <h5 style="font-weight:bold;">A diverse and inclusive workforce provides many advantages for organizations.</h5>

								                                <h5 style="font-weight:bold; text-align:left;">What value does this bring to an organization?</h5>

								                                		<ul style="float:left;">
								                                        <li><span style="font-weight:bold;">Engagement and inclusion</span> are separate but related concepts. Engagement is an outcome of diversity and inclusion. Those who feel highly included in a workplace with a low commitment to diversity are more engaged (67%) compared to those in a workplace with high diversity and low levels of inclusion (20%), it is the combined focus on diversity and inclusion which delivers the highest levels of engagement (101%).</li>
								                                        <li><span style="font-weight:bold;">Higher management team performance:</span> Managements with a high degree of knowledge-based diversity generally achieve higher management team performance (Rodan & Galunic, 2004).</li>
								                                        <li><span style="font-weight:bold;">Higher achieving teams:</span> Management teams possessing high cultural intelligence gained through ethnic and national diversity are higher achievers (Groves & Feyerherm, 2011).</li>
								                                        <li><span style="font-weight:bold;">Attracting new talent: </span> New generations are attracted by companies with a diverse profile: 60% of candidates in a StepStone study from 2013 responded that it is 'very important' or 'important' that their workplace is inclusive regardless of nationality, religion, sexual orientation, gender and disability.</li>
								                                        <li><span style="font-weight:bold;">Innovation:</span> Harvard Business Review published a study showing how diversity in leadership both unlocks innovation and drives market growth (Hewlett, Marshall & Sherbin, 2013) Studies also demonstrate that the more diverse organisations are, the greater their prospects of taking out new patents, resolving complex problems and realising innovations (Justesen, 2015). In their meta-study, Stahl, Maznevski, Voigt & Johnson (2009) demonstrate that diverse teams are more innovative and come in on-budget and on-time.</li>
								                                        <li><span style="font-weight:bold;">Insight into the market:</span> As noted by Justesen (2015), diversity, especially of gender, yields brighter ideas, more perspectives and deeper insights into the market, which allow good services to be adjusted to the target audience. A Gallup study from 2014 of 800 business units within two large service enterprises, revealed that the diverse units earned 19% more than non-diverse units. Diversely composed managements results in a more customer-oriented organisation (Hewlett, Marshall & Sherbin, 2013; McKinsey, 2015).</li>

								                                        </ul>



								                            </div>
                        </div>   <!--lightbox ends-->


                    </div>
                </div>



               <div class="col-sm-12">
               		<div class="col-sm-3"></div>
                    <div class="col-sm-6" style=" margin-top:5em; "><h1 class="text-center" style="border-bottom:#9e9e9e 2px solid; border-top:#9e9e9e 2px solid; margin-bottom:2em; padding:0.5em 0em;"><span style=" /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#ffffff+45,ffffff+45,fe8b87+46,ffffff+46,fe8b87+47,ffffff+47,ffffff+48,fe8b87+48,ffffff+48,fe8b87+49,fe8b87+49,fe8b87+49,fe8b87+61,fe8b87+85&0+0,1+56,1+61,1+68 */
background: -moz-linear-gradient(top,  rgba(255,255,255,0) 0%, rgba(255,255,255,0.8) 45%, rgba(255,255,255,0.82) 46%, rgba(255,255,255,0.84) 47%, rgba(255,255,255,0.86) 48%, rgba(254,139,135,0.88) 49%, rgba(254,139,135,1) 56%, rgba(254,139,135,1) 61%, rgba(254,139,135,1) 68%, rgba(254,139,135,1) 85%); /* FF3.6-15 */
background: -webkit-linear-gradient(top,  rgba(255,255,255,0) 0%,rgba(255,255,255,0.8) 45%,rgba(255,255,255,0.82) 46%,rgba(255,255,255,0.84) 47%,rgba(255,255,255,0.86) 48%,rgba(254,139,135,0.88) 49%,rgba(254,139,135,1) 56%,rgba(254,139,135,1) 61%,rgba(254,139,135,1) 68%,rgba(254,139,135,1) 85%); /* Chrome10-25,Safari5.1-6 */
background: linear-gradient(to bottom,  rgba(255,255,255,0) 0%,rgba(255,255,255,0.8) 45%,rgba(255,255,255,0.82) 46%,rgba(255,255,255,0.84) 47%,rgba(255,255,255,0.86) 48%,rgba(254,139,135,0.88) 49%,rgba(254,139,135,1) 56%,rgba(254,139,135,1) 61%,rgba(254,139,135,1) 68%,rgba(254,139,135,1) 85%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#00ffffff', endColorstr='#fe8b87',GradientType=0 ); /* IE6-9 */">COMING SOON!</span></h1>


</div>
                    <div class="col-sm-3"></div>

               </div>

               <div class="col-sm-12 text-center" >
               <p class="text-center" style="margin:2em 0em;"><img src="images/AA_trusted-icon.png" alt="" title=""><b>&nbsp;Ancestry Atlas</b> is a product of <b><a target="_blank" href="http://culturalinfusion.org.au/" title="Cultural Infusion" style="text-decoration:none; color:#000;">Cultural Infusion</a></b> &quot;Trusted by 2000 schools across Australia&quot;</p>

               </div>

			               <!--
			               <div class="col-sm-12">
			               		<div class="col-sm-3"></div>
			                    <div class="col-sm-6" style=" border-top:#9e9e9e 2px solid; margin-top:2em; "></div>
			                    <div class="col-sm-3"></div>

			               </div>

			               <div class="col-sm-12 text-center" style="margin-top:1em;">


			               		<h5 style="font-weight:bold;">CONNECT</h5>
			                    <p>Many groups know very little about one another's diversity; their ancestry, the languages they speak or their beliefs.<br>
			                       Ancestry Atlas makes this simple. Just invite your group, answer questions and then watch the information come to life in a graphic.</p>


			                       <h5 style="font-weight:bold; margin-top:1em;">SHARE</h5>
			                    <p>Share the Ancestry Atlas image across the world or print and post it on the wall.</p>
			               </div>


			               <div class="col-sm-12">
			               		<div class="col-sm-3"></div>
			                    <div class="col-sm-6" style=" border-top:#9e9e9e 2px solid; margin-top:1em; margin-bottom:1em; "></div>
			                    <div class="col-sm-3"></div>

			               </div>


			               -->

        	</div>

			<div class="col-sm-1"></div>

        </div>




    </div>

   </div>

  <?php
include 'footer.php';
?>

</body>
</html>
