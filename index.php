<?php 
header('Location: https://www.ancestryatlas.com/');
exit();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Ancestry Atlas</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,500,700,800" rel="stylesheet"> 
  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  
  <link rel="stylesheet" type="text/css" href="css/advancedcss.css">
 
<style>
    
    #myNavbar ul li .logbutton{
    border-radius:0 !important;
    border:none;
    
}
 #myNavbar ul li .logbutton:link,visited,active{
    border-radius:0 !important; color:#ff8a87;
    border:none;
    
    background-color:#FFF;
}
#myNavbar ul li .logbutton:visited{
    border-radius:0 !important; color:#ff8a87;border:none;
    
    background-color:#FFF !important;
}
 #myNavbar ul li .logbutton:hover{
    color:#FFF;
    background-color:#FFF;
    border:none;
    
}
#myNavbar ul li .logbutton:active{
    border-radius:0 !important; 
    color:#ff8a87;
    background-color:#FFF !important;
}

#wrap .container-fluid .row #pricing .hsecondbuttonside{
	width:13.813em;
	height:2.125em;
	font-family: 'Open Sans', sans-serif; 
	font-weight:500; 
	font-size:18px;
	background-color:transparent;
	color:#FFF;
	border:#727677 1px solid;
	margin-left:-0.4% !important;
	
	
}
.center-pills {
    display: flex;
    justify-content: center;
}
</style>

<script>
$(document).ready(function(){
    $("#cop").click(function(){
		$("#cop").css({'background-color':'#8575b6','color':'#FFF'});
		$("#sch").css({'background-color':'transparent', 'color':'#747474'});
		
        $("#pricing").css('background-image', 'url(images/bg_image_princing_corporate.jpg)');
		$("#schpricelist").attr('src','images/corporatepricelist.png');
		$("#bulk").text("PLEASE CONTACT US FOR BULK LICENSING COSTS FOR OVER 4000 MEMBERS");
		
    });
	
	 $("#sch").click(function(){
		$("#sch").css({'background-color':'#cc3333','color':'#FFF'});
		$("#cop").css({'background-color':'transparent', 'color':'#747474'});
		
        $("#pricing").css('background-image', 'url(images/bg_image_princing_school.jpg)');
		$("#schpricelist").attr('src','images/schoolpricelist.png');
		$("#bulk").text("PLEASE CONTACT US FOR BULK LICENSING COSTS FOR OVER 1000 MEMBERS");
		
    });
});
</script>
</head>
<body id="homepage">




	<div id="wrap">
    
    
    <nav class="navbar navbar-inverse" style="background-color:#ff8a87;  border:none; border-radius: 0 !important; margin-bottom:0px;
  -moz-border-radius: 0 !important;">
  
    <div class="navbar-header" style="margin-left:10%; ">
      <button type="button" class="navbar-toggle" style="border-color:#FFF;" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a href="index.php"><img src="images/logo.png"></a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar" >
      <ul class="nav navbar-nav navbar-right ">
        <li><a href="#what">WHAT IS</a></li>
        <li><a href="#howto">HOW TO</a></li>
        <li><a href="#pricing">PRICING</a></li>
      <li>&nbsp;<button class="btn btn-default navbar-btn logbutton" onclick="location.href = 'logintest.php';"  style="border-radius:0 !important; color:#ff8a87;">LOGIN</button></li>
      <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
      <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
      <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li> 
      </ul>
      
    </div>
  
