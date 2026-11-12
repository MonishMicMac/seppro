<?php
include("include/connect.php");
require_once("include/select.php");

$dis="select Distinct dist_id from pincode_list order by dist_id";
echo $co_dis=mysql_num_rows($dis);