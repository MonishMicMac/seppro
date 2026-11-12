<?php
$this_page='login_report';
include("include/header.php");
?>
<style type="text/css">
   .ui-autocomplete { position: absolute; cursor: default;z-index:9999999 !important;}
</style>
<div class="page-content-wrapper">
   <div class="page-content">
      <div class="page-head">
         <div class="page-title">
            <h1>Login Report</h1>
         </div>
      </div>

      <div class="row">
         <div class="col-md-12">
            <div class="portlet light bordered">
               <br/>
               <br/>
               <div class="row" style="margin-bottom: -20px;">
                  <div class="row">
                     <div class="col-md-3">
                        <div class="form-group">
                           <label class="control-label col-md-5">User Name</label>
                           <div class="col-md-7">
                              <input type="text" name="user_name" id="user_name" autocomplete="off"  class="form-control" />
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


      <div class="row">
         <div class="col-md-12">
            <div class="portlet light bordered">
               <div class="portlet-title">
                  <div class="caption"><i class="fa fa-globe"></i>Login Report </div>
                  <div class="tools"> </div>
               </div>
               <div class="portlet-body">

                  <table class="table table-striped table-bordered table-hover" id="table">
                     <thead>
                        <tr>
                           <th> S.No </th>
                           <th> User Name </th>
                           <th> IP Address </th>
                           <th> Login Time </th>
                           <th> Logout Time </th>
                        </tr>
                     </thead>

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
      $('#from_date').datepicker({
         format: 'yyyy-mm-dd'
      });

      $('#to_date').datepicker({
         format: 'yyyy-mm-dd'
      });

      $( "#user_name" ).autocomplete({
         source: function( request, response ) {
            $.ajax({
               url: base_url+'index.php/Login_report_controller/get_users_json',
               type:"post",
               dataType: "json",
               data: {
                  user_name: request.term
               },
               success: function( data ) {
                  response(data);
               }
            });
         },
         select: function (event, ui) {
            $('#user_name').val(ui.item.value);
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
            "url": "<?php echo site_url('Login_report_controller/view_login_report')?>",
            "type": "POST",
            "data": function ( data ) {
               data.user_name = $('#user_name').val();
               data.from_date = $('#from_date').val();
               data.to_date = $('#to_date').val();
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

      $("#post_job_for_users").click(function(){
         table.ajax.reload();
      });
   });
</script>