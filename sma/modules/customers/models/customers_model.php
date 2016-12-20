<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/*
| -----------------------------------------------------
| PRODUCT NAME: 	STOCK MANAGER ADVANCE 
| -----------------------------------------------------
| AUTHER:			MIAN SALEEM 
| -----------------------------------------------------
| EMAIL:			saleem@tecdiary.com 
| -----------------------------------------------------
| COPYRIGHTS:		RESERVED BY TECDIARY IT SOLUTIONS
| -----------------------------------------------------
| WEBSITE:			http://tecdiary.net
| -----------------------------------------------------
|
| MODULE: 			Customers
| -----------------------------------------------------
| This is customers module's model file.
| -----------------------------------------------------
*/


class Customers_model extends CI_Model
{
	
	
	public function __construct()
	{
		parent::__construct();

	}
	
	public function getAllCustomers() 
	{
		$q = $this->db->get('customers');
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
	}
	
	public function customers_count() {
        return $this->db->count_all("customers");
    }

    public function fetch_customers($limit, $start) {
        $this->db->limit($limit, $start);
		$this->db->order_by("id", "desc"); 
        $query = $this->db->get("customers");

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
   }
	
	public function getCustomerByID($id) 
	{

		$q = $this->db->get_where('customers', array('id' => $id), 1); 
		  if( $q->num_rows() > 0 )
		  {
			return $q->row();
		  } 
		
		  return FALSE;

	}
	
	public function getCustomerByEmail($email) 
	{

		$q = $this->db->get_where('customers', array('email' => $email), 1); 
		  if( $q->num_rows() > 0 )
		  {
			return $q->row();
		  } 
		
		  return FALSE;

	}
	
	public function addCustomer($data = array())
	{
		
		// Customer data
		$customerData = array(
		    'name'	     	   => $data['name'],
		    'email'   			  => $data['email'],
			'company'      		=> $data['company'],
		    'address' 			=> $data['address'],
			'city'	     	   => $data['city'],
		    'state'   			  => $data['state'],
		    'postal_code'   	    => $data['postal_code'],
		    'country' 			=> $data['country'],
			'phone'	     	  => $data['phone'],
			'cf1'      			=> $data['cf1'],
			'cf2'      			=> $data['cf2'],
			'cf3'      			=> $data['cf3'],
			'cf4'      			=> $data['cf4'],
			'cf5'      			=> $data['cf5'],
			'cf6'      			=> $data['cf6']
		);

		if($this->db->insert('customers', $customerData)) {
			return true;
		} else {
			return false;
		}
	}
	
	public function updateCustomer($id, $data = array())
	{
		
		// Customer data
		$customerData = array(
		    'name'	     	   => $data['name'],
		    'email'   			  => $data['email'],
			'company'      		=> $data['company'],
		    'address' 			=> $data['address'],
			'city'	     	   => $data['city'],
		    'state'   			  => $data['state'],
		    'postal_code'   	    => $data['postal_code'],
		    'country' 			=> $data['country'],
			'phone'	     	  => $data['phone'],
			'cf1'      			=> $data['cf1'],
			'cf2'      			=> $data['cf2'],
			'cf3'      			=> $data['cf3'],
			'cf4'      			=> $data['cf4'],
			'cf5'      			=> $data['cf5'],
			'cf6'      			=> $data['cf6']
		);
		
		$this->db->where('id', $id);
		if($this->db->update('customers', $customerData)) {
			return true;
		} else {
			return false;
		}
	}
	
	public function add_customers($data = array())
	{
		
		if($this->db->insert_batch('customers', $data)) {
			return true;
		} else {
			return false;
		}
	}
	
	public function deleteCustomer($id) 
	{
		if($this->db->delete('customers', array('id' => $id))) {
			return true;
		}
	return FALSE;
	}
	
	public function getCustomerNames($term)
    {
	   	$this->db->select('name');
	    $this->db->like('name', $term, 'both');
   		$q = $this->db->get('customers');
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data; 
		}
    }

}
