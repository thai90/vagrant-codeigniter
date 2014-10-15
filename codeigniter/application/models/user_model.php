<?php
class User_model extends CI_Model{

	public function __construct ()
	{
		parent::__construct();
		$this->load->database();
	}

	public function listAll()
	{
		$query = $this->db->get('user');
		return $query->result_array();
	}

	public function insert($data)
	{
		if($this->db->insert('user',$data))	
		{
			$this->db->from('user');
			$this->db->where('email',$data['email']);
			$query = $this->db->get();
			foreach($query->result() as $row)
				return $row;
		}
		return false;
	}

	public function check_login($email,$password)
	{
		$query1 = $this->db->get_where('user',array('email' => $email));
		if($query1->num_rows() === 0) return 'wrongEmail';
		$query2 = $this->db->get_where('user',array('email' => $email, 'password' => $password));
		if($query2->num_rows() === 0) return 'wrongPassword'; 
		foreach($query2->result() as $row)
				return $row;
		}
	}
?>