<?php
	include("connect_db.php");
	
	$link = mysql_connect(DB_HOST, DB_USER,DB_PASS) or die("Couldn't make connection.");
	$db = mysql_select_db(DB_NAME, $link) or die("Couldn't select database");
	// error_reporting(0);
 
if(isset($_GET["clientidviewreport"])){ 
  $replist1ser = mysql_query("SELECT * FROM clinetcreation WHERE id='".$_GET['clientview']."' ")or die(mysql_error());  
  $replist1ser_count = mysql_fetch_array($replist1ser);	?>

<div class="box-content">
    <h2><?php echo $replist1ser_count['companyname'];?> - Product Details</h2>
  <table class="table table-striped table-bordered bootstrap-datatable datatable">
  <thead>
    <tr>
            <th class="center">#</th>
             
           <th class="hidden-480">Product Name</th>            
            <!-- <th class="hidden-480">Quantity</th> -->
            <th class="hidden-480">Invoice NO</th> 
            <th class="hidden-480">Invoice Date</th>           
            <th class="hidden-480">Type</th>           
            <th class="hidden-480">AMC /WARRENTY Date</th>    
            <!-- <th class="hidden-480">Start Date</th>
            <th class="hidden-480">End Date</th> -->          
             <!-- <th class="hidden-480">Action</th>   -->
            </tr>
  </thead>
  <tbody>
<?php

  $replist = mysql_query("SELECT * FROM client_product_list WHERE clientid='".$_GET['clientview']."'")or die(mysql_error());
  // $replist_count = mysql_num_rows($replist);
  
  // if($replist_count > 0)
  // {
    $jj=1;
    $i=0;
    $j=0;
    $replist1 = mysql_query("SELECT quantity FROM client_product_list WHERE clientid='".$_GET['clientview']."'")or die(mysql_error());
  $replist1_count = mysql_fetch_array($replist1);
    // echo $replist_res['product'];
    //  $product = implode(',',$replist_res['product']);
    //  print_r($product);
    //  $quantity = implode(',',$replist_res['quantity']);
    //  print_r($quantity);
    //  $qty=$replist_res['quantity'];
    while($replist_res = mysql_fetch_array($replist))
    {

// for( $k = 0; $k<count($quantity); $k++ ) 
//     { 

     for( $i = 0; $i<$replist1_count['quantity']; $i++ ) 
    {        
    
?>
    <tr class="commentlist">
        <td class="center"><?php echo $jj;?></td> 
        <td class="hidden-480"><?php echo $replist_res['product'];?></td>
        <!-- <td class="hidden-480"><?php echo $replist_res['quantity'];?></td>              -->
        <td class="hidden-480"><?php echo $replist_res['invoice_no'];?></td>
        <td class="hidden-480"><?php echo $replist_res['purchase_date'];?></td> 
       
        <td class="hidden-480"><?php echo $replist_res['type'];?></td> 
         <td class="hidden-480"><?php echo $replist_res['start_date'].'  to  '.$replist_res['end_date'];?></td> 
        <!-- <td class="hidden-480"><?php echo $replist_res['start_date'];?></td>
        <td class="hidden-480"><?php echo $replist_res['end_date'];?></td>  -->
         <!-- <td><div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
           <u id="interview" is_id1="<?php echo $replist_res['id']; ?>" class="podedit" onclick="podedit(this)" style="cursor:pointer; text-decoration:none;"><i class="icon-edit icon-red"></i></u>
                 
          </div>
        </td> -->
    </tr>
<?php
$jj++;

// }
}

}
// }
// else
// {
  ?>
<!-- <tr class="odd gradeX commentlist" align="center">
      <td colspan='5'>No data available</td>
    </tr> -->
    <?php
// }
?>
  </tbody>
</table>
</div>
<br/>
<br/>
	
	<div class="box-content">
    <h2><?php echo $replist1ser_count['companyname'];?> - Past Service Details</h2>
<table class="table table-striped table-bordered bootstrap-datatable datatable">
  <thead>
    <tr>
            <th class="center">#</th>
             
                       
            <!-- <th class="hidden-480">Client Name</th> -->
            <th class="hidden-480">Product Name</th>
            <th class="hidden-480">REP Name</th>
            <th class="hidden-480">Remarks</th>
            <th class="hidden-480">Amount</th>
              <th class="hidden-480">Reporting Date</th>
            <!-- <th class="hidden-480">Start Date</th>
            <th class="hidden-480">End Date</th> -->          
             <!-- <th class="hidden-480">Action</th>   -->
            </tr>
  </thead>
  <tbody>
<?php

  // $replistser = mysql_query("SELECT * FROM client_product_list WHERE clientid='".$_REQUEST['id1']."' AND attendance='1'")or die(mysql_error());
  // $replist_count = mysql_num_rows($replist);
  
  // if($replist_count > 0)
  // {
    $jj=1;
    $i=0;
    $j=0;

    $replist1ser = mysql_query("SELECT *,(select companyname FROM clinetcreation WHERE id='".$_GET['clientview']."') AS Clientname FROM reorting WHERE clientid='".$_GET['clientview']."' ")or die(mysql_error());
    
  
    while($replist1ser_count = mysql_fetch_array($replist1ser))
    {
      $id = explode(',', $replist1ser_count['productrequested']);
if(count($id)>1){
  for ($i=0; $i < count($id); $i++) { 
    $id_no[]='\''.$id[$i].'\'';
  }
  $final_id=implode(',', $id_no);
} elseif(count($id)==1) {
$final_id='\''.$id[0].'\'';
}
    $replistrep = mysql_query("SELECT * FROM representative WHERE id='".$replist1ser_count['repid']."' ")or die(mysql_error());

                $replistrep_count = mysql_fetch_array($replistrep);
?>
    <tr class="commentlist">
        <td class="center"><?php echo $jj;?></td> 
         <!-- <td class="hidden-480"><?php echo $replist1ser_count['Clientname'];?></td> -->
        <td class="hidden-480"><?php $replist1serpd = mysql_query("SELECT * FROM product WHERE id IN($final_id) ")or die(mysql_error());

                 while($replist1serpd_count = mysql_fetch_array($replist1serpd))
                 {
                echo $p=$replist1serpd_count['pro_name'].',';
                }
                ;?></td>
     
        <td class="hidden-480"><?php echo $replistrep_count['rep_name'];?></td>
        <td class="hidden-480"><?php echo $replist1ser_count['repremarks'];?></td> 
        <td class="hidden-480"><?php echo $replist1ser_count['reprepamount'];?></td> 
        <td class="hidden-480"><?php echo $replist1ser_count['reporteddate'];?></td> 
      
    </tr>
<?php
$jj++;


}
// }
// else
// {
  ?>
<!-- <tr class="odd gradeX commentlist" align="center">
      <td colspan='5'>No data available</td>
    </tr> -->
    <?php
// }
?>
  </tbody>
</table>
</div>
<?php
			
		}


?>
