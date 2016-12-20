<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/*
| -----------------------------------------------------
| PRODUCT NAME: 	STOCK MANAGER ADVANCE 
| -----------------------------------------------------
| AUTHER:			MIAN SALEEM 
| -----------------------------------------------------
| EMAIL:			quoteem@tecdiary.com 
| -----------------------------------------------------
| COPYRIGHTS:		RESERVED BY TECDIARY IT SOLUTIONS
| -----------------------------------------------------
| WEBSITE:			http://tecdiary.net
| -----------------------------------------------------
|
| MODULE: 			Inventories
| -----------------------------------------------------
| This is inventories module's model file.
| -----------------------------------------------------
*/


class Quotes_model extends CI_Model
{
	
	
	public function __construct()
	{
		parent::__construct();

	}
	
	public function getAllBillers() 
	{
		$q = $this->db->get('billers');
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
	}
	
	public function getProductsByCode($code) 
	{
		$this->db->select('*')->from('products')->like('code', $code, 'both');
		$q = $this->db->get();
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
	}
	
	public function getNextAI() 
	{
		$this->db->select_max('id');
		$q = $this->db->get('quotes');
		if( $q->num_rows() > 0 )
		  {
			$row = $q->row();
			//return QUOTE_REF."-".date('Y')."-".sprintf("%03s", $row->id+1);
			return QUOTE_REF."-".sprintf("%04s", $row->id+1);
		  } 
				
			return FALSE;

	}
	
	public function getBillerByID($id) 
	{

		$q = $this->db->get_where('billers', array('id' => $id), 1); 
		  if( $q->num_rows() > 0 )
		  {
			return $q->row();
		  } 
		
		  return FALSE;

	}
	
