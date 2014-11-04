<?php
class UnitTest extends CI_Controller {

    //ツイーター読み込み件数を１０件と設定
    const LIMIT = 10;

    //sessionへのユーザIDの登録
    const USER_ID = 15;

    public function __construct(){
        parent::__construct();
        $this->load->model('Tweet_model');
        $this->load->model('User_model');
        $this->load->library('unit_test');
        $this->load->driver('cache');
    }

    public function index(){
        //---- User_model に関するテスト ----

        //insertテスト
        $test_insert = $this->User_model->insert(
            array('name' => 'takahashi',
                  'password' => md5('123456'),
                  'email' => 'takahashi@email.com'
            )
        );

        $data['insert'] = array(
            $this->unit->run($test_insert, 'is_object', '新規ユーザが登録できる')
        );

        //check_loginテスト
        $test_check_login_1 = $this->User_model->check_login('thai@email.com', md5('123456'));
        $test_check_login_2 = $this->User_model->check_login('wrongEmail@email.com',md5('password'));
        $data['check_login'] = array (
            $this->unit->run($test_check_login_1, 'is_object', 'DBに存在しているEmailでログインしたら、成功'),
            $this->unit->run($test_check_login_2, false, 'DBに存在しないEmailでログインしたら、失敗')
        );


        //---- Tweet_modelに関するテスト ----

        //get_newTweetsテスト
        $test_get_newTweets = $this->Tweet_model->get_newTweets(self::USER_ID, self::LIMIT, 0);
        $data['get_newTweets'] = array(
            $this->unit->run($test_get_newTweets, 'is_array', 'ツイートを読み出すことができる')
        );
        //get_TweetNumsテスト
        $test_get_TweetNums = $this->Tweet_model->get_TweetNums(self::USER_ID);
        $data['get_TweetNums'] = array(
            $this->unit->run($test_get_TweetNums, 'is_int', 'ツイートの件数を読み込むことができる')
        );

        //updateNewTweetテスト
        $test_updateNewTweet = $this->Tweet_model->updateNewTweet(self::USER_ID, '新なツイート');
        $data['updateNewTweet'] = array(
            $this->unit->run($test_updateNewTweet, 'is_array', '新なツイートを追加することができる')
        );

        //deleteTweetsテスト
        $test_deleteTweet = $this->Tweet_model->deleteTweet(288);
        $data['deleteTweet'] = array(
            $this->unit->run($test_deleteTweet, true, 'ツイートを削除することができる')
        );

        //isTweetInCacheテスト
        $test_isTweetInCache = $this->Tweet_model->isTweetInCache(292);
        $data['isTweetInCache'] = array($this->unit->run($test_isTweetInCache, true, 'IDの２9２のツイートはキャッシュにある'));
        $this->load->view('test/index', $data);
    }
}
?>