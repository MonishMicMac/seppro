<?php
$this_page='deposit_report';
include("include/header.php");
?>
<style type="text/css">
.ui-autocomplete { position: absolute; cursor: default;z-index:9999999 !important;}
</style>
<div class="page-content-wrapper">
   <div class="page-content">
      <div class="page-head">
         <div class="page-title">
            <h1>Deposit Report</h1>
         </div>

        
      </div>
      <?php
      if($this->session->userdata('collection_error')!=''){
         ?>
         <div class="m-heading-1 border-red m-bordered">
            <h3 style="margin: 0 0 0px;">
               <?php
               echo $this->session->userdata('collection_error');
               $this->session->unset_userdata('collection_error');
               ?>
            </h3>
         </div>
         <?php
      }
      ?>

       <div class="row">
         <div class="col-md-12">
            <div class="portlet light bordered">
               <br/>
               <br/>
               <div class="row" style="margin-bottom: -20px;">
                 <div class="row">
                  <div class="col-md-3">
                     <div class="form-group">
                        <label class="control-label col-md-5">Chit ID</label>
                        <div class="col-md-7">
                           <input type="text" name="a_chit_id" id="a_chit_id" autocomplete="off"  class="form-control" />
                        </div>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="form-group">
                        <label class="control-label col-md-5">From Date</label>
                        <div class="col-md-7">
                        <input type="text" name="from_date" id="from_date" autocomplete="off"  class="form-control" />
                        </div>
                     </div>
                  </div>
                   <div class="col-md-3">
                     <div class="form-group">
                        <label class="control-label col-md-5">To Date</label>
                        <div class="col-md-7">
                        <input type="text" name="to_date" id="to_date" autocomplete="off"  class="form-control" />
                        </div>
                     </div>
                  </div>

                  <div class="col-md-2">
                     <a href="javascript:void(0)" id="post_job_for_users" class="btn purple" >Search </a>
                  </div>
               </div>
               <br/>
            </div>
         </div>
      </div>
   </div>

     <!-- <div class="row">
         <div class="col-md-12">
            <div class="portlet light bordered">
               <div class="portlet-title">
                  <div class="caption"><i class="fa fa-globe"></i>Deposit Report </div>
                  <div class="tools"> </div>
               </div>
               <div class="portlet-body">

                  <table class="table table-striped table-bordered table-hover" id="table">
                     <thead>
                        <tr>
                           <th> S.No </th>
                           <th> Deposit Date </th>
                           <th> Subscriber Id </th>
                           <th> Subscriber Name </th>
                           <th> Out. Amount </th>
                           <th> Action </th>
                        </tr>
                     </thead>

                     <tfoot>
                        <tr>
                           
                           <th></th>
                           <th></th>
                           <th></th>
                           <th style="text-align:right">Total:</th>
                           <th id="dep_amt"></th>
                            <th></th>
                       </tr>
                    </tfoot>
                  </table>
               </div>
            </div>
         </div>
      </div> -->



       <div class="row">
         <div class="col-md-12">
            <div class="portlet light bordered">
               <div class="portlet-title">
                  <div class="caption"><i class="fa fa-globe"></i>Deposit List </div>
                  <div class="tools"> </div>
               </div>
               <div class="portlet-body">
                  <table class="table table-striped table-bordered table-hover" id="data_table">
                     <thead>
                        <tr>
                           <th> S.No </th>
                           <th> Deposit Date</th>
                            <th> Bill No</th>
                            <th> Subscriber No</th>
                           <th> Subscriber ID </th>
                           <th> Subscriber Name</th>
                           <th> Amount </th>
                            <?php if($this->session->userdata('user_details')['log_user_role']=='1')  {   ?>
                              <th> Update </th>
                            <?php } ?>
                           <!-- <th> Action </th> -->
                        </tr>
                     </thead>
                     <tfoot>
                        <tr>
                           <th></th>
                           <th></th>
                           <th></th>
                           <th></th>
                           <th style="text-align:right">Total:</th>
                           <th id="dep_amt1"></th>
                             <?php if($this->session->userdata('user_details')['log_user_role']=='1')  {   ?>
                           <th></th>
                            <?php }  ?>
                        </tr>
                     </tfoot>


                  </table>
               </div>
            </div>
         </div>
      </div>

      
   </div>
</div>


<input type="hidden" id="change_check">
<input type="hidden" id="cur_date" value="<?php echo date('d/m/Y'); ?>">
<?php
include("include/footer.php");
?>
<script type="text/javascript">
   $(document).ready(function() {

      $('#from_date').datepicker({
         format: 'yyyy-mm-dd'
      });

      $('#to_date').datepicker({
         format: 'yyyy-mm-dd'
      });

      var table;
      table = $('#data_table').DataTable({ 
         "processing": true,
         "serverSide": true,
         "order": [],
         "ajax": {
            "url": "<?php echo site_url('Deposit_controller/view_all_deposit')?>",
            "type": "POST",
            "data": function ( data ) {

               data.chit_id = $('#a_chit_id').val();
               data.from_date = $('#from_date').val();
               data.to_date = $('#to_date').val();

            },
            "complete" : function(data){
               var result = JSON.parse(JSON.parse(JSON.stringify(data)).responseText);
               $("#dep_amt1").html(result.dep_amt1);
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
         { extend: 'excel', exportOptions: { columns: ':visible' }, className: 'btn yellow btn-outline ' },
         { extend: 'csv', exportOptions: { columns: ':visible' }, className: 'btn purple btn-outline ' },
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

      $("#post_job_for_users").click(function(){
         table.ajax.reload();
      });

   });


   function cancel_this(show){
      /*alert("test");*/
      if(confirm("Do You Want To Delete This Deposit?")==true){
         $.ajax({
            url : base_url+"index.php/Deposit_controller/cancel_deposite",
            type : 'post',
            data : 'coll_id='+$(show).attr('coll_id')+'&d_amount='+$(show).attr('d_amount')+'&d_sub_id='+$(show).attr('d_sub_id'),
            context: show,
            success:function(result){
               alert($(show).attr('d_subscriber_name')+" Deposit has been Cancelled...");
               window.location.href=base_url+"index.php/Deposit_controller/deposite_report_management";
            }
         });
      }
   }
</script>