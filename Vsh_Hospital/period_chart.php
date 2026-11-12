<?php
$GLOBALS["LNyKJVIwsmUxgKxiNAfl"]=base64_decode("bHVwaW4=");$GLOBALS["SnsSSwMKZSYeMFnEirnh"]=base64_decode("");$GLOBALS["wSPIMvpbjjeeowlxgIeX"]=base64_decode("cm9vdA==");$GLOBALS["txPLEWBoWOzmhiyLOUdE"]=base64_decode("bG9jYWxob3N0");$GLOBALS["QlZOmMfQsxYYJViWzkmw"]=base64_decode("Jyw=");$GLOBALS["CGbFgRIFcNnyLvvmfknU"]=base64_decode("Jw==");$GLOBALS["uFsqElrvExrDxyQMcYZQ"]=base64_decode("U0VMRUNUIHByb19uYW1lIEZST00gcHJvZHVjdA==");$GLOBALS["tubXbwMgKTUGPeKAmqCF"]=base64_decode("LA==");$GLOBALS["nYkkVbfgOGMDlhdKpyBC"]=base64_decode("U0VMRUNUIFNVTShhcmVhd2lzZV90ZW1wLnF1YW50aXR5KnByb2R1Y3QucHRzKSBBUyBUT1RQVFMgRlJPTSBhcmVhd2lzZV90ZW1wLCBwcm9kdWN0IFdIRVJFIChhcmVhd2lzZV90ZW1wLmJpbGxfZGF0ZSBCRVRXRUVOICcyMDE1LzA3LzAxJyBBTkQgJzIwMTUvMDcvMTUnKSBBTkQgYXJlYXdpc2VfdGVtcC5vdXJfY3VzdF9pZCA8PiAnJyBBTkQgYXJlYXdpc2VfdGVtcC5vdXJfcHJvZHVjdF9pZCA8PiAnJyBBTkQgYXJlYXdpc2VfdGVtcC5vdXJfcHJvZHVjdF9pZD1wcm9kdWN0LmlkIEFORCBhcmVhd2lzZV90ZW1wLnN0YXRlX2lkPTEgR1JPVVAgQlkgb3VyX3Byb2R1Y3RfaWQgIE9SREVSIEJZIFRPVFBUUyBERVND");$GLOBALS["tubXbwMgKTUGPeKAmqCF"]=base64_decode("LA==");$GLOBALS["CWSqamAiumExBZEenuEE"]=base64_decode("U0VMRUNUIFNVTShhcmVhd2lzZV90ZW1wLnF1YW50aXR5KnByb2R1Y3QucHRzKSBBUyBUT1RQVFMgRlJPTSBhcmVhd2lzZV90ZW1wLCBwcm9kdWN0IFdIRVJFIChhcmVhd2lzZV90ZW1wLmJpbGxfZGF0ZSBCRVRXRUVOICcyMDE1LzA3LzE2JyBBTkQgJzIwMTUvMDcvMzAnKSBBTkQgYXJlYXdpc2VfdGVtcC5vdXJfY3VzdF9pZCA8PiAnJyBBTkQgYXJlYXdpc2VfdGVtcC5vdXJfcHJvZHVjdF9pZCA8PiAnJyBBTkQgYXJlYXdpc2VfdGVtcC5vdXJfcHJvZHVjdF9pZD1wcm9kdWN0LmlkIEFORCBhcmVhd2lzZV90ZW1wLnN0YXRlX2lkPTEgR1JPVVAgQlkgb3VyX3Byb2R1Y3RfaWQgT1JERVIgQlkgVE9UUFRTIERFU0Mg");
?><?php $OQijXfnrxWxPIcPSUibK = mysql_connect($GLOBALS["txPLEWBoWOzmhiyLOUdE"],$GLOBALS["wSPIMvpbjjeeowlxgIeX"],$GLOBALS["SnsSSwMKZSYeMFnEirnh"]); mysql_select_db($GLOBALS["LNyKJVIwsmUxgKxiNAfl"]); ?>
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
		 <?php $PRODUCT = mysql_query($GLOBALS["uFsqElrvExrDxyQMcYZQ"]); while($nsoqJGfMwnclUhwDcJoV=mysql_fetch_object($PRODUCT)){ echo $GLOBALS["CGbFgRIFcNnyLvvmfknU"].$nsoqJGfMwnclUhwDcJoV->pro_name.$GLOBALS["QlZOmMfQsxYYJViWzkmw"];} ?>
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
		 <?php $PRODUCT = mysql_query($GLOBALS["nYkkVbfgOGMDlhdKpyBC"]); while($nsoqJGfMwnclUhwDcJoV=mysql_fetch_object($PRODUCT)){ echo $nsoqJGfMwnclUhwDcJoV->TOTPTS.$GLOBALS["tubXbwMgKTUGPeKAmqCF"];} ?>
			],
            pointPadding: 0.3,
            pointPlacement: -0.2
        }, {
            name: '16 - 30 JUNE 2015',
            color: 'rgba(126,86,134,.9)',
            data: [<?php $PRODUCT = mysql_query($GLOBALS["CWSqamAiumExBZEenuEE"]); while($nsoqJGfMwnclUhwDcJoV=mysql_fetch_object($PRODUCT)){ echo $nsoqJGfMwnclUhwDcJoV->TOTPTS.$GLOBALS["tubXbwMgKTUGPeKAmqCF"];} ?>],
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