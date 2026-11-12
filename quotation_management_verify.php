<?php
include("include/connect.php");
session_start();
error_reporting(0);
$id=$_SESSION['id'];
$m_id16=$_SESSION['m_id16'];
if(!isset($_SESSION['id']))
{
   echo "<script type='text/javascript'>window.location='index.php?err'</script>"; 
}
else
{
include("encrypt.php");
include("include/select.php");
$fun = new select1;
$res=$fun->view('distributor','where m_id16='.$m_id16,'order by id desc');


if(@$_REQUEST['condition']=='update_quotation'){
	$value='';
	if($_REQUEST['admin_value']!='0' || $_REQUEST['manager_value']!='0'){
		
		if($_REQUEST['admin_value']!='0'){
		mysql_query("UPDATE quotation_management SET a_perval_given='".$_REQUEST['admin_value']."',a_status='1' WHERE id='".$_REQUEST['id']."'");
		} elseif($_REQUEST['manager_value']!='0'){
		mysql_query("UPDATE quotation_management SET m_perval_given='".$_REQUEST['manager_value']."',m_status='1' WHERE id='".$_REQUEST['id']."'");
		}

	}
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<?php include("include/title.php"); ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="mic and mac Solutions">
<meta name="author" content="mic and mac Solutions">
<link id="bs-css" href="css/bootstrap-cerulean.css" rel="stylesheet">
<style type="text/css">
body {
padding-bottom: 40px;
}
 .sidebar-nav {
padding: 9px 0;
}
.table tbody tr:hover{
    color:#555555 !important;
}
</style>
	<link href="css/bootstrap-responsive.css" rel="stylesheet">
	<link href="css/charisma-app.css" rel="stylesheet">
	<link href="css/jquery-ui-1.8.21.custom.css" rel="stylesheet">
	<link href='css/fullcalendar.css' rel='stylesheet'>
	<link href='css/fullcalendar.print.css' rel='stylesheet'  media='print'>
	<link href='css/chosen.css' rel='stylesheet'>
	<link href='css/uniform.default.css' rel='stylesheet'>
	<link href='css/colorbox.css' rel='stylesheet'>
	<link href='css/jquery.cleditor.css' rel='stylesheet'>
	<link href='css/jquery.noty.css' rel='stylesheet'>
	<link href='css/noty_theme_default.css' rel='stylesheet'>
	<link href='css/elfinder.min.css' rel='stylesheet'>
	<link href='css/elfinder.theme.css' rel='stylesheet'>
	<link href='css/jquery.iphone.toggle.css' rel='stylesheet'>
	<link href='css/opa-icons.css' rel='stylesheet'>
	<link href='css/uploadify.css' rel='stylesheet'>
	<link rel="shortcut icon" href="img/favicon1.ico">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
$(function() {
$( "#from_date" ).datepicker({
changeMonth: true,
changeYear: true,
yearRange: "1990:2020",
dateFormat:"yy/mm/dd"
});
$( "#to_date" ).datepicker({
changeMonth: true,
changeYear: true,
yearRange: "1990:2020",
dateFormat:"yy/mm/dd"
});
//ajax Starts
$("#search_box").keypress(function(){
    var from_date =$("#from_date").val();
    var to_date    =$("#to_date").val();
    var content =$("#search_box").val();
    var url="sort_shops.php?from_date="+from_date+"&to_date="+to_date+"&cont="+content;
    $.get(url,function(data,status){
        $("#search").html(data);
    });
});
//ajax Ends
});
</script>
	
</head>

<body>
<!-- topbar starts -->
<?php include("include/header.php"); ?>
<!-- topbar ends -->
<div class="container-fluid">
<div class="row-fluid">
<?php include("include/menu.php"); ?>

<noscript>
<div class="alert alert-block span10">
</div>
</noscript>

<div id="content" class="span10">
<div class="row-fluid sortable">		
<div class="box span12">
<div class="box-header well" data-original-title>
<h2><i class="icon-user"></i>Quotation Approval Report</h2>
<?php if($_SESSION['AUTH']==1){ ?><span style="padding-left:700px"><a href="quotation_management.php" class="btn btn-primary">New Quotation</a></span><?php } ?>
<div class="box-icon">
</div>
</div>
<input type="hidden" id="session_id" value="<?php echo $_SESSION['AUTH']; ?>">
<div class="box-content">
<br/>
<div class="box-content">
<table id="example" class="table table-bordered bootstrap-datatable datatable" width="100%">
<thead>
<tr>
	<th style="text-align:center">S.NO</th>
    <?php if($_SESSION['AUTH']!=1){ ?>
	<th style="text-align:center">REPRESENTATIVE</th>
	<?php } ?>
	<th style="text-align:center">DOCTOR</th>
	<th style="text-align:center">PRODUCT</th>
	<th style="text-align:center">ORIGINAL RATE</th>
	<th style="text-align:center">NEGOTIATION</th>
	<?php if($_SESSION['AUTH']==2 || $_SESSION['AUTH']==1){ ?>
	<th style="text-align:center;width: 100px;">DR COMM (M)</th>
	<th style="text-align:center">DR COMM (A)</th>
	<?php }elseif($_SESSION['AUTH']==3){ ?>
	<th style="text-align:center;width: 100px;">DR COMM (A)</th>
	<th style="text-align:center">DR COMM (M)</th>
	<?php } ?>
    <?php if($_SESSION['AUTH']!=1){ ?>
	<th style="text-align:center">ACTION</th>
	<?php } ?>
</tr>
</thead>   
<tbody>
	<?php
		$i=1;
		if($_SESSION['AUTH']==2){
			$sql=mysql_query("SELECT id,(select rep_name from representative where id=quotation_management.rep_id) as rep_name, (select doctor_name from doctors where id=quotation_management.doctor_id) as doctor_name, (select pro_name from product where product=product.id) as pro_name, original_rate, comm_perval, m_perval_given, a_perval_given, perval_type FROM quotation_management WHERE rep_id IN (select repid from assigningreptomanager where managerid='".$_SESSION['id']."')");
		} elseif($_SESSION['AUTH']==3){
			$sql=mysql_query("SELECT id,(select rep_name from representative where id=quotation_management.rep_id) as rep_name, (select doctor_name from doctors where id=quotation_management.doctor_id) as doctor_name, (select pro_name from product where product=product.id) as pro_name, original_rate, comm_perval, m_perval_given, a_perval_given, perval_type FROM quotation_management");
		} elseif($_SESSION['AUTH']==1){
			$sql=mysql_query("SELECT id,(select rep_name from representative where id=quotation_management.rep_id) as rep_name, (select doctor_name from doctors where id=quotation_management.doctor_id) as doctor_name, (select pro_name from product where product=product.id) as pro_name, original_rate, comm_perval, m_perval_given, a_perval_given, perval_type, m_status, a_status FROM quotation_management WHERE rep_id='".$_SESSION['id']."'");
		}
		while($row=mysql_fetch_array($sql)){
	?>
    <?php if($_SESSION['AUTH']!=1){ ?>
    <tr>
    	<td style="text-align:center"><?php echo $i; ?></td>
    	<td style="text-align:center"><?php echo $row['rep_name']; ?></td>
    	<td style="text-align:center"><?php echo $row['doctor_name']; ?></td>
    	<td style="text-align:center"><?php echo $row['pro_name']; ?></td>
    	<td style="text-align:center"><?php echo $row['original_rate']; ?></td>
    	<td style="text-align:center">
    	<?php 
    		if($row['perval_type']=='percentage'){
    			$percent=($row['comm_perval']/$row['original_rate'])*100; 
    			echo round($percent,2).'%';
    		} else {
    			echo round($row['comm_perval'],2);
    		}

    	?>
    	</td>

		<?php if($_SESSION['AUTH']==2){ ?>

        <?php 
            if($row['perval_type']=='percentage'){
                $m_val=round(($row['m_perval_given']/$row['original_rate'])*100,2); 
            } else {
                $m_val=round($row['m_perval_given'],2);
            }

        ?>
    	<td style="text-align:center"><?php if($row['perval_type']=='percentage'){ echo '&nbsp;&nbsp;&nbsp;&nbsp;'; } ?><input type="text" id="manager_given<?php echo $row['id']; ?>" commission="<?php echo $row['comm_perval']; ?>" original="<?php echo $row['original_rate']; ?>" perval_type="<?php echo $row['perval_type']; ?>" value="<?php echo $m_val; ?>" style="width: 50%;"><?php if($row['perval_type']=='percentage'){ echo ' %'; } ?></td>
    	
    	<td style="text-align:center">
    	<?php 
    		if($row['perval_type']=='percentage'){
    			$percent=($row['a_perval_given']/$row['original_rate'])*100; 
    			echo round($percent,2).'%';
    		} else {
    			echo round($row['a_perval_given'],2);
    		}

    	?>
    	</td>
		<?php }elseif($_SESSION['AUTH']==3){ ?>
        <?php 
            if($row['perval_type']=='percentage'){
                $a_val=round(($row['a_perval_given']/$row['original_rate'])*100,2); 
            } else {
                $a_val=round($row['a_perval_given'],2);
            }

        ?>
    	<td style="text-align:center"><?php if($row['perval_type']=='percentage'){ echo '&nbsp;&nbsp;&nbsp;&nbsp;'; } ?><input type="text" id="admin_given<?php echo $row['id']; ?>" commission="<?php echo $row['comm_perval']; ?>" original="<?php echo $row['original_rate']; ?>" perval_type="<?php echo $row['perval_type']; ?>" value="<?php echo $a_val; ?>" style="width: 50%;"><?php if($row['perval_type']=='percentage'){ echo ' %'; } ?></td>
    	
    	<td style="text-align:center">
    	<?php 
    		if($row['perval_type']=='percentage'){
    			$percent=($row['m_perval_given']/$row['original_rate'])*100; 
    			echo round($percent,2).'%';
    		} else {
    			echo round($row['m_perval_given'],2);
    		}

    	?>
    	</td>
		<?php } ?>

    	<td style="text-align:center"><input type="submit" class="btn btn-success approve" attr_id="<?php echo $row['id']; ?>" name="submit" value="Submit" /></td>
    </tr>
    <?php } else { ?>
    <tr <?php if($row['m_status']==1 && $row['a_status']==1){ echo "style='background-color:#73a839;color:white;'"; } ?>>
    	<td style="text-align:center"><?php echo $i; ?></td>
    	<td style="text-align:center"><?php echo $row['doctor_name']; ?></td>
    	<td style="text-align:center"><?php echo $row['pro_name']; ?></td>
    	<td style="text-align:center"><?php echo $row['original_rate']; ?></td>
    	<td style="text-align:center">
    	<?php 
    		if($row['perval_type']=='percentage'){
    			$percent=($row['comm_perval']/$row['original_rate'])*100; 
    			echo round($percent,2).'%';
    		} else {
    			echo round($row['comm_perval'],2);
    		}

    	?>
    	</td>
    	<td style="text-align:center">
    	<?php 
    		if($row['perval_type']=='percentage'){
    			$percent=($row['m_perval_given']/$row['original_rate'])*100; 
    			echo round($percent,2).'%';
    		} else {
    			echo round($row['m_perval_given'],2);
    		}

    	?>
    	</td>
    	<td style="text-align:center">
    	<?php 
    		if($row['perval_type']=='percentage'){
    			$percent=($row['a_perval_given']/$row['original_rate'])*100; 
    			echo round($percent,2).'%';
    		} else {
    			echo round($row['a_perval_given'],2);
    		}

    	?>
    	</td>
    </tr>
    <?php } ?>
    <?php $i++; } ?>
</tbody>
</table>   
</div>  
<div>&nbsp;</div>
</div>
</div>
</div>
</div>
</div>
<hr>

<?php include("include/footer.php"); ?>

</div>

<script src="js/jquery-1.7.2.min.js"></script>
<script src="js/jquery-ui-1.8.21.custom.min.js"></script>
<script src="js/bootstrap-transition.js"></script>
<script src="js/bootstrap-alert.js"></script>
<script src="js/bootstrap-modal.js"></script>
<script src="js/bootstrap-dropdown.js"></script>
<script src="js/bootstrap-scrollspy.js"></script>
<script src="js/bootstrap-tab.js"></script>
<script src="js/bootstrap-tooltip.js"></script>
<script src="js/bootstrap-popover.js"></script>
<script src="js/bootstrap-button.js"></script>
<script src="js/bootstrap-collapse.js"></script>
<script src="js/bootstrap-carousel.js"></script>
<script src="js/bootstrap-typeahead.js"></script>
<script src="js/bootstrap-tour.js"></script>
<script src="js/jquery.cookie.js"></script>
<script src='js/fullcalendar.min.js'></script>
<script src='js/jquery.dataTables.min.js'></script>
<script src="js/excanvas.js"></script>
<script src="js/jquery.flot.min.js"></script>
<script src="js/jquery.flot.pie.min.js"></script>
<script src="js/jquery.flot.stack.js"></script>
<script src="js/jquery.flot.resize.min.js"></script>
<script src="js/jquery.chosen.min.js"></script>
<script src="js/jquery.uniform.min.js"></script>
<script src="js/jquery.colorbox.min.js"></script>
<script src="js/jquery.cleditor.min.js"></script>
<script src="js/jquery.noty.js"></script>
<script src="js/jquery.elfinder.min.js"></script>
<script src="js/jquery.raty.min.js"></script>
<script src="js/jquery.iphone.toggle.js"></script>
<script src="js/jquery.autogrow-textarea.js"></script>
<script src="js/jquery.uploadify-3.1.min.js"></script>
<script src="js/jquery.history.js"></script>
<script src="js/charisma.js"></script>

<script type="text/javascript">
	$(".approve").click(function(){
		var id=$(this).attr('attr_id');

		if($("#session_id").val()=='3'){
			if($("#admin_given"+id).val()>0){
				var adm_val=$("#admin_given"+id).val();
				if($("#admin_given"+id).attr('perval_type')=='percentage'){
					var admin_value=(parseInt(adm_val)*parseInt($("#admin_given"+id).attr('original')))/100;
				} else {
                    var admin_value=$("#admin_given"+id).val();
                }
			} else {
				var admin_value=$("#admin_given"+id).attr('commission');
			}
			var manager_value='0';

		} else if($("#session_id").val()=='2'){
			if($("#manager_given"+id).val()>0){
				var mgr_val=$("#manager_given"+id).val();
				if($("#manager_given"+id).attr('perval_type')=='percentage'){
					var manager_value=(parseInt(mgr_val)*parseInt($("#manager_given"+id).attr('original')))/100;
				} else {
                    var manager_value=$("#manager_given"+id).val();
                }
			} else {
				var manager_value=$("#manager_given"+id).attr('commission');
			}
			var admin_value='0';

		}

        window.location.href="quotation_management_verify.php?id="+id+"&admin_value="+admin_value+"&manager_value="+manager_value+"&condition=update_quotation";
	});
</script>

</body>
</html>
<?php
}
?>
