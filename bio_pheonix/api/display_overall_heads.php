<?php
$con = mysql_connect("localhost", "root", "$3pp60@2016");
mysql_select_db("bio_pheonix");

$strSQL = "SELECT * FROM representative WHERE rep_id !='0'";
$objQuery = mysql_query($strSQL);

if (!$objQuery) {
    echo json_encode(array(
        "status" => false,
        "message" => "Database error: " . mysql_error(),
        "data" => (object)array()
    ));
    exit;
}

$intNumField = mysql_num_fields($objQuery);

$resultArray = array(); 

while ($obResult = mysql_fetch_array($objQuery)) {
    $arrCol = array();
    for ($i = 0; $i < $intNumField; $i++) {
        $arrCol[mysql_field_name($objQuery, $i)] = $obResult[$i];
    }
    
    $rowId = $arrCol['id'];
    $resultArray[$rowId] = $arrCol;
}

mysql_close($con);

if (count($resultArray) > 0) {
    $response = array(
        "status" => true,
        "message" => "Representatives retrieved successfully",
        "data" => (object)$resultArray 
    );
} else {
    $response = array(
        "status" => false,
        "message" => "No representatives found",
        "data" => (object)array()
    );
}

echo json_encode($response);
?>