</nav>

    	<div class="container-fluid" style="margin-top:0px; padding-top:0px;">
        		<div class="row">
          
                     <div class="col-sm-12 hmainbackimage" style=" background-image:url(images/AA-homepage_bg_image.jpg); background-size: 100% 100%; background-repeat:no-repeat; height:100% auto; " >
                     
	
	
	
                     	<div class="col-sm-1">
                        </div>
                         <div class="col-sm-8 " style="font-family: 'Open Sans', sans-serif; font-weight:800; font-size:36px;">
                        	
                            <br>
                            <span class="text-left" style="font-family: 'Open Sans', sans-serif; color:#000; font-weight:400; font-size:17pt;">WELCOME TO ANCESTRY ATLAS</span>
                            
                            <p  style="font-family: 'Open Sans', sans-serif; font-weight:700; font-size:39px; line-height:34pt; color:#FFF; margin:3% 0% 3% 0%;">
                            Discover and share<br> the diversity of your <br>community.
                                </p>
                            
                            <a href="adminregistration.php"><input class="hbutton" type="button" value="REGISTER NOW" title="REGISTER NOW"></a><br>
                           	
                            
                            
                            
                            
                            
                            <img src="images/AA_homepage_top_banner_screen.png" style=" vertical-align:text-bottom; float:right; width:45%; height:45%;" >
                            <br><br><br><br>
                        </div>
                        
						<div class="col-sm-3">
                        </div>
                     </div>
                     
                     <div id="what" class="col-sm-12" style="font-family: 'Open Sans', sans-serif;  ">
                     	<div class="col-sm-12 text-center" style="padding:3% 0% 3% 0%;">
                        		
                     			
                                <span  style="font-weight:800; font-size:32px; color:#000;">ALL IN <span style="color:#ff8a88;">3</span> SIMPLE STEPS</span>
	                     </div>
                         <div class="col-sm-12 text-center" style="font-family: 'Open Sans', sans-serif; ">
                         		<div class=" col-sm-1">
                                </div>
                                <div class="col-sm-10">
                                
                                
                                <div class=" col-sm-4">
                                	<img src="images/small1.jpg" style="clear:both; padding-bottom:5%;"><br>
                                    
                                    <h2>Ask</h2>
                                    <p style="font-weight:400; font-size:14px; color:#949494; line-height:20pt; padding-top:7%; padding-bottom:5%;" class="text-justify">Complete a short survey to collect information about birthplace, languages, and beliefs of people in your group.
                                    </p>
                                </div>
                                <div class=" col-sm-4">
                                	<img src="images/small3.jpg" style="padding-bottom:5%;"><br>
                                    <h2>Make</h2>
                                    <p style="font-weight:400; font-size:14px; color:#949494; line-height:20pt; padding-top:7%; padding-bottom:5%;" class="text-justify">A picture tells a thousand words and a map of your whole group ancestry tells the story of your community. The Ancestry Atlas website generates this infographic automatically.
                                    </p>
                                </div>
                                <div class=" col-sm-4">
                                	<img src="images/small2.jpg" style="padding-bottom:5%;"><br>
                                    <h2>Share</h2>
                                   
                                    <p style="font-weight:400; font-size:14px; color:#949494; line-height:20pt; padding-top:7%; padding-bottom:5%;" class="text-justify">                                   
                                   Easily share your Ancestry map with other people around the world through social media. It&apos;s the perfect icebreaker to begin conversations.
                                     </p>
                                </div>
                                </div>
                                <div class=" col-sm-1">
                                </div>
                         </div>
                        
                         
                     </div>
                      <div class="col-sm-12 text-center" style="font-family: 'Open Sans', sans-serif; background-color:#ff8a87; font-weight:700; font-size:14px; color:#FFF; height:auto; margin:0px; padding:0.5%; ">
                         		<span>All personal information collected by Ancestry Atlas will be kept private will not be shared with any third party companies.</span>
                      </div>
                     
                    
	             
	             <div id="howto" class="col-sm-12 text-center" style="padding:3% 0% 3% 0%; ">
                        
                        <span  style="font-weight:800; font-size:32px; color:#000;">HOW TO USE</span><br>
                        
                        <div class="col-sm-12" style="margin-top:3%;">
	                        
                            
                            <div class="col-sm-1">
							</div>                            
                            
                            <div class="col-sm-10">
                            
                                <div class="col-sm-8"  >
                                
                                <img src="images/play.jpg" style="width:97%;">
                                </div>
                                
                                <div class="col-sm-4 text-left">
                                	
                                    <h2 style="color:#ff8a87; font-weight:700; font-size:20px; padding-top:0px; " >Step by Step</h2>
                                   
                                    <p style="font-weight:400; font-size:14px; color:#949494; line-height:20pt; padding-top:5%; text-align:justify">
