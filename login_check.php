<?php
include("include/connect.php");
$command=$_POST['command'];
if($command=='login')
{
$authority=$_POST['authority'];
$u_name=$_POST["u_name"];
$pass=$_POST["pass"]; 

$result = mysql_query("SELECT * FROM admin where u_name='$u_name' and pass='$pass' and authority='$authority'");
$row=mysql_fetch_array($result);
$id=$row['id'];
$num=mysql_num_rows($result);
if($num>0)
{
$result2 = mysql_query("SELECT mark_id FROM representative where rep_id='$u_name'");
$row2=mysql_fetch_array($result2);
$m_id16=$row2['mark_id'];

session_start();
$_SESSION['id']=$id;
$_SESSION['m_id16']=$m_id16;
$_SESSION['u_id16']=$u_name;



if($authority==3)
{
echo "<script type=text/javascript>window.location='manager_home.php';</script>";
}
if($authority==4)
{
echo "<script type=text/javascript>window.location='representative_home.php';</script>";
}


}
else 
{
echo "<script type=text/javascript>alert('Invalid userName or Password');window.location='index.php';</script>";
}
mysql_close($con);
}


if($command=='admin')
{
$u_name=$_POST["u_name"];
$pass=$_POST["pass"]; 
$result = mysql_query("SELECT * FROM admin where u_name='$u_name' and pass='$pass' and authority='2'");
$row=mysql_fetch_array($result);
$id=$row['id'];
$num=mysql_num_rows($result);
if($num>0)
{
session_start();
$SQL=mysql_query("SELECT mark_name  FROM  marketer WHERE mark_id = '".$u_name."'");
$R=mysql_fetch_object($SQL);
$_SESSION['id']=$id;
$_SESSION['m_id16']=$u_name;
$_SESSION["DIVISION"]=$R->mark_name;
echo "<script type=text/javascript>window.location='home.php';</script>";
}
else
{
echo "<script type=text/javascript>alert('Invalid userName or Password');window.location='admin.php';</script>";
}

}


if($command=='ceo')
{
$u_name=$_POST["u_name"];
$pass=$_POST["pass"]; 
$result = mysql_query("SELECT * FROM admin where u_name='$u_name' and pass='$pass' and authority='1'");
$row=mysql_fetch_array($result);
$id=$row['id'];
$num=mysql_num_rows($result);
if($num>0)
{
session_start();
$_SESSION['id']=$id;
$_SESSION['m_id16']=$u_name;
echo "<script type=text/javascript>window.location='home.php';</script>";
}
else
{
echo "<script type=text/javascript>alert('Invalid userName or Password');window.location='ceo.php';</script>";
}

}
