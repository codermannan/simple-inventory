<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Billers extends MX_Controller {

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
| MODULE: 			Billers
| -----------------------------------------------------
| This is billers module controller file.
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
		
		$groups = array('owner', 'admin');
		if (!$this->ion_auth->in_group($groups))
		{
			$this->session->set_flashdata('message', $this->lang->line("access_denied"));
			$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			redirect('module=home', 'refresh');
		}
		
		$this->load->library('form_validation');
		$this->load->model('billers_model');

	}
	
   function index()
   {
	   
	  $data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
	  $data['success_message'] = $this->session->flashdata('success_message');
	  
      $meta['page_title'] = $this->lang->line("billers");
	  $data['page_title'] = $this->lang->line("billers");
      $this->load->view('commons/header', $meta);
      $this->load->view('content', $data);
      $this->load->view('commons/footer');
   }
	
	function getdatatableajax()
   {
 
	   $this->load->library('datatables');
	   $this->datatables
			->select("id, name, company, phone, email, city, country")
			->from("billers")
			->add_column("Actions", 
			"<center><a href='index.php?module=billers&amp;view=edit&amp;id=$1' class='tip' title='".$this->lang->line("edit_biller")."'><i class='icon-edit'></i></a> <a href='index.php?module=billers&amp;view=delete&amp;id=$1' onClick=\"return confirm('". $this->lang->line('alert_x_biller') ."')\" title='".$this->lang->line("delete_biller")."' class='tip'><i class='icon-trash'></i></a></center>", "id")
			->unset_column('id');
		
		
	   echo $this->datatables->generate();

   }
   
	function add()
	{

		
		//validate form input
		$this->form_validation->set_rules('name', $this->lang->line("name"), 'required|xss_clean');
		$this->form_validation->set_rules('email', $this->lang->line("email_address"), 'required|valid_email');
		$this->form_validation->set_rules('company', $this->lang->line("company"), 'required|xss_clean');
		$this->form_validation->set_rules('cf1', $this->lang->line("bcf1"), 'xss_clean');
		$this->form_validation->set_rules('cf2', $this->lang->line("bcf2"), 'xss_clean');
		$this->form_validation->set_rules('cf2', $this->lang->line("bcf3"), 'xss_clean');
		$this->form_validation->set_rules('cf4', $this->lang->line("bcf4"), 'xss_clean');
		$this->form_validation->set_rules('cf5', $this->lang->line("bcf5"), 'xss_clean');
		$this->form_validation->set_rules('cf6', $this->lang->line("bcf6"), 'xss_clean');
		$this->form_validation->set_rules('address', $this->lang->line("address"), 'required|xss_clean');
		$this->form_validation->set_rules('city', $this->lang->line("city"), 'required|xss_clean');
		$this->form_validation->set_rules('state', $this->lang->line("state"), 'required|xss_clean');
		$this->form_validation->set_rules('postal_code', $this->lang->line("postal_code"), 'required|xss_clean');
		$this->form_validation->set_rules('country', $this->lang->line("country"), 'required|xss_clean');
		$this->form_validation->set_rules('phone', $this->lang->line("phone"), 'required|xss_clean|min_length[9]|max_length[16]');
		$this->form_validation->set_rules('logo', $this->lang->line("logo"), 'xss_clean');
		$this->form_validation->set_rules('invoice_footer', $this->lang->line("invoice_footer"), 'xss_clean');
		
		
		if ($this->form_validation->run() == true)
		{
			$name = strtolower($this->input->post('name'));
			$email = $this->input->post('email');
			$company = $this->input->post('company');

			$data = array('name' => $this->input->post('name'),
				'email' => $this->input->post('email'),
				'company' => $this->input->post('company'),
				'cf1' => $this->input->post('cf1'),
				'cf2' => $this->input->post('cf2'),
				'cf3' => $this->input->post('cf3'),
				'cf4' => $this->input->post('cf4'),
				'cf5' => $this->input->post('cf5'),
				'cf6' => $this->input->post('cf6'),
				'address' => $this->input->post('address'),
				'city' => $this->input->post('city'),
				'state' => $this->input->post('state'),
				'postal_code' => $this->input->post('postal_code'),
				'country' => $this->input->post('country'),
				'phone' => $this->input->post('phone'),
				'logo' => $this->input->post('logo'),
				'invoice_footer' => $this->ion_auth->clear_tags($this->input->post('invoice_footer'))
			);
		}
		
		if ( $this->form_validation->run() == true && $this->billers_model->addBiller($name, $email, $company, $data))
		{  
			$this->session->set_flashdata('success_message', $this->lang->line("biller_added"));
			redirect("module=billers", 'refresh');
		}
		else
		{  
			$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));

			$data['name'] = array('name' => 'name',
				'id' => 'name',
				'type' => 'text',
				'value' => $this->form_validation->set_value('name'),
			);
			$data['email'] = array('name' => 'email',
				'id' => 'email',
				'type' => 'text',
				'value' => $this->form_validation->set_value('email'),
			);
			$data['company'] = array('name' => 'company',
				'id' => 'company',
				'type' => 'text',
				'value' => $this->form_validation->set_value('company'),
			);
			
			$data['address'] = array('name' => 'address',
				'id' => 'address',
				'type' => 'text',
				'value' => $this->form_validation->set_value('address'),
			);
			$data['city'] = array('name' => 'city',
				'id' => 'city',
				'type' => 'text',
				'value' => $this->form_validation->set_value('city'),
			);
			$data['state'] = array('name' => 'state',
				'id' => 'state',
				'type' => 'text',
				'value' => $this->form_validation->set_value('state'),
			);
			$data['postal_code'] = array('name' => 'postal_code',
				'id' => 'postal_code',
				'type' => 'text',
				'value' => $this->form_validation->set_value('postal_code'),
			);
			$data['country'] = array('name' => 'country',
				'id' => 'country',
				'type' => 'text',
				'value' => $this->form_validation->set_value('country'),
			);
			$data['phone'] = array('name' => 'phone',
				'id' => 'phone',
				'type' => 'text',
				'value' => $this->form_validation->set_value('phone'),
			);
			$data['logo'] = array('name' => 'logo',
				'id' => 'logo',
				'type' => 'select',
				'value' => $this->form_validation->set_value('logo'),
			);
			$data['invoice_footer'] = array('name' => 'invoice_footer',
				'id' => 'invoice_footer',
				'type' => 'text',
				'value' => $this->form_validation->set_value('invoice_footer'),
			);
		
		$data['logos'] = $this->billers_model->getLogoList();
		
		$meta['page_title'] = $this->lang->line("new_biller");
		$data['page_title'] = $this->lang->line("new_biller");
		$this->load->view('commons/header', $meta);
		$this->load->view('add', $data);
		$this->load->view('commons/footer');
		
		}
	}
	
	function edit($id = NULL)
	{
		if($this->input->get('id')) { $id = $this->input->get('id'); }


		//validate form input
		$this->form_validation->set_rules('name', $this->lang->line("name"), 'required|xss_clean');
		$this->form_validation->set_rules('email', $this->lang->line("email_address"), 'required|valid_email');
		$this->form_validation->set_rules('company', $this->lang->line("company"), 'required|xss_clean');
		$this->form_validation->set_rules('cf1', $this->lang->line("bcf1"), 'xss_clean');
		$this->form_validation->set_rules('cf2', $this->lang->line("bcf2"), 'xss_clean');
		$this->form_validation->set_rules('cf2', $this->lang->line("bcf3"), 'xss_clean');
		$this->form_validation->set_rules('cf4', $this->lang->line("bcf4"), 'xss_clean');
		$this->form_validation->set_rules('cf5', $this->lang->line("bcf5"), 'xss_clean');
		$this->form_validation->set_rules('cf6', $this->lang->line("bcf6"), 'xss_clean');
		$this->form_validation->set_rules('address', $this->lang->line("address"), 'required|xss_clean');
		$this->form_validation->set_rules('city', $this->lang->line("city"), 'required|xss_clean');
		$this->form_validation->set_rules('state', $this->lang->line("state"), 'required|xss_clean');
		$this->form_validation->set_rules('postal_code', $this->lang->line("postal_code"), 'required|xss_clean');
		$this->form_validation->set_rules('country', $this->lang->line("country"), 'required|xss_clean');
		$this->form_validation->set_rules('phone', $this->lang->line("phone"), 'required|xss_clean|min_length[9]|max_length[16]');
		$this->form_validation->set_rules('logo', $this->lang->line("logo"), 'xss_clean');
		$this->form_validation->set_rules('invoice_footer', $this->lang->line("invoice_footer"), 'xss_clean');
		
		if ($this->form_validation->run() == true)
		{

			$data = array('name' => $this->input->post('name'),
				'email' => $this->input->post('email'),
				'company' => $this->input->post('company'),
				'cf1' => $this->input->post('cf1'),
				'cf2' => $this->input->post('cf2'),
				'cf3' => $this->input->post('cf3'),
				'cf4' => $this->input->post('cf4'),
				'cf5' => $this->input->post('cf5'),
				'cf6' => $this->input->post('cf6'),
				'address' => $this->input->post('address'),
				'city' => $this->input->post('city'),
				'state' => $this->input->post('state'),
				'postal_code' => $this->input->post('postal_code'),
				'country' => $this->input->post('country'),
				'phone' => $this->input->post('phone'),
				'logo' => $this->input->post('logo'),
				'invoice_footer' => $this->ion_auth->clear_tags($this->input->post('invoice_footer'))
			);
		}
		
		if ( $this->form_validation->run() == true && $this->billers_model->updateBiller($id, $data))
		{ 
			$this->session->set_flashdata('success_message', $this->lang->line("biller_updated"));
			redirect("module=billers", 'refresh');
		}
		else
		{ 
			$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));

			
		$data['logos'] = $this->billers_model->getLogoList();
		$data['biller'] = $this->billers_model->getBillerByID($id);

		$meta['page_title'] = $this->lang->line("update_biller");
		$data['id'] = $id;
		$data['page_title'] = $this->lang->line("update_biller");
		$this->load->view('commons/header', $meta);
		$this->load->view('edit', $data);
		$this->load->view('commons/footer');
		
		}
	}
	
	function delete($id = NULL)
	{
		if (DEMO) {
			$this->session->set_flashdata('message', $this->lang->line("disabled_in_demo"));
			redirect('module=home', 'refresh');
		}
		
		if($this->input->get('id')) { $id = $this->input->get('id'); }
		if (!$this->ion_auth->in_group('owner'))
		{
			$this->session->set_flashdata('message', $this->lang->line("access_denied"));
			$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			redirect('module=home', 'refresh');
		}
		
		if ( $this->billers_model->deleteBiller($id) )
		{ 
			$this->session->set_flashdata('success_message', $this->lang->line("biller_deleted"));
			redirect("module=billers", 'refresh');
		}
		
	}
	
	
}

/* End of file billers.php */ 
/* Location: ./sma/modules/billers/controllers/billers.php */