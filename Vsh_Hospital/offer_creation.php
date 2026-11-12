<?php
  include("include/connect.php");
  session_start();
  $id=$_SESSION['id'];
  $m_id16=$_SESSION['m_id16'];
  if(!isset($_SESSION['id']))
  {

    echo "<script type='text/javascript'>window.location='index.php?err'</script>"; 
  }
  else
  {
        if(@$_REQUEST["mode"]=="edit")
  {
  $sp = mysql_query("SELECT * FROM product WHERE id='".$_REQUEST['id1']."'")or die(mysql_error());
$sp_res = mysql_fetch_array($sp);
$type10=$sp_res['type1'];
  }
  if(@$_REQUEST["mode"]=="del")
{ 
  mysql_query("DELETE FROM product_grouping WHERE id = '".$_REQUEST["spid"]."'") or die(mysql_error());
  // header("location:studentenrollement_pdf.php");

}
require_once("include/select.php");
$ad=new select1();
$res=$ad->view('marketer','','order by id desc');

if(isset($_REQUEST["group_name5"]))
{
  // echo "SELECT id,subgroup_name FROM product_grouping WHERE subgroup_name!='' AND group_name='".$_REQUEST["group_name5"]."' GROUP BY subgroup_name ORDER BY subgroup_name ASC";
      ?> <option value="">--Select--</option>
      <?php 
            $select=mysql_query("SELECT id,doctor_name FROM doctors WHERE rep_id='".$_REQUEST["group_name5"]."' ORDER BY doctor_name ASC");
            while($row_sel=mysql_fetch_array($select)){ 
            ?>
            <option value="<?php echo $row_sel['id']; ?>"><?php echo $row_sel['doctor_name']; ?></option>
            <?php }
            exit();
        }
              if(isset($_REQUEST["group_name6"]))
{
  // echo "SELECT id,subgroup_name FROM product_grouping WHERE subgroup_name!='' AND group_name='".$_REQUEST["group_name5"]."' GROUP BY subgroup_name ORDER BY subgroup_name ASC";
      ?> <option value="">--Select--</option>
      <?php 
      // echo "SELECT product.id,product.pro_name FROM tbl_doctor_product_mapping,product WHERE product.id =tbl_doctor_product_mapping.product_id AND tbl_doctor_product_mapping.doctor_id='".$_REQUEST["group_name6"]."' ORDER BY product.pro_name ASC";
            $select=mysql_query("SELECT product.id,product.pro_name FROM tbl_doctor_product_mapping,product WHERE product.id =tbl_doctor_product_mapping.product_id AND tbl_doctor_product_mapping.doctor_id='".$_REQUEST["group_name6"]."' ORDER BY product.pro_name ASC");
            while($row_sel=mysql_fetch_array($select)){ 
            ?>
            <option value="<?php echo $row_sel['id']; ?>"><?php echo $row_sel['pro_name']; ?></option>
            <?php }
            exit();
        }

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<?php include("include/title.php"); ?>
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
  <link rel="shortcut icon" href="img/favicon1.ico">
<script type="text/javascript">
function valid()
{
var x=document.getElementById("mark_id").value;
if(x=="null" || x=="")
{
alert("Please Enter Marketer Name");
return false; 
}
var z=document.getElementById("pro_name").value;
if(z=="null" || z=="")
{
alert("Please Enter Product Name");
return false; 
}

return true;
}


</script>
<script language="javascript">
var xmlhttp
function cpswcheck(str)
{
  
if (str.length==0)
  {
  document.getElementById("cp").innerHTML="";
  return;
  }
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Your browser does not support XMLHTTP!");
  return;
  }
var url="pass_check.php";
url=url+"?q="+str;
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=stateChanged_unameck;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}

function stateChanged_unameck()
{
if (xmlhttp.readyState==4)
  {
  document.getElementById("cp").innerHTML=xmlhttp.responseText;
  if(xmlhttp.responseText=="Not Avaliable")
  {
  document.getElementById("dis_abb").value="";
  alert("Already used by another Distributor");
  }
  }
}

function GetXmlHttpObject()
{
if (window.XMLHttpRequest)
  {
  // code for IE7+, Firefox, Chrome, Opera, Safari
  return new XMLHttpRequest();
  }
if (window.ActiveXObject)
  {
  // code for IE6, IE5
  return new ActiveXObject("Microsoft.XMLHTTP");
  }
return null;
}
</script>

</head>

<body>

