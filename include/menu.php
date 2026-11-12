<div class="span2 main-menu-span">
<div class="well nav-collapse sidebar-nav">
<ul class="nav nav-tabs nav-stacked main-menu">
	<?php
	if($_SESSION["STATUS"]!=3){
		?>
		<!-- <li class="nav-header hidden-tablet">DASHBOARD</li>
		<li><a class="ajax-link" href="home.php"><i class="icon-eye-open"></i><span class="hidden-tablet">Dashboard</span></a></li> -->
		<?php 
	}
	if($_SESSION["CID"]=='SEP1053')
	{
			
				$aaa=mysql_query("select mst_mainmenu.mainmenu_id AS MMID, mst_mainmenu.main_menu AS MMENU from  tbl_previleges, mst_mainmenu where tbl_previleges.role='".$_SESSION["AUTH"]."' AND tbl_previleges.mainmenu_id=mst_mainmenu.mainmenu_id AND tbl_previleges.user_group_id='".@$_SESSION["user"]."' GROUP BY tbl_previleges.mainmenu_id");
	}
	elseif($_SESSION["AUTH"]=='1')
	{
// print_r($_SESSION["user"]);exit();

			
				$aaa=mysql_query("select mst_mainmenu.mainmenu_id AS MMID, mst_mainmenu.main_menu AS MMENU from  tbl_previleges, mst_mainmenu where tbl_previleges.tit='".$_SESSION["AUTH"]."' AND tbl_previleges.mainmenu_id=mst_mainmenu.mainmenu_id AND tbl_previleges.user_group_id='".@$_SESSION["user"]."' GROUP BY tbl_previleges.mainmenu_id");
	}
	
	elseif($_SESSION["CID"]=='SEP1080' && $_SESSION["nurse_login"]=='1' ){

		$aaa=mysql_query("select mst_mainmenu.mainmenu_id AS MMID, mst_mainmenu.main_menu AS MMENU 
		from  tbl_previleges, mst_mainmenu 
		where tbl_previleges.role='".$_SESSION["AUTH"]."' AND tbl_previleges.mainmenu_id=mst_mainmenu.mainmenu_id 
		AND mst_mainmenu.rep_login='1'
		GROUP BY tbl_previleges.mainmenu_id");

	}
	else
	{
		// print_r($_SESSION);exit();
$aaa=mysql_query("select mst_mainmenu.mainmenu_id AS MMID, mst_mainmenu.main_menu AS MMENU from  tbl_previleges, mst_mainmenu where tbl_previleges.role='".$_SESSION["AUTH"]."' AND tbl_previleges.mainmenu_id=mst_mainmenu.mainmenu_id GROUP BY tbl_previleges.mainmenu_id");
	}
	
	while($row_aaa=mysql_fetch_array($aaa)){
		?>
		<li class="nav-header hidden-tablet"><?=$row_aaa["MMENU"]; ?></li>
		<?php
		if($_SESSION["CID"]=='SEP1053')
		{
				$submenu=mysql_query("SELECT mst_submenu.submenu_title AS TITLE, mst_submenu.submenu_url AS URL FROM tbl_previleges, mst_submenu WHERE  tbl_previleges.mainmenu_id=".$row_aaa["MMID"]." AND tbl_previleges.submenu_id=mst_submenu.submenu_id AND tbl_previleges.role='".$_SESSION["AUTH"]."' AND tbl_previleges.user_group_id='".@$_SESSION["user"]."'");
		}
		elseif($_SESSION["AUTH"]=='1')
		{
				$submenu=mysql_query("SELECT mst_submenu.submenu_title AS TITLE, mst_submenu.submenu_url AS URL FROM tbl_previleges, mst_submenu WHERE  tbl_previleges.mainmenu_id=".$row_aaa["MMID"]." AND tbl_previleges.submenu_id=mst_submenu.submenu_id AND tbl_previleges.tit='".$_SESSION["AUTH"]."' AND tbl_previleges.user_group_id='".@$_SESSION["user"]."'");
		}
		elseif($_SESSION["CID"]=='SEP1080' && $_SESSION["nurse_login"]=='1' ){

			$submenu=mysql_query("SELECT mst_submenu.submenu_title AS TITLE, mst_submenu.submenu_url AS URL FROM tbl_previleges, mst_submenu
			WHERE  tbl_previleges.mainmenu_id=".$row_aaa["MMID"]." AND tbl_previleges.submenu_id=mst_submenu.submenu_id AND tbl_previleges.role='".$_SESSION["AUTH"]."'
			AND mst_submenu.rep_login='1'
			");
	
		}
		else
		{
		// print_r($row_aaa["MMID"]);exit();

			$submenu=mysql_query("SELECT mst_submenu.submenu_title AS TITLE, mst_submenu.submenu_url AS URL FROM tbl_previleges, mst_submenu
			WHERE  tbl_previleges.mainmenu_id=".$row_aaa["MMID"]." AND tbl_previleges.submenu_id=mst_submenu.submenu_id AND tbl_previleges.role='".$_SESSION["AUTH"]."'");
		}

		while($row=mysql_fetch_array($submenu)){
			?>
			<li><a class="ajax-link" href="<?=$row["URL"]; ?>"><i class="icon-eye-open"></i><span class="hidden-tablet"> <?=$row["TITLE"]; ?></span></a></li>                       
			<?php 
		}
	} 
?>
</ul>
</div>
</div>