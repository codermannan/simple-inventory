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

class Customer_Model extends MY_Model
{
    public $_table_name;
    public $_order_by;
    public $_primary_key;

    public function get_customer_info($id = null) // this function is to get all customer info from tbl customer and tbl_customer_group
    {
        $this->db->select('tbl_customer.*', false);
        $this->db->select('tbl_customer_group.*', false);
        $this->db->from('tbl_customer');
        $this->db->join('tbl_customer_group', 'tbl_customer_group.customer_group_id  =  tbl_customer.customer_group_id ', 'left');
        if (!empty($id)) {
            //specific customer information needed
            $this->db->where('tbl_customer.customer_id', $id);
            $query_result = $this->db->get();
            $result = $query_result->row();
        } else {
            //all customer information needed
            $query_result = $this->db->get();
            $result = $query_result->result();
        }

        return $result;
    }

    public function get_new_customer_detail()
    {
        // this function is to get all customer info blank
        $post = new stdClass();
        $post->customer_group_id = '';
        $post->customer_id = '';
        $post->customer_first_name = '';
        $post->customer_last_name = '';
        $post->company_name = '';
        $post->tax_vat_number = '';
        $post->customer_group_name = '';
        $post->address = '';
        $post->postcode = '';
        $post->city = '';
        $post->country = '';
        $post->phone = '';
        $post->mobile = '';
        $post->fax = '';
        $post->email = '';

        return $post;
    }
}
