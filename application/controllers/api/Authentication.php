<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Authentication extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Mymodel');
    }
    public function registration() {
        try {
            $validate = $this->db->query("SELECT * FROM users WHERE email = '" . $_POST['email'] . "'")->row();
            if (!empty($validate)) {
                $msg = 'Sorry this member already exist, try with another email.';
                $response = array('status' => 'error', 'result' => $msg);
            } else {
                if ($_FILES['profilePic']['name'] != '') {
                    $_POST['profilePic'] = rand(0000, 9999) . "_" . $_FILES['profilePic']['name'];
                    $config2['image_library'] = 'gd2';
                    $config2['source_image'] =  $_FILES['profilePic']['tmp_name'];
                    $config2['new_image'] =   getcwd() . '/uploads/users/' . $_POST['profilePic'];
                    $config2['upload_path'] =  getcwd() . '/uploads/users/';
                    $config2['allowed_types'] = 'JPG|PNG|JPEG|jpg|png|jpeg';
                    $config2['maintain_ratio'] = FALSE;
                    $this->image_lib->initialize($config2);
                    if (!$this->image_lib->resize()) {
                        echo ('<pre>');
                        echo ($this->image_lib->display_errors());
                        exit;
                    } else {
                        $image  = $_POST['profilePic'];
                        @unlink('uploads/users/' . $_POST['old_image']);
                    }
                } else {
                    $image  = $_POST['old_image'];
                }
                $data = array(
                    'username' => $_POST['username'],
                    'fname' => $_POST['first_name'],
                    'lname' => $_POST['last_name'],
                    'email' => $_POST['email'],
                    'phone' => $_POST['phone'],
                    'referent' => $_POST['referent'],
                    'password' => md5($_POST['password']),
                    'user_type' => $_POST['user_type'],
                    'image' => $image,
                    'created_at' => date('Y-m-d H:i:s'),
                    'status' => '1'
                );

                $result = $this->Mymodel->add('users', $data);
                $insert_id = $this->db->insert_id();
                if($_POST['first_name']) {
                    $fullname = $_POST['first_name']." ".$_POST['last_name'];
                } else {
                    $fullname = "";
                }
                /*$get_setting = $this->db->query('SELECT * FROM settings');
                if(!empty($insert_id)) {
                    $data=array(
                        'activationURL' => base_url() . "email-verification/" . urlencode(base64_encode($insert_id)),
                        'imagePath' => base_url().'uploads/logo/'.$get_setting->flogo,
                        'fullname' => $fullname,
                    );
                    $message = "<body><div style='width:600px;margin: 0 auto;background: #fff; border: 1px solid #e6e6e6;'><div style='padding: 30px 30px 15px 30px;box-sizing: border-box;'><img src='cid:Logo' style='width:100px;float: right;margin-top: 0 auto;'><h3 style='padding-top:40px; line-height: 30px;'>Greetings from<span style='font-weight: 900;font-size: 25px;color: #5c4f4f;display: block'>Pay Per Dialog</span></h3><p style='font-size: 17px; margin: 0;'>Hello $fullname,</p><p style='font-size: 17px; margin: 5px 0 0 0;'>Thank you for registration on Cirad.</p><p style='font-size: 17px; margin: 5px 0 0 0;'>Please click the button below to verify your email address.</p><p style='text-align: center;'><a href='".base_url() . "email-verification/" . urlencode(base64_encode($insert_id))."' style='height: 50px; width: 220px; background: rgb(253,179,2); background: linear-gradient(0deg, rgb(73 62 62) 0%, rgb(125 118 118) 100%); text-align: center; font-size: 18px; color: #fff; border-radius: 12px; display: inline-block; line-height: 50px; text-decoration: none; text-transform: uppercase; font-weight: 600;'>ACTIVATE</a></p><p style='font-size: 17px; margin: 5px 0 0 0;'>Thank you!</p><p style='font-size: 17px; margin: 5px 0 0 0; list-style: none;'>Sincerly</p><p style='list-style: none;margin: 5px 0 0 0;font-size: 15px;'><b>Cirad Team</b></p><p style='list-style: none;margin: 5px 0 0 0;font-size: 10px;'><b>Visit us:</b> <span>$get_setting->address</span></p><p style='list-style: none;margin: 5px 0 0 0;font-size: 10px;'><b>Email us:</b> <span>$get_setting->email</span></p></div><table style='width: 100%;'><tr><td style='height: 30px; width: 100%; background: #7e0e14; padding: 10px 0px; font-size: 13px; color: #fff; text-align: center'>Copyright &copy; <?=date('Y')?> Cirad. All rights reserved.</td></tr></table></div></body>";
                    require 'vendor/autoload.php';
                    $mail = new PHPMailer(true);
                    $mail->CharSet = 'UTF-8';
                    //$mail->SetFrom('info@payperdialog.com', 'Pay Per Dialog');
                    $mail->AddAddress($formdata['email']);
                    $mail->IsHTML(true);
                    $mail->Subject = 'Verify Your Email Address From Pay Per Dialog';
                    $mail->AddEmbeddedImage('uploads/logo/'.$get_setting->flogo, 'Logo');
                    $mail->Body = $message;
                    //Send email via SMTP
                    $mail->IsSMTP();
                    $mail->SMTPAuth   = true;
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    // $mail->Host       = "smtp.hostinger.com";
                    // $mail->Port       = 587; //587 465
                    // $mail->Username   = "info@payperdialog.com";
                    // $mail->Password   = "PayperLLC@2024";
                    $mail->send();
                    $msg = "We have sent an activation link to your account to continue with the registration process.";
                    $response = array('status'=> 'success','result'=> $msg);
                } else {
                    $msg = "Something went wrong. Please, try again later.";
                    $response = array('status'=> 'error','result'=> $msg);
                }*/
                $msg = "You have successfully registered with us. Please try to login.";
                $response = array('status' => 'success', 'result' => $msg);
            }
        } catch (\Exception $e) {
            $response = array('status' => 'error', 'result' => $e->getMessage());
        }
        echo json_encode($response);
    }

    public function login() {
        try {
            $formdata = json_decode(file_get_contents('php://input'), true);
            $email = $formdata["email"];
            $password = $formdata["password"];
            $check_user = $this->db->query("SELECT * FROM users WHERE email = '" . $email . "' AND password = '" . md5($password) . "' AND status = '1'")->result_array();
            if (!empty($check_user)) {
                $base_url = base_url('uploads/users/');
                foreach ($check_user as &$user) {
                    if (!empty($user['image'])) {
                        $user['image'] = $base_url . $user['image'];
                    }
                }
                $msg = 'Logged in successfully';
                $response = array('status' => 'success', 'result' => $check_user);
            } else {
                $msg = 'Invalid Email Address or Password';
                $response = array('status' => 'error', 'result' => $msg);
            }
        } catch (\Exception $e) {
            $response = array('status' => 'error', 'result' => $e->getMessage());
        }
        echo json_encode($response);
    }
    public function logout() {
        unset($_SESSION['afrebay']);
        $response = array('status' => 'success', 'result' => 'You have logged out.');
        echo json_encode($response);
    }
}
