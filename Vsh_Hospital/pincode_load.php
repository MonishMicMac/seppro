<?php
	include("include/connect.php");
	session_start();
	
	$id=$_SESSION['id'];
	//echo $m_id16;die();
	$m_id16=$_SESSION['m_id16'];
	if(!isset($_SESSION['id']))
	{

		echo "<script type='text/javascript'>window.location='index.php?err'</script>"; 
	}
	else
	{
	
require_once("include/select.php");
$ad=new select1();
$res=$ad->view('distributor','where m_id16='.$m_id16,'order by id desc');
$res1=$ad->view('dist_prod','','order by id desc');
?>

  <table  class="table table-striped table-bordered" width="100%">
<thead>
    <th>Pincode</th>
    <th>Division Customer</th>
    <th>Distributor</th>
    <th></th>
    <th>Customer</th>
    <th></th>
    <th colspan="1">Actions</th>
</thead>

<tbody>
<?php 
$heq=$_REQUEST['edit_hq_name'];
$pin = $_REQUEST['edit_pincode'];
$repa = mysql_query("SELECT GROUP_CONCAT(`id`) as sid FROM `representative` WHERE `headquarter_id` = $heq");
$rep_rows = mysql_fetch_array($repa);
$repID = $rep_rows['sid'];
$cust_mst = mysql_query("SELECT `pincode`,GROUP_CONCAT(id) as id  FROM `tbl_customer_master` WHERE `rep_id` IN ($repID) and pincode = '$pin' GROUP BY `pincode`");
while($cust_row = mysql_fetch_array($cust_mst)) :

$fd = $cust_row['id'];
$cid = explode(",", $fd);  
$pin_code = $cust_row['pincode'];
$count_pin = 0;
$count_shop = array();
$shop_array = array();
$distname_array = array();
$custname_array = array();
$j = 0;
foreach($cid as $sid) :
  $cust_ch = mysql_query("SELECT shop_name  FROM `tbl_customer_master` where id = $sid");
  $cust_ch_row = mysql_fetch_array($cust_ch);
  $shop_array[] =$cust_ch_row['shop_name'];
  $dist_cust = mysql_query("SELECT b.dis_name as dis_name,a.areaname,a.`customer_name` as customer_name,a.id as id FROM `distributor_customer` a LEFT JOIN distributor b ON a.distributor_id=b.dis_id WHERE `our_cust_id`=$sid");
  $count_shop[$j] = 0;
  if(mysql_num_rows($dist_cust)>0) :
    while($distrow=mysql_fetch_array($dist_cust)) :
      $distname_array[$j][] = $distrow['dis_name'];
      $custname_array[$j][] = $distrow['customer_name'];
      $did_array[$j][] = $distrow['id'];
       $areaname[$j][] = $distrow['areaname'];
      $count_pin++;
      $count_shop[$j]++;
    endwhile;
  else :
    $distname_array[$j][] = '';
    $custname_array[$j][] = '';

    $count_pin++;
    $count_shop[$j]++;
  endif;
  $j++;
endforeach;


echo "<tr class='tr_pincode'><td class='td_pincode' rowspan='".(($count_pin=='0')?1:$count_pin)."'>".$pin_code."</td>";
for ($i=0; $i < count($shop_array); $i++) :
  if($i == 0) :
    echo "<td rowspan='".(($count_shop[$i]=='0')?1:$count_shop[$i])."'>".$shop_array[$i]."</td>";
  else :
    echo "<tr><td rowspan='".(($count_shop[$i]=='0')?1:$count_shop[$i])."'>".$shop_array[$i]."</td>";
  endif;

  for ($o=0; $o < $count_shop[$i]; $o++) :
    if($o == 0) :
      if($i == 0) :
        echo "<td class='td_dis'>".$distname_array[$i][$o]."</td>"."<td><input type='checkbox' name='merge_dist' class='form-control merge_dist' onclick='mergedist(this)' value='".$did_array[$i][$o]."'></td>"."<td class='cust td_customer'>".$custname_array[$i][$o]."</td>"."<td><input type='radio' name='select_dist' class='select_dist' onclick='selectdist(this)' pin='".$pin_code."' data-toggle='modal' data-target='#myModal-mini' style='margin-left: 0px;' disabled></td>"."<td><i class='icon-trash' style='cursor:pointer;' dis='".$did_array[$i][$o]."' onclick='rmvid(this)'></i></td></tr>";
      else :
        echo "<td class='td_dis'>".$distname_array[$i][$o]."</td>"."<td><input type='checkbox' name='merge_dist' class='form-control merge_dist' onclick='mergedist(this)' value='".$did_array[$i][$o]."'></td>"."<td class='cust td_customer'>".$custname_array[$i][$o]."</td>"."<td><input type='radio' name='select_dist' class='select_dist' onclick='selectdist(this)' pin='".$pin_code."' data-toggle='modal' data-target='#myModal-mini' style='margin-left: 0px;' disabled></td>"."<td><i class='icon-trash' style='cursor:pointer;' dis='".$did_array[$i][$o]."' onclick='rmvid(this)'></i></td></tr>";
      endif;
    else :
      echo "<tr><td class='td_dis'>".$distname_array[$i][$o]."</td>"."<td><input type='checkbox' name='merge_dist' class='form-control merge_dist' onclick='mergedist(this)' value='".$did_array[$i][$o]."'></td>"."<td class='cust td_customer'>".$custname_array[$i][$o]."</td>"."<td><input type='radio' name='select_dist' class='select_dist' onclick='selectdist(this)' pin='".$pin_code."' data-toggle='modal' data-target='#myModal-mini' style='margin-left: 0px;' disabled></td>"."<td><i class='icon-trash' dis='".$did_array[$i][$o]."' style='cursor:pointer;' onclick='rmvid(this)'></i></td></tr>";
    endif;

  endfor;
endfor;
endwhile;
?> 
</tbody>


      </table>

<?php
}
?>