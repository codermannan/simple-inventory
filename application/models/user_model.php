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

class User_Model extends MY_Model
{
    public $_table_name;
    public $_order_by;
    public $_primary_key;

    public function select_user_roll_by_employee_id($employee_login_id)
    {
        $this->db->select('tbl_user_role.*', false);
        $this->db->select('tbl_menu.label', false);
        $this->db->from('tbl_user_role');
        $this->db->join('tbl_menu', 'tbl_user_role.menu_id = tbl_menu.menu_id', 'left');
        $this->db->where('tbl_user_role.employee_login_id', $employee_login_id);
        $query_result = $this->db->get();
        $result = $query_result->result();

        return $result;
    }

    public function get_new_user()
    {
        $post = new stdClass();
        $post->user_name = '';
        $post->name = '';
        $post->email = '';
        $post->flag = 3;
        $post->employee_login_id = '';

        return $post;
    }
}
