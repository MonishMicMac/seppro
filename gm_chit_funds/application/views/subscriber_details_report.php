<?php
$this_page='subscriberdetails';
include("include/header.php");
?>
<style type="text/css">
   .ui-autocomplete { position: absolute; cursor: default;z-index:9999999 !important;}
</style>
<div class="page-content-wrapper">
   <div class="page-content">
      <div class="page-head">
         <div class="page-title">
            <h1>Subscriber Detailed Report</h1>
         </div>

       <!--  <div class="page-toolbar">
            <button data-toggle="modal" href="#basic" class="btn green" onclick='open_popup("add")' style="float:right;margin-right:1px;">Chit Detailed Report</button>
         </div>-->
      </div>
      <div class="row">
         <div class="col-md-12">
            <div class="portlet light bordered">
               <br/>
               <br/>
               <div class="row" style="margin-bottom: -20px;">
                 <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label class="control-label col-md-3">Subscribe ID <span class="required"> * </span></label>
                        <div class="col-md-6">
                        <input type="text" name="subscriber_id" id="subscriber_id" autocomplete="off"  class="form-control" />
                        </div>
                     </div>
                  </div>


                  <div class="col-md-3">
                     <a href="javascript:void(0)" id="post_job_for_users" class="btn purple" >Search Users</a>
                  </div>


               </div>
               <br/>
            </div>
         </div>
      </div>
   </div>

   <div class="row">
      <div class="col-md-12">
         <div class="portlet light bordered">
            <div class="portlet-title">
               <div class="caption"><i class="fa fa-globe"></i>Chit List </div>
               <div class="tools"> </div>
            </div>
            <div class="portlet-body">
               <table class="table table-striped table-bordered table-hover" id="data_table">
                  <thead>
                     <tr>
                        <th> S.No </th>
                        <th> Chit ID </th>
                        <th> Chit Name </th>
                        <th> Chit Amount</th>
                        <th> Total Month</th>
                        <th> Monthly Amount</th>
                     </tr>
                  </thead>
                  <tbody id="chitdetails">
                     </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>

   <div class="modal fade bs-modal-lg" id="basic" tabindex="-1" role="basic" aria-hidden="true">
         <div class="modal-dialog modal-lg">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                  <h4 class="modal-title">Auction Details</h4>
               </div>
               <div class="portlet-body">
                  <table class="table table-striped table-bordered table-hover">
                     <thead>
                        <tr>
                           <th> S.No </th>
                           <th> Auction ID </th>
                           <th> Date </th>
                           <th> Subscriber ID </th>
                           <th> Bit Amount </th>
                           <th> Collect Amount </th>
                        </tr>
                     </thead>
                     <tbody id="auctiondetails">
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>

   <div class="modal fade bs-modal-lg" id="basicnew" tabindex="-1" role="basicnew" aria-hidden="true">
         <div class="modal-dialog modal-lg">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                  <h4 class="modal-title">Collection Details</h4>
               </div>
               <div class="portlet-body">
                  <table class="table table-striped table-bordered table-hover">
                     <thead>
                        <tr>
                           <th> S.No </th>
                           <th> Collection Date </th>
                           <th> Chit ID </th>
                           <th> Subscriber ID </th>
                           <th> Collection Amount </th>    
                           <th> Remarks </th>                           
                        </tr>

                     </thead>
                     <tbody id="subscriberdetailsnew">
                         
                     </tbody>


                  </table>
               </div>
            </div>
         </div>
      </div>





</div>
</div>



<?php
include("include/footer.php");
?>
<script type="text/javascript">
   $(document).ready(function() {
      $( "#subscriber_id" ).autocomplete({
         source: function( request, response ) {
            $.ajax({
               url: base_url+'index.php/Subscriber_detailed_report/get_subscribers_json',
               type:"post",
               dataType: "json",
               data: {
                  // Chit_id: $("#chit_id").val(),
                  subscriber_id: request.term
               },
               success: function( data ) {
                  response(data);
               }
            });
         },
         minLength:3,
         select: function (event, ui) {
            $('#subscriber_id').val(ui.item.value);
            return false;
         }
      }).autocomplete( "instance" )._renderItem = function( ul, item ) {
         return $( "<li>" )
         .append( "<div>" + item.label + "</div>" )
         .appendTo( ul );
      };



      var table;
      table = $('#table').DataTable({ 
         "processing": true,
         "serverSide": true,
         "order": [],
         "ajax": {
            "url": "<?php echo site_url('Subscriber_detailed_report/view_subscriber')?>",
            "type": "POST",
            "data": function ( data ) {    

               data.subscriber_id = $('#subscriber_id').val();
            }
         },
         "columnDefs": [
         { 
            "targets": [ 0 ],
            "orderable": false,
         },
         ]
      });


   });

   $("#post_job_for_users").click(function(){
       $.ajax({
      url : base_url+"index.php/Subscriber_detailed_report/view_subscriber",
      type : 'post',
      data : 'subscriber_id='+$('#subscriber_id').val(),
      success:function(result){

         // var data = JSON.parse(result).action_details;
         // alert(result);

         $("#chitdetails").html(result);

      }
   });
      // table.ajax.reload();
   });

    function open_popup(show){
     $.ajax({
      url : base_url+"index.php/Subscriber_detailed_report/view_action",
      type : 'post',
      data : 'chit_id='+$(show).attr('chit_id')+'&subscriber_id='+$(show).attr('subscriber_id'),
      success:function(result){

         // var data = JSON.parse(result).action_details;
         // alert(result);

         $("#auctiondetails").html(result);

      }
   });
  }

   function open_popupnew(show){
     $.ajax({
      url : base_url+"index.php/Subscriber_detailed_report/view_subscriber_new",
      type : 'post',
      data : 'chit_id='+$(show).attr('chit_id')+'&subscriber_id='+$(show).attr('subscriber_id')+'&autiondate='+$(show).attr('action_date'),
      success:function(result){

         // var data = JSON.parse(result).action_details;
         // alert(result);

         $("#subscriberdetailsnew").html(result);

      }
   });
  }


</script>