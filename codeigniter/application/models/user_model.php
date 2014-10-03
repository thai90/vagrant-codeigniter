<?php
class User_model extends CI_Model{

	public function __construct ()
	{
		parent::__construct();
		$connected = $this->load->database();
	}

	public function listAll()
	{
			$query = $this->db->get('user');
			return $query->result_array();
	}

	public function insert($data)
	{
		return $this->db->insert('user',$data);
	}

	public function check_login($email,$password)
	{
		$query = $this->db->get_where('user',array('email'=>$email,'password'=>$password),1);
		$rowCount = $query->num_rows();
		if ($rowCount == 1) 
			foreach($query->result() as $row)
				return $row;
		else return null;
	}
}
?>