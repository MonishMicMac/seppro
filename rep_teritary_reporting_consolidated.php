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

require_once("include/select.php");
$ad=new select1();
$res2=mysql_query("SELECT DISTINCT(dist_id) FROM pincode_list")or die(mysql_error());
$abc=mysql_query("SELECT * FROM tbl_customer_master order by id desc limit 1")or die(mysql_error());
$row_abc=mysql_fetch_array($abc);
$co_abc=mysql_num_rows($abc);
if($co_abc > 0)
{
    $cust_id=$row_abc['id']+1;
}
else 
{
    $cust_id="10001";
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

.kv-file-upload{

display:none;

}

.kv-file-remove{

display:none;

}

.kv-upload-progress
{

display:none;

}

.active{"background-color":#F28C02; color:#FFFFFF; }

     </style>  
	<link type="text/css" href="fileinput.css" rel="stylesheet" />
<link href="font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css" />
	<link href="css/bootstrap-responsive.css" rel="stylesheet">
	<link href="css/charisma-app.css" rel="stylesheet">
	<link href="css/jquery-ui-1.8.21.custom.css" rel="stylesheet">
	<link href='css/fullcalendar.css' rel='stylesheet'>
	<link href='css/fullcalendar.print.css' rel='stylesheet'  media='print'>
	<link href='css/chosen.css' rel='stylesheet'>
	<link href='css/colorbox.css' rel='stylesheet'>
	<link href='css/jquery.cleditor.css' rel='stylesheet'>
	<link href='css/elfinder.min.css' rel='stylesheet'>
	<link href='css/elfinder.theme.css' rel='stylesheet'>
	<link href='css/jquery.iphone.toggle.css' rel='stylesheet'>
	<link href='css/opa-icons.css' rel='stylesheet'>
	<link rel="shortcut icon" href="img/favicon1.ico">  
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

<body onLoad="initialize();">
<?php include("include/header.php"); ?>
<div class="container-fluid">
<div class="row-fluid">
<?php include("include/menu.php"); ?>
			
			
<div id="content" class="span10">
<div class="row-fluid sortable">
<div class="box span12">
<div class="box-header well" data-original-title>
<h2><i class="icon-edit"></i>REPRESENTATIVE TERITARYWISE REPORT</h2>
<div class="box-icon">
</div>
</div>   

<div class="box-content" style="background:#F28C02;padding:14px 8px 10px 8px;color:#FFFFFF;box-shadow: 4px 4px 5px #888888;">
<form class="form-horizontal" action="" enctype="multipart/form-data" method="post"  name="frm" id="frm">
<table style="width:70%; vertical-align:middle" align="center">
    <tr>
        <td><Label>Rep</label></td>
        <td>:</td>
        <td>
        	<select name="rep" id="rep" required>
            	<option value="">-- Select Rep --</option>
                <?php $SQL=mysql_query("SELECT rep_name,id FROM representative WHERE status=0"); while($R=mysql_fetch_object($SQL)){ ?>
                	<option value="<?=$R->id; ?>"><?=$R->rep_name; ?></option>
                <?php } ?>
            </select>
            <script>document.getElementById("rep").value="<?=@$_REQUEST["rep"]; ?>";</script>
        </td>
        <td><Label>From</label></td>
        <td>:</td>
        <td>
        	<input type="text" name="from_date" id='txtDate' value="<?=@$_REQUEST["from_date"]; ?>">
        </td> 
        <td><Label>To</label></td>
        <td>:</td>
        <td>
        	<input type="text" name="to_date" id='txtDate1' value="<?=@$_REQUEST["to_date"]; ?>">
        </td>         
        <td><input type="submit" name="submit" value="REPORT" class="btn" style="font-family:Bookman Old Style;color:#FFFFFF;background:#666666" ></td>
    </tr>    
</table>
</div>
<div class="box-content">
<?php
	if(@$_REQUEST["submit"]=="REPORT"){
?>
	<a href="rep_teritary_reporting_consolidated_excel.php?from_date=<?php echo @$_REQUEST["from_date"]; ?>&to_date=<?php echo @$_REQUEST["to_date"]; ?>&rep=<?php echo @$_REQUEST["rep"]; ?> " target="_blank"><img src="img/excel.png" height="20" width="20" alt="Export Excel"></a>
<?php	
	}
?>

<div>&nbsp;</div>

<?php
	if(@$_REQUEST["submit"]=="REPORT"){
		$_REQUEST["from_date"]=$_REQUEST["from_date"]."/01";
		$_REQUEST["to_date"]=$_REQUEST["to_date"]."/28";
		$MDifference=mysql_query("SELECT TIMESTAMPDIFF(MONTH, '".$_REQUEST["from_date"]."', '".$_REQUEST["to_date"]."') AS MONTH");$MDiff=mysql_fetch_object($MDifference);
		$Monthwise=mysql_query("select DATE_FORMAT(m1, '%Y/%m/%d') AS S, LAST_DAY(DATE_ADD(DATE_FORMAT(m1, '%Y/%m/%d'), INTERVAL 0 MONTH)) S1 from (select 
('".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' - INTERVAL DAYOFMONTH('".date("Y-m-d",strtotime($_REQUEST["from_date"]))."')-1 DAY) +INTERVAL m MONTH as m1 from (select @rownum:=@rownum+1 as m from (select 1 union select 2 union select 3 union select 4) t1, (select 1 union select 2 union select 3 union select 4) t2, (select 1 union select 2 union select 3 union select 4) t3, (select 1 union select 2 union select 3 union select 4) t4, (select @rownum:=-1) t0 ) d1 ) d2  where m1<='".date("Y-m-d",strtotime($_REQUEST["to_date"]))."' order by m1");
?>
	<table class="table table-bordered">
    <thead>
    	<tr><th style="background:#FFBF00; vertical-align:middle">All HQ</th>
<?php		
		 while($M=mysql_fetch_object($Monthwise)){
?>
		<th style="background:#FAAC58; vertical-align:middle"><?=date("M y",strtotime($M->S)); ?></th>
       <?php } ?> 
       <th style="background:#FFBF00; vertical-align:middle">Total</th>
       <th style="background:#FFBF00; vertical-align:middle">Average</th>
       </tr>
       </thead>
       <tbody>
       		<tr>
                <td>Target</td>
                <?php $Monthwise1=mysql_query("select DATE_FORMAT(m1, '%Y/%m/%d') AS S, LAST_DAY(DATE_ADD(DATE_FORMAT(m1, '%Y/%m/%d'), INTERVAL 0 MONTH)) S1 from (select 
('".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' - INTERVAL DAYOFMONTH('".date("Y-m-d",strtotime($_REQUEST["from_date"]))."')-1 DAY) +INTERVAL m MONTH as m1 from (select @rownum:=@rownum+1 as m from (select 1 union select 2 union select 3 union select 4) t1, (select 1 union select 2 union select 3 union select 4) t2, (select 1 union select 2 union select 3 union select 4) t3, (select 1 union select 2 union select 3 union select 4) t4, (select @rownum:=-1) t0 ) d1 ) d2  where m1<='".date("Y-m-d",strtotime($_REQUEST["to_date"]))."' order by m1"); while($T=mysql_fetch_object($Monthwise1)){ ?>
                	<td>0</td>
					<?php } ?>
                    <td>0</td>
                    <td>0</td>
            </tr>
            <tr>
            	<td>Primary Sales</td>
                 <?php $Monthwise2=mysql_query("select DATE_FORMAT(m1, '%Y/%m/%d') AS S, LAST_DAY(DATE_ADD(DATE_FORMAT(m1, '%Y/%m/%d'), INTERVAL 0 MONTH)) S1 from (select 
('".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' - INTERVAL DAYOFMONTH('".date("Y-m-d",strtotime($_REQUEST["from_date"]))."')-1 DAY) +INTERVAL m MONTH as m1 from (select @rownum:=@rownum+1 as m from (select 1 union select 2 union select 3 union select 4) t1, (select 1 union select 2 union select 3 union select 4) t2, (select 1 union select 2 union select 3 union select 4) t3, (select 1 union select 2 union select 3 union select 4) t4, (select @rownum:=-1) t0 ) d1 ) d2  where m1<='".date("Y-m-d",strtotime($_REQUEST["to_date"]))."' order by m1"); while($P=mysql_fetch_object($Monthwise2)){ ?>
                	<td>0</td>
					<?php } ?>
                    <td>0</td>
                    <td>0</td>
            </tr>
            <tr>
            	<td>Secondary Sales</td>
                <?php
				$Monthwise3=mysql_query("select DATE_FORMAT(m1, '%Y/%m/%d') AS S, LAST_DAY(DATE_ADD(DATE_FORMAT(m1, '%Y/%m/%d'), INTERVAL 0 MONTH)) S1 from (select 
('".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' - INTERVAL DAYOFMONTH('".date("Y-m-d",strtotime($_REQUEST["from_date"]))."')-1 DAY) +INTERVAL m MONTH as m1 from (select @rownum:=@rownum+1 as m from (select 1 union select 2 union select 3 union select 4) t1, (select 1 union select 2 union select 3 union select 4) t2, (select 1 union select 2 union select 3 union select 4) t3, (select 1 union select 2 union select 3 union select 4) t4, (select @rownum:=-1) t0 ) d1 ) d2  where m1<='".date("Y-m-d",strtotime($_REQUEST["to_date"]))."' order by m1"); while($PTS=mysql_fetch_object($Monthwise3)){
				$SS=mysql_query("SELECT IFNULL(ROUND(SUM(quantity*pts),0),0) PTS FROM areawise_temp,product WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($PTS->S))."' AND '".date("Y/m/d",strtotime($PTS->S1))."') AND rep_id='".$_REQUEST["rep"]."' AND our_cust_id!='' AND our_product_id!='' AND our_product_id=product.id"); while($PTSValue=mysql_fetch_object($SS)){ $SSPTS+=$PTSValue->PTS;
				?>
                	<td><?php echo $PTSValue->PTS; ?></td>
					<?php }} ?>
                    <td><?=round($SSPTS); ?></td>
                    <td><?=round($SSPTS/$MDiff->MONTH,0); ?></td>
            </tr>
            <tr>
            	<td>Free</td>
                 <?php
				$Monthwise4=mysql_query("select DATE_FORMAT(m1, '%Y/%m/%d') AS S, LAST_DAY(DATE_ADD(DATE_FORMAT(m1, '%Y/%m/%d'), INTERVAL 0 MONTH)) S1 from (select 
('".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' - INTERVAL DAYOFMONTH('".date("Y-m-d",strtotime($_REQUEST["from_date"]))."')-1 DAY) +INTERVAL m MONTH as m1 from (select @rownum:=@rownum+1 as m from (select 1 union select 2 union select 3 union select 4) t1, (select 1 union select 2 union select 3 union select 4) t2, (select 1 union select 2 union select 3 union select 4) t3, (select 1 union select 2 union select 3 union select 4) t4, (select @rownum:=-1) t0 ) d1 ) d2  where m1<='".date("Y-m-d",strtotime($_REQUEST["to_date"]))."' order by m1"); while($PTS1=mysql_fetch_object($Monthwise4)){
				$SS1=mysql_query("SELECT IFNULL(ROUND(SUM(free_quantity),0),0) F FROM areawise_temp,product WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($PTS1->S))."' AND '".date("Y/m/d",strtotime($PTS1->S1))."') AND rep_id='".$_REQUEST["rep"]."' AND our_cust_id!='' AND our_product_id!='' AND our_product_id=product.id"); while($FValue=mysql_fetch_object($SS1)){ $SSF+=$FValue->F;
				?>
                	<td><?=$FValue->F; ?></td>
					<?php }} ?>
                    <td><?=round($SSF);?></td>
                    <td><?=round($SSF/$MDiff->MONTH,0); ?></td>
            </tr>
            <tr>
            	<td>Sale Return</td>
                <?php
				$Monthwise5=mysql_query("select DATE_FORMAT(m1, '%Y/%m/%d') AS S, LAST_DAY(DATE_ADD(DATE_FORMAT(m1, '%Y/%m/%d'), INTERVAL 0 MONTH)) S1 from (select 
('".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' - INTERVAL DAYOFMONTH('".date("Y-m-d",strtotime($_REQUEST["from_date"]))."')-1 DAY) +INTERVAL m MONTH as m1 from (select @rownum:=@rownum+1 as m from (select 1 union select 2 union select 3 union select 4) t1, (select 1 union select 2 union select 3 union select 4) t2, (select 1 union select 2 union select 3 union select 4) t3, (select 1 union select 2 union select 3 union select 4) t4, (select @rownum:=-1) t0 ) d1 ) d2  where m1<='".date("Y-m-d",strtotime($_REQUEST["to_date"]))."' order by m1"); while($PTS2=mysql_fetch_object($Monthwise5)){
				$SS2=mysql_query("SELECT IFNULL(ROUND(SUM(replace_quantity),0),0) F FROM areawise_temp,product WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($PTS2->S))."' AND '".date("Y/m/d",strtotime($PTS2->S1))."') AND rep_id='".$_REQUEST["rep"]."' AND our_cust_id!='' AND our_product_id!='' AND our_product_id=product.id"); while($RValue=mysql_fetch_object($SS2)){
				$SSR+=$RValue->F;
				?>
                	<td><?=$RValue->F; ?></td>
					<?php }} ?>
                    <td><?=round($SSR);?></td>
                    <td><?=round($SSR/$MDiff->MONTH,0); ?></td>                
            </tr>
            <tr>
            	<td>Net Sales</td>
                <?php
				$Monthwise6=mysql_query("select DATE_FORMAT(m1, '%Y/%m/%d') AS S, LAST_DAY(DATE_ADD(DATE_FORMAT(m1, '%Y/%m/%d'), INTERVAL 0 MONTH)) S1 from (select 
('".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' - INTERVAL DAYOFMONTH('".date("Y-m-d",strtotime($_REQUEST["from_date"]))."')-1 DAY) +INTERVAL m MONTH as m1 from (select @rownum:=@rownum+1 as m from (select 1 union select 2 union select 3 union select 4) t1, (select 1 union select 2 union select 3 union select 4) t2, (select 1 union select 2 union select 3 union select 4) t3, (select 1 union select 2 union select 3 union select 4) t4, (select @rownum:=-1) t0 ) d1 ) d2  where m1<='".date("Y-m-d",strtotime($_REQUEST["to_date"]))."' order by m1"); while($PTS3=mysql_fetch_object($Monthwise6)){
				$SS3=mysql_query("SELECT IFNULL(ROUND(SUM(quantity*pts),0),0) - IFNULL(ROUND(SUM(free_quantity),0),0) NETVALUE FROM areawise_temp,product WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($PTS3->S))."' AND '".date("Y/m/d",strtotime($PTS3->S1))."') AND rep_id='".$_REQUEST["rep"]."' AND our_cust_id!='' AND our_product_id!='' AND our_product_id=product.id"); while($NetValue=mysql_fetch_object($SS3)){ $SS+=$NetValue->NETVALUE;
				?>
                	<td><?=$NetValue->NETVALUE; ?></td>
					<?php }} ?>
                    <td><?=round($SS);?></td>
                    <td><?=round($SS/$MDiff->MONTH,0); ?></td> 
            </tr>
            <tr>
            	<td>Sec value (Rs.) Growth (%)</td>
                <?php
				$Monthwise7=mysql_query("select DATE_FORMAT(m1, '%Y/%m/%d') AS S, LAST_DAY(DATE_ADD(DATE_FORMAT(m1, '%Y/%m/%d'), INTERVAL 0 MONTH)) S1 from (select 
('".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' - INTERVAL DAYOFMONTH('".date("Y-m-d",strtotime($_REQUEST["from_date"]))."')-1 DAY) +INTERVAL m MONTH as m1 from (select @rownum:=@rownum+1 as m from (select 1 union select 2 union select 3 union select 4) t1, (select 1 union select 2 union select 3 union select 4) t2, (select 1 union select 2 union select 3 union select 4) t3, (select 1 union select 2 union select 3 union select 4) t4, (select @rownum:=-1) t0 ) d1 ) d2  where m1<='".date("Y-m-d",strtotime($_REQUEST["to_date"]))."' order by m1"); while($PTS4=mysql_fetch_object($Monthwise7)){
				// Prev Month Sale
				$Prev=mysql_query("select date_add(LAST_DAY(date_add('".date("Y/m/d",strtotime($PTS4->S))."',interval -2 month)), interval 1 day) FirstDay, LAST_DAY(date_add('".date("Y/m/d",strtotime($PTS4->S))."',interval -1 month)) LastDay");
				$PSale=mysql_fetch_object($Prev);

				$PS=mysql_query("SELECT IFNULL(ROUND(SUM(quantity*pts),0),0) PTS  FROM areawise_temp,product WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($PSale->FirstDay))."' AND '".date("Y/m/d",strtotime($PSale->LastDay))."') AND rep_id='".$_REQUEST["rep"]."' AND our_cust_id!='' AND our_product_id!='' AND our_product_id=product.id");
				$PPTS=mysql_fetch_object($PS);
				// Current Month Sale
				$CSale=mysql_query("SELECT IFNULL(ROUND(SUM(quantity*pts),0),0) PTS  FROM areawise_temp,product WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($PTS4->S))."' AND '".date("Y/m/d",strtotime($PTS4->S1))."') AND rep_id='".$_REQUEST["rep"]."' AND our_cust_id!='' AND our_product_id!='' AND our_product_id=product.id");
				$CPTS=mysql_fetch_object($CSale);			
				
				?>
                	<td><?=round(((($CPTS->PTS-$PPTS->PTS)/$PPTS->PTS)*100))."%"; ?></td>
					<?php } ?>
                    <td>0</td>
                    <td>0</td>
            </tr>
            <tr>
            	<td>No of Growth Products</td>
                <?php
				$Monthwise8=mysql_query("select DATE_FORMAT(m1, '%Y/%m/%d') AS S, LAST_DAY(DATE_ADD(DATE_FORMAT(m1, '%Y/%m/%d'), INTERVAL 0 MONTH)) S1 from (select 
('".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' - INTERVAL DAYOFMONTH('".date("Y-m-d",strtotime($_REQUEST["from_date"]))."')-1 DAY) +INTERVAL m MONTH as m1 from (select @rownum:=@rownum+1 as m from (select 1 union select 2 union select 3 union select 4) t1, (select 1 union select 2 union select 3 union select 4) t2, (select 1 union select 2 union select 3 union select 4) t3, (select 1 union select 2 union select 3 union select 4) t4, (select @rownum:=-1) t0 ) d1 ) d2  where m1<='".date("Y-m-d",strtotime($_REQUEST["to_date"]))."' order by m1"); while($PTS5=mysql_fetch_object($Monthwise8)){
				// Prev Month Sale
				$Prev1=mysql_query("select date_add(LAST_DAY(date_add('".date("Y/m/d",strtotime($PTS5->S))."',interval -2 month)), interval 1 day) FirstDay, LAST_DAY(date_add('".date("Y/m/d",strtotime($PTS5->S))."',interval -1 month)) LastDay");
				$PSale1=mysql_fetch_object($Prev1);

				$PS1=mysql_query("SELECT IFNULL(COUNT(quantity),0) Q  FROM areawise_temp,product WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($PSale1->FirstDay))."' AND '".date("Y/m/d",strtotime($PSale1->LastDay))."') AND rep_id='".$_REQUEST["rep"]."' AND our_cust_id!='' AND our_product_id!='' AND our_product_id=product.id GROUP BY our_product_id");
				$PPTS1=mysql_fetch_object($PS1);
				// Current Month Sale
				$CSale1=mysql_query("SELECT IFNULL(COUNT(quantity),0) Q  FROM areawise_temp,product WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($PTS5->S))."' AND '".date("Y/m/d",strtotime($PTS5->S1))."') AND rep_id='".$_REQUEST["rep"]."' AND our_cust_id!='' AND our_product_id!='' AND our_product_id=product.id GROUP BY our_product_id");
				$CPTS1=mysql_fetch_object($CSale1);			
				
				?>
                	<td><?php if($PPTS1->Q>$CPTS1->Q){ echo $PPTS1->Q-$CPTS1->Q;}else{ echo "0";} ?></td>
					<?php } ?>
                    <td>0</td>
                    <td>0</td>
            </tr>
            <tr>
            	<td>No of Degrowth Products</td>
                 <?php
				$Monthwise9=mysql_query("select DATE_FORMAT(m1, '%Y/%m/%d') AS S, LAST_DAY(DATE_ADD(DATE_FORMAT(m1, '%Y/%m/%d'), INTERVAL 0 MONTH)) S1 from (select 
('".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' - INTERVAL DAYOFMONTH('".date("Y-m-d",strtotime($_REQUEST["from_date"]))."')-1 DAY) +INTERVAL m MONTH as m1 from (select @rownum:=@rownum+1 as m from (select 1 union select 2 union select 3 union select 4) t1, (select 1 union select 2 union select 3 union select 4) t2, (select 1 union select 2 union select 3 union select 4) t3, (select 1 union select 2 union select 3 union select 4) t4, (select @rownum:=-1) t0 ) d1 ) d2  where m1<='".date("Y-m-d",strtotime($_REQUEST["to_date"]))."' order by m1"); while($PTS5=mysql_fetch_object($Monthwise9)){
				// Prev Month Sale
				$Prev1=mysql_query("select date_add(LAST_DAY(date_add('".date("Y/m/d",strtotime($PTS5->S))."',interval -2 month)), interval 1 day) FirstDay, LAST_DAY(date_add('".date("Y/m/d",strtotime($PTS5->S))."',interval -1 month)) LastDay");
				$PSale1=mysql_fetch_object($Prev1);

				$PS1=mysql_query("SELECT IFNULL(COUNT(quantity),0) Q  FROM areawise_temp,product WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($PSale1->FirstDay))."' AND '".date("Y/m/d",strtotime($PSale1->LastDay))."') AND rep_id='".$_REQUEST["rep"]."' AND our_cust_id!='' AND our_product_id!='' AND our_product_id=product.id GROUP BY our_product_id");
				$PPTS1=mysql_fetch_object($PS1);
				// Current Month Sale
				$CSale1=mysql_query("SELECT IFNULL(COUNT(quantity),0) Q  FROM areawise_temp,product WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($PTS5->S))."' AND '".date("Y/m/d",strtotime($PTS5->S1))."') AND rep_id='".$_REQUEST["rep"]."' AND our_cust_id!='' AND our_product_id!='' AND our_product_id=product.id GROUP BY our_product_id");
				$CPTS1=mysql_fetch_object($CSale1);			
				
				?>
                	<td><?php if($PPTS1->Q<$CPTS1->Q){ echo -($PPTS1->Q-$CPTS1->Q);}else{ echo "0";} ?></td>
					<?php } ?>
                    <td>0</td>
                    <td>0</td>
            </tr>
            <tr>
            	<td>No of Products under Nil Sales</td>
                <?php
				$Monthwise11=mysql_query("select DATE_FORMAT(m1, '%Y/%m/%d') AS S, LAST_DAY(DATE_ADD(DATE_FORMAT(m1, '%Y/%m/%d'), INTERVAL 0 MONTH)) S1 from (select 
('".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' - INTERVAL DAYOFMONTH('".date("Y-m-d",strtotime($_REQUEST["from_date"]))."')-1 DAY) +INTERVAL m MONTH as m1 from (select @rownum:=@rownum+1 as m from (select 1 union select 2 union select 3 union select 4) t1, (select 1 union select 2 union select 3 union select 4) t2, (select 1 union select 2 union select 3 union select 4) t3, (select 1 union select 2 union select 3 union select 4) t4, (select @rownum:=-1) t0 ) d1 ) d2  where m1<='".date("Y-m-d",strtotime($_REQUEST["to_date"]))."' order by m1"); while($PTS11=mysql_fetch_object($Monthwise11)){
				$SS3=mysql_query("SELECT COUNT(id) AS NILPROD FROM product WHERE id NOT IN (SELECT our_product_id FROM areawise_temp WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($PTS11->S))."' AND '".date("Y/m/d",strtotime($PTS11->S1))."') AND rep_id='".$_REQUEST["rep"]."' AND our_cust_id!='' AND our_product_id!='' GROUP BY our_product_id)"); while($NetValue=mysql_fetch_object($SS3)){
				?>
                	<td><?=$NetValue->NILPROD; ?></td>
					<?php }} ?>
                    <td>0</td>
                    <td>0</td>
            </tr>
            <tr>
            	<td>Target Vs Achievement (%)</td>
                <?php $Monthwise1=mysql_query("select DATE_FORMAT(m1, '%Y/%m/%d') AS S, LAST_DAY(DATE_ADD(DATE_FORMAT(m1, '%Y/%m/%d'), INTERVAL 0 MONTH)) S1 from (select 
('".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' - INTERVAL DAYOFMONTH('".date("Y-m-d",strtotime($_REQUEST["from_date"]))."')-1 DAY) +INTERVAL m MONTH as m1 from (select @rownum:=@rownum+1 as m from (select 1 union select 2 union select 3 union select 4) t1, (select 1 union select 2 union select 3 union select 4) t2, (select 1 union select 2 union select 3 union select 4) t3, (select 1 union select 2 union select 3 union select 4) t4, (select @rownum:=-1) t0 ) d1 ) d2  where m1<='".date("Y-m-d",strtotime($_REQUEST["to_date"]))."' order by m1"); while($T=mysql_fetch_object($Monthwise1)){ ?>
                	<td>0</td>
					<?php } ?>
                    <td>0</td>
                    <td>0</td>
            </tr>
       </tbody>
    </table>
    <div>&nbsp;</div>
    <table class="table table-bordered">
    	<thead>
            <tr>
                <th style="background:#FF0040;color:#FFFFFF; vertical-align:middle">ALL HQ</th>
	<?php 
        $Monthwisep=mysql_query("select DATE_FORMAT(m1, '%Y/%m/%d') AS S, LAST_DAY(DATE_ADD(DATE_FORMAT(m1, '%Y/%m/%d'), INTERVAL 0 MONTH)) S1 from (select 
('".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' - INTERVAL DAYOFMONTH('".date("Y-m-d",strtotime($_REQUEST["from_date"]))."')-1 DAY) +INTERVAL m MONTH as m1 from (select @rownum:=@rownum+1 as m from (select 1 union select 2 union select 3 union select 4) t1, (select 1 union select 2 union select 3 union select 4) t2, (select 1 union select 2 union select 3 union select 4) t3, (select 1 union select 2 union select 3 union select 4) t4, (select @rownum:=-1) t0 ) d1 ) d2  where m1<='".date("Y-m-d",strtotime($_REQUEST["to_date"]))."' order by m1");
        while($M=mysql_fetch_object($Monthwisep)){
    ?>
                <th style="background:#A4A4A4;color:#FFFFFF; vertical-align:middle"><?=date("M y",strtotime($M->S)); ?></th>
               <?php } ?> 
               <th style="background:#FF0040;color:#FFFFFF; vertical-align:middle">Total</th>
               <th style="background:#FF0040;color:#FFFFFF; vertical-align:middle">Average</th>
           </tr>
       </thead>
       <tbody>
       <?php $product=mysql_query("SELECT id,pro_name FROM product");while($prod=mysql_fetch_object($product)){ $Qty=0; ?>
       		<tr>
                <td><?php echo strtoupper($prod->pro_name); ?></td>
             <?php 
			 	$Monthwisep1=mysql_query("select DATE_FORMAT(m1, '%Y/%m/%d') AS S, LAST_DAY(DATE_ADD(DATE_FORMAT(m1, '%Y/%m/%d'), INTERVAL 0 MONTH)) S1 from (select 
('".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' - INTERVAL DAYOFMONTH('".date("Y-m-d",strtotime($_REQUEST["from_date"]))."')-1 DAY) +INTERVAL m MONTH as m1 from (select @rownum:=@rownum+1 as m from (select 1 union select 2 union select 3 union select 4) t1, (select 1 union select 2 union select 3 union select 4) t2, (select 1 union select 2 union select 3 union select 4) t3, (select 1 union select 2 union select 3 union select 4) t4, (select @rownum:=-1) t0 ) d1 ) d2  where m1<='".date("Y-m-d",strtotime($_REQUEST["to_date"]))."' order by m1");
        while($M1=mysql_fetch_object($Monthwisep1)){
				$CSale1=mysql_query("SELECT IFNULL(SUM(quantity),0) Q  FROM areawise_temp WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($M1->S))."' AND '".date("Y/m/d",strtotime($M1->S1))."') AND rep_id='".$_REQUEST["rep"]."' AND our_cust_id!='' AND our_product_id!='' AND our_product_id='".$prod->id."'");
				$CPTS1=mysql_fetch_object($CSale1);
				$Qty+=$CPTS1->Q;
			 ?>
             <td><?php echo $CPTS1->Q; ?></td>
             <?php } ?>
             <td><?=$Qty; ?></td>
              <td><?=round($Qty/$MDiff->MONTH); ?></td>  
            </tr>
       <?php } ?>
       		<tr>
            	<td><strong>Total Qty</strong></td>
                <?php 
			 	$MonthwisepA2=mysql_query("select DATE_FORMAT(m1, '%Y/%m/%d') AS S, LAST_DAY(DATE_ADD(DATE_FORMAT(m1, '%Y/%m/%d'), INTERVAL 0 MONTH)) S1 from (select 
('".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' - INTERVAL DAYOFMONTH('".date("Y-m-d",strtotime($_REQUEST["from_date"]))."')-1 DAY) +INTERVAL m MONTH as m1 from (select @rownum:=@rownum+1 as m from (select 1 union select 2 union select 3 union select 4) t1, (select 1 union select 2 union select 3 union select 4) t2, (select 1 union select 2 union select 3 union select 4) t3, (select 1 union select 2 union select 3 union select 4) t4, (select @rownum:=-1) t0 ) d1 ) d2  where m1<='".date("Y-m-d",strtotime($_REQUEST["to_date"]))."' order by m1");
        while($M1=mysql_fetch_object($MonthwisepA2)){
				$CSaleA2=mysql_query("SELECT IFNULL(SUM(quantity),0) Q  FROM areawise_temp WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($M1->S))."' AND '".date("Y/m/d",strtotime($M1->S1))."') AND rep_id='".$_REQUEST["rep"]."' AND our_cust_id!='' AND our_product_id!=''");
				$CPTS1=mysql_fetch_object($CSaleA2);
				$Qty+=$CPTS1->Q;
			 ?>
             <td><?php echo $CPTS1->Q; ?></td>
             <?php } ?>
             <td><?=$Qty; ?></td>
              <td><?=round($Qty/$MDiff->MONTH); ?></td>
            </tr>
            <tr>
            	<td><strong>PTS Value</strong></td>
                <?php 
			 	$MonthwisepA2=mysql_query("select DATE_FORMAT(m1, '%Y/%m/%d') AS S, LAST_DAY(DATE_ADD(DATE_FORMAT(m1, '%Y/%m/%d'), INTERVAL 0 MONTH)) S1 from (select 
('".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' - INTERVAL DAYOFMONTH('".date("Y-m-d",strtotime($_REQUEST["from_date"]))."')-1 DAY) +INTERVAL m MONTH as m1 from (select @rownum:=@rownum+1 as m from (select 1 union select 2 union select 3 union select 4) t1, (select 1 union select 2 union select 3 union select 4) t2, (select 1 union select 2 union select 3 union select 4) t3, (select 1 union select 2 union select 3 union select 4) t4, (select @rownum:=-1) t0 ) d1 ) d2  where m1<='".date("Y-m-d",strtotime($_REQUEST["to_date"]))."' order by m1");
        while($M1=mysql_fetch_object($MonthwisepA2)){
				$CSaleA2=mysql_query("SELECT IFNULL(ROUND(SUM(quantity*pts)),0) PTS  FROM areawise_temp,product WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($M1->S))."' AND '".date("Y/m/d",strtotime($M1->S1))."') AND rep_id='".$_REQUEST["rep"]."' AND our_cust_id!='' AND our_product_id!='' AND areawise_temp.our_product_id=product.id");
				$CPTS1=mysql_fetch_object($CSaleA2);
				$PTS+=$CPTS1->PTS;
			 ?>
             <td><?php echo $CPTS1->PTS; ?></td>
             <?php } ?>
             <td><?=$PTS; ?></td>
              <td><?=round($PTS/$MDiff->MONTH,0); ?></td>
            </tr>
       </tbody>     
    </table>
    <div>&nbsp;</div>
    <?php
		$Teritary=mysql_query("SELECT * FROM mst_tertiary WHERE teritary_rep_id='".$_REQUEST["rep"]."'"); // Teritarywise
		$TCnt=mysql_num_rows($Teritary);
		if($TCnt>0){		
		while($T=mysql_fetch_object($Teritary)){ $TID=$T->tertiary_id;$TNAME=$T->tertiary_name; ?>
    		<table class="table table-bordered">
    <thead>
    	<tr><th style="background:#FFBF00; vertical-align:middle"><?=strtoupper($T->tertiary_name); ?></th>
<?php	
		$Monthwisep=mysql_query("select DATE_FORMAT(m1, '%Y/%m/%d') AS S, LAST_DAY(DATE_ADD(DATE_FORMAT(m1, '%Y/%m/%d'), INTERVAL 0 MONTH)) S1 from (select 
('".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' - INTERVAL DAYOFMONTH('".date("Y-m-d",strtotime($_REQUEST["from_date"]))."')-1 DAY) +INTERVAL m MONTH as m1 from (select @rownum:=@rownum+1 as m from (select 1 union select 2 union select 3 union select 4) t1, (select 1 union select 2 union select 3 union select 4) t2, (select 1 union select 2 union select 3 union select 4) t3, (select 1 union select 2 union select 3 union select 4) t4, (select @rownum:=-1) t0 ) d1 ) d2  where m1<='".date("Y-m-d",strtotime($_REQUEST["to_date"]))."' order by m1");	
		 while($M=mysql_fetch_object($Monthwisep)){
?>
		<th style="background:#FAAC58; vertical-align:middle"><?=date("M y",strtotime($M->S)); ?></th>
       <?php } ?> 
       <th style="background:#FFBF00; vertical-align:middle">Total</th>
       <th style="background:#FFBF00; vertical-align:middle">Average</th>
       </tr>
       </thead>
       <tbody>
       		<tr>
                <td>Target</td>
                <?php $Monthwiset1=mysql_query("select DATE_FORMAT(m1, '%Y/%m/%d') AS S, LAST_DAY(DATE_ADD(DATE_FORMAT(m1, '%Y/%m/%d'), INTERVAL 0 MONTH)) S1 from (select 
('".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' - INTERVAL DAYOFMONTH('".date("Y-m-d",strtotime($_REQUEST["from_date"]))."')-1 DAY) +INTERVAL m MONTH as m1 from (select @rownum:=@rownum+1 as m from (select 1 union select 2 union select 3 union select 4) t1, (select 1 union select 2 union select 3 union select 4) t2, (select 1 union select 2 union select 3 union select 4) t3, (select 1 union select 2 union select 3 union select 4) t4, (select @rownum:=-1) t0 ) d1 ) d2  where m1<='".date("Y-m-d",strtotime($_REQUEST["to_date"]))."' order by m1"); while($T=mysql_fetch_object($Monthwiset1)){ ?>
                	<td>0</td>
					<?php } ?>
                    <td>0</td>
                    <td>0</td>
            </tr>
            <tr>
            	<td>Primary Sales</td>
                 <?php $Monthwiset2=mysql_query("select DATE_FORMAT(m1, '%Y/%m/%d') AS S, LAST_DAY(DATE_ADD(DATE_FORMAT(m1, '%Y/%m/%d'), INTERVAL 0 MONTH)) S1 from (select 
('".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' - INTERVAL DAYOFMONTH('".date("Y-m-d",strtotime($_REQUEST["from_date"]))."')-1 DAY) +INTERVAL m MONTH as m1 from (select @rownum:=@rownum+1 as m from (select 1 union select 2 union select 3 union select 4) t1, (select 1 union select 2 union select 3 union select 4) t2, (select 1 union select 2 union select 3 union select 4) t3, (select 1 union select 2 union select 3 union select 4) t4, (select @rownum:=-1) t0 ) d1 ) d2  where m1<='".date("Y-m-d",strtotime($_REQUEST["to_date"]))."' order by m1"); while($P=mysql_fetch_object($Monthwiset2)){ ?>
                	<td>0</td>
					<?php } ?>
                    <td>0</td>
                    <td>0</td>
            </tr>
            <tr>
            	<td>Secondary Sales</td>
                <?php
				$Monthwiset3=mysql_query("select DATE_FORMAT(m1, '%Y/%m/%d') AS S, LAST_DAY(DATE_ADD(DATE_FORMAT(m1, '%Y/%m/%d'), INTERVAL 0 MONTH)) S1 from (select 
('".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' - INTERVAL DAYOFMONTH('".date("Y-m-d",strtotime($_REQUEST["from_date"]))."')-1 DAY) +INTERVAL m MONTH as m1 from (select @rownum:=@rownum+1 as m from (select 1 union select 2 union select 3 union select 4) t1, (select 1 union select 2 union select 3 union select 4) t2, (select 1 union select 2 union select 3 union select 4) t3, (select 1 union select 2 union select 3 union select 4) t4, (select @rownum:=-1) t0 ) d1 ) d2  where m1<='".date("Y-m-d",strtotime($_REQUEST["to_date"]))."' order by m1"); while($PTS=mysql_fetch_object($Monthwiset3)){				
				$SSt=mysql_query("SELECT IFNULL(ROUND(SUM(quantity*pts),0),0) PTS FROM areawise_temp,product WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($PTS->S))."' AND '".date("Y/m/d",strtotime($PTS->S1))."') AND teritary_id='".$TID."' AND rep_id='".$_REQUEST["rep"]."' AND our_cust_id!='' AND our_product_id!='' AND our_product_id=product.id"); while($PTSValue=mysql_fetch_object($SSt)){ $SSPTSt+=$PTSValue->PTS;
				?>
                	<td><?php echo $PTSValue->PTS; ?></td>
					<?php }} ?>
                    <td><?=round($SSPTSt); ?></td>
                    <td><?=round($SSPTSt/$MDiff->MONTH,0); ?></td>
            </tr>
            <tr>
            	<td>Free</td>
                 <?php
				$Monthwiset4=mysql_query("select DATE_FORMAT(m1, '%Y/%m/%d') AS S, LAST_DAY(DATE_ADD(DATE_FORMAT(m1, '%Y/%m/%d'), INTERVAL 0 MONTH)) S1 from (select 
('".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' - INTERVAL DAYOFMONTH('".date("Y-m-d",strtotime($_REQUEST["from_date"]))."')-1 DAY) +INTERVAL m MONTH as m1 from (select @rownum:=@rownum+1 as m from (select 1 union select 2 union select 3 union select 4) t1, (select 1 union select 2 union select 3 union select 4) t2, (select 1 union select 2 union select 3 union select 4) t3, (select 1 union select 2 union select 3 union select 4) t4, (select @rownum:=-1) t0 ) d1 ) d2  where m1<='".date("Y-m-d",strtotime($_REQUEST["to_date"]))."' order by m1"); while($PTS1=mysql_fetch_object($Monthwiset4)){
				$SSt1=mysql_query("SELECT IFNULL(ROUND(SUM(free_quantity),0),0) F FROM areawise_temp,product WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($PTS1->S))."' AND '".date("Y/m/d",strtotime($PTS1->S1))."') AND teritary_id='".$TID."' AND rep_id='".$_REQUEST["rep"]."' AND our_cust_id!='' AND our_product_id!='' AND our_product_id=product.id"); while($FValue=mysql_fetch_object($SSt1)){ $SSFt+=$FValue->F;
				?>
                	<td><?=$FValue->F; ?></td>
					<?php }} ?>
                    <td><?=round($SSFt);?></td>
                    <td><?=round($SSFt/$MDiff->MONTH,0); ?></td>
            </tr>
            <tr>
            	<td>Sale Return</td>
                <?php
				$Monthwiset5=mysql_query("select DATE_FORMAT(m1, '%Y/%m/%d') AS S, LAST_DAY(DATE_ADD(DATE_FORMAT(m1, '%Y/%m/%d'), INTERVAL 0 MONTH)) S1 from (select 
('".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' - INTERVAL DAYOFMONTH('".date("Y-m-d",strtotime($_REQUEST["from_date"]))."')-1 DAY) +INTERVAL m MONTH as m1 from (select @rownum:=@rownum+1 as m from (select 1 union select 2 union select 3 union select 4) t1, (select 1 union select 2 union select 3 union select 4) t2, (select 1 union select 2 union select 3 union select 4) t3, (select 1 union select 2 union select 3 union select 4) t4, (select @rownum:=-1) t0 ) d1 ) d2  where m1<='".date("Y-m-d",strtotime($_REQUEST["to_date"]))."' order by m1"); while($PTS2=mysql_fetch_object($Monthwiset5)){
				$SSt2=mysql_query("SELECT IFNULL(ROUND(SUM(replace_quantity),0),0) F FROM areawise_temp,product WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($PTS2->S))."' AND '".date("Y/m/d",strtotime($PTS2->S1))."') AND teritary_id='".$TID."' AND rep_id='".$_REQUEST["rep"]."' AND our_cust_id!='' AND our_product_id!='' AND our_product_id=product.id"); while($RValue=mysql_fetch_object($SSt2)){
				$SSR+=$RValue->F;
				?>
                	<td><?=$RValue->F; ?></td>
					<?php }} ?>
                    <td><?=round($SSR);?></td>
                    <td><?=round($SSR/$MDiff->MONTH,0); ?></td>                
            </tr>
            <tr>
            	<td>Net Sales</td>
                <?php
				$Monthwiset6=mysql_query("select DATE_FORMAT(m1, '%Y/%m/%d') AS S, LAST_DAY(DATE_ADD(DATE_FORMAT(m1, '%Y/%m/%d'), INTERVAL 0 MONTH)) S1 from (select 
('".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' - INTERVAL DAYOFMONTH('".date("Y-m-d",strtotime($_REQUEST["from_date"]))."')-1 DAY) +INTERVAL m MONTH as m1 from (select @rownum:=@rownum+1 as m from (select 1 union select 2 union select 3 union select 4) t1, (select 1 union select 2 union select 3 union select 4) t2, (select 1 union select 2 union select 3 union select 4) t3, (select 1 union select 2 union select 3 union select 4) t4, (select @rownum:=-1) t0 ) d1 ) d2  where m1<='".date("Y-m-d",strtotime($_REQUEST["to_date"]))."' order by m1"); while($PTS3=mysql_fetch_object($Monthwiset6)){
				$SSt3=mysql_query("SELECT IFNULL(ROUND(SUM(quantity*pts),0),0) - IFNULL(ROUND(SUM(free_quantity),0),0) NETVALUE FROM areawise_temp,product WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($PTS3->S))."' AND '".date("Y/m/d",strtotime($PTS3->S1))."') AND teritary_id='".$TID."' AND rep_id='".$_REQUEST["rep"]."' AND our_cust_id!='' AND our_product_id!='' AND our_product_id=product.id"); while($NetValue=mysql_fetch_object($SSt3)){ $SS+=$NetValue->NETVALUE;
				?>
                	<td><?=$NetValue->NETVALUE; ?></td>
					<?php }} ?>
                    <td><?=round($SS);?></td>
                    <td><?=round($SS/$MDiff->MONTH,0); ?></td> 
            </tr>
            <tr>
            	<td>Sec value (Rs.) Growth (%)</td>
                <?php
				$Monthwiset7=mysql_query("select DATE_FORMAT(m1, '%Y/%m/%d') AS S, LAST_DAY(DATE_ADD(DATE_FORMAT(m1, '%Y/%m/%d'), INTERVAL 0 MONTH)) S1 from (select 
('".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' - INTERVAL DAYOFMONTH('".date("Y-m-d",strtotime($_REQUEST["from_date"]))."')-1 DAY) +INTERVAL m MONTH as m1 from (select @rownum:=@rownum+1 as m from (select 1 union select 2 union select 3 union select 4) t1, (select 1 union select 2 union select 3 union select 4) t2, (select 1 union select 2 union select 3 union select 4) t3, (select 1 union select 2 union select 3 union select 4) t4, (select @rownum:=-1) t0 ) d1 ) d2  where m1<='".date("Y-m-d",strtotime($_REQUEST["to_date"]))."' order by m1"); while($PTS4=mysql_fetch_object($Monthwiset7)){
				// Prev Month Sale
				$Prevt=mysql_query("select date_add(LAST_DAY(date_add('".date("Y/m/d",strtotime($PTS4->S))."',interval -2 month)), interval 1 day) FirstDay, LAST_DAY(date_add('".date("Y/m/d",strtotime($PTS4->S))."',interval -1 month)) LastDay");
				$PSale=mysql_fetch_object($Prevt);

				$PSt=mysql_query("SELECT IFNULL(ROUND(SUM(quantity*pts),0),0) PTS  FROM areawise_temp,product WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($PSale->FirstDay))."' AND '".date("Y/m/d",strtotime($PSale->LastDay))."') AND teritary_id='".$TID."' AND rep_id='".$_REQUEST["rep"]."' AND our_cust_id!='' AND our_product_id!='' AND our_product_id=product.id");
				$PPTS=mysql_fetch_object($PSt);
				// Current Month Sale
				$CSalet=mysql_query("SELECT IFNULL(ROUND(SUM(quantity*pts),0),0) PTS  FROM areawise_temp,product WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($PTS4->S))."' AND '".date("Y/m/d",strtotime($PTS4->S1))."') AND teritary_id='".$TID."' AND rep_id='".$_REQUEST["rep"]."' AND our_cust_id!='' AND our_product_id!='' AND our_product_id=product.id");
				$CPTS=mysql_fetch_object($CSalet);			
				
				?>
                	<td><?=round(((($CPTS->PTS-$PPTS->PTS)/$PPTS->PTS)*100))."%"; ?></td>
					<?php } ?>
                    <td>0</td>
                    <td>0</td>
            </tr>
            <tr>
            	<td>No of Growth Products</td>
                <?php
				$Monthwiset8=mysql_query("select DATE_FORMAT(m1, '%Y/%m/%d') AS S, LAST_DAY(DATE_ADD(DATE_FORMAT(m1, '%Y/%m/%d'), INTERVAL 0 MONTH)) S1 from (select 
('".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' - INTERVAL DAYOFMONTH('".date("Y-m-d",strtotime($_REQUEST["from_date"]))."')-1 DAY) +INTERVAL m MONTH as m1 from (select @rownum:=@rownum+1 as m from (select 1 union select 2 union select 3 union select 4) t1, (select 1 union select 2 union select 3 union select 4) t2, (select 1 union select 2 union select 3 union select 4) t3, (select 1 union select 2 union select 3 union select 4) t4, (select @rownum:=-1) t0 ) d1 ) d2  where m1<='".date("Y-m-d",strtotime($_REQUEST["to_date"]))."' order by m1"); while($PTS5=mysql_fetch_object($Monthwiset8)){
				// Prev Month Sale
				$Prevt1=mysql_query("select date_add(LAST_DAY(date_add('".date("Y/m/d",strtotime($PTS5->S))."',interval -2 month)), interval 1 day) FirstDay, LAST_DAY(date_add('".date("Y/m/d",strtotime($PTS5->S))."',interval -1 month)) LastDay");
				$PSale1=mysql_fetch_object($Prevt1);

				$PSt1=mysql_query("SELECT IFNULL(COUNT(quantity),0) Q  FROM areawise_temp,product WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($PSale1->FirstDay))."' AND '".date("Y/m/d",strtotime($PSale1->LastDay))."') AND teritary_id='".$TID."' AND rep_id='".$_REQUEST["rep"]."' AND our_cust_id!='' AND our_product_id!='' AND our_product_id=product.id GROUP BY our_product_id");
				$PPTS1=mysql_fetch_object($PSt1);
				// Current Month Sale
				$CSalet1=mysql_query("SELECT IFNULL(COUNT(quantity),0) Q  FROM areawise_temp,product WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($PTS5->S))."' AND '".date("Y/m/d",strtotime($PTS5->S1))."') AND teritary_id='".$TID."' AND rep_id='".$_REQUEST["rep"]."' AND our_cust_id!='' AND our_product_id!='' AND our_product_id=product.id GROUP BY our_product_id");
				$CPTS1=mysql_fetch_object($CSalet1);			
				
				?>
                	<td><?php if($PPTS1->Q>$CPTS1->Q){ echo $PPTS1->Q-$CPTS1->Q;}else{ echo "0";} ?></td>
					<?php } ?>
                    <td>0</td>
                    <td>0</td>
            </tr>
            <tr>
            	<td>No of Degrowth Products</td>
                 <?php
				$Monthwiset9=mysql_query("select DATE_FORMAT(m1, '%Y/%m/%d') AS S, LAST_DAY(DATE_ADD(DATE_FORMAT(m1, '%Y/%m/%d'), INTERVAL 0 MONTH)) S1 from (select 
('".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' - INTERVAL DAYOFMONTH('".date("Y-m-d",strtotime($_REQUEST["from_date"]))."')-1 DAY) +INTERVAL m MONTH as m1 from (select @rownum:=@rownum+1 as m from (select 1 union select 2 union select 3 union select 4) t1, (select 1 union select 2 union select 3 union select 4) t2, (select 1 union select 2 union select 3 union select 4) t3, (select 1 union select 2 union select 3 union select 4) t4, (select @rownum:=-1) t0 ) d1 ) d2  where m1<='".date("Y-m-d",strtotime($_REQUEST["to_date"]))."' order by m1"); while($PTS5=mysql_fetch_object($Monthwiset9)){
				// Prev Month Sale
				$Prevt1=mysql_query("select date_add(LAST_DAY(date_add('".date("Y/m/d",strtotime($PTS5->S))."',interval -2 month)), interval 1 day) FirstDay, LAST_DAY(date_add('".date("Y/m/d",strtotime($PTS5->S))."',interval -1 month)) LastDay");
				$PSale1=mysql_fetch_object($Prevt1);

				$PSt1=mysql_query("SELECT IFNULL(COUNT(quantity),0) Q  FROM areawise_temp,product WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($PSale1->FirstDay))."' AND '".date("Y/m/d",strtotime($PSale1->LastDay))."') AND teritary_id='".$TID."' AND rep_id='".$_REQUEST["rep"]."' AND our_cust_id!='' AND our_product_id!='' AND our_product_id=product.id GROUP BY our_product_id");
				$PPTS1=mysql_fetch_object($PSt1);
				// Current Month Sale
				$CSalet1=mysql_query("SELECT IFNULL(COUNT(quantity),0) Q  FROM areawise_temp,product WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($PTS5->S))."' AND '".date("Y/m/d",strtotime($PTS5->S1))."') AND rep_id='".$_REQUEST["rep"]."' AND our_cust_id!='' AND our_product_id!='' AND our_product_id=product.id GROUP BY our_product_id");
				$CPTS1=mysql_fetch_object($CSalet1);			
				
				?>
                	<td><?php if($PPTS1->Q<$CPTS1->Q){ echo -($PPTS1->Q-$CPTS1->Q);}else{ echo "0";} ?></td>
					<?php } ?>
                    <td>0</td>
                    <td>0</td>
            </tr>
            <tr>
            	<td>No of Products under Nil Sales</td>
                <?php
				$Monthwiset11=mysql_query("select DATE_FORMAT(m1, '%Y/%m/%d') AS S, LAST_DAY(DATE_ADD(DATE_FORMAT(m1, '%Y/%m/%d'), INTERVAL 0 MONTH)) S1 from (select 
('".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' - INTERVAL DAYOFMONTH('".date("Y-m-d",strtotime($_REQUEST["from_date"]))."')-1 DAY) +INTERVAL m MONTH as m1 from (select @rownum:=@rownum+1 as m from (select 1 union select 2 union select 3 union select 4) t1, (select 1 union select 2 union select 3 union select 4) t2, (select 1 union select 2 union select 3 union select 4) t3, (select 1 union select 2 union select 3 union select 4) t4, (select @rownum:=-1) t0 ) d1 ) d2  where m1<='".date("Y-m-d",strtotime($_REQUEST["to_date"]))."' order by m1"); while($PTS11=mysql_fetch_object($Monthwiset11)){
				$SSt3=mysql_query("SELECT COUNT(id) AS NILPROD FROM product WHERE id NOT IN (SELECT our_product_id FROM areawise_temp WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($PTS11->S))."' AND '".date("Y/m/d",strtotime($PTS11->S1))."') AND teritary_id='".$TID."' AND rep_id='".$_REQUEST["rep"]."' AND our_cust_id!='' AND our_product_id!='' GROUP BY our_product_id)"); while($NetValue=mysql_fetch_object($SSt3)){
				?>
                	<td><?=$NetValue->NILPROD; ?></td>
					<?php }} ?>
                    <td>0</td>
                    <td>0</td>
            </tr>
            <tr>
            	<td>Target Vs Achievement (%)</td>
                <?php $Monthwiset1=mysql_query("select DATE_FORMAT(m1, '%Y/%m/%d') AS S, LAST_DAY(DATE_ADD(DATE_FORMAT(m1, '%Y/%m/%d'), INTERVAL 0 MONTH)) S1 from (select 
('".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' - INTERVAL DAYOFMONTH('".date("Y-m-d",strtotime($_REQUEST["from_date"]))."')-1 DAY) +INTERVAL m MONTH as m1 from (select @rownum:=@rownum+1 as m from (select 1 union select 2 union select 3 union select 4) t1, (select 1 union select 2 union select 3 union select 4) t2, (select 1 union select 2 union select 3 union select 4) t3, (select 1 union select 2 union select 3 union select 4) t4, (select @rownum:=-1) t0 ) d1 ) d2  where m1<='".date("Y-m-d",strtotime($_REQUEST["to_date"]))."' order by m1"); while($T=mysql_fetch_object($Monthwiset1)){ ?>
                	<td>0</td>
					<?php } ?>
                    <td>0</td>
                    <td>0</td>
            </tr>
       </tbody>
    </table>
    <div>&nbsp;</div>
    	<table class="table table-bordered">
    	<thead>
            <tr>
                <th style="background:#FF0040;color:#FFFFFF; vertical-align:middle"><?=strtoupper($TNAME); ?></th>
	<?php 
        $Monthwisept=mysql_query("select DATE_FORMAT(m1, '%Y/%m/%d') AS S, LAST_DAY(DATE_ADD(DATE_FORMAT(m1, '%Y/%m/%d'), INTERVAL 0 MONTH)) S1 from (select 
('".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' - INTERVAL DAYOFMONTH('".date("Y-m-d",strtotime($_REQUEST["from_date"]))."')-1 DAY) +INTERVAL m MONTH as m1 from (select @rownum:=@rownum+1 as m from (select 1 union select 2 union select 3 union select 4) t1, (select 1 union select 2 union select 3 union select 4) t2, (select 1 union select 2 union select 3 union select 4) t3, (select 1 union select 2 union select 3 union select 4) t4, (select @rownum:=-1) t0 ) d1 ) d2  where m1<='".date("Y-m-d",strtotime($_REQUEST["to_date"]))."' order by m1");
        while($M=mysql_fetch_object($Monthwisept)){
    ?>
                <th style="background:#A4A4A4;color:#FFFFFF; vertical-align:middle"><?=date("M y",strtotime($M->S)); ?></th>
               <?php } ?> 
               <th style="background:#FF0040;color:#FFFFFF; vertical-align:middle">Total</th>
               <th style="background:#FF0040;color:#FFFFFF; vertical-align:middle">Average</th>
           </tr>
       </thead>
       <tbody>
       <?php $productt=mysql_query("SELECT id,pro_name FROM product");while($prodt=mysql_fetch_object($productt)){ $Qty=0; ?>
       		<tr>
                <td><?php echo strtoupper($prodt->pro_name); ?></td>
             <?php 
			 	$Monthwisept1=mysql_query("select DATE_FORMAT(m1, '%Y/%m/%d') AS S, LAST_DAY(DATE_ADD(DATE_FORMAT(m1, '%Y/%m/%d'), INTERVAL 0 MONTH)) S1 from (select 
('".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' - INTERVAL DAYOFMONTH('".date("Y-m-d",strtotime($_REQUEST["from_date"]))."')-1 DAY) +INTERVAL m MONTH as m1 from (select @rownum:=@rownum+1 as m from (select 1 union select 2 union select 3 union select 4) t1, (select 1 union select 2 union select 3 union select 4) t2, (select 1 union select 2 union select 3 union select 4) t3, (select 1 union select 2 union select 3 union select 4) t4, (select @rownum:=-1) t0 ) d1 ) d2  where m1<='".date("Y-m-d",strtotime($_REQUEST["to_date"]))."' order by m1");
        while($M1=mysql_fetch_object($Monthwisept1)){
				$CSalet1=mysql_query("SELECT IFNULL(SUM(quantity),0) Q  FROM areawise_temp WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($M1->S))."' AND '".date("Y/m/d",strtotime($M1->S1))."') AND teritary_id='".$TID."' AND rep_id='".$_REQUEST["rep"]."' AND our_cust_id!='' AND our_product_id!='' AND our_product_id='".$prodt->id."'");
				$CPTS1=mysql_fetch_object($CSalet1);
				$Qty+=$CPTS1->Q;
			 ?>
             <td><?php echo $CPTS1->Q; ?></td>
             <?php } ?>
             <td><?=$Qty; ?></td>
              <td><?=round($Qty/$MDiff->MONTH); ?></td>                
            </tr>           
       <?php } ?>
        	<tr>
            	<td><strong>Total Qty</strong></td>
                <?php 
			 	$Monthwisept2=mysql_query("select DATE_FORMAT(m1, '%Y/%m/%d') AS S, LAST_DAY(DATE_ADD(DATE_FORMAT(m1, '%Y/%m/%d'), INTERVAL 0 MONTH)) S1 from (select 
('".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' - INTERVAL DAYOFMONTH('".date("Y-m-d",strtotime($_REQUEST["from_date"]))."')-1 DAY) +INTERVAL m MONTH as m1 from (select @rownum:=@rownum+1 as m from (select 1 union select 2 union select 3 union select 4) t1, (select 1 union select 2 union select 3 union select 4) t2, (select 1 union select 2 union select 3 union select 4) t3, (select 1 union select 2 union select 3 union select 4) t4, (select @rownum:=-1) t0 ) d1 ) d2  where m1<='".date("Y-m-d",strtotime($_REQUEST["to_date"]))."' order by m1");
        while($M1=mysql_fetch_object($Monthwisept2)){
				$CSalet2=mysql_query("SELECT IFNULL(SUM(quantity),0) Q  FROM areawise_temp WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($M1->S))."' AND '".date("Y/m/d",strtotime($M1->S1))."') AND teritary_id='".$TID."' AND rep_id='".$_REQUEST["rep"]."' AND our_cust_id!='' AND our_product_id!=''");
				$CPTS1=mysql_fetch_object($CSalet2);
				$Qty+=$CPTS1->Q;
			 ?>
             <td><?php echo $CPTS1->Q; ?></td>
             <?php } ?>
             <td><?=$Qty; ?></td>
              <td><?=round($Qty/$MDiff->MONTH); ?></td>
            </tr>
            <tr>
            	<td><strong>PTS Value</strong></td>
                <?php 
			 	$Monthwisept2=mysql_query("select DATE_FORMAT(m1, '%Y/%m/%d') AS S, LAST_DAY(DATE_ADD(DATE_FORMAT(m1, '%Y/%m/%d'), INTERVAL 0 MONTH)) S1 from (select 
('".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' - INTERVAL DAYOFMONTH('".date("Y-m-d",strtotime($_REQUEST["from_date"]))."')-1 DAY) +INTERVAL m MONTH as m1 from (select @rownum:=@rownum+1 as m from (select 1 union select 2 union select 3 union select 4) t1, (select 1 union select 2 union select 3 union select 4) t2, (select 1 union select 2 union select 3 union select 4) t3, (select 1 union select 2 union select 3 union select 4) t4, (select @rownum:=-1) t0 ) d1 ) d2  where m1<='".date("Y-m-d",strtotime($_REQUEST["to_date"]))."' order by m1");
        while($M1=mysql_fetch_object($Monthwisept2)){
				$CSalet2=mysql_query("SELECT IFNULL(ROUND(SUM(quantity*pts)),0) PTS  FROM areawise_temp,product WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($M1->S))."' AND '".date("Y/m/d",strtotime($M1->S1))."') AND teritary_id='".$TID."' AND rep_id='".$_REQUEST["rep"]."' AND our_cust_id!='' AND our_product_id!='' AND areawise_temp.our_product_id=product.id");
				$CPTS1=mysql_fetch_object($CSalet2);
				$PTS+=$CPTS1->PTS;
			 ?>
             <td><?php echo $CPTS1->PTS; ?></td>
             <?php } ?>
             <td><?=$PTS; ?></td>
              <td><?=round($PTS/$MDiff->MONTH,0); ?></td>
            </tr>
       </tbody>     
    </table>
        <?php } ?>
    <?php } ?>
<?php } ?>
</form>
</div>
</div>
</div>

</div>
</div>

<hr>
      
    </div>

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
    <style>
    	.ui-datepicker-calendar {display:none;}
    </style>
    <script>
	 $(document).ready(function() {
	   $('#txtDate,#txtDate1').datepicker({
		 changeMonth: true,
		 changeYear: true,
		 dateFormat: 'yy/mm',
		   
		 onClose: function() {
			var iMonth = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
			var iYear = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
			$(this).datepicker('setDate', new Date(iYear, iMonth, 1));
		 },
		   
		 beforeShow: function() {
		   if ((selDate = $(this).val()).length > 0) 
		   {
			  iYear = selDate.substring(selDate.length - 4, selDate.length);
			  iMonth = jQuery.inArray(selDate.substring(0, selDate.length - 5), $(this).datepicker('option', 'monthNames'));
			  $(this).datepicker('option', 'defaultDate', new Date(iYear, iMonth, 1));
			   $(this).datepicker('setDate', new Date(iYear, iMonth, 1));
		   }
		}
	  });
	});    
    </script> 
      
</body>
</html>
<?php
}
?>
