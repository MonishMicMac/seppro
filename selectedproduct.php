<?php 	
include("include/connect.php");

$prod = $_POST['productId'];
//echo $prod."<br/>Hai<br/>";
//$valg = 1;
$res=mysql_query("SELECT pro_mrp FROM product WHERE id = ".$prod."");
				$row_res=mysql_fetch_array($res);
                //print_r($row_res);
                //echo $row_res;
				
//$sql = "select pro_mrp from product WHERE id = 4";
//$result = $connect->query($sql);

//if($result->num_rows > 0) { 
 //$row = $result->fetch_array();
//} 

//$connect->close();

//$spe=mysql_query("select pro_mrp from product WHERE id = 6")or die(mysql_error());
  //$row_spe=mysql_fetch_array($spe);
echo json_encode($row_res);
