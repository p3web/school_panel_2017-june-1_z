<?php
if ( isset( $_GET['out'] ) && $_GET['out'] ) {

	if ($_GET['out'] === "TRO"){
		$csvinputfile = "teacherreligonout.csv";
	}
	elseif ($_GET['out'] === "RO"){
		$csvinputfile = "religonout.csv";
	}
	elseif ($_GET['out'] === "TLO"){
		$csvinputfile = "langout.csv";
	}
	elseif ($_GET['out'] === "TARO"){
		$csvinputfile = "teamadminregionout.csv";
	}
	elseif ($_GET['out'] === "RAO"){
		$csvinputfile = "teacherreligonout.csv";
	}
	elseif ($_GET['out'] === "TALO"){
		$csvinputfile = "teamadminlangout.csv";
	}
	
	
}

$file = fopen($csvinputfile,"r");

$data_from_file = array();

$data_from_file[0] = array("Religon",
      
      "Quantity");

$i =1;


while(! feof($file))
  {
      $data_from_file[$i]= fgetcsv($file);
      $i++;
  }

fclose($file);

$metacontent = array(
		array(['School Name', 'City'],$data_from_file[1])
		);
unset($data_from_file[1]);
$data_from_file= array_values($data_from_file);

$data = array();
for($i=0 ; $i < count($data_from_file)-1 ; $i++){
	    $data[$i]=$data_from_file[$i]; 
}


$content = array(
     $data 
        );

if ( isset( $_GET['metadata'] ) && $_GET['metadata'] ) {

	echo json_encode($metacontent);
}else{
	echo json_encode($content);
}

?>