Discover the richness of cultural diversity in your group. Many groups don't know much about one another's heritage. Yet, the first step in embracing diversity is getting to know one another.
</p>
<p style="font-weight:400; font-size:14px; color:#949494; line-height:20pt; padding-top:5%; padding-bottom:5%; text-align:justify">
Ancestry Atlas makes it easy for you to learn more about each other's heritage by mapping your origins onto a shareable map and infographic.
</p>
                                    
                                    
                                    <a href="http://ancestryatlas.com/how-to-use-ancestry-atlas/"><input type="button" style="margin-top:5%; " class="hbuttoncontact" value="Know more" title="Know more"></a>
                                      <br><br><br><br><br>         
                               </div>
                               
                            </div>
                            <div class="col-sm-1"  >
                            </div>
	                </div>
                    
                    
                    <div class="col-sm-12 text-center" style="padding:0% 0% 0% 0%; background-color:#ecdbab;">
                       
                       	<div class="col-sm-1">
                       	</div>
                        <div class="col-sm-10">
                        	<div class="col-sm-4">
                            	<img src="images/brocher.png" style="width:90%;">
                       		</div>
                            <div class="col-sm-8">
                            	<span style=" float:left; font-weight:700; font-size:24px; padding-top:8%;  line-height:21pt; text-align:left;">Ancestry Atlas is a conversation starter designed for groups of primary or secondary schools, or workplace groups.</span>
                                
                                <a target="_blank" href="brochure/AA_borchure_digital.pdf"><input type="button" style="margin-top:5%; float:left; width:11.813em !important;" class="hbuttoncontact" value="Download brochure" title="Download brochure"></a><br><br><br><br><br><br><br><br><br><br><br><br>
                       		</div>
                       	</div>
                        <div class="col-sm-1">
                       	</div>
                       
                        
                        
	             </div>
                    
                      <div id="pricing" class="col-sm-12 text-center" style="background-image:url(images/bg_image_princing_school.jpg); background-size: 100% 100%; background-repeat:no-repeat; height:100% auto; ">
                         <div class="col-sm-12 text-center" style="padding:3% 0% 3% 0%;">
                            
                            <span  style="font-weight:800; font-size:32px; color:#000;">PRICING</span><br>
                        </div>
                        <div class="col-lg-12 text-center" style="padding-top:0% ;">
                        		<input id="sch" type="button" class="hsecondbutton" value="SCHOOLS" title="SCHOOLS">
                                <input id="cop" type="button" class="hsecondbuttonside" value="CORPORATE" title="CORPORATE">
                                <br>
                               
                                <img onclick="location.href = 'adminregistration.php';" id="schpricelist" src="images/schoolpricelist.png" style="padding:3% 0% 3% 0%; width:70%; cursor:pointer;" >
                               
                               
                               
                        </div>
                        
                        




                     </div>
                     
                     <div class="col-sm-12 text-center" style=" padding:5% 0% 1.5% 0%; ">
                     
                     
                     
                     		<span id="bulk" style="font-weight:800; font-size:18px; color:#000;">PLEASE CONTACT US FOR BULK LICENSING COSTS FOR OVER 1000 MEMBERS</span>
                     		&nbsp;&nbsp;
                            <input type="button" class="hbuttoncontact" onclick="location.href = 'contactus.php';"  value="Contact Us" title="Contact Us">
                     </div>
	             </div>
	             
                 
                 
                 
                </div><!-- row ends-->
        </div><!-- container fluid ends -->
    </div><!-- wrap ends -->
    <!--
    
    <div id="footer" style="font-family: 'Open Sans', sans-serif; font-weight:400; ">
      <div class="container" >
        <p>
        				<div class="col-sm-1">
                       	</div>
                        <div class="col-sm-10">
                        	<span style="float:left;"> &copy; <?php echo date('Y');?> CULTURAL INFUSION OR ITS AFFILIATED COMPANIES. ALL RIGHTS RESERVED. </span>
                       <span style="float:right;"> ANCESTRY ATLAS IS POWERED BY 
                       <img src="images/culturalinfusionlogo.png" onclick="window.open('http://culturalinfusion.org.au/', '_blank');" height="50"  style="cursor:pointer; margin-top:-9%;"> </span>   
                       
                       	</div>
                        
                        <div class="col-sm-1">
                       	</div>
        	
            
            
        </p>
        
      </div>
    </div>
    -->
    
    <div id="footer" style="font-family: 'Open Sans', sans-serif; font-weight:400; ">
      <div class="container" >
        <p class="text-muted">
            <span style="float:left; color:#FFF;"> &copy; <?php echo date('Y');?> CULTURAL INFUSION OR ITS AFFILIATED COMPANIES. ALL RIGHTS RESERVED.</span>
             <span style="font-family: 'Open Sans', sans-serif; font-weight:400; color:#FFF; ">ANCESTRY ATLAS IS POWERED BY<img src="images/culturalinfusionlogo.png" onclick="window.open('http://culturalinfusion.org.au/', '_blank');" width = "9.5%" align="middle"  style="cursor:pointer; margin-top:-1.5%;"></span>
            <span style="float:right; color:#FFF;">
            	<a style="color:#FFF;" target="_blank" href="http://ancestryatlas.com/how-to-use-ancestry-atlas/" title="HELP">HELP</a> | 
            	<a style="color:#FFF;" href="privacy.php" title="PRIVACY">PRIVACY</a> |
                <a style="color:#FFF;" href="contactus.php" title="CONTACT US">CONTACT US</a>  
                
            </span>
        </p>
        
      </div>
 </div>
 
</body>
</html>
