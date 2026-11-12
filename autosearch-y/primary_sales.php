<?php
include("connect_db.php");
$link = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("Couldn't make connection.");
$db = mysql_select_db(DB_NAME, $link) or die("Couldn't select database");


if(isset($_GET["dist_id"])){			

		//$SQL=mysql_query("SELECT id FROM primary_sales WHERE distributor_id = '".$_GET["distributor_id"]."' AND bill_string = '".$_GET["month"]."' and division_id='".@$_REQUEST["division_id"]."'");

		$SQL=mysql_query("SELECT id FROM primary_sales WHERE distributor_id = '".$_GET["distributor_id"]."' AND bill_string = '".$_GET["month"]."'");
		$DIST=mysql_num_rows($SQL);
		
		//$TOTAL=mysql_query("select b.dis_name as distributor_name,a.distributor_id as distID ,sum(a.opening_stock*d.ptr) as opening_stock, sum(a.purchase*d.ptr) as purchase, sum(a.sale*d.ptr) as sale, (sum(a.opening_stock*d.ptr)+sum(a.purchase*d.ptr))-sum(a.sale*d.ptr) as closing_stock from primary_sales a left join distributor b on a.distributor_id=b.dis_id left join dist_prod c on a.distributor_product_id=c.id left join product d on d.id=c.our_id where a.distributor_id = '".$_GET["distributor_id"]."' AND a.bill_string='".@$_REQUEST["month"]."' and a.division_id='".@$_REQUEST["division_id"]."'");

		$TOTAL=mysql_query("select sum(a.opening_stock*d.ptr) as opening_stock, sum(a.purchase*d.ptr) as purchase, sum(a.sale*d.ptr) as sale, (sum(a.opening_stock*d.ptr)+sum(a.purchase*d.ptr))-sum(a.sale*d.ptr) as closing_stock from primary_sales a left join distributor b on a.distributor_id=b.dis_id left join dist_prod c on a.distributor_product_id=c.id left join product d on d.id=c.our_id left join mst_division e on e.division_id=a.division_id where a.distributor_id = '".$_GET["distributor_id"]."' AND a.bill_string='".@$_REQUEST["month"]."'");
		$TOT=mysql_fetch_object($TOTAL);
		if($DIST>0){
			echo "<h3 style=\"color:#0066FF;text-align:center\">DATA ALREADY UPLOADED FOR SELECTED MONTH</h3> <h4> TOTAL SALE RECORD : ".$DIST."</h4>";		
			echo "<div style=\"margin:5px;float:right;clear:0 both;\"><span class=\"btn btn-primary\">Opening Value : ".number_format($TOT->opening_stock,2)."</span> <span class=\"btn btn-success\">Purchase Value : ".number_format($TOT->purchase,2)."</span> <span class=\"btn btn-primary\">Sale Value : ".number_format($TOT->sale,2)."</span> <span class=\"btn btn-success\">Closing Value : ".number_format($TOT->closing_stock,2)."</span></div>";		
		}
		if($DIST==0){		
			echo "<h2 style=\"color:#0066FF;\">DATA NOT AVAILABLE</h2>";		
		}
	}






	if(isset($_GET["Customer"])){

		//$SQL=mysql_query("SELECT c.pro_name, a.opening_stock, a.purchase, a.sale, damage FROM primary_sales a left join dist_prod c on a.distributor_product_id=c.id WHERE a.distributor_id = '".$_GET["distributor_id"]."' AND a.bill_string = '".$_GET["month"]."' and a.division_id='".@$_REQUEST["division_id"]."'");

		$SQL=mysql_query("SELECT e.division_name as division_name, c.pro_name, a.opening_stock, a.purchase, a.sale, damage FROM primary_sales a left join dist_prod c on a.distributor_product_id=c.id left join mst_division e on e.division_id=a.division_id WHERE a.distributor_id = '".$_GET["distributor_id"]."' AND a.bill_string = '".$_GET["month"]."'");
		$DIST=mysql_num_rows($SQL);
		if($DIST>0){
			$Y=1;		

			//echo "<table class=\"table table-striped table-bordered bootstrap-datatable datatable\"><thead><tr style=\"text-align:center\"><th style=\"text-align:center\">S.No</th><th style=\"text-align:center\">Product</th><th style=\"text-align:center\">Opening Stock</th><th style=\"text-align:center\">Purchase</th><th style=\"text-align:center\">Sale</th></tr></thead><tbody>";

			echo "<table class=\"table table-striped table-bordered bootstrap-datatable datatable\"><thead><tr style=\"text-align:center\"><th style=\"text-align:center\">S.No</th><th style=\"text-align:center\">Product</th><th style=\"text-align:center\">Opening Stock</th><th style=\"text-align:center\">Purchase</th><th style=\"text-align:center\">Sale</th></tr></thead><tbody>";

			//while($D=mysql_fetch_object($SQL)){echo "<tr><td style=\"text-align:center\">$Y</td><td>".$D->pro_name."</td><td>".$D->opening_stock."</td><td style=\"text-align:center\">".$D->purchase."</td><td style=\"text-align:right\">".$D->sale."</td></tr>";$Y++;}

			while($D=mysql_fetch_object($SQL)){echo "<tr><td style=\"text-align:center\">$Y</td>
				
			<td>".$D->pro_name."</td><td>".$D->opening_stock."</td><td style=\"text-align:center\">".$D->purchase."</td><td style=\"text-align:right\">".$D->sale."</td></tr>";$Y++;}
			echo "</tbody></table>";
		}
	}






/*
	if(isset($_GET["Product"])){			
		$SQL=mysql_query("SELECT * FROM areawise_temp WHERE dist_id = '".$_GET["distributor_id"]."' AND bill_string = '".$_GET["month"]."'");
		$DIST=mysql_num_rows($SQL);
		if($DIST>0){
			$Y=1;		
			echo "<table class=\"table table-striped table-bordered bootstrap-datatable datatable\"><thead><tr style=\"text-align:center\"><th style=\"text-align:center\">SL.NO</th><th style=\"text-align:center\">PRODUCT</th><th style=\"text-align:center\">BILL DATE</th><th style=\"text-align:center\">CUSTOMER</th><th style=\"text-align:center\">PINCODE</th><th style=\"text-align:center\">Q</th><th style=\"text-align:center\">F</th><th style=\"text-align:center\">R</th></tr></thead><tbody>";
			while($D=mysql_fetch_object($SQL)){echo "<tr><td style=\"text-align:center\">$Y</td><td>".$D->pro_name."</td><td style=\"text-align:right\">".date("d/m/Y",strtotime($D->bill_date))."</td><td>".$D->cust_name."</td><td style=\"text-align:center\">".$D->pincode."</td><td style=\"text-align:center\">".$D->quantity."</td><td style=\"text-align:center\">".$D->free_quantity."</td><td style=\"text-align:center\">".$D->replace_quantity."</td></tr>";$Y++;}
			echo "</tbody></table>";
		}
	}
*/

	if(isset($_GET["Distributor"])){

		//$SQL=mysql_query("DELETE FROM primary_sales WHERE distributor_id = '".$_GET["distributor_id"]."' AND bill_string = '".$_GET["month"]."' and division_id='".@$_REQUEST["division_id"]."'");

		$SQL=mysql_query("DELETE FROM primary_sales WHERE distributor_id = '".$_GET["distributor_id"]."' AND bill_string = '".$_GET["month"]."'");
		echo "<h2 style=\"color:#0066FF;\">DISTRIBUTOR DATA DELETED SUCCESSFULLY...</h2>";
	}
?>