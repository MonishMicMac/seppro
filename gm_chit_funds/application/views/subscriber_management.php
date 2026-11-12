<?php
$this_page='subscriber';
include("include/header.php");
?>
<div class="page-content-wrapper">
   <div class="page-content">
      <div class="page-head">
         <div class="page-title">
            <h1>Subscriber Management</h1>
         </div>

         <div class="page-toolbar">
            <button data-toggle="modal" href="#basic" class="btn green" onclick='open_popup("add")' style="float:right;margin-right:1px;">Subscriber Entry</button>
         </div>
      </div>

      <div class="row">
         <div class="col-md-12">
            <div class="portlet light bordered">
               <div class="portlet-title">
                  <div class="caption"><i class="fa fa-globe"></i>Subscriber List </div>
                  <div class="tools"> </div>
               </div>
               <div class="portlet-body">
                  <table class="table table-striped table-bordered table-hover" id="data_table">
                     <thead>
                        <tr>
                           <th> S.No </th>
                           <th> Party ID </th>
                         <!--   <th> Group Name </th> -->
                           <th> Party Name </th>
                           <th> Gender </th>
                           <th> Mobile No </th>
                           <th> Phone Number </th>
                           <th> Surety Number </th>
                           <th> Aadhar no </th>
                           <th> Area </th>
                           <th> Status </th>
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
         <form action="<?php echo base_url(); ?>index.php/Subscriber_controller/subscriber_add_edit" id="subscriber_form" method="post" class="form-horizontal">
            <input type="hidden" name="auto_id" id="auto_id">
            <input type="hidden" name="condition" id="condition">
            <div class="modal-body">
               <div class="form-body">
                  <div class="alert alert-danger display-hide">
                     <button class="close" data-close="alert"></button> You have some errors. Please check below.
                  </div>

                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                           <label class="control-label col-md-5">Party ID <span class="required"> * </span></label>
                           <div class="col-md-7">
                              <input type="text" name="s_party_id" id="s_party_id" autocomplete="off" class="form-control"  />
                           </div>
                        </div>

                      <!--   <div class="form-group">
                           <label class="control-label col-md-5">Group Name </label>
                           <div class="col-md-7">
                              <input type="text" name="s_group_name" id="s_group_name" autocomplete="off" class="form-control"  />
                           </div>
                        </div> -->

                        <div class="form-group">
                           <label class="control-label col-md-5">Party Name <span class="required"> * </span></label>
                           <div class="col-md-7">
                              <input type="text" name="party_name" id="party_name" autocomplete="off" class="form-control" />
                           </div>
                        </div>

                        <div class="form-group">
                           <div class="form-group">
                              <label class="control-label col-md-5">Gender</label>
                              <div class="col-md-7">
                                 <div class="mt-radio-inline">
                                    <label class="mt-radio mt-radio-outline">
                                       <input type="radio" name="gender" class="gender" id="male" value="1" checked> Male
                                       <span></span>
                                    </label>
                                    <label class="mt-radio mt-radio-outline">
                                       <input type="radio" name="gender" class="gender" id="female" value="2"> Female
                                       <span></span>
                                    </label>
                                 </div>
                              </div>
                           </div>
                        </div>

                        <div class="form-group">
                           <label class="control-label col-md-5">Father or Husband </label>
                           <div class="col-md-7">
                              <input type="text" name="father_or_husband" id="father_or_husband" autocomplete="off" class="form-control" />
                           </div>
                        </div>

                        <div class="form-group">
                           <label class="control-label col-md-5">Nominee </label>
                           <div class="col-md-7">
                              <input type="text" name="nominee" id="nominee" autocomplete="off" class="form-control" />
                           </div>
                        </div>

                        <div class="form-group">
                           <label class="control-label col-md-5">Nominee Relation </label>
                           <div class="col-md-7">
                              <input type="text" name="nominee_relation" id="nominee_relation" autocomplete="off" class="form-control" />
                           </div>
                        </div>

                        <div class="form-group">
                           <label class="control-label col-md-5">Aadhar No <span class="required"> * </span></label>
                           <div class="col-md-7">
                              <input type="text" name="aadhar_no" id="aadhar_no" autocomplete="off" class="form-control" />
                           </div>
                        </div>

                        <div class="form-group">
                           <label class="control-label col-md-5">Date Of Birth </label>
                           <div class="col-md-7">
                              <input type="text" name="dob" id="dob" autocomplete="off" class="form-control" readonly />
                           </div>
                        </div>
                     </div>

                     <div class="col-md-6">
                        <div class="form-group">
                           <label class="control-label col-md-4">Mobile No <span class="required"> * </span></label>
                           <div class="col-md-7">
                              <input type="text" name="mobile_no" id="mobile_no" autocomplete="off" class="form-control" />
                           </div>
                        </div>

                        <div class="form-group">
                           <label class="control-label col-md-4">Phone No <span class="required"> * </span></label>
                           <div class="col-md-7">
                              <input type="text" name="phone_no" id="phone_no" autocomplete="off" class="form-control" />
                           </div>
                        </div>

                        <div class="form-group">
                           <label class="control-label col-md-4">Surety No</label>
                           <div class="col-md-7">
                              <input type="text" name="surety_no" id="surety_no" autocomplete="off" class="form-control" />
                           </div>
                        </div>

                        <div class="form-group">
                           <label class="control-label col-md-4">Area</label>
                           <div class="col-md-7">
                              <input type="text" name="area" id="area" autocomplete="off" class="form-control" />
                           </div>
                        </div>

                        <div class="form-group">
                           <label class="control-label col-md-4">Address </label>
                           <div class="col-md-7">
                             <textarea  name="address" id="address" class="form-control" rows="4"/></textarea>
                           </div>
                        </div>

                        <div class="form-group">
                           <label class="control-label col-md-4">Remarks</label>
                           <div class="col-md-7">
                              <textarea class="form-control" name="remarks" id="remarks" rows="2"></textarea>
                           </div>
                        </div>

                        <div class="form-group">
                           <label class="control-label col-md-4">Status <span class="required"> * </span></label>
                           <div class="col-md-7">
                              <div class="mt-checkbox-list" style="padding-top: 10px;">
                                 <label class="mt-checkbox mt-checkbox-outline"> Active
                                    <input type="checkbox" name="status" id="status" value="0" />
                                    <span></span>
                                 </label>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>

            <div class="modal-footer">
               <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
               <button type="submit" id="submit_subscriber" class="btn purple">Save changes</button>
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
      $('#dob').datepicker({
         format: 'dd/mm/yyyy'
      });

      $(".green").trigger("click");

      var table;
      table = $('#data_table').DataTable({ 
         "processing": true,
         "serverSide": true,
         "order": [],
         "ajax": {
            "url": "<?php echo site_url('Subscriber_controller/view_all_subscribers')?>",
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
      $("#s_party_id").val('');
     /* $("#s_group_name").val('');*/
      $("#party_name").val('');
      $("#gender").val('');
      $("#dob").val('');
      $("#father_or_husband").val('');
      $("#nominee").val('');
      $("#nominee_relation").val('');
      $("#entry_fee").val('');
      $("#mobile_no").val('');
      $("#phone_no").val('');
      $("#city").val('');
      $("#area").val('');
      $("#address").val('');
      $("#remarks").val('');
      $("#surety_no").val('');
      $("#status").prop('checked',true);

      $("#condition").val('add_subscriber');
      $(".modal-title").html("Subscriber Entry");
      $("#submit_subscriber").html("Save");
      if(show!='add'){
         $("#condition").val('edit_subscriber');
         $(".modal-title").html("Subscriber Edit");
         $("#submit_subscriber").html("Save Changes");
         $.ajax({
            url : base_url+"index.php/Subscriber_controller/get_subscriber_details",
            type : 'post',
            data : 'subs_id='+$(show).attr('subs_id'),
            success:function(result){
               var data = JSON.parse(result).subscriber_details;

               $("#auto_id").val(data[0].s_id);
               $("#s_party_id").val(data[0].s_party_id);
               /*$("#s_group_name").val(data[0].s_group_name);*/
               $("#party_name").val(data[0].s_party_name);
               $("#gender").val(data[0].s_gender);

               var date=(data[0].s_dob).split('-');
               var dob=date[2]+'/'+date[1]+'/'+date[0];

               $("#dob").val(dob);
               $('#dob').datepicker('update');

               $("#father_or_husband").val(data[0].s_father_or_husband);
               $("#nominee").val(data[0].s_nominee);
               $("#nominee_relation").val(data[0].s_nominee_relation);
               $("#entry_fee").val(data[0].s_entry_fee);
               $("#aadhar_no").val(data[0].s_aadhar_no);
               $("#mobile_no").val(data[0].s_mobile_no);
               $("#phone_no").val(data[0].s_phone_no);
               $("#city").val(data[0].s_city);
               $("#area").val(data[0].s_area);
               $("#address").val(data[0].s_address);
               $("#remarks").val(data[0].s_remarks);
               $("#surety_no").val(data[0].surety_no);

               if(data[0].s_status==0){
                  $("#status").prop('checked',true);
               } else {
                  $("#status").prop('checked',false);
               }
            }
         });
      } /*else {
         $.ajax({
            url : base_url+"index.php/Subscriber_controller/get_auto_party_id_json",
            type : 'post',
            success:function(result){
               var party_id = JSON.parse(result).s_party_id;
               $("#s_party_id").val(party_id);
            }
         });
      }*/
   }
</script>