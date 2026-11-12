  <?php
		  include "../libchart1/classes/libchart.php";
	$chart = new PieChart();
	$dataSet = new XYDataSet();

$aa=mysql_query("select DISTINCT  our_id,SUM(net_amount)  from areawise_temp  GROUP BY our_id order by SUM(net_amount) desc limit 0,10");
$count_aa=mysql_num_rows($aa);
if($count_aa>0)
{
while($row_aa=mysql_fetch_array($aa))
{
$pro_id=$row_aa['our_id'];
$cc=mysql_query("select * from product where  id='$pro_id'");
/*$count_cc=mysql_num_rows($cc);
if($count_cc>0)
{*/
$row_cc=mysql_fetch_array($cc);
$pro=$row_cc['pro_name'];
$pro_sum=$row_aa['SUM(net_amount)'];
$dataSet->addPoint(new Point("$pro", $ss));
/*}*/
}
}
$chart->setDataSet($dataSet);
	$chart->setTitle("Top 10 Area in Pie Chart");
	$chart->render("generated/demo3.png");
?>
     <img alt="Pie chart"  src="generated/demo3.png" style="border: 1px solid gray;"/>	   