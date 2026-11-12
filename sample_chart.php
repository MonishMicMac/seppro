<script type="text/javascript">
$(function () {
    $('#container_subcat').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'HI'
        },
        
        xAxis: {
            categories: [
			<?php
			for($i=12;$i>=1;$i--){	
			$SQL = mysql_query("select date_add(LAST_DAY(date_add(now(),interval -$i-1 month)), interval 1 day) FirstDay, LAST_DAY(date_add(now(),interval -$i month)) LastDay");				
			while($RS=mysql_fetch_object($SQL)){ echo "'"; echo date("M y",strtotime($RS->FirstDay)); echo "',";} }
			?>
		    ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Sale Value'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: 'PTR',
            data: [
				<?php					
					for($i=12;$i>=1;$i--){	
						$SQL = mysql_query("select date_add(LAST_DAY(date_add(now(),interval -$i-1 month)), interval 1 day) FirstDay, LAST_DAY(date_add(now(),interval -$i month)) LastDay");
						while($RS=mysql_fetch_object($SQL)){
							$Sales = mysql_query("SELECT SUM(areawise_temp.quantity*product.ptr) AS TOTPTR, SUM(areawise_temp.quantity*product.pts) AS TOTPTS FROM areawise_temp, product WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($RS->FirstDay))."' AND '".date("Y/m/d",strtotime($RS->LastDay))."') AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND areawise_temp.our_product_id=product.id AND areawise_temp.rep_id='".$_SESSION["_REP"]."'");  $Rs_Sales=mysql_fetch_array($Sales); echo round($Rs_Sales["TOTPTR"],2).",";
						}	
					}
				?>		
			]

        }, {
            name: 'PTS',
            data: [
				<?php
					for($i=12;$i>=1;$i--){	
						$SQL = mysql_query("select date_add(LAST_DAY(date_add(now(),interval -$i-1 month)), interval 1 day) FirstDay, LAST_DAY(date_add(now(),interval -$i month)) LastDay");
						while($RS=mysql_fetch_object($SQL)){
							$Sales = mysql_query("SELECT SUM(areawise_temp.quantity*product.ptr) AS TOTPTR, SUM(areawise_temp.quantity*product.pts) AS TOTPTS FROM areawise_temp, product WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($RS->FirstDay))."' AND '".date("Y/m/d",strtotime($RS->LastDay))."') AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND areawise_temp.our_product_id=product.id AND areawise_temp.rep_id='".$_SESSION["_REP"]."'");  $Rs_Sales=mysql_fetch_array($Sales); echo round($Rs_Sales["TOTPTS"],2).",";
						}	
					}
				?>
			]

        }]
    });
});
		</script>
        <div id="container_subcat" style="min-width: 310px; height: 400px; margin: 0 auto; margin-top:100px;"></div>