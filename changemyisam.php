<?php
    $con = mysqli_connect("localhost","root","$3pp60@2016","pankaj");
    // Actual code starts here 

    $query = "SELECT schema_name FROM information_schema.schemata WHERE schema_name NOT IN ('information_schema', 'mysql', 'performance_schema')";

    $result = mysqli_query($con, $query) or die(mysqli_error($con));
    
    while($db = mysqli_fetch_row($result)) :
       // $sql = "ALTER TABLE ".$db[0].".busdayrecord ENGINE=INNODB";
	    $sql = "CREATE INDEX latandlong ON ".$db[0].".busdayrecord (latandlong)";
	    $sql1 = "CREATE INDEX travel_time ON ".$db[0].".busdayrecord (travel_time)";
        mysqli_query($con,$sql);
        mysqli_query($con,$sql1);
        echo $db[0]."<br />";
    endwhile;
?>