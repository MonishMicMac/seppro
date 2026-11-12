<?php
	include("include/connect.php");
	
	error_reporting(E_ALL);
	@$_REQUEST["from_date"]="2017/01/01";@$_REQUEST["rep_name"]=15;
	$MDATE = mysql_query("select LAST_DAY(date_add('2017/01/01',interval 0 month)) LastDay");
	$R_MDATE=mysql_fetch_object($MDATE);
	
	$Covering_STK = mysql_query("SELECT group_concat(distinct areawise_temp.dist_id) as D FROM `areawise_temp`,distributor WHERE areawise_temp. rep_id IN (15) and (areawise_temp.bill_date BETWEEN '2017/01/01' AND '2017/01/31') and `areawise_temp`.dist_id=distributor.dis_id");
$STK=mysql_fetch_object($Covering_STK);

	// reprsentative details
	
	$REP1 = mysql_query("SELECT group_concat(id) rep_id FROM representative WHERE headquarter_id in (SELECT `headquarter_id` FROM `representative` WHERE `id` IN (15))");
	$REPALL=mysql_fetch_object($REP1);
	
	$REP = mysql_query("SELECT rdist_id,id FROM representative WHERE id IN (15)");
	$REPSTK=mysql_fetch_object($REP);
	
	$CommonCredit = mysql_query("SELECT round(SUM(quantity),0) AS Q, round(SUM(quantity*pts),0) TOT FROM `areawise_temp` WHERE `rep_id`='0' and dist_id IN (".$REPSTK->rdist_id.") and bill_date BETWEEN '2017/01/01' AND '2017/01/31'");
	$CC=mysql_fetch_object($CommonCredit);
	$common = $CC->TOT;$commonQ = $CC->Q;
	
	// TOTAL HQ SUM
	
	$CommonCreditSTK = mysql_query("SELECT round(SUM(quantity*pts),0) TOT FROM `areawise_temp` WHERE dist_id IN (".$REPSTK->rdist_id.") and bill_date BETWEEN '2017/01/01' AND '2017/01/31' and rep_id IN (".$REPALL->rep_id.")");
	$CCSTK=mysql_fetch_object($CommonCreditSTK);
	$commonSTK = $CCSTK->TOT;
	
	
	
	// CC1 CALCULATING
	
	$CommonCreditMR = mysql_query("SELECT round(SUM(quantity*pts),0) TOT FROM `areawise_temp` WHERE  rep_id IN (15) and bill_date BETWEEN '2017/01/01' AND '2017/01/31' AND dist_id IN (".$REPSTK->rdist_id.")");
	$CCMR=mysql_fetch_object($CommonCreditMR);
	$commonMR = $CCMR->TOT;
	
	$MRVALUEPERCENTAGE = round(($CCMR->TOT/($CCSTK->TOT-$CC->TOT))*100,0);
	
	$CommonCredit1 = mysql_query("SELECT round(SUM(quantity),0) AS Q, round(SUM(quantity*pts),0) TOT FROM `areawise_temp` WHERE `rep_id`='57' and bill_date BETWEEN '2017/01/01' AND '2017/01/31'");
	$CC1=mysql_fetch_object($CommonCredit1);
	$common1 = $CC1->TOT;$commonQ1 = $CC1->Q;
	
	
?>

<table width="100%" border="1">
<tr>
	<td>PRODUCT</td><td>PTS</td>
<?php
	$Dist=mysql_query("SELECT dis_name,dis_id FROM distributor WHERE dis_id IN (".$STK->D.") ORDER BY id"); // PRODUCT DETAILS	
	while($D=mysql_fetch_object($Dist)){
?>
	<td><?php echo strtoupper($D->dis_name); ?></td>	
<?php } ?>
	<td>CC1</td>
    <td>MEDPLUS</td>
    <td>TOTAL Q</td>
    <td>TOTAL V</td>
