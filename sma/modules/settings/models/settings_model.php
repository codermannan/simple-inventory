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
| MODULE: 			Products
| -----------------------------------------------------
| This is products module model file.
| -----------------------------------------------------
*/


class Settings_model extends CI_Model
{
	
	
	public function __construct()
	{
		parent::__construct();

	}
	
	public function updateLogo($photo)
	{

			$logo = array(
				'logo'	     			=> $photo
			);
			
		if($this->db->update('settings', $logo)) {
			return true;
		} else {
			return false;
		}
	}
	
	public function updateLoginLogo($photo)
	{

			$logo = array(
				'logo2'	     			=> $photo
			);
			
		if($this->db->update('settings', $logo)) {
			return true;
		} else {
			return false;
		}
	}
	
	public function getSettings() 
	{
				
		$q = $this->db->get('settings'); 
		  if( $q->num_rows() > 0 )
		  {
			return $q->row();
		  } 
		
		  return FALSE;

	}
	
	public function getDateFormats() 
	{
		$q = $this->db->get('date_format');
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
	}
	
	public function updateSetting($data)
	{

		$this->db->where('setting_id', '1');
		if($this->db->update('settings', $data)) {
			return true;
		} else {
			return false;
		}
	}
	
	public function addTaxRate($data)
	{

			$taxData = array(
				'name'	     	=> $data['name'],
				'rate' 			=> $data['rate'],
				'type' 			=> $data['type']
			);

		if($this->db->insert('tax_rates', $taxData)) {
			return true;
		} else {
			return false;
		}
	}
	
	public function updateTaxRate($id, $data = array())
	{
		
		$taxData = array(
				'name'	     	=> $data['name'],
				'rate' 			=> $data['rate'],
				'type' 			=> $data['type']
			);
			
		$this->db->where('id', $id);
		if($this->db->update('tax_rates', $taxData)) {
			return true;
		} else {
			return false;
		}
	}
	
	public function getAllTaxRates() 
	{
		$q = $this->db->get('tax_rates');
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
	}
	
	public function getTaxRateByID($id) 
	{

		$q = $this->db->get_where('tax_rates', array('id' => $id), 1); 
		  if( $q->num_rows() > 0 )
		  {
			return $q->row();
		  } 
		
		  return FALSE;

	}
	
	public function addInvoiceType($data)
	{

			$typeData = array(
				'name'	     	=> $data['name'],
				'type' 			=> $data['type']
			);

		if($this->db->insert('invoice_types', $typeData)) {
			return true;
		} else {
			return false;
		}
	}
	
	public function updateInvoiceType($id, $data = array())
	{
		
		$typeData = array(
				'name'	     	=> $data['name'],
				'type' 			=> $data['type']
			);
			
		$this->db->where('id', $id);
		if($this->db->update('invoice_types', $typeData)) {
			return true;
		} else {
			return false;
		}
	}
	
	public function getAllInvoiceTypes() 
	{
		$q = $this->db->get('invoice_types');
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
	}
	
	public function getInvoiceTypeByID($id) 
	{

		$q = $this->db->get_where('invoice_types', array('id' => $id), 1); 
		  if( $q->num_rows() > 0 )
		  {
			return $q->row();
		  } 
		
		  return FALSE;

	}
	
	public function addWarehouse($data)
	{

			$warehouseData = array(
				'code'	     	=> $data['code'],
				'name'	     	=> $data['name'],
				'address' 		=> $data['address'],
				'city' 			=> $data['city']
			);

		if($this->db->insert('warehouses', $warehouseData)) {
			return true;
		} else {
			return false;
		}
	}
	
	public function updateWarehouse($id, $data = array())
	{
		
		$warehouseData = array(
				'code'	     	=> $data['code'],
				'name'	     	=> $data['name'],
				'address' 		=> $data['address'],
				'city' 			=> $data['city']
			);
			
		$this->db->where('id', $id);
		if($this->db->update('warehouses', $warehouseData)) {
			return true;
		} else {
			return false;
		}
	}
	
	public function getAllWarehouses() 
	{
		$q = $this->db->get('warehouses');
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
	}
	
	public function getWarehouseByID($id) 
	{

		$q = $this->db->get_where('warehouses', array('id' => $id), 1); 
		  if( $q->num_rows() > 0 )
		  {
			return $q->row();
		  } 
		
		  return FALSE;

	}
	
	public function deleteTaxRate($id) 
	{
		if($this->db->delete('tax_rates', array('id' => $id))) {
			return true;
		}
	return FALSE;
	}
	
	public function deleteInvoiceType($id) 
	{
		if($this->db->delete('invoice_types', array('id' => $id))) {
			return true;
		}
	return FALSE;
	}
	
	public function deleteWarehouse($id) 
	{
		if($this->db->delete('warehouses', array('id' => $id)) && $this->db->delete('warehouses_products', array('warehouse_id' => $id))) {
			return true;
		}
	return FALSE;
	}
	
	public function addDiscount($data)
	{

			$discountData = array(
				'name'	     	=> $data['name'],
				'discount' 		=> $data['discount'],
				'type' 			=> $data['type']
			);

		if($this->db->insert('discounts', $discountData)) {
			return true;
		} else {
			return false;
		}
	}
	
	public function updateDiscount($id, $data = array())
	{
		
		$discountData = array(
				'name'	     	=> $data['name'],
				'discount' 		=> $data['discount'],
				'type' 			=> $data['type']
			);
			
		$this->db->where('id', $id);
		if($this->db->update('discounts', $discountData)) {
			return true;
		} else {
			return false;
		}
	}
	
	public function getAllDiscounts() 
	{
		$q = $this->db->get('discounts');
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
	}
	
	public function getDiscountByID($id) 
	{

		$q = $this->db->get_where('discounts', array('id' => $id), 1); 
		  if( $q->num_rows() > 0 )
		  {
			return $q->row();
		  } 
		
		  return FALSE;

	}
	
	public function deleteDiscount($id) 
	{
		if($this->db->delete('discounts', array('id' => $id))) {
			return true;
		}
	return FALSE;
	}

}
