 <?php
				$log1=mysql_query("select * from site_conf");
				$row_log1=mysql_fetch_array($log1);
				$footer_name=$row_log1['footer'];
				?>

<footer><p class="pull-left"><?php echo @$_SESSION["CNAME"]; ?></p>
<!-- <p class="pull-right">Designed by:<a href="http://micandmac.net" target="_blank">Mic and Mac Solutions Pvt Ltd</a></p> -->
</footer>