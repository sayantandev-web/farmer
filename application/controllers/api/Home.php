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
            $veg_id = $formdata['veg_id'];

            $get_bioagressor_data = $this->db->query("SELECT * FROM product WHERE id = '".$veg_id."'")->row();
            $bioagressor = $get_bioagressor_data->category_id;
            $bioagressor = explode(',', $bioagressor);
            
            $query = "SELECT * FROM product WHERE ";
            for($i = 0; $i < count($bioagressor); $i++) {
                $query .= "NOT FIND_IN_SET('".$bioagressor[$i]."', category_id) AND ";
            }
            $query = rtrim($query, ' AND ');
            $nonCommonVeg = $this->db->query($query)->result();
            $vagetableList = array();
                foreach ($nonCommonVeg as $key => $value) {
                    $vagetableList[$key]['id'] = $value->id;
                    $vagetableList[$key]['category_id'] = $value->category_id;
                    $vagetableList[$key]['prod_name'] = $value->prod_name;
                    $vagetableList[$key]['prod_description'] = $value->prod_description;
                    $vagetableList[$key]['engrais'] = $value->engrais;
                    $vagetableList[$key]['bio_aggresseurs'] = $value->bio_aggresseurs;
                    $vagetableList[$key]['maladies'] = $value->maladies;
                    $vagetableList[$key]['start_period'] = $value->start_period;
                    $vagetableList[$key]['end_period'] = $value->end_period;
                    $vagetableList[$key]['harvest_days'] = $value->harvest_days;
                    $vagetableList[$key]['harvest_end'] = $value->harvest_end;
                    $vagetableList[$key]['number_harvest'] = $value->number_harvest;
                    if(!empty($value->product_image)){
                        $vagetableList[$key]['product_image'] = base_url().'uploads/product/'.$value->product_image;
                    } else {
                        $vagetableList[$key]['product_image'] = base_url().'uploads/no_image.png';
                    }
                    $vagetableList[$key]['created_at'] = $value->created_at;
                    $vagetableList[$key]['update_date'] = $value->update_date;
                    $vagetableList[$key]['status'] = $value->status;
                    $vagetableList[$key]['is_delete'] = $value->is_delete;
                }

            $response = array('status' => 'success', 'result' => $vagetableList);
        } catch (\Exception $e) {
            $response = array('status' => 'error', 'result' => $e->getMessage());
        }
        echo json_encode($response);
    }

    public function vagetable_details(){
        try {
            $formdata = json_decode(file_get_contents('php://input'), true);
            $veg_id = $formdata['veg_id'];
            $getVegDetails = $this->db->query("SELECT * FROM product WHERE id = '".$veg_id."'")->row();
            
            $vagetableDetails = array(
                'id' => $getVegDetails->id,
                'category_id' => $getVegDetails->category_id,
                'prod_name' => $getVegDetails->prod_name,
                'prod_description' => $getVegDetails->prod_description,
                'engrais' => $getVegDetails->engrais,
                'bio_aggresseurs' => $getVegDetails->bio_aggresseurs,
                'maladies' => $getVegDetails->maladies,
                'start_period' => $getVegDetails->start_period,
                'end_period' => $getVegDetails->end_period,
                'harvest_days' => $getVegDetails->harvest_days,
                'harvest_end' => $getVegDetails->harvest_end,
                'number_harvest' => $getVegDetails->number_harvest,
                'product_image' => !empty($getVegDetails->product_image) ? base_url().'uploads/product/'.$getVegDetails->product_image : base_url().'uploads/no_image.png',
                'created_at' => $getVegDetails->created_at,
                'update_date' => $getVegDetails->update_date,
                'status' => $getVegDetails->status,
                'is_delete' => $getVegDetails->is_delete
            );
            $response = array('status' => 'success', 'result' => $vagetableDetails);
        } catch (\Exception $e) {
            $response = array('status' => 'error', 'result' => $e->getMessage());
        }
        echo json_encode($response);
    }
}
