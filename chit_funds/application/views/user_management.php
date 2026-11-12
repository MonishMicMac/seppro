<?php
$this_page='users';
include("include/header.php");
?>
<div class="page-content-wrapper">
   <div class="page-content">
      <div class="page-head">
         <div class="page-title">
            <h1>User Management</h1>
         </div>

         <div class="page-toolbar">
            <button data-toggle="modal" href="#basic" class="btn green" onclick='open_popup("add")' style="float:right;margin-right:1px;">User Entry</button>
         </div>
      </div>

      <div class="row">
         <div class="col-md-12">
            <div class="portlet light bordered">
               <div class="portlet-title">
                  <div class="caption"><i class="fa fa-globe"></i>User List </div>
                  <div class="tools"> </div>
               </div>
               <div class="portlet-body">
                  <table class="table table-striped table-bordered table-hover" id="data_table">
                     <thead>
                        <tr>
                           <th> S.No </th>
                           <th> First Name </th>
                           <th> Last Name </th>
                           <th> User Name </th>
                           <th> Phone Number </th>
                           <th> Email ID </th>
                           <th> User Role </th>
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
         <form action="<?php echo base_url(); ?>index.php/User_controller/user_add_edit" id="user_form" method="post" class="form-horizontal">
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
                           <label class="control-label col-md-5">First Name <span class="required"> * </span></label>
                           <div class="col-md-7">
                              <input type="text" name="first_name" id="first_name" autocomplete="off" class="form-control" />
                           </div>
                        </div>

                        <div class="form-group">
                           <label class="control-label col-md-5">Last Name <span class="required"> * </span></label>
                           <div class="col-md-7">
                              <input type="text" name="last_name" id="last_name" autocomplete="off" class="form-control" />
                           </div>
                        </div>

                        <div class="form-group">
                           <label class="control-label col-md-5">User Name <span class="required"> * </span></label>
                           <div class="col-md-7">
                              <input type="text" name="user_name" id="user_name" autocomplete="off" class="form-control" />
                           </div>
                        </div>

                        <div class="form-group">
                           <label class="control-label col-md-5">Password <span class="required"> * </span></label>
                           <div class="col-md-7">
                              <input type="password" name="password" id="password" autocomplete="off" class="form-control" />
                           </div>
                        </div>

                        <div class="form-group">
                           <label class="control-label col-md-5">Confirm Password <span class="required"> * </span></label>
                           <div class="col-md-7">
                              <input type="password" name="conf_password" id="conf_password" autocomplete="off" class="form-control" />
                           </div>
                        </div>
                     </div>

                     <div class="col-md-6">
                        <div class="form-group">
                           <label class="control-label col-md-4">Phone No <span class="required"> * </span></label>
                           <div class="col-md-7">
                              <input type="text" name="phone_no" id="phone_no" autocomplete="off" class="form-control" />
                           </div>
                        </div>

                        <div class="form-group">
                           <label class="control-label col-md-4">Email ID <span class="required"> * </span></label>
                           <div class="col-md-7">
                              <input type="text" name="email_id" id="email_id" autocomplete="off" class="form-control" />
                           </div>
                        </div>

                        <div class="form-group">
                           <label class="control-label col-md-4">User Role <span class="required"> * </span></label>
                           <div class="col-md-7">
                              <select name="user_role" id="user_role" class="form-control">
                                 <option value="">--Select--</option>
                                 <option value="1">Super Admin</option>
                                 <option value="2">Admin</option>
                                 <option value="3">Front Desk</option>
                                 <option value="4">Collection</option>
                              </select>
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

               <div class="modal-footer">
                  <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                  <button type="submit" id="submit_chit" class="btn purple">Save changes</button>
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
         var table;
         table = $('#data_table').DataTable({ 
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
               "url": "<?php echo site_url('User_controller/view_all_users')?>",
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
      });

      function open_popup(show){
         $(".has-error").removeClass("has-error");
         $(".help-block-error").html("");
         $(".display-hide").hide();

         $("#auto_id").val('');
         $("#first_name").val('');
         $("#last_name").val('');
         $("#user_name").val('');
         $("#password").val('');
         $("#conf_password").val('');
         $("#phone_no").val('');
         $("#email_id").val('');
         $("#user_role option[value='']").prop("selected",true);
         $("#status").prop('checked',true);

         $("#condition").val('add_user');
         $(".modal-title").html("User Entry");
         $("#submit_chit").html("Save");
         if(show!='add'){
            $("#condition").val('edit_user');
            $(".modal-title").html("User Edit");
            $("#submit_chit").html("Save Changes");
            $.ajax({
               url : base_url+"index.php/User_controller/get_user_details",
               type : 'post',
               data : 'user_id='+$(show).attr('user_id'),
               success:function(result){
                  var data = JSON.parse(result).user_details;

                  $("#auto_id").val(data[0].log_id);
                  $("#first_name").val(data[0].log_first_name);
                  $("#last_name").val(data[0].log_last_name);
                  $("#user_name").val(data[0].log_user_name);
                  $("#phone_no").val(data[0].log_phone_no);
                  $("#email_id").val(data[0].log_email_id);

                  $("#user_role option[value="+data[0].log_user_role+"]").prop("selected",true);

                  if(data[0].log_status==0){
                     $("#status").prop('checked',true);
                  } else {
                     $("#status").prop('checked',false);
                  }
               }
            });
         }
      }
   </script>