<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script src="chart/js/highcharts.js"></script>
    <script src="chart/js/highcharts-3d.js"></script>
<script type="text/javascript">
$(function () {
    $('#container').highcharts({
        chart: {
            type: 'column',
        },
        title: {
            text: 'Month Wise Sales comparison Chart'
        },
        
        xAxis: {
            categories: [
			<?php
				
				$SQL = mysql_query("SELECT rep_name FROM representative");				
				while($RS=mysql_fetch_object($SQL)){ echo "'"; echo $RS->rep_name; echo "',";}
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
            headerFormat: '<span style="font-size:12px">{point.key}</span><table>',
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
            },
			series: {
              cursor: 'pointer',
              point: {
                events: {
                 click: function() {//alert ('Category: '+ this.category +', value: '+ this.y);	
					 draw_cat_chart(this.category);
					 yuvi(this.category);					 
					 $("#REP").load("sample_chart.php");					 				 			 
                 }
				 
                }
              }
           }
        },
		
        series: [{
            name: 'PTR',
            data: [
				<?php					
					
						$SQL = mysql_query("select date_add(LAST_DAY(date_add(now(),interval -3 month)), interval 1 day) FirstDay, LAST_DAY(date_add(now(),interval -2 month)) LastDay");
						$RS=mysql_fetch_object($SQL);
							$Sales = mysql_query("SELECT SUM(areawise_temp.quantity*product.ptr) AS TOTPTR FROM areawise_temp, product,representative WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($RS->FirstDay))."' AND '".date("Y/m/d",strtotime($RS->LastDay))."') AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND areawise_temp.our_product_id=product.id AND representative.id=areawise_temp.rep_id GROUP BY areawise_temp.rep_id ORDER BY areawise_temp.rep_id ");  while($Rs_Sales=mysql_fetch_array($Sales)){ echo round($Rs_Sales["TOTPTR"],2).","; }	
					
				?>			
			]

        }, {
            name: 'PTS',
            data: [
				<?php					
					
						$SQL = mysql_query("select date_add(LAST_DAY(date_add(now(),interval -3 month)), interval 1 day) FirstDay, LAST_DAY(date_add(now(),interval -2 month)) LastDay");
						$RS=mysql_fetch_object($SQL);
							$Sales = mysql_query("SELECT SUM(areawise_temp.quantity*product.pts) AS TOTPTS FROM areawise_temp, product,representative WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($RS->FirstDay))."' AND '".date("Y/m/d",strtotime($RS->LastDay))."') AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND areawise_temp.our_product_id=product.id AND representative.id=areawise_temp.rep_id GROUP BY areawise_temp.rep_id ORDER BY areawise_temp.rep_id ");  while($Rs_Sales=mysql_fetch_array($Sales)){ echo round($Rs_Sales["TOTPTS"],2).","; }	
					
				?>	
			]

        }]
    });
});
</script>
<div id="container" style="width: 980px; height: 300px; margin: 0 auto"></div>