	public function getProductByCode($code) 
	{

		$q = $this->db->get_where('products', array('code' => $code), 1); 
		  if( $q->num_rows() > 0 )
		  {
			return $q->row();
		  } 
		
		  return FALSE;

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
	
	public function getCustomerByID($id) 
	{

		$q = $this->db->get_where('customers', array('id' => $id), 1); 
		  if( $q->num_rows() > 0 )
		  {
			return $q->row();
		  } 
		
		  return FALSE;

	}
	
	public function getAllProducts() 
	{
		$this->db->select('*')->from('products')->order_by('id', 'asc');
		$q = $this->db->get();
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
	}
	
	public function getProductByID($id) 
	{

		$q = $this->db->get_where('products', array('id' => $id), 1); 
		  if( $q->num_rows() > 0 )
		  {
			return $q->row();
		  } 
		
		  return FALSE;

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

	public function getItemByID($id)
	{

		$q = $this->db->get_where('quote_items', array('id' => $id), 1); 
		  if( $q->num_rows() > 0 )
		  {
			return $q->row();
		  } 
		
		  return FALSE;

	}
	
	public function getAllQuotes() 
	{
		$q = $this->db->get('quotes');
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
	}
		
	public function getQuoteByID($id)
	{

		$q = $this->db->get_where('quotes', array('id' => $id), 1); 
		  if( $q->num_rows() > 0 )
		  {
			return $q->row();
		  } 
		
		  return FALSE;

	}

	public function getAllQuoteItems($quote_id) 
	{
		$q = $this->db->get_where('quote_items', array('quote_id' => $quote_id));
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
	}
        
        public function getAllQuoteItemsWithDetails($quote_id) 
	{
            $this->db->select('quote_items.id, quote_items.product_name, quote_items.product_code, quote_items.quantity, quote_items.tax, quote_items.unit_price, quote_items.val_tax, quote_items.discount_val, quote_items.gross_total, products.details');	
            $this->db->join('products', 'products.id=quote_items.product_id', 'left');
            $this->db->order_by('id', 'asc');
		$q = $this->db->get_where('quote_items', array('quote_id' => $quote_id));
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
	}
	
	
	
	public function addQuote($quoteDetails = array(), $items = array(), $warehouse_id)
	{
			
		// quote data
		$quoteData = array(
			'reference_no'			=> $quoteDetails['reference_no'],
			'warehouse_id'			=> $warehouse_id,
		    'biller_id'				=> $quoteDetails['biller_id'],
			'biller_name'			=> $quoteDetails['biller_name'],
			'customer_id'			=> $quoteDetails['customer_id'],
			'customer_name'			=> $quoteDetails['customer_name'],
			'date'					=> $quoteDetails['date'],
			'note'	  	 			=> $quoteDetails['note'],
			'internal_note'	  	 	=> $quoteDetails['internal_note'],
			'inv_total'				=> $quoteDetails['inv_total'],
			'total_tax'				=> $quoteDetails['total_tax'],
			'total'					=> $quoteDetails['total'],
			'total_tax2'			=> $quoteDetails['total_tax2'],
			'tax_rate2_id'			=> $quoteDetails['tax_rate2_id'],
			'inv_discount'			=> $quoteDetails['inv_discount'],
			'discount_id'			=> $quoteDetails['discount_id'],
			'user'					=> $quoteDetails['user'],
			'shipping'				=> $quoteDetails['shipping']
		);

		if($this->db->insert('quotes', $quoteData)) {
			$quote_id = $this->db->insert_id();
			
			$addOn = array('quote_id' => $quote_id);
					end($addOn);
					foreach ( $items as &$var ) {
						$var = array_merge($addOn, $var);
			}
				
			if($this->db->insert_batch('quote_items', $items)) {
				return true;
			}
		}
		
		return false;
	}
	
	public function updateQuote($id, $quoteDetails, $items = array(), $warehouse_id)
	{
				
			
			// quote data
			$quoteData = array(
				'reference_no'			=> $quoteDetails['reference_no'],
				'biller_id'				=> $quoteDetails['biller_id'],
				'biller_name'			=> $quoteDetails['biller_name'],
				'customer_id'			=> $quoteDetails['customer_id'],
				'customer_name'			=> $quoteDetails['customer_name'],
				'date'					=> $quoteDetails['date'],
				'note'	  	 			=> $quoteDetails['note'],
				'internal_note'	  	 	=> $quoteDetails['internal_note'],
				'inv_total'				=> $quoteDetails['inv_total'],
				'total_tax'				=> $quoteDetails['total_tax'],
				'total'					=> $quoteDetails['total'],
				'total_tax2'			=> $quoteDetails['total_tax2'],
				'tax_rate2_id'			=> $quoteDetails['tax_rate2_id'],
				'inv_discount'			=> $quoteDetails['inv_discount'],
				'discount_id'			=> $quoteDetails['discount_id'],
				'updated_by'			=> $quoteDetails['user'],
				'shipping'				=> $quoteDetails['shipping']
			);
			
			$this->db->where('id', $id);
			if($this->db->update('quotes', $quoteData) && $this->db->delete('quote_items', array('quote_id' => $id))) {
							
				$addOn = array('quote_id' => $id);
					end($addOn);
					foreach ( $items as &$var ) {
							$var = array_merge($addOn, $var);
					}
			
			
				if($this->db->insert_batch('quote_items', $items)) {
					return true;
				}

		}
	
		return false;
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
	

	public function deleteQuote($id)
	{
	       
	    if($this->db->delete('quote_items', array('quote_id' => $id)) && $this->db->delete('quotes', array('id' => $id))) {
	        return true;
	    }
			
	return FALSE;
	}     
	
	public function getProductNames($term)
    {
	   	$this->db->select('name');
	    $this->db->like('name', $term, 'both');
   		$q = $this->db->get('products');
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data; 
		}
    }
	public function getProductByName($name)
	{

		$q = $this->db->get_where('products', array('name' => $name), 1); 
		  if( $q->num_rows() > 0 )
		  {
			return $q->row();
		  } 
		
		  return FALSE;

	}
        
        public function getWarehouseProductQuantity($warehouse_id, $product_id)
	{

		$q = $this->db->get_where('warehouses_products', array('warehouse_id' => $warehouse_id, 'product_id' => $product_id), 1); 
		  if( $q->num_rows() > 0 )
		  {
			return $q->row();
		  } 
		
		  return FALSE;

	}
        
        public function getProductCodes($term)
    {
	   	$this->db->select('code');
	    $this->db->like('code', $term, 'both')->limit('10');
   		$q = $this->db->get('products');
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data; 
		}
    }
	
}
