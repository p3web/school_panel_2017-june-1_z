<?php
ob_start();
session_cache_expire();
session_start();
?>
<?php
        
        
        if(!isset($_SESSION['teacher'])){
        	header('Location:index.php');
        }else{

            include 'connection.php';
    		if(!mysql_query("DELETE from student where studentemailid='".$_GET['id']."'",$con)){
    			die("Student data not deleted".mysql_error());
    		}else{
    			mysql_close($con);
    			header('Refresh:0; url=teacherpanel.php');
    			echo "<script>alert('Student data has been deleted Successfully.')</script>";
    		  }
         }

?>