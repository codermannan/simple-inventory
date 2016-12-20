<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/*
 *	@author : CodesLab
 *  @support: support@codeslab.net
 *	date	: 05 June, 2015
 *	Easy Inventory
 *	http://www.codeslab.net
 *  version: 1.0
 */

class Login extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {


        $data['title'] = 'User Login';
        $data['subview'] = $this->load->view('login', $data, true);
        $this->load->view('login', $data);

        $dashboard = $this->session->userdata('url');

        $this->login_model->loggedin() == false || redirect($dashboard);

        $rules = $this->login_model->rules;
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() == true) {
            // We can login and redirect
            if ($this->login_model->login() == true) {
                redirect($dashboard);
            } else {
                $this->session->set_flashdata('error', 'That Username/password combination does not exist');
                redirect('login', 'refresh');
            }
        }
    }


    public function logout()
    {
        $this->login_model->logout();
        redirect('login');
    }

}
