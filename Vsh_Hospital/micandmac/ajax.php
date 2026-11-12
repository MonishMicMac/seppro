<?php

include("../include/connect.php");
include("../include/select.php");
$ad=new select1();

$command=$_REQUEST['command'];

if($command == 'state')
{
    $state=$_REQUEST['state'];
    $count_state=$ad->count1("master_state", "where state_name like '%$state%'", "");
    if($count_state > 0 )
    {
        echo "1";
    }  
    else 
    {
        echo "0";
    }
}

if($command === 'get_div_rest')
{
    $div_id=$_GET['div_id'];
    $tab=$ad->view("tbl_division_state","where division_id = '$div_id'","");
    $count=$ad->count1("tbl_division_state","where division_id = '$div_id'","");
    $x=1;
    if($count > 0)
    {    
    while($row_tab=mysql_fetch_array($tab))
       { ?>
        <tr>
            <td><?=$x;?></td>
            <td><?=$ad->get_admin_state($row_tab['state_id']);?></td>
            <td><?=$row_tab['ds_no_distributors'];?></td>
            <td>
                <a href="edit_div_rest.php?ds_id=<?=$row_tab['ds_id'];?>"><img src="images/edit.png" style="height: 17px;width:17px;">Edit</a>
                <a href="delete.php?command=del_div_rest&&ds_id=<?=$row_tab['ds_id'];?>" onclick="return confirm('Are you sure you want to delete!!!');"><img src="images/del.png" style="height: 17px;width:17px;">Delete</a>
            </td>
        </tr>
 <?php $x++;
      }
    }
    else
      { ?>
        <tr>
            <td colspan="4"><span style="color:red;">No Restrictions Added to Selected Division</span></td>
        </tr> 
<?php }    
    
}