<?php
	include("include/connect.php");
	session_start();
	
	$id=$_SESSION['id'];
	//echo $m_id16;die();
	$m_id16=$_SESSION['m_id16'];
	if(!isset($_SESSION['id']))
	{

		echo "<script type='text/javascript'>window.location='index.php?err'</script>"; 
	}
	else
	{
	
require_once("include/select.php");
$ad=new select1();
$res=$ad->view('distributor','where m_id16='.$m_id16,'order by id desc');
$res1=$ad->view('dist_prod','','order by id desc');
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
    <link href="//datatables.net/download/build/nightly/jquery.dataTables.css" rel="stylesheet" type="text/css" />
	<link href='css/jquery.noty.css' rel='stylesheet'>
	<link href='css/noty_theme_default.css' rel='stylesheet'>
	<link href='css/elfinder.min.css' rel='stylesheet'>
	<link href='css/elfinder.theme.css' rel='stylesheet'>
	<link href='css/jquery.iphone.toggle.css' rel='stylesheet'>
	<link href='css/opa-icons.css' rel='stylesheet'>
	<link href='css/uploadify.css' rel='stylesheet'>
	<link rel="shortcut icon" href="img/favicon1.ico">
    <style type="text/css">
 .tr_name {
  color: #337ab7;
 } 
  .tr_dist {
  color: #337ab7;
  background-color: #f1f1f1;
 } 
</style>
    <script type="text/javascript">
function valid()
{
var x=document.getElementById("dist_id").value;
if(x === "null" || x === "")
{
alert("Please Enter Distributor Name");
return false; 
}
return true;
}
</script>

    
</head>

<body>
	<?php include("include/header.php"); ?>
		<div class="container-fluid">
		<div class="row-fluid">
        <?php include("include/menu.php"); ?>
			
<div id="content" class="span10">

<div class="row-fluid sortable">
<div class="box span12">
<div class="box-header well" data-original-title>
<h2><i class="icon-edit"></i>MONTHWISE CONSOLIDATED REPORT</h2>
<div class="box-icon">
</div>
</div>
<div class="box-content">

  <table id="example" class="display" width="100%">
      </table>



<?php 
$ad =array();
$sal = mysql_query("SELECT distinct pincode as pincode,`customer_name`,`distributor_id`,`id`  FROM `distributor_customer` where `pincode` !='.' and `pincode` !='0' and `pincode` !=' ' and `pincode` !='' ORDER BY `pincode`");
while($sal_row = mysql_fetch_array($sal))
{

$gn = mysql_query("select dis_name from distributor where dis_id ='".$sal_row['distributor_id']."' ");
$gn_row = mysql_fetch_array($gn);
$pincode = $sal_row['pincode']; 
$encoding = mb_detect_encoding($pincode, 'utf-8, iso-8859-1, ascii', true);
    if (strcasecmp($encoding, 'UTF-8') !== 0) {
      $pincode = iconv($encoding, 'utf-8', $pincode);
    }

$ad[] = array($pincode,'',$sal_row['customer_name'],'',$gn_row['dis_name'],$sal_row['id']);


}
?>

 <div id="myModal-mini" class="modal fade myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal"> <i class='fa fa-times'></i> </button>
              <button class="close modalMinimize"> <i class='fa fa-minus'></i> </button>
              <p class="h2 text-center"><strong>Planning</strong></p>
            </div>
            <div class="modal-body">
            <div class="control-group"><label class="control-label" for="typeahead">Customer Name<span style="color:#FF0000;">*</span> </label>
<div class="controls">
    <input class="input-xlarge focused" type="text" name="doc_name" id="doc_name" required="" value="">        
</div>
</div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Close</button>
            </div>
          </div>
    </div>
</div>

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
    <script src="//datatables.net/download/build/nightly/jquery.dataTables.js"></script>
    <script src="//cdn.rawgit.com/ashl1/datatables-rowsgroup/v1.0.0/dataTables.rowsGroup.js"></script>
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
    $(document).ready( function () {


 var data = <?php echo json_encode($ad); ?>


 // var data = [
 //    ['1', 'David', 'Maths', '80'],
 //    ['1', 'David', 'Physics', '90'],
 //    ['1', 'David', 'Computers', '70'],
 //    ['2', 'Alex', 'Maths', '80'],
 //    ['2', 'Alex', 'Physics', '70'],
 //    ['2', 'Alex', 'Computers', '90'],
 //  ];

  var table = $('#example').DataTable({
    columns: [
            {
            name: 'Pincode',
            title: 'Pincode',
            width:'20%',
            class:'tr_name',
        },
        {
           title: '',
           targets: -1,
           data: null,
           defaultContent: "<input type='checkbox' name='merge_dist' class='form-control merge_dist'> "

        },
        {
            title: 'Customer Name',
        },
        {
            title: '',
            targets: -1,
            data: null,
            defaultContent: "<input type='radio' name='select_dist' class='form-control select_dist' data-toggle='modal' data-target='#myModal-mini' disabled> "            
        },        
        {
            title: 'Distributor',
            class:'tr_dist',
        },
        {
         title : 'Mapping',
         targets: -1,
         data: null,
         defaultContent: "<input type='textbox' name='mapp_dist' class='form-control mapp_dist'>"    
        },
    ],
    data: data,
    rowsGroup: [// Always the array (!) of the column-selectors in specified order to which rows groupping is applied
                // (column-selector could be any of specified in https://datatables.net/reference/type/column-selector)
        'Pincode:name'
    ],
    pageLength: '100',
    });

    $('#example tbody').on( 'click', '.merge_dist', function () {
        var data = table.row( $(this).parents('tr') ).data();
        //table.row( $(this).parents('tr') )
        alert( data[0] +"'s ID is: "+ data[ 5 ] );

        $(this).closest('tr').find('.select_dist').attr('disabled',false);

    } );

} );


</script>




</body>
</html>
<?php
}
