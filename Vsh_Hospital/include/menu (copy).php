<div class="span2 main-menu-span">
	<div class="well nav-collapse sidebar-nav">
		<ul class="nav nav-tabs nav-stacked main-menu">
			<div class="accordion" id="accordion<?php echo $main; ?>" style="line-height: 20%">
				<div class="accordion-group">
					<?php
					$page_name=basename($_SERVER['PHP_SELF']); 
					if($_SESSION["STATUS"]!=3){

						?>
						<div class="accordion-heading" style="border: 1px solid #bbbaba;">
							<li class="">
								<a class="accordion-toggle" style="text-decoration: none;" data-toggle="collapse" data-parent="#accordion222" href="#collapseOne"><span>Home</span></a>
							</li>
						</div>

						<div id="collapseOne" class="accordion-body collapse" style="background-color: #f4f7fa;">
							<div class="accordion-inner">
								<li>
									<a class="ajax-link" href="primary_home_new.php"><span class="hidden-tablet" style="color: black;">Primary Dashboard</span></a>
								</li>
							</div>
							<div class="accordion-inner">
								<li><a class="ajax-link" href="home.php"><span class="hidden-tablet" style="color: black;">Standard Dashboard</span></a></li>
							</div>
						</div>
						<?php
					}
					?>

					<?php 
					$main=0;
					$aaa=mysql_query("select mst_mainmenu.mainmenu_id AS MMID, mst_mainmenu.main_menu AS MMENU from  tbl_previleges, mst_mainmenu where tbl_previleges.user_group_id='".$_SESSION["user_group"]."' AND tbl_previleges.mainmenu_id=mst_mainmenu.mainmenu_id GROUP BY tbl_previleges.mainmenu_id");
					while($row_aaa=mysql_fetch_array($aaa)){
						?>
						<div class="accordion-heading" style="border: 1px solid #bbbaba;">
							<li class="">
								<a class="accordion-toggle" style="text-decoration: none;" data-toggle="collapse" data-parent="#accordion<?php echo $main; ?>" href="#collapse<?php echo $main; ?>"><span><?php echo ucwords(strtoupper($row_aaa["MMENU"])); ?></span></a>
							</li>
						</div>
						<?php
						$submenus=mysql_query("SELECT mst_submenu.submenu_url AS URL FROM tbl_previleges, mst_submenu WHERE  tbl_previleges.mainmenu_id=".$row_aaa["MMID"]." AND tbl_previleges.submenu_id=mst_submenu.submenu_id AND tbl_previleges.user_group_id='".$_SESSION["user_group"]."'");
						$rows=mysql_fetch_array($submenus);
						$url=$rows['URL'];
						?>
						<div id="collapse<?php echo $main; ?>" class="accordion-body collapse <?php echo $page_name; echo $url; if($page_name==$url) { echo 'in'; } ?>" style="background-color: #f4f7fa;">
							<?php
							$submenu=mysql_query("SELECT mst_submenu.submenu_title AS TITLE, mst_submenu.submenu_url AS URL FROM tbl_previleges, mst_submenu WHERE  tbl_previleges.mainmenu_id=".$row_aaa["MMID"]." AND tbl_previleges.submenu_id=mst_submenu.submenu_id AND tbl_previleges.user_group_id='".$_SESSION["user_group"]."' GROUP BY tbl_previleges.submenu_id");
							while($row=mysql_fetch_array($submenu)){
								?>

								<div class="accordion-inner <?php if($page_name==$row['URL']) { echo 'liactive'; } ?>">
									<a class="active" style="text-decoration: none;" href="<?=$row["URL"]; ?>"><li style="cursor: pointer;"><span class="hidden-tablet" style="font-family: Ubuntu,Tahoma,Helvetica Neue,Helvetica,Arial,sans-serif;font-size: 14px;color: black;"> <?=$row["TITLE"]; ?>
									</span></li> </a>
								</div>	

								<?php
							}
							$main++;
							?>
						</div>
						<?php
					}
					?>
				</div>
			</div>
		</ul>
	</div>
</div>


<style type="text/css">
	@import url('css/font-awesome.min.css');
	.accordion-toggle:after {
		font-family: 'FontAwesome';
		content: "\f078";    
		float: right;
	}
	.accordion-opened .accordion-toggle:after {    
		content: "\f054";    
	}

	.accordion-inner:hover { 
		background-color: white;
	}

	.liactive
	{
		background-color: white;	
	}

</style>