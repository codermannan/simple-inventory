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

class Tax_Model extends MY_Model
{
    public $_table_name;
    public $_order_by;
    public $_primary_key;

    public function get_new_tax_rate_info()
    {
        $post = new stdClass();
        $post->rate_name = '';
        $post->rate = '';

        return $post;
    }
    public function get_new_tax_rule_info()
    {
        $post = new stdClass();
        $post->tax_group_id = '';
        $post->tax_rate_id = '';
        $post->rule_name = '';

        return $post;
    }

    public function get_tax_rule_info($id = null)
    {
        // this function is to get all tax info if id exist then row wise else result

        $this->db->select('tbl_tax_rule.*', false);
        $this->db->select('tbl_tax_rate.*', false);
        $this->db->select('tbl_tax_group.*', false);
        $this->db->from('tbl_tax_rule');
        $this->db->join('tbl_tax_rate', 'tbl_tax_rate.tax_rate_id  =  tbl_tax_rule.tax_rate_id ', 'left');
        $this->db->join('tbl_tax_group', 'tbl_tax_group.tax_group_id  =  tbl_tax_rule.tax_group_id ', 'left');
        if (!empty($id)) { //specific tax rule information needed
            $this->db->where('tbl_tax_rule.tax_rule_id', $id);
            $query_result = $this->db->get();
            $result = $query_result->row();
        } else {
            //all tax rule information needed
            $query_result = $this->db->get();
            $result = $query_result->result();
        }

        return $result;
    }
}
