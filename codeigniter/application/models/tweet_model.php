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
			$sql = "SELECT tweet.*,user.name,user.email 
				FROM user,tweet
				WHERE user.id = tweet.user_id
				ORDER BY tweet.post_time DESC
				LIMIT ".$limit." OFFSET ".$offset."";
			$query = $this->db->query($sql);
			return $query->result_array();

		}

		function get_tweetNums()
		{
			return $this->db->count_all('tweet');
		}
	}
?>