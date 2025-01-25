<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Product extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->Adminmodel->loggedIn();
    }

    public function index() {
        $data = array(
            'title' => 'Farmer App',
            'page' => 'Product List',
            'subpage' => 'product',
        );
        $data['product'] = $this->Adminmodel->get_all_record('*', 'product', '', array('id', 'DESC'), '');
        $this->load->view('admin/header', $data);
        $this->load->view('admin/sidebar');
        $this->load->view('admin/product/product_list');
        $this->load->view('admin/footer');
    }

    function add_product() {
        $data = array(
            'title' => 'Farmer App',
            'page' => 'Add product',
            'subpage' => 'product',
            'category_list' => $this->db->query("SELECT * FROM category WHERE status = '1'")->result()
        );

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!empty($_FILES['product_image']['name'])) {
                $_FILES['file']['name'] = preg_replace("/\s+/", "_", $_FILES['product_image']['name']);
                $_FILES['file']['type'] = $_FILES['product_image']['type'];
                $_FILES['file']['tmp_name'] = $_FILES['product_image']['tmp_name'];
                $_FILES['file']['error'] = $_FILES['product_image']['error'];
                $_FILES['file']['size'] = $_FILES['product_image']['size'];
                $uploadPath = 'uploads/product/';
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
            $prod_category = implode(",",$this->input->post('category_name',TRUE));

            if (!empty($_POST['content_title'])) {
                $count = count($_POST['content_title']);
                $all_data = array();

                for ($i = 0; $i < $count; $i++) {
                    $details_data = array(
                        'content_title' => $_POST['content_title'][$i],
                        'content_desc' => $_POST['content_desc'][$i],
                        'icon_file' => $_POST['icon_file'][$i],
                    );

                    $all_data[] = $details_data;
                }

                $serialized_data = serialize($all_data);
            }
            $data = array(
                'category_id' => $prod_category,
                'prod_name' => $this->input->post('product_name'),
                'prod_description' => $this->input->post('product_description'),
                'engrais' => $serialized_data,
                'bio_aggresseurs' => $this->input->post('bio_aggressors'),
                'maladies' => $this->input->post('maladies'),
                'start_period' => $this->input->post('period_list1'),
                'end_period' => $this->input->post('period_list2'),
                'harvest_days' => $this->input->post('harvest_days'),
                'harvest_end' => $this->input->post('harvest_end'),
                'number_harvest' => $this->input->post('number_harvest'),
                'product_image' => $image,
                'status' => $this->input->post('product_status'),
                'created_at' => date('Y-m-d H:i:s')
            );
            $result = $this->Adminmodel->add('product', $data);
            if ($result) {
                $msg = '["Product has been added successfully.", "success", "#A5DC86"]';
                $this->session->set_flashdata('msg', $msg);
                redirect(base_url('admin/product'), 'refresh');
            } else {
                $msg = 'Some error occurred.Please try again.';
                $this->session->set_flashdata('msg', $msg);
                redirect(base_url('admin/product'), 'refresh');
            }
        }
        $this->load->view('admin/header', $data);
        $this->load->view('admin/sidebar');
        $this->load->view('admin/product/add_product');
        $this->load->view('admin/footer');
    }

    function edit_product($prod_id) {
        $data = array(
            'title' => 'Farmer App',
            'page' => 'Edit Product',
            'subpage' => 'product',
            'category_list' => $this->db->query("SELECT * FROM category WHERE status = '1'")->result()
        );
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!empty($_FILES['product_image']['name'])) {
                $_FILES['file']['name'] = preg_replace("/\s+/", "_", $_FILES['product_image']['name']);
                $_FILES['file']['type'] = $_FILES['product_image']['type'];
                $_FILES['file']['tmp_name'] = $_FILES['product_image']['tmp_name'];
                $_FILES['file']['error'] = $_FILES['product_image']['error'];
                $_FILES['file']['size'] = $_FILES['product_image']['size'];
                $uploadPath = 'uploads/product/';
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
                $image  = @$_POST['old_image'];
            }
            $prod_category = implode(",",$this->input->post('category_name',TRUE));

            if (!empty($_POST['content_title'])) {
                $count = count($_POST['content_title']);
                $all_data = array();

                for ($i = 0; $i < $count; $i++) {
                    $details_data = array(
                        'content_title' => $_POST['content_title'][$i],
                        'content_desc' => $_POST['content_desc'][$i],
                        'icon_file' => $_POST['icon_file'][$i],
                    );

                    $all_data[] = $details_data;
                }

                $serialized_data = serialize($all_data);
            }
            $data = array(
                'category_id' => $prod_category,
                'prod_name' => $this->input->post('product_name'),
                'prod_description' => $this->input->post('product_description'),
                'engrais' => $serialized_data,
                'bio_aggresseurs' => $this->input->post('bio_aggressors'),
                'maladies' => $this->input->post('maladies'),
                'start_period' => $this->input->post('period_list1'),
                'end_period' => $this->input->post('period_list2'),
                'harvest_days' => $this->input->post('harvest_days'),
                'harvest_end' => $this->input->post('harvest_end'),
                'number_harvest' => $this->input->post('number_harvest'),
                'product_image' => $image,
                'status' => $this->input->post('product_status'),
                'created_at' => date('Y-m-d H:i:s')
            );
            //echo "<pre>"; print_r($data); die();
            $result = $this->Adminmodel->update($data, 'product', array('id' => $prod_id));
            if ($result) {
                $msg = '["Product has been updated successfully.", "success", "#A5DC86"]';
                $this->session->set_flashdata('msg', $msg);
                redirect(base_url('admin/product'), 'refresh');
            } else {
                $msg = 'Some error occurred.Please try again.';
                $this->session->set_flashdata('msg', $msg);
                redirect(base_url('admin/product'), 'refresh');
            }
        }
        $data['product'] = $this->Adminmodel->get_by('product', 'single', array('id' => $prod_id), '', 1);
        $this->load->view('admin/header', $data);
        $this->load->view('admin/sidebar');
        $this->load->view('admin/product/edit_product');
        $this->load->view('admin/footer');
    }

    public function change_product_status() {
        $prod_id = $this->input->post('prodId');
        $status = $this->input->post('status');
        if ($status == 1) {
            $msg = 'Product status is Activate';
        } else {
            $msg = 'Product status is Inctivate';
        }
        if ($this->Adminmodel->update(['status' => $status], 'product', ['id' => $prod_id])) {
            echo '["' . $msg . '", "success", "#A5DC86"]';
        } else {
            echo '["Some error occured, Please try again!", "error", "#DD6B55"]';
        }
    }

    function delete_product($id) {
        if (empty($id)) {
            return false;
        }
        $result = $this->db->query('DELETE from product where id = ' . $id . '');
        if ($result) {
            $msg = '["Product is deleted successfully.", "success", "#A5DC86"]';
            $this->session->set_flashdata('msg', $msg);
            redirect(base_url('admin/product'), 'refresh');
        } else {
            $msg = 'error';
            $this->session->set_flashdata('msg', $msg);
            redirect(base_url('admin/product'), 'refresh');
        }
    }
}
