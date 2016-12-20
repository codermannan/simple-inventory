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

class Product_Model extends MY_Model
{
    public $_table_name;
    public $_order_by;
    public $_primary_key;


    public function get_all_sub_category()
    { // get category info by category name from tbl_subcategory with join tbl_category by root category id
        $this->db->select('tbl_subcategory.*', false);
        $this->db->select('tbl_category.category_name', false);
        $this->db->from('tbl_subcategory');
        $this->db->join('tbl_category', 'tbl_category.category_id  =  tbl_subcategory.category_id ', 'left');
        $query_result = $this->db->get();
        $result = $query_result->result();

        return $result;
    }

    public function get_all_category_by_id($category_id)
    {
        $this->db->select('tbl_subcategory.*', false);
        $this->db->select('tbl_category.category_name', false);
        $this->db->from('tbl_subcategory');
        $this->db->join('tbl_category', 'tbl_category.category_id  =  tbl_subcategory.category_id ', 'left');
        $this->db->where('tbl_category.category_id', $category_id);
        $query_result = $this->db->get();
        $result = $query_result->result();

        return $result;
    }

    // * me
    public function get_all_product_info()
    {
        $this->db->select('tbl_product.*', false);
        $this->db->select('tbl_product_image.filename', false);
        $this->db->select('tbl_subcategory.subcategory_name', false);
        $this->db->select('tbl_category.category_name', false);
        $this->db->select('tbl_inventory.product_quantity, tbl_inventory.notify_quantity ', false);
        $this->db->from('tbl_product');
        $this->db->join('tbl_product_image', 'tbl_product_image.product_id  =  tbl_product.product_id ', 'left');
        $this->db->join('tbl_subcategory', 'tbl_subcategory.subcategory_id  =  tbl_product.subcategory_id ', 'left');
        $this->db->join('tbl_category', 'tbl_category.category_id  =  tbl_subcategory.category_id ', 'left');
        $this->db->join('tbl_inventory', 'tbl_inventory.product_id  =  tbl_product.product_id ', 'left');

        $this->db->order_by('tbl_product.product_id', ' DESC');
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }
    public function get_product_information_by_id($id)
    {
        $this->db->select('tbl_product.*', false);
        $this->db->select('tbl_product_image.filename', false);
        $this->db->select('tbl_subcategory.subcategory_name', false);
        $this->db->select('tbl_category.category_name', false);
        $this->db->select('tbl_product_price.buying_price, tbl_product_price.selling_price ', false);
        $this->db->select('tbl_special_offer.offer_price, tbl_special_offer.start_date, tbl_special_offer.end_date  ', false);
        $this->db->select('tbl_inventory.product_quantity, tbl_inventory.notify_quantity ', false);
        $this->db->from('tbl_product');
        $this->db->where('tbl_product.product_id', $id);
        $this->db->join('tbl_product_image', 'tbl_product_image.product_id  =  tbl_product.product_id ', 'left');
        $this->db->join('tbl_subcategory', 'tbl_subcategory.subcategory_id  =  tbl_product.subcategory_id ', 'left');
        $this->db->join('tbl_category', 'tbl_category.category_id  =  tbl_subcategory.category_id ', 'left');
        $this->db->join('tbl_product_price', 'tbl_product_price.product_id  =  tbl_product.product_id ', 'left');
        $this->db->join('tbl_special_offer', 'tbl_special_offer.product_id  =  tbl_product.product_id ', 'left');
        $this->db->join('tbl_inventory', 'tbl_inventory.product_id  =  tbl_product.product_id ', 'left');

        $this->db->order_by('tbl_product.product_id', ' DESC');
        $query_result = $this->db->get();
        $result = $query_result->row();
        return $result;
    }

    public function get_damage_product($id)
    {
        //$this->db->select('tbl_damage_product.*', false);
        $this->db->select('tbl_product.subcategory_id, tbl_subcategory.subcategory_name, tbl_category.category_name ', false);
        $this->db->from('tbl_product');
        //$this->db->join('tbl_product', 'tbl_product.product_id  =  tbl_damage_product.product_id ', 'left');
        $this->db->join('tbl_subcategory', 'tbl_subcategory.subcategory_id  =  tbl_product.subcategory_id ', 'left');
        $this->db->join('tbl_category', 'tbl_category.category_id  =  tbl_subcategory.category_id ', 'left');
        $this->db->where('tbl_product.product_id', $id);
        $query_result = $this->db->get();
        $result = $query_result->row();

        return $result;
    }





}
