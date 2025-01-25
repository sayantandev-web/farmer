<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->library('session');
		$this->Adminmodel->loggedIn();
		
		
	}

	public function index()
	{

		//echo CI_VERSION;DIE;
		$data = array(
			'title' => 'Dashboard',
			'page' => 'Dashboard',
			'subpage' => ''
		);
		
		//print_r($this->session->userdata('userId'));die; 

		$this->load->view('admin/header', $data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/dashboard');
		$this->load->view('admin/footer');
	}

}