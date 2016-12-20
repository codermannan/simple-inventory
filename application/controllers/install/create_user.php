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

class Create_User extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $installer = mysql_query('SELECT user_id FROM tbl_user');
        $item = mysql_fetch_assoc($installer);

        if(empty($item)){
            $this->load->view('install/create_user');
        }else{
            redirect(base_url(), 'refresh');
        }
    }

    public function save_user(){

        $data['name'] = $this->input->post('name');
        $data['user_name'] = $this->input->post('user_name');
        $data['email'] = $this->input->post('email');
        $data['flag'] = 1;
        $data['password'] = $this->encryption->hash($this->input->post('password'));

        $this->db->insert('tbl_user', $data);
        unset($_SESSION["install_flag"]);
        redirect(base_url(), 'refresh');

    }

}