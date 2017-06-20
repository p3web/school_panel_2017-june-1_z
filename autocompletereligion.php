<?php
$dbHost = 'localhost';
$dbUsername = 'ancestry_atlas';
$dbPassword = ']?7W%4yATmA?';
$dbName = 'ancestry_atlas';
//connect with the database
$db = new mysqli($dbHost,$dbUsername,$dbPassword,$dbName);
//get search term
$searchTerm = $_GET['term'];
//get matched data from countries table
$query = $db->query("SELECT * FROM 	religions WHERE religion LIKE '".$searchTerm."%' ORDER BY religion");
$data[]="Non-Believer";
$data[]="---";

while ($row = $query->fetch_assoc()) {
    $data[] = $row['religion'];
}
//return json data
echo json_encode($data);

?>