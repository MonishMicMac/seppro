<?php
$this_page='subscriberdetailsnew';
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
                        <label class="control-label col-md-3">Chit ID <span class="required"> * </span></label>
                        <div class="col-md-6">
                        <input type="text" name="chit_id" id="chit_id" autocomplete="off"  class="form-control" />
                        </div>
                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="form-group">
                        <label class="control-label col-md-3">Subscribe ID <span class="required"> * </span></label>
                        <div class="col-md-6">
                        <input type="text" name="subscriber_id" id="subscriber_id" autocomplete="off"  class="form-control" />
                        </div>
                     </div>
                  </div>

               </div>
               <br/>
                <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label class="control-label col-md-3">From Date <span class="required"> * </span></label>
                        <div class="col-md-6">
                        <input type="text" name="fromdate" id="fromdate" autocomplete="off"  class="form-control" />
                        </div>
                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="form-group">
                        <label class="control-label col-md-3">To Date <span class="required"> * </span></label>
                        <div class="col-md-6">
                        <input type="text" name="todate" id="todate" autocomplete="off"  class="form-control" />
                        </div>
                     </div>
                  </div>

               </div>
               <br/>
                 <div class="row">
                 <center>
                     <a href="javascript:void(0)" id="post_job_for_users" class="btn purple" >Search Users</a>
                     </center>
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
               <div class="caption"><i class="fa fa-globe"></i>Collection Details</div>
               <div class="tools"> </div>
            </div>
            <div class="portlet-body">
               <table class="table table-striped table-bordered table-hover" id="data_table">
                  <thead>
                     <tr>
                          <th> S.No </th>
                           <th> Collection Date </th>
                           <th> Chit ID </th>
                           <th> Subscriber ID </th>
                           <th> Collection Amount </th>  
                     </tr>
                  </thead>
                  <tbody >
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

        $('#fromdate').datepicker({
         format: 'dd/mm/yyyy'
      });
          $('#todate').datepicker({
         format: 'dd/mm/yyyy'
      });
      
       $( "#chit_id" ).autocomplete({
         source: function( request, response ) {
            $.ajax({
               url: base_url+'index.php/Subscriber_detailed_report2/get_chits_json',
               type:"post",
               dataType: "json",
               data: {
                  chit_id: request.term
               },
               success: function( data ) {
                  response(data);
               }
            });
         },
         select: function (event, ui) {
            $('#chit_id').val(ui.item.value);
            return false;
         }
      }).autocomplete( "instance" )._renderItem = function( ul, item ) {
         return $( "<li>" )
         .append( "<div>" + item.label + "</div>" )
         .appendTo( ul );
      };


      $( "#subscriber_id" ).autocomplete({
         source: function( request, response ) {
            $.ajax({
               url: base_url+'index.php/Subscriber_detailed_report2/get_subscribers_json',
               type:"post",
               dataType: "json",
               data: {
                  chit_id: $("#chit_id").val(),
                  subscriber_id: request.term
               },
               success: function( data ) {
                  response(data);
               }
            });
         },
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
      table = $('#data_table').DataTable({ 
         "processing": true,
         "serverSide": true,
         "order": [],
         "ajax": {
            "url": "<?php echo site_url('Subscriber_detailed_report2/view_subscriber_new')?>",
            "type": "POST",
            "data": function ( data ) {    

               data.subscriber_id = $('#subscriber_id').val();
               data.chit_id = $('#chit_id').val();
               data.fromdate = $('#fromdate').val();
               data.todate = $('#todate').val();
            }
         },
         "lengthMenu": [
         [10, 20, 50, 100, 150, -1],
         [10, 20, 50, 100, 150, "All"]
         ],
         
         buttons: [
         { extend: 'print', exportOptions: { columns: ':visible' }, className: 'btn dark btn-outline', footer: true },
         { extend: 'copy', exportOptions: { columns: ':visible' }, className: 'btn red btn-outline', footer: true },
         { extend: 'pdf', exportOptions: { columns: ':visible' }, className: 'btn green btn-outline', footer: true },
         { extend: 'excel', exportOptions: { columns: ':visible' }, className: 'btn yellow btn-outline', footer: true },
         { extend: 'csv', exportOptions: { columns: ':visible' }, className: 'btn purple btn-outline', footer: true },
         { extend: 'colvis', className: 'btn dark btn-outline', text: 'Columns'}
         ],
         "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", 
         "columnDefs": [
         { 
            "targets": [ 0 ],
            "orderable": false,
         }
         ]
      });




   });



   $("#post_job_for_users").click(function(){
     
   //     $.ajax({
   //    url : base_url+"index.php/Subscriber_detailed_report1/view_subscriber",
   //    type : 'post',
   //    data : 'subscriber_id='+$('#subscriber_id').val()+'&chit_id='+$('#chit_id').val()+'&fromdate='+$('#fromdate').val()+'&todate='+$('#todate').val(),
   //    success:function(result){

   //       // var data = JSON.parse(result).action_details;
   //       // alert(result);

   //       $("#chitdetails").html(result);

   //    }
   // });
   alert('1');
      table.ajax.reload();
   });

    function open_popup(show){
     $.ajax({
      url : base_url+"index.php/Subscriber_detailed_report2/view_action",
      type : 'post',
      data : 'chit_id='+$(show).attr('chit_id')+'&subscriber_id='+$(show).attr('subscriber_id')+'&fromdate='+$('#fromdate').val()+'&todate='+$('#todate').val(),
      success:function(result){

         // var data = JSON.parse(result).action_details;
         // alert(result);

         $("#auctiondetails").html(result);

      }
   });
  }

   function open_popupnew(show){
       
     $.ajax({
      url : base_url+"index.php/Subscriber_detailed_report2/view_subscriber_new",
      type : 'post',
      data : 'chit_id='+$(show).attr('chit_id')+'&subscriber_id='+$(show).attr('subscriber_id')+'&autiondate='+$(show).attr('action_date')+'&fromdate='+$('#fromdate').val()+'&todate='+$('#todate').val(),
      success:function(result){

         // var data = JSON.parse(result).action_details;
         // alert(result);

         $("#subscriberdetailsnew").html(result);

      }
   });
  }


</script>