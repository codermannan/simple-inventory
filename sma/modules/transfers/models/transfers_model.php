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
| MODULE: 			Transfers
| -----------------------------------------------------
| This is transfers module model file.
| -----------------------------------------------------
*/


class Transfers_model extends CI_Model
{
	
	
	public function __construct()
	{
		parent::__construct();

	}
	
	public function getAllProducts() 
	{
		$q = $this->db->get('products');
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
	
	public function getProductByCategoryID($id) 
	{

		$q = $this->db->get_where('products', array('category_id' => $id), 1); 
		  if( $q->num_rows() > 0 )
		  {
			return true;
		  } 
		
		  return FALSE;

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
		$q = $this->db->get('transfers');
		if( $q->num_rows() > 0 )
		  {
			$row = $q->row();
			//return QUOTE_REF."-".date('Y')."-".sprintf("%03s", $row->id+1);
			return TRANSFER_REF."-".sprintf("%04s", $row->id+1);
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
	
	public function getProductNames($term)
    {
	   	$this->db->select('name');
	    $this->db->like('name', $term, 'both')->limit('10');
   		$q = $this->db->get('products');
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data; 
		}
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
	
	public function getProductByName($name)
	{

		$q = $this->db->get_where('products', array('name' => $name), 1); 
		  if( $q->num_rows() > 0 )
		  {
			return $q->row();
		  } 
		
		  return FALSE;

	}	
	
	
	public function getAllTransfers() 
	{
		$q = $this->db->get('transfers');
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
	}
	
	
	public function getProductQuantity($product_id, $warehouse = DEFAULT_WAREHOUSE) 
	{
		$q = $this->db->get_where('warehouses_products', array('product_id' => $product_id, 'warehouse_id' => $warehouse), 1); 
		
		  if( $q->num_rows() > 0 )
		  {
			return $q->row_array(); //$q->row();
		  } 
		
		  return FALSE;
		
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
	
	public function getTransferByID($id) 
	{

		$q = $this->db->get_where('transfers', array('id' => $id), 1); 
		  if( $q->num_rows() > 0 )
		  {
			return $q->row();
		  } 
		
		  return FALSE;

	}
	
	public function getAllTransferItems($transfer_id) 
	{
		$q = $this->db->get_where('transfer_items', array('transfer_id' => $transfer_id));
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
	}
	
	
	
	public function getProductsByName($name, $limit, $start) {
        $this->db->limit($limit, $start);
		$this->db->order_by("id", "desc"); 
        $this->db->like("name", $name); 
        $query = $this->db->get('products');
		
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
   }
	
	public function searched_products_count($name) {
		$this->db->like("name", $name); 
        $query = $this->db->get('products');
        return $query->num_rows();
    }

	
	
	
	public function transferQuantity($product_id, $warehouseFrom, $warehouseTo, $quantity) 
	{

		//check if entry exist then update else inster
		if($this->getProductQuantity($product_id, $warehouseTo)) {
			
			$to_product_details = $this->getProductQuantity($product_id, $warehouseTo);
			$to_old_quantity = $to_product_details['quantity'];
			$to_quantity = $to_old_quantity + $quantity;
			
			$from_product_details = $this->getProductQuantity($product_id, $warehouseFrom);
			$from_old_quantity = $from_product_details['quantity'];
			$from_quantity = $from_old_quantity - $quantity;
			
			if($this->updateQuantity($product_id, $warehouseTo, $to_quantity) && $this->updateQuantity($product_id, $warehouseFrom, $from_quantity)){
				return TRUE;
			}
			
		} else {
			
			$from_product_details = $this->getProductQuantity($product_id, $warehouseFrom);
			$from_old_quantity = $from_product_details['quantity'];
			$from_quantity = $from_old_quantity - $quantity;
			
			if($this->insertQuantity($product_id, $warehouseTo, $quantity) && $this->updateQuantity($product_id, $warehouseFrom, $from_quantity)){
				return TRUE;
			}
		}
		
		return FALSE;

	}
	
	public function transferProducts($transferDetails = array(), $items = array())
	{
		
		
			foreach($items as $item){
				$product_id = $item['product_id'];
				$product_quantity = $item['quantity'];
				$from_warehouse_id = $transferDetails['from_warehouse_id'];
				$to_warehouse_id = $transferDetails['to_warehouse_id'];
				
					$this->updateFromWarehouseQuantity($product_id, $from_warehouse_id, $product_quantity);
					$this->updateToWarehouseQuantity($product_id, $to_warehouse_id, $product_quantity);

			}

		
		// sale data
		$transferData = array(
			'transfer_no'			=> $transferDetails['transfer_no'],
		    'date'					=> $transferDetails['date'],
			'from_warehouse_id'		=> $transferDetails['from_warehouse_id'],
			'from_warehouse_code'	=> $transferDetails['from_warehouse_code'],
			'from_warehouse_name'	=> $transferDetails['from_warehouse_name'],
			'to_warehouse_id'		=> $transferDetails['to_warehouse_id'],
			'to_warehouse_code'	  	=> $transferDetails['to_warehouse_code'],
			'to_warehouse_name'		=> $transferDetails['to_warehouse_name'],
			'note'					=> $transferDetails['note'],
			'user'					=> USER_NAME,
                    'total_tax'					=> $transferDetails['total_tax'],
                    'tr_total'					=> $transferDetails['tr_total'],
                    'total'					=> $transferDetails['total'],
		);

		if($this->db->insert('transfers', $transferData)) {
			$transfer_id = $this->db->insert_id();
			
			$addOn = array('transfer_id' => $transfer_id);
					end($addOn);
					foreach ( $items as &$var ) {
						$var = array_merge($addOn, $var);
					}
				
			if($this->db->insert_batch('transfer_items', $items)) {
				return true;
			}
		}
		return false;
	}
	
	public function updateToWarehouseQuantity($product_id, $warehouse_id, $quantity)
	{
		//check if entry exist then update else inster
		if($this->getProductQuantity($product_id, $warehouse_id)) {
			
			//get product details to calculate nwe quantity
			$warehouse_quantity = $this->getProductQuantity($product_id, $warehouse_id);	
			$warehouse_quantity = $warehouse_quantity['quantity'];
			$new_quantity = $warehouse_quantity + $quantity;
			
			if($this->updateQuantity($product_id, $warehouse_id, $new_quantity)){
					return TRUE;
			}
			
		} else {
						
			if($this->insertQuantity($product_id, $warehouse_id, $quantity)){
				return TRUE;
			}
		}
		
		return FALSE;
	}
	
	
	public function updateFromWarehouseQuantity($product_id, $warehouse_id, $quantity)
	{
		//check if entry exist then update else inster
		if($this->getProductQuantity($product_id, $warehouse_id)) {
			
			//get product details to calculate nwe quantity
			$warehouse_quantity = $this->getProductQuantity($product_id, $warehouse_id);	
			$warehouse_quantity = $warehouse_quantity['quantity'];
			$new_quantity = $warehouse_quantity - $quantity;
			
			if($this->updateQuantity($product_id, $warehouse_id, $new_quantity)){
					return TRUE;
			}
			
		} else {
						
			if($this->insertQuantity($product_id, $warehouse_id, -$quantity)){
				return TRUE;
			}
		}
		
		return FALSE;
	}
	
	public function addQuantity($product_id, $warehouse_id, $quantity) 
	{

		//check if entry exist then update else inster
		if($this->getProductQuantity($product_id, $warehouse_id)) {
			
		$warehouse_quantity = $this->getProductQuantity($product_id, $warehouse_id);	
		$old_quantity = $warehouse_quantity['quantity'];		
		$new_quantity = $old_quantity - $quantity;
					
			if($this->updateQuantity($product_id, $warehouse_id, $new_quantity)){
				return TRUE;
			}
			
		} else {
						
			if($this->insertQuantity($product_id, $warehouse_id, -$quantity)){
				return TRUE;
			}
		}
		
		return FALSE;

	}
	
	public function insertQuantity($product_id, $warehouse_id, $quantity)
	{	

			// Product data
			$productData = array(
				'product_id'	     		=> $product_id,
				'warehouse_id'   			=> $warehouse_id,
				'quantity' 					=> $quantity
			);

		if($this->db->insert('warehouses_products', $productData)) {
			return true;
		} else {
			return false;
		}
	}
	
	
	public function updateQuantity($product_id, $warehouse_id, $quantity)
	{	

			$productData = array(
				'quantity'	     			=> $quantity
			);
		
		if($this->db->update('warehouses_products', $productData, array('product_id' => $product_id, 'warehouse_id' => $warehouse_id))) {
			return true;
		} else {
			return false;
		}
	}
		
	public function deleteTransfer($id) 
	{
		if($this->db->delete('transfers', array('id' => $id)) && $this->db->delete('transfer_items', array('transfer_id' => $id))) {
			return true;
		}
	return FALSE;
	}
	
	public function updateTransfer($id, $transferDetails = array(), $items = array())
	{
		
		$otransfer = $this->transfers_model->getTransferByID($id);
		$oitems = $this->transfers_model->getAllTransferItems($id);
		foreach($oitems as $oitem){
			$oproduct_id = $oitem->product_id;
			$oproduct_quantity = $oitem->quantity;
			$ofrom_warehouse_id = $otransfer->from_warehouse_id;
			$oto_warehouse_id = $otransfer->to_warehouse_id;
				$this->oupdateFromWarehouseQuantity($oproduct_id, $ofrom_warehouse_id, $oproduct_quantity);
				$this->oupdateToWarehouseQuantity($oproduct_id, $oto_warehouse_id, $oproduct_quantity);
		}
		
			foreach($items as $item){
				$product_id = $item['product_id'];
				$product_quantity = $item['quantity'];
				$from_warehouse_id = $transferDetails['from_warehouse_id'];
				$to_warehouse_id = $transferDetails['to_warehouse_id'];
					$this->updateFromWarehouseQuantity($product_id, $from_warehouse_id, $product_quantity);
					$this->updateToWarehouseQuantity($product_id, $to_warehouse_id, $product_quantity);
			}

		$transferData = array(
			'transfer_no'			=> $transferDetails['transfer_no'],
		    'date'					=> $transferDetails['date'],
			'from_warehouse_id'		=> $transferDetails['from_warehouse_id'],
			'from_warehouse_code'	=> $transferDetails['from_warehouse_code'],
			'from_warehouse_name'	=> $transferDetails['from_warehouse_name'],
			'to_warehouse_id'		=> $transferDetails['to_warehouse_id'],
			'to_warehouse_code'	  	=> $transferDetails['to_warehouse_code'],
			'to_warehouse_name'		=> $transferDetails['to_warehouse_name'],
			'note'					=> $transferDetails['note'],
                    'total_tax'					=> $transferDetails['total_tax'],
                    'tr_total'					=> $transferDetails['tr_total'],
                    'total'					=> $transferDetails['total'],
		);


		$this->db->where('id', $id);
		if($this->db->update('transfers', $transferData) && $this->db->delete('transfer_items', array('transfer_id' => $id))) {
						
			$addOn = array('transfer_id' => $id);
				end($addOn);
				foreach ( $items as &$var ) {
						$var = array_merge($addOn, $var);
				}
		
		
			if($this->db->insert_batch('transfer_items', $items)) {
				return true;
			}
		}
	
		return false;
	}
	
	public function oupdateToWarehouseQuantity($product_id, $warehouse_id, $quantity)
	{
		//check if entry exist then update else inster
		if($this->getProductQuantity($product_id, $warehouse_id)) {
			
			//get product details to calculate nwe quantity
			$warehouse_quantity = $this->getProductQuantity($product_id, $warehouse_id);	
			$warehouse_quantity = $warehouse_quantity['quantity'];
			$new_quantity = $warehouse_quantity - $quantity;
			
			if($this->updateQuantity($product_id, $warehouse_id, $new_quantity)){
					return TRUE;
			}
			
		} else {
						
			if($this->insertQuantity($product_id, $warehouse_id, $quantity)){
				return TRUE;
			}
		}
		
		return FALSE;
	}
	
	
	public function oupdateFromWarehouseQuantity($product_id, $warehouse_id, $quantity)
	{
		//check if entry exist then update else inster
		if($this->getProductQuantity($product_id, $warehouse_id)) {
			
			//get product details to calculate nwe quantity
			$warehouse_quantity = $this->getProductQuantity($product_id, $warehouse_id);	
			$warehouse_quantity = $warehouse_quantity['quantity'];
			$new_quantity = $warehouse_quantity + $quantity;
			
			if($this->updateQuantity($product_id, $warehouse_id, $new_quantity)){
					return TRUE;
			}
			
		} else {
						
			if($this->insertQuantity($product_id, $warehouse_id, $quantity)){
				return TRUE;
			}
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
	
}
