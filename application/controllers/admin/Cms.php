<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Cms extends CI_Controller {
    public function __construct() {
        parent::__construct();
        // $this->loggedIn();
        // $this->load->model('Commonmodel');
        // $this->load->helper('admin_helper');
        $this->Adminmodel->loggedIn();
    }
    public function about_us() {
        $data = array(
            'title' => 'About Us',
            'page' => 'CMS',
            'subpage' => 'about_us'
        );
        $data['aboutUs'] = $this->db->query("select * from about_us where slug = 'about'")->row();
        $this->load->view('admin/header', $data);
        $this->load->view('admin/sidebar');
        //$this->load->view('admin/manage_about');
        $this->load->view('admin/about_us');
        $this->load->view('admin/footer');
    }
    /*public function edit_about_us($id) {
        if (empty(@$id)) {
            return false;
        }
        $data = array(
            'title' => 'Edit About Us',
            'page' => 'cms',
            'subpage' => 'about_us'
        );
        $data['aboutUs'] = $this->db->query("select * from about_us where id = " . @$id . "")->row();
        $this->load->view('admin/header', $data);
        $this->load->view('admin/sidebar');
        $this->load->view('admin/about_us');
        $this->load->view('admin/footer');
    }*/
    public function saveAboutus() {
        $id = $this->input->post('id');
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->form_validation->set_rules('heading', 'Heading', 'required|trim');
            $this->form_validation->set_rules('description', 'Description', 'required|trim');
            $this->form_validation->set_rules('status', 'Status', 'required|trim');
            if ($this->form_validation->run() == true) {
                if (!empty($_FILES['upload_image']['name'])) {
                    $config['upload_path'] = 'uploads/about_us'; # check path is correct
                    $config['allowed_types'] = 'jpg|png|jpeg|gif|mov|mp4|3gp|ogg|ogv|webm'; # add video extenstion on here
                    $config['overwrite'] = FALSE;
                    $config['remove_spaces'] = TRUE;
                    $image_name = preg_replace("/\s+/", "_", $_FILES['upload_image']['name']);
                    $config['file_name'] = $image_name;
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if (!$this->upload->do_upload('upload_image')) {
                        $array = array('error' => true, 'upload_image' => $this->upload->display_errors());
                        echo json_encode($array);
                        exit();
                    } else {
                        $url = $image_name;
                        $data = array(
                            'heading' => strip_tags($this->input->post('heading')),
                            'description' => $this->input->post('description'),
                            'image' => $image_name,
                            'status' => strip_tags($this->input->post('status')),
                            'bgcolorcode' => $this->input->post('color'),
                            'updated_at' => date('Y-m-d H:i:s')
                        );
                        $result = $this->Adminmodel->update($data, 'about_us', array('id' => $id));
                        if ($result) {
                            $response['status'] = 1;
                            $response['message'] = 'About us updated successfully.';
                        } else {
                            $response['status'] = 0;
                            $response['message'] = 'Some error ocure.Please try again.';
                        }
                    }
                } else {
                    $data = array(
                        'heading' => strip_tags($this->input->post('heading')),
                        'description' => $this->input->post('description'),
                        'status' => strip_tags($this->input->post('status')),
                        'bgcolorcode' => $this->input->post('color'),
                        'updated_at' => date('Y-m-d H:i:s')
                    );
                    $result = $this->Adminmodel->update($data, 'about_us', array('id' => $id));
                    if ($result) {
                        $response['status'] = 1;
                        $response['message'] = 'About us updated successfully.';
                    } else {
                        $response['status'] = 0;
                        $response['message'] = 'Some error ocure.Please try again.';
                    }
                }
            } else {
                $response = array(
                    'vali_error' => 1,
                    'heading_error' => form_error('heading'),
                    'description_error' => form_error('description'),
                    'status_error' => form_error('status')
                );
            }
        }
        echo json_encode($response);
    }
    public function changestatus() {
        if ($this->input->post('pckId')) {
            $pckId = $this->input->post('pckId');
            $status = $this->input->post('status');
            if ($status == 1) {
                $msg = 'About Us status is Activate';
            } else {
                $msg = 'About Us status is Inctivate';
            }
            if ($this->Adminmodel->update(['status' => $status], 'about_us', ['id' => $pckId])) {
                echo '["' . $msg . '", "success", "#A5DC86"]';
            } else {
                echo '["Some error occured, Please try again!", "error", "#DD6B55"]';
            }
        }
    }
    public function privacy() {
        $data = array(
            'title' => 'Privacy Policy',
            'page' => 'cms',
            'subpage' => 'privacy_policy'
        );
        $data['aboutUs'] = $this->db->query("select * from about_us where status = '1' and slug = 'privacy'")->row();
        $this->load->view('admin/header', $data);
        $this->load->view('admin/sidebar');
        $this->load->view('admin/privacy_policy');
        $this->load->view('admin/footer');
    }
    public function savePrivacy() {
        $id = $this->input->post('id');
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->form_validation->set_rules('heading', 'Heading', 'required|trim');
            $this->form_validation->set_rules('description', 'Description', 'required|trim');
            $this->form_validation->set_rules('status', 'Status', 'required|trim');
            if ($this->form_validation->run() == true) {
                if (!empty($_FILES['upload_image']['name'])) {


                } else {
                    $data = array(
                        'heading' => strip_tags($this->input->post('heading')),
                        'description' => $this->input->post('description'),
                        'status' => strip_tags($this->input->post('status')),
                        'updated_at' => date('Y-m-d H:i:s')
                    );
                    $result = $this->Adminmodel->update($data, 'about_us', array('slug' => 'privacy'));
                    if ($result) {
                        $response['status'] = 1;
                        $response['message'] = 'Privacy Policy us updated successfully.';
                    } else {
                        $response['status'] = 0;
                        $response['message'] = 'Some error ocure.Please try again.';
                    }
                }
            } else {
                $response = array(
                    'vali_error' => 1,
                    'heading_error' => form_error('heading'),
                    'description_error' => form_error('description'),
                    'status_error' => form_error('status')
                );
            }
        }
        echo json_encode($response);
    }
    public function terms() {
        $data = array(
            'title' => 'Terms & Condition',
            'page' => 'cms',
            'subpage' => 'terms'
        );
        $data['aboutUs'] = $this->db->query("select * from about_us where status = '1' and slug = 'term'")->row();
        $this->load->view('admin/header', $data);
        $this->load->view('admin/sidebar');
        $this->load->view('admin/terms');
        $this->load->view('admin/footer');
    }
    public function saveTerms() {
        $id = $this->input->post('id');
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->form_validation->set_rules('heading', 'Heading', 'required|trim');
            $this->form_validation->set_rules('description', 'Description', 'required|trim');
            $this->form_validation->set_rules('status', 'Status', 'required|trim');
            if ($this->form_validation->run() == true) {
                if (!empty($_FILES['upload_image']['name'])) {


                } else {
                    $data = array(
                        'heading' => strip_tags($this->input->post('heading')),
                        'description' => $this->input->post('description'),
                        'status' => strip_tags($this->input->post('status')),
                        'updated_at' => date('Y-m-d H:i:s')
                    );
                    $result = $this->Adminmodel->update($data, 'about_us', array('slug' => 'term'));
                    if ($result) {
                        $response['status'] = 1;
                        $response['message'] = 'Terms & Condition updated successfully.';
                    } else {
                        $response['status'] = 0;
                        $response['message'] = 'Some error ocure.Please try again.';
                    }
                }
            } else {
                $response = array(
                    'vali_error' => 1,
                    'heading_error' => form_error('heading'),
                    'description_error' => form_error('description'),
                    'status_error' => form_error('status')
                );
            }
        }
        echo json_encode($response);
    }
    public function home_block() {
        $data = array(
            'title' => 'Home Page Block',
            'page' => 'cms',
            'subpage' => 'home_block'
        );
        $data['aboutUs'] = $this->db->query("select * from home_block where status = '1'")->row();
        $this->load->view('admin/header', $data);
        $this->load->view('admin/sidebar');
        $this->load->view('admin/home_block');
        $this->load->view('admin/footer');
    }
    public function saveHomeblock() {
        $id = $this->input->post('id');
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->form_validation->set_rules('heading', 'Heading', 'required|trim');
            $this->form_validation->set_rules('description', 'Description', 'required|trim');
            $this->form_validation->set_rules('status', 'Status', 'required|trim');
            if ($this->form_validation->run() == true) {
                if (!empty($_FILES['upload_image']['name'])) {
                    $config['upload_path'] = 'uploads/about_us'; # check path is correct
                    $config['allowed_types'] = 'jpg|png|jpeg|gif|mov|mp4|3gp|ogg|ogv|webm'; # add video extenstion on here
                    $config['overwrite'] = FALSE;
                    $config['remove_spaces'] = TRUE;
                    $image_name = preg_replace("/\s+/", "_", $_FILES['upload_image']['name']);
                    $config['file_name'] = $image_name;
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if (!$this->upload->do_upload('upload_image')) {
                        $array = array('error' => true, 'upload_image' => $this->upload->display_errors());
                        echo json_encode($array);
                        exit();
                    } else {
                        $url = $image_name;
                        $data = array(
                            'heading' => strip_tags($this->input->post('heading')),
                            'description' => $this->input->post('description'),
                            'image_1' => $image_name,
                            'status' => strip_tags($this->input->post('status')),
                            'updated_at' => date('Y-m-d H:i:s')
                        );
                        $result = $this->Adminmodel->update($data, 'home_block', array('id' => $id));
                        if ($result) {
                            if (!empty($_FILES['upload_image_2']['name'])) {
                                $config['upload_path'] = 'uploads/about_us'; # check path is correct
                                $config['allowed_types'] = 'jpg|png|jpeg|gif|mov|mp4|3gp|ogg|ogv|webm'; # add video extenstion on here
                                $config['overwrite'] = FALSE;
                                $config['remove_spaces'] = TRUE;
                                $image_name_2 = preg_replace("/\s+/", "_", $_FILES['upload_image_2']['name']);
                                $config['file_name'] = $image_name_2;
                                $this->load->library('upload', $config);
                                $this->upload->initialize($config);
                                if (!$this->upload->do_upload('upload_image_2')) {
                                    $array = array('error' => true, 'upload_image_2' => $this->upload->display_errors());
                                    echo json_encode($array);
                                    exit();
                                } else {
                                    $data = array(
                                        'image_2' => $image_name_2,
                                        'updated_at' => date('Y-m-d H:i:s')
                                    );
                                    $result = $this->Adminmodel->update($data, 'home_block', array('id' => $id));
                                }
                            }
                            $response['status'] = 1;
                            $response['message'] = 'Information updated successfully.';
                        } else {
                            $response['status'] = 0;
                            $response['message'] = 'Some error ocure.Please try again.';
                        }
                    }
                } else {
                    $data = array(
                        'heading' => strip_tags($this->input->post('heading')),
                        'description' => $this->input->post('description'),
                        'status' => strip_tags($this->input->post('status')),
                        'updated_at' => date('Y-m-d H:i:s')
                    );
                    $result = $this->Adminmodel->update($data, 'home_block', array('id' => $id));
                    if ($result) {
                        if (!empty($_FILES['upload_image_2']['name'])) {
                            $config['upload_path'] = 'uploads/about_us'; # check path is correct
                            $config['allowed_types'] = 'jpg|png|jpeg|gif|mov|mp4|3gp|ogg|ogv|webm'; # add video extenstion on here
                            $config['overwrite'] = FALSE;
                            $config['remove_spaces'] = TRUE;
                            $image_name_2 = preg_replace("/\s+/", "_", $_FILES['upload_image_2']['name']);
                            $config['file_name'] = $image_name_2;
                            $this->load->library('upload', $config);
                            $this->upload->initialize($config);
                            if (!$this->upload->do_upload('upload_image_2')) {
                                $array = array('error' => true, 'upload_image_2' => $this->upload->display_errors());
                                echo json_encode($array);
                                exit();
                            } else {
                                $data = array(
                                    'image_2' => $image_name_2,
                                    'updated_at' => date('Y-m-d H:i:s')
                                );
                                $result = $this->Adminmodel->update($data, 'home_block', array('id' => $id));
                            }
                        }
                        $response['status'] = 1;
                        $response['message'] = 'Information updated successfully.';
                    } else {
                        $response['status'] = 0;
                        $response['message'] = 'Some error ocure.Please try again.';
                    }
                }
            } else {
                $response = array(
                    'vali_error' => 1,
                    'heading_error' => form_error('heading'),
                    'description_error' => form_error('description'),
                    'status_error' => form_error('status')
                );
            }
        }
        echo json_encode($response);
    }
    function banner() {
        $data = array(
            'title' => 'Banner Block',
            'page' => 'cms',
            'subpage' => 'banner'
        );
        $data['aboutUs'] = $this->db->query("select * from banner_block where status = '1'")->row();
        $this->load->view('admin/header', $data);
        $this->load->view('admin/sidebar');
        $this->load->view('admin/banner_block');
        $this->load->view('admin/footer');
    }
    public function saveBannerblock() {
        $id = $this->input->post('id');
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->form_validation->set_rules('heading', 'Heading', 'required|trim');
            $this->form_validation->set_rules('button_text', 'Button Text', 'required|trim');
            $this->form_validation->set_rules('status', 'Status', 'required|trim');
            if ($this->form_validation->run() == true) {
                if (!empty($_FILES['upload_image']['name'])) {
                    $config['upload_path'] = 'uploads/banner'; # check path is correct
                    $config['allowed_types'] = 'jpg|png|jpeg|gif|mov|mp4|3gp|ogg|ogv|webm'; # add video extenstion on here
                    $config['overwrite'] = FALSE;
                    $config['remove_spaces'] = TRUE;
                    $image_name = preg_replace("/\s+/", "_", $_FILES['upload_image']['name']);
                    $config['file_name'] = $image_name;
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if (!$this->upload->do_upload('upload_image')) {
                        $array = array('error' => true, 'upload_image' => $this->upload->display_errors());
                        echo json_encode($array);
                        exit();
                    } else {
                        $url = $image_name;
                        $data = array(
                            'heading' => strip_tags($this->input->post('heading')),
                            'button_text' => $this->input->post('button_text'),
                            'image_1' => $image_name,
                            'status' => strip_tags($this->input->post('status')),
                            'updated_at' => date('Y-m-d H:i:s')
                        );
                        $result = $this->Adminmodel->update($data, 'banner_block', array('id' => $id));
                        if ($result) {
                            if (!empty($_FILES['upload_image_2']['name'])) {
                                $config['upload_path'] = 'uploads/banner'; # check path is correct
                                $config['allowed_types'] = 'jpg|png|jpeg|gif|mov|mp4|3gp|ogg|ogv|webm'; # add video extenstion on here
                                $config['overwrite'] = FALSE;
                                $config['remove_spaces'] = TRUE;
                                $image_name_2 = preg_replace("/\s+/", "_", $_FILES['upload_image_2']['name']);
                                $config['file_name'] = $image_name_2;
                                $this->load->library('upload', $config);
                                $this->upload->initialize($config);
                                if (!$this->upload->do_upload('upload_image_2')) {
                                    $array = array('error' => true, 'upload_image_2' => $this->upload->display_errors());
                                    echo json_encode($array);
                                    exit();
                                } else {
                                    $data = array(
                                        'image_2' => $image_name_2,
                                        'updated_at' => date('Y-m-d H:i:s')
                                    );
                                    $result = $this->Adminmodel->update($data, 'banner_block', array('id' => $id));
                                }
                            }
                            $response['status'] = 1;
                            $response['message'] = 'Banner updated successfully.';
                        } else {
                            $response['status'] = 0;
                            $response['message'] = 'Some error ocure.Please try again.';
                        }
                    }
                } else {
                    $data = array(
                        'heading' => strip_tags($this->input->post('heading')),
                        'button_text' => $this->input->post('button_text'),
                        'status' => strip_tags($this->input->post('status')),
                        'updated_at' => date('Y-m-d H:i:s')
                    );
                    $result = $this->Adminmodel->update($data, 'banner_block', array('id' => $id));
                    if ($result) {
                        if (!empty($_FILES['upload_image_2']['name'])) {
                            $config['upload_path'] = 'uploads/banner'; # check path is correct
                            $config['allowed_types'] = 'jpg|png|jpeg|gif|mov|mp4|3gp|ogg|ogv|webm'; # add video extenstion on here
                            $config['overwrite'] = FALSE;
                            $config['remove_spaces'] = TRUE;
                            $image_name_2 = preg_replace("/\s+/", "_", $_FILES['upload_image_2']['name']);
                            $config['file_name'] = $image_name_2;
                            $this->load->library('upload', $config);
                            $this->upload->initialize($config);
                            if (!$this->upload->do_upload('upload_image_2')) {
                                $array = array('error' => true, 'upload_image_2' => $this->upload->display_errors());
                                echo json_encode($array);
                                exit();
                            } else {
                                $data = array(
                                    'image_2' => $image_name_2,
                                    'updated_at' => date('Y-m-d H:i:s')
                                );
                                $result = $this->Adminmodel->update($data, 'banner_block', array('id' => $id));
                            }
                        }
                        $response['status'] = 1;
                        $response['message'] = 'Banner updated successfully.';
                    } else {
                        $response['status'] = 0;
                        $response['message'] = 'Some error ocure.Please try again.';
                    }
                }
            } else {
                $response = array(
                    'vali_error' => 1,
                    'heading_error' => form_error('heading'),
                    'button_text_error' => form_error('button_text'),
                    'status_error' => form_error('status')
                );
            }
        }
        echo json_encode($response);
    }
    public function help() {
        $data = array(
            'title' => 'Help & Support',
            'page' => 'cms',
            'subpage' => 'help'
        );
        $data['help'] = $this->db->query("select * from about_us where status = '1' and slug = 'help'")->row();
        $this->load->view('admin/header', $data);
        $this->load->view('admin/sidebar');
        $this->load->view('admin/help');
        $this->load->view('admin/footer');
    }
    function saveHelp() {
        $id = $this->input->post('id');
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->form_validation->set_rules('heading', 'Heading', 'required|trim');
            $this->form_validation->set_rules('description', 'Description', 'required|trim');
            $this->form_validation->set_rules('status', 'Status', 'required|trim');
            if ($this->form_validation->run() == true) {
                if (!empty($_FILES['upload_image']['name'])) {


                } else {
                    $data = array(
                        'heading' => strip_tags($this->input->post('heading')),
                        'description' => $this->input->post('description'),
                        'status' => strip_tags($this->input->post('status')),
                        'updated_at' => date('Y-m-d H:i:s')
                    );
                    $result = $this->Adminmodel->update($data, 'about_us', array('slug' => 'help'));
                    if ($result) {
                        $response['status'] = 1;
                        $response['message'] = 'Help & Support us updated successfully.';
                    } else {
                        $response['status'] = 0;
                        $response['message'] = 'Some error ocure.Please try again.';
                    }
                }
            } else {
                $response = array(
                    'vali_error' => 1,
                    'heading_error' => form_error('heading'),
                    'description_error' => form_error('description'),
                    'status_error' => form_error('status')
                );
            }
        }
        echo json_encode($response);
    }
    public function event_step_process() {
        $data = array(
            'title' => 'Event Planning Process',
            'page' => 'cms',
            'subpage' => 'event_process'
        );
        $data['step_process'] = $this->db->query("select * from event_step_process order by id desc")->result();
        $this->load->view('admin/header', $data);
        $this->load->view('admin/sidebar');
        $this->load->view('admin/event_process');
        $this->load->view('admin/footer');
    }
    function add_event_process() {
        $data = array(
            'title' => 'Add Event Planning Process',
            'page' => 'cms',
            'subpage' => 'event_process'
        );
        $this->load->view('admin/header', $data);
        $this->load->view('admin/sidebar');
        $this->load->view('admin/add_event_process');
        $this->load->view('admin/footer');
    }
    function add_stepProcess() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->form_validation->set_rules('description', 'Description', 'required|trim');
            $this->form_validation->set_rules('status', 'Status', 'required|trim');
            if ($this->form_validation->run() == true) {
                if (!empty($_FILES['upload_image']['name'])) {
                    $config['upload_path'] = 'uploads/event_process'; # check path is correct
                    $config['allowed_types'] = 'jpg|png|jpeg|gif|mov|mp4|3gp|ogg|ogv|webm'; # add video extenstion on here
                    $config['overwrite'] = FALSE;
                    $config['remove_spaces'] = TRUE;
                    $image_name = preg_replace("/\s+/", "_", $_FILES['upload_image']['name']);
                    $config['file_name'] = $image_name;
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if (!$this->upload->do_upload('upload_image')) {
                        $array = array('error' => true, 'upload_image' => $this->upload->display_errors());
                        echo json_encode($array);
                        exit();
                    } else {
                        $url = $image_name;
                        $data = array(
                            'description' => $this->input->post('description'),
                            'image' => $image_name,
                            'status' => strip_tags($this->input->post('status')),
                            'updated_at' => date('Y-m-d H:i:s')
                        );
                        $result = $this->Adminmodel->add('event_step_process', $data);
                        if ($result) {
                            $response['status'] = 1;
                            $response['message'] = 'Event planning process added successfully.';
                        } else {
                            $response['status'] = 0;
                            $response['message'] = 'Some error ocure.Please try again.';
                        }
                    }
                } else {
                    $data = array(
                        'description' => $this->input->post('description'),
                        'status' => strip_tags($this->input->post('status')),
                        'updated_at' => date('Y-m-d H:i:s')
                    );
                    $result = $this->Adminmodel->add('event_step_process', $data);
                    if ($result) {
                        $response['status'] = 1;
                        $response['message'] = 'Event planning process added successfully.';
                    } else {
                        $response['status'] = 0;
                        $response['message'] = 'Some error ocure.Please try again.';
                    }
                }
            } else {
                $response = array(
                    'vali_error' => 1,
                    'description_error' => form_error('description'),
                    'status_error' => form_error('status')
                );
            }
        }
        echo json_encode($response);
    }
    function edit_event_process($id) {
        if (empty($id)) {
            return false;
        }
        $data = array(
            'title' => 'Edit Event Planning Process',
            'page' => 'cms',
            'subpage' => 'event_process'
        );
        $data['event_process'] = $this->db->query("select * from event_step_process where id = " . @$id . "")->row();
        $this->load->view('admin/header', $data);
        $this->load->view('admin/sidebar');
        $this->load->view('admin/edit_event_process');
        $this->load->view('admin/footer');
    }
    function edit_stepProcess() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->form_validation->set_rules('description', 'Description', 'required|trim');
            $this->form_validation->set_rules('status', 'Status', 'required|trim');
            if ($this->form_validation->run() == true) {
                if (!empty($_FILES['upload_image']['name'])) {
                    $config['upload_path'] = 'uploads/event_process'; # check path is correct
                    $config['allowed_types'] = 'jpg|png|jpeg|gif|mov|mp4|3gp|ogg|ogv|webm'; # add video extenstion on here
                    $config['overwrite'] = FALSE;
                    $config['remove_spaces'] = TRUE;
                    $image_name = preg_replace("/\s+/", "_", $_FILES['upload_image']['name']);
                    $config['file_name'] = $image_name;
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if (!$this->upload->do_upload('upload_image')) {
                        $array = array('error' => true, 'upload_image' => $this->upload->display_errors());
                        echo json_encode($array);
                        exit();
                    } else {
                        $url = $image_name;
                        $data = array(
                            'description' => $this->input->post('description'),
                            'image' => $image_name,
                            'status' => strip_tags($this->input->post('status')),
                            'updated_at' => date('Y-m-d H:i:s')
                        );
                        //$result= $this->Adminmodel->add('event_step_process', $data);
                        $result = $this->Adminmodel->update($data, 'event_step_process', array('id' => $this->input->post('id')));
                        if ($result) {
                            $response['status'] = 1;
                            $response['message'] = 'Event planning process updated successfully.';
                        } else {
                            $response['status'] = 0;
                            $response['message'] = 'Some error ocure.Please try again.';
                        }
                    }
                } else {
                    $data = array(
                        'description' => $this->input->post('description'),
                        'status' => strip_tags($this->input->post('status')),
                        'updated_at' => date('Y-m-d H:i:s')
                    );
                    $result = $this->Adminmodel->update($data, 'event_step_process', array('id' => $this->input->post('id')));
                    if ($result) {
                        $response['status'] = 1;
                        $response['message'] = 'Event planning process updated successfully.';
                    } else {
                        $response['status'] = 0;
                        $response['message'] = 'Some error ocure.Please try again.';
                    }
                }
            } else {
                $response = array(
                    'vali_error' => 1,
                    'description_error' => form_error('description'),
                    'status_error' => form_error('status')
                );
            }
        }
        echo json_encode($response);
    }
    public function step_process_changestatus() {
        if ($this->input->post('faqId')) {
            $pckId = $this->input->post('faqId');
            $status = $this->input->post('status');
            if ($status == 1) {
                $msg = 'About Us status is Activate';
            } else {
                $msg = 'About Us status is Inctivate';
            }
            if ($this->Adminmodel->update(['status' => $status], 'event_step_process', ['id' => $pckId])) {
                echo '["' . $msg . '", "success", "#A5DC86"]';
            } else {
                echo '["Some error occured, Please try again!", "error", "#DD6B55"]';
            }
        }
    }
    function delete_event_process($id) {
        if (empty($id)) {
            return false;
        }
        $result = $this->db->query('delete from event_step_process where id = ' . $id . '');
        if ($result) {
            $msg = '["Event planning process deleted successfully.", "success", "#A5DC86"]';
            $this->session->set_flashdata('msg', $msg);
            redirect(base_url('admin/cms/event_step_process'), 'refresh');
        } else {
            $msg = 'error';
            $this->session->set_flashdata('msg', $msg);
            redirect(base_url('admin/cms/event_step_process'), 'refresh');
        }
    }
}