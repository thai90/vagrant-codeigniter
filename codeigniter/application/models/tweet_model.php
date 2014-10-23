<?php
class Tweet_model extends CI_model
{
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    function get_newTweets ($userID, $limit = 0,$offset = 0){
        //タイミングに関するヘルパーをロード
        $this->db->select('tweet.*, user.name, user.email');
        $this->db->from('tweet');
        $this->db->where('tweet.user_id',$userID);
        $this->db->join('user','tweet.user_id = user.id');
        $this->db->order_by('tweet.post_time','DESC');
        $this->db->limit($limit,$offset);
        $query = $this->db->get();
        $resultArr = $query->result_array();
        $size = sizeof($resultArr);
        return $resultArr;
    }

    function get_tweetNums($userID){
        $this->db->from('tweet');
        $this->db->where('user_id',$userID);
        return $this->db->count_all_results();
    }

    function updateNewTweet($userID,$newTweet){
        $this->load->helper('time');
        $data=array('user_id'=>$userID,'tweet'=>$newTweet,'post_time'=>date('Y-m-d H:i:s'));
        $this->db->insert('tweet',$data);
        $query = $this->db->get_where('tweet',array('user_id' => $userID, 'post_time' => $data['post_time']));
        $result_array =  $query->result_array();
        foreach ($result_array as $row){
            return $row;
        }
    }

    function deleteTweet($tweetID){
        $this->db->where('id',$tweetID);
        return $this->db->delete('tweet');
    }
}
?>