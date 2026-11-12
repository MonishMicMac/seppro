<?php
include("connect.php");

$item_id=$_REQUEST['item_id'];
$status=$_REQUEST['status'];

$upload_file=$_FILES['upload_file'];
//$filename=time().'_'.$upload_file['name']; 
$filename=$upload_file['name'];
move_uploaded_file($upload_file['tmp_name'], 'expenses_images/'.$filename);
echo $upload_file;
echo $filename;
/*
if($status==1){
	mysqli_query($conn,"UPDATE book_ride SET pickup_photo='$filename' WHERE itemid='$item_id'");
} elseif($status==2) {
	mysqli_query($conn,"UPDATE book_ride SET delivery_photo='$filename' WHERE itemid='$item_id'");
}
*/
?>