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
// $fun = new select1;
// $res=$fun->view('distributor','where m_id16='.$m_id16,'order by id desc');

function calculateDistance($latitude1, $longitude1, $latitude2, $longitude2) {
    $theta = $longitude1 - $longitude2;
    $miles = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
    $miles = acos($miles);
    $miles = rad2deg($miles);
    $miles = $miles * 60 * 1.1515;
    return round($miles * 1.609344,2);
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
    <link rel="stylesheet" href="css/leaflet.css" />
       <link rel="stylesheet" href="../dist/leaflet-routing-machine.css" />
  <link href="http://fortawesome.github.io/Font-Awesome/assets/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="css/leaflet.awesome-markers.css">


      <!-- <link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.0-rc.3/dist/leaflet.css" /> -->
    <!-- <link rel="stylesheet" href="../dist/leaflet-routing-machine.css" /> -->
    <!-- <link href="http://fortawesome.github.io/Font-Awesome/assets/font-awesome/css/font-awesome.css" rel="stylesheet"> -->
    <!-- <link rel="stylesheet" href="leaflet.awesome-markers.css"> -->
    <link rel="stylesheet" href="css/index.css" />
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

<style type="text/css">
.leaflet-control{

	display: none;
}

</style>

<div id="content" class="span10">
<div class="row-fluid sortable">		
<div class="box span12">
<div class="box-header well" data-original-title>
<?php if($_REQUEST["mode"]=="mapview"){ 
	$sql1=mysql_query("SELECT latandlong,travel_time FROM busdayrecord where time='".$_REQUEST["rep_name"]."' and date='".$_REQUEST["from_date"]."'");
	$row1=mysql_fetch_array($sql1);
	$location=explode(":", $row1['latandlong']);
	$j=1;
	$total=0;
	for ($i=0; $i<count($location)-1; $i++) { 
		if($location[$j]!=''){
    		$loc=explode(",", $location[$i]);
    		$loc1=explode(",", $location[$j]);
    		if(calculateDistance($loc[0],$loc[1],$loc1[0],$loc1[1])>0){
    			$total=$total+calculateDistance($loc[0],$loc[1],$loc1[0],$loc1[1]);
    		}
    		$j++;
		}
	}
	echo "<button class='btn btn-primary' style='float:right;'>KM : ".$total."</b></button>";
?>
<h2><i class="icon-user"></i>REP ONE DAY Report</h2>

<div class="box-icon">
</div>
</div>

<div class="box-content">

<div>
    <form name="thisForm" action="?mode=mapview" method="post">

        <table style="width:100%;">
            <tr>
            	<?php if($_SESSION['AUTH']=='3'){ ?>
            	<td>Representative</td>
                <td>:</td>
                <td><select id="rep_name" name="rep_name" data-rel="chosen">
				<option value="">--Select--</option>
				<?php
				$res=mysql_query("SELECT * FROM representative");
				while($row_res=mysql_fetch_array($res)) {
				$rep_name1=$row_res['rep_name'];
				$id=$row_res['id'];
				?>
				<option value="<?php echo $id; ?>"><?php echo $rep_name1; ?></option>
				<?php } ?> 
				</select><script>document.thisForm.rep_name.value="<?php echo $_REQUEST["rep_name"]; ?>"</script></td>
				<?php } ?>
                <td><Label>Date</label></td>
                <td>:</td>
                <td><input type="text" name="from_date" id="from_date" value="<?php echo @$_REQUEST["from_date"]; ?>" readonly/></td>
                
                <td><input type="submit" name="submit" value="REPORT" class="btn btn-primary" ></td>
                <td></td>
            </tr>
        </table>

		<div id="map" style="width:auto; height: 450px;"></div>
		<?php 
        //echo "SELECT latandlong,travel_time FROM busdayrecord where time='".$_REQUEST["rep_name"]."' and date='".$_REQUEST["from_date"]."'";
		
		 $sql = mysql_query("SELECT latandlong,travel_time FROM busdayrecord where time='".$_REQUEST["rep_name"]."' and date='".$_REQUEST["from_date"]."'") or die(mysql_error());
$result = mysql_fetch_array($sql);
$srt=rtrim($result['latandlong'], ":");
$srt1=rtrim($result['travel_time'], ":");
$rty=explode(":",$srt);
$rty1=explode(",",$srt1);
// $last = count(array_unique($rty));
	$last = count($rty);	
		?>
		
		<?php } ?>
        <script src="js/leaflet.js"></script>

     <!-- // <script src="../dist/leaflet-routing-machine.js"></script> -->
     <!-- // <script src="https://www.mapquestapi.com/sdk/leaflet/v2.s/mq-map.js?key=Kmjtd%7Cluua2qu7n9%2C7a%3Do5-lzbgq"></script> -->
<!-- <script src="https://www.mapquestapi.com/sdk/leaflet/v2.s/mq-routing.js?key=Kmjtd%7Cluua2qu7n9%2C7a%3Do5-lzbgq"></script> -->
 <script src="js/Control.Geocoder.js"></script>
  <script src="js/leaflet.awesome-markers.js"></script>

   <!-- // <script src="https://unpkg.com/leaflet@1.0.0-rc.3/dist/leaflet.js"></script> -->
    <script src="js/leaflet-routing-machine.js"></script>
    <!-- // <script src="Control.Geocoder.js"></script> -->
    <!-- // <script src="leaflet.awesome-markers.js"></script> -->
        <script>


 var map = L.map('map').setView([11.1271,78.6569], 6);

    L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        //  maxZoom:12,
            attribution: '&copy; mic&amp;Mac Solutions Private Limited',
}).addTo(map);



