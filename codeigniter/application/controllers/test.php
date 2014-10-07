<?php
	class Test extends CI_Controller
	{
		public function __construct(){
			parent::__construct();
			$this->load->database();
		}

		function insertData()
		{
			$data = array(
				'user_id'=>13,
				'tweet'=>'リアルワルード会社は面白い会社である',
				'post_time'=>date('Y-m-d H:i:s',strtotime('2014-10-05 9:15:21')));
			$count = 10;
			while($count > 0)
			{
				$this->db->insert('tweet',$data);
				$count--;
			}
			echo 'Insert data done!';
		}
	}
	
?>