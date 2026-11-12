<?php
include("include/connect.php");
include("include/select.php");
session_start();
error_reporting(0);

$id=$_SESSION['id'];
$m_id16=$_SESSION['m_id16'];
$ad =new select1;
if(!isset($_SESSION['id']))
{

        echo "<script type='text/javascript'>window.location='index.php?err'</script>"; 
}
else
{
        ini_set('upload_max_filesize', '20M');
        ini_set('post_max_size', '10M');
        ini_set('max_input_time', 300);
        ini_set('max_execution_time', 15000);

        include("include/excel_reader.php");
        include("encrypt.php");
        $sess_id=$_SESSION['id'];
        $command=$_POST['command'];
        $c_date=date('Y-m-d');
        date_default_timezone_set('Asia/Kolkata');
        $date = new DateTime();
        $c_time=$date->format( 'H:i:s A' );
        $ip_addr=$_SERVER['REMOTE_ADDR']; 
        $cur_year=date('Y');
        $excel = new PhpExcelReader;

    if($command === 'add_customer')
    {
            $state_id=$_POST['state_id'];
            $distributor_id=$_POST['distrib_id'];
            $file_name=$_FILES["userfile"]["name"];
            $file_size=$_FILES["userfile"]["size"];
            $file_temp=$_FILES['userfile']['tmp_name'];
            $file_mb1=round(($file_size / 1048576), 2);
            $file_mb=$file_mb1."MB";
            $ext = pathinfo($file_name, PATHINFO_EXTENSION);
            $random_no=rand(10000000,99999999);
            $head_no=$_POST['head_no'];
            $org_id=$_POST['organization'];

            $uploaded_files=$random_no."_".$file_name;
            $target_path = "upload/";
            move_uploaded_file($file_temp, $target_path.$uploaded_files);
            mysql_query("insert into excel_record(file_type,head_no,dist_id,file_name,file_size,uploaded_by,sess_id,c_date,c_time,ip_addr)values('$ext','$head_no','0','$uploaded_files','$file_mb','0','$sess_id','$c_date','$c_time','$ip_addr')")or die(mysql_error());
            $last_id=mysql_insert_id();
            //----------------------------------------------------------------//        
            ////////////////////////////////Function Starts/////////////////////////////
                    function sheetData($sheet,$last_id,$head_no) 
                     {
                        $x = $head_no;
                        $y = 1;
                        while($y <= $sheet['numCols']) 
                        {
                        $cell = isset($sheet['cells'][$x][$y]) ? $sheet['cells'][$x][$y] : '';
                        mysql_query("insert into excel_heading(record_id,heading_name,heading_no)values('$last_id','$cell','$y')");
                        $y++;
                        }  
                        $x++;
                     }
            ////////////////////////////////Function Ends/////////////////////////////// 
            $excel->read($target_path.$uploaded_files);
            $nr_sheets = count($excel->sheets);
            $excel_data = '';         
            $i=0;
            $excel_data .= sheetData($excel->sheets[$i],$last_id,$head_no);  
            echo "<script type=text/javascript>alert('".$file_name." uploaded sucessfully');window.location.href='customermatching.php?last_id=".encrypt($last_id)."&&dis_id=".encrypt($distributor_id)."&&state_id=".encrypt($state_id)."&&org_id=".$org_id."';</script>";

    }
    if($command === 'distributor_customer_save')
    {
        $record_id=$_POST['record_id'];
        $billno=$_POST['billno'];
        $billdate=$_POST['billdate'];
        $outamount=$_POST['outamount'];
        $clientname=$_POST['clientname'];
        $pincode=$_POST['pincode'];
        $mobileno=$_POST['mobileno'];
        $address=$_POST['address'];
        $type=$_POST['type']; 
        $org_id=$_REQUEST['org_id'];        

        $b=mysql_query("select * from excel_record where id='$record_id'")or die(mysql_error());
        $row_b=mysql_fetch_array($b);        
        $file_name=$row_b['file_name'];        
        $head_no=$row_b['head_no'];        
        $excel->read('upload/'.$file_name);

        ////////////////////////////////Function Starts/////////////////////////////
        function sheetData($sheet,$head_no) 
        {
            $x = $head_no+1;
            while($x <= $sheet['numRows']) 
            {
                global $clientname,$pincode,$mobileno,$address,$type,$record_id,$org_id;                   

                    $clientname1=isset($sheet['cells'][$x][$clientname]) ? $sheet['cells'][$x][$clientname] : '';
                    $clientname2=str_replace("'", "", $clientname1);

                    $pincode1=isset($sheet['cells'][$x][$pincode]) ? $sheet['cells'][$x][$pincode] : '';
                    $pincode2=str_replace("'", "", $pincode1);

                    $address1=isset($sheet['cells'][$x][$address]) ? $sheet['cells'][$x][$address] : '';
                    $address2=str_replace("'", "", $address1);

                    $mobileno1=isset($sheet['cells'][$x][$mobileno]) ? $sheet['cells'][$x][$mobileno] : '';
                    $mobileno2=str_replace("'", "", $mobileno1);

                    $type1=isset($sheet['cells'][$x][$type]) ? $sheet['cells'][$x][$type] : '';
                    $type2=str_replace("'", "", $type1); 

                    $d=mysql_query("select * from clinetcreation where name='$clientname2' AND pincode='$pincode2' AND mobileno='$mobileno2' AND repid='$org_id'");
                    $count_d=mysql_num_rows($d);
                    if($count_d==0) {
                        mysql_query("INSERT INTO clinetcreation(name,pincode,address,mobileno,type,repid,date,time) VALUES ('".$clientname2."','".$pincode2."','".$address2."','".$mobileno2."','".$type2."','".$org_id."','".date('Y-m-d')."','".date('H:i:s')."')")or die(mysql_error());                        
                   }
                    $x++;        
            }
        }
        ////////////////////////////////Function Ends///////////////////////////////
        $nr_sheets = count($excel->sheets);
        $excel_data = '';                         
        $i=0;
        sheetData($excel->sheets[$i],$head_no);       
         echo "<script type=text/javascript>alert('Values Stored into DB Successfully');window.location='customerupload.php';</script>";
$excelid=mysql_query("select * from excel_record order by id desc limit 1");
$na=mysql_fetch_array($excelid);
$idm=$na['id'];
$ma=$na['sheet_name'];
$path = "upload/$ma";
unlink($path);
mysql_query("DELETE FROM excel_record WHERE id = '".$_REQUEST["record_id"]."'") or die(mysql_error());
mysql_query("DELETE FROM excel_heading WHERE id = '".$_REQUEST["record_id"]."'") or die(mysql_error());
    }
    

if($_REQUEST['command'] == 'updatesaleperson')
    {
        
        mysql_query("UPDATE clinetcreation SET name='".$_REQUEST['cusname']."',pincode='".$_REQUEST['pincode']."',address='".$_REQUEST['address']."',mobileno='".$_REQUEST['mobileno']."',type ='".$_REQUEST['type']."' WHERE id='".$_REQUEST['spid']."'")or die(mysql_error());
        echo "<script type='text/javascript'>alert('Client Details Updated Successfully');window.location.href='customerupload.php';</script>";
    }

if($_REQUEST['command'] == 'updatesaleperson1')
    {
        
        mysql_query("INSERT INTO collection(billno,amount,clientid) VALUES ('".$_REQUEST['billno']."','".$_REQUEST['billamount']."','".$_REQUEST['spid']."')")or die(mysql_error());
        echo "<script type='text/javascript'>alert('bill Details Added Successfully');window.location.href='customerupload.php';</script>";
    }

    if($_REQUEST['command'] == 'updatesaleperson10')
    {           
        mysql_query("UPDATE collection SET amount='".$_REQUEST['billamount']."' WHERE billno='".$_REQUEST['spid']."'")or die(mysql_error());        
        echo "<script type='text/javascript'>alert('bill Updated Successfully');window.location.href='customerupload.php';</script>";
    }

 if($_REQUEST['command'] == 'addcustomerrep')
    {         
        mysql_query("INSERT INTO clinetcreation(name,address,pincode,type,mobileno,repid,date,time) VALUES ('".$_REQUEST['cusname']."','".$_REQUEST['address']."','".$_REQUEST['pincode']."','".$_REQUEST['type']."','".$_REQUEST['mobileno']."','".$_REQUEST['productname']."','".date('Y-m-d')."','".date('H:i:s')."')")or die(mysql_error());      
        echo "<script type='text/javascript'>alert('Customer Added Successfully');window.location.href='customerupload.php';</script>";
    }

 if($_REQUEST['command'] == 'assigningrep')
    {         
        mysql_query("INSERT INTO reorting(tdate,clientid,repid,scheduleddate,scheduledtime) VALUES ('".$_REQUEST['assigndate']."','".$_REQUEST['customername']."','".$_REQUEST['productname']."','".date('Y-m-d')."','".date('H:i:s')."')")or die(mysql_error());      
        echo "<script type='text/javascript'>alert('Rep Assigning Successfully');window.location.href='customerupload.php';</script>";
    }
    if(isset($_REQUEST['repid'])){
      
      $a=mysql_query("SELECT * from clinetcreation WHERE repid='".$_REQUEST['repid']."'") or die(mysql_error());
        ?> <option value="">---Select---</option><?php
        while($row=mysql_fetch_array($a))
        {?>
             
          <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
          <?php

        }
        }
    

if(isset($_REQUEST['organization'])){?>
        <div class="row-fluid sortable">    
<div class="box span12">
<div class="box-header well" data-original-title>
<h2><i class="icon-user"></i>Client Payment List </h2>
<div class="box-icon">
</div>
</div>
<div class="box-content">
<table class="table table-striped table-bordered bootstrap-datatable datatable">
  <thead>
    <tr>
            <th class="center">#</th>
           
            <th class="hidden-480">Client Name</th>
            <!-- <th class="hidden-480">supplier name</th>  --> 
            <th class="hidden-480">Pin Code</th>                                                      
            
            <th class="hidden-480">Mobile Number</th>
            <th class="hidden-480">Type</th>            
            
               <th class="hidden-480">Action</th>
            </tr>
  </thead>

  <tbody>
<?php





  $replist = mysql_query("SELECT * FROM clinetcreation WHERE repid='".$_REQUEST['organization']."'")or die(mysql_error());
  $replist_count = mysql_num_rows($replist);
  

  if($replist_count > 0)
  {
    $jj=1;
    while($replist_res = mysql_fetch_array($replist))
    {
       
 $replistview = mysql_query("SELECT * FROM collection WHERE clientid='".$replist_res['id']."'")or die(mysql_error());
  $replistview_count = mysql_fetch_array($replistview);

?>

    <tr class="commentlist">
        <td class="center"><?php echo $jj;?></td>
        
        <td class="hidden-480"><?php echo $replist_res['name'];?></td>
        <td class="hidden-480"><?php echo $replist_res['pincode'];?></td>             
        <td class="hidden-480"><?php echo $replist_res['mobileno'];?></td> 
         <td class="hidden-480"><?php echo $replist_res['type'];?></td>         
        <td><div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
          <u id="interview5" is_id5="<?php echo $replist_res['id']; ?>" class="custedit1 btn btn-info" style="cursor:pointer; text-decoration:none;"><i class="icon-edit icon-white"></i></u>
          <a class="btn btn-danger" href="javascript:delMe1(<?php echo $replist_res['id']; ?>)">
      <i class="icon-trash icon-white"></i>
      </a><u id="interview6" is_id6="<?php echo $replist_res['id']; ?>" class="custadd1 btn btn-success" style="cursor:pointer; text-decoration:none;margin-left: 3px;"><i class="icon-plus icon-white"></i></u>
       <?php
      if($replistview_count)
      {
        ?>
        <u id="interview7" is_id7="<?php echo $replist_res['id']; ?>" class="custview1 btn btn-warning" style="cursor:pointer; text-decoration:none;margin-left: 3px;"><i class="icon-list icon-white"></i></u>      
      
      <?php
    }?>
      </div>
    </td>


    </tr>

<?php
$jj++;
}
}
else
{
  ?>
<tr class="odd gradeX commentlist" align="center">
      <td colspan='7'>No data available</td>
    </tr>
    <?php
}

?>

  </tbody>
   </table>

</div>
</div>
</div> 

<script type="text/javascript">
$('.custedit1').click(function(){

  var is = confirm("Are you sure want to update?");

  if(is == true)
  {
  
  $.post("customeredit.php",{sid:$(this).attr("is_id5")},function(data){
 
  $(".modal-body5").html(data);
  $("#myModal5").modal(open);
  });
    
  }
  
});
$('.custadd1').click(function(){

  var is = confirm("Are you sure want to add bill Payment?");

  if(is == true)
  {
    
  $.post("customeredit.php",{sid1:$(this).attr("is_id6")},function(data){
 
  $(".modal-body6").html(data);
  $("#myModal6").modal(open);
  });
    
  }
  
});
$('.custview1').click(function(){

  $.post("customeredit.php",{sid2:$(this).attr("is_id7")},function(data){
 
  $(".modal-body7").html(data);
  $("#myModal7").modal(open);
  });
 
  
});</script>
 <script>
function delMe1(id)
{
if (confirm("Are you sure want to delete..?")) {
    document.location = "customerupload.php?mode=del1&spid="+id;
  }
}
</script>
<?php
    }
}
?>