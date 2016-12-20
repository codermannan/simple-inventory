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

class Customer extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('customer_model');
        $this->load->model('global_model');

        $this->load->helper('ckeditor');
        $this->data['ckeditor'] = array(
            'id' => 'ck_editor',
            'path' => 'asset/js/ckeditor',
            'config' => array(
                'toolbar' => 'Full',
                'width' => '100%',
                'height' => '150px',
            ),
        );

    }



    /*** Add Customer ***/
    public function add_customer($id = null)
    {
        $this->tbl_customer('customer_id');

        if ($id) {
            $data['customer'] = $this->global_model->get_by(array('customer_id'=>$id), true);
            if(empty($data['customer'])){
                $type = 'error';
                $message = 'There is no Record Found!';
                set_message($type, $message);
                redirect('admin/customer/manage_customer');
            }
        }


        $data['code'] = $data['code'] = rand(10000000, 99999);

        $data['title'] = 'Add Customer';  // title page
        $data['editor'] = $this->data;
        $data['subview'] = $this->load->view('admin/customer/add_customer', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    /*** Save Customer ***/
    public function save_customer($id = null)
    {
        $data = $this->customer_model->array_from_post(array(
            'customer_name',
            'email',
            'phone',
            'address',
            'discount'
             ));

        $this->tbl_customer('customer_id');
        $customer_id = $this->global_model->save($data, $id);

        if(empty($id)) {
            $customer_code['customer_code'] = $this->input->post('customer_code').$customer_id;
            $this->global_model->save($customer_code, $customer_id);
        }

        $type = 'success';
        $message = 'Customer Information Saved Successfully!';
        set_message($type, $message);
        redirect('admin/customer/manage_customer');
    }

    /*** Manage Customer ***/
    public function manage_customer()
    {

        $this->tbl_customer('customer_id');
        $data['customer'] = $this->global_model->get();
        $data['title'] = 'Manage Customer';
        $data['subview'] = $this->load->view('admin/customer/manage_customer', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    /*** Delete Customer ***/
    public function delete_customer($id=null)
    {
        $this->customer_model->_table_name = 'tbl_customer';
        $this->customer_model->_primary_key = 'customer_id';
        $this->customer_model->delete($id);  // delete by id

        // massage for employee
        $type = 'error';
        $message = 'Customer Successfully Deleted from System';
        set_message($type, $message);
        redirect('admin/customer/manage_customer');
    }

    /*** Check Duplicate Customer  ***/
    public function check_customer_phone($phone=null, $customer_id = null)
    {
        $this->tbl_customer('customer_id');
        if(empty($customer_id))
        {
            $result = $this->global_model->get_by(array('phone'=>$phone), true);
        }else{
            //$result = $this->customer_model->check_customer_phone($phone, $customer_id);
            $result = $this->global_model->get_by(array('phone'=>$phone, 'customer_id !=' => $customer_id ), true);
        }

        if($result)
        {
            echo 'This phone number already exist!';
        }

    }
}