<?php include("include/header.php"); ?>
<div class="container-fluid">
<div class="row-fluid">
<?php include("include/menu.php"); ?>   
<div id="content" class="span10">
<div class="row-fluid sortable">
<div class="box span12">
<div class="box-header well" data-original-title>
<h2><i class="icon-edit"></i>Offer Creation</h2>
<div class="box-icon">
</div>
</div>
<div class="box-content">
<form class="form-horizontal" action="" enctype="multipart/form-data" method="post"  name="frm"  >
<input type="hidden" name="command" id="command" value="add_product" />
<input type="hidden" name="mark_id" id="mark_id" value="<?php echo $m_id16; ?>" />
<input type="hidden" name="spid" id="spid" value="<?php echo $sp_res['id']; ?>" />
<fieldset>
  
   <div class="control-group"> 
    <!-- <label class="control-label" for="typeahead" style="text-align: center;">Offers<span style="color:#FF0000;">*</span></label> -->
    <div class="controls"> 
       <label class="radio">
           <input type="radio" class="ace css-checkbox" name="doc_gender" id="one" value="nooff" checked>
           Define Offer 
       </label>
       <label class="radio">
           <input type="radio" class="ace css-checkbox" name="doc_gender" id="two" value="off"> 
           General Offer
       </label>       
    </div>
</div>  

<div id="a">  
 <div class="control-group"> 
 </div>     
           
           <div class="control-group" >
  <label class="control-label" for="typeahead" style="text-align: center;"><strong>Rep Name</strong></label>
  <div class="controls">
        <select id="repname" name="repname" data-rel="chosen" onchange="groupadd(this)">
            <option value="">--Select--</option>
            <?php 
            $select1=mysql_query("SELECT id,rep_name FROM representative");
            while($row_sel1=mysql_fetch_array($select1)){ 
            ?>
            <option value="<?php echo $row_sel1['id']; ?>"><?php echo $row_sel1['rep_name']; ?></option>
            <?php } ?> 
        </select>
     
    </div>
</div>

<div class="control-group" >
  <label class="control-label" for="typeahead" style="text-align: center;"><strong>Doctor</strong></label>
  <div class="controls">
        <select id="docter" name="docter" onchange="groupadd2(this)">
            <option value="">--Select--</option>
          <!--   <?php 
            $select=mysql_query("SELECT id,doctor_name FROM doctors");
            while($row_sel=mysql_fetch_array($select)){ 
            ?>
            <option value="<?php echo $row_sel['id']; ?>"><?php echo $row_sel['doctor_name']; ?></option>
            <?php } ?>  -->
        </select>
     
    </div>
</div>
 <div class="control-group"> 
 <div class="controls"> 
       <label class="radio">
           <input type="radio" class="ace css-checkbox1" name="allpdt" id="all" value="all" checked>
           All Products
       </label>
       <label class="radio">
           <input type="radio" class="ace css-checkbox1" name="allpdt" id="single" value="single" > 
           Single Product
       </label>       
    </div>
</div>
  <div id="b1">
    <div class="control-group" >
  <label class="control-label" for="typeahead" style="text-align: center;"><strong>Product</strong></label>
  <div class="controls">
        <select id="product" name="product"  >
            <option value="">--Select--</option>
           <!--  <?php 
            $select=mysql_query("SELECT id,pro_name FROM product");
            while($row_sel=mysql_fetch_array($select)){ 
            ?>
            <option value="<?php echo $row_sel['id']; ?>"><?php echo $row_sel['pro_name']; ?></option>
            <?php } ?>  -->
        </select>
     
    </div>
</div>

     
  </div>
    <div class="control-group" >
  <label class="control-label" for="typeahead" style="text-align: center;"><strong>Offer</strong></label>
  <div class="controls">
        <select id="offqtyper" name="offqtyper" data-rel="chosen">
            <option value="">--Select--</option>
            <option value="q1">Quantity</option>
            <option value="p1">Percentege</option>
        </select>
     
    </div>
