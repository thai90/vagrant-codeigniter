	<?php
	class User extends CI_Controller 
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->library('session');
			$this->load->helper('url');
		}

		function test()
		{
			$this->load->helper('time');
			echo convertTime('2014-08-28 10:27:00');
		}

		function register()
		{
			$this->load->model('User_model');
			$this->load->helper(array('form'));
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('<p style="color:red">','</p>');
			if($this->form_validation->run('signUp')==FALSE)
			{
				$content = $this->load->view('user/registerForm',null,TRUE);
				$this->load->view('user/beforeLogin_layout',array('content'=>$content));
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
			if($this->session->userdata('logged_in'))
				redirect('/user/homepage','refresh');
			$this->load->model('User_model');
			$this->load->helper(array('form'));
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('<p style="color:red">','</p>');
			if($this->form_validation->run('login')==FALSE)
			{
				$content = $this->load->view('user/loginForm',null,TRUE);
				$this->load->view('user/beforeLogin_layout',array('content'=>$content));
			}
			else
			{

				$email = $this->input->post('email');
				$password = $this->input->post('password');
				echo 'before';
				$userInfo = $this->User_model->check_login($email,$password);
				echo 'after';
				if($userInfo != null)
				{
					$data = array('email'=>$userInfo->email,'username'=>$userInfo->name,'userID'=>$userInfo->id);
					$this->session->set_userdata('logged_in',$data);
					redirect('user/homepage');

				}
				else
				{
					$data['login_failed_mess'] = 'Emailアドレスかパスワードは間違ったんです';
					$content=$this->load->view('user/loginForm',$data);
					$this->load->view('user/beforeLogin_layout',array('content'=>$content));

				}
			}

		}

		function homepage()
		{

			if($this->session->userdata('logged_in'))
			{
				$this->load->model('Tweet_model');
				$this->load->helper('time');
				if($this->input->post('page'))
				{
					$tweetArr = $this->Tweet_model->get_newTweets(TWEETS_PER_PAGE,$this->input->post('page')*TWEETS_PER_PAGE);
					$response = json_encode($tweetArr);
					echo $response;
				}
				else
				{
					$data['userData'] = $this->session->userdata('logged_in');
					$data['newTweets'] = $this->Tweet_model->get_newTweets(TWEETS_PER_PAGE,0);
					$data['tweetNum'] = $this->Tweet_model->get_tweetNums();
					$data['pageNum'] = ceil($data['tweetNum']/TWEETS_PER_PAGE);
					$data1['content'] = $this->load->view('user/homepage',$data,TRUE);
					$this->load->view('user/layout',$data1);
				}
			}
			else
				redirect('user/login');
		}

		function updateNewTweet()
		{
			if($this->input->post('userID') && $this->input->post('newTweet'))
			{
				$this->load->model('Tweet_model');
				$newTweetInfo=$this->Tweet_model->updateNewTweet($this->input->post('userID'),
					$this->input->post('newTweet'));
				$currentUserInfo=$this->session->userdata('logged_in');
				$newTweetInfo['username'] = $currentUserInfo['username'];
				echo json_encode($newTweetInfo);

			}
		}

		function logout()
		{
			$this->session->unset_userdata('logged_in');
			redirect('user/login');
		}


	}
	?>