</tr>
<?php 
	$tot = 0;
	$ProductSales=mysql_query("SELECT id,pts,pro_name FROM product"); // PRODUCT DETAILS	
	while($PS=mysql_fetch_object($ProductSales)){
	$MEDPLUS = mysql_query("SELECT IFNULL(SUM(quantity),0) Q FROM areawise_temp WHERE our_product_id='".$PS->id."' AND bill_date BETWEEN '2017/01/01' AND '2017/01/31' and rep_id='57'");
				$MEDPY=mysql_fetch_object($MEDPLUS);
?>
	<tr><td><?php echo strtoupper($PS->pro_name); ?></td><td><?php echo strtoupper($PS->pts); ?></td>
    <?php
    	$Representative2=mysql_query("SELECT dis_id FROM distributor WHERE dis_id IN (".$STK->D.") ORDER BY id"); // PRODUCT DETAILS	
		while($R=mysql_fetch_object($Representative2)){	
			$Sales = mysql_query("SELECT IFNULL(SUM(quantity),0) Q,IFNULL(SUM(quantity*pts),0) PTS FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '2017/01/01' AND '2017/01/31' AND our_product_id='".$PS->id."' AND dist_id='".$R->dis_id."' and  rep_id IN (15)");
			
			
				
				
				$S=mysql_fetch_object($Sales);
				$tot = $tot+$S->Q;
	?>
    <td><?php echo $S->Q; ?></td>
    <?php } ?>
    <?php
    	$Representative22=mysql_query("SELECT id,sales_credit,rdist_id FROM representative WHERE id IN (15) ORDER BY id"); // PRODUCT DETAILS	
		while($R223=mysql_fetch_object($Representative22)){
				
				$Sales11 = mysql_query("SELECT IFNULL(SUM(quantity),0) Q,IFNULL(SUM(quantity*pts),0) PTS FROM areawise_temp WHERE rep_id=0 AND bill_date BETWEEN '2017/01/01' AND '2017/01/31' AND our_product_id='".$PS->id."' and dist_id IN (".$R223->rdist_id.")");
				$S111=mysql_fetch_object($Sales11);
				
				
	?>			
    <td><?php echo round(($MRVALUEPERCENTAGE*$S111->Q/100),0); ?></td>
    <td><?php echo floor($MEDPY->Q*$R223->sales_credit/100); ?></td>
    <td><?php echo $tot+round(($MRVALUEPERCENTAGE*$S111->Q/100),0)+floor($MEDPY->Q*$R223->sales_credit/100); ?></td>
    <td><?php echo round(($tot+round(($MRVALUEPERCENTAGE*$S111->Q/100),2)+round(($MEDPY->Q*$R223->sales_credit/100),2))*$PS->pts,0); ?></td>
    </tr>
<?php } $tot = 0; } ?>
<tr>
	<td>STK TOTAL</td>
    <td></td>
	<?php
	$total = 0;
	$Dist=mysql_query("SELECT `areawise_temp`.dist_id DID,round( sum( `areawise_temp`.quantity * `areawise_temp`.pts ) , 0 ) PTS FROM areawise_temp WHERE dist_id IN (".$STK->D.") and  rep_id IN (15) AND bill_date BETWEEN '2017/01/01' AND '2017/01/31' GROUP BY `areawise_temp`.dist_id ORDER BY `areawise_temp`.dist_id"); // PRODUCT DETAILS	
	while($DTOT=mysql_fetch_object($Dist)){ $total= $total+$DTOT->PTS;
		echo "<td>".$DTOT->PTS."</td>";
	}
	?>
    <td><?=round($MRVALUEPERCENTAGE*$CC->TOT/100,0); ?></td>
    <?php $REPMP = mysql_query("SELECT rep_name,sales_credit FROM representative WHERE id IN (".$_REQUEST["rep_name"].")");$RMP=mysql_fetch_object($REPMP); ?>
    <td><?=round(($common1*$RMP->sales_credit/100),0); ?></td>
    <td>TOT</td>
    <td><?php echo $total+round($MRVALUEPERCENTAGE*$CC->TOT/100,0)+round(($common1*$RMP->sales_credit/100),0); ?></td>
</tr>


</table>