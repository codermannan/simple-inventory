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
| MODULE: 			Inventories
| -----------------------------------------------------
| This is inventories module's model file.
| -----------------------------------------------------
*/


class Sales_model extends CI_Model
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
		$q = $this->db->get('sales');
		if( $q->num_rows() > 0 )
		  {
			$row = $q->row();
			//return SALES_REF."-".date('Y')."-".sprintf("%03s", $row->id+1);
			return SALES_REF."-".sprintf("%04s", $row->id+1);
			
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
	public function getAllInvoiceTypesFor() 
	{
		$q = $this->db->get_where('invoice_types', array('type' => 'real'));
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
	
	public function updateProductQuantity($product_id, $warehouse_id, $quantity)
	{

		// update the product with new details
		if($this->addQuantity($product_id, $warehouse_id, $quantity))
		{
			return true;
		} 
			
			return false;
	}
	
	public function calculateAndUpdateQuantity($item_id, $product_id, $quantity, $warehouse_id)
	{
		//check if entry exist then update else inster
		if($this->getProductQuantity($product_id, $warehouse_id)) {
			
			//get product details to calculate quantity
			$warehouse_quantity = $this->getProductQuantity($product_id, $warehouse_id);	
			$warehouse_quantity = $warehouse_quantity['quantity'];
			$item_details = $this->getItemByID($item_id);
			$item_quantity = $item_details->quantity;
			$after_quantity = $warehouse_quantity + $item_quantity;
			$new_quantity = $after_quantity - $quantity;
			
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
	
	public function CalculateOldQuantity($item_id, $product_id, $quantity, $warehouse_id)
	{

			
			//get product details to calculate quantity
			$warehouse_quantity = $this->getProductQuantity($product_id, $warehouse_id);	
			$warehouse_quantity = $warehouse_quantity['quantity'];
			$item_details = $this->getItemByID($item_id);
			$item_quantity = $item_details->quantity;
			$after_quantity = $warehouse_quantity + $item_quantity;
			
			
			if($this->updateQuantity($product_id, $warehouse_id, $after_quantity)){
					return TRUE;
			}
			

		
		return FALSE;
	}
	public function addQuantity($product_id, $warehouse_id, $quantity) 
	{
		
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
		
		//$this->db->where('product_id', $id);		
		if($this->db->update('warehouses_products', $productData, array('product_id' => $product_id, 'warehouse_id' => $warehouse_id))) {
			return true;
		} else {
			return false;
		}
	}
	public function getProductQuantity($product_id, $warehouse) 
	{
		$q = $this->db->get_where('warehouses_products', array('product_id' => $product_id, 'warehouse_id' => $warehouse), 1); 
		
		  if( $q->num_rows() > 0 )
		  {
			return $q->row_array(); //$q->row();
		  } 
		
		  return FALSE;
		
	}
	
	
	/*public function updateProduct($id, $quantity)
	{
		
		// Product data 
		$productData = array(
		    'quantity'	     	=> $quantity,
		);
		
		$this->db->where('id', $id);
		if($this->db->update('products', $productData)) {
			return true;
		} 
			
			return false;

	}*/
	
	public function getItemByID($id)
	{

		$q = $this->db->get_where('sale_items', array('id' => $id), 1); 
		  if( $q->num_rows() > 0 )
		  {
			return $q->row();
		  } 
		
		  return FALSE;

	}
	
	public function getAllSales() 
	{
		$q = $this->db->get('sales');
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
	}
	
	
	public function getmonthlyPurchases() 
	{
		$myQuery = "SELECT date_format( date, '%b' ) as month, SUM( total ) as purchases FROM purchases WHERE date >= date_sub( now( ) , INTERVAL 12 MONTH ) GROUP BY date_format( date, '%b' ) ORDER BY date_format( date, '%m' ) ASC";
		$q = $this->db->query($myQuery);
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
	}
	
	public function getmonthlySales() 
	{
		$myQuery = "SELECT date_format( date, '%b' ) as month, SUM( total ) as sales FROM sales WHERE in_type = 'real' AND date >= date_sub( now( ) , INTERVAL 12 MONTH ) GROUP BY date_format( date, '%b' ) ORDER BY date_format( date, '%m' ) ASC";
		$q = $this->db->query($myQuery);
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
	}
	
	public function getAllInvoiceItems($sale_id) 
	{
		$this->db->order_by('id', 'asc');
		$q = $this->db->get_where('sale_items', array('sale_id' => $sale_id));
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
	}
        
        public function getAllInvoiceItemsWithDetails($sale_id) 
	{
            $this->db->select('sale_items.id, sale_items.product_name, sale_items.product_code, sale_items.quantity, sale_items.serial_no, sale_items.tax, sale_items.unit_price, sale_items.val_tax, sale_items.discount_val, sale_items.gross_total, products.details');	
            $this->db->join('products', 'products.id=sale_items.product_id', 'left');
            $this->db->order_by('id', 'asc');
		$q = $this->db->get_where('sale_items', array('sale_id' => $sale_id));
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
	}
        
	public function getInvoiceByID($id)
	{

		$q = $this->db->get_where('sales', array('id' => $id), 1); 
		  if( $q->num_rows() > 0 )
		  {
			return $q->row();
		  } 
		
		  return FALSE;

	}

	
	public function getInvoiceBySaleID($sale_id)
	{

		$q = $this->db->get_where('sales', array('id' => $sale_id), 1); 
		  if( $q->num_rows() > 0 )
		  {
			return $q->row();
		  } 
		
		  return FALSE;

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
	
	public function getQuoteByQID($id)
	{
		$this->db->select("reference_no, warehouse_id, biller_id, biller_name, customer_id, customer_name, date, note, inv_total, total_tax, total");
		$this->db->from('quotes');
		$this->db->where('id', $id);
		$this->db->limit(1);
		$q = $this->db->get(); 
		  if( $q->num_rows() > 0 )
		  {
			return $q->row_array();
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
	public function nsQTY($product_id, $quantity) {
		$prD = $this->getProductByID($product_id);
		$nQTY = $prD->quantity - $quantity;
		$this->db->update('products', array('quantity' => $nQTY), array('id' => $product_id));
	}
	
	public function addSale($saleDetails = array(), $items = array(), $warehouse_id)
	{
			
		// sale data
		$saleData = array(
			'reference_no'			=> $saleDetails['reference_no'],
			'warehouse_id'			=> $warehouse_id,
		    'biller_id'				=> $saleDetails['biller_id'],
			'biller_name'			=> $saleDetails['biller_name'],
			'customer_id'			=> $saleDetails['customer_id'],
			'customer_name'			=> $saleDetails['customer_name'],
			'date'					=> $saleDetails['date'],
			'note'	  	 			=> $saleDetails['note'],
			'internal_note'	  	 	=> $saleDetails['internal_note'],
			'inv_total'				=> $saleDetails['inv_total'],
			'total_tax'				=> $saleDetails['total_tax'],
			'total'					=> $saleDetails['total'],
			'total_tax2'			=> $saleDetails['total_tax2'],
			'tax_rate2_id'			=> $saleDetails['tax_rate2_id'],
			'inv_discount'			=> $saleDetails['inv_discount'],
			'discount_id'			=> $saleDetails['discount_id'],
			'user'					=> $saleDetails['user'],
			'shipping'				=> $saleDetails['shipping']
		);

		if($this->db->insert('sales', $saleData)) {
			$sale_id = $this->db->insert_id();
						
			foreach($items as $idata){
				$this->nsQTY($idata['product_id'], $idata['quantity']);
				$this->updateProductQuantity($idata['product_id'], $warehouse_id, $idata['quantity']);
			}
			
			$addOn = array('sale_id' => $sale_id);
					end($addOn);
					foreach ( $items as &$var ) {
						$var = array_merge($addOn, $var);
			}
				
			if($this->db->insert_batch('sale_items', $items)) {
				return true;
			}
		}
		
		return false;
	}
	
	public function usQTY($product_id, $quantity) {
		$prD = $this->getProductByID($product_id);
		$nQTY = $prD->quantity + $quantity;
		$this->db->update('products', array('quantity' => $nQTY), array('id' => $product_id));
	}
	
	public function updateSale($id, $saleDetails, $items = array(), $warehouse_id)
	{
				
			if($old_items = $this->getAllInvoiceItems($id)){
				foreach($old_items as $data){
					$item_id = $data->id;
					$item_qiantity = $data->quantity;
					$product_id = $data->product_id;
					$pr_qty_details = $this->getProductQuantity($product_id, $warehouse_id);
					$pr_qty = $pr_qty_details['quantity'];
					$qty = $pr_qty + $item_qiantity;
				
					$this->updateQuantity($product_id, $warehouse_id, $qty);
					$this->usQTY($product_id, $item_qiantity);
				}
			}
			
			// sale data
			$saleData = array(
				'reference_no'			=> $saleDetails['reference_no'],
				'biller_id'				=> $saleDetails['biller_id'],
				'biller_name'			=> $saleDetails['biller_name'],
				'customer_id'			=> $saleDetails['customer_id'],
				'customer_name'			=> $saleDetails['customer_name'],
				'date'					=> $saleDetails['date'],
				'note'	  	 			=> $saleDetails['note'],
				'internal_note'	  	 	=> $saleDetails['internal_note'],
				'inv_total'				=> $saleDetails['inv_total'],
				'total_tax'				=> $saleDetails['total_tax'],
				'total'					=> $saleDetails['total'],
				'total_tax2'			=> $saleDetails['total_tax2'],
				'tax_rate2_id'			=> $saleDetails['tax_rate2_id'],
				'inv_discount'			=> $saleDetails['inv_discount'],
				'discount_id'			=> $saleDetails['discount_id'],
				'updated_by'			=> $saleDetails['user'],
				'shipping'				=> $saleDetails['shipping']
			);
			
			$this->db->where('id', $id);
			if($this->db->update('sales', $saleData) && $this->db->delete('sale_items', array('sale_id' => $id))) {
				foreach($items as $idata){
					$this->nsQTY($idata['product_id'], $idata['quantity']);
					$this->updateProductQuantity($idata['product_id'], $warehouse_id, $idata['quantity']);
				}
						
				$addOn = array('sale_id' => $id);
					end($addOn);
					foreach ( $items as &$var ) {
							$var = array_merge($addOn, $var);
					}
			
				if($this->db->insert_batch('sale_items', $items)) {
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
	
	public function deleteInvoice($id)
	    {
	        $inv = $this->getInvoiceByID($id);
	        $warehouse_id = $inv->warehouse_id;
	        $items = $this->getAllInvoiceItems($id);
	       
	        foreach($items as $item) {
	            $product_id = $item->product_id;
	            $item_details = $this->getProductQuantity($product_id, $warehouse_id);
	            $pr_quantity = $item_details['quantity'];
	            $inv_quantity = $item->quantity;
	            $new_quantity = $pr_quantity + $inv_quantity;
	           
	            $this->updateQuantity($product_id, $warehouse_id, $new_quantity);
                    $this->usQTY($product_id, $item->quantity);
	        }
	       
	        if($this->db->delete('sale_items', array('sale_id' => $id)) && $this->db->delete('sales', array('id' => $id))) {
	            return true;
	        }
	    return FALSE;
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
	   	$this->db->select('name')->limit('10');
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
	
	public function addDelivery($data = array())
	{
		if($this->db->insert('deliveries', $data)) {
				return true;
		}
		
		return false;
	}
	
	public function updateDelivery($id, $data = array())
	{
		$this->db->where('id', $id);
		if($this->db->update('deliveries', $data)) {
				return true;
		}
		
		return false;
	}
	
	public function getDeliveryByID($id)
	{

		$q = $this->db->get_where('deliveries', array('id' => $id), 1); 
		  if( $q->num_rows() > 0 )
		  {
			return $q->row();
		  } 
		
		  return FALSE;

	}
	
		public function deleteDelivery($id)
	    {
	       
	        if($this->db->delete('deliveries', array('id' => $id))) {
	            return true;
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
