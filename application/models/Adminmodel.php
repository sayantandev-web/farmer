<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');
class Adminmodel extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->library('session');
		
	}
	
 public function login($username, $password)
    {
        $where = "email = '" . $username . "' OR username = '" . $username . "'";
        if ($this->count('admin', $where) != 1) {
            $msg = "Invalid Username.";
        } else {
            $user = $this->get_by('admin', true, $where);
            if (password_verify($password, @$user->password) == 0) 
            {
                $msg = "Invalid Password";
            } elseif (@$user->status == 0) {
                $msg = "Your account has been deactivated. Please contact master admin for details.";
            } else {
                $msg = "Login";
                $this->session->set_userdata('admin', '1');
                $this->session->set_userdata('userId', @$user->userId);
				 $cookie = array(
                    'name' => 'newuserId',
                    'value' => @$user->userId,
                    'expire' => '86500',
                    'path' => '/',
                    'secure' => TRUE
                );

                $this->input->set_cookie($cookie);

            }
        }
        return $msg;
    }
	
	public function user_login($username, $password)
    {
        $where = "email = '" . $username . "'";
        if ($this->count('users', $where) != 1) {
            $msg = "Invalid Username.";
        } else {
            $user = $this->get_by('users', true, $where);
			//print_r($user->user_type);die;
            if ($password != @$user->password) 
            {
                $msg = "Invalid Password";
            } elseif (@$user->status == 0) {
                $msg = "Your account has been deactivated. Please contact master admin for details.";
            } else {
                $msg = "Login";
                $this->session->set_userdata('USER', '1');
                $this->session->set_userdata('USER_ID', @$user->id);
                $this->session->set_userdata('USERROLEID', $user->user_type);
				 $cookie = array(
                    'name' => 'newuserId',
                    'value' => @$user->id,
                    'expire' => '86500',
                    'path' => '/',
                    'secure' => TRUE
                );

                $this->input->set_cookie($cookie);

            }
        }
        return $msg;
    }
	
	public function loggedIn()
	{
		
		//echo $this->session->userdata('userId');die;
		if (!$this->session->has_userdata('userId') || !$this->session->has_userdata('admin')) {
			
			//$redirectto = urlencode(current_url());
			//redirect(base_url('admin/login?redirectto='.$redirectto),'refresh');
			redirect(base_url('admin/login'),'refresh');
		}
	}
	
	public function userloggedIn()
	{
		
		//echo $this->session->userdata('userId');die;
		if (!$this->session->has_userdata('USER_ID') || !$this->session->has_userdata('USER')) {
			
			//$redirectto = urlencode(current_url());
			//redirect(base_url('admin/login?redirectto='.$redirectto),'refresh');
			redirect(base_url('user/login'),'refresh');
		}
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
		
		if($this->db->update($table, $data)) {
			return true;
		} else {
			return false;
		}
	}
	function get_all_record($column = '', $table = '', $where = '', $orderby = '', $limit = ''){
		$this->db->select($column); 
		$this->db->from($table);
		if($where != ''){
		  $this->db->where($where);	
		}
       	if($limit != ''){
		  $this->db->limit($limit);
		}
		if($orderby != ''){
		  $this->db->order_by($orderby[0], $orderby[1]);
		}
		$query = $this->db->get();
		$result = ($query->num_rows() > 0) ? $query->result():FALSE;
		return $result;
	}
	function add($table = '', $data = ''){
		if(empty($data)){
		   return false;
		} 
		if(empty($table)){
		   return false;
		}
		$result = $this->db->insert($table, $data);
		return $result ? $this->db->insert_id() : FALSE;
	}
	function UniqueEmail($params = array()){
		
	  if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
		$this->db->select('email'); 
        $this->db->from('users'); 
		$this->db->where('email',$params['conditions']['email']);
		$query = $this->db->get();
		return $query;
		
	  }
	}
	function state($country_id){
		$this->db->where('country_id', $country_id);
		$this->db->order_by('state_name', 'ASC');
		$query = $this->db->get('state');
		$output = '<option value="">Select State</option>';
		foreach($query->result() as $row){
		 $output .= '<option value="'.(!empty($row->state_id) ? $row->state_id : '').'">'.$row->state_name.'</option>';
		}
		return $output;
	}
	function get_city($state_id){
		$this->db->where('state_id', $state_id);
		$this->db->order_by('city_name', 'ASC');
		$query = $this->db->get('city');
		$output = '<option value="">Select City</option>';
		foreach($query->result() as $row){
		    $output .= '<option value="'.(!empty($row->city_id) ? $row->city_id : '').'">'.$row->city_name.'</option>';
		}
		return $output;
	}
	public function update_user_data($column = '', $table = '', $where = '', $data = ''){
        if(!empty($data)){
			//print_r($data);die;
            $this->db->select($column);
            $this->db->from($table);
            $this->db->where($where);
            $prevQuery = $this->db->get();
            $prevCheck = $prevQuery->num_rows();
            
            if($prevCheck > 0){
                $prevResult = $prevQuery->row_array();
                $data['updated_at'] = date("Y-m-d H:i:s");
                $update = $this->db->update($table, $data, $where);
                $userID = $prevResult['id'];
            }else{
                $data['created_at']  = date("Y-m-d H:i:s");
				$insert = $this->db->insert($table, $data);
                $userID = $this->db->insert_id();
            }
        }
        //return user ID
        return $userID?$userID:FALSE;
    }
	function getuser_bysport($sport_id){
		$where = 'FIND_IN_SET("'.$sport_id.'", sport_id) AND user_type = "Individual"';
		// $where = array('sport_id' => $sport_id, 'user_type' => 'Individual');
		// $this->db->where($where);
		// $this->db->order_by('id', 'ASC');
		$sql = "select * from users where ".$where." ORDER BY id ASC";
		$query = $this->db->query($sql);
		echo $this->db->last_query();
		$output = '<option value="">Select User</option>';
		foreach($query->result() as $row){
		    $output .= '<option value="'.(!empty($row->id) ? $row->id : '').'">'.$row->first_name .' '.$row->last_name.'</option>';
		}
		return $output;
	}
	
	function getrganiser_bysport($sport_id){
		$where = 'FIND_IN_SET("'.$sport_id.'", sport_id) AND user_type = "Individual"';
		// $where = array('sport_id' => $sport_id, 'user_type' => 'Individual');
		// $this->db->where($where);
		// $this->db->order_by('id', 'ASC');
		$sql = "select * from users where ".$where." ORDER BY id ASC";
		$query = $this->db->query($sql);
		echo $this->db->last_query();
		$output = '<option value="">Select Organizer</option>';
		foreach($query->result() as $row){
		    $output .= '<option value="'.(!empty($row->id) ? $row->id : '').'">'.$row->first_name .' '.$row->last_name.'</option>';
		}
		return $output;
	}
	
	function UniqueTeamPlayer($params = array()){
		$where = array('coach_id' => $params['conditions']['coach_id'], 'player_id' => $params['conditions']['user_id']);
		if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
			$this->db->select('coach_id, player_id'); 
			$this->db->from('coach_team'); 
			$this->db->where($where);
			$query = $this->db->get();
			return $query;
		}
	}
	function add_multiple_image($data = ''){
		//print_r($data);die;
		$count = 0;
		foreach ($data as $image) {
						
			$galleryData = array(
				'image' => $image['image'],
				'user_id' => $image['userId'],
				'created_at' =>date('Y-m-d H:i:s')
			);
			
			$this->db->insert('sponser', $galleryData);
			$result[] =  $this->db->insert_id();
		}
		return $result;
	}
	
	function getwinnerOpt($orgId){
		if($orgId){
			$opponent = $this->db->query("select * from invite_opponent where sender_team = ".@$orgId." AND game_type='One to One' AND status = '1' ORDER BY id DESC LIMIT 1")->row();
			if(!empty($opponent)){
				
				$getTeam = $this->db->query("select first_name, last_name, team_name, id from users where id IN(".@$opponent->receiver_team.",".@$opponent->sender_team.")")->result();
				
				if(!empty(@$opponent->winner_id)){
					$winnerId = @$opponent->winner_id;
				}else{
					$winnerId = '';
				}
				
				$output = '<option value="">Select Winner</option>';
				foreach($getTeam as $row){
				   $output .= '<option value="'.(!empty($row->id) ? $row->id : '').'" '.((@$winnerId == @$row->id) ? 'selected' : '').'>'.$row->team_name.'('.$row->first_name.' '.$row->last_name.')'.'</option>';
				}
                return $output;
			
			}
		}
		
	}
	public function addInvite_Opponent($table = '', $column = '', $where_1 = '', $where_2 = '', $userData = array()){
        if(!empty($userData)){
            //check whether user data already exists in database with same oauth info
            $this->db->select($column);
            $this->db->from($table);
            $this->db->where($where_1);
            $prevQuery = $this->db->get();
            $prevCheck = $prevQuery->num_rows();
            
            if($prevCheck > 0){
                $prevResult = $prevQuery->row_array();
                $userData['updated_at'] = date("Y-m-d H:i:s");
                $update = $this->db->update($table, $userData, $where_2);
                $userID = $prevResult['id'];
            }else{
                $userData['created_at']  = date("Y-m-d H:i:s");
                $insert = $this->db->insert($table, $userData);
                $userID = $this->db->insert_id();
            }
        }
        return $userID?$userID:FALSE;
    }
	
	function gettournamentwinnerOpt($orgId){
		if($orgId){
			$opponent = $this->db->query("select * from invite_tournament_opponent where sender_team = ".@$orgId." AND game_type='Tournament' AND status = '1' ORDER BY id DESC LIMIT 1")->row();
			if(!empty($opponent)){
				if(!empty(@$opponent->winner_id)){
					$winnerId = @$opponent->winner_id;
				}else{
					$winnerId = '';
				}
				$exopponent = explode(',', @$opponent->receiver_team);
				$output = '<option value="">Select Winner</option>';
				foreach($exopponent as $opp){
					$getTeam = $this->db->query("select first_name, last_name, team_name, id from users where id = ".@$opp."")->row();
					$output .= '<option value="'.(!empty($getTeam->id) ? $getTeam->id : '').'" '.((@$winnerId == @$getTeam->id) ? 'selected' : '').'>'.$getTeam->team_name.'('.$getTeam->first_name.' '.$getTeam->last_name.')'.'</option>';
				}
				// $getTeam = $this->db->query("select first_name, last_name, team_name, id from users where id IN(".@$opponent->receiver_team.")")->row();
				// //return $output;
				// $output = '<option value="">Select Winner</option>';
				// foreach($getTeam as $row){
				// $output .= '<option value="'.(!empty($row->id) ? $row->id : '').'">'.$row->team_name.'('.$row->first_name.' '.$row->last_name.')'.'</option>';
				// }
				return $output;
			}
		}
	}
	function uploadMultipleFile($data){
		if($data){
			foreach($data as $gallery){
				
			$check_file = explode(".",$gallery['image']);
			if($check_file[1] == 'jpg' OR $check_file[1] == 'jpeg' OR $check_file[1] == 'png' OR $check_file[1] == 'gif'){
				$file_type = 1;
			}
			if($check_file[1] == 'mp4' OR $check_file[1] == '3gp' OR $check_file[1] == 'mov' OR $check_file[1] == 'webm' OR $check_file[1] == 'ogv' OR $check_file[1] == 'ogg'){
				$file_type = 2;
			}
			if($check_file[1] == 'mp3'){
			    $file_type = 3;
			}
			
				 $insertGallery = array(
				   'image' => $gallery['image'],
				   'user_id' => $gallery['userId'],
				   'status' => $gallery['status'],
				   'file_type' => $file_type,
				   'created_at' => date('Y-m-d H:i:s'),
				 );
				 $result[] = $this->db->insert('player_img_gallery', $insertGallery);
			}
			return $result ? $result : FALSE;
		}
	}
	function updateMultipleFile($data = '', $id = ''){
		if($data){
			
			foreach($data as $gallery){
				//print_r($gallery);die;
				
				$check_file = explode(".",$gallery['image']);
				if($check_file[1] == 'jpg' OR $check_file[1] == 'jpeg' OR $check_file[1] == 'png' OR $check_file[1] == 'gif'){
					$file_type = 1;
				}
				
				if($check_file[1] == 'mp4' OR $check_file[1] == '3gp' OR $check_file[1] == 'mov' OR $check_file[1] == 'webm' OR $check_file[1] == 'ogv' OR $check_file[1] == 'ogg'){
					$file_type = 2;
				}
				
				if($check_file[1] == 'mp3'){
					$file_type = 3;
				}
			
				 $insertGallery = array(
				   'image' => $gallery['image'],
				   'status' => $gallery['status'],
				   'file_type' => $file_type,
				   'updated_at' => date('Y-m-d H:i:s'),
				 );
				// $result[] = $this->db->update('player_img_gallery', $insertGallery);
				 $result[] = $this->db->update('player_img_gallery', $insertGallery, array('id' => $id));
			}
			return $result ? $result : FALSE;
		}
	}
	
	function uploadMultipleFilePost($postId = '', $data = ''){
		if($data){
			foreach($data as $gallery){
				
			$check_file = explode(".",$gallery['image']);
			if($check_file[1] == 'jpg' OR $check_file[1] == 'jpeg' OR $check_file[1] == 'png' OR $check_file[1] == 'gif'){
				$file_type = 1;
			}
			if($check_file[1] == 'mp4' OR $check_file[1] == '3gp' OR $check_file[1] == 'mov' OR $check_file[1] == 'webm' OR $check_file[1] == 'ogv' OR $check_file[1] == 'ogg'){
				$file_type = 2;
			}
			if($check_file[1] == 'mp3'){
			    $file_type = 3;
			}
			
				 $insertGallery = array(
					'file' => $gallery['image'],
					//'user_id' => $gallery['userId'],
					// 'status' => $gallery['status'],
					'post_id' => $postId,
					'fileType' => $file_type,
					'created_at' => date('Y-m-d H:i:s'),
				 );
				 $result[] = $this->db->insert('post_gallery', $insertGallery);
			}
			return $result ? $result : FALSE;
		}
	}
	function uploadMultipleFilePost_update($postId = '', $data = ''){
		if($data){
			foreach($data as $gallery){
				
			$check_file = explode(".",$gallery['image']);
			if($check_file[1] == 'jpg' OR $check_file[1] == 'jpeg' OR $check_file[1] == 'png' OR $check_file[1] == 'gif'){
				$file_type = 1;
			}
			if($check_file[1] == 'mp4' OR $check_file[1] == '3gp' OR $check_file[1] == 'mov' OR $check_file[1] == 'webm' OR $check_file[1] == 'ogv' OR $check_file[1] == 'ogg'){
				$file_type = 2;
			}
			if($check_file[1] == 'mp3'){
			    $file_type = 3;
			}
			
				 $insertGallery = array(
					'file' => $gallery['image'],
					//'user_id' => $gallery['userId'],
					// 'status' => $gallery['status'],
					'post_id' => $postId,
					'fileType' => $file_type,
					'created_at' => date('Y-m-d H:i:s'),
				 );
				 $result[] = $this->db->insert('post_gallery', $insertGallery);
			}
			return $result ? $result : FALSE;
		}
	}
	
	function add_multiple_listing_gallery($data = '', $table = '', $id = ''){
		//print_r($data);die;
		$count = 0;
		foreach ($data as $image) {
						
			$galleryData = array(
				'image' => $image['image'],
				'event_id' => $id,
				'user_id' => $image['userId'],
				'created_at' =>date('Y-m-d H:i:s')
			);
			
			$this->db->insert($table, $galleryData);
			$result[] =  $this->db->insert_id();
		}
		return $result;
	}
	
	function addInvitedPeople($email = '', $eventId = ''){
		foreach ($email as $v) {
			$data = array('email' => $v, 'event_id' => $eventId, 'status' => '1', 'created_at' => date('Y-m-d h:i:s'));
			$this->db->insert('event_invited_people', $data);
			$result[] =  $this->db->insert_id();
		}
		return $result;
	}
	function checksubBefore_expied($user_id){
		$date = date('Y-m-d');
		$query = $this->db->query("select * from transaction where user_id = ".$user_id." and payment_type = '1' and end_date > '".$date."' ORDER BY id DESC LIMIT 1");
		$result = ($query->num_rows() > 0) ? $query->row() : '';
		return $result;
	}
	
	function get_single_row_info($column = '', $table = '', $where = '', $orderby = '', $limit = ''){
		
		if(!empty($where)){
			$where = "where ".@$where."";
		}else{
			$where = "";
		}
		
		if(!empty($orderby)){
			$orderby = "order by ".$orderby."";
		}else{
			$orderby = "";
		}
		
		if(!empty($limit)){
			$limit = "limit ".$limit."";
		}else{
			$limit = "";
		}
		
		$query = $this->db->query("select ".@$column." from ".@$table." ".@$where." ".@$orderby." ".@$limit."");
		$result = ($query->num_rows() > 0) ? $query->row() : FALSE;
		return $result;
	}
	
	function get_multiple_row_info($column = '', $table = '', $where = '', $orderby = '', $limit = ''){
		
		if(!empty($where)){
			$where = "where ".@$where."";
		}else{
			$where = "";
		}
		
		if(!empty($orderby)){
			$orderby = "order by ".$orderby."";
		}else{
			$orderby = "";
		}
		
		if(!empty($limit)){
			$limit = "limit ".$limit."";
		}else{
			$limit = "";
		}
		
		$query = $this->db->query("select ".@$column." from ".@$table." ".@$where." ".@$orderby." ".@$limit."");
		$result = ($query->num_rows() > 0) ? $query->result() : FALSE;
		return $result;
	}
}	