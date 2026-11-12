<?php
$this_page='chit_subs_assign';
include("include/header.php");
?>
<style type="text/css">
.ui-autocomplete { position: absolute; cursor: default;z-index:9999999 !important;}
</style>
<div class="page-content-wrapper">
   <div class="page-content">
      <div class="page-head">
         <div class="page-title">
            <h1>Subscriber To Chit</h1>
         </div>

         <div class="page-toolbar">
            <button data-toggle="modal" href="#basic" class="btn green" onclick='open_popup("add")' style="float:right;margin-right:1px;">Subscriber To Chit Entry</button>
         </div>
      </div>

      <div class="row">
         <div class="col-md-12">
            <div class="portlet light bordered">
               <div class="portlet-title">
                  <div class="caption"><i class="fa fa-globe"></i>Chits List </div>
                  <div class="tools"> </div>
               </div>
               <div class="portlet-body">
                  <table class="table table-striped table-bordered table-hover" id="data_table">
                     <thead>
                        <tr>
                           <th> S.No </th>
                           <th> Chit ID </th>
                           <th> Subscriber ID </th>
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
         <form action="<?php echo base_url(); ?>index.php/Chit_subs_controller/chit_add_edit" id="chit_subs_form" method="post" class="form-horizontal">
            <input type="hidden" name="condition" id="condition">
            <div class="modal-body">
               <div class="form-body">
                  <div class="alert alert-danger display-hide">
                     <button class="close" data-close="alert"></button> You have some errors. Please check below.
                  </div>

                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                           <label class="control-label col-md-4">Chit ID <span class="required"> * </span></label>
                           <div class="col-md-7">
                              <input type="hidden" name="popup_chit_id" id="popup_chit_id" />
                              <input type="text" name="chit_id" id="chit_id" autocomplete="off" class="form-control" />
                           </div>
                        </div>
                     </div>
                  </div>

                  <div class="row" id="show_subs_textbox"></div>
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
      $('#chit_date').datepicker({
         format: 'dd/mm/yyyy'
      });

      $( "#chit_id" ).autocomplete({
         source: function( request, response ) {
            $.ajax({
               url: base_url+'index.php/Chit_subs_controller/get_chits_json',
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

      $("#chit_id").blur(function(){
         $.ajax({
            url:base_url+"index.php/Chit_subs_controller/get_chit_sub_cnt",
            type:"post",
            data:"chit_id="+$(this).val(),
            success:function(data){
               $("#show_subs_textbox").html('');
               var result = JSON.parse(data);
               var total_subs = result.subscribers_cnt;
               var subs='';
               var subs2='';
               var subs4='';
               
               var half_total=Math.ceil(total_subs/2);
               var t=0;
               for (var i=1; i<=total_subs; i++) {
                  var subs1='';
                  var subs3='';

                  if(i>9){
                     t=i;
                  } else {
                     t='0'+i;
                  }

                  if(i==1){
                     var subs1="<div class='col-md-6'>";
                  }
                  var subs2="<div class='row'><div class='col-md-12'><div class='form-group'><label class='control-label col-md-4'>Subscriber "+i+" <span class='required'> * </span></label><div class='col-md-7'><input type='hidden' name='subscriber_sno[]' value='"+t+"'><input type='text' name='subscriber_id[]' class='form-control subscriber_id' onkeyup='subscriber_id(this)' autocomplete='off' /></div></div></div></div>";

                  if(i==half_total){
                     var subs3="</div><div class='col-md-6'>";
                  }
                  if(i==total_subs){
                     var subs4="</div>";
                  }

                  subs+=(subs1+subs2+subs3+subs4);
               }
               $("#show_subs_textbox").append(subs);
               sub_auto();
            }
         });
      });

      var table;
      table = $('#data_table').DataTable({ 
         "processing": true,
         "serverSide": true,
         "order": [],
         "ajax": {
            "url": "<?php echo site_url('Chit_subs_controller/view_all_chit_subs')?>",
            "type": "POST",
            "data": function ( data ) {

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
         "columnDefs": [
         { 
            "targets": [ 0 ],
            "orderable": false,
         }
         ]
      });
   });

   function sub_auto(){
      $("input[name^=subscriber_id]").autocomplete({
         source: function( request, response ) {
            var sub_ids=[];
            $("input[name^=subscriber_id]").each(function(){
               if($(this).val()!=''){
                  sub_ids.push($(this).val());
               }
            });

            $.ajax({
               url: base_url+'index.php/Chit_subs_controller/get_subscribers_json',
               type:"post",
               dataType: "json",
               data: {
                  sub_ids: sub_ids,
                  subscriber_id: request.term
               },
               success: function( data ) {
                  response(data);
               }
            });
         },
         select: function (event, ui) {
            $(this).val(ui.item.value);
            return false;
         }
      }).autocomplete( "instance" )._renderItem = function( ul, item ) {
         return $( "<li>" )
         .append( "<div>" + item.label + "</div>" )
         .appendTo( ul );
      };
   }

   function subscriber_id(show){
      if($(show).val()==''){
         $(show).closest("div.form-group").addClass("has-error");
         $(show).closest("div").find('span').remove();
         $(show).after('<span id="subscriber_id-error" class="help-block help-block-error">Please Enter Subscriber ID / Name</span>');
      } else {
         $(show).closest("div.form-group").removeClass("has-error");
         $(show).closest("div").find('span').remove();
      }
   };

   function open_popup(show){
      $(".has-error").removeClass("has-error");
      $(".help-block-error").html("");
      $(".display-hide").hide();

      $("#chit_id").val('');
      $("#show_subs_textbox").html('');

      $("#condition").val('add_chit_subs');
      $(".modal-title").html("Subscriber To Chit Entry");
      $("#submit_chit").html("Save");
      if(show!='add'){
         $("#condition").val('edit_chit_subs');
         $(".modal-title").html("Subscriber To Chit Edit");
         $("#submit_chit").html("Save Changes");
         $.ajax({
            url : base_url+"index.php/Chit_subs_controller/get_chit_subs_details",
            type : 'post',
            data : 'chit_id='+$(show).attr('chit_id'),
            success:function(result){
               var data = JSON.parse(result).cs_details;

               $("#chit_id").val(data.asc_chit_id);
               $("#popup_chit_id").val(data.asc_chit_id);

               var subscriber_id=data.asc_subscriber_id.split(',');
               var subscribers_cnt=data.c_subscribers_cnt;

               var sub_id='';
               var subs='';
               var subs2='';
               var subs4='';

               var half_total=Math.ceil(subscribers_cnt/2);
               var t=0;
               for (var i=0; i<subscribers_cnt; i++) {

                  h=parseInt(i)+1;
                  if(subscriber_id[i]!=undefined){
                     sub_id=subscriber_id[i];
                  } else {
                     sub_id='';
                  }
                  var subs1='';
                  var subs3='';
                  if(h==1){
                     var subs1="<div class='col-md-6'>";
                  }

                  if(h>9){
                     t=h;
                  } else {
                     t='0'+h;
                  }

                  var subs2="<div class='row'><div class='col-md-12'><div class='form-group'><label class='control-label col-md-4'>Subscriber "+h+" <span class='required'> * </span></label><div class='col-md-7'><input type='hidden' name='subscriber_sno[]' value='"+t+"'><input type='text' name='subscriber_id[]' class='form-control subscriber_id' onkeyup='subscriber_id(this)' autocomplete='off' value='"+sub_id+"' /></div></div></div></div>";

                  if(h==half_total){
                     var subs3="</div><div class='col-md-6'>";
                  }
                  if(h==subscribers_cnt){
                     var subs4="</div>";
                  }

                  subs+=(subs1+subs2+subs3+subs4);
               }
               $("#show_subs_textbox").append(subs);
               sub_auto();
            }
         });
      }
   }
</script>