<?php  


$connect = mysqli_connect("localhost", "ancestry_atlas", "]?7W%4yATmA?", "ancestry_atlas");

if(!empty($_POST)){

    $error ="";
    
   
   
    $email = mysqli_real_escape_string($connect, $_POST["studentemailindiv"]);
    $country = mysqli_real_escape_string($connect, $_POST["sbindiv"]);
    $countrym = mysqli_real_escape_string($connect, $_POST["mindiv"]);
    $countrygfm = mysqli_real_escape_string($connect, $_POST["gfmindiv"]);
    $countrygmm = mysqli_real_escape_string($connect, $_POST["gmmindiv"]);
    $countryf = mysqli_real_escape_string($connect, $_POST["findiv"]);
    $countrygff = mysqli_real_escape_string($connect, $_POST["gffindiv"]);
    $countrygmf = mysqli_real_escape_string($connect, $_POST["gmfindiv"]);
    
    if( check_email($email) == "yes"){
        $error = "This email id is already registered.";
    }else if( check_country($country) == "no"){
		$error = "Student birth Country name not found.";
		
	}else if( check_country($countrym) == "no"){
	    $error ="Mother's birth Country name not found.";
	
	}else if( check_country($countrygfm) == "no"){
	    $error ="GrandFather (Mother's side) birth Country name not found.";
	
	}else if( check_country($countrygmm) == "no"){
	    $error ="GrandMother (Mother's side) birth Country name not found.";
	
	}else if( check_country($countryf) == "no"){
	    $error ="Father's birth Country name not found.";
	
	}else if( check_country($countrygff) == "no"){
	    $error ="GrandFather (Father's side) birth Country name not found.";
	
	}else if( check_country($countrygmf) == "no"){
	    $error ="GrandMother (Father's side) birth Country name not found.";
	
	}
	else{
	    $error ="No error";
	}
    
    
    echo $error;	
}





//function to check the countryname from the database
function check_country($birtdata){
	
	include 'connection.php';

	$query = "select countryname from countries";
	$result = mysql_query($query);
	
	$dataMatched = "no";
	while ($row=mysql_fetch_array($result))
	{
		if(strtolower($birtdata) == strtolower($row["countryname"])){
			$dataMatched = "yes";
			}
	}
	mysql_close($con);
	return $dataMatched;
}


//function to check the email id from the database
function check_email($email){
	
	include 'connection.php';

                $dataMatched ="no";
				
				
				//staff email check
				$querys = "select staffemailid from staff";
				$results = mysql_query($querys);
				
				while ($rows=mysql_fetch_array($results))
				{
					if(strtolower($email) == strtolower($rows["staffemailid"])){
						$dataMatched ="yes";
						$email = $rows["staffemailid"];
						
						}
				
				}
				
				
				
				//Team admin email check
				if($dataMatched == "no"){
					$queryo = "select teamemailid from teamadmin";
					$resulto = mysql_query($queryo);
					
					while ($rowo=mysql_fetch_array($resulto))
					{
						if(strtolower($email) == strtolower($rowo["teamemailid"])){
							$dataMatched ="yes";
							$email = $rowo["teamemailid"];
							
							}
					
					}
				}
				
				
				
				//organisation admin email check
				if($dataMatched == "no"){
					
					$queryo = "select orgadminemailid from organisationadmin";
					$resulto = mysql_query($queryo);
					
					
					
					while ($rowo=mysql_fetch_array($resulto))
					{
						if(strtolower($email) == strtolower($rowo["orgadminemailid"])){
							$dataMatched ="yes";
							$email = $rowo["orgadminemailid"];
							
							}
					
					}
				}
				
				//dept email check
				if($dataMatched == "no"){
					$queryd = "select deptemailid from deptadmin";
					$resultd = mysql_query($queryd);
					
					while ($rowd=mysql_fetch_array($resultd))
					{
						if(strtolower($email) == strtolower($rowd["deptemailid"])){
							$dataMatched = "yes";
							$email = $rowd["deptemailid"];
							
							}
					
					}
				}
				

			
				//School admin email check
				if($dataMatched == "no"){
					$query = "select adminemailid from school";
					$result = mysql_query($query);
					
					while ($row=mysql_fetch_array($result))
					{
						if(strtolower($email) == strtolower($row["adminemailid"])){
							$dataMatched = "yes";
							$email = $row["adminemailid"];
							
							}
					
					}
				}
				
				//teacher email check
				if($dataMatched == "no"){
					$queryt = "select teacheremailid from teacher";
					$resultt = mysql_query($queryt);
					
					while ($rowt=mysql_fetch_array($resultt))
					{
						if(strtolower($email) == strtolower($rowt["teacheremailid"])){
							$dataMatched = "yes";
							$email = $rowt["teacheremailid"];	
							}
					}
				}
				
				//student email check
				if($dataMatched == "no"){
					$querys = "select studentemailid from student";
					$results = mysql_query($querys);
					
					while ($rows=mysql_fetch_array($results))
					{
						if(strtolower($email) == strtolower($rows["studentemailid"])){
							$dataMatched = "yes";
							$email = $rows["studentemailid"];	
							}
					}
				}
	
	mysql_close($con);
	return $dataMatched;
}

 ?>