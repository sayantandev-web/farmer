<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Category extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->Adminmodel->loggedIn();
    }

    public function index() {
        $data = array(
            'title' => 'Farmer App',
            'page' => 'Category List',
            'subpage' => 'category',
        );
        $data['category'] = $this->Adminmodel->get_all_record('*', 'category', '', array('id', 'DESC'), '');
        $this->load->view('admin/header', $data);
        $this->load->view('admin/sidebar');
        $this->load->view('admin/category/category_list');
        $this->load->view('admin/footer');
    }

    function add_category() {
        $data = array(
            'title' => 'Farmer App',
            'page' => 'Add Category',
            'subpage' => 'category',
        );

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!empty($_FILES['category_image']['name'])) {
                $_FILES['file']['name'] = preg_replace("/\s+/", "_", $_FILES['category_image']['name']);
                $_FILES['file']['type'] = $_FILES['category_image']['type'];
                $_FILES['file']['tmp_name'] = $_FILES['category_image']['tmp_name'];
                $_FILES['file']['error'] = $_FILES['category_image']['error'];
                $_FILES['file']['size'] = $_FILES['category_image']['size'];
                $uploadPath = 'uploads/category/';
                $config['upload_path'] = $uploadPath;
                $config['allowed_types'] = 'jpg|jpeg|png|gif|mp4|ogg|ogv|3gp|mov|webm';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload('file')) {
                    $fileData = $this->upload->data();
                    $image = $fileData['file_name'];
                } else {
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                }
            } else {
                $image  = "";
            }
            $data = array(
                'category_name' => strip_tags($this->input->post('category_name')),
                'category_description' => strip_tags($this->input->post('category_description')),
                'category_image' => $image,
                'status' => strip_tags($this->input->post('category_status')),
                'created_at' => date('Y-m-d H:i:s')
            );
            $result = $this->Adminmodel->add('category', $data);
            if ($result) {
                $msg = '["Category has been added successfully.", "success", "#A5DC86"]';
                $this->session->set_flashdata('msg', $msg);
                redirect(base_url('admin/category'), 'refresh');
            } else {
                $msg = 'Some error occurred.Please try again.';
                $this->session->set_flashdata('msg', $msg);
                redirect(base_url('admin/category'), 'refresh');
            }
        }
        $this->load->view('admin/header', $data);
        $this->load->view('admin/sidebar');
        $this->load->view('admin/category/add_category');
        $this->load->view('admin/footer');
    }

    function edit_category($cat_id) {
        $data = array(
            'title' => 'Farmer App',
            'page' => 'Edit Category',
            'subpage' => 'category',
        );
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!empty($_FILES['category_image']['name'])) {
                $_FILES['file']['name'] = preg_replace("/\s+/", "_", $_FILES['category_image']['name']);
                $_FILES['file']['type'] = $_FILES['category_image']['type'];
                $_FILES['file']['tmp_name'] = $_FILES['category_image']['tmp_name'];
                $_FILES['file']['error'] = $_FILES['category_image']['error'];
                $_FILES['file']['size'] = $_FILES['category_image']['size'];
                $uploadPath = 'uploads/category/';
                $config['upload_path'] = $uploadPath;
                $config['allowed_types'] = 'jpg|jpeg|png|gif|mp4|ogg|ogv|3gp|mov|webm';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload('file')) {
                    $fileData = $this->upload->data();
                    $image = $fileData['file_name'];
                } else {
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                }
            } else {
                $image  = $_POST['old_image'];
            }
            $data = array(
                'category_name' => strip_tags($this->input->post('category_name')),
                'category_description' => strip_tags($this->input->post('category_description')),
                'category_image' => $image,
                'status' => strip_tags($this->input->post('category_status')),
            );
            $result = $this->Adminmodel->update($data, 'category', array('id' => $cat_id));
            if ($result) {
                $msg = '["Category has been updated successfully.", "success", "#A5DC86"]';
                $this->session->set_flashdata('msg', $msg);
                redirect(base_url('admin/category'), 'refresh');
            } else {
                $msg = 'Some error occurred.Please try again.';
                $this->session->set_flashdata('msg', $msg);
                redirect(base_url('admin/category'), 'refresh');
            }
        }
        $data['category'] = $this->Adminmodel->get_by('category', 'single', array('id' => $cat_id), '', 1);
        $this->load->view('admin/header', $data);
        $this->load->view('admin/sidebar');
        $this->load->view('admin/category/edit_category');
        $this->load->view('admin/footer');
    }

    public function change_category_status() {
        $cat_id = $this->input->post('catId');
        $status = $this->input->post('status');
        if ($status == 1) {
            $msg = 'Category status is Activate';
        } else {
            $msg = 'Category status is Inctivate';
        }
        if ($this->Adminmodel->update(['status' => $status], 'category', ['id' => $cat_id])) {
            echo '["' . $msg . '", "success", "#A5DC86"]';
        } else {
            echo '["Some error occured, Please try again!", "error", "#DD6B55"]';
        }
    }

    function delete_category($id) {
        if (empty($id)) {
            return false;
        }
        $result = $this->db->query('DELETE from category where id = ' . $id . '');
        if ($result) {
            $msg = '["Category is deleted successfully.", "success", "#A5DC86"]';
            $this->session->set_flashdata('msg', $msg);
            redirect(base_url('admin/category'), 'refresh');
        } else {
            $msg = 'error';
            $this->session->set_flashdata('msg', $msg);
            redirect(base_url('admin/category'), 'refresh');
        }
    }
}
