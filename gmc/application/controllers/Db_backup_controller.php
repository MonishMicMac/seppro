<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(0);
class Db_backup_controller extends CI_Controller{  
	function __construct(){
		parent::__construct();
		$this->load->helper('url');		
		ini_set('upload_max_filesize', '2000M');
		ini_set('post_max_size', '1000M');
		ini_set('max_input_time', 3000);
		ini_set('max_execution_time', 15000);
		ini_set('memory_limit', '-1');
	}

public function db_backup(){
		
		$this->load->view('db_backup');
	}

	public function db_backup_download(){
		
		$this->load->dbutil();
		$prefs = array(     
			'format'      => 'zip',             
			'filename'    => 'my_db_backup.sql'
		);


		$backup =& $this->dbutil->backup($prefs); 

		$db_name = 'GM_Chit-backup-on-'. date("Y-m-d-H-i-s") .'.zip';
		$save = 'pathtobkfolder/'.$db_name;

		$this->load->helper('file');
		write_file($save, $backup); 


		$this->load->helper('download');
		force_download($db_name, $backup);
	}

	
}
?>