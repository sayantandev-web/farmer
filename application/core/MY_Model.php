<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model {

	protected $key = 'id';

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
			$this->db->order_by($order_by, 'DESC');
		}

		$query = $this->db->get();

		$result = $query->$method();

		return $result;
	}


	public function select($select, $table, $single = False, $where = NULL, $limit = NULL, $order_by = NULL)
	{
		$this->db->select($select);

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


	public function save($table, $data)
	{
		if($this->db->insert($table, $data)) {
			return true;
		} else {
			return false;
		}
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


	public function delete($table, $where)
	{
		if($this->db->delete($table, $where)) {
			return true;
		} else {
			return false;
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


	public function fetch($sql, $single = FALSE)
	{
		$query = $this->db->query($sql);

		if ($single == FALSE) {
			$result = $query->result();
		} else {
			$result = $query->row();
		}
		return $result;
	}


	public function change_status($table, $where, $status)
	{
		if($this->update($status, $table, $where) == true) {
			return true;
		} else {
			return false;
		}
	}

	public function fetch_user($userId)
	{
		if (is_numeric($userId)) {
			$sql="SELECT firstName, lastName FROM users WHERE userId='".$userId."'";

			$query = $this->db->query($sql);
			$result = $query->row();
		} else {
			
			$sql="SELECT eshopName FROM eshop WHERE eshopId='".$userId."'";
			$query = $this->db->query($sql);
			$result = $query->row();
		}
		return $result;

	}
	public function getCurrencySymbol($currency_code='INR')
	{
  
    $query=$this->db->select('symbol')->where('currency_code', $currency_code)->get('currency');
    $res=$query->row();
    if (!empty($res->symbol))
      return (string) $res->symbol;
    else
      return 'Rs ';
  }

  public function avgStarRating($productId)
  {
  	$sql = "SELECT AVG(starRating) AS avgStarRating FROM product_rating WHERE productId = '$productId'";
  	return $this->fetch($sql, true)->avgStarRating;
  }

 public function generateRandomString($length = 8) 
 {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
}