<?php

$target_path = "uploads/";

$target_path = $target_path . $_FILES['image']['name'];

try {
    //throw exception if can't move the file  file_put_contents($ImagePath,base64_decode($ImageData));
    if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
        throw new Exception('Could not move file');
    }

    echo "The file " . basename($_FILES['image']['name']) .
    " has been uploaded";
   // mysql_query("UPDATE doctors SET visitcardclinicphoto='".$_REQUEST['imagename']."'  WHERE id='".$_REQUEST['dr_id']."' ")or die(mysql_error());
} catch (Exception $e) {
    die('File did not upload: ' . $e->getMessage());
}
?>