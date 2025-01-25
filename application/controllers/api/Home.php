<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Home extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Mymodel');
    }

    /*public function category_list() {
        try {
            $category_list = $this->db->query("SELECT * FROM category WHERE status = '1'")->result();
            if(!empty($category_list)) {
                $categoryList = array();
                foreach ($category_list as $key => $value) {
                    $categoryList[$key]['id'] = $value->id;
                    $categoryList[$key]['category_name'] = $value->category_name;
                    $categoryList[$key]['category_description'] = $value->category_description;
                    if(!empty($value->category_image)){
                        $categoryList[$key]['category_image'] = base_url().'uploads/category/'.$value->category_image;
                    } else {
                        $categoryList[$key]['category_image'] = base_url().'uploads/no_image.png';
                    }
                }
                $response = array('status'=> 'success', 'result'=> $categoryList);
            } else {
                $response = array('status'=> 'error', 'result'=> 'No data found');
            }
        } catch (\Exception $e) {
            $response = array('status' => 'error', 'result' => $e->getMessage());
        }
        echo json_encode($response);
    }
    public function category_wise_product() {
        try {
            $formdata = json_decode(file_get_contents('php://input'), true);
            $cat_id = $formdata['cat_id'];

            $month_data = $this->db->query("SELECT * FROM month_data")->result();
            $month_map = [];
            foreach ($month_data as $month) {
                $month_map[$month->id] = $month->month_name;
            }

            if($formdata['cat_id'] == '0') {
                $product_list = $this->db->query("SELECT * FROM product WHERE status = '1'")->result();
                if(!empty($product_list)) {
                    $prodList = array();
                    foreach ($product_list as $key => $value) {

                        $period_ids = explode(',', $value->period);
                        $month_names = array_map(function($id) use ($month_map) {
                            return isset($month_map[trim($id)]) ? $month_map[trim($id)] : null;
                        }, $period_ids);
                        $month_names = array_filter($month_names);
                        $month_names_display = implode(', ', $month_names);

                        $prodList[$key]['id'] = $value->id;
                        $prodList[$key]['prod_name'] = $value->prod_name;
                        $prodList[$key]['prod_description'] = $value->prod_description;
                        $prodList[$key]['period'] = $month_names_display;
                        $prodList[$key]['engrais'] = $value->engrais;
                        $prodList[$key]['bio_aggresseurs'] = $value->bio_aggresseurs;
                        $prodList[$key]['maladies'] = $value->maladies;
                        if(!empty($value->product_image)){
                            $prodList[$key]['product_image'] = base_url().'uploads/product/'.$value->product_image;
                        } else {
                            $prodList[$key]['product_image'] = base_url().'uploads/no_image.png';
                        }
                    }
                    $response = array('status'=> 'success', 'result'=> $prodList);
                } else {
                    $response = array('status'=> 'error', 'result'=> 'No data found');
                }
            } else {
                $product_list = $this->db->query("SELECT * FROM product WHERE instr(concat(',', category_id, ','), ',$cat_id,') AND status = '1'")->result();
                if(!empty($product_list)) {
                    $prodList = array();
                    foreach ($product_list as $key => $value) {

                        $period_ids = explode(',', $value->period);
                        $month_names = array_map(function($id) use ($month_map) {
                            return isset($month_map[trim($id)]) ? $month_map[trim($id)] : null;
                        }, $period_ids);
                        $month_names = array_filter($month_names);
                        $month_names_display = implode(', ', $month_names);
                        
                        $prodList[$key]['id'] = $value->id;
                        $prodList[$key]['prod_name'] = $value->prod_name;
                        $prodList[$key]['prod_description'] = $value->prod_description;
                        $prodList[$key]['period'] = $month_names_display;
                        $prodList[$key]['engrais'] = $value->engrais;
                        $prodList[$key]['bio_aggresseurs'] = $value->bio_aggresseurs;
                        $prodList[$key]['maladies'] = $value->maladies;
                        if(!empty($value->product_image)){
                            $prodList[$key]['product_image'] = base_url().'uploads/product/'.$value->product_image;
                        } else {
                            $prodList[$key]['product_image'] = base_url().'uploads/no_image.png';
                        }
                    }
                    $response = array('status'=> 'success', 'result'=> $prodList);
                } else {
                    $response = array('status'=> 'error', 'result'=> 'No data found');
                }
            }
        } catch (\Exception $e) {
            $response = array('status' => 'error', 'result' => $e->getMessage());
        }
        echo json_encode($response);
    }*/
    public function vagetable_list() {
        try {
            $vagetable_list = $this->db->query("SELECT * FROM product WHERE status = '1' AND is_delete = '1'")->result();
            if(!empty($vagetable_list)) {
                $vagetableList = array();
                foreach ($vagetable_list as $key => $value) {
                    $vagetableList[$key]['id'] = $value->id;
                    $vagetableList[$key]['prod_name'] = $value->prod_name;
                    $vagetableList[$key]['prod_description'] = $value->prod_description;
                    if(!empty($value->product_image)){
                        $vagetableList[$key]['product_image'] = base_url().'uploads/product/'.$value->product_image;
                    } else {
                        $vagetableList[$key]['product_image'] = base_url().'uploads/no_image.png';
                    }
                }
                $response = array('status'=> 'success', 'result'=> $vagetableList);
            } else {
                $response = array('status'=> 'error', 'result'=> 'No data found');
            }

        } catch (\Exception $e) {
            $response = array('status' => 'error', 'result' => $e->getMessage());
        }
        echo json_encode($response);
    }

    public function filter_vagetables() {
        try {
            $formdata = json_decode(file_get_contents('php://input'), true);
            $veg_id = $formdata['veg_id']; //$veg_id = 1

            $get_bioagressor_data = $this->db->query("SELECT * FROM product WHERE id = '".$veg_id."'")->row();
            $bioagressor = $get_bioagressor_data->category_id;
            $bioagressor = explode(',', $bioagressor);
            $nonCommonVeg = array();
            for($i = 0; $i < count($bioagressor); $i++) {
                $checkVeg = $this->db->query("SELECT * FROM product WHERE instr(concat(',',category_id,','), ',$bioagressor[$i],') AND `status` = 1 AND `is_delete` = 1")->result();
            }

        } catch (\Exception $e) {
            $response = array('status' => 'error', 'result' => $e->getMessage());
        }
        //echo json_encode($response);
    }
}
