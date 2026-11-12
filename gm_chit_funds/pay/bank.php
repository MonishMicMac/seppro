<?php
	$file1="bank.txt";  
    if (file_exists($file1))   
    {  
    $file = fopen("bank.txt", "r");  
     while (!feof($file))   
     {  
      $display = fgets($file, filesize("bank.txt"));  
      echo $display . "<br>";  
     }  
     fclose($file);  
    }   
    else   
    {  
      echo "Error occured ! ! ! Try again or report it to us";  
    }  
?>	
	
	<script type="text/javascript">
	
	<!-- Begin
	
	function reFresh() {
	
	  location.reload(true)
	
	}
	
	/* Set the number below to the amount of delay, in milliseconds,
	
	you want between page reloads: 1 minute = 60000 milliseconds. */
	
	window.setInterval("reFresh()",9000);
	
	// End -->
	
	</script>	
