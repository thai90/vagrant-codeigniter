<?php
    class Tweet extends CI_controller {
        
        public function __construct()
        {
            parent::__construct();
            $this->load->library('session');
            $this->load->model('Tweet_model');
        }

        /*ユーザの新ツイートをデータベースに記入、
        そして記入成功の場合、タイミングプロセスしたその新ツイート
        をレスポンスとしてクライアントに送る
        */
        function updateNewTweet()
        {
            if($this->input->post('userID') && $this->input->post('newTweet'))
            {
                $newTweetInfo = $this->Tweet_model->updateNewTweet($this->input->post('userID'),
                    $this->input->post('newTweet'));
                $currentUserInfo = $this->session->userdata('logged_in');
                $newTweetInfo['username'] = $currentUserInfo['username'];
                echo json_encode($newTweetInfo);
            }
        }   

        function loadNextPage()
        {
            //ユーザに「もっと見る」ボタンをクリックされるかどうかチェック
            $page = $this->input->post('page');
            if($page)
            {
                $userData = $this->session->userdata('logged_in');
                $tweetArr = $this->Tweet_model->get_newTweets($userData['userID'],TWEETS_PER_PAGE,$page*TWEETS_PER_PAGE);
                echo json_encode($tweetArr);
            }
        }                 


    }
?>