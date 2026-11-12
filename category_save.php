<?php 
    include("include/connect.php");
    
    if($_REQUEST['SUBMIT_DATA'] == 'submit'){

        $category = $_REQUEST['status'];
        
        
        $created_at = date('Y-m-d H:i:s');

        $ins= mysql_query("SELECT * from category  WHERE  category='$category' ");
        // print_r($ins);exit();
        $row= mysql_fetch_array($ins);
        // $red=$row->status;
        // print_r($red);exit();



        $inserted = mysql_query("INSERT INTO category(category,created_at) VALUES('$category','$created_at')")or die(mysql_error());

        if($inserted != $row){
            echo '<script type="text/javascript">alert("category added successfully");window.location="category.php"</script>';
        }

    }else{
        echo 'alert("Something went wrong, couldnt save the data")';
    }


?>