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

class Dashboard_Model extends MY_Model
{
    public $_table_name;
    public $_order_by;
    public $_primary_key;


    public function recently_added_product()
    {
        $this->db->select('tbl_product.*', false);
        $this->db->select('tbl_product_price.selling_price, tbl_product_image.filename', false);
        $this->db->from('tbl_product');
        $this->db->join('tbl_product_price', 'tbl_product_price.product_id  =  tbl_product.product_id ', 'left');
        $this->db->join('tbl_product_image', 'tbl_product_image.product_id  =  tbl_product.product_id ', 'left');
        $this->db->order_by('product_id', 'DESC');
        $this->db->limit(4);
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }

    public function recently_added_order()
    {
        $this->db->select('tbl_order.*', false);
        $this->db->from('tbl_order');
        $this->db->order_by('order_id', 'DESC');
        $this->db->limit(6);
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }

    /***  create view total revenue,cost,tax from tbl_order_details  ***/
    public function get_revenue()
    {
        $this->db->select_sum('tbl_order_details.buying_price');
        $this->db->select_sum('tbl_order_details.selling_price');
        $this->db->select_sum('tbl_order_details.product_tax');
        $this->db->from('tbl_order');
        $this->db->where('tbl_order.order_status', 2);
        $this->db->join('tbl_order_details', 'tbl_order_details.order_id  =  tbl_order.order_id ', 'left');

        $query_result = $this->db->get();
        $result = $query_result->row();
        return $result;
    }

    public function get_discount(){
        $this->db->select_sum('discount_amount');
        $this->db->where('tbl_order.order_status', 2);
        $query_result = $this->db->get('tbl_order');
        $result = $query_result->row();
        return $result;
    }

    /***  create view yearly report by start date to end date  ***/
    public function get_all_report_by_date($start_date, $end_date)
    {
        $this->db->select('tbl_invoice.*', false);
        $this->db->select_sum('tbl_order.grand_total', false);
        $this->db->from('tbl_invoice');
        $this->db->where('invoice_date >=', $start_date);
        $this->db->where('invoice_date <=', $end_date);
        $this->db->join('tbl_order', 'tbl_order.order_id  =  tbl_invoice.order_id ', 'left');
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }


}