	<?php
	class User extends CI_Controller 
	{
	   	public function __construct()
		{
			parent::__construct();
			$this->load->library('session');
			$this->load->helper('url');
		}

        //このファンクションはテストの目的のみです		
		function test()
		{

			$this->load->helper('time');
			echo convertTime('2014-08-28 10:27:00');
		}

		//登録機能
		function register()
		{
			$this->load->model('User_model');
			$this->load->helper(array('form'));
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('<p style="color:red">','</p>');
			if($this->form_validation->run('signUp') == FALSE)
			{
				$content = $this->load->view('user/registerForm',null,TRUE);
				$this->load->view('user/beforeLogin_layout',array('content' => $content));
				return;
			}
			$newRecord['name'] = $this->input->post('username');
			$newRecord['password'] = $this->input->post('password');
			$newRecord['email'] = $this->input->post('email');
			$newUser = $this->User_model->insert($newRecord);
			if($newUser != FALSE)
			{
				$this->session->set_userdata(
					'logged_in',
					array('userID'=>$newUser->id,
						'username' => $newUser->name,
						'email' => $user->email
					)
				);
				$this->session->set_flashdata('registerSuccess','登録成功、あなたは今新しいツイートを投稿できるようになります');
				redirect('/user/homepage');
			}
		}


		//ログイン機能
		function login()
		{
			if($this->session->userdata('logged_in'))
				redirect('/user/homepage','refresh');
			$this->load->model('User_model');
			$this->load->helper(array('form'));
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('<p style="color:red">','</p>');
			if($this->form_validation->run('login') == FALSE)
			{ 
				$content = $this->load->view('user/loginForm',null,TRUE);
				$this->load->view('user/beforeLogin_layout',array('content' => $content));
				return;
			}

			$loginResult = $this->User_model->check_login(
				$this->input->post('email'),
				$this->input->post('password')
			);

			//Emailアドレスが間違った場合
			if($loginResult == 'wrongEmail')
			{
				$content = $this->load->view(
					'user/loginForm',
					array('email_wrong_mess' => 'Emailアドレスが間違ってしまいました',
					TRUE)
				);
				$this->load->view('user/beforeLogin_layout',array('content' => $content));
				return;
			}
			
			//パスワードが間違った場合
			if ($loginResult === 'wrongPassword')
			{
				$content = $this->load->view(
					'user/loginForm',
					array('password_wrong_mess' => 'パスワードが間違ってしまいました',
					TRUE)
				);
				$this->load->view('user/beforeLogin_layout',array('content' => $content));
				return;
			}

			//ログインが成功の場合
			$this->session->set_userdata(
				'logged_in',
				array('username' => $loginResult->name,
					'email' => $loginResult->email,
					'userID' => $loginResult->id)
			);
			redirect('user/homepage');

			
		}

		//ユーザのログインしたあとのページ
		function homepage()
		{
			$userData = $this->session->userdata('logged_in');

			if($userData)
			{
				$this->load->model('Tweet_model');
				$this->load->helper('time');
				$data['userData'] = $userData;
				$data['newTweets'] = $this->Tweet_model->get_newTweets($userData['userID'],TWEETS_PER_PAGE,0);
				$data['tweetNum'] = $this->Tweet_model->get_tweetNums($userData['userID']);
				$data['pageNum'] = ceil($data['tweetNum']/TWEETS_PER_PAGE);
				$data1['content'] = $this->load->view('user/homepage',$data,TRUE);
				$this->load->view('user/layout',$data1);
				return;
			}
			redirect('user/login');
		}

		function logout()
		{
			$this->session->unset_userdata('logged_in');
			redirect('user/login');
		}


	}
	?>