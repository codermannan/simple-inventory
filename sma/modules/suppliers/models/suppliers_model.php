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
| MODULE: 			Suppliers
| -----------------------------------------------------
| This is suppliers module's model file.
| -----------------------------------------------------
*/


class Suppliers_model extends CI_Model
{
	
	
	public function __construct()
	{
		parent::__construct();

	}
	
	public function getAllSuppliers() 
	{
		$q = $this->db->get('suppliers');
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
	}
	
	public function suppliers_count() {
        return $this->db->count_all("suppliers");
    }

    public function fetch_suppliers($limit, $start) {
        $this->db->limit($limit, $start);
		$this->db->order_by("id", "desc"); 
        $query = $this->db->get("suppliers");

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
   }
	
	public function getSupplierByID($id) 
	{

		$q = $this->db->get_where('suppliers', array('id' => $id), 1); 
		  if( $q->num_rows() > 0 )
		  {
			return $q->row();
		  } 
		
		  return FALSE;

	}
	
	public function getSupplierByEmail($email) 
	{

		$q = $this->db->get_where('suppliers', array('email' => $email), 1); 
		  if( $q->num_rows() > 0 )
		  {
			return $q->row();
		  } 
		
		  return FALSE;

	}
	
	public function addSupplier($name, $email, $company, $data = array())
	{
		
		
		// Supplier data
		$supplierData = array(
		    'name'	   			=> $data['name'],
		    'email'   				=> $data['email'],
		    'company'   			=> $data['company'],
		    'address' 			=> $data['address'],
			'city'				=> $data['city'],
		    'state'  				=> $data['state'],
		    'postal_code' 		=> $data['postal_code'],
		    'country' 			=> $data['country'],
			'phone'	     		=> $data['phone'],
			'cf1'      			=> $data['cf1'],
			'cf2'      			=> $data['cf2'],
			'cf3'      			=> $data['cf3'],
			'cf4'      			=> $data['cf4'],
			'cf5'      			=> $data['cf5'],
			'cf6'      			=> $data['cf6']
		);

		if($this->db->insert('suppliers', $supplierData)) {
			return true;
		} else {
			return false;
		}
	}
	
	public function updateSupplier($id, $data = array())
	{
		
		
		// Supper data
		$supplierData = array(
		    'name'	   			=> $data['name'],
		    'email'   				=> $data['email'],
		    'company'   			=> $data['company'],
		    'address' 			=> $data['address'],
			'city'				=> $data['city'],
		    'state'  				=> $data['state'],
		    'postal_code' 		=> $data['postal_code'],
		    'country' 			=> $data['country'],
			'phone'	     		=> $data['phone'],
			'cf1'      			=> $data['cf1'],
			'cf2'      			=> $data['cf2'],
			'cf3'      			=> $data['cf3'],
			'cf4'      			=> $data['cf4'],
			'cf5'      			=> $data['cf5'],
			'cf6'      			=> $data['cf6']
		);
		$this->db->where('id', $id);
		if($this->db->update('suppliers', $supplierData)) {
			return true;
		} else {
			return false;
		}
	}
	
	public function add_suppliers($data = array())
	{
		
		if($this->db->insert_batch('suppliers', $data)) {
			return true;
		} else {
			return false;
		}
	}
	
	public function deleteSupplier($id) 
	{
		if($this->db->delete('suppliers', array('id' => $id))) {
			return true;
		}
	return FALSE;
	}

}
