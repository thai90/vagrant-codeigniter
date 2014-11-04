<?php
class Tweet_model extends CI_model
{
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function isTweetInCache($tweetID)
    {
        $this->load->driver('cache');
        $cachedTweets = $this->cache->memcached->get(CACHED_TWEETS_ID);
        if(!$cachedTweets){
            return false;
        }
        foreach($cachedTweets as $item){
            if($item['id'] == $tweetID){
                return true;
            }
        }
        return false;
    }

    function get_newTweets ($userID, $limit = 0, $offset = 0){
        $this->load->driver('cache');
        if($offset == 0){
            $tweets = $this->cache->memcached->get(CACHED_TWEETS_ID);
            if($tweets){
                return $tweets;
            }
        }
        $this->db->select('tweet.*, user.name, user.email');
        $this->db->from('tweet');
        $this->db->where('tweet.user_id',$userID);
        $this->db->join('user','tweet.user_id = user.id');
        $this->db->order_by('tweet.post_time','DESC');
        $this->db->limit($limit,$offset);
        $query = $this->db->get();
        $resultArr = $query->result_array();
        if($offset == 0){
            $this->cache->memcached->save(CACHED_TWEETS_ID, $resultArr, CACHE_TIME);
        }
        return $resultArr;
    }

    function get_tweetNums($userID){
        $this->db->from('tweet');
        $this->db->where('user_id',$userID);
        return $this->db->count_all_results();
    }

    function updateNewTweet($userID,$newTweet){
        $this->load->driver('cache');
        $data = array('user_id' => $userID, 'tweet' => $newTweet, 'post_time' => date('Y-m-d H:i:s'));
        $this->db->insert('tweet',$data);
        $this->cache->memcached->delete(CACHED_TWEETS_ID);
        $tweetsToCache = $this->get_newTweets($userID, TWEETS_PER_PAGE, 0);
        $this->cache->memcached->save(CACHED_TWEETS_ID, $tweetsToCache, CACHE_TIME);
        $query = $this->db->get_where('tweet',array('user_id' => $userID, 'post_time' => $data['post_time']));
        $result_array =  $query->result_array();
        foreach ($result_array as $row){
            return $row;
        }
    }

    function deleteTweet($tweetID){
        $this->load->driver('cache');
        if($this->isTweetInCache($tweetID)){
            $this->cache->memcached->delete(CACHED_TWEETS_ID);
        }
        $this->db->where('id',$tweetID);
        return $this->db->delete('tweet');
    }
}
?>