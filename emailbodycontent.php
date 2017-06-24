<?php

		function emailbodytoschooladmin($adminid,$email,$token)
    {
        return "
											     Thanks for signing up with <a href='http://www.ancestryatlas.com/'>Ancestry Atlas</a> powered by <a href='http://culturalinfusion.org.au/'>Cultural Infusion</a>. Start your journey here!
                                                 <br>You have now completed the setup phase for Ancestry Atlas and are ready to go. Your school has a private group for your whole school to collect data.  When you log in to the website you will see the Administrator Dashboard.  The next step in this process is to register an unlimited number of teachers. 
                                                 <br>
                                                 <ol>
                                                 <li>Activate this registration by selecting this <a href='https://www.ancestryatlas.com/backend/verify.php?email=".$email."&token=".$token."'>LINK</a></li>
                                                 <li>After activation you can log in to <a href='http://www.ancestryatlas.com'>www.ancestryatlas.com</li>
                                                 <li>Under the tab labelled Teachers, enter the email address for the teachers you wish to invite</li>
                                                 <li>The teacher will receive an email with an activation link and will be responsible for inviting students within their classes</li>
                                                 <li>As an Administrator you can view the dashboard and see the progress of data being collected</li>
                                                 </ol>


								  <br>For further instruction please see our <a href='http://www.ancestryatlas.com/faq.php'>How to Guide and FAQ</a>.
								  <br>Please do let us know if you require any further assistance or help and we will respond rapidly via our <a href='http://www.ancestryatlas.com/contactus.php'>Contact Page</a>.
								  <br><br>
								  <br>Kind Regards
								  <br>
								  <br>Ancestry Atlas Team
								  <br>www.ancestryatlas.com


						
						";
								}
	function emailbodyadmintoteacher($adminid,$email,$token)
    {
        return "
											    Your School administrator ".$adminid."  has signed you up for Ancestry Atlas powered by <a href='http://culturalinfusion.org.au/'>Cultural Infusion</a>. Start your journey here!
                                                                                          <br>											
											  <ol>
											  	<li>Activate this registration by selecting this <a href='https://www.ancestryatlas.com/backend/verifyteacher.php?email=".$email."&token=".$token."'>LINK</a></li>
											  	<li>Enter your place of birth and, if you want to, you can enter the place of birth or your parents, paternal and maternal grandparents. The results automatically map the location to a world map. Don't worry if you can't complete all of these answers. We are working as a team so just answer what you know and are willing to share. As long as each person enters at least one place of birth the map will look awesome!
											  	<li>You are invited to share information about the languages you speak and your religion or beliefs. If you would prefer to keep this private we do understand
											  	<li>After activation you can log in to <a href='http://www.ancestryatlas.com'>www.ancestryatlas.com</li>
											  	<li>Under the tab labelled Classes, enter the email address for the students you wish to invite</li>
											  	<li>Each student will receive an email with an activation link</li>
											  	<li>As a Teacher, you can view the dashboard and see the progress of data being collected</li>
											  </ol>
											  
									<br>For further instruction please see our <a href='http://www.ancestryatlas.com/faq.php'>How to Guide and FAQ</a>.
									<br>Please do let us know if you require any further assistance or help and we will respond rapidly via our <a href='http://www.ancestryatlas.com/contactus.php'>Contact Page</a>.
								    <br><br>
									<br>Kind Regards
									<br>
									<br>Ancestry Atlas Team
									<br>www.ancestryatlas.com
									";
								
								}							
								
	function emailbodyteachertostudent($adminid,$email,$token)
{
        return "
											  The Ancestry Atlas is a fun activity that can be done by any group, class, institution or community. Our website helps you begin discussions around culture by creating a beautiful infographic that helps you discover the richness and diversity within your community.
											  
											  <br>
											  <br>Your teacher ".$adminid." has signed you up for Ancestry Atlas powered by <a href='http://culturalinfusion.org.au/'>Cultural Infusion</a>. Start your journey here!
											  <br><br>
											  <ol>
											  	<li>Activate this registration by selecting this <a href='https://www.ancestryatlas.com/backend/verifystudent.php?email=".$email."&token=".$token."'>LINK</a></li>
											  	<li>Enter your place of birth and, if you want to, you can enter the place of birth or your parents, paternal and maternal grandparents. The results automatically map the location to a world map. Don&#39;t worry if you can&#39;t complete all of these answers. We are working as a team so just answer what you know and are willing to share. As long as each person enters at least one place of birth the map will look awesome!</li>
											  	<li>You are invited to share information about the languages you speak and your religion or beliefs. If you would prefer to keep this private we do understand.</li>
											  </ol>
											  
											  

                                    <br>Please do let your Teacher know if you require any further assistance or help. We have listed some of the most frequently asked questions below.
									 <br><br>
									 <br>Kind Regards
									 <br>
									 <br>Ancestry Atlas Team
									 <br>www.ancestryatlas.com
											  ";
								
								}
		function emailbodytoorgadmin($adminid,$email,$token)
    {
        return "
											       Thanks for signing up with <a href='http://www.ancestryatlas.com/'>Ancestry Atlas</a> powered by <a href='http://culturalinfusion.org.au/'>Cultural Infusion</a>. Start your journey here!
                                              <br>The Ancestry Atlas is a fun activity that can be done by any group, organization or community. Our website helps you begin discussions around culture by creating a beautiful infographic that helps you discover the richness and diversity within your community.You have now completed the setup phase for Ancestry Atlas and are ready to go. When you log in to the website you will see the Administrator Dashboard. The next step in this process is to register an unlimited number of departments.
                                              <ol>
                                              <li>Activate this registration by selecting this <a href='http://www.ancestryatlas.com/backend/verifyorgadmin.php?email=".$email."&token=".$token."'>LINK</a></li>
                                              <li>After activation you can log in to <a href='http://www.ancestryatlas.com'>www.ancestryatlas.com</li>
                                			  <li>Under the tab labelled Departments, enter the email address for the department admin you wish to invite</li>
                                			  <li>The department admin will receive an email with an activation link and will be responsible for inviting team admin within their department</li>
                                			  <li>As an Administrator you can view the dashboard and see the progress of data being collected</li>
                                			  </ol>


                        			  <br>For further instruction please see our <a href='http://www.ancestryatlas.com/faq.php'>How to Guide and FAQ</a>.
                        			  <br>Please do let us know if you require any further assistance or help and we will respond rapidly via our <a href='http://www.ancestryatlas.com/contactus.php'>Contact Page</a>.
                        			  <br><br>
                        			  <br>Kind Regards
                        			  <br>
                        			  <br>Ancestry Atlas Team
                        			  <br>www.ancestryatlas.com
                    				";
                    				
								}
		function emailbodyadmintodeptadmin($adminid,$email,$token)
    {
        return "
											   
											  The Ancestry Atlas is a fun activity that can be done by any group, organization or community. Our website helps you begin discussions around culture by creating a beautiful infographic that helps you discover the richness and diversity within your community.Your Organisation administrator ".$adminidorg."  has signed you up for Ancestry Atlas powered by <a href='http://culturalinfusion.org.au/'>Cultural Infusion</a>. Start your journey here!
                                              <br>
											  <ol>
											  	<li>Activate this registration by selecting this <a href='https://www.ancestryatlas.com/backend/verifydepartment.php?email=".$email."&token=".$token."'>LINK</a></li>
											  	<li>Enter your place of birth and, if you want to, you can enter the place of birth or your parents, paternal and maternal grandparents. The results automatically map the location to a world map. Don't worry if you can't complete all of these answers. We are working as a team so just answer what you know and are willing to share. As long as each person enters at least one place of birth the map will look awesome!
											  	<li>You are invited to share information about the languages you speak and your religion or beliefs. If you would prefer to keep this private we do understand
											  	<li>After activation you can log in to <a href='http://www.ancestryatlas.com'>www.ancestryatlas.com</li>
											  	<li>Under the tab labelled Team admin, enter the email address for the Team admin you wish to invite</li>
											  	<li>The Team admin will receive an email with an activation link and will be responsible for inviting staff within their team</li>
											  	<li>As an Administrator you can view the dashboard and see the progress of data being collected</li>
											  </ol>

									<br>For further instruction please see our <a href='http://www.ancestryatlas.com/faq.php'>How to Guide and FAQ</a>.
									<br>Please do let your department Admin know if you require any further assistance or help.
								    <br><br>
									<br>Kind Regards
									<br>
									<br>Ancestry Atlas Team
									<br>www.ancestryatlas.com



									";
								}		
		function emailbodydeptadmintoteamadmin($adminid,$email,$token)
    {
        return "
											   
											 The Ancestry Atlas is a fun activity that can be done by any group, organisation or community. Our website helps you begin discussions around culture by creating a beautiful infographic that helps you discover the richness and diversity within your community. Your Department administrator ".$adminid."  has signed you up for Ancestry Atlas powered by <a href='http://culturalinfusion.org.au/'>Cultural Infusion</a>. Start your journey here!
                                               <br>
											   <ol>
											  	<li>Activate this registration by selecting this <a href='https://www.ancestryatlas.com/backend/verifyteam.php?email=".$email."&token=".$token."'>LINK</a></li>
											  	<li>Enter your place of birth and, if you want to, you can enter the place of birth or your parents, paternal and maternal grandparents. The results automatically map the location to a world map. Don't worry if you can't complete all of these answers. We are working as a team so just answer what you know and are willing to share. As long as each person enters at least one place of birth the map will look awesome!
											  	<li>You are invited to share information about the languages you speak and your religion or beliefs. If you would prefer to keep this private we do understand.
											  	<li>After activation you can log in to <a href='http://www.ancestryatlas.com'>www.ancestryatlas.com</li>
											  	<li>Under the tab labelled Staff, enter the email address for the Staff you wish to invite</li>
											  	<li>The Staff will receive an email with an activation link</li>
											  	<li>As an Administrator you can view the dashboard and see the progress of data being collected</li>
											  </ol>

									<br>For further instruction please see our <a href='http://www.ancestryatlas.com/faq.php'>How to Guide and FAQ</a>.
									<br>Please do let your Department Admin know if you require any further assistance or help.
									<br><br>
									<br>Kind Regards
									<br>
									<br>Ancestry Atlas Team
									<br>www.ancestryatlas.com
									";
								}		
		function emailbodyteamadmintostaff($adminid,$email,$token)
    {
        return "
											   
											The Ancestry Atlas is a fun activity that can be done by any group, organisation or community. Our website helps you begin discussions around culture by creating a beautiful infographic that helps you discover the richness and diversity within your community. Your Department administrator ".$adminid."  has signed you up for Ancestry Atlas powered by <a href='http://culturalinfusion.org.au/'>Cultural Infusion</a>. Start your journey here!
											  <br>
											  <ol>
											  	<li>Activate this registration by selecting this <a href='https://www.ancestryatlas.com/backend/verifystaff.php?email=".$email."&token=".$token."'>LINK</a></li>
											  	<li>Enter your place of birth and, if you want to, you can enter the place of birth or your parents, paternal and maternal grandparents. The results automatically map the location to a world map. Don't worry if you can't complete all of these answers. We are working as a team so just answer what you know and are willing to share. As long as each person enters at least one place of birth the map will look awesome!</li>
											  	<li>You are invited to share information about the languages you speak and your religion or beliefs. If you would prefer to keep this private we do understand.</li>
											  </ol>
								    <br>Please do let your Team Admin know if you require any further assistance or help. 
									<br><br>
									<br>Kind Regards
									<br>
									<br>Ancestry Atlas Team
									<br>www.ancestryatlas.com
									";
								}		
								
								
								
	?>