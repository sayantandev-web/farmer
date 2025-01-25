<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Settings extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->Adminmodel->loggedIn();
	}
	public function site_settings()
	{
		$data = array(
			'title' => 'Site Settings',
			'page' => 'Site Settings',
			'subpage' => 'site_settings'
		);
		$data['data'] = $this->Adminmodel->get('settings', true, 'settingId', 1);
		$this->load->view('admin/header', $data, FALSE);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/site-settings');
		$this->load->view('admin/footer');
	}
	public function save()
	{
		if ($this->input->post('settings')) 
		{			
			$mydata = array(
				'address' => $this->testInput($this->input->post('address')),
				'email' => $this->lc($this->input->post('email')),
				'phone' => $this->testInput($this->input->post('phone')),
				'facebook' => $this->testInput($this->input->post('facebook')),
				'twitter' => $this->testInput($this->input->post('twitter')),
				'linkedin' => $this->testInput($this->input->post('linkedin')),
				'instagram' => $this->testInput($this->input->post('instagram')),
				'youtube' => $this->testInput($this->input->post('youtube')),
			);
			
			$where = array('settingId' => '1');
			
			if (!$this->Adminmodel->update($mydata, 'settings', $where))
			{
				$msg = 'error';
			} else {
				$msg = '["Setting saved successfully!", "success", "#A5DC86"]';
			}
			$this->session->set_flashdata('msg', $msg);
		}
		redirect(base_url('admin/settings/site_settings'),'refresh');
	}
	public function logo()
	{
		$data = array(
			'title' => 'Logo Settings',
			'page' => 'Logo Settings',
			'subpage' => 'logo_settings'
		);
		$data['data'] = $this->Adminmodel->get('settings', true, 'settingId', 1);
		$this->load->view('admin/header', $data, FALSE);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/logo-settings');
		$this->load->view('admin/footer');
	}
	public function logosave()
	{
		if ($this->input->post('logo_settings')) {
			$mydata = array();
			$where = array('settingId' => '1');
			if ($_FILES['logo']['name']!='') {
				$config['upload_path'] = './uploads/logos/';
				$config['allowed_types'] = 'jpeg|jpg|png';
				$config['max_size']  = '10240';
				$this->load->library('upload');
				$this->upload->initialize($config);
				if ( ! $this->upload->do_upload('logo')){
					$error = strip_tags($this->upload->display_errors());
				} else {
					$logoArray = $this->upload->data();
					$oldLogo = $this->input->post('oldLogo');
					$mydata['logo'] = $logoArray['file_name'];
				}
			}
		
			if ($_FILES['sec_logo']['name']!='') {
				$config['upload_path'] = './uploads/logos/';
				$config['allowed_types'] = 'jpeg|jpg|png';
				$config['max_size']  = '10240';
				$this->load->library('upload');
				$this->upload->initialize($config);
				if ( ! $this->upload->do_upload('sec_logo')){
					$error = strip_tags($this->upload->display_errors());
				} else {
					$logoArray = $this->upload->data();
					$oldLogo = $this->input->post('oldSecLogo');
					$mydata['sec_logo'] = $logoArray['file_name'];
				}
			}
			if ($_FILES['favicon']['name']!='') {
				$config['upload_path'] = './uploads/logos/';
				$config['allowed_types'] = 'jpeg|jpg|png';
				$config['max_size']  = '10240';
				$this->load->library('upload');
				$this->upload->initialize($config);
				if ( ! $this->upload->do_upload('favicon')){
					$error = strip_tags($this->upload->display_errors());
				} else {
					$faviconArray = $this->upload->data();
					$oldFavicon = $this->input->post('oldFavicon');
					$mydata['favicon'] = $faviconArray['file_name'];
					
				}
			}
			
			$mydata['title'] =  $this->input->post('title');
			
			if (count($mydata) > 0) 
			{
				//print_r($mydata);die;
				if (!$this->Adminmodel->update($mydata, 'settings', $where)) {
					$msg = 'error';
				} else {
					if (!empty($oldLogo) && $oldLogo != '' && !is_null($oldLogo) && file_exists('./uploads/logos/'.$oldLogo)) {
						@unlink('./uploads/logos/'.$oldLogo);
					}
					if (!empty($oldFavicon) && $oldFavicon != '' && !is_null($oldFavicon) && file_exists('./uploads/logos/'.$oldFavicon)) {
						@unlink('./uploads/logos/'.$oldFavicon);
					}
					
					$msg = '["Settings saved successfully!", "success", "#A5DC86"]';
				}
				$this->session->set_flashdata('msg', $msg);
			} elseif (!empty($error)) {
				$msg = '["'.$error.'", "error", "#DD6B55"]';
			}
		}
		redirect(base_url('admin/settings/logo'),'refresh');
	}
	
	public function testInput($data)
	{
		$data = trim($data);
		$data = stripcslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	public function uw($data)
	{
		$data = $this->testInput($data);
		$data = ucwords(strtolower($data));
		return $data;
	}
	public function uc($data)
	{
		$data = $this->testInput($data);
		$data = strtoupper($data);
		return $data;
	}
	public function lc($data)
	{
		$data = $this->testInput($data);
		$data = strtolower($data);
		return $data;
	}
}