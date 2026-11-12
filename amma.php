<?php
include("include/connect.php");
ini_set('memory_limit', '-1');
ini_set('upload_max_filesize', '512M');
ini_set('post_max_size', '512M');
ini_set('max_input_time', 3000);
ini_set('max_execution_time', 15000);
?>

<?php
$html="";
$text = file_get_contents('chart_mpdf.php');
$text = preparePreText($text);

// Default spaces/tab in mPDF is 8 as specified by HTML spec.
// Notepad and other text editors use a value of 6
$mpdf->tabSpaces = 6;

// If 'scriptfile.php' is iso-8859-1 or win-1252 encoded, use
$mpdf->allow_charset_conversion=true;
$mpdf->charset_in='windows-1252';
include("mpdf/mpdf.php");
$mpdf=new mPDF('c'); 
$mpdf->setFooter('{PAGENO} of {nb}');
$mpdf->WriteHTML($text, 2);

$mpdf->Output();
exit;
?>