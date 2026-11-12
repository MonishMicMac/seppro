<?php
include("include/connect.php");

if(@$_REQUEST['condition']=='district'){
  $state=$_REQUEST['state'];

  echo "<option value=''>-- Select District --</option>";
  $sql=mysql_query("SELECT district_id,district_name FROM master_district WHERE state_id='$state' AND status='1'");
  while($row=mysql_fetch_array($sql)){
    echo "<option value='".$row['district_id']."'>".$row['district_name']."</option>";
  }
}

if(@$_REQUEST['condition']=='state'){
  $country=$_REQUEST['country'];

  echo "<option value=''>-- Select State --</option>";

  $sql=mysql_query("SELECT state_id,state_name FROM master_state WHERE country_id='$country' AND status='1'");
  while($row=mysql_fetch_array($sql)){
    echo "<option value='".$row['state_id']."'>".$row['state_name']."</option>";
  }
}

if(@$_REQUEST['condition']=='hospital'){
  if($_REQUEST['distributor']!=''){
    $distributor="AND distributor_id='".$_REQUEST['distributor']."'";
  } else {
    $distributor="";
  }

  echo "<option value=''>-- Select Hospital --</option>";

  $sql=mysql_query("SELECT id,hos_name FROM Hospitalname WHERE status='1' $distributor");
  while($row=mysql_fetch_array($sql)){
    echo "<option value='".$row['id']."'>".$row['hos_name']."</option>";
  }
}

if(@$_REQUEST['condition']=='town_district'){
  $country=$_REQUEST['country'];
  $state=$_REQUEST['state'];

  echo "<option value=''>-- Select District --</option>";
  $sql=mysql_query("SELECT district_id,district_name FROM master_district WHERE country_id='$country' AND state_id='$state' AND status='1'");
  while($row=mysql_fetch_array($sql)){
    echo "<option value='".$row['district_id']."'>".$row['district_name']."</option>";
  }
}

if(@$_REQUEST['condition']=='town'){
  $country=$_REQUEST['country'];
  $state=$_REQUEST['state'];
  $district=$_REQUEST['district'];

  echo "<option value=''>-- Select Town --</option>";
  $sql=mysql_query("SELECT id,area_name FROM pincode_list WHERE country_id='$country' AND state_id='$state' AND dist_id='$district' AND status='1'");
  while($row=mysql_fetch_array($sql)){
    echo "<option value='".$row['id']."'>".$row['area_name']."</option>";
  }
}

if(@$_REQUEST['condition']=='area'){
  $country=$_REQUEST['country'];
  $state=$_REQUEST['state'];
  $district=$_REQUEST['district'];
  $town=$_REQUEST['town'];

  echo "<option value=''>-- Select Area --</option>";
  $sql=mysql_query("SELECT id,name FROM beadname WHERE country_id='$country' AND state_id='$state' AND district_id='$district' AND town_id='$town' AND status='1'");
  while($row=mysql_fetch_array($sql)){
    echo "<option value='".$row['id']."'>".$row['name']."</option>";
  }
}

if(@$_REQUEST['condition']=='area_rep'){
  $country=$_REQUEST['country'];
  $state=$_REQUEST['state'];
  $district=$_REQUEST['district'];
  $town=$_REQUEST['town'];

  echo "<option value=''>-- Select Area --</option>";
  $sql=mysql_query("SELECT id,name FROM beadname WHERE country_id='$country' AND state_id='$state' AND district_id='$district' AND town_id IN ($town) AND status='1'");
  while($row=mysql_fetch_array($sql)){
    echo "<option value='".$row['id']."'>".$row['name']."</option>";
  }
}

if(@$_REQUEST['condition']=='product'){
  $pro_category=$_REQUEST['pro_category'];

  echo "<option value=''>-- Select Product --</option>";
  $sql=mysql_query("SELECT id,pro_name FROM product WHERE category_id='$pro_category' AND status='1'");
  while($row=mysql_fetch_array($sql)){
    echo "<option value='".$row['id']."'>".$row['pro_name']."</option>";
  }
}

if(@$_REQUEST['condition']=='check_short_code'){
  $short_code=$_REQUEST['short_code'];

  $sql=mysql_query("SELECT id FROM product_pricing WHERE sku_short_code='$short_code'");
  if(mysql_num_rows($sql)>0){
    echo "false";
  } else {
    echo "true";
  }
}

if(@$_REQUEST['condition']=='check_short_code_edit'){
  $short_code_old=$_REQUEST['short_code_old'];
  $short_code=$_REQUEST['short_code'];

  $sql=mysql_query("SELECT id FROM product_pricing WHERE sku_short_code='$short_code' AND sku_short_code!='$short_code_old'");
  if(mysql_num_rows($sql)>0){
    echo "false";
  } else {
    echo "true";
  }
}
?>

<script>

</script>