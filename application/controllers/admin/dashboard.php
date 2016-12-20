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

class Dashboard extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('dashboard_model');
        $this->load->model('global_model');

    }

    /*** Dashboard ***/
    public function index()
    {
        // recent order
        $data['order_info'] = $this->dashboard_model->recently_added_order();

        //recently added product
        $data['product_info'] = $this->dashboard_model->recently_added_product();

        //total order
        $this->tbl_order('order_id');
        $data['total_order'] = count($this->global_model->get());

        //total invoice
        $this->tbl_invoice('invoice_id');
        $data['total_invoice'] = count($this->global_model->get());

        //total customer
        $this->tbl_customer('customer_id');
        $data['total_customer'] = count($this->global_model->get());

        //total product
        $this->tbl_product('product_id');
        $data['total_product'] = count($this->global_model->get());

        //total buying, selling, tax
        $data['total'] = $this->dashboard_model->get_revenue();

        //discount
        $data['discount'] = $this->dashboard_model->get_discount();


        $data['year'] = date('Y');

        $data['yearly_sales_report'] = $this->get_yearly_sales_report($data['year']);  // get yearly report
        $data['title'] = 'Easy Inventory'; // title
        $data['subview'] = $this->load->view('admin/dashboard', $data, true); // sub view
        $this->load->view('admin/_layout_main', $data); // main page
    }

    /*** Get Yearly Report ***/
    public function get_yearly_sales_report($year)
    {

        for ($i = 1; $i <= 12; $i++) {
            if ($i >= 1 && $i <= 9) {
                $start_date = $year.'-'.'0'.$i.'-'.'01';
                $end_date = $year.'-'.'0'.$i.'/'.'31';
            } else {
                $start_date = $year.'-'.$i.'-'.'01';
                $end_date = $year.'-'.$i.'-'.'31';
            }

            $get_all_report[$i] = $this->dashboard_model->get_all_report_by_date($start_date, $end_date);
        }

        return $get_all_report;
    }

    /*** Login ***/
    public function login()
    {
        $data['title'] = 'Login';
        $this->load->view('admin/login');
    }


}
