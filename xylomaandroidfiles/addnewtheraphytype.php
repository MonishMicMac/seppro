<?php
include("connect23.php"); 


$theraphy=$_REQUEST['theraphy'];












 $jj = mysql_query("SELECT * FROM mst_theraphy WHERE theraphy= '$theraphy'")or die(mysql_error());
      $jj_count = mysql_num_rows($jj);
     if($jj_count > 0)
    {
}
else
{
mysql_query("insert into mst_theraphy(theraphy)values('$theraphy')")or die(mysql_error());
}

?>