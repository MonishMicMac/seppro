<?php

if ( !isset($_REQUEST['term']) )
    exit;


include("include/connect.php");


//$dblink = mysql_connect('localhost', 'doctorsi_doctors', 'micandmac@123') or die( mysql_error() );
//mysql_select_db('doctorsi_doctors');

$rs = mysql_query('select pro_name, id, pro_id, ptr from product where pro_name like "'. mysql_real_escape_string($_REQUEST['term']) .'%" order by pro_name asc limit 0,10');

$data = array();
if ( $rs && mysql_num_rows($rs) )
{
    while( $row = mysql_fetch_array($rs, MYSQL_ASSOC) )
    {
        $data[] = array(
           'label' => '<table width="100%">
		   <tr>
		   <td width="40%">'.$row['pro_name'].'</td>
		   <td width="15%">'. $row['id'].'</td>
		   <td width="15%">'. $row['pro_id'].'</td>
		   <td width="30%">'.$row['ptr'].'</td>
		 
		   </tr></table>' ,
            'value' => $row['pro_id']
        );
    }
}

echo json_encode($data);
flush();

