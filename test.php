<?php
////////// GET IP ADDRESS //////////
function get_client_ip() {
  $ipaddress = '';
  if (isset($_SERVER['HTTP_CLIENT_IP'])){
    $ipaddress = $_SERVER['HTTP_CLIENT_IP'];

  }else if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
    $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];

  }else if(isset($_SERVER['HTTP_X_FORWARDED'])){
    $ipaddress = $_SERVER['HTTP_X_FORWARDED'];

  }else if(isset($_SERVER['HTTP_FORWARDED_FOR'])){
    $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];

  }else if(isset($_SERVER['HTTP_FORWARDED'])){
    $ipaddress = $_SERVER['HTTP_FORWARDED'];

  }else if(isset($_SERVER['REMOTE_ADDR'])){
    $ipaddress = $_SERVER['REMOTE_ADDR'];

  }else{
    $ipaddress = 'UNKNOWN';
  }
  return $ipaddress;
}

////////// GET COUNTRY //////////
function ip_details($IPaddress) 
{
  $json=file_get_contents("http://www.geoplugin.net/json.gp?ip=$IPaddress");
  $details=json_decode($json);
  return $details;
}
$IPaddress=get_client_ip();
$details=ip_details($IPaddress);

echo $details->geoplugin_countryName;
?>