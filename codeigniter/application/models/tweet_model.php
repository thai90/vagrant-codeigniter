<?php
	class Tweet_model extends CI_model
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->database();
		}

		function get_newTweets ($limit = 0,$offset = 0)
		{	
			$this->db->select('tweet.*, user.name, user.email');
			$this->db->from('tweet');
			$this->db->join('user','tweet.user_id = user.id');
			$this->db->order_by('tweet.post_time','DESC');
			$this->db->limit($limit,$offset);
			$query = $this->db->get();
			return $query->result_array();

		}

		function get_tweetNums()
		{
			return $this->db->count_all('tweet');
		}

		function updateNewTweet($userID,$newTweet)
		{
			$data=array('user_id'=>$userID,'tweet'=>$newTweet,'post_time'=>date('Y-m-d H:i:s'));
			$this->db->insert('tweet',$data);
		}
	}
?>