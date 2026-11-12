<?php
if($this->session->userdata('user_details')==''){
	redirect("Login_controller/index");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>GM CHIT FUNDS PVT LTD</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url(); ?>assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url(); ?>assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url(); ?>assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url(); ?>assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url(); ?>assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
	<link href="<?php echo base_url(); ?>assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url(); ?>assets/layouts/layout4/css/layout.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url(); ?>assets/layouts/layout4/css/themes/default.min.css" rel="stylesheet" type="text/css" id="style_color" />
	<link href="<?php echo base_url(); ?>assets/layouts/layout4/css/custom.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url(); ?>assets/global/plugins/autocomplete/jquery-ui.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css" />
	<link rel="shortcut icon" href="<?php echo base_url(); ?>favicon.ico" />
	
	<style type="text/css">
		.ui-autocomplete {
			max-height: 200px;
			overflow-y: auto;
			overflow-x: hidden;
			padding-right: 20px;
		} 
	</style>

	<script type="text/javascript">
		var base_url="<?php echo base_url(); ?>";
	</script>
</head>
<body class="page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo">
	<div class="page-header navbar navbar-fixed-top">
		<div class="page-header-inner ">
			<div class="page-logo">
				<a href="<?php echo base_url(); ?>index.php/Chit_detailed_report/chit_details_view"><img src="<?php echo base_url(); ?>assets/layouts/layout4/img/micMac_green_logo.png" alt="gm chit funds" class="logo-default" /> </a>
				<div class="menu-toggler sidebar-toggler"></div>
			</div>
			<a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"> </a>

			<div class="page-top">
				<div class="top-menu">
					<ul class="nav navbar-nav pull-right">
						<li class="separator hide"> </li>
						<li class="dropdown dropdown-user dropdown-dark">
							<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" style="padding: 28px 10px 26px;">
								<span class="username username-hide-on-mobile"> <?php echo $this->session->userdata('user_details')['log_full_name']; ?> </span>
								<!-- <img alt="" class="img-circle" src="<?php echo base_url(); ?>/assets/layouts/layout4/img/avatar9.jpg" /> -->
							</a>
						</li>
						<li class="dropdown dropdown-extended quick-sidebar-toggler" id="logout">
							<span class="sr-only">Toggle Quick Sidebar</span>
							<i class="icon-logout"></i>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<div class="clearfix"> </div>

	<div class="page-container">
		<div class="page-sidebar-wrapper">
			<div class="page-sidebar navbar-collapse collapse">
				<ul class="page-sidebar-menu   " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
					<li class="nav-item start active open">
						<a href="javascript:;" class="nav-link nav-toggle">
							<i class="icon-briefcase"></i>
							<span class="title">Masters</span>
							<span class="arrow open"></span>
						</a>
						<ul class="sub-menu">
							<li class="nav-item <?php if($this_page=='subscriber'){ ?>start active open<?php } ?>">
								<a href="<?php echo base_url(); ?>index.php/Subscriber_controller/subscriber_management" class="nav-link ">
									<span class="title">Subscriber Entry</span>
								</a>
							</li>

							<li class="nav-item <?php if($this_page=='chit'){ ?>start active open<?php } ?>">
								<a href="<?php echo base_url(); ?>index.php/Chit_controller/chit_management" class="nav-link ">
									<span class="title">Chit Entry</span>
								</a>
							</li>

							<li class="nav-item <?php if($this_page=='chit_subs_assign'){ ?>start active open<?php } ?>">
								<a href="<?php echo base_url(); ?>index.php/Chit_subs_controller/chit_subs_management" class="nav-link ">
									<span class="title">Subscriber To Chit</span>
								</a>
							</li>

							<li class="nav-item <?php if($this_page=='auction'){ ?>start active open<?php } ?>">
								<a href="<?php echo base_url(); ?>index.php/Auction_controller/auction_management" class="nav-link">
									<span class="title">Auction Entry</span>
								</a>
							</li>

							<li class="nav-item <?php if($this_page=='collection'){ ?>start active open<?php } ?>">
								<a href="<?php echo base_url(); ?>index.php/Collection_controller/collection_management" class="nav-link">
									<span class="title">Collection Entry</span>
								</a>
							</li>
							<?php
							if($this->session->userdata()['user_details']['log_user_role']=='1'){
								?>
								<li class="nav-item <?php if($this_page=='users'){ ?>start active open<?php } ?>">
									<a href="<?php echo base_url(); ?>index.php/User_controller/user_management" class="nav-link">
										<span class="title">User Management</span>
									</a>
								</li>
								<?php
							}
							?>

							<li class="nav-item <?php if($this_page=='deposit'){ ?>start active open<?php } ?>">
								<a href="<?php echo base_url(); ?>index.php/Deposit_controller/deposit_management" class="nav-link">
									<span class="title">Deposit Entry</span>
								</a>
							</li>
						</ul>
						<a href="javascript:;" class="nav-link nav-toggle">
							<i class="icon-briefcase"></i>
							<span class="title">Reports</span>
							<span class="arrow open"></span>
						</a>
						<ul class="sub-menu">
							<li class="nav-item <?php if($this_page=='chitdetails'){ ?>start active open<?php } ?>">
								<a href="<?php echo base_url(); ?>index.php/Chit_detailed_report/chit_details_view" class="nav-link ">
									<span class="title">Chit Query Report</span>
								</a>
							</li>
							<li class="nav-item <?php if($this_page=='subscriberdetails'){ ?>start active open<?php } ?>">
								<a href="<?php echo base_url(); ?>index.php/Subscriber_detailed_report/subscriber_details_view" class="nav-link ">
									<span class="title">Subscriber Report</span>
								</a>
							</li>
							<li class="nav-item <?php if($this_page=='subscriberdetailsnew'){ ?>start active open<?php } ?>">
								<a href="<?php echo base_url(); ?>index.php/Subscriber_detailed_report1/subscriber_details_view" class="nav-link ">
									<span class="title">Subscriber Detailed Report</span>
								</a>
							</li>
							<li class="nav-item <?php if($this_page=='collectiondetails'){ ?>start active open<?php } ?>">
								<a href="<?php echo base_url(); ?>index.php/Collection_report_controller/collection_management" class="nav-link ">
									<span class="title">Collection Report</span>
								</a>
							</li>
							<li class="nav-item <?php if($this_page=='chitbalance'){ ?>start active open<?php } ?>">
								<a href="<?php echo base_url(); ?>index.php/Chit_balance_report/chit_balance_view" class="nav-link ">
									<span class="title">Chit Balance Query Report</span>
								</a>
							</li>

							<li class="nav-item <?php if($this_page=='deposit_report'){ ?>start active open<?php } ?>">
								<a href="<?php echo base_url(); ?>index.php/Deposit_controller/deposite_report_management" class="nav-link ">
									<span class="title">Deposit Report</span>
								</a>
							</li>

							<?php
							if($this->session->userdata()['user_details']['log_user_role']=='1'){
								?>
								<li class="nav-item <?php if($this_page=='login_report'){ ?>start active open<?php } ?>">
									<a href="<?php echo base_url(); ?>index.php/Login_report_controller/login_report" class="nav-link ">
										<span class="title">Login Report</span>
									</a>
								</li>
								<?php
							}
							?>
							<!--<li class="nav-item <?php if($this_page=='testing'){ ?>start active open<?php } ?>">
								<a href="<?php echo base_url(); ?>index.php/Collection_controller1/collection_management1" class="nav-link ">
									<span class="title">Collection Outstanding Report</span>
								</a>
							</li>-->
						</ul>

						<a href="<?php echo base_url(); ?>index.php/Db_backup_controller/db_backup" class="nav-link nav-toggle">
							<i class="icon-briefcase"></i>
							<span class="title">Db Backup</span>
						</a>
					</li>
				</ul>
			</div>
		</div>