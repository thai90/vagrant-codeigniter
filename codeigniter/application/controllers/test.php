<?php
//このクラスはテストの目的のみです、よまないでください
class Test extends CI_Controller
{

    protected $layout = 'layout';
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    protected function render($content)
    {
        $view_data = array ('content' => $content);
        $this->load->view($this->layout,$view_data);
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