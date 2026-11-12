<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(0);
class Test extends CI_Controller{  
	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
	}

	public function index(){
		$this->load->view('blank_page');
	}
	
}
?>