<?php
include("include/connect.php");
session_start();
error_reporting(0);
  //echo $_SESSION["session_id"]; exit;
  // if(@$_REQUEST["mode"]=="edit")
  // {
  //  $random=rand(1000,9999); 
  //  mysql_query("update live_users set session_time='".date('H:i:s')."',session_status='1' where user_id='".$_REQUEST['user_id']."'"); 
  // //mysql_query("delete from live_users where user_id='".$_REQUEST['user_id']."'");
  // header('Location:manage_session.php');
  // }


if(@$_REQUEST["mode"]=="sign_in")
{ 
	$uid = mysql_query("SELECT * FROM `live_users` where mark_uid='".$_SESSION['u_name']."'")or die(mysql_error());
	while($row = mysql_fetch_array($uid))
	{
		$check[]=$row['session_status'];
	}
	if($check!='1')
	{ 
		?>
		<div class="del">
			<script>
				alert("Logout Atleast One Session");
			</script>
		</div>
		<?php 
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="mic and mac Solutions">
	<meta name="author" content="mic and mac Solutions">
	<link id="bs-css" href="css/bootstrap-cerulean.css" rel="stylesheet">

	<style type="text/css">
		body {
			padding-bottom: 40px;
		}
		.sidebar-nav {
			padding: 9px 0;
		}
		
		.del
		{
			margin-left:35%;
			margin-top:10px;
			color:#f90000;
		}
	</style>
	<link href="css/bootstrap-responsive.css" rel="stylesheet">
	<link href="css/charisma-app.css" rel="stylesheet">
	<link href="css/jquery-ui-1.8.21.custom.css" rel="stylesheet">
	<link href='css/fullcalendar.css' rel='stylesheet'>
	<link href='css/fullcalendar.print.css' rel='stylesheet'  media='print'>
	<link href='css/chosen.css' rel='stylesheet'>
	<link href='css/uniform.default.css' rel='stylesheet'>
	<link href='css/colorbox.css' rel='stylesheet'>
	<link href='css/jquery.cleditor.css' rel='stylesheet'>
	<link href='css/jquery.noty.css' rel='stylesheet'>
	<link href='css/noty_theme_default.css' rel='stylesheet'>
	<link href='css/elfinder.min.css' rel='stylesheet'>
	<link href='css/elfinder.theme.css' rel='stylesheet'>
	<link href='css/jquery.iphone.toggle.css' rel='stylesheet'>
	<link href='css/opa-icons.css' rel='stylesheet'>
	<link href='css/uploadify.css' rel='stylesheet'>
	<link href='css/jquery-ui-timepicker-addon.css' rel='stylesheet'>
	<link rel="shortcut icon" href="img/favicon1.ico">
</head>
<script src="jquery.js" type="text/javascript"></script>    
<body>

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
				<a class="brand" href="#"><img alt="Bio Phoenix" src="logo/<?php echo $logo_name; ?>" /> <span></span></a>

				<!-- user dropdown starts -->
				<div class="btn-group pull-right" >           
				</div>
			</div>

		</div>
	</div>

	<!--    <div id="timer" style="text-align: center; color: #32b87a;"></div> -->

	<div class="container-fluid">
		<div class="row-fluid">
			<div id="content" class="span10">
				<div class="row-fluid sortable">
					<div class="box span12" style="margin-left: 57px;">
						<div class="box-header well" data-original-title>
							<h2><i class="icon-user"></i>Manage Sessions</h2>
							<a href="index.php" style="float:right;" class="btn btn-primary">Back</a>
							<div class="box-icon">
							</div>
						</div>
						<div class="box-content">  
							<table class="table table-striped table-bordered bootstrap-datatable datatable">
								<thead>
									<tr>
										<th class="center">#</th>             
										<th class="hidden-480">Ip Address</th>            
										<th class="hidden-480">Login Date</th>
										<th class="hidden-480">Login Time</th> 
										<th class="hidden-480">Log Out</th>  
									</tr>
								</thead>
								<tbody>
									<?php
									$users = mysql_query("SELECT * FROM `live_users`")or die(mysql_error());
									$n=1;

									while($users_res = mysql_fetch_array($users))
									{  
										?>
										<tr class="commentlist">
											<td class="center"><?php echo $n;?></td> 

											<td class="hidden-480"><?php echo $users_res['ip_address'];?></td>
											<td class="hidden-480"><?php echo date('d-m-Y',strtotime($users_res['c_date']));?></td>             
											<td class="hidden-480"><?php echo $users_res['c_time'];?></td>
											<td>
												<div class="visible-md visible-lg hidden-sm hidden-xs action-buttons" id="use">
													<input type="button" name="Logout" id="Logout" value="Logout" class="btn btn-danger logout" log="<?php echo $users_res['session_id'];?>"> &nbsp;&nbsp;&nbsp;<p id="timer" class="timer" style="display:inline-block; color: #f44336; font-size:20px;font-weight:bold;"></p>
													<!-- <a class="btn btn-danger" style="cursor:pointer; text-decoration:none;" href="manage_session.php?mode=edit&user_id=<?php echo $users_res['user_id'] ?>"><i class="icon-trash icon-white"></i>Logout</a> -->
													<!-- <div id="timer" style="text-align: center; color: #32b87a;"></div> -->        
												</div>


											</td>
										</tr>
										<?php
										$n++;

									}
									?>
								</tbody>
							</table>
							<a href="manage_session.php?mode=sign_in" style="margin-left:450px;" class="btn btn-primary">Sign in</a>
						</div>
					</div>
				</div> 
			</div>
		</div>
	</div>
</body>
</html>
<script type="text/javascript">
	$(".logout").click(function() {
		var log_id = $(this).attr('log');
		var e = $(this).parent("div").find("p")
		$.ajax({
			type: 'POST',
			url: 'include/settiming_user.php', 
			data: 'session_timing='+log_id,
			success:function(data)
			{	
				if(data=="timing_start")
				{
					var timeoutHandle;
					function countdown() {
						alert("After Completing 60 Seconds the Page will be Redirect");
						var seconds = 60;
          //var mins = minutes
          function tick() 
          {
          	var current_minutes = seconds-1
          	seconds--;
          	
          	e.html((seconds < 10 ? "0" : "") + String(seconds));
          	if( seconds > 0 ) 
          	{
          		timeoutHandle=setTimeout(tick, 1000);
          	}
          	else 
          	{
          		if(seconds > 1)
          		{
                     // countdown(mins-1);   never reach “00″ issue solved:Contributed by Victor Streithorst
                     setTimeout(function () { countdown(seconds - 1); }, 1000);
                 }
             }

             if(seconds=="00")
             {

             	$.ajax({
             		type: 'POST',
             		url: 'include/settiming_limit_del.php', 
             		data: 'session_id='+log_id,
             		success:function(data)
             		{
             			if(data=="del_sucess")
             			{
             				$.get("autosearch-y/login.php?checkpoint=<?php echo $_SESSION['checkpoint']; ?>&company_name=<?php echo $_SESSION['company_name']; ?>&u_name=<?php echo $_SESSION['u_name']; ?>&password=<?php echo $_SESSION['password']; ?>",function(data){
             					if(data=="MGR Success")
             						window.location.href="home.php";
             					if(data=="Rep Success")
             						window.location.href="home.php";	
             					if(data=="Success")
             						window.location.href="home.php";
             				});     
             			} 
             		}

             	});	


             	//window.location.href="home.php";
             }

          else
          {
          
          $.get("autosearch-y/login.php?checkpoint=<?php echo $_SESSION['checkpoint']; ?>&company_name=<?php echo $_SESSION['company_name']; ?>&u_name=<?php echo $_SESSION['u_name']; ?>&password=<?php echo $_SESSION['password']; ?>",function(data){
             					if(data=="MGR Success")
             						window.location.href="home.php";
             					if(data=="Rep Success")
             						window.location.href="home.php";	
             					if(data=="Success")
             						window.location.href="home.php";
             				});  
          
          }

         }
         tick();
     }
     countdown();
			//window.location.href="home.php";
		}
	}
});
	});

</script>