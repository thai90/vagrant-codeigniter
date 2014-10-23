<?php
class User extends CI_Controller
{
    private $obj;
    public function __construct(){
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
    }

    private function cacheFirstTweets($cachedID, $tweets, $liveTime){
        $this->load->driver('cache');
        return $this->cache->memcached->save($cachedID, $tweets, $liveTime);
    }

    private function getFirstTweets($cachedID, $userID, $tweetNum, $offset, $liveTime, $timeIndexName){
        $this->load->driver('cache');
        $this->load->helper('time');
        $tweets = $this->cache->memcached->get($cachedID);
        if($tweets){
            return convertTimeArr($tweets, $timeIndexName);
        }
        $this->load->model('Tweet_model');
        $tweets = $this->Tweet_model->get_newTweets($userID, $tweetNum, $offset);
        $this->cacheFirstTweets($cachedID, $tweets, $liveTime);
        return convertTimeArr($tweets, $timeIndexName);
    }

    function test(){
       $this->load->helper('time');
       $data[0]['post_time'] = '2014-10-10 14:05:34';
       $data[1]['post_time'] = '2014-10-15 14:05:34';
       $data = convertTimeArr($data, 'post_time');
       print_r($data);
    }

    //登録機能
    function register(){
        $this->load->model('User_model');
        $this->load->helper(array('form'));
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');
        if($this->form_validation->run('signUp') == false){
            $content = $this->load->view('user/registerForm', null, true);
            $this->load->view('user/beforeLogin_layout', array('content' => $content));
            return;
        }
        $newRecord['name'] = $this->input->post('username');
        $newRecord['password'] = $this->input->post('password');
        $newRecord['email'] = $this->input->post('email');
        $newUser = $this->User_model->insert($newRecord);
        if($newUser != false){
            $this->session->set_userdata('logged_in', array(
                    'userID' => $newUser->id,
                    'username' => $newUser->name,
                    'email' => $user->email
                    ));
            $this->session->set_flashdata('registerSuccess','登録成功、あなたは今新しいツイートを投稿できるようになります');
            redirect('/user/homepage');
        }
    }

    //ログイン機能
    function login(){
        if($this->session->userdata('logged_in')){
            redirect('/user/homepage','refresh');
        }
        $this->load->model('User_model');
        $this->load->helper(array('form'));
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<p style="color:red">','</p>');
        if($this->form_validation->run('login') ==  false){
            $content = $this->load->view('user/loginForm',null,true);
            $this->load->view('user/beforeLogin_layout',array('content' => $content));
            return;
        }
        $loginResult = $this->User_model->check_login(
            $this->input->post('email'),
            $this->input->post('password')
            );

        //ログインが失敗だった場合
        if($loginResult == false){
            $content = $this->load->view(
                'user/loginForm',
                array('loginFailedMess' => 'Emailアドレスかパスワードが間違ったのでログインできません',true)
                );
            $this->load->view('user/beforeLogin_layout',array('content' => $content));
            return;
        }

        //ログインが成功の場合
        $this->session->set_userdata(
            'logged_in',array(
                'username' => $loginResult->name,
                'userID' => $loginResult->id
                )
            );
        redirect('user/homepage');
    }

      //ユーザのログインしたあとのページ
    function homepage(){
        $userData = $this->session->userdata('logged_in');
        if($userData){
            $this->load->model('Tweet_model');
            $data['userData'] = $userData;
            $data['newTweets'] = $this->getFirstTweets(CACHED_TWEETS_ID, $userData['userID'], TWEETS_PER_PAGE, 0, CACHE_TIME, 'post_time');
            $data['tweetNum'] = $this->Tweet_model->get_tweetNums($userData['userID']);
            $data['pageNum'] = ceil($data['tweetNum']/TWEETS_PER_PAGE);
            $renderData['content'] = $this->load->view('user/homepage', $data, true);
            $this->load->view('user/layout', $renderData);
            return;
        }
        redirect('user/login');
    }

    function logout(){
        $this->session->unset_userdata('logged_in');
        redirect('user/login');
    }
}
?>