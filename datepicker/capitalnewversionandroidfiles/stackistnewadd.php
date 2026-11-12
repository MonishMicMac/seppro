<?php
include("connect23.php"); 





$patient_type_name=$_REQUEST['patient_type_name'];





  $jj = mysql_query("SELECT * FROM mst_rcpa_stockist WHERE stockist_name= '$patient_type_name'")or die(mysql_error());
      $jj_count = mysql_num_rows($jj);
     if($jj_count > 0)
    {
}
else
{
mysql_query("insert into mst_rcpa_stockist(stockist_name)values('$patient_type_name')")or die(mysql_error());
}







?>
