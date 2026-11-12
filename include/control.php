<?php
require_once 'function.php';
if(isset($_REQUEST['command']))
{
$command=$_REQUEST['command'];
}
switch($command)
{
	case "add_distributor":
	add_distributor($_POST);
	break;
	case "edit_distributor":
	edit_distributor($_POST);
	break;
	case "add_marketer":
	add_marketer($_POST);
	break;
	case "edit_marketer":
	edit_marketer($_POST);
	break;
	case "add_representative":
	add_representative($_POST);
	break;
	case "edit_representative":
	edit_representative($_POST);
	break;	
	case "edit_representative_ges":
	edit_representative_ges($_POST);
	break;
	case "add_product":
	add_product($_POST);
	break;
	case "edit_product":
	edit_product($_POST);
	break;

	case "add_product_anderson":
	add_product_anderson($_POST);
	break;
	case "edit_product_anderson":
	edit_product_anderson($_POST);
	break;

	case "add_pincode":
	add_pincode($_POST);
	break;
	case "add_customer":
	add_customer($_POST);
	break;
    	case "add_doctor":
	add_doctor($_POST);
	break;
        case "edit_doctor":
	edit_doctor($_POST);
	break;
	 case "edit_doctor_zinnia":
	edit_doctor($_POST);
	break;
        case "add_distributed_customer";
        add_distri_cust($_POST);
        break;
        case "edit_customerr";
        edit_customerr($_POST);
        break;
        case "add_manager";
        add_manager($_POST);
        break;
        case "add_dis_product";
        add_dis_product($_POST);
        break;
	
}
