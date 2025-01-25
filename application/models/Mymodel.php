<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

use Twilio\Rest\Client;
class Mymodel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        error_reporting(0);
    }
    public function count($table, $where = NULL)
    {
        if ($where != NULL) {
            $this->db->where($where);
        }
        $this->db->from($table);
        return $this->db->count_all_results();
    }
    public function get_by($table, $single = False, $where = NULL, $order_by = NULL, $limit = NULL)
    {
        if (!$where == NULL) {
            $this->db->where($where);
        }
        $this->db->from($table);
        if ($single == FALSE) {
            $method = 'result';
        } else {
            $method = 'row';
        }
        if (!$limit == NULL) {
            $this->db->limit($limit);
        }
        if (!$order_by == NULL) {
            $this->db->order_by($order_by);
        }
        $query = $this->db->get();
        $result = $query->$method();
        return $result;
    }
    public function get($table, $single = False, $col = NULL, $id = NULL, $limit = NULL, $order_by = NULL)
    {
        if (!$col == NULL && !$id == NULL) {
            $this->db->where($col, $id);
        }
        $this->db->from($table);

        if ($single == FALSE) {
            $method = 'result';
        } else {
            $method = 'row';
        }
        if (!$limit == NULL) {
            $this->db->limit($limit);
        }
        if (!$order_by == NULL) {
            $this->db->order_by($order_by, 'DESC');
        }
        $query = $this->db->get();
        $result = $query->$method();
        return $result;
    }
    public function getSettings()
    {
        return $this->get('settings', true, 'settingId', '1');
    }
    public function getAdminProfileData()
    {
        $userId = $this->session->userdata('userId');
        return $this->get('admin', true, 'userId', $userId);
    }
    public function update($data, $table, $where)
    {
        $this->db->where($where);

        if ($this->db->update($table, $data)) {
            return true;
        } else {
            return false;
        }
    }
    function get_all_record($column = '', $table = '', $where = '', $orderby = '', $limit = '')
    {
        $this->db->select($column);
        $this->db->from($table);
        if ($where != '') {
            $this->db->where($where);
        }
        if ($limit != '') {
            $this->db->limit($limit);
        }
        if ($orderby != '') {
            $this->db->order_by($orderby[0], $orderby[1]);
        }
        $query = $this->db->get();
        $result = ($query->num_rows() > 0) ? $query->result() : FALSE;
        return $result;
    }
    function add($table = '', $data = '') {
        if (empty($data)) {
            return false;
        }
        if (empty($table)) {
            return false;
        }
        $result = $this->db->insert($table, $data);
        return $result ? $this->db->insert_id() : FALSE;
    }
    function UniqueEmail($params = array()) {
        if (array_key_exists("returnType", $params) && $params['returnType'] == 'count') {
            $this->db->select('email');
            $this->db->from('users');
            $this->db->where('email', $params['conditions']['email']);
            $query = $this->db->get();
            return $query;
        }
    }
    function UniqueEmail_subscribe($params = array()) {
        if (array_key_exists("returnType", $params) && $params['returnType'] == 'count') {
            $this->db->select('email');
            $this->db->from('subscribe');
            $this->db->where('email', $params['conditions']['email']);
            $query = $this->db->get();
            return $query;
        }
    }
    public function login($username, $password) {
        $where = "email = '" . $username . "'";
        if ($this->count('users', $where) != 1) {
            $msg = "Invalid Username.";
        } else {
            $user = $this->get_by('users', true, $where);
            if ($password != @$user->password) {
                $msg = "Invalid Password";
            } elseif (@$user->status == 0) {
                $msg = "Your account has been deactivated. Please contact master admin for details.";
            } elseif (@$user->email_verify_status == 0) {
                $msg = "Please verify your email address.";
            } else {
                $msg = "Login";
                $this->session->set_userdata('is_login', true);
                $this->session->set_userdata('loguserId', @$user->id);
                $this->session->set_userdata('logusertype', @$user->user_type);
                // $cookie = array(
                // 'name' => 'newuserId',
                // 'value' => @$user->userId,
                // 'expire' => '86500',
                // 'path' => '/',
                // 'secure' => TRUE
                // );

                // $this->input->set_cookie($cookie);

            }
        }
        return $msg;
    }
    public function loggedIn()
    {
        if (!$this->session->userdata('loguserId') || !$this->session->userdata('is_login')) {
            //$redirectto = urlencode(current_url());
            redirect(base_url('login'), 'refresh');
        }
    }

    function getOldPassword($ID)
    {
        if (empty($ID)) {
            return false;
        }
        $this->db->select('password');
        $this->db->from('users');
        $this->db->where('id', $ID);
        $query = $this->db->get();
        $result = ($query->num_rows() > 0) ? $query->result() : FALSE;
        return $result;
    }

    function add_multiple_listing_gallery($data = '', $table = '', $id = '')
    {
        //print_r($data);die;
        $count = 0;
        foreach ($data as $image) {

            $galleryData = array(
                'image' => $image['image'],
                'event_id' => $id,
                'user_id' => $image['userId'],
                'created_at' => date('Y-m-d H:i:s')
            );

            $this->db->insert($table, $galleryData);
            $result[] = $this->db->insert_id();
        }
        return $result;
    }

    function Forget_Password($params = array()) {
        if (empty($params)) {
            return false;
        }
        if (array_key_exists("returnType", $params) && $params['returnType'] == 'forgetpassword') {
            $data = array('email' => $params['conditions']['email'], 'status' => $params['conditions']['status']);
            $this->db->select('*');
            $this->db->from('users');
            $this->db->where($data);
            $query = $this->db->get();
            $result = ($query->num_rows() == 1) ? $query->row() : FALSE;
            return $result;
        }
    }
    function Reset_Password($params = array()) {
        if (empty($params)) {
            return false;
        }
        if (array_key_exists("returnType", $params) && $params['returnType'] == 'Reset') {
            $where = array('id' => $params['conditions']['id']);
            $data = array('password' => $params['conditions']['password']);
            $this->db->where($where);
            $result = $this->db->update('users', $data);
            return $result ? $result : FALSE;

        }
    }
    function addInvitedPeople($email = '', $eventId = '', $amount = '', $subscription = '')
    {
        //$userId = $this->session->userdata('loguserId');
        $event_user_id = $this->Mymodel->get_single_row_info('user_id', 'event', 'event_id=' . @$eventId . '', '', 1);
        $userId = $event_user_id->user_id;

        $get_sub_id = $this->Mymodel->get_single_row_info('id', 'transaction', 'user_id=' . $userId . ' and payment_type = "1"', 'id DESC', 1);
        foreach ($email as $v) {
            $data = array('email' => $v, 'event_id' => $eventId, 'distributed_event_price' => $amount, 'user_id' => $userId, 'status' => '1', 'invited_people' => $subscription, 'created_at' => date('Y-m-d h:i:s'), 'tran_id' => $get_sub_id->id);
            $this->db->insert('event_invited_people', $data);
            $result[] = $this->db->insert_id();
        }
        return $result;
    }

    function exist_invite_peoplecount($eventId = '')
    {
        $query = $this->db->query("select * from event_invited_people where event_id = " . @$eventId . " and status = '1'");
        $result = ($query->num_rows() > 0) ? $query->num_rows() : FALSE;
        return $result;
    }
    function update_price($eventId = '', $amount = '')
    {
        $query = $this->db->query("update event_invited_people set distributed_event_price = " . $amount . " where event_id = " . $eventId . "");
    }

    function get_single_row_info($column = '', $table = '', $where = '', $orderby = '', $limit = '')
    {

        if (!empty($where)) {
            $where = "where " . @$where . "";
        } else {
            $where = "";
        }

        if (!empty($orderby)) {
            $orderby = "order by " . $orderby . "";
        } else {
            $orderby = "";
        }

        if (!empty($limit)) {
            $limit = "limit " . $limit . "";
        } else {
            $limit = "";
        }

        $query = $this->db->query("select " . @$column . " from " . @$table . " " . @$where . " " . @$orderby . " " . @$limit . "");
        $result = ($query->num_rows() > 0) ? $query->row() : FALSE;
        return $result;
    }

    function get_multiple_row_info($column = '', $table = '', $where = '', $orderby = '', $limit = '')
    {

        if (!empty($where)) {
            $where = "where " . @$where . "";
        } else {
            $where = "";
        }

        if (!empty($orderby)) {
            $orderby = "order by " . $orderby . "";
        } else {
            $orderby = "";
        }

        if (!empty($limit)) {
            $limit = "limit " . $limit . "";
        } else {
            $limit = "";
        }

        $query = $this->db->query("select " . @$column . " from " . @$table . " " . @$where . " " . @$orderby . " " . @$limit . "");
        $result = ($query->num_rows() > 0) ? $query->result() : FALSE;
        return $result;
    }
    function check_subscription_exist()
    {
        $userId = $this->session->userdata('loguserId');
        $current_date = date('Y-m-d H:i:s');

        $check_subscription = $this->db->query("select id, sub_id, subscription from transaction where user_id = " . $userId . " ORDER BY id DESC LIMIT 1")->row();
        //return $check_subscription;die;
        if (!empty(@$check_subscription)) {

            if (@$check_subscription->subscription == 'Free') {
                $count_invite_people_byuser_freesub = $this->count_invite_people_byuser_freesub($userId);
                $getSub = $this->db->query("select * from subscription where id = " . @$check_subscription->sub_id . " and status = '1'")->row();
                if ($getSub->invitation_limit <= $count_invite_people_byuser_freesub) {
                    $result = 0;
                } else {
                    $result = 1;
                }
            } else {
                $query = $this->db->query("select * from transaction where user_id = " . @$userId . " and payment_type = '1' and end_date >= '" . @$current_date . "' ORDER BY id DESC LIMIT 1");
                $result = ($query->num_rows() > 0) ? $query->num_rows() : '';
            }
        } else {
            $result = 0;
        }

        return $result;
    }

    function count_invite_people_byuser_freesub($userId = '')
    {
        $current_date = date('Y-m');
        //$current_date = date('2023-08');
        $query = $this->db->query("select * from event_invited_people where user_id = " . @$userId . " and invited_people = 'free subscription'");
        $result = ($query->num_rows() > 0) ? $query->num_rows() : '';
        return $result;
    }

    function count_invite_people_byuser($userId = '', $user_tran_id = '')
    {
        $current_date = date('Y-m');
        //$current_date = date('2023-11');
        $query = $this->db->query("select * from event_invited_people where user_id = " . @$userId . " and DATE_FORMAT(created_at, '%Y-%m') = '" . $current_date . "' and invited_people != 'free subscription' and tran_id = '" . $user_tran_id . "'");
        $result = ($query->num_rows() > 0) ? $query->num_rows() : '';
        return $result;
    }

    function check_monthly_invitepeople_limit($user_Id)
    {
        //$userId = $this->session->userdata('loguserId');
        $userId = $user_Id;
        $current_date = date('Y-m-d H:i:s');
        $result = '';
        $check_subscription = $this->db->query("select id, sub_id, subscription from transaction where user_id = " . $userId . " ORDER BY id DESC LIMIT 1")->row();
        //return $check_subscription;die;
        if (!empty(@$check_subscription)) {

            if (@$check_subscription->subscription == 'Free') {

                // $query = $this->db->query("select * from transaction where user_id = ".$userId." ORDER BY id DESC LIMIT 1");
                // if($query->num_rows() > 0){
                // $sub = $query->row();
                // $getSub = $this->db->query("select * from subscription where id = ".@$sub->sub_id." and status = '1'")->row();
                // $count_invite_people_byuser = $this->count_invite_people_byuser($userId);
                // if($getSub->invitation_limit <= $count_invite_people_byuser){
                // //echo 'your monthly limit is over. limit is: '.@$getSub->invitation_limit.'';
                // $result = 0;
                // }else{
                // //echo 'not over monthly limit';
                // $result = 1;
                // }
                // }else{
                // $result = 'sub_over';
                // }

                $count_invite_people_byuser_freesub = $this->count_invite_people_byuser_freesub($userId);
                $getSub = $this->db->query("select * from subscription where id = " . @$check_subscription->sub_id . " and status = '1'")->row();
                if ($getSub->invitation_limit <= $count_invite_people_byuser_freesub) {
                    $result = 'free_limit_over';
                } else {
                    $result = 1;
                }

            } else {

                $query = $this->db->query("select * from transaction where user_id = " . $userId . " and payment_type = '1' and end_date >= '" . @$current_date . "' ORDER BY id DESC LIMIT 1");
                if ($query->num_rows() > 0) {

                    $sub = $query->row();
                    $getSub = $this->db->query("select * from subscription where id = " . @$sub->sub_id . " and status = '1'")->row();
                    $count_invite_people_byuser = $this->count_invite_people_byuser($userId, $sub->id);

                    $user_total_invitation = $this->db->query("select total_invitation from users where id = " . $userId . "")->row();
                    if ($user_total_invitation->total_invitation == 0) {
                        $result = 'total_invitaion_limit_over';
                    } else {
                        if ($getSub->invitation_limit <= $count_invite_people_byuser) {
                            //echo 'your monthly limit is over. limit is: '.@$getSub->invitation_limit.'';
                            $result = 0;
                        } else {
                            //echo 'not over monthly limit';
                            $result = 1;
                        }

                    }

                } else {
                    $result = 'sub_over';
                }
            }
        } else {
            $result = 'sub_not_found';
        }
        return $result;
    }

    function total_sum($id = '')
    {
        $query = $this->db->query("select sum(distributed_event_price) as totalAmount from event_invited_people where event_id = " . $id . "");
        $result = ($query->num_rows() > 0) ? $query->row() : '';
        return $result;
    }

    function send_mail($to_email = '', $from_email = '', $msg = '', $subject = '', $mail_username = '', $mail_password = '')
    {
        require_once APPPATH . 'third_party/email/vendor/autoload.php';
        $mail = new PHPMailer();
        $mail->SMTPDebug = 0; //Enable verbose debug output
        $mail->Host = 'smtp.office365.com'; // Specify main and backup SMTP servers
        $mail->IsSMTP();
        $mail->SMTPAuth = true; // Enable SMTP authentication
        $mail->Username = $mail_username;
        $mail->Password = $mail_password;
        $mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587; // TCP port to connect to
        //$mail->setFrom($from_email);
        $mail->From = '' . $from_email . '';
        $mail->addAddress($to_email);
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body = $msg;
        return $mail->send();

        //email
        /*$headers = "MIME-Version: 1.0" . "\r\n";
              $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
              // More headers
              $headers .= 'From: <'.@$from_email.'>' . "\r\n";
              $subject = @$subject;
              $to = 	@$to_email;
              $message = @$msg;
              return mail($to, $subject, $message, $headers);*/
    }

    function partiallyHideEmail($email)
    {
        // use FILTER_VALIDATE_EMAIL filter to validates an email address
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // split an email by "@"
            list($first, $last) = explode('@', $email);

            // get half the length of the first part
            $firstLen = floor(strlen($first) / 2);

            // partially hide a first part
            $first = str_replace(substr($first, $firstLen), str_repeat('*', strlen($first) - $firstLen), $first);


            // get the starting position of the "."
            $lastIndex = strpos($last, ".");

            // divide last part in two different strings
            $last1 = substr($last, 0, $lastIndex);
            $last2 = substr($last, $lastIndex);

            // get half the length of the "$last1"
            $lastLen = floor(strlen($last1) / 2);

            // partially hide a string by "*"
            $last1 = str_replace(substr($last1, $lastLen), str_repeat('*', strlen($last1) - $lastLen), $last1);

            // combine all parts together and return partially hide email
            $partiallyHideEmail = $first . '@' . $last1 . '' . $last2;

            return $partiallyHideEmail;
        }
    }
    function mail_send_management($to_email = '', $from_email = '', $bcc = '', $msg = '', $subject = '', $mail_username = '', $mail_password = '')
    {
        require_once APPPATH . 'third_party/email/vendor/autoload.php';
        $mail = new PHPMailer();
        $mail->SMTPDebug = 0; //Enable verbose debug output
        $mail->Host = 'smtp.office365.com'; // Specify main and backup SMTP servers
        $mail->IsSMTP();
        $mail->SMTPAuth = true; // Enable SMTP authentication
        $mail->Username = $mail_username;
        $mail->Password = $mail_password;
        $mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587; // TCP port to connect to
        $mail->setFrom($from_email);
        $mail->addAddress($to_email);
        if (!empty($bcc)) {
            foreach ($bcc as $v) {
                $mail->AddBCC($v);//data taken from table
            }
        }
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body = $msg;
        return $mail->send();
    }

    public function update_data($table = '', $colum = '', $where = '', $data = '')
    {
        if (!empty($data)) {
            $this->db->select($colum);
            $this->db->from($table);
            $this->db->where($where);
            $prevQuery = $this->db->get();
            $prevCheck = $prevQuery->num_rows();

            if ($prevCheck > 0) {
                $prevResult = $prevQuery->row_array();
                $data['updated_at'] = date("Y-m-d H:i:s");
                $update = $this->db->update($table, $data, $where);
                $userID = $prevResult['id'];
            } else {
                $data['created_at'] = date("Y-m-d H:i:s");
                $insert = $this->db->insert($table, $data);
                $userID = $this->db->insert_id();
            }
        }
        //return user ID
        return $userID ? $userID : FALSE;
    }

    public function Facebook_Login($userData = array())
    {
        if (!empty($userData)) {
            //check whether user data already exists in database with same oauth info
            $this->db->select('*');
            $this->db->from('users');
            $this->db->where(array('oauth_provider' => $userData['oauth_provider'], 'oauth_uid' => $userData['oauth_uid']));
            $prevQuery = $this->db->get();
            $prevCheck = $prevQuery->num_rows();

            if ($prevCheck > 0) {
                $prevResult = $prevQuery->row_array();

                //update user data
                $userData['updated_at'] = date("Y-m-d H:i:s");
                $update = $this->db->update('users', $userData, array('id' => $prevResult['id']));
                //get user ID
                $userID = $prevResult['id'];
            } else {
                //insert user data
                $userData['created_at'] = date("Y-m-d H:i:s");
                $insert = $this->db->insert('users', $userData);
                //get user ID
                $userID = $this->db->insert_id();
            }
        }

        //return user ID
        return $userID ? $userID : FALSE;
    }

    public function Google_Login($userData = array())
    {
        if (!empty($userData)) {
            //check whether user data already exists in database with same oauth info
            $this->db->select('id');
            $this->db->from('users');
            $this->db->where(array('oauth_provider' => $userData['oauth_provider'], 'oauth_uid' => $userData['oauth_uid']));
            $prevQuery = $this->db->get();
            $prevCheck = $prevQuery->num_rows();

            if ($prevCheck > 0) {
                $prevResult = $prevQuery->row_array();
                //update user data
                $userData['updated_at'] = date("Y-m-d H:i:s");
                $update = $this->db->update('users', $userData, array('id' => $prevResult['id']));
                //get user ID
                $userID = $prevResult['id'];
            } else {
                //insert user data
                $userData['created_at'] = date("Y-m-d H:i:s");
                $insert = $this->db->insert('users', $userData);
                //get user ID
                $userID = $this->db->insert_id();
            }
        }
        //return user ID
        return $userID ? $userID : FALSE;
    }

    function already_exist($email = '')
    {

        $query = $this->db->query('select * from users where email = "' . $email . '"');
        $result = ($query->num_rows() > 0) ? $query->row() : FALSE;
        return $result;
    }

    function send_sms($to_phone = '', $msg = '')
    {
        error_reporting(0);
        require_once APPPATH . 'third_party/twilio/vendor/autoload.php';
        $account_sid = "ACb7fc6bb7d154f0604e3807a2665b527d";
        $auth_token = "58fc4c180537e034215e8fc8b1a039b3";
        $twilio_phone_number = "+15163424608";
        $client = new Client($account_sid, $auth_token);
        try {
            $result = $client->messages->create(
                '' . @$to_phone . '',
                array(
                    "from" => $twilio_phone_number,
                    "body" => "" . $msg . ""
                )
            );
        } catch (Twilio\Exceptions\RestException $e) {
            $result = $e->getMessage();
        }
        return $result;
    }

    function checksubBefore_expied($user_id)
    {
        $date = date('Y-m-d');
        $query = $this->db->query("select * from transaction where user_id = " . $user_id . " and payment_type = '1' and end_date > '" . $date . "' ORDER BY id DESC LIMIT 1");
        $result = ($query->num_rows() > 0) ? $query->row() : '';
        return $result;
    }

    function get_ById($table = '', $where = '', $limit = '', $orderby = '')
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($where);
        if ($limit = '') {
            $this->db->limit($limit);
        }
        if ($orderby = '') {
            $this->db->order_by($orderby);
        }
        $query = $this->db->get();
        $result = ($query->num_rows() > 0) ? $query->result() : FALSE;
        return $result;
    }

    function update_data_onsignal($table = '', $where = '', $data = '')
    {
        $this->db->set($data);
        $this->db->where($where);
        if ($this->db->update($table) === true) {
            return true;
        } else {
            return false;
        }
    }

    public function sendMsg($userId, $msg)
    {
        $playerInfo = $this->get_single("onesignal_users", "user_id='" . $userId . "'");
        if ($playerInfo) {
            $pushData = array(
                'playerId' => $playerInfo->player_id,
                'msg' => $msg,
            );

            $this->Mymodel->sendPushNotification($pushData);
            //echo 'Sent';
        } else {
            //echo "Not Found";
        }

    }

    public function sendPushNotification($pushData)
    {
        $content = array(
            "en" => $pushData['msg']
        );

        $fields = array(
            //'app_id' => "0369ee8b-9c16-4873-9d03-f7985989b631",
            'app_id' => "361882f3-ac2c-40fe-aaa9-65192c0e8267",
            'include_player_ids' => [$pushData['playerId']],
            'data' => array("name" => "MadeToSplit Team"),
            'large_icon' => "https://madetosplit.com/uploads/logos/logo.png",
            'contents' => $content
        );

        $fields = json_encode($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        //curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8', 'Authorization: Basic MzNkODVmZWQtNTA1NC00YTc4LTg4MDctYzQ1ZTVkNjEyNzgx'));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8', 'Authorization: Basic YWVhODE4MWUtODQ2OS00ZmJiLThjNmItN2JiYTI3MjE1YmQ4'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);
        return $response;

    }
    function get_single($table, $cond = '')
    {
        if ($cond != '')
            $this->db->where($cond);
        return $this->db->get($table)->row();
    }

}