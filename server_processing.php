<?php
include("include/connect.php");
include("encrypt.php");
$table = 'tbl_customer_master';
$primaryKey = 'id';

$columns = array(
    array(
        'db' => 'rep_id',
        'dt' => 0,
        'formatter' => function($d, $row) {
            if ($d == '') {
                return "Floating";
            } else {
                $reps = '';
                $rep_ids = explode(',', $d);
                foreach ($rep_ids as $rep_id) {
                    $dr_los = mysql_query("SELECT rep_name FROM representative WHERE id = " . $rep_id);
                    while ($dr_rep = mysql_fetch_object($dr_los)) {
                        $reps .= $dr_rep->rep_name . ', ';
                    }
                }
                return rtrim($reps, ', ');
            }
        }
    ),
    array('db' => 'shop_name', 'dt' => 1),
    array('db' => 'pincode', 'dt' => 2),
    array(
        'db' => 'doctor_id',
        'dt' => 3,
        'formatter' => function($d, $row) {
            if ($d == '') {
                return "Floating";
            } else {
                $doctors = '';
                $doctor_ids = explode(',', $d);
                foreach ($doctor_ids as $doctor_id) {
                    $dr_sql = mysql_query("SELECT doctor_name, doc_pincode FROM doctors WHERE id = " . $doctor_id);
                    while ($dr_row = mysql_fetch_object($dr_sql)) {
                        $doctors .= $dr_row->doctor_name . " - " . $dr_row->doc_pincode . ', ';
                    }
                }
                return rtrim($doctors, ', ');
            }
        }
    ),
    array(
        'db' => 'id',
        'dt' => 4,
        'formatter' => function($d, $row) {
            return "<a class='btn btn-info' href='edit_cust.php?c_id=" . $row['id'] . "'><i class='icon-edit icon-white'></i> Edit</a>&nbsp;&nbsp;<a class='btn btn-danger' href='delete.php?c_id=" . $row['id'] . "&comm=cust' onClick=\"return confirm('Are you sure you want to delete?')\"><i class='icon-trash icon-white'></i> Delete</a>";
        }
    )
);


$sql_details = array(
	'user' => @$_SESSION["DBUSR"],
	'pass' => @$_SESSION["DBPWD"],
	'db'   => @$_SESSION["DBNAME"],
	'host' => @$_SESSION["HOST"]
);

require( 'ssp.class.php' );

echo json_encode(SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns ));
?>