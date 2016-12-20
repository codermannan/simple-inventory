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

class Mail
{
    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->library('email');
    }

    public function sendEmail($from, $to, $subject, $page)
    {

        $this->CI->email->set_mailtype('html');
        $this->CI->email->from($from[0], $from[1]);
        $this->CI->email->to($to);
        $this->CI->email->subject($subject);
        $body = $page;
        $this->CI->email->message($body);
        $send = $this->CI->email->send();
        if ($send) {
            return true;
        } else {
            return false;
        }
    }
}
