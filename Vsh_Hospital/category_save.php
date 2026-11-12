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
 if(isset($_REQUEST['addcategoryname1'])){  

  mysql_query("INSERT INTO category(catname)VALUES('".$_REQUEST["addcategoryname1"]."')")or die(mysql_error());


                                      
                                            $schoolname = mysql_query("SELECT * FROM category WHERE catname='".$_REQUEST["addcategoryname1"]."'")or die(mysql_error());
                                                         $schoolname_count = mysql_num_rows($schoolname);
                                                         $schoolname1_count = mysql_fetch_array($schoolname);
                                                         ?><option value="<?php echo $schoolname1_count['catid'];?>"><?php echo $_REQUEST["addcategoryname1"];?></option><?php
                                        if($schoolname_count > 0)
                                        {
                                          while($schoolname_res = mysql_fetch_array($schoolname))
                                          {?>
                                          
                                        <option  value="<?php echo $schoolname_res['catid'];?>"><?php echo $schoolname_res['catname'];?></option>
                                          <?php
                                          }
                                        }
                                        else
                                        {
                                        ?>
                                     <option  value="">No record found</option>
                                        <?php
                                        }
                                      
}
if(isset($_REQUEST['repname'])){
  mysql_query("UPDATE representative SET rep_name='".$_REQUEST['repname']."',email='".$_REQUEST['emailid']."',mobile='".$_REQUEST['mobileno']."' WHERE id='".$_REQUEST['spid']."'")or die(mysql_error());  

} 
if(isset($_REQUEST['repname1'])){
  mysql_query("INSERT INTO representative(rep_name,mobile,email,rep_id)VALUES('".$_REQUEST["repname1"]."','".$_REQUEST["mobileno1"]."','".$_REQUEST["emailid1"]."','".$_REQUEST["organn1"]."')")or die(mysql_error());  

} 
if(isset($_REQUEST['organization1'])){?>
      
 
<div class="row-fluid sortable"> 

<div class="box span12">
<div class="box-header well" data-original-title>
<h2><i class="icon-user"></i>Repersentative List  <div class="pull-right" style="margin-left:475px;">
        <div class="col-xs-12">
            <input type="text" id="filter" class="form-control pull-right" placeholder="Search">
            <u id="interview10" is_id2="<?php echo $_REQUEST['organization1']; ?>" class="repadd btn btn-primary" style="cursor:pointer; text-decoration:none;margin-left:25px;">Rep ADD</u>
        </div>
    </div></h2>
<div class="box-icon">
</div>
</div>
<div class="box-content">  
<table class="table table-striped table-bordered bootstrap-datatable datatable">
  <thead>
    <tr>
            <th class="center">#</th>
           <th class="hidden-480">Rep Name</th>            
            <th class="hidden-480">Mobile Number</th>
            <th class="hidden-480">Email ID</th>       
            <th class="hidden-480">Action</th>
            </tr>
  </thead>

  <tbody>
<?php





  $replist = mysql_query("SELECT * FROM clinetcreation")or die(mysql_error());
  $replist_count = mysql_num_rows($replist);
  

  if($replist_count > 0)
  {
    $jj=1;
    while($replist_res = mysql_fetch_array($replist))
    {
     
?>

    <tr class="commentlist">
        <td class="center"><?php echo $jj;?></td>
        
        <td class="hidden-480"><?php echo $replist_res['rep_name'];?></td>
        <td class="hidden-480"><?php echo $replist_res['mobile'];?></td>             
        <td class="hidden-480"><?php echo $replist_res['email'];?></td>         
          <td><div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
          <u id="interview" is_id="<?php echo $replist_res['id']; ?>" class="custedit btn btn-info" style="cursor:pointer; text-decoration:none;"><i class="icon-edit icon-white"></i></u>
          <a class="custdel btn btn-danger" is_id1="<?php echo $replist_res['id']; ?>" style="cursor:pointer; text-decoration:none;">
      <i class="icon-trash icon-white"></i>
      </a>     
     
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
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Category Details Edit</h4>
        </div>
        <div class="modal-body">
          
        </div>
            <!--<div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>-->
      </div>
      
    </div>
  </div>
  <div class="modal fade" id="myModaladd" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Representative ADD</h4>
        </div>
        <div class="modal-bodyadd">
          
        </div>
            <!--<div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>-->
      </div>
      
    </div>
  </div>
<script>
  $("#filter").keyup(function(){

       // Retrieve the input field text and reset the count to zero
       var filter = $(this).val(), count = 0;

       // Loop through the comment list
       $(".commentlist").each(function(){

           // If the list item does not contain the text phrase fade it out
           if ($(this).text().search(new RegExp(filter, "i")) < 0) {
               $(this).fadeOut();

           // Show the list item if the phrase matches and increase the count by 1
           } else {
               $(this).show();
               count++;
           }
       });

   });
  $('.custedit').click(function(){

  var is = confirm("Are you sure want to update?");

  if(is == true)
  {
  
  $.post("category_edit.php",{sid:$(this).attr("is_id")},function(data){
 
  $(".modal-body").html(data);
  $("#myModal").modal(open);
   
  });
      // $.post("category_save.php",{organization1:$('#is_id').val()}, function( data ) {
      //     $('.loadsupplier').html(data);
      //   });  
  }
 
  
});


   $('.repadd').click(function(){
      var is = confirm("Are you sure want to ADD?");

  if(is == true)
  { 
  $.post("category_edit.php",{sid2:$(this).attr("is_id2")},function(data){
    // alert(data);
 
  $(".modal-bodyadd").html(data);
  $("#myModaladd").modal(open);
  });
}
});

   $(".custdel").click(function(){ 
           var is = confirm("Are you sure want to Delete?");

  if(is == true)
  {
          $.post("category_edit.php",{sid1:$(this).attr("is_id1")}, function( data ) {
            // alert(data);
             $.post("category_save.php",{organization1:$('#organization').val()}, function( data ) {
          $('.loadsupplier').html(data);
        });
            
       }); 
        }
        });

</script>
<?php
    }
   


}?>