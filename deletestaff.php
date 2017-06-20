<?php
ob_start();
session_cache_expire();
session_start();
?>
<?php
        
        
        if(!isset($_SESSION['teamorg'])){
        	header('Location:index.php');
        }else{

            include 'connection.php';
    		if(!mysql_query("DELETE from staff where staffemailid='".$_GET['id']."'",$con)){
    			die("Staff data not deleted".mysql_error());
    		}else{
    			mysql_close($con);
    			header('Refresh:0; url=teamadminpanel.php');
    			echo "<script>alert('Staff data has been deleted Successfully.')</script>";
    		  }
         }

?>