</div>
<!-- <div id="a2">
<div class="control-group">
              <label class="control-label" for="typeahead" style="text-align: center;"><strong>Quantity</strong></label>
              <div class="controls">
               <input class="input focused"  type="text" name="auantity" id="auantity"  />
                </div>
            </div>

             <div class="control-group">
              <label class="control-label" for="typeahead" style="text-align: center;"><strong>Free</strong></label>
              <div class="controls">
               <input class="input focused"  type="text" name="free" id="free" />
                </div>
            </div>
        </div> -->
        <div id="b2">
          <div class="control-group">
              <label class="control-label" for="typeahead" style="text-align: center;"><strong>Percentage</strong></label>
              <div class="controls">
               <input class="input focused "  type="text" name="aiiper" id="aiiper" style="width:16%;" />
               <input class="input focused"  type="text" name="percentage1" id="Percentage1" value="%" style="width:4%;" />
                </div>
            </div>
          </div>
          <div class="control-group">
              <label class="control-label" for="typeahead" style="text-align: center;"><strong>Quantity</strong></label>
              <div class="controls">
               <input class="input focused"  type="text" name="auantity2" id="auantity2"  />
                </div>
            </div>

             <div class="control-group">
              <label class="control-label" for="typeahead" style="text-align: center;"><strong>Free</strong></label>
              <div class="controls">
               <input class="input focused"  type="text" name="free2" id="free2" />
                </div>
            </div>
        <!-- </div> -->

             <!-- <div class="control-group">
              
              <div class="controls">
               <input class="input focused"  type="text" name="offval" id="offval" />
                </div>
            </div> -->
             <div class="control-group">
              <label class="control-label" for="typeahead" style="text-align: center;"><strong>Valid Upto</strong></label>
              <div class="controls">
               <input class="input focused"  type="text" name="valupto" id="valupto" />
                </div>
            </div>

  

    <div class="form-actions">
      <center>
        <!-- <input type="submit" class="btn btn-primary" name="submit" value="submit" class="submit" onClick="return valid();" />  -->
      
  <input type="submit" class="btn btn-primary" name="submit" value="submit" class="submit" onClick="return valid();" /> 
        <input type="reset" class="btn" value="Cancel" />
          
      </center>
    </div>
  
</div>


<div id="b">  

 <div class="control-group"> 
 </div>   
<!--  <div class="control-group" >
  <label class="control-label" for="typeahead" style="text-align: center;"><strong>Rep Name</strong></label>
  <div class="controls">
        <select id="repname5" name="repname5" data-rel="chosen" onchange="groupadd1(this)">
            <option value="">--Select--</option>
            <?php 
            $select15=mysql_query("SELECT id,rep_name FROM representative");
            while($row_sel15=mysql_fetch_array($select15)){ 
            ?>
            <option value="<?php echo $row_sel15['id']; ?>"><?php echo $row_sel15['rep_name']; ?></option>
            <?php } ?> 
        </select>
     
    </div>
</div>

<div class="control-group" >
  <label class="control-label" for="typeahead" style="text-align: center;"><strong>Doctor</strong></label>
  <div class="controls">
        <select id="docter5" name="docter5" >
            <option value="">--Select--</option>
         
        </select>
     
    </div>
</div>   -->
<!-- 
    <div class="control-group" >
  <label class="control-label" for="typeahead" style="text-align: center;"><strong>Product</strong></label>
  <div class="controls">
        <select id="product1" name="product1" data-rel="chosen">
            <option value="">--Select--</option>
            <?php 
            $select=mysql_query("SELECT id,pro_name FROM product");
            while($row_sel=mysql_fetch_array($select)){ 
            ?>
            <option value="<?php echo $row_sel['id']; ?>"><?php echo $row_sel['pro_name']; ?></option>
            <?php } ?> 
        </select>
     
    </div>
</div> -->

      


    <div class="control-group" >
  <label class="control-label" for="typeahead" style="text-align: center;"><strong>Offer</strong></label>
  <div class="controls">
        <select id="offqtyper1" name="offqtyper1" data-rel="chosen">
            <option value="">--Select--</option>
            <option value="q2">Quantity</option>
            <option value="p2">Percentege</option>
        </select>
     
    </div>
</div>

<!-- <div id="a3">
     <div class="control-group">
              <label class="control-label" for="typeahead" style="text-align: center;"><strong>Quantity</strong></label>
              <div class="controls">
               <input class="input focused"  type="text" name="auantity1" id="auantity1"  />
                </div>
            </div>
  <div class="control-group">
              <label class="control-label" for="typeahead" style="text-align: center;"><strong>Free</strong></label>
              <div class="controls">
               <input class="input focused"  type="text" name="free1" id="free1"  />
                </div>
            </div>
          </div> -->
          <div id="b3">
     
      <div class="control-group">
              <label class="control-label" for="typeahead" style="text-align: center;"><strong>Percentage</strong></label>
              <div class="controls">
               <input class="input focused"  type="text" name="aiiper15" id="aiiper15" style="width:16%;" />
               <input class="input focused"  type="text" name="percentage4" id="Percentage4" value="%" style="width:4%;" />
                </div>
            </div>
          </div>
            <div class="control-group">
              <label class="control-label" for="typeahead" style="text-align: center;"><strong>Quantity</strong></label>
              <div class="controls">
               <input class="input focused"  type="text" name="auantity4" id="auantity4"  />
                </div>
            </div>
  <div class="control-group">
              <label class="control-label" for="typeahead" style="text-align: center;"><strong>Free</strong></label>
              <div class="controls">
               <input class="input focused"  type="text" name="free4" id="free4"  />
                </div>
            </div>
          <!-- </div> -->
          


             <div class="control-group">
              <label class="control-label" for="typeahead" style="text-align: center;"><strong>Valid Upto</strong></label>
              <div class="controls">
               <input class="input focused"  type="text" name="valupto1" id="valupto1" />
                </div>
            </div>
           
           

    <!-- <div class="form-actions"> -->
     
        <!-- <input type="submit" class="btn btn-primary" name="submit" value="submit" class="submit" onClick="return valid();" />  -->
      
 <!--  <input type="submit" class="btn btn-primary" name="submit" value="submit" class="submit" onClick="return valid();" /> 
        <input type="reset" class="btn" value="Cancel" /> -->
          
 
    <!-- </div> -->
     <div class="row-fluid sortable"> 

