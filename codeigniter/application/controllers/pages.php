<?php
	class Pages extends CI_Controller {

		  public function __construct(){
        parent::__construct();
    }

		public function view ($page = 'home')
		{
			$this->load->model("User_model");
			if(!file_exists(APPPATH.'views/pages/'.$page.'.php'))
			{
				show_404();
			}
			$data['title']= ucfirst($page);
			$data['allUsers']=$this->User_model->listAll();
			$this->load->view('pages/'.$page,$data);
		}

		public function register ()
		{
				$this->load->view('pages/register');
		}
	}
?>