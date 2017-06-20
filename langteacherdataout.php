<?php
$file = fopen("langout.csv","r");

$data_from_file = array();
$data_from_file[0] = array("Language",
							"Quantity"
							);
$i =1;

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