<div class="box span12">
<div class="box-header well" data-original-title>
<h2><i class="icon-user"></i>Product List  </h2>
<div class="box-icon">
</div>
</div>
<div class="box-content">
 <input type="hidden" name="repid" class="repid" id="repid" value="<?php echo $_REQUEST['organization1'];?>">  
<table class="table table-striped table-bordered bootstrap-datatable datatable">
  <thead>
    <tr>
            <th class="center">#</th>             
           <th class="hidden-480">Product Name</th>            
            <th class="hidden-480">Package</th>
            <th class="hidden-480">MRP</th> 
            <th class="hidden-480">PTS</th> 
             <th class="hidden-480">PTR</th>
              <th class="hidden-480">QTY</th>
               <th class="hidden-480">Free</th>
            <!-- <th class="hidden-480">Action</th>  -->
            </tr>
  </thead>
  <tbody>
<?php
  $replist = mysql_query("SELECT * FROM product")or die(mysql_error());
  // $replist_count = mysql_num_rows($replist);  
  // if($replist_count > 0)
  // {
    $jj=1;
 
    while($replist_res = mysql_fetch_array($replist))
    {  
       $replist5 = mysql_query("SELECT * FROM product_offer_gemeral WHERE gen_pdt_id='".$replist_res['id']."' AND  gen_id=(select max(gen_id) from product_offer_gemeral WHERE gen_pdt_id='".$replist_res['id']."') ")or die(mysql_error());
       $replist_res5 = mysql_fetch_array($replist5);
      
?>
    <tr class="commentlist">
        <!-- <td class="center"><?php echo $jj;?></td>  -->
        <td> <input id="checkbox<?php echo $jj;?>" type="checkbox" name="checkbox[]"  id="checkbox" onclick="checkbox(this)"  class="checkbox" value="<?php echo $replist_res["id"];?>">               
                <label for="#"></label></td>
        <td class="hidden-480"><?php echo $replist_res['pro_name'];?></td>
        <td class="hidden-480"><?php echo $replist_res['packing'];?></td>             
        <td class="hidden-480"><?php echo $replist_res['pro_mrp'];?></td>
         <td class="hidden-480"><?php echo $replist_res['pts'];?></td>
         <td class="hidden-480"><?php echo $replist_res['ptr'];?></td>
         <td><input class="input"  type="text" class="qty10" name="qty10" id="qty10" id="qty10<?php echo $jj;?>" value="<?php echo $replist_res5['gen_qty']; ?>"  disabled /></td>
         <td><input class="input"  type="text" class="free10" name="free10" id="free10" id="free10<?php echo $jj;?>" value="<?php echo $replist_res5['gen_free']; ?>"  disabled /></td>
        <!-- <td> -->
          <!-- <div class="visible-md visible-lg hidden-sm hidden-xs action-buttons"> -->
          <!-- <a style="cursor:pointer; text-decoration:none;" href="add_product_kalzem.php?mode=edit&id1=<?php echo $replist_res['id'] ?>"><i class="icon-edit icon-red"></i></a> -->
          <!--  <u id="interview" is_id="<?php echo $replist_res['id']; ?>" class="custedit" onclick="custedit(this)" style="cursor:pointer; text-decoration:none;"><i class="icon-edit icon-red"></i></u>
                     
          </div> -->
          
        <!-- </td> -->
        

    </tr>
<?php
$jj++;

}
// }
// else
// {
  ?>
<!-- <tr class="odd gradeX commentlist" align="center">
      <td colspan='7'>No data available</td>
    </tr> -->
    <?php
// }
?>
  </tbody>
   </table>

</div>
</div>
</div> 

