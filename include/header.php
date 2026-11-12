<?php
if(!isset($_SESSION['m_id16']))
	{
	echo "<script type='text/javascript'>window.location='index.php?err'</script>"; 
	}
	else
	{
$ty=mysql_query("select * from admin where id='$id'");
$row_ty=mysql_fetch_array($ty);
$author=$row_ty['authority'];
$uuu_nm=$row_ty['u_name'];
?>
<div class="navbar">
		<div class="navbar-inner">
			<div class="container-fluid">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
                 <?php
				$log=mysql_query("select * from site_conf");
				$row_log=mysql_fetch_array($log);
				$logo_name=$row_log['logo'];
			?>	                
				<!-- <a class="brand" href="#"><img alt="Micandmac" src="logo/<?php echo $logo_name; ?>" /> <span></span></a> -->
				<!-- <a class="brand" href="#"><img alt="ADEC" src="ADEC" /> <span></span></a> -->

				<!-- user dropdown starts -->
				<?php 
				// echo"<pre>";  print_r($_SESSION['m_id16']);exit(); 
				?>
				<div class="btn-group pull-right" >
					<a class="btn dropdown-toggle" data-toggle="dropdown" href="">
						<i class="icon-user"></i><span class="hidden-phone"><?php echo @$_SESSION["CNAME"]; ?></span>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
                    	<li class="divider"></li>
                    	<li><a href="#">Change Password</a></li>
						<li class="divider"></li>
						<li><a href="logout.php">Logout</a></li>
					</ul> 
				</div>
			</div>
		</div>
	</div>
    <?php
	}
	?>