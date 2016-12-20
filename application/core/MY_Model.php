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

class MY_Model extends CI_Model
{
    protected $_table_name = '';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = '';
    protected $_order = '';
    public $rules = array();
    protected $_timestamps = false;

    public function __construct()
    {
        parent::__construct();
    }

    // CURD FUNCTION

    public function array_from_post($fields)
    {
        $data = array();
        foreach ($fields as $field) {
            $data[$field] = $this->input->post($field);
        }

        return $data;
    }

    public function get($id = null, $single = false)
    {
        if ($id != null) {
            $filter = $this->_primary_filter;
            $id = $filter($id);
            $this->db->where($this->_primary_key, $id);
            $method = 'row';
        } elseif ($single == true) {
            $method = 'row';
        } else {
            $method = 'result';
        }

        if (!count($this->db->ar_orderby)) {
            $this->db->order_by($this->_order_by, $this->_order);
        }

        return $this->db->get($this->_table_name)->$method();
    }

    public function get_by($where, $single = false)
    {
        $this->db->where($where);

        return $this->get(null, $single);
    }

    public function save($data, $id = null)
    {

        // Set timestamps
        if ($this->_timestamps == true) {
            $now = date('Y-m-d H:i:s');
            $id || $data['created'] = $now;
            $data['modified'] = $now;
        }

        // Insert
        if ($id === null) {
            !isset($data[$this->_primary_key]) || $data[$this->_primary_key] = null;
            $this->db->set($data);
            $this->db->insert($this->_table_name);
            $id = $this->db->insert_id();
        }
        // Update
        else {
            $filter = $this->_primary_filter;
            $id = $filter($id);
            $this->db->set($data);
            $this->db->where($this->_primary_key, $id);
            $this->db->update($this->_table_name);
        }

        return $id;
    }

    /**
     * Delete Single rows.
     */
    public function delete($id)
    {
        $filter = $this->_primary_filter;
        $id = $filter($id);

        if (!$id) {
            return false;
        }
        $this->db->where($this->_primary_key, $id);
        $this->db->limit(1);
        $this->db->delete($this->_table_name);
    }

    /**
     * Delete Multiple rows.
     */
    public function delete_all($where)
    {
        $this->db->where($where);
        $this->db->delete($this->_table_name);
    }

    public function uploadImage($field)
    {
        $config['upload_path'] = 'img/uploads/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size'] = '2024';

        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!$this->upload->do_upload($field)) {
            $error = $this->upload->display_errors();
            $type = 'error';
            $message = $error;
            set_message($type, $message);

            return false;
            // uploading failed. $error will holds the errors.
        } else {
            $fdata = $this->upload->data();
            $img_data ['path'] = $config['upload_path'].$fdata['file_name'];
            $img_data ['fullPath'] = $fdata['full_path'];

            return $img_data;
            // uploading successfull, now do your further actions
        }
    }

    public function uploadFile($field)
    {
        $config['upload_path'] = 'img/uploads/';
        $config['allowed_types'] = 'pdf|docx|doc';
        $config['max_size'] = '2048';

        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!$this->upload->do_upload($field)) {
            $error = $this->upload->display_errors();
            $type = 'error';
            $message = $error;
            set_message($type, $message);

            return false;
            // uploading failed. $error will holds the errors.
        } else {
            $fdata = $this->upload->data();
            $file_data ['fileName'] = $fdata['file_name'];
            $file_data ['path'] = $config['upload_path'].$fdata['file_name'];
            $file_data ['fullPath'] = $fdata['full_path'];

            return $file_data;
            // uploading successfull, now do your further actions
        }
    }

    public function check_by($where, $tbl_name)
    {
        $this->db->select('*');
        $this->db->from($tbl_name);
        $this->db->where($where);
        $query_result = $this->db->get();
        $result = $query_result->row();

        return $result;
    }

    public function set_action($where, $value, $tbl_name)
    {
        $this->db->set($value);
        $this->db->where($where);
        $this->db->update($tbl_name);
    }

    /** duplicate value check **/
    public function check_update($table, $where, $id = null)
    {
        $this->db->select('*', false);
        $this->db->from($table);
        if ($id != null) {
            $this->db->where($id);
        }
        $this->db->where($where);
        $query_result = $this->db->get();
        $result = $query_result->result();

        return $result;
    }
}
