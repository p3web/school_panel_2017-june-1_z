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
$query = $db->query("SELECT * FROM 	languages WHERE language LIKE '".$searchTerm."%' ORDER BY language");
while ($row = $query->fetch_assoc()) {
    $data[] = $row['language'];
}
//return json data
echo json_encode($data);

?>