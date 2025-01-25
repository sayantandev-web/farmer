<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->Adminmodel->loggedIn();
	}


	public function index()
	{
		$data = array(
			'title' => 'Update Profile'
		);
		$data['userId'] = $userId = $this->session->userdata('userId');
		$data['data'] = $this->Adminmodel->get('admin', true, 'userId', $userId);

		$this->load->view('admin/header', $data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/profile');
		$this->load->view('admin/footer');
	}


	public function save()
	{
		$userId = $this->session->userdata('userId');

		if ($this->input->post('name')) {

			$mydata = array(
				'name' => $this->testInput($this->input->post('name')),
				'username' => $this->testInput($this->input->post('username')),
				'email' => $this->testInput($this->input->post('email'))
			);

			if (!empty($_FILES['profilePic']['name']) || $this->input->post('oldProfilePic')) {

				$config['upload_path'] = './uploads/admin/';
				$config['allowed_types'] = 'jpeg|jpg|png';
				$config['max_size']  = '10240';

				$this->load->library('upload');
				$this->upload->initialize($config);

				if ( ! $this->upload->do_upload('profilePic')){
					$error = strip_tags($this->upload->display_errors());
				} else {
					$logoArray = $this->upload->data();
					$oldProfilePic = $this->input->post('oldProfilePic');
					$mydata['profilePic'] = $logoArray['file_name'];
				}
			}

			if (!$this->Adminmodel->update($mydata, 'admin', ['userId'=>$userId])) {
				$msg = 'error';
			} else {
				if (!empty($oldProfilePic) && $oldProfilePic != '' && !is_null($oldProfilePic) && file_exists('./uploads/admin/'.$oldProfilePic)) {
					@unlink('./uploads/admin/'.$oldProfilePic);
				}

				$msg = '["Profile updated successfully.", "success", "#A5DC86"]';
			}
			$this->session->set_flashdata('msg', $msg);
		}
		redirect(base_url('admin/profile'),'refresh');
	}
    public function testInput($data)
	{
		$data = trim($data);
		$data = stripcslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	public function check_store_name()
	{
		if ($this->input->post('storeName')) {
			$storeName = $this->testInput($this->input->post('storeName'));
			if ($this->mymodel->count('users', ['store_name'=>$storeName]) > 0) {
				echo 'This Store Name is already taken!';
			} else {
				echo '';
			}
		}
	}

}

/* End of file Profile.php */
/* Location: ./application/controllers/Profile.php */