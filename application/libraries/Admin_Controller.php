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
class Admin_Controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('global_model');

        $this->global_model->_table_name = 'tbl_menu'; //table name
            $this->global_model->_order_by = 'menu_id';
            //get all navigation data
            $all_menu = $this->global_model->get();
        $_SESSION['user_roll'] = $all_menu;

            //get employee id from session
            $user_id = $this->session->userdata('employee_id');

        $this->global_model->_table_name = 'tbl_user_role'; //table name
            $this->global_model->_order_by = 'user_role_id';
            // get employee navigation by employee id
            $user_menu = $this->global_model->get_by(array('employee_login_id' => $user_id), false);

        $user_type = $this->session->userdata('user_type');

        if ($user_type != 1) {
            $restricted_link = array();
            foreach ($all_menu as $data1) {
                $duplicate = false;
                foreach ($user_menu as $data2) {
                    if ($data1->menu_id === $data2->menu_id) {
                        $duplicate = true;
                    }
                }

                if ($duplicate === false) {
                    $restricted_link[] = $data1->link;
                }
            }
            $exception_uris = $restricted_link;
        } else {
            $exception_uris = array();
        }

        // Login check

        if (in_array(uri_string(), $exception_uris) == true) {
            redirect('admin/dashboard');
        }


        //echo $uriSegment = $this->uri->uri_string();
        $uri1 = $this->uri->segment(1);
        $uri2 = $this->uri->segment(2);
        $uri3 = $this->uri->segment(3);
        if ($uri3) {
            $uri3 = '/'.$uri3;
        }
        $uriSegment = $uri1.'/'.$uri2.$uri3;
        $menu_uri['menu_active_id'] = $this->login_model->select_menu_by_uri($uriSegment);
        $menu_uri['menu_active_id'] == false || $this->session->set_userdata($menu_uri);


        $this->global_model->_table_name = 'tbl_business_profile';
        $this->global_model->_order_by = 'business_profile_id';

        $info['business_info'] = $this->global_model->get_by(array("business_profile_id"=> 1), true);
        $this->session->set_userdata($info);

        //notify bellow Quantity
        $this->global_model->_table_name = 'tbl_inventory';
        $this->global_model->_order_by = 'inventory_id';
        $product_inventory = $this->global_model->get();

        foreach($product_inventory as $v_inventory){
            if($v_inventory->notify_quantity >= $v_inventory->product_quantity)
                $notify_product[] = $this->global_model->get_product_bellow_qty($v_inventory->product_id ,$v_inventory->product_quantity);
        }

        if(!empty($notify_product)) {
            $_SESSION["notify_product"] = $notify_product;
        }else{
            $_SESSION["notify_product"]=null;
        }

        //Pending Order
        $this->global_model->_table_name = 'tbl_order';
        $this->global_model->_order_by = 'order_id';
        $pending_order = $this->global_model->get_by(array("order_status"=> 0), false);
        $_SESSION["pending_order"] = $pending_order;

    }

    //======================================================================
    // ALL TABLE DECLARATION
    //======================================================================

    /* product category and sub table start */

    public function tbl_category($order_by){
        $this->global_model->_table_name = 'tbl_category';
        $this->global_model->_order_by = $order_by;
        $this->global_model->_primary_key = 'category_id';
    }
    public function tbl_subcategory($order_by){
        $this->global_model->_table_name = 'tbl_subcategory';
        $this->global_model->_order_by = $order_by;
        $this->global_model->_primary_key = 'subcategory_id';
    }

    /* product tax table */

    public function tbl_tax($order_by){
        $this->global_model->_table_name = 'tbl_tax';
        $this->global_model->_order_by = $order_by;
        $this->global_model->_primary_key = 'tax_id';
    }

    /* tag table */

    public function tbl_tag($order_by){
        $this->global_model->_table_name = 'tbl_tag';
        $this->global_model->_order_by = $order_by;
        $this->global_model->_primary_key = 'tag_id';
    }

    /* supplier table */

    public function tbl_supplier($order_by, $order=null){
        $this->global_model->_table_name = 'tbl_supplier';
        $this->global_model->_order_by = $order_by;
        $this->global_model->_order = $order;
        $this->global_model->_primary_key = 'supplier_id';
    }


    /* product table start */

    public function tbl_product($order_by){
        $this->global_model->_table_name = 'tbl_product';
        $this->global_model->_order_by = $order_by;
        $this->global_model->_primary_key = 'product_id';
    }
    public function tbl_product_image($order_by){
        $this->global_model->_table_name = 'tbl_product_image';
        $this->global_model->_order_by = $order_by;
        $this->global_model->_primary_key = 'product_image_id';
    }
    public function tbl_product_price($order_by){
        $this->global_model->_table_name = 'tbl_product_price';
        $this->global_model->_order_by = $order_by;
        $this->global_model->_primary_key = 'product_price_id';
    }
    public function tbl_special_offer($order_by){
        $this->global_model->_table_name = 'tbl_special_offer';
        $this->global_model->_order_by = $order_by;
        $this->global_model->_primary_key = 'special_offer_id';
    }
    public function tbl_tier_price($order_by){
        $this->global_model->_table_name = 'tbl_tier_price';
        $this->global_model->_order_by = $order_by;
        $this->global_model->_primary_key = 'tier_price_id';
    }
    public function tbl_inventory($order_by){
        $this->global_model->_table_name = 'tbl_inventory';
        $this->global_model->_order_by = $order_by;
        $this->global_model->_primary_key = 'inventory_id';
    }
    public function tbl_attribute($order_by){
        $this->global_model->_table_name = 'tbl_attribute';
        $this->global_model->_order_by = $order_by;
        $this->global_model->_primary_key = 'attribute_id';
    }
    public function tbl_attribute_set($order_by)
    {
        $this->global_model->_table_name = 'tbl_attribute_set';
        $this->global_model->_order_by = $order_by;
        $this->global_model->_primary_key = 'attribute_set_id';
    }

    public function tbl_product_tag($order_by){
        $this->global_model->_table_name = 'tbl_product_tag';
        $this->global_model->_order_by = $order_by;
        $this->global_model->_primary_key = 'product_tag_id';
    }

    /* purchase table start */

    public function tbl_purchase($order_by, $order=null){
        $this->global_model->_table_name = 'tbl_purchase';
        $this->global_model->_order_by = $order_by;
        $this->global_model->_order = $order;
        $this->global_model->_primary_key = 'purchase_id';
    }

    public function tbl_purchase_product($order_by){
        $this->global_model->_table_name = 'tbl_purchase_product';
        $this->global_model->_order_by = $order_by;
        $this->global_model->_primary_key = 'purchase_product_id';
    }

    /* customer table */

    public function tbl_customer($order_by){
        $this->global_model->_table_name = 'tbl_customer';
        $this->global_model->_order_by = $order_by;
        $this->global_model->_primary_key = 'customer_id';
    }

    /* damage product */

    public function tbl_damage_product($order_by){
        $this->global_model->_table_name = 'tbl_damage_product';
        $this->global_model->_order_by = $order_by;
        $this->global_model->_primary_key = 'damage_product_id';
    }

    /* tbl_order */

    public function tbl_order($order_by){
        $this->global_model->_table_name = 'tbl_order';
        $this->global_model->_order_by = $order_by;
        $this->global_model->_primary_key = 'order_id';
    }

    public function tbl_order_details($order_by){
        $this->global_model->_table_name = 'tbl_order_details';
        $this->global_model->_order_by = $order_by;
        $this->global_model->_primary_key = 'order_details_id';
    }

    public function tbl_invoice($order_by){
        $this->global_model->_table_name = 'tbl_invoice';
        $this->global_model->_order_by = $order_by;
        $this->global_model->_primary_key = 'invoice_id';
    }

    public function tbl_campaign($order_by, $order=null){
        $this->global_model->_table_name = 'tbl_campaign';
        $this->global_model->_order_by = $order_by;
        $this->global_model->_order = $order;
        $this->global_model->_primary_key = 'campaign_id';
    }
    public function tbl_campaign_result($order_by, $order=null){
        $this->global_model->_table_name = 'tbl_campaign_result';
        $this->global_model->_order_by = $order_by;
        $this->global_model->_order = $order;
        $this->global_model->_primary_key = 'campaign_result_id';
    }




}
