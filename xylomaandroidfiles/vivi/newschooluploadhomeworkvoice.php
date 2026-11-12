<?php


$target_path = "audio/";

$uploaded_files=$_FILES['uploadedfile']['name'];

move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path .$_FILES['uploadedfile']['name']);

?>