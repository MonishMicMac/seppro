<?php
	include("include/connect.php");
?>
<table class="table table-striped table-bordered bootstrap-datatable datatable" id="PT" style="width:300px;border:1px solid #cccccc;border-collapse:collapse">
    	<tr>
        <?php $Y=1;
			$DC=mysql_query("SELECT mst_patient_type.patient_type_name AS PTYPE FROM tbl_drpatient_type,mst_patient_type WHERE doctor_id IN (SELECT doctor_id FROM tbl_doctor_chemist WHERE dc_id=".$_REQUEST["dc_id"].") AND tbl_drpatient_type.patient_type_id=mst_patient_type.patient_id");
			while($P=mysql_fetch_object($DC)){
		?>
        <td><?php echo $P->PTYPE; ?></td>
        <?php 
		 if ($Y % 4 == 0){
            print "</tr><tr style='border:1px solid #cccccc;border-collapse:collapse'>";
        }
		$Y++; } ?>
    </tr>
    </table>