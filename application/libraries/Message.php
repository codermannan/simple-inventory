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

class Message
{


    public function custom_error_msg($url, $message)
    {
        $type = 'error';
        set_message($type, $message);
        redirect($url);
    }

    public function custom_success_msg($url, $message)
    {
        $type = 'success';
        set_message($type, $message);
        redirect($url);
    }

    public function save_success($url)
    {
        $type = 'success';
        $message = 'Your record has been saved successfully!';
        set_message($type, $message);
        redirect($url);
    }


    public function delete_success($url)
    {
        $type = 'error';
        $message = 'Your record has been delete successfully!';
        set_message($type, $message);
        redirect($url);
    }

    public function norecord_found($url)
    {
        $type = 'error';
        $message = 'No Record has been found!';
        set_message($type, $message);
        redirect($url);
    }

}