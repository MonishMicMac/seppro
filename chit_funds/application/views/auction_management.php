<?php
$this_page='auction';
include("include/header.php");
?>
<style type="text/css">
   .ui-autocomplete { position: absolute; cursor: default;z-index:9999999 !important;}
</style>
<div class="page-content-wrapper">
   <div class="page-content">
      <div class="page-head">
         <div class="page-title">
            <h1>Auction Management</h1>
         </div>

         <div class="page-toolbar">
            <button data-toggle="modal" href="#basic" class="btn green" onclick='open_popup("add")' style="float:right;margin-right:1px;">Auction Entry</button>
         </div>
      </div>

      <div class="row">
         <div class="col-md-12">
            <div class="portlet light bordered">
               <div class="portlet-title">
                  <div class="caption"><i class="fa fa-globe"></i>Auction List </div>
                  <div class="tools"> </div>
               </div>
               <div class="portlet-body">
                  <table class="table table-striped table-bordered table-hover" id="data_table">
                     <thead>
                        <tr>
                           <th> S.No </th>
                           <th> Auction ID </th>
                           <th> Auction Date </th>
                           <th> Chit Name </th>
                           <th> Bidder Name </th>
                           <th> Bid Amount </th>
                           <th> Comm. Amount </th>
                           <th> Actions </th>
                        </tr>
                     </thead>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<div class="modal fade bs-modal-lg" id="basic" tabindex="-1" role="basic" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h4 class="modal-title"></h4>
         </div>
         <form action="<?php echo base_url(); ?>index.php/Auction_controller/auction_add_edit" id="auction_form" method="post" class="form-horizontal">
            <input type="hidden" name="auto_id" id="auto_id">
            <input type="hidden" name="condition" id="condition">
            <div class="modal-body">
               <div class="form-body">
                  <div class="alert alert-danger display-hide">
                     <button class="close" data-close="alert"></button> You have some errors. Please check below.
                  </div>

                  <div class="row">
                     <div class="col-md-12" id="auction_cnt_h" style="text-align:center;font-size: 25px;font-weight:700;"></div>
                  </div>
                  
                  <br>

                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                           <label class="control-label col-md-5">Auction ID <span class="required"> * </span></label>
                           <div class="col-md-7">
                              <input type="hidden" name="auction_cnt" id="auction_cnt" />
                              <input type="hidden" name="company_chit_month" id="company_chit_month" />
                              <input type="text" name="auction_id" id="auction_id" autocomplete="off" class="form-control" readonly />
                           </div>
                        </div>

                        <div class="form-group">
                           <label class="control-label col-md-5">Auction Date <span class="required"> * </span></label>
                           <div class="col-md-7">
                              <input type="text" name="auction_date" id="auction_date" autocomplete="off" class="form-control" readonly />
                           </div>
                        </div>

                        <div class="form-group">
                           <label class="control-label col-md-5">Chit ID / Name <span class="required"> * </span></label>
                           <div class="col-md-7">
                              <input type="text" name="chit_id" id="chit_id" class="form-control" tabindex="1" style="color: #555;" />
                           </div>
                        </div>

                        <div class="form-group">
                           <label class="control-label col-md-5">Bidder ID / Name <span class="required"> * </span></label>
                           <div class="col-md-7">
                              <input type="text" name="bidder_id" id="bidder_id" tabindex="2" class="form-control" style="color: #555;" />
                           </div>
                        </div>

                        <div class="form-group">
                           <label class="control-label col-md-5">Total Subscribers <span class="required"> * </span></label>
                           <div class="col-md-7">
                              <input type="text" name="total_subsription" id="total_subsription" autocomplete="off" class="form-control" readonly />
                           </div>
                        </div>

                        <div class="form-group">
                           <label class="control-label col-md-5">Total Bidders <!-- <span class="required"> * </span> --></label>
                           <div class="col-md-7">
                              <input type="text" name="bid_count" id="bid_count" autocomplete="off" class="form-control" />
                           </div>
                        </div>
                     </div>

                     <div class="col-md-6">
                        <div class="form-group">
                           <label class="control-label col-md-4">Chit Amount <span class="required"> * </span></label>
                           <div class="col-md-7">
                              <input type="text" name="chit_amount" id="chit_amount" autocomplete="off" class="form-control" readonly />
                           </div>
                        </div>

                        <div class="form-group">
                           <label class="control-label col-md-4">Bid Amount <span class="required"> * </span></label>
                           <div class="col-md-7">
                              <input type="text" name="bid_amount" tabindex="3" id="bid_amount" autocomplete="off" class="form-control" />
                           </div>
                        </div>

                        <div class="form-group">
                           <input type="hidden" id="comm_percent">
                           <label class="control-label col-md-4">Commission Amount <span class="required"> * </span></label>
                           <div class="col-md-7">
                              <input type="text" name="commission_amount" id="commission_amount" autocomplete="off" class="form-control" readonly />
                           </div>
                        </div>

                        <div class="form-group">
                           <label class="control-label col-md-4">Balance Amount <span class="required"> * </span></label>
                           <div class="col-md-7">
                              <input type="text" name="balance_amount" id="balance_amount" autocomplete="off" class="form-control" readonly />
                           </div>
                        </div>

                        <div class="form-group">
                           <label class="control-label col-md-4">Amount Per.User</label>
                           <div class="col-md-7">
                              <input type="text" name="collect_amount" id="collect_amount" autocomplete="off" class="form-control" readonly />
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>

            <div class="modal-footer">
               <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
               <button type="submit" id="submit_auction" class="btn purple">Save changes</button>
            </div>
         </form>
      </div>
   </div>
