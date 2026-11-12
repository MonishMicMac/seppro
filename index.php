<!DOCTYPE html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]> <html class="lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]> <html class="lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Welcome to Sales Enchancement Planner</title>
  <link rel="stylesheet" href="css/style.css">
  <!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
</head>
<body>
  <h1 class="register-title">Welcome to Sales Enchancement Planner</h1>
  <form class="register" name="Login" method="post" action=""> 
    <div class="register-switch">
      <input type="radio" name="sex" value="1" id="sex_r" class="register-switch-input">
      <label for="sex_r" class="register-switch-label">Representative</label>
      <input type="radio" name="sex" value="2" id="sex_m" class="register-switch-input">
      <label for="sex_m" class="register-switch-label">Manager</label>
      <input type="radio" name="sex" value="3" id="sex_a" class="register-switch-input" checked>
      <label for="sex_a" class="register-switch-label">Admininstrator</label>
    </div>
    <input type="text" id="company_name" class="register-input" placeholder="Company Id" required>
    <input type="text" id="u_name" class="register-input" placeholder="User Name" required>
    <input type="password" id="password" class="register-input" placeholder="Password" required>
    <input type="button" name="submit" id="Submit" value="Sign in" class="register-button"><a href="#" style="color:#2672f0;">I've forgot my password</a>
  </form>

  <div class="about">   
    <p class="about-author">
      Powered By <a href="http://micandmac.in" target="_blank">mic&amp;Mac Solutions Pvt Ltd</a>
    </p>
  </div>
    
</body>
</html>
<script src="js/jquery-1.7.2.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
	$("#Submit").click(function(){	
		$.get("autosearch-y/login.php?checkpoint="+$('input:radio[name=sex]:checked').val()+"&company_name="+$('#company_name').val()+"&u_name="+$('#u_name').val()+"&password="+$('#password').val()+"",function(data){		
      
      if(data=="Rep login Success")
      			// alert('data');
				window.location.href="nurse_assign.php";
      if(data=="MGR Success")
				window.location.href="mgr_dashboard.php";
			if(data=="Rep Success")
				window.location.href="view_doctor.php";	
			if(data=="Rep Successeeee")
				window.location.href="vsh_rep_tracking.php";
        if(data=="Success")
				window.location.href="home.php";
			if(data!="Success")
				alert("Login  : "+data);
        
		});
	});
});
</script>