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

class Campaign extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('global_model');
        $this->load->library('email');
    }

    /*** New Campaign***/
    public function new_campaign($id=null){

        if ($id) {
            $this->tbl_campaign('campaign_id');
            $data['campaign'] = $this->global_model->get_by(array('campaign_id'=>$id), true);
            if(empty($data['campaign'])){
                $this->message->norecord_found('admin/campaign/manage_campaign');
            }
        }

        $data['title'] = 'Create Email';
        $data['subview'] = $this->load->view('admin/campaign/new_campaign', $data, true);
        $this->load->view('admin/_layout_main', $data);

    }

    /*** Save Campaign ***/
    public function save_campaign($id=null)
    {

        $data = $this->global_model->array_from_post(array(
            'campaign_name',
            'subject',
            'email_body'

        ));
        $data['created_by'] = $this->session->userdata('name');

        $this->tbl_campaign('campaign_id');
        $this->global_model->save($data, $id);
        $this->message->save_success('admin/campaign/manage_campaign');
    }

    /*** Manage Campaign ***/
    public function manage_campaign(){
        $this->tbl_campaign('campaign_id','desc');
        $data['campaign'] = $this->global_model->get();

        $data['title'] = 'Manage Campaign';
        $data['subview'] = $this->load->view('admin/campaign/manage_campaign', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    /*** View Campaign ***/
    public function view_email($id)
    {
        $this->tbl_campaign('campaign_id');
        $data['campaign'] = $this->global_model->get_by(array('campaign_id'=>$id), true);

        $data['title'] = 'View Email';
        $data['campaign_id'] = $id;
        $data['modal_subview'] = $this->load->view('admin/campaign/_modal_view_email', $data, FALSE);
        $this->load->view('admin/_layout_modal', $data);

    }

    /*** Send Campaign Email ***/
    public function send_email()
    {
        $id = $this->input->post('campaign_id');

        $this->tbl_campaign('campaign_id');
        $data['campaign'] = $this->global_model->get_by(array('campaign_id'=>$id), true);


        $company_info = $this->session->userdata('business_info');


        if(empty($company_info->email) && empty($company_info->company_name)){
            $this->message->custom_error_msg('admin/campaign/campaign_result', 'Your campaign email unable to send please set company email');
        }

        $company_email = $company_info->email;
        $company_name = $company_info->company_name;

        $this->tbl_customer('customer_id');
        $customer = $this->global_model->get();

        if(empty($customer)) {
            $this->message->custom_error_msg('admin/campaign/campaign_result', 'Your campaign email unable to send, customer email are empty');
        }


        $count = count($customer);
        if ($count % 100) {
           $n = (int) ($count / 100);
            $offset = $n+1;
        } else {
            $offset = $count / 100;
        }

            $customer_email = $this->partition( $customer, $offset );


            foreach($customer_email as $name => $email_list) {
               $email = '';
                foreach($email_list as $v_email ) {
                    $email .= $v_email->email . ', ';
                    }
                    // Send Email
                    $this->email->clear();
                    $config['charset'] = 'iso-8859-1';
                    $config['wordwrap'] = true;
                    $config["bcc_batch_mode"] = true;
                    $config["bcc_batch_size"] = 200;

                    $this->email->initialize($config);

                    $view_page = $this->load->view('admin/campaign/email_campaign_templet', $data, true);
                    $this->email->set_mailtype('html');
                    $this->email->from($company_email, $company_name);
                    $this->email->to('');
                    $this->email->bcc($email);
                    $this->email->subject($data['campaign']->subject);
                    $this->email->message($view_page);
                    $this->email->send();
                

            }

        $campaign_result['campaign_id']= $data['campaign']->campaign_id ;
        $campaign_result['campaign_name']= $data['campaign']->campaign_name ;
        $campaign_result['subject']= $data['campaign']->subject ;
        $campaign_result['send_by']= $this->session->userdata('name');

        $this->tbl_campaign_result('campaign_result_id');
        $this->global_model->save($campaign_result);

        $this->message->custom_success_msg('admin/campaign/campaign_result', 'Your campaign email has been send successfully');


    }

    /*** Campaign Result ***/
    public function campaign_result()
    {
        $this->tbl_campaign_result('campaign_result_id','desc');
        $data['campaign_result'] = $this->global_model->get();

        $data['title'] = 'Campaign Result';
        $data['subview'] = $this->load->view('admin/campaign/campaign_result', $data, TRUE);
        $this->load->view('admin/_layout_main', $data);

    }


    public function partition( $list, $p ) {
        $listlen = count( $list );
        $partlen = floor( $listlen / $p );
        $partrem = $listlen % $p;
        $partition = array();
        $mark = 0;
        for ($px = 0; $px < $p; $px++) {
            $incr = ($px < $partrem) ? $partlen + 1 : $partlen;
            $partition[$px] = array_slice( $list, $mark, $incr );
            $mark += $incr;
        }
        return $partition;
    }
    
    /*** Delete Campaign ***/
    public function delete_campaign($id=null)
    {
        if(!empty($id)){
            $this->tbl_campaign('campaign_id');
            $this->global_model->delete($id);
            $this->message->delete_success('admin/campaign/manage_campaign');
        }else{
            $this->message->custom_error_msg('admin/campaign/manage_campaign', 'Sorry there is no record found');
        }
    }

}