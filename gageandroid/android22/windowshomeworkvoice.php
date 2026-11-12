<?php

error_reporting(0);
$con=mysql_connect("localhost","adsouq_school","micandmac@123");
mysql_select_db("adsouq_school",$con);




	
	echo '{"title":{"episodes": [
            {
                "season": "Pandiyan",
                "name": "Pandiyan",
                "number": "Pandiyan"
            }],
        "year": 2005
    }
}';

?>