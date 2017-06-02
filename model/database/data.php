<?php
class data
{
	private $conn;
	private static function connection_string()
	{

		$servername = "localhost";
		$username = "noname";
		$password = "123123$#@!";
		$database="noname";
		try {
			$con =  new PDO("mysql:host=$servername;dbname=$database", $username, $password);
			$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$con->exec("set names utf8");
			return $con;
		}
		catch(PDOException $e)
		{
			echo "Connection failed: " . $e->getMessage();
		}


		// return  mysql_connect("localhost","elecstor_footbal","Pp123456","elecstor_football");

	}
	private  static function connection_open()
	{
		// Create connection



		$conn=self::connection_string();
		return $conn;


	}
	private static function connection_close()
	{
		//mysql_close(self::connection_string());
		$conn = null;
	}

	public static function call($ps,$param=null)
	{
		$con=self::connection_open();

		if($param=='' || $param==null)
		{
			//$cmd = sprintf("SELECT * FROM $table");
			$cmd = "CALL `$ps`();";
		}
		else
		{
			//$cmd = sprintf("SELECT * FROM $table WHERE $where");
			$cmd = "CALL `$ps`($param);";
		}

		try {

			$stmt = $con->prepare($cmd);
			$stmt->execute();
			$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
			//$r=array() ;
			$r=$stmt->fetchAll();

			//print_r($r);
			//exit;
			self::connection_close();
			return $r;

			//foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
			//	echo $v;
			//}
			//exit;
		}

		catch(PDOException $e) {
			return $row= "Error: " . $e->getMessage();
		}

		/*
		$con=self::connection_open();
		if($where=='' || $where==null)
		{
			//$cmd = sprintf("SELECT * FROM $table");
			$cmd = "SELECT * FROM $table";
		}
		else
		{
			//$cmd = sprintf("SELECT * FROM $table WHERE $where");
			$cmd = "SELECT * FROM $table WHERE $where";
		}
		$result = mysql_query($con,$cmd);
		self::connection_close();
		$row=array();
		while($row[] = mysql_fetch_array($result)) {
		}
		return $row;
		*/
	}
	public static function selects($table,$where)
	{
		$con=self::connection_open();

		if($where=='' || $where==null)
		{
			//$cmd = sprintf("SELECT * FROM $table");
			$cmd = "SELECT * FROM $table";
		}
		else
		{
			//$cmd = sprintf("SELECT * FROM $table WHERE $where");
			$cmd = "SELECT * FROM $table WHERE $where";
		}

		try {

			$stmt = $con->prepare($cmd);
			$stmt->execute();
			$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
			//$r=array() ;
			$r=$stmt->fetchAll();

			//print_r($r);
			//exit;
			self::connection_close();
			return $r;

			//foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
			//	echo $v;
			//}
			//exit;
		}

		catch(PDOException $e) {
			return $row= "Error: " . $e->getMessage();
		}

		/*
		$con=self::connection_open();
		if($where=='' || $where==null)
		{
			//$cmd = sprintf("SELECT * FROM $table");
			$cmd = "SELECT * FROM $table";
		}
		else
		{
			//$cmd = sprintf("SELECT * FROM $table WHERE $where");
			$cmd = "SELECT * FROM $table WHERE $where";
		}
		$result = mysql_query($con,$cmd);
		self::connection_close();
		$row=array();
		while($row[] = mysql_fetch_array($result)) {
		}
		return $row;
		*/
	}
	public static function selects_col($table,$cols,$where)
	{
		$con=self::connection_open();

		if($where=='' || $where==null)
		{
			$cmd = "SELECT $cols FROM $table";
		}
		else
		{
			$cmd = "SELECT $cols FROM $table WHERE $where";
		}

		//echo $cmd ; exit;
		try {

			$stmt = $con->prepare($cmd);
			$stmt->execute();
			$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
			$r=$stmt->fetchAll();

			self::connection_close();
			return $r;

		}

		catch(PDOException $e) {
			return $row= "Error: " . $e->getMessage();
		}
	}
	public static function selects_join($table,$cols,$join)
	{
		$con=self::connection_open();

		if($join=='' || $join==null)
		{
			$cmd = "SELECT $cols FROM $table";
		}
		else
		{
			$cmd = "SELECT $cols FROM $table $join";
		}

		//echo $cmd ; exit;
		try {

			$stmt = $con->prepare($cmd);
			$stmt->execute();
			$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
			$r=$stmt->fetchAll();

			self::connection_close();
			return $r;

		}

		catch(PDOException $e) {
			return $row= "Error: " . $e->getMessage();
		}
	}
	public static function insertinto($table,$col,$param)
	{
		$result="";
		$con=self::connection_open();
		try
		{
			$sql="INSERT INTO $table ($col)VALUES ($param)";
			//echo $sql ; exit;
			$con->exec($sql);
			$result = $con->lastInsertId();
		}
		catch(PDOException $e)
		{
			$result= $sql . "<br>" . $e->getMessage();
		}
		self::connection_close();
		return $result;

		//$con=self::connection_open();
		//$cmd="INSERT INTO $table ($col)VALUES ($param)";
		//$res= mysql_query($con,$cmd);

		//self::connection_close();
		//return  $res;
	}
	public static function update($table,$value,$where)
	{
		$result="";
		$con=self::connection_open();
		try
		{
			$sql="UPDATE $table SET $value WHERE $where";
			$con->exec($sql);
			$result = "1";
		}
		catch(PDOException $e)
		{
			$result= $sql . "<br>" . $e->getMessage();
		}
		self::connection_close();
		return $result;


		//$con=self::connection_open();
		//$cmd="UPDATE $table SET $value WHERE $where";
		//mysql_query($con,$cmd);

		//self::connection_close();
	}
	public static function delete($table,$where)
	{
		$result="";
		$con=self::connection_open();
		try
		{

			$sql="DELETE FROM $table WHERE $where";
			$con->exec($sql);
			$result = "1";
		}
		catch(PDOException $e)
		{
			$result= $sql . "<br>" . $e->getMessage();
		}
		self::connection_close();
		return $result;

		//return  mysql_query($con,"DELETE FROM $table WHERE $where");

	}
	public static function execute_non_qury()
	{

	}
	public static function execute_reader()
	{

	}

}