</div>

<?php
include("include/footer.php");
?>

<script type="text/javascript">
   $(document).ready(function() {
      $('#auction_date').datepicker({
         format: 'dd/mm/yyyy'
      });

      $(".green").trigger("click");

      $( "#chit_id" ).autocomplete({
         source: function( request, response ) {
            $.ajax({
               url: base_url+'index.php/Auction_controller/get_chits_json',
               type:"post",
               dataType: "json",
               data: {
                  condition: $("#condition").val(),
                  auction_date: $("#auction_date").val(),
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

      $( "#bidder_id" ).autocomplete({
         source: function( request, response ) {
            $.ajax({
               url: base_url+'index.php/Auction_controller/get_subscribers_json',
               type:"post",
               dataType: "json",
               data: {
                  condition: $("#condition").val(),
                  chit_id: $("#chit_id").val(),
                  subscriber_id: request.term
               },
               success: function( data ) {
                  response(data);
               }
            });
         },
         select: function (event, ui) {
            $('#bidder_id').val(ui.item.value);
            return false;
         }
      }).autocomplete( "instance" )._renderItem = function( ul, item ) {
         return $( "<li>" )
         .append( "<div>" + item.label + "</div>" )
         .appendTo( ul );
      };

      $("#chit_id").blur(function(){
         $.ajax({
            url:base_url+"index.php/Auction_controller/get_chit_amount",
            type:"post",
            data:"chit_id="+$(this).val(),
            success:function(data){

               var result = JSON.parse(data);
               $("#chit_amount").val(result.chit_amount);
               $("#comm_percent").val(result.comm_percent);
               $("#total_subsription").val(result.subscribers_cnt);


               if($("#condition").val()=="add_auction"){
                  $("#auction_cnt_h").html(result.auction_cnt);
                  $("#auction_cnt").val(result.auction_cnt);
                  $("#company_chit_month").val(result.company_chit_month);
               }
               
               $("#commission_amount").val((result.comm_percent*result.chit_amount)/100);
            }
         });
      });

      $("#bid_amount").keyup(function(){
         var chit_amount=$("#chit_amount").val();
         var comm_amount=$("#commission_amount").val();
         var total_subsription=$("#total_subsription").val();
         
         var auction_cnt2=$("#auction_cnt").val();
         var company_chit_month=$("#company_chit_month").val();

         
         
         

         if(auction_cnt2 == company_chit_month){
            $("#bid_amount").val(chit_amount/total_subsription);
            var balance_amount= chit_amount-parseInt((chit_amount/total_subsription));
            var balance_amount1=chit_amount-(parseInt(bid_amount)-parseInt(comm_amount));
            $("#collect_amount").val(chit_amount/total_subsription);
            $("#balance_amount").val(balance_amount);
         }else{
            var bid_amount=$(this).val();
            var balance_amount=chit_amount-(parseInt(bid_amount));
            var balance_amount1=chit_amount-(parseInt(bid_amount)-parseInt(comm_amount));
            $("#collect_amount").val(balance_amount1/total_subsription);
            $("#balance_amount").val(balance_amount);
         }
      });

      var table;
      table = $('#data_table').DataTable({ 
         "processing": true,
         "serverSide": true,
         "order": [],
         "ajax": {
            "url": "<?php echo site_url('Auction_controller/view_all_auctions')?>",
            "type": "POST",
            "data": function ( data ) {

            }
         },
         "lengthMenu": [
         [10, 20, 50, 100, 150, -1],
         [10, 20, 50, 100, 150, "All"]
         ],

         buttons: [
         { extend: 'print', exportOptions: { columns: ':visible' }, className: 'btn dark btn-outline' },
         { extend: 'copy', exportOptions: { columns: ':visible' }, className: 'btn red btn-outline' },
         { extend: 'pdf', exportOptions: { columns: ':visible' }, className: 'btn green btn-outline' },
         { extend: 'excel', exportOptions: { columns: ':visible' }, className: 'btn yellow btn-outline' },
         { extend: 'csv', exportOptions: { columns: ':visible' }, className: 'btn purple btn-outline' },
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

function open_popup(show){
   $(".has-error").removeClass("has-error");
   $(".help-block-error").html("");
   $(".display-hide").hide();

   $("#auto_id").val('');
   $("#auction_id").val('');
   $("#auction_date").val('');
   $("#chit_id").val('');
   $("#bidder_id").val('');
   $("#total_subsription").val('');
   $("#bid_count").val('1');
   $("#chit_amount").val('');
   $("#bid_amount").val('');
   $("#commission_amount").val('');
   $("#balance_amount").val('');

   $("#condition").val('add_auction');
   $(".modal-title").html("Auction Entry");
   $("#submit_auction").html("Save");
   if(show!='add'){
      $("#condition").val('edit_auction');
      $(".modal-title").html("Auction Edit");
      $("#submit_auction").html("Save Changes");
      $.ajax({
         url : base_url+"index.php/Auction_controller/get_auction_details",
         type : 'post',
         data : 'subs_id='+$(show).attr('subs_id'),
         success:function(result){
            var data = JSON.parse(result).auction_details;

            $("#auto_id").val(data[0].a_id);
            $("#auction_id").val(data[0].a_auction_id);

            var date=(data[0].a_auction_date).split('-');
            var auction_date=date[2]+'/'+date[1]+'/'+date[0];

            $("#auction_date").val(auction_date);
            $('#auction_date').datepicker('update');

            $("#chit_id").val(data[0].a_chit_id);
            $("#bidder_id").val(data[0].a_bidder_id);
            $("#total_subsription").val(data[0].a_total_subsription);
            $("#bid_count").val(data[0].a_bid_count);
            $("#chit_amount").val(data[0].a_chit_amount);
            $("#bid_amount").val(data[0].a_bid_amount);
            $("#commission_amount").val(data[0].a_commission_amount);
            $("#balance_amount").val(data[0].a_balance_amount);
            $("#collect_amount").val(data[0].a_collect_amount);
            $("#auction_cnt_h").html(data[0].a_auction_count);
            $("#auction_cnt").val(data[0].a_auction_count);
            

         }
      });
   } else {
      $.ajax({
         url : base_url+"index.php/Auction_controller/get_auto_auction_id_json",
         type : 'post',
         success:function(result){
            var auction_id = JSON.parse(result).a_auction_id;
            $("#auction_id").val(auction_id);
         }
      });
   }
}
</script>