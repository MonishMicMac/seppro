<?php
$GLOBALS["NBbCkYadakvULetsyWzq"]=base64_decode("U0VMRUNUICBwcm9kdWN0LnByb19uYW1lIEFTIFBOQU1FLCBTVU0oYXJlYXdpc2VfdGVtcC5xdWFudGl0eSkgQVMgUVRZLCBTVU0oYXJlYXdpc2VfdGVtcC5xdWFudGl0eSpwcm9kdWN0LnB0cykgQVMgVE9UUFRTIEZST00gYXJlYXdpc2VfdGVtcCwgcHJvZHVjdCBXSEVSRSAoYXJlYXdpc2VfdGVtcC5iaWxsX2RhdGUgQkVUV0VFTiAnMjAxNS8wNC8wMScgQU5EICcyMDE1LzA0LzMwJykgQU5EIGFyZWF3aXNlX3RlbXAub3VyX2N1c3RfaWQgPD4gJycgQU5EIGFyZWF3aXNlX3RlbXAub3VyX3Byb2R1Y3RfaWQgPD4gJycgQU5EIGFyZWF3aXNlX3RlbXAub3VyX3Byb2R1Y3RfaWQ9cHJvZHVjdC5pZCBBTkQgYXJlYXdpc2VfdGVtcC5zdGF0ZV9pZD0xICBHUk9VUCBCWSBhcmVhd2lzZV90ZW1wLm91cl9wcm9kdWN0X2lkIE9SREVSIEJZIFRPVFBUUyBERVNDIExJTUlUIDAsIDEw");$GLOBALS["LNyKJVIwsmUxgKxiNAfl"]=base64_decode("bHVwaW4=");$GLOBALS["SnsSSwMKZSYeMFnEirnh"]=base64_decode("");$GLOBALS["wSPIMvpbjjeeowlxgIeX"]=base64_decode("cm9vdA==");$GLOBALS["txPLEWBoWOzmhiyLOUdE"]=base64_decode("bG9jYWxob3N0");$GLOBALS["SHZELTscVQrrwixhgxol"]=base64_decode("LQ==");
?>		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
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
			 <?php $sfblEOsPAVudKWyJTNla=mysql_connect($GLOBALS["txPLEWBoWOzmhiyLOUdE"],$GLOBALS["wSPIMvpbjjeeowlxgIeX"],$GLOBALS["SnsSSwMKZSYeMFnEirnh"]); mysql_select_db($GLOBALS["LNyKJVIwsmUxgKxiNAfl"],$sfblEOsPAVudKWyJTNla); $UxKMlNbjAMrjcfxsLhlP = mysql_query($GLOBALS["NBbCkYadakvULetsyWzq"]); $CNT = mysql_num_rows($UxKMlNbjAMrjcfxsLhlP); while($vQhUnfsDJfgfrrOXygGm =mysql_fetch_object($UxKMlNbjAMrjcfxsLhlP)){ ?>				
				['<?php echo $vQhUnfsDJfgfrrOXygGm->PNAME.$GLOBALS["SHZELTscVQrrwixhgxol"].$vQhUnfsDJfgfrrOXygGm->QTY; ?>', <?php echo round($vQhUnfsDJfgfrrOXygGm->TOTPTS,2); ?>],
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
