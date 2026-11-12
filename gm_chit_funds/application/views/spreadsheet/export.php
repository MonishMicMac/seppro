 <?php $this->load->view('templates/header'); ?>

 <!-- container --> 
  <section class="showcase">
    <div class="container">
      <div class="pb-2 mt-4 mb-2 border-bottom">
        <h2>Export Data to Excel and CSV file using PhpSpreadsheet library in CodeIgniter and MySQL</h2>
      </div>

    <form action="<?php print site_url();?>phpspreadsheet/export" class="excel-upl" id="excel-upl" enctype="multipart/form-data" method="post" accept-charset="utf-8">
      <div class="row padall">  
      <div class="col-lg-12">
      <div class="float-right">  
        <input type="radio" checked="checked" name="export_type" value="xlsx"> .xlsx
        <input type="radio" name="export_type" value="xls"> .xls
        <input type="radio" name="export_type" value="csv"> .csv
        <button type="submit" name="import" class="btn btn-primary">Export</button>
        </div> 
      </div>
      </div>
    </form>

      <div class="row">
        <div class="col-lg-12">     
        <table class="table table-striped">
          <thead>
            <tr class="table-primary">
              <th scope="col">First Name</th>
              <th scope="col">Last Name</th>
              <th scope="col">Email</th>
              <th scope="col">DOB</th>
              <th scope="col">Contact No</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($empInfo as $element) {?>
            <tr>
              <td><?php print $element['first_name'];?></td>
              <td><?php print $element['last_name'];?></td>
              <td><?php print $element['email'];?></td>
              <td><?php print $element['dob'];?></td>
              <td><?php print $element['contact_no'];?></td>
            </tr>
          <?php } ?>
          </tbody>
        </table>
        </div>
      </div>
    </div>
  </section>
 <?php $this->load->view('templates/footer');?>