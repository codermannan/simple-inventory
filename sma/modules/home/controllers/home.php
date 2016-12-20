<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

/*
| -----------------------------------------------------
| PRODUCT NAME: 	STOCK MANAGER ADVANCE 
| -----------------------------------------------------
| AUTHER:			MIAN SALEEM 
| -----------------------------------------------------
| EMAIL:			saleem@tecdiary.com 
| -----------------------------------------------------
| COPYRIGHTS:		RESERVED BY TECDIARY IT SOLUTIONS
| -----------------------------------------------------
| WEBSITE:			http://tecdiary.net
| -----------------------------------------------------
|
| MODULE: 			Homepage / Dashboard
| -----------------------------------------------------
| This is homepage module controller file.
| -----------------------------------------------------
*/

	 
	function __construct()
	{
		parent::__construct();
		
		// check if user logged in 
		if (!$this->ion_auth->logged_in())
	  	{
			redirect('auth/login');
	  	}
		$this->load->library('form_validation');
		//$this->security->csrf_verify(); 
		$this->load->model('home_model');	
		
	}
	
   function index()
   {
	   
	   $this->form_validation->set_rules('comment', $this->lang->line("comment"), 'xss_clean');
	  
	  if ( $this->form_validation->run() == true && $this->home_model->updateComment($comment) )
		{ 
				$this->session->set_flashdata('success_message', $this->lang->line("comment_updated"));
				redirect("module=home", 'refresh');
	
		}
		else
		{ 

	  
	  $data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
	  $data['success_message'] = $this->session->flashdata('success_message');
	  	   
	  $data['com'] = $this->home_model->getComment();	
	  $data['monthly_sales'] = $this->home_model->getChartData();
	  $data['topProducts'] = $this->home_model->topProducts();
	  $data['stock'] = $this->home_model->getStockValue();
	  	
      $meta['page_title'] = $this->lang->line("welcome")." ".SITE_NAME."!";
	  $data['page_title'] = $this->lang->line("welcome")." ".SITE_NAME."!";
      $this->load->view('commons/header', $meta);
      $this->load->view('content', $data);
      $this->load->view('commons/footer');
   	}
   }
   
   function update_comment()
   {
	   $this->form_validation->set_rules('comment', $this->lang->line("comment"), 'xss_clean');
	  
	  if ($this->form_validation->run() == true)
		{ 
			$comment = $this->ion_auth->clear_tags($this->input->post('comment'));
		}
	  
	  if ( $this->form_validation->run() == true && $this->home_model->updateComment($comment) )
		{ 
				$this->session->set_flashdata('success_message', $this->lang->line("comment_updated"));
				redirect("module=home", 'refresh');
	
		}
   }
   
   function image_upload()
   {
	 
			if(DEMO) { 
				$error = array('error' => $this->lang->line('disabled_in_demo'));
				echo json_encode($error);
				exit;
			}
		
		$this->security->csrf_verify(); 	
		if(isset($_FILES['file'])){
				
		$this->load->library('upload_photo');
		
		$config['upload_path'] = 'assets/uploads/images/'; 
		$config['allowed_types'] = 'gif|jpg|png|pjpeg'; 
		$config['max_size'] = '500';
		$config['max_width'] = '800';
		$config['max_height'] = '800';
		$config['overwrite'] = FALSE; 
		
			$this->upload_photo->initialize($config);
			
			if( ! $this->upload_photo->do_upload('file')){
			
				$error = $this->upload_photo->display_errors();
				$error = array('error' => $error);
				echo json_encode($error);
				exit;

			} 
		
		$photo = $this->upload_photo->file_name;
		$array = array(
        	'filelink' => base_url().'assets/uploads/images/'.$photo
		);
	
		echo stripslashes(json_encode($array));
		exit;
		
		} else {
			$error = array('error' => 'No file selected to upload!');
			echo json_encode($error);
			exit;
		}
   	  
   }
   
   function language($lang = false){
	    if($this->input->get('lang')){ $lang = $this->input->get('lang'); }
		$this->load->helper('cookie');
		$folder = 'sma/language/';
		$languagefiles = scandir($folder);
		if(in_array($lang, $languagefiles)){
		//setcookie("sma_language", $lang, '31536000');
		$cookie = array(
                   'name'   => 'language',
                   'value'  => $lang,
                   'expire' => '31536000',
				   'prefix' => 'sma_',
				   'secure' => false
               );
 
		$this->input->set_cookie($cookie);
		}
		redirect($_SERVER["HTTP_REFERER"]); 
	}

}

/* End of file home.php */ 
/* Location: ./sma/modules/home/controllers/home.php */