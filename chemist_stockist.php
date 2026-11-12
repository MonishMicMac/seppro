<?php
	include("include/connect.php");
?>    
<table class="table table-striped table-bordered bootstrap-datatable datatable" style="width:300px;border:1px solid #cccccc;border-collapse:collapse">
    	<tr>
        <?php $Y=1;
			$DC=mysql_query("SELECT mst_rcpa_stockist.stockist_name AS STYPE FROM  tbl_rcpa_stockist,mst_rcpa_stockist WHERE tbl_rcpa_stockist.dc_id=0 AND tbl_rcpa_stockist.stockist_id=mst_rcpa_stockist.stockist_id");
			echo mysql_error();
			while($P=mysql_fetch_object($DC)){
		?>
        <td><?php echo $P->STYPE; ?></td>
        <?php 
		 if ($Y % 4 == 0){
            print "</tr><tr style='border:1px solid #cccccc;border-collapse:collapse'>";
        }
		$Y++; } ?>
    </tr>
    </table>