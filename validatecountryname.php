<?php  


$connect = mysqli_connect("localhost", "ancestry_atlas", "]?7W%4yATmA?", "ancestry_atlas");

if(!empty($_POST)){

    $error ="";
    
   
    $country = mysqli_real_escape_string($connect, $_POST["sb"]);
    $countrym = mysqli_real_escape_string($connect, $_POST["m"]);
    $countrygfm = mysqli_real_escape_string($connect, $_POST["gfm"]);
    $countrygmm = mysqli_real_escape_string($connect, $_POST["gmm"]);
    $countryf = mysqli_real_escape_string($connect, $_POST["f"]);
    $countrygff = mysqli_real_escape_string($connect, $_POST["gff"]);
    $countrygmf = mysqli_real_escape_string($connect, $_POST["gmf"]);
    	
    if( check_country($country) == "no"){
		$error = "Employee birth Country name not found.";
		
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

 ?>