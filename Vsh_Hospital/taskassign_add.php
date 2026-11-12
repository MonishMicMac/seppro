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

if(isset($_REQUEST['organization1'])){?>
      
  <div class="row-fluid sortable"> 

<div class="box span12">
<div class="box-header well" data-original-title>
<h2><i class="icon-user"></i>Repersentative List  <div class="pull-right" style="margin-left:475px;">
        <div class="col-xs-12">
            <input type="text" id="filter" class="form-control pull-right" placeholder="Search">           
        </div>
    </div></h2>
<div class="box-icon">
</div>
</div>
<div class="box-content">
 <input type="hidden" name="categoryid" class="categoryid" id="categoryid" value="<?php echo $_REQUEST['organization1'];?>">  
<table class="table table-striped table-bordered bootstrap-datatable datatable">
  <thead>
    <tr>
            <th class="center">#</th>
             <th class="hidden-480">Select</th>
           <th class="hidden-480">Rep Name</th>            
            <th class="hidden-480">Mobile Number</th>
            <th class="hidden-480">Email ID</th> 
            </tr>
  </thead>
  <tbody>
<?php
  $replist = mysql_query("SELECT * FROM representative WHERE rep_id='".$_REQUEST['organization1']."'")or die(mysql_error());
  $replist_count = mysql_num_rows($replist);
  if($replist_count > 0)
  {
    $jj=1;
    while($replist_res = mysql_fetch_array($replist))
    {     
?>
    <tr class="commentlist">
        <td class="center"><?php echo $jj;?></td> 
        <td class="hidden-480">
          <input type="checkbox" name="checkbox[]"  id="checkbox" class="checkbox" value="<?php echo $replist_res['id'];?>">           
                <label for="#"></label>
            </td>   

        <td class="hidden-480"><?php echo $replist_res['rep_name'];?></td>
        <td class="hidden-480"><?php echo $replist_res['mobile'];?></td>             
        <td class="hidden-480"><?php echo $replist_res['email'];?></td>
        
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

<hr style="border:1px solid #317eac;height: 0px;">

   <div class="controls">
    <table style="width:100%;">
    <tr>   
        <td style="width:20%;"><label>Select Trackers</label></td>   
        <td style="width:10%;"><label>
            <input name="form-field-radio" class="ace css-checkbox1" type="radio" id="tone" >
            <span class="lbl" value="cash" required>no Trackers</span></label></td>
        <td style="width:60%;"><label>
            <input name="form-field-radio" class="ace css-checkbox1" type="radio" id="ttwo" >
            <span class="lbl"value="cheque" required>Trackers</span></label></td>             
    </tr>
    </table>
</div>
<div id="nta">
  <div class="control-group">
    <label class="control-label" for="typeahead">Task Name<span style="color:#FF0000;">*</span></label>
  <div class="controls">
    <input class="form-control" name="tasknament" id="tasknament" placeholder="Enter Task Name" type="text" onKeyUp="this.value=this.value.replace(/[^a-zA-Z .,]/g,'');" required/>
  </div>
</div>
 <div class="controls">
    <table style="width:100%;">
    <tr>   
        <td style="width:10%;"><label>
            <input name="form-field-radionts1" value="low" class="ace css-checkbox2" type="radio" id="ntonel" >
            <span class="lbl" required>Low</span></label></td>
        <td style="width:10%;"><label>
            <input name="form-field-radionts1" value="medium" class="ace css-checkbox2" type="radio" id="nttwom" >
            <span class="lbl" required>MEDIUM</span></label></td>
        <td style="width:70%;"><label>
            <input name="form-field-radionts1" value="high" class="ace css-checkbox2" type="radio" id="ntthreeh" >
            <span class="lbl" required>HIGH</span></label></td>              
    </tr>
    </table>
</div>
<div class="control-group">
    <label class="control-label" for="typeahead">Task Complete Date<span style="color:#FF0000;">*</span></label>
  <div class="controls">
    <input class="form-control" name="taskcompletedatent" id="taskcompletedatent" placeholder="Select Task Complete Date" type="text" required/>
  </div>
</div>
<div class="control-group">
    <label class="control-label" for="typeahead">Task Complete Time<span style="color:#FF0000;">*</span></label>
  <div class="controls">
    <input class="form-control" name="taskcompletetiment" id="taskcompletetiment" placeholder="Enter Task Complete Time" type="text" required/>
  </div>
</div>
<div class="control-group">
    <label class="control-label" for="typeahead">Task Decsription<span style="color:#FF0000;">*</span></label>
  <div class="controls">
     <textarea name="taskdescriptionnt" id="taskdescriptionnt" placeholder="Enter Task Description" class="form-control" onKeyUp="this.value=this.value.replace(/[^a-zA-Z .,]/g,'');" required></textarea>  
  </div>
</div>
<div class="form-actions"><label type="submit" class="btn btn-primary" name="submitnt" id="submitnt" >Submit</label></div>
 
</div>
<div id="tb">
 <div class="control-group">
    <label class="control-label" for="typeahead">Select Rep Name<span style="color:#FF0000;">*</span></label>
<div class="controls">
<select name="organizationt" id="organizationt"  required>
         <option value="">-----Select Rep Name-----</option>
<?php
$manager = mysql_query("SELECT * FROM category")or die(mysql_error());

$managercount =  mysql_num_rows($manager);
if($managercount > 0)
{
  while($manager_res = mysql_fetch_array($manager))
  {
?>
        <option value="<?php echo $manager_res['catid'];?>"><?php echo $manager_res['catname'];?></option>
<?php 
  }
}
else
{
?>  
    <option value="">No records found</option>
<?php
}
?>  
        </select>

</div></div>

  <div class="loadsuppliert">    
  </div>
</div>

<script type="text/javascript">
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
  
</script>
<script type="text/javascript">
   $(document).ready(function () {
    $('#nta').hide();
    $('#tb').hide();
        $(".css-checkbox1").click(function () {
              var numbers = new Array();
              $('.checkbox:checked').each(function(){
                numbers.push($(this).val());                
              });
            if ($(this).attr('id') == "tone") {
              if(numbers !='')
              {
                $('#nta').show();
                $('#tb').hide();  
              }
              else
              {
                alert("select representative Checkbox");
                $(this).attr('checked', false);
              }           
                
            } else {
              if(numbers !='')
              {
                $('#nta').hide();
                $('#tb').show();
              }
              else
              {
                alert("select representative Checkbox");
                $(this).attr('checked', false);
              }
               
            }
        });

    });
      $("#organizationt").change(function(){  
        // alert("hi");
      
      // alert($('#organization1').val());
        $.post("taskassign_add.php",{organizationt1:$('#organizationt').val()}, function( data ) {
          $('.loadsuppliert').html(data);
        });    
      });



       $('#submitnt').click(function(){
               var numbers = new Array();
              $('.checkbox:checked').each(function(){
                numbers.push($(this).val());                
              });  
              // alert(numbersall);
              var taskname =$('#tasknament').val();              
              var periority =$('input[name=form-field-radionts1]:checked').val();
              var taskcompletedate =$('#taskcompletedatent').val();
              var taskcompletetime =$('#taskcompletetiment').val();
              var taskdescription =$('#taskdescriptionnt').val();  
              //  alert(numbers);              
              // alert(taskname);  
              // alert(periority);  
              // alert(taskcompletedate);  
              // alert(taskcompletetime);          
              // alert(taskdescription);             
              $.post("taskassign_save.php",{taskname:taskname,periority:periority,taskcompletedate:taskcompletedate,taskcompletetime:taskcompletetime,taskdescription:taskdescription,taskowner:numbers,submitsept1:'insert'}, function( data ) {         
        });    
      });
</script>
 <script type="text/javascript">
   $(function(){ $( "#taskcompletedatent" ).datepicker(); 
    $('#taskcompletetiment').timepicker(); });
                </script>
<?php 
}

if(isset($_REQUEST['organizationt1'])) { ?>
  <div class="row-fluid sortable"> 
<div class="box span12">
<div class="box-header well" data-original-title>
<h2><i class="icon-user"></i>Repersentative List  <div class="pull-right" style="margin-left:475px;">
        <div class="col-xs-12">
            <input type="text" id="filtert" class="form-control pull-right" placeholder="Search">           
        </div>
    </div></h2>
<div class="box-icon">
</div>
</div>
<div class="box-content">
 <input type="hidden" name="categoryid" class="categoryidt" id="categoryidt" value="<?php echo $_REQUEST['organization1'];?>">  
<table class="table table-striped table-bordered bootstrap-datatable datatable">
  <thead>
    <tr>
            <th class="center">#</th>
             <th class="hidden-480">Select</th>
           <th class="hidden-480">Rep Name</th>            
            <th class="hidden-480">Mobile Number</th>
            <th class="hidden-480">Email ID</th> 
            </tr>
  </thead>
  <tbody>
<?php
  $replist = mysql_query("SELECT * FROM representative WHERE rep_id='".$_REQUEST['organizationt1']."'")or die(mysql_error());
  $replist_count = mysql_num_rows($replist);
  if($replist_count > 0)
  {
    $jj=1;
    while($replist_res = mysql_fetch_array($replist))
    {     
?>
    <tr class="commentlistt">
        <td class="center"><?php echo $jj;?></td> 
        <td class="hidden-480">
          <input type="checkbox" name="checkboxt[]"  id="checkboxt" class="checkboxt" value="<?php echo $replist_res['id'];?>">           
                <label for="#"></label>
            </td>   

        <td class="hidden-480"><?php echo $replist_res['rep_name'];?></td>
        <td class="hidden-480"><?php echo $replist_res['mobile'];?></td>             
        <td class="hidden-480"><?php echo $replist_res['email'];?></td>
        
    </tr>
<?php
$jj++;
}
}
else
{
  ?>
<tr class="odd gradeX commentlistt" align="center">
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

<hr style="border:1px solid #317eac;height: 0px;">

<div class="control-group">
    <label class="control-label" for="typeahead">Task Name<span style="color:#FF0000;">*</span></label>
  <div class="controls">
    <input class="form-control" name="taskname" id="taskname" placeholder="Enter Task Name" type="text" onKeyUp="this.value=this.value.replace(/[^a-zA-Z .,]/g,'');" required/>
  </div>
</div>
 <div class="controls">
    <table style="width:100%;">
    <tr>   
        <td style="width:10%;"><label>
            <input name="form-field-radios" value="low" class="ace css-checkbox2" type="radio" id="tonel" >
            <span class="lbl" required>Low</span></label></td>
        <td style="width:10%;"><label>
            <input name="form-field-radios" value="medium" class="ace css-checkbox2" type="radio" id="ttwom" >
            <span class="lbl" required>MEDIUM</span></label></td>
        <td style="width:70%;"><label>
            <input name="form-field-radios" value="high" class="ace css-checkbox2" type="radio" id="ttwoh" >
            <span class="lbl" required>HIGH</span></label></td>              
    </tr>
    </table>
</div>
<div class="control-group">
    <label class="control-label" for="typeahead">Task Complete Date<span style="color:#FF0000;">*</span></label>
  <div class="controls">
    <input class="form-control" name="taskcompletedate" id="taskcompletedate" placeholder="Select Task Complete Date" type="text" required/>
  </div>
</div>
<div class="control-group">
    <label class="control-label" for="typeahead">Task Complete Time<span style="color:#FF0000;">*</span></label>
  <div class="controls">
    <input class="form-control" name="taskcompletetime" id="taskcompletetime" placeholder="Enter Task Complete Time" type="text" required/>
  </div>
</div>
<div class="control-group">
    <label class="control-label" for="typeahead">Task Decsription<span style="color:#FF0000;">*</span></label>
  <div class="controls">
     <textarea name="taskdescription" id="taskdescription" placeholder="Enter Task Description" class="form-control" onKeyUp="this.value=this.value.replace(/[^a-zA-Z .,]/g,'');" required></textarea>  
  </div>
</div>
<div class="form-actions"><label type="submit" class="btn btn-primary" name="submit" id="submit" >Submit</label></div>

<script type="text/javascript">

 $("#filtert").keyup(function(){

       // Retrieve the input field text and reset the count to zero
       var filter = $(this).val(), count = 0;

       // Loop through the comment list
       $(".commentlistt").each(function(){

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
    $("#taskname").keyup(function(){  
      var numbers = new Array();
              $('.checkboxt:checked').each(function(){
                numbers.push($(this).val());                
              });
              if(numbers !='')
              {

              }
              else
              {
                 alert("select tracker representative Checkbox");
                 $('#taskname').val('');
              }
       
      });
    $("#taskcompletedate").click(function(){  
      var numbers = new Array();
              $('.checkboxt:checked').each(function(){
                numbers.push($(this).val());                
              });
               if(numbers !='')
              {

              }
              else
              {
                 alert("select tracker representative Checkbox");
                 $('#taskcompletedate').val('');
              }
       
      });
    $("#taskcompletetime").click(function(){ 
    var numbers = new Array();
              $('.checkboxt:checked').each(function(){
                numbers.push($(this).val());                
              }); 
               if(numbers !='')
              {

              }
              else
              {
                 alert("select tracker representative Checkbox");
                 $('#taskcompletetime').val('');
              }
       
      });
    $("#taskdescription").keyup(function(){ 
    var numbers = new Array();
              $('.checkboxt:checked').each(function(){
                numbers.push($(this).val());                
              }); 
               if(numbers !='')
              {

              }
              else
              {
                 alert("select tracker representative Checkbox");
                 $('#taskdescription').val('');
              }       
      });

     $('#submit').click(function(){
      var numberst = new Array();
              $('.checkboxt:checked').each(function(){
                numberst.push($(this).val());                
              }); 
               var numbers = new Array();
              $('.checkbox:checked').each(function(){
                numbers.push($(this).val());                
              });              
            var taskname =$('#taskname').val();              
              var periority =$('input[name=form-field-radios]:checked').val();
              var taskcompletedate =$('#taskcompletedate').val();
              var taskcompletetime =$('#taskcompletetime').val();
              var taskdescription =$('#taskdescription').val();
              var organizationttrack =$('#organizationt').val();  
              alert(taskname);  
              alert(periority);  
              alert(taskcompletedate);  
              alert(taskcompletetime);          
              alert(taskdescription); 
              alert(organizationttrack);  
              
              $.post("taskassign_save.php",{taskname:taskname,periority:periority,taskcompletedate:taskcompletedate,taskcompletetime:taskcompletetime,taskdescription:taskdescription,taskowner:numbers,tracker:numberst,organizationttrack:organizationttrack,submitsept:'insert'}, function( data ) {                
        });    
      });
  
   </script>
   <script type="text/javascript">
   $(function(){ $( "#taskcompletedate" ).datepicker();
   $('#taskcompletetime').timepicker(); });
                </script>
<?php 
}

if(isset($_REQUEST['organizationt1all'])) { ?>
  <div class="row-fluid sortable"> 
<div class="box span12">
<div class="box-header well" data-original-title>
<h2><i class="icon-user"></i>Repersentative List  <div class="pull-right" style="margin-left:475px;">
        <div class="col-xs-12">
            <input type="text" id="filtertall" class="form-control pull-right" placeholder="Search">           
        </div>
    </div></h2>
<div class="box-icon">
</div>
</div>
<div class="box-content">
 <input type="hidden" name="categoryidall" class="categoryidtall" id="categoryidtall" value="<?php echo $_REQUEST['organizationt1all'];?>">  
<table class="table table-striped table-bordered bootstrap-datatable datatable">
  <thead>
    <tr>
            <th class="center">#</th>
             <th class="hidden-480">Select</th>
           <th class="hidden-480">Rep Name</th>            
            <th class="hidden-480">Mobile Number</th>
            <th class="hidden-480">Email ID</th> 
            </tr>
  </thead>
  <tbody>
<?php
  $replist = mysql_query("SELECT * FROM representative WHERE rep_id='".$_REQUEST['organizationt1all']."'")or die(mysql_error());
  $replist_count = mysql_num_rows($replist);
  if($replist_count > 0)
  {
    $jj=1;
    while($replist_res = mysql_fetch_array($replist))
    {     
?>
    <tr class="commentlistt">
        <td class="center"><?php echo $jj;?></td> 
        <td class="hidden-480">
          <input type="checkbox" name="checkboxtall[]"  id="checkboxtall" class="checkboxtall" value="<?php echo $replist_res['id'];?>">           
                <label for="#"></label>
            </td>   

        <td class="hidden-480"><?php echo $replist_res['rep_name'];?></td>
        <td class="hidden-480"><?php echo $replist_res['mobile'];?></td>             
        <td class="hidden-480"><?php echo $replist_res['email'];?></td>
        
    </tr>
<?php
$jj++;
}
}
else
{
  ?>
<tr class="odd gradeX commentlisttall" align="center">
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

<hr style="border:1px solid #317eac;height: 0px;">

<div class="control-group">
    <label class="control-label" for="typeahead">Task Name<span style="color:#FF0000;">*</span></label>
  <div class="controls">
    <input class="form-control" name="tasknameall" id="tasknameall" placeholder="Enter Task Name" type="text" onKeyUp="this.value=this.value.replace(/[^a-zA-Z .,]/g,'');" required/>
  </div>
</div>
 <div class="controls">
    <table style="width:100%;">
    <tr>   
        <td style="width:10%;"><label>
            <input name="form-field-radioa" value="low" class="ace css-checkbox2all" type="radio" id="tonelall" />
            <span class="lbl"  required>Low</span></label></td>
        <td style="width:10%;"><label>
            <input name="form-field-radioa" value="medium" class="ace css-checkbox2all" type="radio" id="ttwomall" />
            <span class="lbl" required>MEDIUM</span></label></td>
        <td style="width:70%;"><label>
            <input name="form-field-radioa" value="high" class="ace css-checkbox2all" type="radio" id="ttwohall" />
            <span class="lbl" required>HIGH</span></label></td>              
    </tr>
    </table>
</div>
<div class="control-group">
    <label class="control-label" for="typeahead">Task Complete Date<span style="color:#FF0000;">*</span></label>
  <div class="controls">
    <input class="form-control" name="taskcompletedateall" id="taskcompletedateall" placeholder="Select Task Complete Date" type="text" required/>
  </div>
</div>
<div class="control-group">
    <label class="control-label" for="typeahead">Task Complete Time<span style="color:#FF0000;">*</span></label>
  <div class="controls">
    <input class="form-control" name="taskcompletetimeall" id="taskcompletetimeall" placeholder="Enter Task Complete Time" type="text" required/>
  </div>
</div>
<div class="control-group">
    <label class="control-label" for="typeahead">Task Decsription<span style="color:#FF0000;">*</span></label>
  <div class="controls">
     <textarea name="taskdescriptionall" id="taskdescriptionall" placeholder="Enter Task Description" class="form-control" onKeyUp="this.value=this.value.replace(/[^a-zA-Z .,]/g,'');" required></textarea>  
  </div>
</div>
<div class="form-actions"><label type="submit" class="btn btn-primary" name="submitall" id="submitall" >Submit</label></div>

<script type="text/javascript">

 $("#filtertall").keyup(function(){

       // Retrieve the input field text and reset the count to zero
       var filter = $(this).val(), count = 0;

       // Loop through the comment list
       $(".commentlisttall").each(function(){

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
    $("#tasknameall").click(function(){  
      var numbers = new Array();
              $('.checkboxtall:checked').each(function(){
                numbers.push($(this).val());                
              });
              if(numbers !='')
              {

              }
              else
              {
                 alert("select tracker representative Checkbox");
                 $('#tasknameall').val('');
              }
       
      });
    $("#taskcompletedateall").click(function(){  
      var numbers = new Array();
              $('.checkboxtall:checked').each(function(){
                numbers.push($(this).val());                
              });
               if(numbers !='')
              {

              }
              else
              {
                 alert("select tracker representative Checkbox");
                  $('#taskcompletedateall').val('');
              }
       
      });
    $("#taskcompletetimeall").click(function(){ 
    var numbers = new Array();
              $('.checkboxtall:checked').each(function(){
                numbers.push($(this).val());                
              }); 
               if(numbers !='')
              {

              }
              else
              {
                 alert("select tracker representative Checkbox");
                  $('#taskcompletetimeall').val('');
              }
       
      });
    $("#taskdescriptionall").click(function(){ 
    var numbers = new Array();
              $('.checkboxtall:checked').each(function(){
                numbers.push($(this).val());                
              }); 
               if(numbers !='')
              {

              }
              else
              {
                 alert("select tracker representative Checkbox");
                  $('#taskdescriptionall').val('');
              }       
      });
    $(".css-checkbox2all").click(function(){
      alert("hi");
      alert();
    });

     $('#submitall').click(function(){
      var numberstall = new Array();
              $('.checkboxtall:checked').each(function(){
                numberstall.push($(this).val());                
              });                
               var numbersall = new Array();
              $('.reid').each(function(){
                numbersall.push($(this).val());                
              });  
              var taskname =$('#tasknameall').val();              
              var periority =$('input[name=form-field-radioa]:checked').val();
              var taskcompletedate =$('#taskcompletedateall').val();
              var taskcompletetime =$('#taskcompletetimeall').val();
              var taskdescription =$('#taskdescriptionall').val();
              var organizationttrack =$('#organizationtll').val();    
              // alert(taskname);  
              // alert(periority);  
              // alert(taskcompletedate);  
              // alert(taskcompletetime);          
              // alert(taskdescription);  
              // alert(organizationttrack);  
              $.post("taskassign_save.php",{taskname:taskname,periority:periority,taskcompletedate:taskcompletedate,taskcompletetime:taskcompletetime,taskdescription:taskdescription,taskowner:numbersall,tracker:numberstall,organizationttrack:organizationttrack,submitallt:'insert'}, function( data ) {         
        });    
      });

 
  
   </script>
   <script type="text/javascript">
   $(function(){ $( "#taskcompletedateall" ).datepicker(); 
 $('#taskcompletetimeall').timepicker();});
                </script>
<?php 
}

} ?>