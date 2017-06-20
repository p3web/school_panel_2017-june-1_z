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
$query = $db->query("SELECT * FROM 	countries WHERE countryname LIKE '".$searchTerm."%' ORDER BY countryname");
while ($row = $query->fetch_assoc()) {
    $data[] = $row['countryname'];
}
//return json data
echo json_encode($data);

?>