<?php
$voice=$_REQUEST["voice"];
$ch1=curl_init("http://call.smshorizon.in/api/v1/api.php?api_key=85fc838e7f5d3492c2955c77c0567cd7&method=voice.call&play=185349.sound&numbers=9841700035");
curl_setopt($ch1, CURLOPT_HEADER, 0);
curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
$response1=curl_exec($ch1);
if (curl_errno($ch1)) {
      print curl_error($ch1);
  }
curl_close($ch1);                                
echo $response1;

?>