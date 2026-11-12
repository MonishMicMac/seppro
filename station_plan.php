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
    
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script>
$(function() {

    $('#from_date').datepicker( {
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        dateFormat: 'MM yy',
        yearRange: '1980:' + new Date().getFullYear(),
        beforeShow: function(el, dp) { 
            $('#ui-datepicker-div').addClass('hide-calendar');
        },
        onClose: function(dateText, inst) { 
            $('#ui-datepicker-div').removeClass('hide-calendar');
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            $(this).datepicker('setDate', new Date(year, month, 1));
        }
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
<style>
 .ui-datepicker-calendar {
   display: none;
 }
</style>

	
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
<h2><i class="icon-user"></i>Station Plan</h2>
<div class="box-icon">
</div>
</div>

<div class="box-content">

<div>
    <form name="thisForm" action="" method="post">
    	<table style="width:100%;">
            <tr>
            	<?php if($_SESSION['AUTH']=='3'){ ?>
            	<td >Representative</td>
                <td>:</td>
                <td><select id="rep_name" name="rep_name" data-rel="chosen" required>
				<option value="">--Select--</option>
				<?php
				$res=mysql_query("SELECT * FROM representative");
				while($row_res=mysql_fetch_array($res)) {
				$rep_name1=$row_res['rep_name'];
				$id=$row_res['id'];
				?>
				<option value="<?php echo $id; ?>"><?php echo $rep_name1; ?></option>
				<?php } ?> 
				</select>
               </td>
				<?php } ?>
            <!--  <td><input name="form-field-radio" class="ace css-checkbox" value="out" type="radio" id="one" required>
            <span class="lbl" style="margin-left: 10%;" required>out</span></td> 

            <td><input name="form-field-radio" class="ace css-checkbox" value="local" type="radio" id="two" required></td>
            <td>:</td>
            <td><span class="lbl" style="margin-left: 10%;" required>local</span></td> -->
            <td ><label>Select Station</label></td>
             <td>:</td>
        <td ><label>
            <input name="form-field-radio" class="ace css-checkbox" value="out" type="radio" id="out" required>
            <span class="lbl" value="out" required>out</span></label></td>
        <td ><label>
            <input name="form-field-radio" class="ace css-checkbox" value="local" type="radio" id="local" required>
            <span class="lbl"value="local" required>local</span></label></td>
          <td style="width:40%"></td>
            </tr>
        </table>
        <br/>
        <table>
              <tr>
                <td>Select Pincode</td>  
                <td>:</td>
                <td >
                <?php  ?>
                    <input type="text" placeholder="select pincode" id="demo-input-local" name="pins" />
                    <script type="text/javascript">
                    $(document).ready(function() {
                        $("#demo-input-local").tokenInput([
                        <?php $sql = mysql_query("SELECT  pin_id,pincode,area_name FROM pincode_list WHERE state_id='16' GROUP BY area_name");
                         while($P=mysql_fetch_object($sql)){ ?>
                            {id: <?php echo $P->pin_id ?>, name: "<?php echo $P->pincode."-".$P->area_name; ?>"},
                        <?php } ?>
                        ]);
                    });
                    </script>
                </td>
            <!-- 	
            	<td>Pincode</td>
                <td>:</td>
                <td><select class="form-control populate" id="pincode" name="pincode" multiple data-plugin-selectTwo data-rel="chosen" required>
				
				<?php
				$res=mysql_query("SELECT  pin_id,pincode,area_name FROM pincode_list WHERE state_id='16' GROUP BY area_name");
				while($row_res=mysql_fetch_array($res)) {
				$rep_name1=$row_res['pincode'];
				$id=$row_res['pin_id'];
				$area_name=$row_res['area_name'];
				?>
				<option value="<?php echo $id; ?>"><?php echo $rep_name1.'-'.$area_name; ?></option>
				<?php } ?> 
				</select></td> -->
	
                <td><input type="submit" name="submit" id="submit" value="Submit" class="btn btn-primary" ></td>
                <td style="width:20%"></td>
            </tr>
        </table>
    </form>

</div>
<div class="box-content">
<h2>LIST</h2>
<table  class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
<thead>
<tr>

    <th style="text-align:center">SI NO</th>
    <th style="text-align:center">REP Name</th>
    <th style="text-align:center">Pincode</th>
    <th style="text-align:center">Area Name</th>
       <th style="text-align:center">station</th>
    <th style="text-align:center">Amount</th>
    <th style="text-align:center">Action</th>
    
</tr>
</thead>   
<tbody>
    
    <?php   
        $p=1;   

// echo "SELECT * from stationplanforrep where  repid='".$_REQUEST['rep']."' AND station='".$_REQUEST['wage']."' ";
// exit();
                
        $SQL=mysql_query("SELECT * from stationplanforrep ");
        while($Y=mysql_fetch_array($SQL)){          
        
            $pinarea=mysql_query("SELECT * FROM pincode_list WHERE pin_id ='".$Y['pinid']."' ");    
            $pinarea_res=mysql_fetch_array($pinarea);
              $repname2=mysql_query("SELECT * FROM representative WHERE id ='".$Y['repid']."' ");    
            $repname2_res=mysql_fetch_array($repname2);
            ?>
         <tr ><td style="text-align:center"><?php echo $p; ?></td>
            <td style="text-align:center"><?php echo $repname2_res['rep_name'] ?></td>
                <td style="text-align:center"><?php echo $pinarea_res['pincode'] ?></td>        
                <td style="text-align:center"><?php echo $pinarea_res['area_name'] ?></td>  
                <td style="text-align:center"><?php echo $Y['station'] ?></td>  
                <td style="text-align:center"><?php echo $Y['amount'] ?></td>   
                <td style="text-align:center">    <a href="javascript:delMe(<?php echo $Y['id'] ?>)">
                                  <i class="icon-trash icon-red"></i>   
                                            </a></td>       
            
         </tr>

   
    <?php $p++;} ?>
</tbody>
</table>  


</div> <br>

<div>&nbsp;</div>      
<div style="height:auto;" id="consolidated1"></div>  
<div>&nbsp;</div>      
<div style="height:auto;" id="consolidated"></div>      
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
    <script type="text/javascript" src="src/jquery.tokeninput.js"></script>
    <link rel="stylesheet" href="styles/token-input.css" type="text/css" />
</body>
</html>
<script type="text/javascript">

 // $(".css-checkbox").click(function () {
 // 	// alert($(this).attr('id'));
 //             if($('#rep_name').val()=='')
 //                {
 //                    alert("Select Rep Name");
 //                    $(this).removeAttr('checked');
 //                }
 //                else{
 //              $.post("station_reporting.php?station=yuvi&rep="+$('#rep_name').val()+"&wage="+$(this).attr('id')+"",function(data){
 //            // alert(data);
 //            $("#consolidated1").html(data);
 //        }); 
 //          }
 //            });
          $("#submit").click(function(){  
          	// alert($('#demo-input-local').val());
            // alert($("input[name='form-field-radio']:checked").val());
            if($('#rep_name').val()!='' && $("input[name='form-field-radio']:checked").val()!='' && $('#demo-input-local').val()!='')
            {
          	 $.post("station_reporting.php?insertstation=yuvi&rep="+$('#rep_name').val()+"&wage="+$("input[name='form-field-radio']:checked").val()+"&pincode="+$('#demo-input-local').val()+"",function(data){
            alert("Station Plan Added Successfully");
              
          });
            }
            else
            {
                if($('#rep_name').val()=='')
                {
                    alert("Select Rep Name");
                }
                 if($("input[name='form-field-radio']:checked").val()=='')
                {
                     alert("Select Station");
                }
                 if($('#demo-input-local').val()=='')
                {
                     alert("Select Pincode");
                }
            }
              // window.location.reload();
          	});

 
      </script>

      <script type="text/javascript">
                              function delMe(id)
{
if (confirm("Are you sure want to delete..?")) {
    document.location = "station_reporting.php?mode=servicedel&spid="+id;
  }
}
</script>
<?php
}
?>