</div>
</fieldset>
</form>

   <?php
if(isset($_REQUEST['submit'])=='submit')
{
date_default_timezone_set('Asia/Calcutta'); 

  $d=mysql_query("select * from product_offer_tracking where off_rep_id='".$_REQUEST['repname']."' AND off_doc_id='".$_REQUEST["docter"]."'  ");
  $count_d=mysql_num_rows($d);
  $row_d=mysql_fetch_array($d);
  if($count_d==0) {

    // echo $_REQUEST["allpdt"];
    if($_REQUEST["allpdt"]=='single')
    {
      // echo "hi";
       
        
       mysql_query("INSERT INTO product_offer_tracking(off_rep_id,off_doc_id,off_pdt_id,off_offer,off_percent,off_qty,off_free,off_uptodate,off_date,off_time)VALUES('".$_REQUEST["repname"]."','".$_REQUEST["docter"]."','".$_REQUEST["product"]."','".$_REQUEST["offqtyper"]."','".$_REQUEST["aiiper"]."','".$_REQUEST["auantity2"]."','".$_REQUEST["free2"]."','".date("Y-m-d",strtotime($_REQUEST["valupto"]))."','".date('Y-m-d')."','".date('H:i:s')."')")or die(mysql_error());  
         echo "<script type='text/javascript'>alert('Add Successfully');window.location.href='offer_creation.php';</script>";
    
       }

    elseif ($_REQUEST["allpdt"]=='all') {

       $prod=mysql_query("SELECT product.id,product.pro_name FROM tbl_doctor_product_mapping,product WHERE product.id =tbl_doctor_product_mapping.product_id AND tbl_doctor_product_mapping.doctor_id='".$_REQUEST["docter"]."'");
        while($row_prod=mysql_fetch_array($prod)){ 
      
       mysql_query("INSERT INTO product_offer_tracking(off_rep_id,off_doc_id,off_pdt_id,off_offer,off_percent,off_qty,off_free,off_uptodate,off_date,off_time)VALUES('".$_REQUEST["repname"]."','".$_REQUEST["docter"]."','".$row_prod["id"]."','".$_REQUEST["offqtyper"]."','".$_REQUEST["aiiper"]."','".$_REQUEST["auantity2"]."','".$_REQUEST["free2"]."','".date("Y-m-d",strtotime($_REQUEST["valupto"]))."','".date('Y-m-d')."','".date('H:i:s')."')")or die(mysql_error());  

    // $LastId = mysql_insert_id();
  }
  echo "<script type='text/javascript'>alert('Add Successfully');window.location.href='offer_creation.php';</script>";
      
    }
    
  
 // echo "<script type='text/javascript'>alert('Add Successfully');window.location.href='add_product_kalzem.php';</script>";

 
  }
  else
  {

      if($_REQUEST["allpdt"]=='single')
    {
      // echo "hi";
      if($row_d["off_date"]==date('Y-m-d'))
      {

        mysql_query("UPDATE  product_offer_tracking SET off_rep_id='".$_REQUEST["repname"]."',off_doc_id='".$_REQUEST["docter"]."',off_pdt_id='".$_REQUEST["product"]."',off_offer='".$_REQUEST["offqtyper"]."',off_percent='".$_REQUEST["aiiper"]."',off_qty='".$_REQUEST["auantity2"]."',off_free='".$_REQUEST["free2"]."',off_uptodate='".date("Y-m-d",strtotime($_REQUEST["valupto"]))."',off_date='".date('Y-m-d')."',off_time='".date('H:i:s')."' WHERE off_id='".$row_d["off_id"]."'")or die(mysql_error()); 
        echo "<script type='text/javascript'>alert('Add Successfully');window.location.href='offer_creation.php';</script>";
      }
      else
      {

               mysql_query("UPDATE  product_offer_tracking SET off_uptodate='".date("Y-m-d")."' WHERE off_id='".$row_d["off_id"]."'")or die(mysql_error()); 

           mysql_query("INSERT INTO product_offer_tracking(off_rep_id,off_doc_id,off_pdt_id,off_offer,off_percent,off_qty,off_free,off_uptodate,off_date,off_time)VALUES('".$_REQUEST["repname"]."','".$_REQUEST["docter"]."','".$_REQUEST["product"]."','".$_REQUEST["offqtyper"]."','".$_REQUEST["aiiper"]."','".$_REQUEST["auantity2"]."','".$_REQUEST["free2"]."','".date("Y-m-d",strtotime($_REQUEST["valupto"]))."','".date('Y-m-d')."','".date('H:i:s')."')")or die(mysql_error()); 
     
             echo "<script type='text/javascript'>alert('Add Successfully');window.location.href='offer_creation.php';</script>";
         }      
     
    
       }

    elseif ($_REQUEST["allpdt"]=='all') {
         if($row_d["off_date"]==date('Y-m-d'))
      {
        echo "hello";
         $prod51=mysql_query("SELECT product.id,product.pro_name FROM tbl_doctor_product_mapping,product WHERE product.id =tbl_doctor_product_mapping.product_id AND tbl_doctor_product_mapping.doctor_id='".$_REQUEST["docter"]."'");
        while($row_prod51=mysql_fetch_array($prod51)){
       
            mysql_query("UPDATE  product_offer_tracking SET off_rep_id='".$_REQUEST["repname"]."',off_doc_id='".$_REQUEST["docter"]."',off_pdt_id='".$row_prod51["id"]."',off_offer='".$_REQUEST["offqtyper"]."',off_percent='".$_REQUEST["aiiper"]."',off_qty='".$_REQUEST["auantity2"]."',off_free='".$_REQUEST["free2"]."',off_uptodate='".date("Y-m-d",strtotime($_REQUEST["valupto"]))."',off_date='".date('Y-m-d')."',off_time='".date('H:i:s')."' WHERE off_id='".$row_d["off_id"]."'")or die(mysql_error()); 
          }
            echo "<script type='text/javascript'>alert('Add Successfully');window.location.href='offer_creation.php';</script>";
      }
      else
      {

       $prod5=mysql_query("SELECT product.id,product.pro_name FROM tbl_doctor_product_mapping,product WHERE product.id =tbl_doctor_product_mapping.product_id AND tbl_doctor_product_mapping.doctor_id='".$_REQUEST["docter"]."'");
        while($row_prod5=mysql_fetch_array($prod5)){ 
             mysql_query("UPDATE  product_offer_tracking SET off_uptodate='".date("Y-m-d",strtotime($_REQUEST["valupto"]))."' WHERE off_id='".$row_d["off_id"]."'")or die(mysql_error()); 

       mysql_query("INSERT INTO product_offer_tracking(off_rep_id,off_doc_id,off_pdt_id,off_offer,off_percent,off_qty,off_free,off_uptodate,off_date,off_time)VALUES('".$_REQUEST["repname"]."','".$_REQUEST["docter"]."','".$row_prod5["id"]."','".$_REQUEST["offqtyper"]."','".$_REQUEST["aiiper"]."','".$_REQUEST["auantity2"]."','".$_REQUEST["free2"]."','".date("Y-m-d",strtotime($_REQUEST["valupto"]))."','".date('Y-m-d')."','".date('H:i:s')."')")or die(mysql_error());  
    // $LastId = mysql_insert_id();

  }
    echo "<script type='text/javascript'>alert('Add Successfully');window.location.href='offer_creation.php';</script>";
      
    }
  }
  // else{
  // echo "<script type='text/javascript'>alert('Already Added Successfully');</script>";
  // }

}
}
  
