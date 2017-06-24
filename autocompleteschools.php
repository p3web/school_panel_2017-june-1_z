<?php
$dbHost = 'localhost';
$dbUsername = 'ancestry_atlas';
$dbPassword = ']?7W%4yATmA?';
$dbName = 'ancestry_atlas';
//connect with the database
$db = new mysqli($dbHost,$dbUsername,$dbPassword,$dbName);
//get search term
$searchTerm = $_GET['term'];
//get matched data from schools table
$query = $db->query("SELECT * FROM 	schools WHERE schoolname LIKE '".$searchTerm."%' ORDER BY schoolname");
while ($row = $query->fetch_assoc()) {
    $data[] = $row['schoolname'];
}
//return json data
echo json_encode($data);

?>



