<?php  
 if(isset($_POST["employee_id"]))  
 {  
      $output = '';  
      $connect = mysqli_connect("localhost", "ancestry_atlas", "]?7W%4yATmA?", "ancestry_atlas");  
      
	  
	
	  
	  
	  
	   $query = "SELECT * FROM student WHERE studentemailid = '".$_POST["employee_id"]."'";  
      $result = mysqli_query($connect, $query);  
	  
	  $output .= '  
	  
	 
	 
	  <button type="button" class="close" data-dismiss="modal">&times;</button>  
	  
      <div class="table-responsive">  
           <table class="table borderless">';  
      
      while($row = mysqli_fetch_array($result))  
      {  
           $output .= '  
               
			   
			   	<h3 style="text-align:center;">PERSONAL DETAILS</h3>
			    <tr>  
                     <td style="text-align:right;" width="50%"><label>Name:&nbsp;&nbsp;</label></td> 
                     
                     ';
                     
                     $lastname='';
                     if($row["lastname"] != "null"){
                         $lastname= $row["lastname"];
                     }
            
            $output .= '       
                     <td width="50%">'.$row["firstname"].'&nbsp;'.$lastname.'</td>
					   
                </tr>  
				
                <tr>  
                     <td style="text-align:right;" width="50%"><label>Email:&nbsp;&nbsp;</label></td>  
                     <td width="50%">'.$row["studentemailid"].'</td>  
                </tr>  
				
                <tr>  
                     <td style="text-align:right;" width="50%"><label>Gender:&nbsp;&nbsp;</label></td>  
                     <td width="50%">'.$row["gender"].'</td>  
                </tr>  
                <tr>  
                     <td style="text-align:right;" width="50%"><label>Belief/Religion:&nbsp;&nbsp;</label></td>  
                     <td width="50%">'.$row["religion"].'</td>  
                </tr>  
                  
				
				  
                ';  
      }  
      $output .= "</table></div>"; 
	  
	  
	  $query = "SELECT * FROM studentbirthdetails WHERE studentemailid = '".$_POST["employee_id"]."'";  
      $result = mysqli_query($connect, $query);  
	  
	  $output .= '  
	  
	 
	 
	  
      <div class="table-responsive">  
           <table class="table borderless">';  
      while($row = mysqli_fetch_array($result))  
      {  
           $output .= '  
               
			   
			   	<h3 style="text-align:center;">BIRTH COUNTRIES</h3>
			    <tr>  
                     <td style="text-align:right;" width="50%"><label>Student:&nbsp;&nbsp;</label></td>  
                     <td width="50%">'.$row["studentbirthplace"].'</td>
					   
                </tr>  
				<tr><td align="center" colspan="2"><hr style="padding 0%; margin:1%; width:40%"></td></tr>
                <tr>  
                     <td style="text-align:right;" width="50%"><label>Mother:&nbsp;&nbsp;</label></td>  
                     <td width="50%">'.$row["studentmotherbirthplace"].'</td>  
                </tr>  
				
                <tr>  
                     <td style="text-align:right;" width="50%"><label>Grandfather:&nbsp;&nbsp;</label></td>  
                     <td width="50%">'.$row["studentmothersfatherbirthplace"].'</td>  
                </tr>  
                <tr>  
                     <td style="text-align:right;" width="50%"><label>GrandMother:&nbsp;&nbsp;</label></td>  
                     <td width="50%">'.$row["studentmothersmotherbirthplace"].'</td>  
                </tr>  
                  
				 <tr><td align="center" colspan="2"><hr style="padding 0%; margin:1%; width:40%"></td></tr>
				 <tr>  
                     <td style="text-align:right;" width="50%"><label>Father:&nbsp;&nbsp;</label></td>  
                     <td width="50%">'.$row["studentfatherbirthplace"].'</td>  
                </tr>  
                <tr>  
                     <td style="text-align:right;" width="50%"><label>Grandfather:&nbsp;&nbsp;</label></td>  
                     <td width="50%">'.$row["studentfathersfatherbirthplace"].'</td>  
                </tr>  
                <tr>  
                     <td style="text-align:right;" width="50%"><label>GrandMother:&nbsp;&nbsp;</label></td>  
                     <td width="50%">'.$row["studentfathersmotherbirthplace"].'</td>  
                </tr>  
				  
                ';  
      }  
      $output .= "</table></div>"; 
	  
	  
	  $query = "SELECT * FROM studentlanguage WHERE studentemailid = '".$_POST["employee_id"]."'";  
      $result = mysqli_query($connect, $query);  
	  
	  $output .= '  
	  
	 
	 
	  
      <div class="table-responsive">  
           <table class="table borderless">';  
           $output .= '<h3 style="text-align:center;">LANGUAGES</h3>';
      while($row = mysqli_fetch_array($result))  
      {  
         
           
           $output .= '  
			   	
			    <tr>  
                     <td style="text-align:right;" width="50%"><label>'.$row["languagename"].':&nbsp;&nbsp;</label></td>  
                     <td width="50%">'.$row["languagelevel"].'</td>
					   
                </tr>  
				
                
				  
                ';  
      }  
      $output .= "</table></div>";  
	  
	  
      echo $output;  
 }  
 ?>