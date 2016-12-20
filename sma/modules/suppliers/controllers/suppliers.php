<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Suppliers extends MX_Controller {

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
| MODULE: 			Suppliers
| -----------------------------------------------------
| This is suppliers module controller file.
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
		
		$groups = array('owner', 'admin', 'purchaser');
		if (!$this->ion_auth->in_group($groups))
		{
			$this->session->set_flashdata('message', $this->lang->line("access_denied"));
			$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			redirect('module=home', 'refresh');
		}
		
		$this->load->library('form_validation');
		$this->load->model('suppliers_model');


	}
	
   function index()
   {
		
	  $data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
	  $data['success_message'] = $this->session->flashdata('success_message');
	  
      $meta['page_title'] = $this->lang->line("suppliers");
	  $data['page_title'] = $this->lang->line("suppliers");
      $this->load->view('commons/header', $meta);
      $this->load->view('content', $data);
      $this->load->view('commons/footer');
   }
   
   function getdatatableajax()
   {
 
	   $this->load->library('datatables');
	   $this->datatables
			->select("id, name, company, phone, email, city, country")
			->from("suppliers")
			
			->add_column("Actions", 
			"<center><a href='index.php?module=suppliers&amp;view=edit&amp;id=$1' title='".$this->lang->line("edit_supplier")."' class='tip'><i class='icon-edit'></i></a> <a href='index.php?module=suppliers&amp;view=delete&amp;id=$1' onClick=\"return confirm('". $this->lang->line('alert_x_supplier') ."')\" title='".$this->lang->line("delete_supplier")."' class='tip'><i class='icon-trash'></i></a></center>", "id")
			->unset_column('id');
		
		
	   echo $this->datatables->generate();

   }
	
	function add()
	{
	
		//validate form input
		$this->form_validation->set_rules('name', $this->lang->line("name"), 'required|xss_clean');
		$this->form_validation->set_rules('email', $this->lang->line("email_address"), 'required|valid_email');
		$this->form_validation->set_rules('company', $this->lang->line("company"), 'required|xss_clean');
		$this->form_validation->set_rules('cf1', $this->lang->line("scf1"), 'xss_clean');
		$this->form_validation->set_rules('cf2', $this->lang->line("scf2"), 'xss_clean');
		$this->form_validation->set_rules('cf2', $this->lang->line("scf3"), 'xss_clean');
		$this->form_validation->set_rules('cf4', $this->lang->line("scf4"), 'xss_clean');
		$this->form_validation->set_rules('cf5', $this->lang->line("scf5"), 'xss_clean');
		$this->form_validation->set_rules('cf6', $this->lang->line("scf6"), 'xss_clean');
		$this->form_validation->set_rules('address', $this->lang->line("address"), 'required|xss_clean');
		$this->form_validation->set_rules('city', $this->lang->line("city"), 'required|xss_clean');
		$this->form_validation->set_rules('state', $this->lang->line("state"), 'required|xss_clean');
		$this->form_validation->set_rules('postal_code', $this->lang->line("postal_code"), 'required|xss_clean');
		$this->form_validation->set_rules('country', $this->lang->line("country"), 'required|xss_clean');
		$this->form_validation->set_rules('phone', $this->lang->line("phone"), 'required|xss_clean|min_length[9]|max_length[16]');


		
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
				'phone' => $this->input->post('phone')

			);
		}
		
		if ( $this->form_validation->run() == true && $this->suppliers_model->addSupplier($name, $email, $company, $data))
		{ 
			$this->session->set_flashdata('success_message', $this->lang->line("supplier_added"));
			redirect("module=suppliers", 'refresh');
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

			
		
		$meta['page_title'] = $this->lang->line("new_supplier");
		$data['page_title'] = $this->lang->line("new_supplier");
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
		$this->form_validation->set_rules('cf1', $this->lang->line("scf1"), 'xss_clean');
		$this->form_validation->set_rules('cf2', $this->lang->line("scf2"), 'xss_clean');
		$this->form_validation->set_rules('cf2', $this->lang->line("scf3"), 'xss_clean');
		$this->form_validation->set_rules('cf4', $this->lang->line("scf4"), 'xss_clean');
		$this->form_validation->set_rules('cf5', $this->lang->line("scf5"), 'xss_clean');
		$this->form_validation->set_rules('cf6', $this->lang->line("scf6"), 'xss_clean');
		$this->form_validation->set_rules('address', $this->lang->line("address"), 'required|xss_clean');
		$this->form_validation->set_rules('city', $this->lang->line("city"), 'required|xss_clean');
		$this->form_validation->set_rules('state', $this->lang->line("state"), 'required|xss_clean');
		$this->form_validation->set_rules('postal_code', $this->lang->line("postal_code"), 'required|xss_clean');
		$this->form_validation->set_rules('country', $this->lang->line("country"), 'required|xss_clean');
		$this->form_validation->set_rules('phone', $this->lang->line("phone"), 'required|xss_clean|min_length[9]|max_length[16]');

		
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
				'phone' => $this->input->post('phone')

			);
		}
		
		if ( $this->form_validation->run() == true && $this->suppliers_model->updateSupplier($id, $data))
		{  
			$this->session->set_flashdata('success_message', $this->lang->line("supplier_updated"));
			redirect("module=suppliers", 'refresh');
		}
		else
		{  
			$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));

		$data['supplier'] = $this->suppliers_model->getSupplierByID($id);
		
		$meta['page_title'] = $this->lang->line("update_supplier");
		$data['id'] = $id;
		$data['page_title'] = $this->lang->line("update_supplier");
		$this->load->view('commons/header', $meta);
		$this->load->view('edit', $data);
		$this->load->view('commons/footer');
		
		}
	}
	
	function add_by_csv()
	{
		
		$groups = array('owner', 'admin');
		if (!$this->ion_auth->in_group($groups))
		{
			$this->session->set_flashdata('message', $this->lang->line("access_denied"));
			$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			redirect('module=products', 'refresh');
		}
			
		$this->form_validation->set_rules('userfile', $this->lang->line("upload_file"), 'xss_clean');
		 
		if ($this->form_validation->run() == true)
		{
			
		if (DEMO) {
			$this->session->set_flashdata('message', $this->lang->line("disabled_in_demo"));
			redirect('module=home', 'refresh');
		}
		
		if ( isset($_FILES["userfile"])) /*if($_FILES['userfile']['size'] > 0)*/
		{
				
		$this->load->library('upload');
		
		$config['upload_path'] = 'assets/uploads/csv/'; 
		$config['allowed_types'] = 'csv'; 
		$config['max_size'] = '200';
		$config['overwrite'] = TRUE; 
		
			$this->upload->initialize($config);
			
			if( ! $this->upload->do_upload()){
			
				$error = $this->upload->display_errors();
				$this->session->set_flashdata('message', $error);
				redirect("module=suppliers&view=add_by_csv", 'refresh');
			} 
		
		$csv = $this->upload->file_name;
		
		$arrResult = array();
			$handle = fopen("assets/uploads/csv/".$csv, "r");
			if( $handle ) {
			while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
			$arrResult[] = $row;
			}
			fclose($handle);
			}
			$titles = array_shift($arrResult);
			
			$keys = array('name', 'email', 'phone', 'company', 'address', 'city', 'state', 'postal_code', 'country');
			
			$final = array();
					
					foreach ( $arrResult as $key => $value ) {
								$final[] = array_combine($keys, $value);
					}
			$rw = 2;
			foreach($final as $csv) {
				if($this->suppliers_model->getSupplierByEmail($csv['email'])) {
						$this->session->set_flashdata('message', $this->lang->line("check_supplier_email")." (".$csv['email']."). ".$this->lang->line("supplier_already_exist")." ".$this->lang->line("line_no")." ".$rw);
						redirect("module=suppliers&view=add_by_csv", 'refresh');
					}
				$rw++;
			}
		} 

		$final = $this->mres($final);
		//$data['final'] = $final;
		}
	
		if ( $this->form_validation->run() == true && $this->suppliers_model->add_suppliers($final))
		{ 
			$this->session->set_flashdata('success_message', $this->lang->line("suppliers_added"));
			redirect('module=suppliers', 'refresh');
		}
		else
		{  
		
			$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			
			$data['userfile'] = array('name' => 'userfile',
				'id' => 'userfile',
				'type' => 'text',
				'value' => $this->form_validation->set_value('userfile')
			);

		$meta['page_title'] = $this->lang->line("add_suppliers_by_csv");
		$data['page_title'] = $this->lang->line("add_suppliers_by_csv");
		$this->load->view('commons/header', $meta);
		$this->load->view('add_by_csv', $data);
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
		
		if ( $this->suppliers_model->deleteSupplier($id) )
		{  
			$this->session->set_flashdata('success_message', $this->lang->line("supplier_deleted"));
			redirect("module=suppliers", 'refresh');
		}
		
	}
	
	function mres($q) {
		if(is_array($q))
			foreach($q as $k => $v)
				$q[$k] = $this->mres($v); //recursive
		elseif(is_string($q))
			$q = mysql_real_escape_string($q);
		return $q;
	}
	
	
}