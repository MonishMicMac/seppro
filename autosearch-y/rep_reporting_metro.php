<?php
	include("connect_db.php");
	
	$link = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("Couldn't make connection.");
	$db = mysql_select_db(DB_NAME, $link) or die("Couldn't select database");
	error_reporting(0);
if(isset($_GET["consolidated"])){	
	
		$SQL=mysql_query("SELECT clinetcreation.companyname,clinetcreation.pincode,reporteddate,reportedtime,repremarks FROM reorting,clinetcreation WHERE reorting.clientid=clinetcreation.id AND reorting.repid='".$_GET["rep"]."' AND (tdate BETWEEN '".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' AND '".date("Y-m-d",strtotime($_REQUEST["to_date"]))."')  GROUP BY reorting.clientid ORDER BY  reorting.id DESC");
		echo mysql_error();
		$CNT=mysql_num_rows($SQL);
		if($CNT>0){
		echo "<h2>".$_GET["rep_name"]." - ".strtoupper($_SESSION["LABEL"])." LIST</h2>";
		$P=1;
?>
<table class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
<thead>
<tr><th style="text-align:center">S.NO</th><th style="text-align:center"><?php echo strtoupper($_SESSION["LABEL"]); ?></th><th>REMARKS</th><th>LAST VISITED</th><th style="text-align:center">PINCODE</th></tr>
</thead> 
<tbody>  
<?php while($R=mysql_fetch_object($SQL)){ ?>
	<tr><td style="text-align:center"><?=$P; ?></td><td><?=$R->companyname; ?></td><td><?=$R->repremarks; ?></td><td><?php if($R->reporteddate!=""){echo date("d/m/Y",strtotime($R->reporteddate))." ".$R->reportedtime;} ?></td>
    <td style="text-align:right">
	<?php $AREA=mysql_query("SELECT * FROM master_pincode WHERE pincode='".$R->pincode."' GROUP BY pincode");$areaname=mysql_fetch_object($AREA);
		echo $R->pincode; ?>
    </td></tr>
<?php			
			$P++;}
?>
</tbody>
</table>
<?php
			
		}


}
	
	if(isset($_GET["missed"])){	
		$SQL=mysql_query("SELECT name,pincode FROM clinetcreation WHERE id IN (SELECT clientid FROM reorting WHERE (reorting.tdate BETWEEN '".date('Y-m-d',strtotime($_REQUEST["from_date"]))."' AND '".date('Y-m-d',strtotime($_REQUEST["to_date"]))."')  AND repid='".$_GET["rep"]."' AND attendance='0')");
		echo mysql_error();
		$CNT=mysql_num_rows($SQL);
		if($CNT>0){
		echo "<h2>".$_GET["rep_name"]." - ".strtoupper($_SESSION["LABEL"])." MISSED LIST</h2>";
		$P=1;
?>
<table class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
<thead>
<tr><th style="text-align:center">S.NO</th><th style="text-align:center"><?php echo strtoupper($_SESSION["LABEL"]); ?></th><th style="text-align:center">PINCODE</th></tr>
</thead> 
<tbody>  
<?php while($MR=mysql_fetch_object($SQL)){ ?>
	<tr><td style="text-align:center"><?=$P; ?></td><td><?=$MR->name; ?></td>
    <td style="text-align:right"><?php echo $MR->pincode; ?></td></tr>
<?php $P++;} ?>
</tbody>
</table>
<?php
		}
	}


	if(isset($_GET["detailed"])){
		echo "<h2>".$_GET["rep_name"]." - Visited Call Report for ".date("d/m/Y",strtotime($_GET["from_date"]))." - ".date("d/m/Y",strtotime($_GET["to_date"]))."</h2>";
		
			$SQL=mysql_query("SELECT R, COUNT(D) DR FROM (SELECT repid R,COUNT(clientid) AS D FROM reorting WHERE attendance='1'  AND (tdate BETWEEN '".date("Y-m-d",strtotime($_GET["from_date"]))."' AND '".date("Y-m-d",strtotime($_GET["to_date"]))."') AND repid='".$_GET["rep"]."' GROUP BY clientid HAVING D=1) AS B GROUP BY R");
	
		$CNT=mysql_num_rows($SQL);	
		if($CNT>0){
			$R=mysql_fetch_object($SQL); 
			echo "<h3> One Visit Listed ".$_SESSION["LABEL"]." (".$R->DR.") </h3>";

		
			$D=mysql_query("SELECT reorting.repremarks,reorting.reporteddate,reorting.reportedtime,clinetcreation.name as name,clinetcreation.pincode as pincode,reorting.repid R,reorting.clientid,COUNT(reorting.clientid) AS D FROM reorting,clinetcreation WHERE reorting.attendance='1'  AND (reorting.tdate BETWEEN '".date("Y-m-d",strtotime($_GET["from_date"]))."' AND '".date("Y-m-d",strtotime($_GET["to_date"]))."') AND reorting.repid='".$_GET["rep"]."' AND reorting.clientid=clinetcreation.id GROUP BY reorting.clientid HAVING D=1 ORDER BY reorting.id DESC");
		

?>
    <table class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
    <thead>
    <tr><th style="text-align:center">S.NO</th><th style="text-align:center"><?php echo $_SESSION["LABEL"]; ?></th><th style="text-align:center">Reported</th><th style="text-align:center">Last Visited</th><th style="text-align:center">PINCODE</th></tr>
    </thead> 
    <tbody>
		<?php $P=1;while($DR=mysql_fetch_object($D)){ ?>
				<tr>
                	<td style="text-align:center"><?=$P; ?></td><td><?=$DR->name; ?></td><td><?=$DR->repremarks; ?></td><td><?=date("d/m/Y",strtotime($DR->reporteddate))." ".$DR->reportedtime; ?></td><td style="text-align:right"><?php echo $DR->pincode; ?></td>
                </tr>
		<?php $P++;} ?>
    </tbody>
    </table>
<?php
		}
		// TWO TIMES
		
			$SQL1=mysql_query("SELECT R, COUNT(D) DR FROM (SELECT repid R,COUNT(clientid) AS D FROM reorting WHERE attendance='1' AND (tdate BETWEEN '".date("Y-m-d",strtotime($_GET["from_date"]))."' AND '".date("Y-m-d",strtotime($_GET["to_date"]))."') AND repid='".$_GET["rep"]."' GROUP BY clientid HAVING D=2) AS B GROUP BY R");
		
		$CNT1=mysql_num_rows($SQL1);			
		if($CNT1>0){
			$R1=mysql_fetch_object($SQL1);
			echo "<h3> Two Time Visit Listed ".$_SESSION["LABEL"]." (".$R1->DR.") </h3>";

		
			$D1=mysql_query("SELECT reorting.repremarks,reorting.reporteddate,reorting.reportedtime,clinetcreation.name as name,clinetcreation.pincode as pincode,reorting.repid R,reorting.clientid,COUNT(reorting.clientid) as D FROM reorting,clinetcreation WHERE reorting.attendance='1'  AND (reorting.tdate BETWEEN '".date("Y-m-d",strtotime($_GET["from_date"]))."' AND '".date("Y-m-d",strtotime($_GET["to_date"]))."') AND reorting.repid='".$_GET["rep"]."' AND reorting.clientid=clinetcreation.id GROUP BY reorting.clientid HAVING D=2 ORDER BY reorting.id DESC");
		
?>
    <table class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
    <thead>
    <tr><th style="text-align:center">S.NO</th><th style="text-align:center"><?php echo $_SESSION["LABEL"]; ?></th><th style="text-align:center">Reported</th><th style="text-align:center">Last Visited</th><th style="text-align:center">PINCODE</th></tr>
    </thead> 
    <tbody>
		<?php $P=1;while($DR1=mysql_fetch_object($D1)){ ?>
				<tr>
                	<td style="text-align:center"><?=$P; ?></td><td><?=$DR1->name; ?></td><td><?=$DR1->repremarks; ?></td><td><?=date("d/m/Y",strtotime($DR1->reporteddate))." ".$DR1->reportedtime; ?></td><td style="text-align:right"><?php echo $DR1->pincode; ?></td>
                </tr>
		<?php $P++;} ?>
    </tbody>
    </table>
<?php
		}
		
		// THREE TIMES
	
			$SQL2=mysql_query("SELECT R, COUNT(D) DR FROM (SELECT repid R,COUNT(clientid) AS D FROM reorting WHERE attendance='1' AND (tdate BETWEEN '".date("Y-m-d",strtotime($_GET["from_date"]))."' AND '".date("Y-m-d",strtotime($_GET["to_date"]))."') AND repid='".$_GET["rep"]."' GROUP BY clientid HAVING D=3) AS B GROUP BY R");
		
		$CNT2=mysql_num_rows($SQL2);			
		if($CNT2>0){
			$R2=mysql_fetch_object($SQL2); 
			echo "<h3> Three Time Visit Listed ".$_SESSION["LABEL"]." (".$R2->DR.") </h3>";

		
			$D2=mysql_query("SELECT reorting.repremarks,reorting.reporteddate,reorting.reportedtime,clinetcreation.name as name,clinetcreation.pincode as pincode,reorting.repid R,reorting.clientid,COUNT(reorting.clientid) as D FROM reorting,clinetcreation WHERE reorting.attendance='1'  AND (reorting.tdate BETWEEN '".date("Y-m-d",strtotime($_GET["from_date"]))."' AND '".date("Y-m-d",strtotime($_GET["to_date"]))."') AND reorting.repid='".$_GET["rep"]."' AND reorting.clientid=clinetcreation.id GROUP BY reorting.clientid HAVING D=3 ORDER BY reorting.id DESC");
		
?>
    <table class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
    <thead>
    <tr><th style="text-align:center">S.NO</th><th style="text-align:center"><?php echo $_SESSION["LABEL"]; ?></th><th style="text-align:center">Reported</th><th style="text-align:center">Last Visited</th><th style="text-align:center">PINCODE</th></tr>
    </thead> 
    <tbody>
		<?php $P=1;while($DR2=mysql_fetch_object($D2)){ ?>
				<tr>
                	<td style="text-align:center"><?=$P; ?></td><td><?=$DR2->name; ?></td><td><?=$DR2->repremarks; ?></td><td><?=date("d/m/Y",strtotime($DR2->reporteddate))." ".$DR2->reportedtime; ?></td><td style="text-align:right"><?php echo $DR2->pincode; ?></td>
                </tr>
		<?php $P++;} ?>
    </tbody>
    </table>
<?php
		}
		// > 3 TIMES
		
			$SQL3=mysql_query("SELECT R, COUNT(D) DR FROM (SELECT repid R,COUNT(clientid) AS D FROM reorting WHERE attendance='1' AND (tdate BETWEEN '".date("Y-m-d",strtotime($_GET["from_date"]))."' AND '".date("Y-m-d",strtotime($_GET["to_date"]))."') AND repid='".$_GET["rep"]."' GROUP BY clientid HAVING D>3) AS B GROUP BY R");
	
		$CNT3=mysql_num_rows($SQL3);	
		if($CNT3>0){
			$R3=mysql_fetch_object($SQL3); 
			echo "<h3> More than 3 Visit Listed ".$_SESSION["LABEL"]." (".$R3->DR.") </h3>";

		
			$D3=mysql_query("SELECT reorting.repremarks,reorting.reporteddate,reorting.reportedtime,clinetcreation.name as name,clinetcreation.pincode as pincode,reorting.repid R,reorting.clientid,COUNT(reorting.clientid) as D FROM reorting,clinetcreation WHERE reorting.attendance='1'  AND (reorting.tdate BETWEEN '".date("Y-m-d",strtotime($_GET["from_date"]))."' AND '".date("Y-m-d",strtotime($_GET["to_date"]))."') AND reorting.repid='".$_GET["rep"]."' AND reorting.clientid=clinetcreation.id GROUP BY reorting.clientid HAVING D>3 ORDER BY reorting.id DESC");
		
	?>
		<table class="table table-striped table-bordered bootstrap-datatable datatable" width="100%">
		<thead>
		<tr><th style="text-align:center">S.NO</th><th style="text-align:center"><?php echo $_SESSION["LABEL"]; ?></th><th style="text-align:center">Reported</th><th style="text-align:center">Last Visited</th><th style="text-align:center">PINCODE</th></tr>
		</thead> 
		<tbody>
			<?php $P=1;while($DR3=mysql_fetch_object($D3)){ ?>
				<tr>
					<td style="text-align:center"><?=$P; ?></td><td><?=$DR3->name; ?></td><td><?=$DR3->doc_qualification; ?></td><td><?=$DR3->repremarks; ?></td><td><?=date("d/m/Y",strtotime($DR3->reporteddate))." ".$DR3->reportedtime; ?></td><td style="text-align:right"><?php echo $DR3->pincode; ?></td>
				</tr>
			<?php $P++;} ?>
		</tbody>
		</table>
	<?php
		}
	}
?>