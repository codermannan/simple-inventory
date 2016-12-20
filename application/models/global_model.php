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

class Global_Model extends MY_Model
{
    public $_table_name;
    public $_order_by;
    public $_primary_key;
    public $_order = '';

    public function get_last_id($table, $key, $id)
    {
        $this->db->select_max($key);
        $Q = $this->db->get($table);
        $row = $Q->row_array();
        $last_id = $row[$id];

        return $last_id;
    }

    public function get_all_sub_category_by_id($category_id)
    {
        $this->db->select('tbl_sub_category.*', false);
        $this->db->select('tbl_category.category_name', false);
        $this->db->from('tbl_sub_category');
        $this->db->join('tbl_category', 'tbl_category.category_id  =  tbl_sub_category.category_id ', 'left');
        $this->db->where('tbl_category.category_id', $category_id);
        $query_result = $this->db->get();
        $result = $query_result->result();

        return $result;
    }

    public function check_product_code($product_code, $product_id)
    {
        $this->db->select('tbl_product.*', false);
        $this->db->from('tbl_product');
        if (!empty($product_id)) {
            $this->db->where('product_id !=', $product_id);
        }
        $this->db->where('product_code', $product_code);
        $query_result = $this->db->get();
        $result = $query_result->row();

        return $result;
    }
    public function check_user_name($user_name, $user_id)
    {
        $this->db->select('tbl_user.*', false);
        $this->db->from('tbl_user');
        if ($user_id) {
            $this->db->where('user_id !=', $user_id);
        }
        $this->db->where('user_name', $user_name);
        $query_result = $this->db->get();
        $result = $query_result->row();

        return $result;
    }

    public function get_product_bellow_qty($product_id, $product_quantity)
    {
            $this->db->select('tbl_inventory.*', false);
            $this->db->select('tbl_product.product_name, tbl_product.product_code, tbl_product_image.filename', false);
            $this->db->from('tbl_inventory');
            $this->db->where('tbl_inventory.product_id', $product_id);
            $this->db->where('tbl_inventory.notify_quantity >=', $product_quantity);

            $this->db->join('tbl_product', 'tbl_product.product_id  =  tbl_inventory.product_id ', 'left');
            $this->db->join('tbl_product_image', 'tbl_product_image.product_id  =  tbl_inventory.product_id ', 'left');

            $query_result = $this->db->get();
            $result= $query_result->row();
            return $result;

    }
}
