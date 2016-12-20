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

class Global_Controller extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('global_model');
    }


    public function check_existing_user_name($user_name=null, $user_id = null)
    {
        if(!empty($user_name)) {
            $result = $this->global_model->check_user_name($user_name, $user_id);
            if ($result) {
                echo 'This User Name is Exist!';
            }
        }
    }
}
