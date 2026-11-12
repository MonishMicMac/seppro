<?php
$con=mysql_connect("gage.co.in", "gageco_tracking", "tracking123")or die('could not connect');
mysql_select_db("gageco_traccar",$con)or die ('could not database');  

echo '[';
global $str;


$jjtracking= mysql_query("SELECT positions.latitude AS lat,positions.longitude AS longi,devices.name AS dname FROM positions,devices WHERE devices.id IN (SELECT deviceId FROM user_device WHERE userId='6') AND positions.id = devices.positionId GROUP BY devices.name")or die(mysql_error());

while($jjtracking_res = mysql_fetch_array($jjtracking))
{
   $str.='{"Name":"KRM School","Latitude":"13.119553","Longitude":"80.2382453"},{"Latitude":'.'"'.$jjtracking_res['lat'].'","Longitude":'.'"'.$jjtracking_res['longi'].'","Name":'.'"'.$jjtracking_res['dname'].'"},';
}


 echo substr($str,0,-1).']';


?>