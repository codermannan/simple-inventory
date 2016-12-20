<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('ion_auth');
		$this->load->library('session');
		$this->load->library('form_validation');
		$this->load->helper('url');
		// Load MongoDB library instead of native db driver if required
		$this->config->item('use_mongodb', 'ion_auth') ?
			$this->load->library('mongo_db') :
			$this->load->database();
			
	}

	//redirect if needed, otherwise display the user list
	function index()
	{
		if (!$this->ion_auth->logged_in())
		{
			redirect('module=auth&view=login');
		} else {
			redirect('module=home');
		}
	}

	function users() {

		if ( ! $this->ion_auth->in_group('owner'))
		{
			$this->session->set_flashdata('message', $this->lang->line("access_denied"));
			redirect('module=home', 'refresh');
		}
		
		$this->user_check();
		
		$data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
		$data['success_message'] = $this->session->flashdata('success_message');
		
			//list the users
			$data['users'] = $this->ion_auth->users()->result();
			foreach ($data['users'] as $k => $user)
			{
				$data['users'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
			}
			
			$meta['page_title'] = 'Users';
			$this->load->view('commons/header', $meta);

			$this->load->view('index', $data);
			
			$this->load->view('commons/footer');
			
	}
	//log the user in
	function login()
	{
		$data['title'] = "Login";

		//validate form input
		$this->form_validation->set_rules('identity', 'Identity', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if ($this->form_validation->run() == true)
		{ //check to see if the user is logging in
			//check for "remember me"
			$remember = (bool) $this->input->post('remember');

			if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember))
			{ //if the login is successful
				//redirect them back to the home page
				$this->session->set_flashdata('success_message', $this->ion_auth->messages());
				redirect('module=home', 'refresh');
			}
			else
			{ //if the login was un-successful
				//redirect them back to the login page
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect('module=auth&view=login', 'refresh'); //use redirects instead of loading views for compatibility with MY_Controller libraries
			}
		}
		else
		{  //the user is not logging in so display the login page
			//set the flash data error message if there is one
			$data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$data['success_message'] = $this->session->flashdata('success_message');
			$data['identity'] = array('name' => 'identity',
				'id' => 'identity',
				'type' => 'text',
				'value' => $this->form_validation->set_value('identity'),
			);
			$data['password'] = array('name' => 'password',
				'id' => 'password',
				'type' => 'password',
			);

			$this->load->view('auth/login', $data);
		}
	}

	//log the user out
	function logout()
	{
		$data['title'] = $this->lang->line("logout");

		//log the user out
		$logout = $this->ion_auth->logout();
		
		$this->session->set_flashdata('success_message', $this->lang->line('logout_successful'));
		redirect('module=auth&view=login', 'refresh');
	}

	//change password
	function change_password()
	{
			if(DEMO) { 
				$this->session->set_flashdata('message', $this->lang->line('disabled_in_demo'));
				redirect("module=home", 'refresh');
			}
		
		$this->user_check();
		
		$this->form_validation->set_rules('old', $this->lang->line("old_pw"), 'required');
		$this->form_validation->set_rules('new', $this->lang->line("new_pw"), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
		$this->form_validation->set_rules('new_confirm', $this->lang->line("confirm_pw"), 'required');

		$user = $this->ion_auth->user()->row();

		if ($this->form_validation->run() == false)
		{ //display the form
			//set the flash data error message if there is one
			$data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$data['success_message'] = $this->session->flashdata('success_message');
			$data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
			$data['old_password'] = array(
				'name' => 'old',
				'id'   => 'old',
				'type' => 'password',
			);
			$data['new_password'] = array(
				'name' => 'new',
				'id'   => 'new',
				'type' => 'password',
				'pattern' => '^.{'.$data['min_password_length'].'}.*$',
			);
			$data['new_password_confirm'] = array(
				'name' => 'new_confirm',
				'id'   => 'new_confirm',
				'type' => 'password',
				'pattern' => '^.{'.$data['min_password_length'].'}.*$',
			);
			$data['user_id'] = array(
				'name'  => 'user_id',
				'id'    => 'user_id',
				'type'  => 'hidden',
				'value' => $user->id,
			);

			//render
			$meta['page_title'] = $this->lang->line("change_password");
			$this->load->view('commons/header', $meta);

			$this->load->view('auth/change_password', $data);
			
			$this->load->view('commons/footer');
			
		}
		else
		{
			$identity = $this->session->userdata($this->config->item('identity', 'ion_auth'));

			$change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));

			if ($change)
			{ //if the password was successfully changed
				$this->session->set_flashdata('success_message', $this->ion_auth->messages());
				redirect('module=auth&view=change_password', 'refresh');
				//$this->logout();
			}
			else
			{
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect('module=auth&view=change_password', 'refresh');
			}
		}
	}

	//forgot password
	function forgot_password()
	{
		$this->form_validation->set_rules('email', $this->lang->line("email_address"), 'required');
		if ($this->form_validation->run() == false)
		{
			//setup the input
			$data['email'] = array('name' => 'email',
				'id' => 'email',
			);
			//set any errors and display the form
			$data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$data['success_message'] = $this->session->flashdata('success_message');
			
			$this->load->view('auth/forgot_password', $data);
		}
		else
		{
			//run the forgotten password method to email an activation code to the user
			$forgotten = $this->ion_auth->forgotten_password($this->input->post('email'));

			if ($forgotten)
			{ //if there were no errors
				$this->session->set_flashdata('success_message', $this->ion_auth->messages());
				redirect("module=auth&view=login", 'refresh'); //we should display a confirmation page here instead of the login page
			}
			else
			{
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect("module=auth&view=forgot_password", 'refresh');
			}
		}
	}

	//reset password - final step for forgotten password
	public function reset_password($code = NULL)
	{
		$code = $this->input->get('code');
		if (!$code)
		{
			show_404();
		}

		$user = $this->ion_auth->forgotten_password_check($code);

		if ($user)
		{  //if the code is valid then display the password reset form

			$this->form_validation->set_rules('new', $this->lang->line("new_pw"), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
			$this->form_validation->set_rules('new_confirm', $this->lang->line("confirm_pw"), 'required');

			if ($this->form_validation->run() == false)
			{//display the form
				//set the flash data error message if there is one
				$data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
				$data['success_message'] = $this->session->flashdata('success_message');
				$data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
				$data['new_password'] = array(
					'name' => 'new',
					'id'   => 'new',
				'type' => 'password',
					'pattern' => '^.{'.$data['min_password_length'].'}.*$',
				);
				$data['new_password_confirm'] = array(
					'name' => 'new_confirm',
					'id'   => 'new_confirm',
					'type' => 'password',
					'pattern' => '^.{'.$data['min_password_length'].'}.*$',
				);
				$data['user_id'] = array(
					'name'  => 'user_id',
					'id'    => 'user_id',
					'type'  => 'hidden',
					'value' => $user->id,
				);
				$data['csrf'] = $this->_get_csrf_nonce();
				$data['code'] = $code;

				//render
				$this->load->view('auth/reset_password', $data);
			}
			else
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $user->id != $this->input->post('user_id')) {

					//something fishy might be up
					$this->ion_auth->clear_forgotten_password_code($code);

					show_404();

				} else {
					// finally change the password
					$identity = $user->{$this->config->item('identity', 'ion_auth')};

					$change = $this->ion_auth->reset_password($identity, $this->input->post('new'));

					if ($change)
					{ //if the password was successfully changed
						$this->session->set_flashdata('success_message', $this->ion_auth->messages());
						$this->logout();
					}
					else
					{
						$this->session->set_flashdata('message', $this->ion_auth->errors());
						redirect('module=auth&view=reset_password&code=' . $code, 'refresh');
					}
				}
			}
		}
		else
		{ //if the code is invalid then send them back to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("module=auth&view=forgot_password", 'refresh');
		}
	}


	//activate the user
	function activate($id, $code=false)
	{
		if ($code !== false)
			$activation = $this->ion_auth->activate($id, $code);
		else if ($this->ion_auth->is_admin())
			$activation = $this->ion_auth->activate($id);

		if ($activation)
		{
			//redirect them to the auth page
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			redirect("module=auth", 'refresh');
		}
		else
		{
			//redirect them to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("module=auth&view=forgot_password", 'refresh');
		}
	}

	//deactivate the user
	function deactivate($id = NULL)
	{
		$id = $this->config->item('use_mongodb', 'ion_auth') ? (string) $id : (int) $id;

		$this->load->library('form_validation');
		$this->form_validation->set_rules('confirm', 'confirmation', 'required');
		$this->form_validation->set_rules('id', 'user ID', 'required|alpha_numeric');

		if ($this->form_validation->run() == FALSE)
		{
			// insert csrf check
			$data['csrf'] = $this->_get_csrf_nonce();
			$data['user'] = $this->ion_auth->user($id)->row();
			
			$meta['page_title'] = "Deactivate User";
			$this->load->view('commons/header', $meta);
			$this->load->view('auth/deactivate_user', $data);
			$this->load->view('commons/footer');
		}
		else
		{
			// do we really want to deactivate?
			if ($this->input->post('confirm') == 'yes')
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
				{
					show_404();
				}

				// do we have the right userlevel?
				if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
				{
					$this->ion_auth->deactivate($id);
				}
			}

			//redirect them back to the auth page
			redirect('module=auth', 'refresh');
		}
	}

	//create a new user
	function create_user()
	{

		if ( ! $this->ion_auth->in_group('owner'))
		{
			$this->session->set_flashdata('message', $this->lang->line("access_denied"));
			redirect('module=home', 'refresh');
		}
		
		$this->form_validation->set_message('is_natural_no_zero', 'The %s field is required.');		
		//validate form input
		$this->form_validation->set_rules('first_name', $this->lang->line("first_name"), 'required|xss_clean');
		$this->form_validation->set_rules('last_name', $this->lang->line("last_name"), 'required|xss_clean');
		$this->form_validation->set_rules('role', $this->lang->line("user_role"), 'is_natural_no_zero|required|xss_clean');
		$this->form_validation->set_rules('email', $this->lang->line("email_address"), 'required|valid_email');
		$this->form_validation->set_rules('phone', $this->lang->line("phone"), 'required|xss_clean|min_length[9]|max_length[16]');
		$this->form_validation->set_rules('company', $this->lang->line("company"), 'required|xss_clean');
		$this->form_validation->set_rules('password', $this->lang->line("pw"), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
		$this->form_validation->set_rules('password_confirm', $this->lang->line("confirm_pw"), 'required');

		if ($this->form_validation->run() == true)
		{
			if(DEMO) { 
				$this->session->set_flashdata('message', $this->lang->line('disabled_in_demo'));
				redirect("module=home", 'refresh');
			}
			
			$username = strtolower($this->input->post('first_name')) . ' ' . strtolower($this->input->post('last_name'));
			$email = $this->input->post('email');
			$password = $this->input->post('password');

			$additional_data = array('first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'company' => $this->input->post('company'),
				'phone' => $this->input->post('phone'),
			);
			
			$group = array($this->input->post('role')); 
			/*
			$check_groups = array($owner, $admin, $purchaser, $salesman);
			$groups = array_filter($check_groups, 'strlen');
			if(empty($groups)) {
				$groups = array('viewer');
			}*/
			
			//$data['groups'] = $group;
		}
		
		
		if ($this->form_validation->run() == true && $this->ion_auth->register($username, $password, $email, $additional_data, $group))
		{ //check to see if we are creating the user
			//redirect them back to the admin page
			$this->session->set_flashdata('success_message', $this->lang->line("user_added"));
			redirect("module=auth&view=users", 'refresh');
		}
		else
		{ //display the create user form
			//set the flash data error message if there is one
		
			$data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			
			$data['first_name'] = array('name' => 'first_name',
				'id' => 'first_name',
				'type' => 'text',
				'value' => $this->form_validation->set_value('first_name'),
			);
			$data['last_name'] = array('name' => 'last_name',
				'id' => 'last_name',
				'type' => 'text',
				'value' => $this->form_validation->set_value('last_name'),
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
			$data['phone'] = array('name' => 'phone',
				'id' => 'phone',
				'type' => 'text',
				'value' => $this->form_validation->set_value('phone'),
			);
			$data['password'] = array('name' => 'password',
				'id' => 'password',
				'type' => 'password',
				'value' => $this->form_validation->set_value('password'),
			);
			$data['password_confirm'] = array('name' => 'password_confirm',
				'id' => 'password_confirm',
				'type' => 'password',
				'value' => $this->form_validation->set_value('password_confirm'),
			);
			
			$meta['page_title'] = $this->lang->line("new_user");
			$data['title'] = $this->lang->line("new_user");
			$this->load->view('commons/header', $meta);

			$this->load->view('auth/create_user', $data);
			
			$this->load->view('commons/footer');
			
		}
	}

	function _get_csrf_nonce()
	{
		$this->load->helper('string');
		$key = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);

		return array($key => $value);
	}

	function _valid_csrf_nonce()
	{
		if ($this->input->post($this->session->flashdata('csrfkey')) !== FALSE &&
				$this->input->post($this->session->flashdata('csrfkey')) == $this->session->flashdata('csrfvalue'))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	public function user_check()
	{
		if (!$this->ion_auth->logged_in())
		{
			$this->session->set_flashdata('success_message', "Login Required!");
			redirect('module=auth&view=login', 'refresh');
		}
	}
	
	
	function edit_user($id = NULL)
	{
		if($this->input->get('id')) { $id = $this->input->get('id'); }
		
		if ( ! $this->ion_auth->in_group('owner'))
		{
			$this->session->set_flashdata('message', $this->lang->line("access_denied"));
			redirect('module=home', 'refresh');
		}
		

		$this->form_validation->set_message('is_natural_no_zero', 'The %s field is required.');
		//validate form input
		$this->form_validation->set_rules('first_name', $this->lang->line("first_name"), 'required|xss_clean');
		$this->form_validation->set_rules('last_name', $this->lang->line("last_name"), 'required|xss_clean');
		$this->form_validation->set_rules('role', $this->lang->line("user_role"), 'is_natural_no_zero|required|xss_clean');
		$this->form_validation->set_rules('email', $this->lang->line("email_address"), 'required|valid_email');
		$this->form_validation->set_rules('phone', $this->lang->line("phone"), 'required|xss_clean|min_length[9]|max_length[16]');
		$this->form_validation->set_rules('company', $this->lang->line("company"), 'required|xss_clean');
		$this->form_validation->set_rules('password', $this->lang->line("pw"), 'min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]|xss_clean');
		$this->form_validation->set_rules('password_confirm', $this->lang->line("confirm_pw"), 'xss_clean');

		if ($this->form_validation->run() == true)
		{
			if(DEMO) { 
				$this->session->set_flashdata('message', $this->lang->line('disabled_in_demo'));
				redirect("module=home", 'refresh');
			}
			
			$email = $this->input->post('email');
			if($this->input->post('password')){
			$password = $this->input->post('password');
			} else {
				$password = NULL;
			}
			$additional_data = array('first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'company' => $this->input->post('company'),
				'phone' => $this->input->post('phone'),
			);
			$group = $this->input->post('role'); 
			
			
		}
		
		
		if ($this->form_validation->run() == true && $this->ion_auth_model->updateUser($id, $email, $password, $additional_data, $group))
		{ //check to see if we are creating the user
			//redirect them back to the admin page
			$this->session->set_flashdata('success_message', $this->lang->line("user_updated"));
			redirect("module=auth&view=users", 'refresh');
		}
		else
		{ //display the create user form
			//set the flash data error message if there is one
		
			$data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			
			$data['first_name'] = array('name' => 'first_name',
				'id' => 'first_name',
				'type' => 'text',
				'value' => $this->form_validation->set_value('first_name'),
			);
			$data['last_name'] = array('name' => 'last_name',
				'id' => 'last_name',
				'type' => 'text',
				'value' => $this->form_validation->set_value('last_name'),
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
			$data['phone'] = array('name' => 'phone',
				'id' => 'phone',
				'type' => 'text',
				'value' => $this->form_validation->set_value('phone'),
			);
			$data['password'] = array('name' => 'password',
				'id' => 'password',
				'type' => 'password',
				'value' => $this->form_validation->set_value('password'),
			);
			$data['password_confirm'] = array('name' => 'password_confirm',
				'id' => 'password_confirm',
				'type' => 'password',
				'value' => $this->form_validation->set_value('password_confirm'),
			);
			
		
		$data['user'] = $this->ion_auth_model->getUserByID($id);
		$data['group'] = $this->ion_auth_model->getUserGroupByUserID($id);
		

		$meta['page_title'] = $this->lang->line("update_user");
		$data['id'] = $id;
		$data['page_title'] = $this->lang->line("update_user");
		$this->load->view('commons/header', $meta);
		$this->load->view('auth/edit_user', $data);
		$this->load->view('commons/footer');
		
		}
	}
	
	function delete_user($id = NULL)
	{
		if($this->input->get('id')) { $id = $this->input->get('id'); }
		if(DEMO) { 
				$this->session->set_flashdata('message', $this->lang->line('disabled_in_demo'));
				redirect("module=home", 'refresh');
			}
		
		if ( ! $this->ion_auth->in_group('owner'))
		{
			$this->session->set_flashdata('message', $this->lang->line("access_denied"));
			redirect('module=home', 'refresh');
		}
		
		if ( $this->ion_auth_model->deleteUser($id) )
		{
			$this->session->set_flashdata('success_message', $this->lang->line("user_deleted"));
			redirect("module=auth&view=users", 'refresh');
		}
		
	}

}

/* End of file auth.php */ 
/* Location: ./sma/modules/auth/controllers/auth.php */