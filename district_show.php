<?php
include("include/connect.php");
include("include/select.php");
$ad=new select1();

$command=$_REQUEST['command'];

if($command === 'district_show')
{
    $pin=$_REQUEST['pin'];
    $count=count($pin);
    $d_id=$_REQUEST['d_id'];
    mysql_query("delete from temp_rep where district_id = '$d_id'")or die(mysql_error());
    mysql_query("insert into temp_rep (district_id,area_ids)values('$d_id','$pin')")or die(mysql_error());
    $temp=$ad->view("temp_rep","","");
    $t_count=$ad->count1("temp_rep","","");
    if($t_count > 0)
    { ?>
      <table style="margin-left:4%;">
<?php
        while($row_t=mysql_fetch_object($temp))
        { ?>
            <tr style="border:1px solid lightskyblue;" align="center">
                <td style="width:30%;border:1px solid lightskyblue;"><?=$ad->get_district($row_t->district_id);?><td>
                <td style="margin-left: 3%; float: left;">
                    <?php
                    $area=explode(",",$row_t->area_ids);
                    $a_count=count($area);
                    for($i=0;$i<$a_count;$i++)
                    {
                    echo $ad->get_pin_area($area[$i]).",";
                    }
                    ?>
                <td>    
            </tr>
 <?php  } ?>
       </table>     
  <?php          
    }
}


if($command === 'reps_show')
{
    $reps=$_REQUEST['reps'];
    $count=count($reps);
    $d_id=$_REQUEST['d_id'];
    mysql_query("delete from temp_manager where district_id = '$d_id'")or die(mysql_error());
    mysql_query("insert into temp_manager (district_id,reps)values('$d_id','$reps')")or die(mysql_error());
    $temp=$ad->view("temp_manager","","");
    $t_count=$ad->count1("temp_manager","","");
    if($t_count > 0)
    { ?>
      <table style="margin-left:4%;">
      <?php
        while($row_t=mysql_fetch_object($temp))
        { ?>
            <tr style="border:1px solid lightskyblue;" align="center">
                <td style="width:30%;border:1px solid lightskyblue;"><?=$ad->get_district($row_t->district_id);?><td>
                <td style="margin-left: 3%; float: left;">
                    <?php
                    $reprs=explode(",",$row_t->reps);
                    $a_count=count($reprs);
                    for($i=0;$i<$a_count;$i++)
                    {
                    echo $ad->get_representative($reprs[$i]).",";
                    }
                    ?>
                <td>    
            </tr>
 <?php  } ?>
       </table>     
  <?php          
    }
}
