<?php
$file = fopen("regionmapdataout.csv","r");
//print_r(fgetcsv($file));
//fclose($file);


//$file = fopen("contacts.csv","r");

$data_from_file = array();
$data_from_file[0] = array();
$i =0;

while(! feof($file))
  {
      $data_from_file[$i]= fgetcsv($file);
      $i++;
  }

fclose($file);

$data = array();
for($i=0 ; $i < count($data_from_file)-1 ; $i++){
    $data[$i]=$data_from_file[$i]; 
}

$content = array(
     $data 
        );

 echo json_encode($content);
?>