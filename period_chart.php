<?php $conn = mysql_connect("localhost","root",""); mysql_select_db("lupin"); ?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Highcharts Example</title>

		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<style type="text/css">
${demo.css}
		</style>
		<script type="text/javascript">
$(function () {
    $('#product_pts').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'PRODUCT PTS COMPARSION REPORT'
        },
        xAxis: {
            categories: [
			<?php $PRODUCT = mysql_query("SELECT pro_name FROM product"); while($RS_PRODUCT=mysql_fetch_object($PRODUCT)){ echo "'".$RS_PRODUCT->pro_name."',";} ?>
            ]
        },
        yAxis: [{
            min: 0,
            title: {
                text: 'PTS'
            }
        }, {
            title: {
                text: ''
            },
            opposite: false
        }],
        legend: {
            shadow: false
        },
        tooltip: {
            shared: true
        },
        plotOptions: {
            column: {
                grouping: false,
                shadow: false,
                borderWidth: 0
            }
        },
        series: [{
            name: '01 - 15 JUNE 2015',
            color: 'rgba(165,170,217,1)',
            data: [
			<?php $PRODUCT = mysql_query("SELECT SUM(areawise_temp.quantity*product.pts) AS TOTPTS FROM areawise_temp, product WHERE (areawise_temp.bill_date BETWEEN '2015/07/01' AND '2015/07/15') AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND areawise_temp.our_product_id=product.id AND areawise_temp.state_id=1 GROUP BY our_product_id  ORDER BY TOTPTS DESC"); while($RS_PRODUCT=mysql_fetch_object($PRODUCT)){ echo  $RS_PRODUCT->TOTPTS.",";} ?>
			],
            pointPadding: 0.3,
            pointPlacement: -0.2
        }, {
            name: '16 - 30 JUNE 2015',
            color: 'rgba(126,86,134,.9)',
            data: [<?php $PRODUCT = mysql_query("SELECT SUM(areawise_temp.quantity*product.pts) AS TOTPTS FROM areawise_temp, product WHERE (areawise_temp.bill_date BETWEEN '2015/07/16' AND '2015/07/30') AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND areawise_temp.our_product_id=product.id AND areawise_temp.state_id=1 GROUP BY our_product_id ORDER BY TOTPTS DESC "); while($RS_PRODUCT=mysql_fetch_object($PRODUCT)){ echo $RS_PRODUCT->TOTPTS.",";} ?>],
            pointPadding: 0.4,
            pointPlacement: -0.2
        }]
    });
});
		</script>
	</head>
	<body>
<script src="chart/js/highcharts.js"></script>

<div id="product_pts" style="min-width: 400px; height: 400px; margin: 0 auto"></div>

	</body>
</html>