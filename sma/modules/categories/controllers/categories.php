<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categories extends MX_Controller {

/*
| -----------------------------------------------------
| PRODUCT NAME: 	Trip Manager
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
| MODULE: 			Categories
| -----------------------------------------------------
| This is categories module controller file.
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
		$this->load->model('categories_model');
		$groups = array('owner', 'admin');
		if (!$this->ion_auth->in_group($groups))
		{
			$this->session->set_flashdata('message', $this->lang->line("access_denied"));
			$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			redirect('module=categories', 'refresh');
		}

	}
	
   function index()
   {
	   
	  $data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
	  $data['success_message'] = $this->session->flashdata('success_message');
	  	
      $meta['page_title'] = $this->lang->line("categories");
	  $data['page_title'] = $this->lang->line("categories");
      $this->load->view('commons/header', $meta);
      $this->load->view('index', $data);
      $this->load->view('commons/footer');
   }
   
   function getdatatableajax()
   {
 
	   $this->load->library('datatables');
	   $this->datatables
			->select("id, code, name")
			->from("categories")
			
			->add_column("Actions", 
			"<center><a href='index.php?module=categories&amp;view=subcategories&amp;parent_id=$1' class='tip' title='".$this->lang->line("list_subcategories")."'><i class=\"icon-list\"></i></a> <a href='index.php?module=categories&amp;view=edit&amp;id=$1' class='tip' title='".$this->lang->line("edit_category")."'><i class=\"icon-edit\"></i></a> <a href='index.php?module=categories&amp;view=delete&amp;id=$1' onClick=\"return confirm('". $this->lang->line('alert_x_category') ."')\" class='tip' title='".$this->lang->line("delete_category")."'><i class=\"icon-remove\"></i></a></center>", "id");
		
	   echo $this->datatables->generate();

   }
	
	function add()
	{

		//validate form input
		$this->form_validation->set_rules('code', $this->lang->line("category_code"), 'trim|is_unique[categories.code]|required|xss_clean');
		$this->form_validation->set_rules('name', $this->lang->line("name"), 'required|min_length[3]|xss_clean');
	
		if ($this->form_validation->run() == true)
		{
			$name = strtolower($this->input->post('name'));
			$code = $this->input->post('code');
			
		}
		
		if ( $this->form_validation->run() == true && $this->categories_model->addCategory($name, $code))
		{ //check to see if we are creating the customer
			//redirect them back to the admin page
			$this->session->set_flashdata('success_message', $this->lang->line("category_added"));
			redirect("module=categories", 'refresh');
		}
		else
		{ //display the create customer form
			//set the flash data error message if there is one
			$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));

			$data['name'] = array('name' => 'name',
				'id' => 'name',
				'type' => 'text',
				'value' => $this->form_validation->set_value('name'),
			);
			$data['code'] = array('name' => 'code',
				'id' => 'code',
				'type' => 'text',
				'value' => $this->form_validation->set_value('code'),
			);
			
		
		$meta['page_title'] = $this->lang->line("new_category");
		$data['page_title'] = $this->lang->line("new_category");
		$this->load->view('commons/header', $meta);
		$this->load->view('add', $data);
		$this->load->view('commons/footer');
		
		}
	}
	
	function edit($id = NULL)
	{
		if($this->input->get('id')) { $id = $this->input->get('id'); }

		//validate form input
		$this->form_validation->set_rules('code', $this->lang->line("category_code"), 'trim|required|xss_clean');
		$pr_details = $this->categories_model->getCategoryByID($id);
			if ($this->input->post('code') != $pr_details->code) {
				$this->form_validation->set_rules('code', $this->lang->line("category_code"), 'is_unique[categories.code]');
			}
		$this->form_validation->set_rules('name', $this->lang->line("category_name"), 'required|min_length[3]|xss_clean');
		
		if ($this->form_validation->run() == true)
		{

			$data = array('code' => $this->input->post('code'),
				'name' => $this->input->post('name')
				
			);
		}
		
		if ( $this->form_validation->run() == true && $this->categories_model->updateCategory($id, $data))
		{ //check to see if we are updateing the customer
			//redirect them back to the admin page
			$this->session->set_flashdata('success_message', $this->lang->line("category_updated"));
			redirect("module=categories", 'refresh');
		}
		else
		{ //display the update form
			//set the flash data error message if there is one
			$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));

			$data['name'] = array('name' => 'name',
				'id' => 'name',
				'type' => 'text',
				'value' => $this->form_validation->set_value('name'),
			);
			$data['code'] = array('name' => 'code',
				'id' => 'code',
				'type' => 'text',
				'value' => $this->form_validation->set_value('code'),
			);
			
			
		$data['category'] = $this->categories_model->getCategoryByID($id);
		
		$meta['page_title'] = $this->lang->line("update_category");
		$data['id'] = $id;
		$data['page_title'] = $this->lang->line("update_category");
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
			redirect('module=categories', 'refresh');
		}
		if($this->categories_model->getSubCategoriesByCategoryID($id)) {
			$this->session->set_flashdata('message', $this->lang->line("category_has_subcategory"));
			redirect("module=categories", 'refresh');
		}
		if ( $this->categories_model->deleteCategory($id) )
		{ //check to see if we are deleting the customer
			//redirect them back to the admin page
			$this->session->set_flashdata('success_message', $this->lang->line("category_deleted"));
			redirect("module=categories", 'refresh');
		}
		
	}
	
	function subcategories()
   {
	   
	  if($this->input->get('parent_id')) { $data['parent_id'] = $this->input->get('parent_id'); } else { $data['parent_id'] = NULL; }
	  
	  $data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
	  $data['success_message'] = $this->session->flashdata('success_message');
	  	
      $meta['page_title'] = $this->lang->line("subcategories");
	  $data['page_title'] = $this->lang->line("subcategories");
      $this->load->view('commons/header', $meta);
      $this->load->view('subcategories', $data);
      $this->load->view('commons/footer');
   }
   
   function getsubcategory()
   {
 		if($this->input->get('parent_id')) { $parent_id = $this->input->get('parent_id'); } else { $parent_id = NULL; } 
		
	   $this->load->library('datatables');
	   $this->datatables
			->select("subcategories.id as id, subcategories.code as scode, subcategories.name as sname, categories.name as cname")
			->from("subcategories")
			->join('categories', 'categories.id = subcategories.category_id', 'left')
			->group_by('subcategories.id');
			
		if($parent_id) { $this->datatables->where('category_id', $parent_id); }	
			
		$this->datatables->add_column("Actions", 
			"<center>			<a href='index.php?module=categories&amp;view=edit_subcategory&amp;id=$1' class='tip' title='".$this->lang->line("edit_subcategory")."'><i class=\"icon-edit\"></i></a>
							    <a href='index.php?module=categories&amp;view=delete_subcategory&amp;id=$1' onClick=\"return confirm('". $this->lang->line('alert_x_subcategory') ."')\" class='tip' title='".$this->lang->line("delete_subcategory")."'><i class=\"icon-remove\"></i></a></center>", "id")
			->unset_column('id');
		
		
	   echo $this->datatables->generate();

   }
   
	function add_subcategory()
	{
		

		//validate form input
		$this->form_validation->set_rules('category', $this->lang->line("category"), 'required|xss_clean');
		$this->form_validation->set_rules('code', $this->lang->line("subcategory_code"), 'trim|is_unique[categories.code]|is_unique[subcategories.code]|required|xss_clean');
		$this->form_validation->set_rules('name', $this->lang->line("subcategory_name"), 'required|min_length[3]|xss_clean');
	
		if ($this->form_validation->run() == true)
		{
			$name = strtolower($this->input->post('name'));
			$code = $this->input->post('code');
			$category = $this->input->post('category');
			
		}
		
		if ( $this->form_validation->run() == true && $this->categories_model->addSubCategory($category, $name, $code))
		{ //check to see if we are creating the customer
			//redirect them back to the admin page
			$this->session->set_flashdata('success_message', $this->lang->line("subcategory_added"));
			redirect("module=categories&view=subcategories", 'refresh');
		}
		else
		{ //display the create customer form
			//set the flash data error message if there is one
			$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));

			$data['name'] = array('name' => 'name',
				'id' => 'name',
				'type' => 'text',
				'value' => $this->form_validation->set_value('name'),
			);
			$data['code'] = array('name' => 'code',
				'id' => 'code',
				'type' => 'text',
				'value' => $this->form_validation->set_value('code'),
			);
			
		$data['categories'] = $this->categories_model->getAllCategories();
		$meta['page_title'] = $this->lang->line("new_subcategory");
		$data['page_title'] = $this->lang->line("new_subcategory");
		$this->load->view('commons/header', $meta);
		$this->load->view('add_subcategory', $data);
		$this->load->view('commons/footer');
		
		}
	}
	
	function edit_subcategory($id = NULL)
	{
		if($this->input->get('id')) { $id = $this->input->get('id'); }

		//validate form input
		$this->form_validation->set_rules('category', $this->lang->line("category"), 'required|xss_clean');
		$this->form_validation->set_rules('code', $this->lang->line("subcategory_code"), 'trim|required|xss_clean');
		$pr_details = $this->categories_model->getSubCategoryByID($id);
			if ($this->input->post('code') != $pr_details->code) {
				$this->form_validation->set_rules('code', $this->lang->line("subcategory_code"), 'is_unique[categories.code]');
			}
		$this->form_validation->set_rules('name', $this->lang->line("subategory_name"), 'required|min_length[3]|xss_clean');
		
		if ($this->form_validation->run() == true)
		{

			$data = array(
				'category' => $this->input->post('category'),
				'code' => $this->input->post('code'),
				'name' => $this->input->post('name')
				
			);
		}
		
		if ( $this->form_validation->run() == true && $this->categories_model->updateSubCategory($id, $data))
		{ //check to see if we are updateing the customer
			//redirect them back to the admin page
			$this->session->set_flashdata('success_message', $this->lang->line("subcategory_updated"));
			redirect("module=categories&view=subcategories", 'refresh');
		}
		else
		{ //display the update form
			//set the flash data error message if there is one
			$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));

			$data['name'] = array('name' => 'name',
				'id' => 'name',
				'type' => 'text',
				'value' => $this->form_validation->set_value('name'),
			);
			$data['code'] = array('name' => 'code',
				'id' => 'code',
				'type' => 'text',
				'value' => $this->form_validation->set_value('code'),
			);
			
			
		$data['subcategory'] = $this->categories_model->getSubCategoryByID($id);
		$data['categories'] = $this->categories_model->getAllCategories();
		$meta['page_title'] = $this->lang->line("update_subcategory");
		$data['id'] = $id;
		$data['page_title'] = $this->lang->line("update_subcategory");
		$this->load->view('commons/header', $meta);
		$this->load->view('edit_subcategory', $data);
		$this->load->view('commons/footer');
		
		}
	}
	
	function delete_subcategory($id = NULL)
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
			redirect('module=categories&view=subcategories', 'refresh');
		}
		
		if ( $this->categories_model->deleteSubCategory($id) )
		{  
			$this->session->set_flashdata('success_message', $this->lang->line("subcategory_deleted"));
			redirect("module=categories&view=subcategories", 'refresh');
		}
		
	}
	
}

/* End of file categories.php */ 
/* Location: ./sma/modules/categories/controllers/categories.php */