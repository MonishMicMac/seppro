<?php
include("include/connect.php");
session_start();
$id=$_SESSION['id'];
unset($_SESSION['id']);
session_destroy();
?>
<html>
<head>
<script type="text/javascript">
function LoadMe()
{
if(top!=self)
{
top.location=self.location;
}
location.href = "index.php"
}
</script>

</head>
<body onLoad="LoadMe()">

</body>
</html>