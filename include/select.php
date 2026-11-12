<?php
include("connect.php");
class select1
{
		public function cnt($tbl,$column_name){
			$sql="SELECT COUNT(*) AS CNT FROM $tbl WHERE $column_name ";
			$res=mysql_query($sql);
			$yuvaraj = mysql_fetch_object($res);
			return $yuvaraj->CNT;
		}
        ////////////////////////////////////////////////////////////////////////
        public function view($a,$b,$c)
        {
                $sql="select * from ".$a.' '.$b.' '.$c;
                $result=mysql_query($sql) or mysql_error();
                return $result;
        }
        ////////////////////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////////////////////
        public function view1($a,$b,$c)
        {
                $sql="select * from ".$a.' '.$b.' '.$c;
                $result=mysql_query($sql) or mysql_error();
                return $result;
        }
        ////////////////////////////////////////////////////////////////////////
        public function count1($a,$b,$c)
        {
                $sql="select * from ".$a.' '.$b.' '.$c;
                $result=mysql_query($sql) or mysql_error();
                $count_result=mysql_num_rows($result);
                return $count_result;  	
        }
        ////////////////////////////////////////////////////////////////////////
        public function delete($a,$b,$c)
        {
                $sql="delete from ".$a.' '.$b.' '.$c;
                $result=mysql_query($sql) or mysql_error();
                return $result;
        }
        ////////////////////////////////////////////////////////////////////////
        public function get_district($abc)
        {
            $a=mysql_query("select * from district where id = '$abc'")or die(mysql_error());
            $count_a=mysql_num_rows($a);
            if($count_a > 0)
            {
                $row_a=mysql_fetch_array($a);
                return $row_a['dist_name'];
            }
            else 
            {
                return 'No match found';

            }    
        }
        ////////////////////////////////////////////////////////////////////////
        public function get_area($abc)
        {
            $a=mysql_query("select * from  pincode_list where id = '$abc'")or die(mysql_error());
            $count_a=mysql_num_rows($a);
            if($count_a > 0)
            {
                $row_a=mysql_fetch_array($a);
                $areaname=$row_a['area_name'];
                $pincode=$row_a['pincode'];
                $combain="/".$areaname."/".$pincode;
                return $combain;                               
            }
            else 
            {
                return null;

            }    
        }
        ////////////////////////////////////////////////////////////////////////
        public function get_speciality($abc)
        {
             if($abc === '')
             {
               return 'No match found';   
             }
             else
             {
                $a=mysql_query("select * from specilist_list where id = ".$abc."")or die(mysql_error());
                $row_a=mysql_fetch_array($a);
                return $row_a['specilist_name'];
             }   

        }
        ////////////////////////////////////////////////////////////////////////
        public function get_doctor($doc_id)
        { 
                $a=mysql_query("select * from  doctors where id = '$doc_id'")or die(mysql_error());
                $row_a=mysql_fetch_array($a);
                return $row_a['doctor_name']; 
        }
        ////////////////////////////////////////////////////////////////////////
        public function select_operation($table,$where,$col,$elsemsg)
        {
            $yu = "SELECT * FROM $table WHERE $where";
            $r = mysql_query($yu);
            $d = mysql_num_rows($r);
            if($d>0)
            {
                while($ry=mysql_fetch_object($r))
                {
                   return $ry->$col;
                }			
            }
            else
            {
               return $elsemsg;
            }
        }
        ////////////////////////////////////////////////////////////////////////
        public function select_our_product_name($abc)
        {
            $a=mysql_query("select * from product where id = '$abc'")or die(mysql_error());
            $row_a=  mysql_fetch_array($a);
            if($row_a['pro_name'])
            {
            return $row_a['pro_name'];
            }else
            {
                echo "No Records Found";
            }
        }
		
        ////////////////////////////////////////////////////////////////////////
        public function get_pin_area($abc)
        {
            $a=mysql_query("select * from  pincode_list where pin_id = '$abc'")or die(mysql_error());
            $count_a=mysql_num_rows($a);
            if($count_a > 0)
            {
                $row_a=mysql_fetch_array($a);
                $areaname=$row_a['area_name'];
                $pincode=$row_a['pincode'];
                $combain=$pincode."/".$areaname;
                return $combain;                               
            }
            else 
            {
                return null;

            } 
        }
        ////////////////////////////////////////////////////////////////////////
        public function get_representative($abc)
        {
            $a=mysql_query("select * from representative where id = '$abc'")or die(mysql_error());
            $row_a=  mysql_fetch_array($a);
            return $row_a['rep_name'];
        }
        ////////////////////////////////////////////////////////////////////////
        public function get_managers($abc)
        {
            $a=mysql_query("select * from managers where id = '$abc'")or die(mysql_error());
            $row_a=  mysql_fetch_array($a);
            return $row_a['manager_name'];
        }  
        ////////////////////////////////////////////////////////////////////////
        public function get_admin_state($abc)
        {
            $a=mysql_query("select state_name from master_state where state_id = '$abc'")or die(mysql_error());
            $row_a=  mysql_fetch_array($a);
            return $row_a['state_name'];
        }  
        ////////////////////////////////////////////////////////////////////////
        public function get_admin_district($abc)
        {
            $a=mysql_query("select * from master_district where district_id = '$abc'")or die(mysql_error());
            $row_a=  mysql_fetch_array($a);
            return $row_a['district_name'];
        }  
        ////////////////////////////////////////////////////////////////////////
        public function get_admin_division($abc)
        {
            $a=mysql_query("select * from  marketer where id = '$abc'")or die(mysql_error());
            $row_a=  mysql_fetch_array($a);
            return $row_a['mark_name'];
        } 
        ////////////////////////////////////////////////////////////////////////
        public function get_master_pincode($abc)
        {
            $a=mysql_query("select * from  master_pincode where pin_id = '$abc'")or die(mysql_error());
            $row_a=  mysql_fetch_array($a);
            return $row_a['pincode'];
        } 
        ////////////////////////////////////////////////////////////////////////
        
        public function get_restricted_district($abc)
        {
            $a=mysql_query("select * from  master_district where district_id = '$abc'")or die(mysql_error());
            $row_a=  mysql_fetch_array($a);
            return $row_a['district_name'];
        } 
        ////////////////////////////////////////////////////////////////////////
        
}	