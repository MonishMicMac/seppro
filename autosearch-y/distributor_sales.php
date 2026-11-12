<?php
include("connect_db.php");
$link = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("Couldn't make connection.");
$db = mysql_select_db(DB_NAME, $link) or die("Couldn't select database");
if(isset($_GET["dist_id"])){			
		$SQL=mysql_query("SELECT * FROM areawise_temp WHERE dist_id = '".$_GET["distributor_id"]."' AND bill_string = '".$_GET["month"]."'");
		$DIST=mysql_num_rows($SQL);
		$TOTAL=mysql_query("SELECT SUM(areawise_temp.quantity) Q,SUM(free_quantity) F,SUM(replace_quantity) R,round(SUM(product.ptr*areawise_temp.quantity),2) PTR,round(SUM(product.pts*areawise_temp.quantity),2) PTS FROM areawise_temp,product WHERE areawise_temp.our_product_id=product.id AND areawise_temp.dist_id = '".$_GET["distributor_id"]."' AND areawise_temp.bill_string = '".$_GET["month"]."'");
		$TOT=mysql_fetch_object($TOTAL);
		if($DIST>0){		
			echo "<h3 style=\"color:#0066FF;text-align:center\">DATA ALREADY UPLOADED FOR SELECTED MONTH - REFER DISTRIBUTOR COVERED / UNCOVERED REPORT</h3> <h4> TOTAL SALE RECORD : ".$DIST."</h4>";		
			echo "<div style=\"margin:5px;float:right;clear:0 both;\"><span class=\"btn btn-primary\">Q : ".$TOT->Q."</span> <span class=\"btn btn-success\">F : ".$TOT->F."</span> <span class=\"btn btn-primary\">R : ".$TOT->R."</span> <span class=\"btn btn-success\">PTR : ".$TOT->PTR."</span> <span class=\"btn btn-primary\">PTS : ".$TOT->PTS."</span></div>";		
		}
		if($DIST==0){		
			echo "<h2 style=\"color:#0066FF;\">DATA NOT AVAILABLE</h2>";		
		}
	}if(isset($_GET["Customer"])){			
		$SQL=mysql_query("SELECT * FROM areawise_temp WHERE dist_id = '".$_GET["distributor_id"]."' AND bill_string = '".$_GET["month"]."'");
		$DIST=mysql_num_rows($SQL);
		if($DIST>0){
			$Y=1;		
			echo "<table class=\"table table-striped table-bordered bootstrap-datatable datatable\"><thead><tr style=\"text-align:center\"><th style=\"text-align:center\">SL.NO</th><th style=\"text-align:center\">CUSTOMER</th><th style=\"text-align:center\">PRODUCT</th><th style=\"text-align:center\">PINCODE</th><th style=\"text-align:center\">BILL DATE</th><th style=\"text-align:center\">Q</th><th style=\"text-align:center\">F</th><th style=\"text-align:center\">R</th></tr></thead><tbody>";
			while($D=mysql_fetch_object($SQL)){echo "<tr><td style=\"text-align:center\">$Y</td><td>".$D->cust_name."</td><td>".$D->pro_name."</td><td style=\"text-align:center\">".$D->pincode."</td><td style=\"text-align:right\">".date("d/m/Y",strtotime($D->bill_date))."</td><td style=\"text-align:center\">".$D->quantity."</td><td style=\"text-align:center\">".$D->free_quantity."</td><td style=\"text-align:center\">".$D->replace_quantity."</td></tr>";$Y++;}
			echo "</tbody></table>";
		}
	}if(isset($_GET["Product"])){			
		$SQL=mysql_query("SELECT * FROM areawise_temp WHERE dist_id = '".$_GET["distributor_id"]."' AND bill_string = '".$_GET["month"]."'");
		$DIST=mysql_num_rows($SQL);
		if($DIST>0){
			$Y=1;		
			echo "<table class=\"table table-striped table-bordered bootstrap-datatable datatable\"><thead><tr style=\"text-align:center\"><th style=\"text-align:center\">SL.NO</th><th style=\"text-align:center\">PRODUCT</th><th style=\"text-align:center\">BILL DATE</th><th style=\"text-align:center\">CUSTOMER</th><th style=\"text-align:center\">PINCODE</th><th style=\"text-align:center\">Q</th><th style=\"text-align:center\">F</th><th style=\"text-align:center\">R</th></tr></thead><tbody>";
			while($D=mysql_fetch_object($SQL)){echo "<tr><td style=\"text-align:center\">$Y</td><td>".$D->pro_name."</td><td style=\"text-align:right\">".date("d/m/Y",strtotime($D->bill_date))."</td><td>".$D->cust_name."</td><td style=\"text-align:center\">".$D->pincode."</td><td style=\"text-align:center\">".$D->quantity."</td><td style=\"text-align:center\">".$D->free_quantity."</td><td style=\"text-align:center\">".$D->replace_quantity."</td></tr>";$Y++;}
			echo "</tbody></table>";
		}
	}if(isset($_GET["Distributor"])){
		$SQL=mysql_query("DELETE FROM areawise_temp WHERE dist_id = '".$_GET["distributor_id"]."' AND bill_string = '".$_GET["month"]."'");
		echo "<h2 style=\"color:#0066FF;\">DISTRIBUTOR DATA DELETED SUCCESSFULLY...</h2>";
	}
?>