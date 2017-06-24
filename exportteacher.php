<?php
ob_start();
session_cache_expire();
session_start();
?>
<?php
	require('fpdf/fpdf.php');
	$adminid = $_SESSION['emailid']; 
	 if (!empty($_POST['pngaddresstoexport']))
		{
			$pngcontent= $_POST['pngaddresstoexport'];
			export_infography($pngcontent,$adminid);
			$data = base64_decode($pngcontent);
			file_put_contents('ChartImage.png', $data);
		}
	
function export_infography($var_value,$adminid)
{
	$pdf = new FPDF();
	$pdf->AddPage();
	$pdf->SetFont('Arial','B',16);
	$pdf->Cell(40,10,'Hello '.$adminid.'!');
	$pdf->Ln(10);
	//$pdf->Cell(40,10,'The path is '.$var_value.'!');
	$pdf->Image('ChartImage.png',60,30,90,0,'png');
	$pdf->Output();
}
?>