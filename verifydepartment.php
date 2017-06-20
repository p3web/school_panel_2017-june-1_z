<?php
         
         
            
	include 'connection.php';

	

  
 if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['token']) && !empty($_GET['token'])){
    // Verify data
	 
	$email = mysql_escape_string($_GET['email']); // Set email variable
    $token = mysql_escape_string($_GET['token']); // Set hash variable
	 
	 $search = mysql_query("SELECT deptemailid, token, status FROM deptadmin WHERE deptemailid='".$email."' AND token='".$token."' AND status='pending'") or die(mysql_error()); 
	 $match  = mysql_num_rows($search);
	 
	 if($match > 0){
    	// We have a match, activate the account
		// mysql_query("UPDATE teacher SET status='active' WHERE teacheremailid='".$email."' AND token='".$token."' AND status='pending'") or die(mysql_error());
		
		 header('location:departmentregistrationstep1.php?u='.$email.'&t='.$token.'');

	}else{
		// No match -> invalid url or account has already been activated.
		 echo 'The url is either invalid or you already have activated your account.';
	}
	 
	 
}else{
    echo 'Invalid approach, please use the link that has been send to your email.';
}

mysql_close($con);

  ?>