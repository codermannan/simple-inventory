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

class Purchase extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('purchase_model');
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

    /*** Add Supplier ***/
    public function add_supplier($id = null)
    {
        $this->tbl_supplier('supplier_id');

        if ($id) {//condition check
            $result = $this->global_model->get_by(array('supplier_id' => $id), true);

            if ($result) {
                $data['supplier'] = $result;
            } else {
                //msg
                $type = 'error';
                $message = 'Sorry, No Record Found!';
                set_message($type, $message);
                redirect('admin/purchase/manage_supplier');
            }
        }

        // view page
        $data['title'] = 'Add New Supplier';
        $data['editor'] = $this->data;
        $data['subview'] = $this->load->view('admin/purchase/add_supplier', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    /*** Save Supplier ***/
    public function save_supplier($id = null)
    {
        $this->tbl_supplier('supplier_id');
        $data = $this->global_model->array_from_post(array('company_name', 'supplier_name' , 'email', 'address', 'phone'));

        $this->global_model->save($data, $id);
        //msg
        $this->message->save_success('admin/purchase/manage_supplier');

    }

    /*** Manage Supplier ***/
    public function manage_supplier($id = null)
    {
        $this->tbl_supplier('supplier_id', 'desc');
        $data['supplier'] = $this->global_model->get();
            // view page
        $data['title'] = 'Add New Supplier';
        $data['subview'] = $this->load->view('admin/purchase/manage_supplier', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    /*** Delete Supplier ***/
    public function delete_supplier($id)
    {
        $this->tbl_supplier('supplier_id');
        $this->global_model->delete($id);
        $this->message->delete_success('admin/purchase/manage_supplier');

    }

    /*** New Purchase  ***/
    public function new_purchase($flag = null)
    {
        if(empty($flag))
        {
            $this->cart->destroy();
        }
        $data['product'] = $this->purchase_model->get_all_product_info();
        $this->tbl_supplier('supplier_id');
        $data['supplier'] = $this->global_model->get();

        // view page
        $data['title'] = 'Add New Supplier';
        $data['subview'] = $this->load->view('admin/purchase/purchase', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    /*** Add to cart item ***/
    public function add_cart_item(){

        $this->purchase_model->validate_add_cart_item();

        if($this->purchase_model->validate_add_cart_item() == TRUE){
                redirect('admin/purchase/new_purchase/'.$flag = 'purchase');

        }
    }

    /*** Add new product add to cart ***/
    public function add_new_product_to_cart()
    {
        $product_name = $this->input->post('product_name');
        $qty = $this->input->post('qty');
        $price = $this->input->post('price');

       $id = rand(100, 99999);

        $data = array(
            'id' => 'sku-'.$id,
            'qty' => $qty,
            'price' => $price,
            'name' => $product_name,
            'tax'   => 'tax',
            'price_option' => 'price_option'

        );
        $this->cart->insert($data);

        if($this->input->post('ajax') != '1'){
            redirect('admin/purchase/new_purchase'); // If javascript is not enabled, reload the page with new data
        }else{
            echo 'true'; // If javascript is enabled, return true, so the cart gets updated
        }
    }

    /*** Update cart item ***/
    public function update_cart_item()
    {
        $rowid = $this->input->post('rowid');
        $qty = $this->input->post('qty');
        $price = $this->input->post('price');

        if($qty !=0 )
        {
            $data = array(
                'rowid' => $rowid,
                'qty' => $qty,
                'price' => $price,
                'tax'   => 'tax',
                'price_option' => 'price_option'

            );
        }else
        {
            $data = array(
                'rowid' => $rowid,
                'qty' => $qty,
            );
        }

        $this->cart->update($data);

        if($this->input->post('ajax') != '1'){
            redirect('admin/purchase/new_purchase'); // If javascript is not enabled, reload the page with new data
        }else{
            echo 'true'; // If javascript is enabled, return true, so the cart gets updated
        }
    }

    /*** Delete Cart Item ***/
    public function delete_cart_item($id)
    {
        $data = array(
            'rowid' => $id,
            'qty' => 0,
        );
        $this->cart->update($data);
        redirect('admin/purchase/new_purchase/'.$flag = 'delete');
    }

    function show_cart(){
        $this->load->view('admin/purchase/cart/cart');
    }

    /*** Save Purchase Item Item ***/
    public function save_purchase()
    {

        $data = $this->global_model->array_from_post(array('supplier_id', 'purchase_ref', 'payment_method', 'payment_ref'));

        //find out supplier details
        $this->tbl_supplier('supplier_id');
        $supplier = $this->global_model->get_by(array('supplier_id'=> $data['supplier_id']), true);
        $data['supplier_name'] = $supplier->company_name;
        $data['grand_total']  = $this->cart->total();
        $data['purchase_by'] = $this->session->userdata('name');
        //save to purchase table
        $this->tbl_purchase('purchase_id');
        $purchase_id = $this->global_model->save($data);
        //random number
        $code = rand(10000000, 99999);

        $data= array();
        $data['purchase_order_number'] = $code.$purchase_id;
        //save purchase order number to purchase table
        $this->global_model->save($data, $purchase_id);

        $data= array();
        $cart = $this->cart->contents();
        foreach($cart as $item)
        {
            $this->tbl_purchase_product('purchase_product_id');
            $data['purchase_id'] = $purchase_id;
            $data['product_code'] = $item['id'];
            $data['product_name'] = $item['name'];
            $data['qty'] = $item['qty'];
            $data['unit_price'] = $item['price'];
            $data['sub_total'] = $item['subtotal'];
            $this->global_model->save($data);

            // update product Quantity
            $this->tbl_product('product_id');
            $product = $this->global_model->get_by(array('product_code'=>$item['id'] ), true);

            if(!empty($product)) {
                $product_id = $product->product_id;

                $this->tbl_inventory('inventory_id');
                $inventory = $this->global_model->get_by(array('product_id' => $product_id), true);
                $inventory_id = $inventory->inventory_id;
                $inventory_qty['product_quantity'] = $item['qty'] + $inventory->product_quantity;
                $this->global_model->save($inventory_qty, $inventory_id);
            }
        }

        //destroy cart
        $this->cart->destroy();
        redirect('admin/purchase/purchase_invoice/'.$purchase_id);

    }
    /*** view purchase invoice ***/
    public function purchase_invoice($id)
    {
        $data['purchase'] = $this->purchase_model->select_purchase_by_id($id);

        $this->tbl_purchase_product('purchase_product_id');
        $data['product'] = $this->global_model->get_by(array('purchase_id'=>$id), false);

        $data['title'] = 'Purchase Invoice';
        $data['subview'] = $this->load->view('admin/purchase/purchase_invoice', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    /*** make pdf purchase invoice ***/
    public function pdf_invoice($id)
    {
        $data['purchase'] = $this->purchase_model->select_purchase_by_id($id);

        $this->tbl_purchase_product('purchase_product_id');
        $data['product'] = $this->global_model->get_by(array('purchase_id'=>$id), false);

        $view_file = $this->load->view('admin/purchase/pdf_invoice', $data, true);
        $file_name =  'PUR-'.$data['purchase']->purchase_order_number;
        $this->load->library('pdf');
        $pdf = $this->pdf->load();

        $pdf->WriteHTML($view_file);
        $pdf->Output($file_name, 'D');


    }

    /*** make pdf purchase invoice ***/
    public function purchase_list()
    {

        $this->tbl_purchase('purchase_id', 'desc');
        $data['purchase'] = $this->global_model->get();

        $data['title'] = 'Purchase History';
        $data['subview'] = $this->load->view('admin/purchase/purchase_list', $data, true);
        $this->load->view('admin/_layout_main', $data);

    }

    /*** Supplier History ***/
    public function supplier_history($id){
        if(empty($id)){
            $this->message->norecord_found('admin/purchase/manage_supplier');
        }

        $this->tbl_supplier('supplier_id');
        $data['supplier'] = $this->global_model->get_by(array('supplier_id' => $id), true);

        if(empty($data['supplier'])){
            $this->message->norecord_found('admin/purchase/manage_supplier');
        }

        $this->tbl_purchase('purchase_id');
        $data['purchase'] = $this->global_model->get_by(array('supplier_id' => $id), false);

        $data['title'] = 'Supplier History';
        $data['subview'] = $this->load->view('admin/purchase/supplier_history', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }



}