?>
 

</div>
</div>
</div>
</div>
</div>
<hr>
  <div class="modal fade" id="myModal" role="dialog" style="width:50%;">
    <div class="modal-dialog" >
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Product Edit</h4>
        </div>
        <div class="modal-body">
          
        </div>
            <!--<div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>-->
      </div>
      
    </div>
  </div>
<?php include("include/footer.php"); ?>
</div>

    
  <script src="js/jquery-1.7.2.min.js"></script>
  <script src="js/jquery-ui-1.8.21.custom.min.js"></script>
  <script src="js/bootstrap-transition.js"></script>
  <script src="js/bootstrap-alert.js"></script>
  <script src="js/bootstrap-modal.js"></script>
  <script src="js/bootstrap-dropdown.js"></script>
  <script src="js/bootstrap-scrollspy.js"></script>
  <script src="js/bootstrap-tab.js"></script>
  <script src="js/bootstrap-tooltip.js"></script>
  <script src="js/bootstrap-popover.js"></script>
  <script src="js/bootstrap-button.js"></script>
  <script src="js/bootstrap-collapse.js"></script>
  <script src="js/bootstrap-carousel.js"></script>
  <script src="js/bootstrap-typeahead.js"></script>
  <script src="js/bootstrap-tour.js"></script>
  <script src="js/jquery.cookie.js"></script>
  <script src='js/fullcalendar.min.js'></script>
  <script src='js/jquery.dataTables.min.js'></script>
  <script src="js/excanvas.js"></script>
  <script src="js/jquery.flot.min.js"></script>
  <script src="js/jquery.flot.pie.min.js"></script>
  <script src="js/jquery.flot.stack.js"></script>
  <script src="js/jquery.flot.resize.min.js"></script>
  <script src="js/jquery.chosen.min.js"></script>
  <script src="js/jquery.uniform.min.js"></script>
  <script src="js/jquery.colorbox.min.js"></script>
  <script src="js/jquery.cleditor.min.js"></script>
  <script src="js/jquery.noty.js"></script>
  <script src="js/jquery.elfinder.min.js"></script>
  <script src="js/jquery.raty.min.js"></script>
  <script src="js/jquery.iphone.toggle.js"></script>
  <script src="js/jquery.autogrow-textarea.js"></script>
  <script src="js/jquery.uploadify-3.1.min.js"></script>
  <script src="js/jquery.history.js"></script>
  <script src="js/charisma.js"></script>
  <script src="js/jquery.repeater.js"></script>
        <script type="text/javascript">
           $(function(){    
            $('.checkbox for refer').click(function(){
          
     
      //  var auantity1=$('#auantity1').val();
      // var free1=$('#free1').val();
      // var auantity4=$('#auantity4').val();
      // var free4=$('#free4').val(); 
      var offqtyper1=$('#offqtyper1').val();
      //  if($('#offqtyper1').val()=='q2') 
      // {
      //   var checkqty=$('#auantity1').val();
      //   var checkfree=$('#free1').val();
      // }
      //  if($('#offqtyper1').val()=='p2')
      // {
        var checkqty=$('#auantity4').val();
        var checkfree=$('#free4').val();
      // }

     
      if(offqtyper1!='')  
      {
        if($('#valupto1').val()!='')  
        {
         if(this.checked == true)
         {
           
     
        if(checkqty!='')    
        {
          if(checkfree!='')    
        {
         $(this).closest('tr').find('#qty10').val(checkqty);
         $(this).closest('tr').find('#free10').val(checkfree);
         // alert($(this).val());
         // alert($('#offqtyper1').val());
         // alert($('#aiiper15').val());
         // alert($('#auantity4').val());
         // alert($('#free4').val());
         // alert($('#valupto1').val());
         $.post("offer_creation_save.php",{proidgen:$(this).val(),offgen:$('#offqtyper1').val(),genpercent:$('#aiiper15').val(),genqty:$('#auantity4').val(),genfree:$('#free4').val(),genuptodate:$('#valupto1').val()}, function( data ) { 
          alert(data); });
       }
       else
       {
        alert("Enter Quantity");
        $(this).removeAttr("checked",false);
       }
       }
       else
       {
        alert("Enter Quantity");
        $(this).removeAttr("checked",false);

       }
       
     
  }
    if(this.checked == false){
      $(this).closest('tr').find('#qty10').val('');
         $(this).closest('tr').find('#free10').val('');
    }
  }
  else
  {
    alert("select validupto date");
     $(this).removeAttr("checked",false);
  }
}
else
{
  alert("select offers");
     $(this).removeAttr("checked",false);
}
              
    });




            // alert("hi");
            $( "#valupto" ).datepicker();
            $( "#valupto1" ).datepicker();
             $('#a,#table').show();
    $('#b,#table').hide();
        $(".css-checkbox").click(function () {
            if ($(this).attr('id') == "one") {
                $('#a,#table').show();
                $('#b,#table').hide();             
                
            } else {
                $('#a,#table').hide();
                $('#b,#table').show();
               
            }
        });
           $('#a1').show();
    $('#b1').hide();
        $(".css-checkbox1").click(function () {
            if ($(this).attr('id') == "all") {
                $('#a1').show();
                $('#b1').hide();             
                
            } else {
                $('#a1').hide();
                $('#b1').show();
               
            }
        });
        $('#a2').hide();
    $('#b2').hide();
        $("#offqtyper").change(function () {
            if ($(this).attr('value') == "q1") {
                $('#a2').show();
                $('#b2').hide();             
                
            } else {
                $('#a2').hide();
                $('#b2').show();
               
            }
        });

         $('#a3').hide();
    $('#b3').hide();
        $("#offqtyper1").change(function () {
            if ($(this).attr('value') == "q2") {
                $('#a3').show();
                $('#b3').hide();             
                
            } else {
                $('#a3').hide();
                $('#b3').show();
               
            }
        });

           $('#vatextra').val("14.50%");   
           $("#packing").keyup(function(){  
             var packing =$('#packing').val(); 
             $('#unit').val(packing); 
           });   
            $("#auantity2,#aiiper").keyup(function(){                       
                    var percentage =$('#aiiper').val(); 
                    var auantity2 =$('#auantity2').val();  
                  
                    if(percentage=='') 
                    {
                      var percentage =0; 
                    } 
                    if(auantity2=='')
                    {
                      var auantity2 =0; 
                    }    
                                        
                    
                       var total=(parseInt(auantity2)*parseInt(percentage))/100;   
                     
                  
                  $('#free2').val(total); 
                   });
              $("#auantity4,#aiiper15").keyup(function(){                       
                    var percentage =$('#aiiper15').val(); 
                    var auantity2 =$('#auantity4').val();  
                  
                    if(percentage=='') 
                    {
                      var percentage =0; 
                    } 
                    if(auantity2=='')
                    {
                      var auantity2 =0; 
                    }    
                                        
                    
                       var total=(parseInt(auantity2)*parseInt(percentage))/100;   
                     
                  
                  $('#free4').val(total); 
                   });

   
             

            });
      
        </script>   
        <script type="text/javascript">
                  function groupadd(gp){ 
              var group = gp
                    $.post("offer_creation.php",{group_name5:$(gp).val()}, function( data ) {     
     // alert(data);  
      // $('#docter').html(data);  
      $(group).parent("div").parent("div").parent("div").find('#docter').html(data);
    });    
               
  }
                function groupadd1(gp1){ 
               var group = gp1
                    $.post("offer_creation.php",{group_name5:$(gp1).val()}, function( data ) {     
     // alert(data);  
      $(group).parent("div").parent("div").parent("div").find('#docter5').html(data); 
     
    });    
               
  }
                 function groupadd2(gp2){ 
                      // alert("hi");
               var group = gp2
                    $.post("offer_creation.php",{group_name6:$(gp2).val()}, function( data ) {     
     // alert(data);  
      $('#product').html(data); 
     
    });    
               
  }
              function checkbox(id5){ 
                      // alert("hi");
               
      //  var auantity1=$('#auantity1').val();
      // var free1=$('#free1').val();
      // var auantity4=$('#auantity4').val();
      // var free4=$('#free4').val(); 
      var offqtyper1=$('#offqtyper1').val();
      //  if($('#offqtyper1').val()=='q2') 
      // {
      //   var checkqty=$('#auantity1').val();
      //   var checkfree=$('#free1').val();
      // }
      //  if($('#offqtyper1').val()=='p2')
      // {
        var checkqty=$('#auantity4').val();
        var checkfree=$('#free4').val();
      // }

     
      if(offqtyper1!='')  
      {
        if($('#valupto1').val()!='')  
        {
         if(id5.checked == true)
         {
           
     
        if(checkqty!='')    
        {
          if(checkfree!='')    
        {
         $(id5).closest('tr').find('#qty10').val(checkqty);
         $(id5).closest('tr').find('#free10').val(checkfree);
         // alert($(this).val());
         // alert($('#offqtyper1').val());
         // alert($('#aiiper15').val());
         // alert($('#auantity4').val());
         // alert($('#free4').val());
         // alert($('#valupto1').val());
         $.post("offer_creation_save.php",{proidgen:$(id5).val(),offgen:$('#offqtyper1').val(),genpercent:$('#aiiper15').val(),genqty:$('#auantity4').val(),genfree:$('#free4').val(),genuptodate:$('#valupto1').val()}, function( data ) { 
          // alert(data);
               alert("Added Successfully"); });
       }
       else
       {
        alert("Enter Quantity");
        $(id5).removeAttr("checked",false);
       }
       }
       else
       {
        alert("Enter Quantity");
        $(id5).removeAttr("checked",false);

       }
       
     
  }
    if(id5.checked == false){
      $(id5).closest('tr').find('#qty10').val('');
         $(id5).closest('tr').find('#free10').val('');
    }
  }
  else
  {
    alert("select validupto date");
     $(id5).removeAttr("checked",false);
  }
}
else
{
  alert("select offers");
     $(id5).removeAttr("checked",false);
}
       
               
  }
  function custedit(fs)
{
 $.post("add_product_kalzem_save.php",{sid:$(fs).attr("is_id")},function(data){
          $(".modal-body").html(data);
          $("#myModal").modal(open);
          }); 
}
        function delMe(id)
{
if (confirm("Are you sure want to delete..?")) {
    $.post("add_product_kalzem_save.php",{sid:$("#proid").val()},function(data){
    });
    document.location = "add_product_kalzem.php?mode=del&spid="+id;
    alert($('#proid').val());
    $.post("add_product_kalzem_save.php",{sid:$("#proid").val()},function(data){
          $(".modal-body").html(data);
          $("#myModal").modal(open);
          }); 
  }
}
  </script>


</body>
</html>
<?php
}
