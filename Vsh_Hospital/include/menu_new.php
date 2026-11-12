
<div class="span2 main-menu-span">
<div class="well nav-collapse sidebar-nav">
<ul class="nav nav-tabs nav-stacked main-menu">
<?php
if($_SESSION["STATUS"]!=3){
?>
<li class="nav-header hidden-tablet">DASHBOARD</li>
<li><a class="ajax-link" href="home.php"><i class="icon-home"></i><span class="hidden-tablet">Dashboard</span></a></li>
<?php 
}
	$aaa=mysql_query("select mst_mainmenu.mainmenu_id AS MMID, mst_mainmenu.main_menu AS MMENU from  tbl_previleges, mst_mainmenu where tbl_previleges.role='".$_SESSION["AUTH"]."' AND tbl_previleges.mainmenu_id=mst_mainmenu.mainmenu_id GROUP BY tbl_previleges.mainmenu_id");
	while($row_aaa=mysql_fetch_array($aaa)){
?>
<li class="accordion active"><a href="#"><span><?=$row_aaa["MMENU"]; ?></span></a>
<?php
	$submenu=mysql_query("SELECT mst_submenu.submenu_title AS TITLE,mst_submenu.submenu_icon AS ICON, mst_submenu.submenu_url AS URL FROM tbl_previleges, mst_submenu WHERE  tbl_previleges.mainmenu_id=".$row_aaa["MMID"]." AND tbl_previleges.submenu_id=mst_submenu.submenu_id AND tbl_previleges.role='".$_SESSION["AUTH"]."'");
	while($row=mysql_fetch_array($submenu)){
?>
<li><a class="ajax-link" href="<?=$row["URL"]; ?>"><i class="fa <?=$row['ICON']; ?> fa-lg" style="color:black;"></i><span class="hidden-tablet" style="font-family: Ubuntu,Tahoma,Helvetica Neue,Helvetica,Arial,sans-serif;font-size: 14px"> <?=$row["TITLE"]; ?></span></a></li>                       
<?php }} ?>
</ul>
</li>
</div>
</div>