// var message = ["10:12","10:18","11:05","12:15","01:20"];
var message = [<?php

for($j=0;$j<count($rty1, COUNT_RECURSIVE);$j++)
{

if(count($rty1, COUNT_RECURSIVE)-1==$j)
{
echo '"'.$rty1[$j].'"';
}
else
{
echo '"'.$rty1[$j].'"'.',';
}

}
    ?>
];


    var geocoder = L.Control.Geocoder.nominatim(),
    routeControl = L.Routing.control({
     plan: L.Routing.plan(waypoints, {
                createMarker: function(i, wp) {
                    if(waypoints[0]) {
//return L.marker(wp.latLng, {draggable: false,icon: L.AwesomeMarkers.icon({icon: 'user', prefix: 'fa', markerColor: 'green'})}).bindPopup(message[i]).openPopup().addTo(map);

// alert(i);

    if(i==0)
            {
        return L.marker(wp.latLng, {draggable: false,icon: L.AwesomeMarkers.icon({icon: 'user', prefix: 'fa', markerColor: 'green'})}).bindPopup(message[i]).openPopup().addTo(map);
            }
        else if(i== <?php echo $last-1; ?>){
      return L.marker(wp.latLng, {draggable: false,icon: L.AwesomeMarkers.icon({icon: 'user', prefix: 'fa', markerColor: 'red'})}).bindPopup(message[i]).openPopup().addTo(map);
        } else {        
       return L.marker(wp.latLng, {draggable: false,icon: L.AwesomeMarkers.icon({icon: 'user', prefix: 'fa', markerColor: 'blue'})}).bindPopup(message[i]).openPopup().addTo(map);
    }





                    }

                },
    // geocoder: geocoder,
  routeWhileDragging: false,
    reverseWaypoints: false,
    showAlternatives: false,
  }),

routeLine: function(r) {
            var line = L.Routing.line(r, {  styles: [{color: '#19afc3', opacity: 0.8, weight: 2}],
                                                addWaypoints: false
                                             });
           // line.on('linetouched', function(e) { alert("!"); });
            return line;
          }
}).addTo(map),
    waypoints = [

// L.latLng(13.0066681,77.579091),
// L.latLng(12.9949342,77.5720168),
// L.latLng(12.9951065,77.5719272),
// L.latLng(12.9950716,77.5719001),
// L.latLng(12.9955065,77.5719272)
<?php
for($i=0;$i<count($rty, COUNT_RECURSIVE);$i++)
{

if(count($rty, COUNT_RECURSIVE)-1==$i)
{
?>
 L.latLng(<?=$rty[$i]?>)<?php echo (count($rty, COUNT_RECURSIVE)==$i ? '' : ',' ); ?>
 <?php
}
else
{
?>
 L.latLng(<?=$rty[$i]?>)<?php echo (count($rty, COUNT_RECURSIVE)==$i ? '' : ',' ); ?>
<?php  } } ?>

    ];

routeControl.setWaypoints(waypoints);


               
    </script>
    </form>
</div><br>  
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
</body>
</html>
<?php
}
?>
