<?php  
   
           // $AUTH_USERNAME = "Username";
           // $AUTH_PASSWORD = "Password";
            
           // $url = 'curl -X POST -H "Conrpc": "2.0", "method": "common", "params": {"db": "odoo", "login": "mobile", "password": "mobile123!"}}' http://59.90.167.107:8080/web/session/authenticate'; 
           // $data = array("src" => "source",  "text" => "test curl request");
            
           // $ch=curl_init($url);
           // curl_setopt($ch, CURLOPT_POST, true);
           // curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
           // curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
            
           // curl_setopt($ch, CURLOPT_USERPWD, $AUTH_USERNAME . ":" . $AUTH_PASSWORD);
            
           // $response = curl_exec( $ch );
           // if(!response){
           //     die('Error: "' . curl_error($ch) . '" - Code: ' . curl_errno($ch));
           // }
           // curl_close($ch);



         echo    $url = 'curl -X POST -H "Conrpc": "2.0", "method": "common", "params": {"db": "odoo", "login": "mobile", "password": "mobile123!"}}' http://59.90.167.107:8080/web/session/authenticate';
                  $crl = curl_init();
                   
                  curl_setopt($crl, CURLOPT_URL, $url);
                  curl_setopt($crl, CURLOPT_FRESH_CONNECT, true);
                  curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
                  $response = curl_exec($crl);
                   
                  if(!response){
                      die('Error: "' . curl_error($ch) . '" - Code: ' . curl_errno($ch));
                  }
                  curl_close($crl);
                
  ?>     