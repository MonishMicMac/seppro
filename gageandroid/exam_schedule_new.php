<?php
$GLOBALS["RPxHijpTjaBHMJcLBwsy"]=base64_decode("bV9pZA==");$GLOBALS["pwYytlaFaqmEuHBTgqKT"]=base64_decode("aW5jbHVkZXNfc21zL2hlYWRlcjFfc21zLnBocA==");$GLOBALS["ciOJXoNuerHptaIXtHZq"]=base64_decode("PHNjcmlwdCB0eXBlPXRleHQvamF2YXNjcmlwdD53aW5kb3cubG9jYXRpb249J2luZGV4LnBocD9lcnInOzwvc2NyaXB0Pg==");$GLOBALS["dKpMLxpUlLerOdzvVkTc"]=base64_decode("aW5jbHVkZXNfc21zL2Nvbm5lY3RzbXMucGhw");$GLOBALS["CNgjOHWuFLqAzPPTvmPo"]=base64_decode("U0VMRUNUICogRlJPTSBgbXN0X2V4YW1uYW1lYCBHUk9VUCBCWSBleGFtX25hbWU=");$GLOBALS["PPYMENJAFEqCTqjEYtRp"]=base64_decode("ZW5faWQ=");$GLOBALS["clEhNfSOgBDjsCkLSYIb"]=base64_decode("ZXhhbV9uYW1l");$GLOBALS["bCmpGMXHvxcwXtdVqZpE"]=base64_decode("U0VMRUNUICogRlJPTSBtc3Rfc3RfbmFtZXMgT1JERVIgQlkgc25faWQ=");$GLOBALS["CkDsvIzsdEeOtvprYctd"]=base64_decode("c25faWQ=");$GLOBALS["zmYUNJypMoepQqvClLw"]=base64_decode("c19uYW1lcw==");$GLOBALS["vWLEBSBGpbhdOhUNYTkn"]=base64_decode("dXBkYXRlZXhhbWlk");$GLOBALS["UbaRplKViRcaastqgwct"]=base64_decode("cG9zdGV4YW1fc2VsZWN0");$GLOBALS["ulEJZztLLkuBjKCMLI"]=base64_decode("cG9zdGV4YW1kYXRl");$GLOBALS["NeEpoqFHXrKePHrDMboS"]=base64_decode("WS1tLWQ=");$GLOBALS["tImyYUQfBugZgYPvXodY"]=base64_decode("c2NoZWR1bGVkZXhhbXBvc3Rwb25l");$GLOBALS["fRnFRTrEFwzqtGqZMDGj"]=base64_decode("Y29tbWFuZA==");$GLOBALS["usbLJpncbxnouvhTXMFw"]=base64_decode("aW5jbHVkZXNfc21zL2Zvb3RlcjFfc21zLnBocA==");$GLOBALS["POrOCvAZfDXbyvLJuzqm"]=base64_decode("PHNjcmlwdCB0eXBlID0ndGV4dC9qYXZhc2NyaXB0Jz4gYWxlcnQoJ0V4YW0gUG9zdHBvbmVkIFN1Y2Nlc3NmdWxseScpO3dpbmRvdy5sb2NhdGlvbi5ocmVmPSd2aWV3ZXhhbXRpbWV0YWJsZS5waHAnOzwvc2NyaXB0Pg==");$GLOBALS["CGbFgRIFcNnyLvvmfknU"]=base64_decode("Jw==");$GLOBALS["JYhRhtmtSZVerpRtlsgU"]=base64_decode("JyBXSEVSRSBleGFtX3NjaGVkdWxlX2lkPSc=");$GLOBALS["zmexNmUeDdXKIKsrqFgz"]=base64_decode("JyxleGFtX3NjaGVkdWxlX2NkYXRlPSc=");$GLOBALS["UOuiwssmrJsQRztgCGnd"]=base64_decode("JyxleGFtX3NjaGVkdWxlX3Nlc3Npb249Jw==");$GLOBALS["nYRABtrxVhXrpyGYWQec"]=base64_decode("VVBEQVRFIHRibF9leGFtX3NjaGVkdWxlIFNFVCBleGFtX3NjaGVkdWxlX2RhdGU9Jw==");
?><?php session_start(); include($GLOBALS["dKpMLxpUlLerOdzvVkTc"]); error_reporting(0); $OHwyWTqXBFcsSIDUrLFw=$_SESSION[$GLOBALS["RPxHijpTjaBHMJcLBwsy"]]; if(!isset($_SESSION[$GLOBALS["RPxHijpTjaBHMJcLBwsy"]])) { echo $GLOBALS["ciOJXoNuerHptaIXtHZq"]; } else { include($GLOBALS["pwYytlaFaqmEuHBTgqKT"]); ?>
<div class="page-content-wrapper">
<div class="content">
         
          <div class="jumbotron" data-pages="parallax">
            <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20" style="background-color:#2B303B;">
              <div class="inner">
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                  <li>
                    <p><?=$_SESSION["_LOG"]; ?></p>
                  </li>
                  <li><a href="" class="active">Exam Schedule</a>
                  </li>
                </ul>
                <!-- END BREADCRUMB -->
                </div>
            </div>
          </div>
<div class="container-fluid container-fixed-lg">
<div class="row">
<div class="col-md-12">
<div class="panel panel-default">
<div class="panel-heading">
<div class="panel-title">Exam Schedule <span style="margin-left:800px;"><a href="viewexamtimetable.php">View Scheduled Exams</a></span>
</div>
</div>
<div class="panel-body"> 


<form name="form" role="form" action="examschedule_insert.php" method="post" enctype="multipart/form-data" >
 <div class="col-md-2">
      <div class="form-group form-group-default  ">
          <select name="term_name" id="term_name" class="full-width" data-init-plugin="select2" required>
     		 <option value="">Term Name</option>
          <?php $qwBLDgvBAXuHlfqdfvPd = mysql_query($GLOBALS["CNgjOHWuFLqAzPPTvmPo"])or die(mysql_error()); $XgXAlZifNpYukGzBEoVk = mysql_num_rows($qwBLDgvBAXuHlfqdfvPd); if($XgXAlZifNpYukGzBEoVk > 0) { while($nrQyQNmEdfrGgiBGYeWb = mysql_fetch_array($qwBLDgvBAXuHlfqdfvPd)) { ?>
                	<option value="<?php echo $nrQyQNmEdfrGgiBGYeWb[$GLOBALS["PPYMENJAFEqCTqjEYtRp"]];?>"><?php echo $nrQyQNmEdfrGgiBGYeWb[$GLOBALS["clEhNfSOgBDjsCkLSYIb"]];?></option>
                <?php } } else { ?>
            	<option value="">No records found</option>
            <?php } ?>
	      </select>
       </div> 
  </div>


  <div class="col-md-2">
       <div class="form-group form-group-default  ">
           <select name="exam_name" id="exam_name" class="full-width" data-init-plugin="select2" required>
             	 <option value="">Exam Name</option>
                                  
           </select>  
   
        </div>
     </div>  
 
  <div class="col-md-2">
      	<div class="form-group form-group-default  ">
              <select name="standard" id="standard"    class="full-width" data-init-plugin="select2" required>
                   <option value="">Standard</option>
                      <?php $BDgRmrksGWpNkBCtYFaG = mysql_query($GLOBALS["bCmpGMXHvxcwXtdVqZpE"])or die(mysql_error()); $pCccnnrkEIiDIUUxRRdT = mysql_num_rows($BDgRmrksGWpNkBCtYFaG); if($pCccnnrkEIiDIUUxRRdT > 0) { while($JpUqsEGnMViDELspHrUB = mysql_fetch_array($BDgRmrksGWpNkBCtYFaG)) {?>
                                <option  value="<?php echo $JpUqsEGnMViDELspHrUB[$GLOBALS["CkDsvIzsdEeOtvprYctd"]];?>"><?php echo $JpUqsEGnMViDELspHrUB[$GLOBALS["zmYUNJypMoepQqvClLw"]];?></option>
                              <?php } } else { ?>
                                 <option  value="">No record found</option>
						   <?php } ?>
                                  
                 </select>
         </div> 
      </div>
                    
                    
   <div class="col-md-2">
      <div class="form-group form-group-default  ">
          <select name="section" id="section"    class="full-width jjsection" data-init-plugin="select2" required>
     		 	<option value="">Section</option>
   	      </select>
	 </div> 
  </div>

 <div class="col-md-2">
      <div class="form-group form-group-default">
      <select name="subject" class="full-width jjsection" data-init-plugin="select2"  id="subject_ptr" required>
<option value="">Subject</option>
</select>
      </div></div>

<div class="col-md-2">
<div class="form-group form-group-default ">
<input type="text" name="max_mark" id="max_mark" placeholder="Max Mark" class="form-control" required maxlength="3" />
</div> 
</div><br>
<div class="row">
<div class="checkbox check-warning">
<input type="checkbox"  name="exam_type" id="exam_type" value="1">
<label for="exam_type">Select(Exam Type : Listening,Oral,Written )</label>
</div>
<div id="examtype" style="display:none">

<div class="col-md-2">
<label><input type="checkbox" class="ex_type" value="listen" id="listen_check"> Listening</label>
<div class="form-group form-group-default " id="listen">
<input type="text" name="max_mark1" id="max_mark1" placeholder="Listening" maxlength="3" class="form-control" />
</div> 
</div>
<div class="col-md-2">
<label><input type="checkbox" class="ex_type" value="oral" id="oral_check"> Oral</label>
<div class="form-group form-group-default " id="oral">
<input type="text" name="max_mark2" id="max_mark2" placeholder="Oral" maxlength="3" class="form-control" />
</div> 
</div>
<div class="col-md-2">
<label><input type="checkbox" class="ex_type" value="written" id="written_check"> Written</label>
<div class="form-group form-group-default " id="written">
<input type="text" name="max_mark3" id="max_mark3" placeholder="Written" maxlength="3" class="form-control" />
</div> 
</div>
</div>

<div class="col-md-2">
<label>Exam Date</label>
<div class="form-group form-group-default  ">
<input type="text" name="exam_date" id="exam_date" class="form-control" placeholder='dd-mm-yyyy' readonly required />
</div>
</div>

<div class="col-md-2">
<label>Portions</label>
<div class="form-group form-group-default ">
<textarea name="portions" id="portions" placeholder="Exam Portions" class="form-control" /></textarea>
</div>
</div> 

<div class="col-md-2">
<label>Session</label>
<div class="radio radio-success">
<input id="an" type="radio" name="exam_select" value="0" required>
<label for="an">Forenoon</label> 
<input id="fn" type="radio" name="exam_select" value="1" required>
<label for="fn">Afternoon</label> 
</div>   </div>       
 </div>         
    


<input type="submit" name="submit" id="submit" class="btn btn-complete btn-cons " style="margin-top:5px; margin-left:8px;" value="Schedule">
</div>

</form>    
    
    
          
</div>
</div>
</div>
</div>
</div>
</div>
</div>
  <?php if(isset($_REQUEST[$GLOBALS["fRnFRTrEFwzqtGqZMDGj"]])==$GLOBALS["tImyYUQfBugZgYPvXodY"]) { mysql_query($GLOBALS["nYRABtrxVhXrpyGYWQec"].date($GLOBALS["NeEpoqFHXrKePHrDMboS"],strtotime($_REQUEST[$GLOBALS["ulEJZztLLkuBjKCMLI"]])).$GLOBALS["UOuiwssmrJsQRztgCGnd"].$_REQUEST[$GLOBALS["UbaRplKViRcaastqgwct"]].$GLOBALS["zmexNmUeDdXKIKsrqFgz"].date($GLOBALS["NeEpoqFHXrKePHrDMboS"]).$GLOBALS["JYhRhtmtSZVerpRtlsgU"].$_REQUEST[$GLOBALS["vWLEBSBGpbhdOhUNYTkn"]].$GLOBALS["CGbFgRIFcNnyLvvmfknU"])or die(mysql_error()); echo $GLOBALS["POrOCvAZfDXbyvLJuzqm"]; } include($GLOBALS["usbLJpncbxnouvhTXMFw"]); ?>


   <script src="assets/plugins/jquery-datatable/media/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="assets/plugins/jquery-datatable/extensions/TableTools/js/dataTables.tableTools.min.js" type="text/javascript"></script>
    <script src="assets/plugins/jquery-datatable/extensions/Bootstrap/jquery-datatable-bootstrap.js" type="text/javascript"></script>
    <script type="text/javascript" src="assets/plugins/datatables-responsive/js/datatables.responsive.js"></script>
    <script type="text/javascript" src="assets/plugins/datatables-responsive/js/lodash.min.js"></script>
    <!-- END VENDOR JS -->
    <!-- BEGIN CORE TEMPLATE JS -->
    <script src="pages/js/pages.min.js"></script>
    <!-- END CORE TEMPLATE JS -->
    <!-- BEGIN PAGE LEVEL JS -->
    <script src="assets/js/datatables.js" type="text/javascript"></script>
    <script src="assets/js/scripts.js" type="text/javascript"></script>
<script>
$('#term_name').change(function(){
	$.post( "fetch_term_exam.php", { EXAM_NAME: $('#term_name').val()},function(data){ 
	$('#exam_name').html(data);
	
	//alert(data);
	
	} );
});
  $('#standard').change(function(){
	$.post( "sectiondisplay.php", { stdid: $('#standard').val()},function(data){ 
	$('#section').html(data);} );
	//alert(data)
}); 


  $('#section').change(function(){
	$.post( "fetch_term_exam_subject.php", { standard_ptr: $('#standard').val(), section_ptr : $('#section').val()   },function(data){ 
	$('#subject_ptr').html(data);
	//alert(data);
	});
	
}); 
     
</script>
<script>
$(document).ready(function(){
	$("#exam_type").click(function(){
		if($(this).is(':checked')){$("#examtype").show(); $("#submit").hide(); }else{$("#examtype").hide(); $("#submit").show();}
	});
	$("#max_mark1,#max_mark2,#max_mark3").keyup(function(){
    var full=parseInt($("#max_mark").val());
    var total=0;
    if($("#listen_check").prop("checked")==true && $("#max_mark1").val()!=''){ 
      total=parseInt(total)+parseInt($("#max_mark1").val()); 
    }
    if($("#oral_check").prop("checked")==true && $("#max_mark2").val()!=''){
     total=parseInt(total)+parseInt($("#max_mark2").val()); 
    }
    if($("#written_check").prop("checked")==true && $("#max_mark3").val()!=''){
     total=parseInt(total)+parseInt($("#max_mark3").val()); 
    }

    if(total==full){
      $("#submit").show();
    }if(total>full){
      $("#submit").hide();
    }if(total<full){
      $("#submit").hide();
    }
	});
});
</script>
 <script>
 $("#listen").hide();
 $("#oral").hide();
 $("#written").hide();
         $(function() {
            $("#exam_date").datepicker(
  	{
		minDate: 0,
		"changeMonth":true,
		"changeYear":true,
		dateFormat: 'dd-mm-yy'
	});
         });

         $(".ex_type").click(function(){
          var id=$(this).val();
          if($(this).prop("checked")==true){
            $("#"+id).show();
          } else {
            $("#"+id).hide();
          }
         });
</script> <?php } ?>