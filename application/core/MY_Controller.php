<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

session_start();

/*
 *	@author : CodesLab
 *  @support: support@codeslab.net
 *	date	: 05 June, 2015
 *	Easy Inventory
 *	http://www.codeslab.net
 *  version: 1.0
 */

class MY_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('login_model');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->model('global_model');


        // Login check
        $exception_uris = array(
            'login',
            'login/logout',
        );
        if (in_array(uri_string(), $exception_uris) == false) {
            if ($this->login_model->loggedin() == false) {
                redirect('login');
            }
        }




    }
}
