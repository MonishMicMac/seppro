<?php
include('../include/connect.php');
	$command=$_POST['command'];
	if($command=="login")
	{
	$u_name=$_POST['u_name'];
	$pass=$_POST['pass'];
	$select=mysql_query("SELECT * FROM login WHERE username='$u_name' AND password='$pass'")or die(mysql_error());
		$numofrows=mysql_num_rows($select);
		if($numofrows>0)
		{
		$record=mysql_fetch_array($select);
		$id=$record['id'];
		session_start();
		$_SESSION['id']=$id;
		echo "<script type=text/javascript>window.location='home.php'</script>";
		}
		else
		{
			echo "<script type=text/javascript>alert('Please Enter Correct Username And Password'); window.location='index.php'</script>";	
		}
	}
?>