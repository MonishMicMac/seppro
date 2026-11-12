<?php
	include("../include/connect.php");
        include("../include/select.php");
	session_start();
	$id=$_SESSION['id'];
	if(!isset($_SESSION['id']))
	{
	echo "<script type='text/javascript'>window.location='index.php'</script>"; 
	}
	else
	{
        $admin=mysql_query("select * from login where id='$id'");
	$admin_row=mysql_fetch_array($admin);
	$username=$admin_row['username'];
        $ad=new select1();
        
        
        if(isset($_POST['submit']))
        {
            $division_id=$_POST['division_name'];
            $state_name=$_POST['state_name'];
            $sel_state=$_POST['sel_state'];
            $count=count($state_name);
            for($i=0;$i<$count;$i++)
            { 
                $count_div=$ad->count1("tbl_division_state", "where division_id ='$division_id' and state_id = '$state_name[$i]'", "");
                if(!$count_div > 0)
                {
                  mysql_query("insert into tbl_division_state(division_id,state_id,ds_no_distributors)values('".$division_id."','".$state_name[$i]."','".$sel_state[$i]."')")or die(mysql_error());
                }
            }
            echo "<script type='text/javascript'>alert('Restriction recorded Sucessfully');window.location.href='restriction_master.php';</script>";
        }
		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php include("include/title.php"); ?>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" href="css/jquery.treeview.css" />
<script src="js/jquery-1.4.min.js" type="text/javascript"></script>
<script src="js/jquery.treeview.js" type="text/javascript"></script>
<script src="js/jquery.cookie.js" type="text/javascript"></script>
</head>

<body>    
<div id="wrapper">
<?php include("include/header.php"); ?>
<div class="clr"></div> 
<div class="contentArea">
<div class="clr"></div>
<div class="contentLeft">
<span class="headers">
<h2>Administrator</h2>
</span>
<div class="clr"></div>
<?php
include("include/menu.php");
?>
</div>
<div class="contentRight" align="center" style="height:auto;padding: 2% 0% 2% 0%;">
    <h2>Division Restriction</h2>
    <div>
      <form name="frm" action="" method="post">    
      <table width="50%" border="1">
            <tr>
                <td>Division Name</td>
                <td>:</td>
                <td>
                    <select name="division_name" id="division_name" required>
                        <option value="">---Select---</option>
                        <?php
                        $co_stat=$ad->count1("marketer", "", "");
                        $state=$ad->view("marketer", "", "");
                        if($co_stat > 0)
                        {
                            while($row_st=mysql_fetch_object($state))
                            {          ?>
                        <option value="<?=$row_st->id;?>"><?=$row_st->mark_name;?></option>              
                <?php       }
                        }
                        else
                        {              ?>
                            <option value="">No Division Avaliable!</option>
                 <?php  }    
                                       ?>
                    </select>
                </td>
            </tr>
          <tr style="height:5px;">
                <td colspan="3"></td>
            </tr>
            <tr>
                <td>State Name</td>
                <td>:</td>
                <td>
                    <select name="state_name[]" id="state_name" multiple required>
                        <?php
                        $co_state=$ad->count1("master_state", "", "");
                        $states=$ad->view("master_state", "", "");
                        if($co_state > 0)
                        {
                            while($row_st=mysql_fetch_object($states))
                            {          ?>
                        <option value="<?=$row_st->state_id;?>"><?=$row_st->state_name;?></option>              
                <?php       }
                        }
                        else
                        {              ?>
                            <option value="">No State Avaliable!</option>
                 <?php  }    
                                       ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="3">(Use Ctrl(key) For Multiple Select)</td>
            </tr>
      </table>
      <div id="show" style="height:auto;width:50%;padding:2% 0% 2% 0%">
          <table>
              
          </table>
      </div>
          <div>
              <input type="submit" name="submit" id="submit" class="myButton" value="Add" />
          </div>    
      </form>
    </div>
</div>

<div class="clr"></div>
</div>

<script type="text/javascript">
    $(function(){
        $( "select" ).change(function(){ 
        var selected=[];
        var div = $("#show");
        $("#show").html('');
        var x=0;
        $('#state_name :selected').each(function(){
        selected[x]=$(this).text();
        x++;
        });
        len=selected.length-1;
        for(var i=0;i<=len;i++)
        {
            div.append('<tr><td>'+selected[i]+'<td>:</td><td><input type="text" class="textbox" name="sel_state[]" id="sel_state[]" value="" required/></td></tr>');
        }
        });
    });
</script>
<?php
include("include/footer.php")
?>
</div>
</body>
</html>
<?php
}

