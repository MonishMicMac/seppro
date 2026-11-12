<?php
$this_page='chitdetails';
include("include/header.php");
?>
<style type="text/css">
   .ui-autocomplete { position: absolute; cursor: default;z-index:9999999 !important;}
</style>
<div class="page-content-wrapper">
   <div class="page-content">
      <div class="page-head">
         <div class="page-title">
            <h1>Chit Query Report</h1>
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
                           <th> Chit Date </th>
                           <th> Chit Time </th>
                           <th> Chit Name </th>
                           <th> Chit Amount </th>
                           <th> Subscribers </th>                           
                           <th> No. Of Instalments </th>
                           <th> Months </th>
                           <th> Monthly Amt </th>
                        </tr>
                     </thead>
                     <tfoot>
                        <tr>
                           <th></th>
                           <th></th>
                           <th></th>
                           <th></th>
                           <th style="text-align:right">Total:</th>
                           <th id="c_chit_amount"></th>
                           <th></th>
                           <th></th>
                           <th></th>
                           <th></th>
                        </tr>
                     </tfoot>
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
                           <th> Commission Amount </th>
                           <th> Subscription Amount </th>
                           <th> Balance Amount </th>
                        </tr>
                     </thead>
                     <tbody id="auctiondetails">
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>

      <div class="modal fade bs-modal-lg" id="basicnew" tabindex="-1" role="basic" aria-hidden="true">
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
                           <th> Subscriber ID </th>                            
                           <th> Payment Amount </th> 
                            <th> Collection Amount </th> 
                            <th> Pending Amount </th> 
                            <th> Phone </th> 
                            <th> Mobile </th>                           
                        </tr>
                     </thead>
                     <tbody id="auctiondetailsnew">
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





      var table;
      table = $('#data_table').DataTable({ 
         "processing": true,
         "serverSide": true,
         "order": [],
         "ajax": {
            "url": "<?php echo site_url('Chit_detailed_report/view_all_chits')?>",
            "type": "POST",
            "data": function ( data ) {

            },
              "complete" : function(data){
               var result = JSON.parse(JSON.parse(JSON.stringify(data)).responseText);

               $("#c_chit_amount").html(result.c_chit_amount);
            }
         },
         "lengthMenu": [
         [10, 20, 50, 100, 150, -1],
         [10, 20, 50, 100, 150, "All"]
         ],

         buttons: [
         { extend: 'print', className: 'btn dark btn-outline' },
         { extend: 'copy', className: 'btn red btn-outline' },
         { extend: 'pdf', className: 'btn green btn-outline' },
         { extend: 'excel', className: 'btn yellow btn-outline ' },
         { extend: 'csv', className: 'btn purple btn-outline ' },
         { extend: 'colvis', className: 'btn dark btn-outline', text: 'Columns'}
         ],
         "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", 
         "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
            /*alert(aData[8]);*/
            if(aData[6] == aData[7]){
               $(nRow).css('background-color', 'red')
               $(nRow).css('color', 'white')
            }

           
         },
         "columnDefs": [
         { 
            "targets": [ 0 ],
            "orderable": false,
         }
         ]
      });


   });

   function open_popup(show){
     $.ajax({
      url : base_url+"index.php/Chit_detailed_report/view_action",
      type : 'post',
      data : 'chit_id='+$(show).attr('chit_id'),
      success:function(result){

         // var data = JSON.parse(result).action_details;
         // alert(result);

         $("#auctiondetails").html(result);

      }
   });
  }
  function open_popupnew(show){
     $.ajax({
      url : base_url+"index.php/Chit_detailed_report/view_action_new",
      type : 'post',
      data : 'auction_id='+$(show).attr('auction_id')+'&auction_date='+$(show).attr('action_date')+'&auction_id_name='+$(show).attr('auction_id_name'),
      success:function(result){

         // var data = JSON.parse(result).action_details;
         // alert(result);

         $("#auctiondetailsnew").html(result);

      }
   });
  }



</script>