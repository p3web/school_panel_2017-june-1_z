<?php
ob_start();         
         
            
	

	

  
 if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['t']) && !empty($_GET['t'])  AND  isset($_GET['c']) && !empty($_GET['c']) AND isset($_GET['resettoken']) && !empty($_GET['resettoken'])  ){
    // Verify data
	 
	 
	$email = mysql_escape_string($_GET['email']); // Set email variable
    $resettoken = mysql_escape_string($_GET['resettoken']); // Set hash variable
	$tableName = mysql_escape_string($_GET['t']);
	$columnName = mysql_escape_string($_GET['c']);
	
	include 'connection.php';
	 
	 $search = mysql_query("SELECT $columnName, token, status FROM $tableName WHERE $columnName='".$email."' AND resetpassword='".$resettoken."' AND resetpasswordstatus='active'") or die(mysql_error()); 
	 $match  = mysql_num_rows($search);
	 
	 if($match > 0){
    	// We have a match, activate the account
		// mysql_query("UPDATE teacher SET status='active' WHERE teacheremailid='".$email."' AND token='".$token."' AND status='pending'") or die(mysql_error());
		
		 header('Location:forgetpasswordstep1.php?email='.$email.'&t='.$tableName.'&c='.$columnName.'&resettoken='.$resettoken.'');
		 
		
		 exit;
		 

	}else{
		// No match -> invalid url or account has already been activated.
		 echo 'The url is either invalid or you already have activated your account.';
	}
	 
	 
}else{
    echo 'Invalid approach, please use the link that has been send to your email.';
}

mysql_close($con);

  ?>