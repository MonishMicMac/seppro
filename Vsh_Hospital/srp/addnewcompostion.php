<?php
include("connect2.php"); 



$composition=$_REQUEST['composition'];












 $jj = mysql_query("SELECT * FROM mst_composition WHERE composition= '$composition'")or die(mysql_error());
      $jj_count = mysql_num_rows($jj);
     if($jj_count > 0)
    {
}
else
{
mysql_query("insert into mst_composition(composition)values('$composition')")or die(mysql_error());
}

?>
