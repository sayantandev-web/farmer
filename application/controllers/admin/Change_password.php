<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Change_password extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//$this->loggedIn();
	}

	public function index()
	{
		$data = array(
			'title' => 'Change Password'
		);
		$data['userId'] = $userId = $this->session->userdata('userId');

		$this->load->view('admin/header', $data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/change_password');
		$this->load->view('admin/footer');
	}


	public function update()
	{
		$userId = $this->session->userdata('userId');

		if ($this->input->post('c_password')) {

			$this->form_validation->set_rules('c_password', 'Current Password', 'trim|required');
			$this->form_validation->set_rules('n_password_confirmation', 'New Password', 'trim|required');
			$this->form_validation->set_rules('n_password', 'Repeat Password', 'trim|required|matches[n_password_confirmation]');
			$msg = '';

			if ($this->form_validation->run() == false) {
				if (form_error('c_password')) {
					$msg .= strip_tags(form_error('c_password'));
				}
				if (form_error('n_password_confirmation')) {
					$msg .= strip_tags(form_error('n_password_confirmation'));
				}
				if (form_error('n_password')) {
					$msg .= strip_tags(form_error('n_password'));
				}
			} else {
				$c_password = $this->input->post('c_password');
				$n_password = $this->input->post('n_password');
				$user = $this->Adminmodel->get('admin', true, 'userId', $userId);
                
                if($c_password == $n_password){
                	$msg = '["New Password can not be same as old password.", "warning", "#F29F06"]';
                } 

				elseif (! password_verify($c_password, $user->password)) {
					$msg = '["You have entered wrong password.", "warning", "#F29F06"]';
				} else {

					$mydata['password'] = $this->enc_password($n_password);

					if (!$this->Adminmodel->update($mydata, 'admin', ['userId'=>$userId])) {
						$msg = 'error';
					} else {
						$msg = '["Password changed successfully.", "success", "#A5DC86"]';
					}
				}
			}
			$this->session->set_flashdata('msg', $msg);
		}
		redirect(base_url('admin/profile'),'refresh');
	}
	public function enc_password($password)
	{
		$encrypted_password = password_hash($password, PASSWORD_DEFAULT);
		return $encrypted_password;
	}


	public function my_encrypt($data)
	{
		return $this->my_simple_crypt($data, 'e');
	}


	public function my_decrypt($data) {
		return $this->my_simple_crypt($data, 'd');
	}

}
