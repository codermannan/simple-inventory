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

class Order_Model extends MY_Model
{
    public $_table_name;
    public $_order_by;
    public $_primary_key;


    public function get_all_product_info()
    {
        $this->db->select('tbl_product.*', false);
        $this->db->select('tbl_inventory.product_quantity, tbl_inventory.notify_quantity ', false);
        $this->db->from('tbl_product');
        $this->db->where('tbl_product.status', 1);
        $this->db->join('tbl_inventory', 'tbl_inventory.product_id  =  tbl_product.product_id ', 'left');
        $this->db->order_by('tbl_product.product_id', ' DESC');
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }

    function validate_add_cart_item($product_code){

        $this->db->select('tbl_product.*', false);
        $this->db->select('tbl_product_price.buying_price, tbl_product_price.selling_price ', false);

        $this->db->from('tbl_product');
        $this->db->where('tbl_product.product_code', $product_code);
        $this->db->join('tbl_product_price', 'tbl_product_price.product_id  =  tbl_product.product_id ', 'left');

        $query_result = $this->db->get();
        $result = $query_result->row();
        return $result;

    }

    public function get_tire_price($product_id, $qty)
    {
        $this->db->select('tbl_tier_price.*', false);
        $this->db->from('tbl_tier_price');
        $this->db->where('product_id', $product_id);
        $this->db->where('quantity_above <=', $qty);
        $this->db->order_by('quantity_above', 'DESC');
        $this->db->limit(1);
        $query_result = $this->db->get();
        $result = $query_result->row();
        return $result;
    }

    public function get_customer_details($customer_code)
    {
        $where = "customer_code = $customer_code OR phone = $customer_code ";

        $this->db->select('tbl_customer.*', false);
        $this->db->from('tbl_customer');
        $this->db->where($where);
        $query_result = $this->db->get();
        $result = $query_result->row();
        return $result;
    }

    public function get_all_order()
    {
        $this->db->select('tbl_invoice.*, tbl_order.*', false);
        $this->db->from('tbl_order');
        $this->db->join('tbl_invoice', 'tbl_invoice.order_id  =  tbl_order.order_id ', 'left');
        $this->db->order_by('tbl_order.order_id', ' DESC');
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }

    public function get_all_invoice()
    {
        $this->db->select('tbl_invoice.*, tbl_order.*', false);
        $this->db->from('tbl_invoice');
        $this->db->join('tbl_order', 'tbl_order.order_id  =  tbl_invoice.order_id ', 'left');
        $this->db->order_by('invoice_id', 'DESC');
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }
}
