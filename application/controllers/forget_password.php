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

class Forget_Password extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('global_model');
    }

    public function index(){

        $data['title'] = 'Forget Password';  // title page

        $data['subview'] = $this->load->view('forget_password', $data, true);
        $this->load->view('forget_password', $data);
    }

    public function retrieve_password(){
        $username = $this->input->post('username');
        $email = $this->input->post('email');

        $this->global_model->_table_name = 'tbl_user'; //table name
        $this->global_model->_order_by = 'user_id';

        $employee = $this->global_model->get_by(array('user_name' => $username, 'email' => $email ), true);

        if(!empty($employee))
        {
        $random = $this->generateRandomString();
        $pdata['password'] = $this->encryption->hash($random);

            $this->db->where('user_id', $employee->user_id);
            $this->db->update('tbl_user', $pdata);

            $data['password'] =$random;
            $data['username'] =$employee->user_name;
            $data['name'] =$employee->name;


            $company_info = $this->session->userdata('business_info');
            
            if(empty($company_info)){
                $company_email = 'info@codeslab.net';
                $company_name = 'Codes Lab';
            }else{
                $company_email = $company_info->email;
                $company_name = $company_info->company_name;
            }

            $from = array($company_email, $company_name);
            //sender email
            $to = $employee->email;
            //subject
            $subject = 'New Password';
            // set view page
            $view_page = $this->load->view('retrive_password_email', $data, true);

            $send_email = $this->mail->sendEmail($from, $to, $subject, $view_page);
            if ($send_email) {
                $this->session->set_flashdata('error', 'New password successfully send, please check your email.');
                redirect('forget_password', 'refresh');
            }

        }else{
            $this->session->set_flashdata('error', 'That Username/email combination does not exist');
            redirect('forget_password', 'refresh');
        }

    }

    function generateRandomString($length = 8) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}