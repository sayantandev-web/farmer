<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		//$this->load->library('email');
		$this->load->helper('url');
	}
	public function index()
	{
		$data = array('page' => 'login');
		if ($this->input->post('username')) {
			$this->form_validation->set_rules('username', 'Email', 'trim|required');
			$this->form_validation->set_rules('password', 'Password', 'trim|required');
			if ($this->form_validation->run() == false) {
				$msg = '';
				if (form_error('username')) {
				    $msg .= strip_tags(form_error('username'));
				}
				if (form_error('password')) {
				    $msg .= strip_tags(form_error('password'));
				}

				$data['msg'] =  '<div class="alert alert-success alert-dismissible fade show" role="alert">
				'.$msg.'
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>';

			} else {
				$username = $this->input->post('username');
				$password = $this->input->post('password');
				$data['msg'] =  '<div class="alert alert-danger alert-dismissible fade show" role="alert">
				'.$this->Adminmodel->login($username, $password).'!
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>';
				if ($this->session->has_userdata('userId') && $this->session->has_userdata('admin')) {
					//echo $this->session->has_userdata('userId');die;
					//echo $this->session->has_userdata('admin');die;
					//echo $this->input->get('redirectto');die;
					// if ($this->input->get('redirectto')) {
					    // redirect($this->input->get('redirectto'),'refresh');
					// } else {
					    // redirect('admin/dashboard','refresh');
					// }
					redirect('admin/dashboard','refresh');
				}
			}
		}
		if ($this->session->flashdata('msg')) {
		    $data['msg'] = $this->session->flashdata('msg');
		}
		$this->load->view('admin/login', $data);
	}
	public function logout()
	{

		$this->session->unset_userdata('userId');
		$this->session->unset_userdata('admin');
		$msg = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                   You have successfully logged out!
                   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
		$this->session->set_flashdata('msg', $msg);
		redirect(base_url('admin/login'),'refresh');
	}
}