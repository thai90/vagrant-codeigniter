<?php
class User_model extends CI_Model{

    private $current_user;

    public function __construct (){
        parent::__construct();
        $this->load->database();
    }

    public function insert($data){
        if($this->db->insert('user',$data)){
            $this->db->from('user');
            $this->db->where('email',$data['email']);
            $query = $this->db->get();
            foreach($query->result() as $row){
                return $row;
            }
        }
        return false;
    }

    /*izumiyaさんが作ってくれたメソード
    public function sign_in($email,$password) {
       $query = $this->db->get_where('user',array('email' => $email, 'password' => $password));
       $this->_current_user = $query->first_row();
       return $query->num_rows() > 0;
    }

    public function current_user()
    {
        return $this->_current_user;
    }
    */

    public function check_login($email,$password){
        $checkLogin = $this->db->get_where('user',array('email' => $email, 'password' => $password));
        if($checkLogin->num_rows() === 0) return false;
        foreach($checkLogin->result() as $row){
            return $row;
        }
    }
}
?>