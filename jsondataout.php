<?php
if ( isset( $_GET['out'] ) && $_GET['out'] ) {

	if ($_GET['out'] === "TRO"){
		$csvinputfile = "teacherreligonout.csv";
		$headerrow = array("Religon",
      
      "Quantity");

	}
	elseif ($_GET['out'] === "SCT"){
		$csvinputfile = "staffcount.csv";
		$headerrow = array("Staff",
      
      "Quantity");

	}
	elseif ($_GET['out'] === "STCT"){
		$csvinputfile = "studentcount.csv";
		$headerrow = array("Student",

      "Quantity");

	}
	elseif ($_GET['out'] === "TRMDO"){
		$csvinputfile = "teacherregionmapdataout.csv";
		$headerrow = array("Region",
      
      "Quantity");

	}
	elseif ($_GET['out'] === "TLO"){
		$csvinputfile = "teacherlangout.csv";
		$headerrow = array("Language",
      
      "Quantity");

	}
	elseif ($_GET['out'] === "TARO"){
		$csvinputfile = "teamadminregionout.csv";
		$headerrow = array("Region",
      
      "Quantity");

	}
	elseif ($_GET['out'] === "RAO"){
		$csvinputfile = "teamadminreligonout.csv";
		$headerrow = array("Religon",
      
      "Quantity");

	}
	elseif ($_GET['out'] === "TALO"){
		$csvinputfile = "teamadminlangout.csv";
		$headerrow = array("Language",
      
      "Quantity");

	}


	
}

$file = fopen($csvinputfile,"r");

$data_from_file = array();

$data_from_file[0] = $headerrow;

$i =1;


while(! feof($file))
  {
      $data_from_file[$i]= fgetcsv($file);
      $i++;
  }

fclose($file);

$metacontent = array(
		array(['Name', 'Address'],$data_from_file[1])
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