<?php 
	//include 'connection.php';
	
if(isset($_POST['submit']))

  {
$con = mysql_connect("http://server.culturalinfusion.org:2082", "ancestryatlas", "$EC!~)?M?}=D");
$db = mysql_select_db("ancestry_atlas",$con);
//	include 'connection.php';
	$filename='uploads/'.strtotime(now).'.csv';
	echo $filename;

	
//$sql=mysql_query("SELECT religion, COUNT( religion ) FROM staff where orgid='".$orgId."' AND deptname='".$deptName."' AND teamname='".$teamName."' AND status='active' GROUP BY religion ORDER BY COUNT( religion ) DESC");
$sql=mysql_query("SELECT * from class") or die (mysql_error());

$row = mysql_fetch_assoc($sql);
echo $row;
//	$currentClassName = $_POST['classnamedropdownbeltab'];
//	$teamName = $_POST['classnamedropdownbeltab'];
//	echo '<script>activaTab("religion");</script>';
	
	}
	
	
?>


<html>
    
    <head>
        <form method="post" action="exp.php">
          
       	<input type="submit" name="submit" value="submit"  /> 
       	  </form>
    </head>
</html>