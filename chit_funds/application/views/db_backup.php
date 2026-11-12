<?php
$this_page='collection';
include("include/header.php");
?>
<style type="text/css">
   .ui-autocomplete { position: absolute; cursor: default;z-index:9999999 !important;}
</style>
<div class="page-content-wrapper">
   <div class="page-content">
      <div class="page-head">
         <div class="page-title">
            <h1>Database Backup</h1>
         </div>
       <!--   <div class="page-toolbar">
            <button data-toggle="modal" href="#basic" class="btn green" onclick='open_popup("add")' style="float:right;margin-right:1px;">Collection Entry</button>
         </div> -->
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
         <br><br><br>
         <div class="col-md-12">
           <div class="modal-dialog modal-lg">
            <div class="modal-content">

            
             <!-- <form action="<?php echo base_url(); ?>index.php/Db_backup_controller/db_backup_download" name="settings" method="post" enctype="multipart/form-data"> -->
               <form class="form-horizontal" action="<?php echo base_url();?>index.php/Db_backup_controller/db_backup_download/" name="settings" method="post" enctype="multipart/form-data" >
              <div class="modal-footer">
               <div class="col-md-2">
                  <input type="submit" id="btn-filter" name="Submit" class="btn btn-primary" value="Backup">
               </div>
            </div> 
  </form>
</div>
</div>

</div>
</div>


</div>
</div>

<?php
include("include/footer.php");
?>
