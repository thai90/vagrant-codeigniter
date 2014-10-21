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
        $checkEmai_query = $this->db->get_where('user',array('email' => $email));
        if($checkEmai_query->num_rows() === 0) return 'wrongEmail';
        $checkPassword_query = $this->db->get_where('user',array('email' => $email, 'password' => $password));
        if($checkPassword_query->num_rows() === 0) return 'wrongPassword';
        foreach($query2->result() as $row)
                return $row;
        }
    }
?>