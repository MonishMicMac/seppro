<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <title>Login Page</title>
  <style>
    body {
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      background-color: #f8f9fa;
    }

    .card-container {
      width: 500px;
      background-color: black;
  
    }

   
  </style>
</head>
<body>

 

  <div class="card card-container ">
    <div class="card-body">
      <h3 class="card-title text-center text-light mt-2">Propel Healthcare Rep</h3>
      <p class="text-light" style="text-align: justify; width: 450px;">We understand that circumstances may change, and you may choose to delete your account. If you wish to proceed fill the form and submit.</p>
<p class="text-light">Note:</p>
<p  class="text-light" style="text-align: justify; width: 450px;">Deleting your account will permanently remove all associated data, including your profile information and usage history. Please note that the deletion process may take 2 working days, and you will be notified once it's completed.
We take your privacy seriously. Your account and associated data will be permanently deleted in accordance with our privacy policy.</p>

      <form class="form-horizontal" action="propel_rep_save.php" enctype="multipart/form-data" method="post"  name="frm" >
        <!-- <div class="form-group">
          <label for="username" class="text-light">USER NAME</label>
          <input type="text" class="form-control" id="username" name="username" style="width: 450px;"  placeholder="ENTER YOUR USERNAME">
        </div> -->
        <div class="form-group">
          <label for="password" class="text-light">ENTER YOUR LOGIN DETAIL : </label>
          <input type="text" class="form-control" id="password" name="password" style="width: 450px;"  placeholder="username or phonenumber">
        </div>
        <button type="submit" class="btn btn-primary btn-block"  name="submit" value="submit" style="margin-left: 349px; width: 100px;margin-top: 20px;">Submit</button>
      </form>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>
</html>
