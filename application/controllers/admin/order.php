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

class Order extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('order_model');
        $this->load->model('global_model');

        $this->load->helper('ckeditor');
        $this->data['ckeditor'] = array(
            'id' => 'ck_editor',
            'path' => 'asset/js/ckeditor',
            'config' => array(
                'toolbar' => 'Full',
                'width' => '100%',
                'height' => '100px',
            ),
        );
        $this->data2['ckeditor2'] = array(
            'id' => 'ck_editor2',
            'path' => 'asset/js/ckeditor',
            'config' => array(
                'toolbar' => 'Full',
                'width' => '100%',
                'height' => '100px',
            ),
        );

    }

    /*** New Order ***/
    public function new_order($flag=null)
    {

        $data['product'] = $this->order_model->get_all_product_info();
        $customer = $this->input->post('customer', true);
        $customer_flag = $this->input->post('flag', true);
        $customer_remove_flag = $this->input->post('remove_flag', true);

        //remove customer
        if(!empty($customer_remove_flag)){
            $customer_session = array('customer_name' => '', 'customer_code' => '', 'discount' => '');
            $this->session->unset_userdata($customer_session);
            $flag = 'customer';
        }
        //search customer
        if(!empty($customer_flag)) {
            if (!empty($customer))
            {
                $result = $this->order_model->get_customer_details($customer);
                if(!empty($result)) {
                    $customer = array(
                        'customer_code' => $result->customer_code,
                        'customer_name' => $result->customer_name,
                        'discount' => $result->discount,
                    );

                    $this->session->set_userdata($customer);
                }
            }
            $flag = 'customer';
        }
        //destroy cart and session data
        if(empty($flag)){
            $customer_session = array('customer_name' => '', 'customer_code' => '', 'discount' => '', 'order_no' => '');
            $this->session->unset_userdata($customer_session);
            $this->cart->destroy();
            $random_number = rand(10000000, 99999);

            $order_no = array(
                'order_no'  => $random_number,
            );
            $this->session->set_userdata($order_no);
        }

        // view page
        $data['title'] = 'Add New Order';
        $data['editor'] = $this->data;
        $data['editor2'] = $this->data2;
        $data['subview'] = $this->load->view('admin/order/new_order', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    /*** Product add to cart ***/
    public function add_cart_item(){

            $product_code = $this->uri->segment(4);
            $result = $this->order_model->validate_add_cart_item($product_code);

            if($result){

                //product price check
                $price = $this->check_product_rate($result->product_id, $qty=1);


                //product tax check
                $tax = $this->product_tax_calculate($result->tax_id, $qty=1, $price);

                $data = array(
                    'id' => $result->product_code,
                    'qty' => 1,
                    'price' => $price,
                    'buying_price' => $result->buying_price,
                    'name' => $result->product_name,
                    'tax' => $tax,
                    'price_option' => 'general'
                );
                $this->cart->insert($data);
                $this->session->set_flashdata('cart_msg', 'add');
            }
        redirect('admin/order/new_order/'.$flag ='add');
    }

    /*** Multiple Product add to cart ***/
    public function add_cart_items(){
        $product_code = $this->input->post('product_barcode', true);

        foreach($product_code as $v_barcode){
            $result = $this->order_model->validate_add_cart_item($v_barcode);

            if($result){

                //product price check
                $price = $this->check_product_rate($result->product_id, $qty=1);

                //product tax check
                $tax = $this->product_tax_calculate($result->tax_id, $qty=1, $price);

                $data = array(
                    'id' => $result->product_code,
                    'qty' => 1,
                    'price' => $price,
                    'buying_price' => $result->buying_price,
                    'name' => $result->product_name,
                    'tax' => $tax,
                    'price_option' => 'general'
                );
                $this->cart->insert($data);
                $this->session->set_flashdata('cart_msg', 'add');
            }
        }
        redirect('admin/order/new_order/'.$flag ='add');
    }

    /*** Product add to cart by barcode ***/
    public function add_cart_item_by_barcode(){

        $product_code = $this->input->post('barcode', true);
        $result = $this->order_model->validate_add_cart_item($product_code);

        if($result){

            //product price check
            $price = $this->check_product_rate($result->product_id, $qty=1);

            //product tax check
            $tax = $this->product_tax_calculate($result->tax_id, $qty=1, $price);

            $data = array(
                'id' => $result->product_code,
                'qty' => 1,
                'price' => $price,
                'buying_price' => $result->buying_price,
                'name' => $result->product_name,
                'tax' => $tax,
                'price_option' => 'general'
            );
            $this->cart->insert($data);
            $this->session->set_flashdata('cart_msg', 'add');
        }
        redirect('admin/order/new_order/'.$flag ='add');
    }

    /*** Check product general, offer, tire rate ***/
    public function check_product_rate($product_id=null, $qty=null)
    {
        //tier Price check
        $tire_price = $this->order_model->get_tire_price($product_id, $qty);

        if($tire_price)
        {
            return $price = $tire_price->tier_price ;
        }

        //special offer check
        $this->tbl_special_offer('special_offer_id');
        $offer_price = $this->global_model->get_by(array("product_id"=>$product_id), true);

        if(!empty($offer_price)) {
            $today = strtotime(date('Y-m-d'));
            $start_date = strtotime($offer_price->start_date);
            $end_date = strtotime($offer_price->end_date);
            if (($today >= $start_date) && ($today <= $end_date)) {
                return $price = $offer_price->offer_price;
            }
        }

        //return regular rate
        $this->tbl_product_price('product_price_id');
        $general_price = $this->global_model->get_by(array("product_id"=>$product_id), true);
        return $product_price = $general_price->selling_price;

    }

    /*** Product tax calculation ***/
    public function product_tax_calculate($tax_id, $qty ,$price)
    {
        $this->tbl_tax('tax_id');
        $tax = $this->global_model->get_by(array('tax_id'=>$tax_id), true);

        //1 = tax in %
        //2 = Fixed tax Rate

        if($tax){
            if($tax->tax_type == 1)
            {
                $subtotal = $price * $qty;
                $product_tax = $tax->tax_rate * ($subtotal / 100);

                //return $result = round($product_tax, 2);
                return $result = $product_tax;

            }else
            {

                //$product_tax = $tax->tax_rate * $qty;
                $product_tax = $tax->tax_rate * $qty;
                return $result = $product_tax;

            }
        }
    }

    /*** Update Product Cart ***/
    public function update_cart_item()
    {
        $rowid = $this->input->post('rowid');
        $qty = $this->input->post('qty');
        $product_price = $this->input->post('price');
        $product_code = $this->input->post('product_code');
        $custom_price = $this->input->post('custom_price');


        if($qty !=0 )
        {
            //tbl product
            $this->tbl_product('product_id');
            $result = $this->global_model->get_by(array('product_code'=> $product_code ), true);

            //product Inventory Check
            $this->tbl_inventory('inventory_id');
            $product_inventory = $this->global_model->get_by(array('product_id'=> $result->product_id ), true);

            if($qty > $product_inventory->product_quantity)
            {
                $type = 'error';
                $message = 'Sorry! This product has not enough stock.';
                set_message($type, $message);
                echo 'false';
                return;
            }


            if($custom_price == "on")
            {
                   $price = $product_price;
                   $price_option = 'custom_price';

            }
            else
            {
                //product price check
                $price = $this->check_product_rate($result->product_id, $qty);
                $price_option = 'general';
            }


            //product tax check
            $tax = $this->product_tax_calculate($result->tax_id, $qty, $price);

            $data = array(
                'rowid' => $rowid,
                'qty' => $qty,
                'price' => $price,
                'tax'   => $tax,
                'price_option' => $price_option

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
            redirect('admin/order/new_order'); // If javascript is not enabled, reload the page with new data
        }else{
            echo 'true'; // If javascript is enabled, return true, so the cart gets updated
        }
    }
    /*** Show cart ***/
    function show_cart(){
        $this->load->view('admin/order/cart/cart');
    }
    /*** cart Summery ***/
    function show_cart_summary(){
        $this->load->view('admin/order/cart/cart_summary');
    }

    /*** Delete Cart Item ***/
    public function delete_cart_item($id)
    {
        $data = array(
            'rowid' => $id,
            'qty' => 0,
        );
        $this->cart->update($data);
        $this->session->set_flashdata('cart_msg', 'delete');
        redirect('admin/order/new_order/'.$flag ='delete');
    }

    public function error_inventory(){
        redirect('admin/order/new_order/'.$flag ='delete');
    }

    /*** Save Order ***/
    public function save_order()
    {
        $data_order = $this->global_model->array_from_post(array('grand_total', 'total_tax', 'discount','note', 'payment_ref', 'discount_amount'));
        $order_code = $this->input->post('order_no', true);

        $data_order['sub_total']  = $this->cart->total();
        $data_order['sales_person'] = $this->session->userdata('name');

        //checking order pending or confirm
        $payment_method = $this->input->post('payment_method', true);
        if($payment_method != 'pending'){
            $data_order['payment_method'] = $payment_method;
            $data_order['order_status'] = 2;

        }

        //customer
        $customer_code =$this->input->post('customer_id', true);
        if(empty($customer_code))
        {
            $data_order['customer_name'] = 'walking Client';
        }else
        {
            $this->tbl_customer('customer_id');
            $customer_info = $this->global_model->get_by(array('customer_code'=> $customer_code), true);
            $data_order['customer_id']= $customer_info->customer_id;
            $data_order['customer_name']= $customer_info->customer_name;
            $data_order['customer_email']= $customer_info->email;
            $data_order['customer_phone']= $customer_info->phone;
            $data_order['customer_address']= $customer_info->address;
            $data_order['shipping_address']= $this->input->post('shipping_address', true);
        }

        //save order
        $this->tbl_order('order_id');
        $order_id = $this->global_model->save($data_order);

        $order_number['order_no'] = $order_code.$order_id;
        $this->global_model->save($order_number,$order_id );

        //save order details
        $cart = $this->cart->contents();
        foreach($cart as $item)
        {
            $this->tbl_order_details('order_details_id');
            $data_order_details['order_id'] = $order_id;
            $data_order_details['product_code'] = $item['id'];
            $data_order_details['product_name'] = $item['name'];
            $data_order_details['product_quantity'] = $item['qty'];
            $data_order_details['selling_price'] = $item['price'];
            $data_order_details['buying_price'] = $item['buying_price'];
            $data_order_details['product_tax'] = $item['tax'];
            $data_order_details['sub_total'] = $item['subtotal'];
            $data_order_details['price_option'] = $item['price_option'];

            $this->global_model->save($data_order_details);

            // update product Quantity
            $this->tbl_product('product_id');
            $product = $this->global_model->get_by(array('product_code'=>$item['id'] ), true);
            $product_id = $product->product_id;

            $this->tbl_inventory('inventory_id');
            $inventory = $this->global_model->get_by(array('product_id'=>$product_id ), true);
            $inventory_id = $inventory->inventory_id;
            $inventory_qty['product_quantity'] = $inventory->product_quantity - $item['qty'];
            $this->global_model->save($inventory_qty, $inventory_id);
        }

        //save invoice
        if($payment_method != 'pending'){
            $data_order_invoice['order_id'] = $order_id;

            $this->tbl_invoice('invoice_id');
            $invoice_id = $this->global_model->save($data_order_invoice);
            $invoice_code = rand(10000000, 99999);

            $invoice_number['invoice_no'] = $invoice_code.$invoice_id;
            $this->global_model->save($invoice_number,$invoice_id );

            //destroy cart
            $this->cart->destroy();
            $customer_session = array('customer_name' => '', 'customer_code' => '', 'discount' => '', 'order_no' => '');
            $this->session->unset_userdata($customer_session);

            redirect('admin/order/order_invoice/'.$invoice_number['invoice_no'] );
            //display invoice

        }

        //display order pending invoice
        redirect('admin/order/view_order/'.$order_number['order_no']);

        //destroy cart
        $this->cart->destroy();
        $customer_session = array('customer_name' => '', 'customer_code' => '', 'discount' => '', 'order_no' => '');
        $this->session->unset_userdata($customer_session);

    }

    /*** View Order Invoice ***/
    public function order_invoice($id=null)
    {

        if(empty($id)){
            //redirect manage invoice
            $this->message->norecord_found('admin/order/manage_invoice');
        }

        //get order id
        $this->tbl_invoice('invoice_id');
        $data['invoice_info']= $this->global_model->get_by(array('invoice_no'=>$id), true);

        if(empty($data['invoice_info'])){
            //redirect manage invoice
            $this->message->norecord_found('admin/order/manage_invoice');
        }

        //order information
        $this->tbl_order('order_id');
        $data['order_info']= $this->global_model->get_by(array('order_id'=>$data['invoice_info']->order_id), true);

        //order details
        $this->tbl_order_details('order_details_id');
        $data['order_details']= $this->global_model->get_by(array('order_id'=>$data['invoice_info']->order_id), false);

        $data['title'] = 'Order Invoice';
        $data['subview'] = $this->load->view('admin/order/order_invoice', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    /*** Manage Order ***/
    public function manage_order(){
        $data['order'] = $this->order_model->get_all_order();
        $data['title'] = 'Manage Order';
        $data['subview'] = $this->load->view('admin/order/manage_order', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    /*** Pending Order ***/
    public function pending_order(){
        $data['title'] = 'Pending Order';
        $data['subview'] = $this->load->view('admin/order/pending_order', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    /*** Manage Invoice ***/
    public function manage_invoice(){
        $data['invoice'] = $this->order_model->get_all_invoice();
        $data['title'] = 'Manage Invoice';
        $data['subview'] = $this->load->view('admin/order/manage_invoice', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    /*** View Order  ***/
    public function view_order($id=null){
        if(empty($id)){
            //redirect manage invoice
            $this->message->norecord_found('admin/order/manage_order');
        }

        //get order
        $this->tbl_order('order_id');
        $data['order_info']= $this->global_model->get_by(array('order_no'=>$id), true);
        //order details
        $this->tbl_order_details('order_details_id');
        $data['order_details']= $this->global_model->get_by(array('order_id'=>$data['order_info']->order_id), false);

        if(empty($data['order_info'])){
            //redirect manage invoice
            $this->message->norecord_found('admin/order/manage_order');
        }

        //get invoice
        $data['order'] = $this->order_model->get_all_order();
        $data['title'] = 'View Order';
        $data['subview'] = $this->load->view('admin/order/order_view', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    /*** Order Reconfirmation  ***/
    public function order_re_confirmation()
    {
        $data['order_status'] = $this->input->post('order_status', true);

        $data['payment_method'] = $this->input->post('payment_method', true);
        $data['payment_ref'] = $this->input->post('payment_ref', true);
        $order_id = $this->input->post('order_id', true);
        $order_no = $this->input->post('order_no', true);

        if($data['order_status'] == 2)
        {
            //confirm order
            $this->tbl_order('order_id');
            $this->global_model->save($data,$order_id );


            //invoice generate
            $data_order_invoice['order_id'] = $order_id;

            $this->tbl_invoice('invoice_id');
            $invoice_id = $this->global_model->save($data_order_invoice);
            $invoice_code = rand(10000000, 99999);

            $invoice_number['invoice_no'] = $invoice_code.$invoice_id;
            $this->global_model->save($invoice_number,$invoice_id );

            redirect('admin/order/order_invoice/'.$invoice_number['invoice_no'] );

        }elseif($data['order_status'] == 1)
        {
            //cancel order
            $this->tbl_order('order_id');
            $this->global_model->save($data,$order_id );

            //product details
            $this->tbl_order_details('order_details_id');
            $order_details = $this->global_model->get_by(array('order_id'=> $order_id), false);

            foreach($order_details as $v_order_details){
                //tbl_product
                $this->tbl_product('product_id');
                $product = $this->global_model->get_by(array('product_code'=> $v_order_details->product_code), true);

                //tbl_product inventory
                $this->tbl_inventory('inventory_id');
                $inventory = $this->global_model->get_by(array('product_id'=> $product->product_id), true);

                $data_inventory['product_quantity'] = $inventory->product_quantity + $v_order_details->product_quantity;
                $this->global_model->save($data_inventory,$inventory->inventory_id );
            }
            redirect('admin/order/view_order/'.$order_no);

        }else{
            //redirect
            redirect('admin/order/manage_order');
        }

    }

    /*** PDF Invoice Generate  ***/
    public function pdf_invoice($id=null)
    {

        //get order id
        $this->tbl_invoice('invoice_id');
        $data['invoice_info']= $this->global_model->get_by(array('invoice_no'=>$id), true);

        if(empty($data['invoice_info'])){
            //redirect manage invoice
            $this->message->norecord_found('admin/order/manage_invoice');
        }

        //order information
        $this->tbl_order('order_id');
        $data['order_info']= $this->global_model->get_by(array('order_id'=>$data['invoice_info']->order_id), true);

        //order details
        $this->tbl_order_details('order_details_id');
        $data['order_details']= $this->global_model->get_by(array('order_id'=>$data['invoice_info']->order_id), false);
        $data['title'] = 'Order Invoice';

        $html = $this->load->view('admin/order/pdf_order_invoice', $data, true);
        $filename = 'INV-'.$id;
        $this->load->library('pdf');
        $pdf = $this->pdf->load();

        $pdf->WriteHTML($html);
        $pdf->Output($filename, 'D');

    }

    /*** Email Invoice to customer   ***/
    public function email_invoice($id=null){

        //get order id
        $this->tbl_invoice('invoice_id');
        $data['invoice_info']= $this->global_model->get_by(array('invoice_no'=>$id), true);

        if(empty($data['invoice_info'])){
            //redirect manage invoice
            $this->message->norecord_found('admin/order/manage_invoice');
        }

        //order information
        $this->tbl_order('order_id');
        $data['order_info']= $this->global_model->get_by(array('order_id'=>$data['invoice_info']->order_id), true);

        //order details
        $this->tbl_order_details('order_details_id');
        $data['order_details']= $this->global_model->get_by(array('order_id'=>$data['invoice_info']->order_id), false);


        $company_info = $this->session->userdata('business_info');

        if(!empty($company_info->email) && !empty($company_info->email)) {

            $company_email = $company_info->email;
            $company_name = $company_info->company_name;
            $from = array($company_email, $company_name);
            //sender email
            $to = $data['order_info']->customer_email;
            //subject
            $subject = 'Invoice no:' . $id;
            // set view page
            $view_page = $this->load->view('admin/order/pdf_order_invoice', $data, true);
            $send_email = $this->mail->sendEmail($from, $to, $subject, $view_page);
            if ($send_email) {
                $this->message->custom_success_msg('admin/order/order_invoice/' . $id,
                    'Your email has been send successfully!');
            } else {
                $this->message->custom_error_msg('admin/order/order_invoice/' . $id,
                    'Sorry unable to send your email!');
            }
        }else{
                 $this->message->custom_error_msg('admin/order/order_invoice/' . $id,
                'Sorry unable to send your email, without company email');
        }

    }


}
