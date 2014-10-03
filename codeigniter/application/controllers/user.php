<?php
	class User extends CI_Controller 
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->library('session');
		}
		function register()
		{
			$this->load->model('User_model');
			$this->load->helper(array('form','url'));
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('<p style="color:red">','</p>');
			if($this->form_validation->run('signUp')==FALSE)
			{
				$this->load->view('user/registerForm');
			}
			else
			{
				$newRecord['name'] = $this->input->post('username');
				$newRecord['password'] = $this->input->post('password');
				$newRecord['email'] = $this->input->post('email');
				if($this->User_model->insert($newRecord) == TRUE)
					$this->load->view('user/registerSuccess');
			}
		}

		function login()
		{
			$this->load->model('User_model');
			$this->load->helper(array('form','url'));
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('<p style="color:red">','</p>');
			if($this->form_validation->run('login')==FALSE)
			{
				$this->load->view('user/loginForm');
			}
			else
			{
				$email = $this->input->post('email');
				$password = $this->input->post('password');
				$userInfo = $this->User_model->check_login($email,$password);
				if($userInfo != null)
				{
					$data = array('email'=>$userInfo->email,'username'=>$userInfo->name);
					$this->session->set_userdata('logged_in',$data);
					$this->load->view('user/homepage');
					
				}
				else
				{
					$this->form_validation->set_message('check_database','ユーザ名かパスワードは無効です');

				}
			}

		}

		function homepage()
		{
			if($this->session->userdata('logged_in'))
			{
				$sessionData = $this->session->userdata('logged_in');
				$data['username'] = $sessionData['username'];
				$this->load->view('user/homepage',$data);
			}
			else
				$this->load->view('user/login');
		}

		function logout()
		{
			$this->session->unset_userdata('logged_in');
			session_destroy();
			$this->load->view('user/loginForm');
		}
	}
?>