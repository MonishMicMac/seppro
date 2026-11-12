<?php

    
    include("geo_server_connect.php");

    function update_rep_latlong_geo_server($rep_id,$rep_lat, $rep_long){

        include("geo_server_connect.php");

        $id=$rep_id;
        $companyname='hitwin';




        $latlong = $rep_lat.",".$rep_long.":";

        date_default_timezone_set('Asia/Kolkata');

        $cdate= date('Y-m-d');

        $ctime= date("H:i");

        $date_t = date('Y/m/d');

        if($rep_lat === '0.0' || '' || strlen($rep_lat) <= 2 )
        {
            mysql_query("UPDATE representative SET lastdate='$cdate',lasttime='$ctime',repcurrentstatus='1',waiting=' ' WHERE rep_id= '$id' and companyname like'%$companyname'")or die(mysql_error());


        }

        else
        {
           $a = mysql_query("SELECT rep_lat,rep_long,waiting FROM representative WHERE rep_id='$id' and companyname like'%$companyname' ORDER BY id DESC LIMIT 1")or die(mysql_error());
            
            $i = 1;
            while($c = mysql_fetch_array($a))
            {

                if($rep_lat==$c['rep_lat'])
                {

                    $w = (($c['waiting']  !='')?$c['waiting']:0)+1;


                    if($w > 10)

                    {
                        $y = mysql_query("UPDATE representative SET rep_lat='$rep_lat',rep_long='$rep_long',lastdate='$cdate',lasttime='$ctime',waiting='$w',repcurrentstatus='2' WHERE rep_id= '$id' and  companyname like'%$companyname'")or die(mysql_error());


                        $Y = mysql_query("SELECT * FROM busdayrecord WHERE time='".$rep_id."' AND date='".date("Y/m/d")."' and  companyname like'%$companyname'");
                        
                        $YCNT = mysql_num_rows($Y);
                        
                        if($YCNT==0){
                            
                           mysql_query("INSERT INTO busdayrecord(busid,time,latandlong,latlog,date,travel_time,companyname) VALUES('".$rep_id."','".$rep_id."','".$latlong."','".$latlong."','".date("Y/m/d")."','".date("H:i")."','$companyname')");

                            echo mysql_error();
                        
                        }
                        
                        if($YCNT>0){
                            
                            $P = mysql_fetch_object($Y); $CONCAT = $P->latandlong."".$latlong; $CONTRAVELTIME = $P->travel_time.",".date("H:i");
                        
                            mysql_query("UPDATE busdayrecord SET latandlong='".$CONCAT."',latlog='".$latlong."',travel_time='".$CONTRAVELTIME."' WHERE time='".$rep_id."' AND date='".date("Y/m/d")."' AND latlog<>'".$latlong."' AND  companyname like'%$companyname'");
                        
                        }


                    }


                    else

                    {
                        $y = mysql_query("UPDATE representative SET rep_lat='$rep_lat',rep_long='$rep_long',lastdate='$cdate',lasttime='$ctime',waiting='$w' WHERE rep_id= '$id' and  companyname like'%$companyname'")or die(mysql_error());



                        $Y = mysql_query("SELECT * FROM busdayrecord WHERE time='".$rep_id."' AND date='".date("Y/m/d")."' AND  companyname like'%$companyname'");
                        
                        $YCNT = mysql_num_rows($Y);
                        
                        if($YCNT==0){   
                           
                            mysql_query("INSERT INTO busdayrecord(busid,time,latandlong,latlog,date,travel_time,companyname) VALUES('".$rep_id."','".$rep_id."','".$latlong."','".$latlong."','".date("Y/m/d")."','".date("H:i")."','$companyname')");

                            echo mysql_error();
                        
                        }
                        
                        if($YCNT>0){

                           
                            $P = mysql_fetch_object($Y); $CONCAT = $P->latandlong."".$latlong; $CONTRAVELTIME = $P->travel_time.",".date("H:i");
                        
                            mysql_query("UPDATE busdayrecord SET latandlong='".$CONCAT."',latlog='".$latlong."',travel_time='".$CONTRAVELTIME."' WHERE time='".$rep_id."' AND date='".date("Y/m/d")."' AND latlog<>'".$latlong."' AND  companyname like'%$companyname'");
                        
                        }

                    }


                }

                else
                {

                    
                    $b = mysql_query("UPDATE representative SET rep_lat='$rep_lat',rep_long='$rep_long',lastdate='$cdate',lasttime='$ctime',repcurrentstatus='3',waiting=' ' WHERE rep_id= '$id' and  companyname like'%$companyname'")or die(mysql_error());



                    $Y = mysql_query("SELECT * FROM busdayrecord WHERE time='".$rep_id."' AND date='".date("Y/m/d")."' AND  companyname like '%$companyname' ORDER BY id DESC LIMIT 1 ");

                    $YCNT = mysql_num_rows($Y);
                    
                    if($YCNT==0){

                        mysql_query("INSERT INTO busdayrecord(busid,time,latandlong,latlog,date,travel_time,companyname) VALUES('".$rep_id."','".$rep_id."','".$latlong."','".$latlong."','".date("Y/m/d")."','".date("H:i")."','$companyname')");

                        echo mysql_error();
                    }
                    if($YCNT>0){
                        
                        $P = mysql_fetch_object($Y); 

                        
                        $CONCAT = $P->latandlong."".$latlong; 

                        
                        $CONTRAVELTIME = $P->travel_time.",".date("H:i");

                        
                        mysql_query("UPDATE busdayrecord SET latandlong = '$CONCAT',
                        latlog = '$latlong',
                        travel_time = '$CONTRAVELTIME' WHERE TIME = '$rep_id' AND DATE = '$date_t' AND latlog <> '$latlong' AND companyname like'%$companyname' ");
                    }

                }

            }



        }
    }

?>