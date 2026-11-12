		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<style type="text/css">
${demo.css}
		</style>
		<script type="text/javascript">
$(function () {
    $('#product').highcharts({
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45
            }
        },
        title: {
            text: 'TOP 10 PRODUCT'
        },        
        plotOptions: {
            pie: {
                innerSize: 45,
                depth: 25,
				dataLabels: { style:{ fontSize: '8px' }}
			
			}          
				
        },
        series: [{
            name: 'QTY@PTS',
            data: [
				<?php
				$con=mysql_connect("localhost","root","");
					mysql_select_db("lupin",$con);
					
					$product_top = mysql_query("SELECT  product.pro_name AS PNAME, SUM(areawise_temp.quantity) AS QTY, SUM(areawise_temp.quantity*product.pts) AS TOTPTS FROM areawise_temp, product WHERE (areawise_temp.bill_date BETWEEN '2015/04/01' AND '2015/04/30') AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND areawise_temp.our_product_id=product.id AND areawise_temp.state_id=1  GROUP BY areawise_temp.our_product_id ORDER BY TOTPTS DESC LIMIT 0, 10"); $CNT = mysql_num_rows($product_top); while($top_product =mysql_fetch_object($product_top)){ ?>				
				['<?php echo $top_product->PNAME."-".$top_product->QTY;  ?>', <?php echo round($top_product->TOTPTS,2); ?>],
				 <?php } ?>
				           				
            ]
        }]
    });
});
		</script>
	</head>
	<body>

<script src="chart/js/highcharts.js"></script>
<script src="chart/js/highcharts-3d.js"></script>
<script src="chart/js/modules/exporting.js"></script>

<div id="product" style="width:450px;height: 350px;"></div>
	</body>
</html>
