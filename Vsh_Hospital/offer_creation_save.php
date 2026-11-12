<?php
include("include/connect.php");

session_start();
// error_reporting(0);

	echo "select * from product_offer_gemeral where  gen_pdt_id='".$_REQUEST["proidgen"]."' ";

 $d=mysql_query("select * from product_offer_gemeral where  gen_pdt_id='".$_REQUEST["proidgen"]."' ");
  $count_d=mysql_num_rows($d);
  $row_d=mysql_fetch_array($d);
  if($count_d==0) {

    // echo $_REQUEST["allpdt"];
    // if($_REQUEST["offgen"]=='single')
    // {
    //   // echo "hi";
       
        
    //    mysql_query("INSERT INTO product_offer_gemeral(gen_pdt_id,gen_offer,gen_percent,gen_qty,gen_free,gen_uptodate,gen_date,gen_time)VALUES('".$_REQUEST["proidgen"]."','".$_REQUEST["offgen"]."','".$_REQUEST["genpercent"]."','".$_REQUEST["genqty"]."','".$_REQUEST["genfree"]."','".date("Y-m-d",strtotime($_REQUEST["genuptodate"]))."','".date('Y-m-d')."','".date('H:i:s')."')")or die(mysql_error());  
    
    //    }

    // elseif ($_REQUEST["offgen"]=='all') {
  	// echo "hi";
   //     $prod=mysql_query("SELECT product.id,product.pro_name FROM tbl_doctor_product_mapping,product WHERE product.id =tbl_doctor_product_mapping.product_id  GROUP BY tbl_doctor_product_mapping.product_id ");
   //      while($row_prod=mysql_fetch_array($prod)){ 
      
       mysql_query("INSERT INTO product_offer_gemeral(gen_pdt_id,gen_offer,gen_percent,gen_qty,gen_free,gen_uptodate,gen_date,gen_time)VALUES('".$_REQUEST["proidgen"]."','".$_REQUEST["offgen"]."','".$_REQUEST["genpercent"]."','".$_REQUEST["genqty"]."','".$_REQUEST["genfree"]."','".date("Y-m-d",strtotime($_REQUEST["genuptodate"]))."','".date('Y-m-d')."','".date('H:i:s')."')")or die(mysql_error());  
         
    // $LastId = mysql_insert_id();
  // }
      
    // }
    
  
 // echo "<script type='text/javascript'>alert('Add Successfully');window.location.href='add_product_kalzem.php';</script>";

 
  }
  else
  {

    //   if($_REQUEST["offgen"]=='single')
    // {
    //   // echo "hi";
    //   if($row_d["gen_date"]==date('Y-m-d'))
    //   {

    //     mysql_query("UPDATE  product_offer_gemeral SET gen_pdt_id='".$_REQUEST["proidgen"]."',gen_offer='".$_REQUEST["offgen"]."',gen_percent='".$_REQUEST["genpercent"]."',gen_qty='".$_REQUEST["genqty"]."',gen_free='".$_REQUEST["genfree"]."',gen_uptodate='".date("Y-m-d",strtotime($_REQUEST["genuptodate"]))."',gen_date='".date('Y-m-d')."',gen_time='".date('H:i:s')."' WHERE gen_id='".$row_d["gen_id"]."'")or die(mysql_error()); 
    //   }
    //   else
    //   {

    //            mysql_query("UPDATE  product_offer_gemeral SET gen_uptodate='".date("Y-m-d")."',gen_date='".date('Y-m-d')."',gen_time='".date('H:i:s')."' WHERE gen_id='".$row_d["gen_id"]."'")or die(mysql_error()); 

    //        mysql_query("INSERT INTO product_offer_gemeral(gen_pdt_id,gen_offer,gen_percent,gen_qty,gen_free,gen_uptodate,gen_date,gen_time)VALUES('".$_REQUEST["proidgen"]."','".$_REQUEST["offgen"]."','".$_REQUEST["genpercent"]."','".$_REQUEST["genqty"]."','".$_REQUEST["genfree"]."','".date("Y-m-d",strtotime($_REQUEST["genuptodate"]))."','".date('Y-m-d')."','".date('H:i:s')."')")or die(mysql_error()); 

    //      }      
     
    
    //    }

    // elseif ($_REQUEST["offgen"]=='all') {
         if($row_d["gen_date"]==date('Y-m-d'))
      {
        // echo "hello";
        //  $prod51=mysql_query("SELECT product.id,product.pro_name FROM tbl_doctor_product_mapping,product WHERE product.id =tbl_doctor_product_mapping.product_id");
        // while($row_prod51=mysql_fetch_array($prod51)){
       
            mysql_query("UPDATE  product_offer_gemeral SET gen_pdt_id='".$_REQUEST["proidgen"]."',gen_offer='".$_REQUEST["offgen"]."',gen_percent='".$_REQUEST["genpercent"]."',gen_qty='".$_REQUEST["genqty"]."',gen_free='".$_REQUEST["genfree"]."',gen_uptodate='".date("Y-m-d",strtotime($_REQUEST["genuptodate"]))."',gen_date='".date('Y-m-d')."',gen_time='".date('H:i:s')."' WHERE gen_id='".$row_d["gen_id"]."'")or die(mysql_error()); 
          // }
      }
      else
      {

       // $prod5=mysql_query("SELECT product.id,product.pro_name FROM tbl_doctor_product_mapping,product WHERE product.id =tbl_doctor_product_mapping.product_id ");
       //  while($row_prod5=mysql_fetch_array($prod5)){ 
       //       mysql_query("UPDATE  product_offer_gemeral SET gen_uptodate='".date("Y-m-d",strtotime($_REQUEST["genuptodate"]))."',gen_date='".date('Y-m-d')."',gen_time='".date('H:i:s')."' WHERE gen_id='".$row_d["gen_id"]."'")or die(mysql_error()); 

       mysql_query("INSERT INTO product_offer_gemeral(gen_pdt_id,gen_offer,gen_percent,gen_qty,gen_free,gen_uptodate,gen_date,gen_time)VALUES('".$_REQUEST["proidgen"]."','".$_REQUEST["offgen"]."','".$_REQUEST["genpercent"]."','".$_REQUEST["genqty"]."','".$_REQUEST["genfree"]."','".date("Y-m-d",strtotime($_REQUEST["genuptodate"]))."','".date('Y-m-d')."','".date('H:i:s')."')")or die(mysql_error());  
    // $LastId = mysql_insert_id();

  // }
      
    }
  // }
  // else{
  // echo "<script type='text/javascript'>alert('Already Added Successfully');</script>";
  // }

}
?>