<?php
class Tweet extends CI_controller {
    public function __construct(){
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Tweet_model');
    }

    /*ユーザの新ツイートをデータベースに記入、
    そして記入成功の場合、タイミングプロセスしたその新ツイート
    をレスポンスとしてクライアントに送る
    */
    function updateNewTweet(){
        if($this->input->post('userID') && $this->input->post('newTweet')){
            $this->load->helper('time');
            $this->load->driver('cache');
            $newTweetInfo = $this->Tweet_model->updateNewTweet($this->input->post('userID'),
                $this->input->post('newTweet'));

            //キャッシュ更新
            $this->cache->memcached->delete(CACHED_TWEETS_ID);
            $tweets = $this->Tweet_model->get_newTweets($this->input->post('userID'), TWEETS_PER_PAGE, 0);
            $this->cache->memcached->save(CACHED_TWEETS_ID, $tweets);

            $currentUserInfo = $this->session->userdata('logged_in');
            $newTweetInfo['username'] = $currentUserInfo['username'];
            $newTweetInfo['post_time'] = convertTime($newTweetInfo['post_time']);
            $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($newTweetInfo));
        }
    }

    /*ユーザは「もっと見る」ボタンをクリックして、
    次のツイートをデータベースからロードして、
    クライアントにロードしたツイートをリターン*/
    function loadNextPage(){
        $page = $this->input->post('page');
        $this->load->helper('time');
        if($page){
            $userData = $this->session->userdata('logged_in');
            $tweetArr = $this->Tweet_model->get_newTweets($userData['userID'], TWEETS_PER_PAGE, $page*TWEETS_PER_PAGE);
            $tweetArr = convertTimeArr($tweetArr, 'post_time');
            $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($tweetArr));
        }
    }

    function deleteTweet(){
        $this->load->driver('cache');
        $tweetID = $this->input->post('tweetID');
        if($tweetID){
            $this->load->model('Tweet_model');
            $this->cache->memcached->delete(CACHED_TWEETS_ID);
            $this->output->set_output($this->Tweet_model->deleteTweet($tweetID));
        }
    }
}
?>