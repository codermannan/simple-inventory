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


class Products_model extends CI_Model
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
	
	public function getProductsByCode($code) 
	{
		$q = $this->db->query("SELECT * FROM products WHERE code LIKE '%{$code}%' ORDER BY code");
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
	
	public function getProductByCode($code) 
	{

		$q = $this->db->get_where('products', array('code' => $code), 1); 
		  if( $q->num_rows() > 0 )
		  {
			return $q->row();
		  } 
		
		  return FALSE;

	}
	
	public function addProduct($code, $name,  $photo, $data = array())
	{
		
		if($photo == NULL) {
			// Product data
			$productData = array(
				'code'	     			=> $data['code'],
				'name'   				=> $data['name'],
				'category_id'   		=> $data['category_id'],
				'subcategory_id'   		=> $data['subcategory_id'],
				'unit' 					=> $data['unit'],
				'size' 					=> $data['size'],
				'cost'	     			=> $data['cost'],
				'price'	     			=> $data['price'],
				'alert_quantity'   		=> $data['alert_quantity'],
				'tax_rate'   			=> $data['tax_rate'],
				'track_quantity'   		=> $data['track_quantity'],
				'cf1'   					=> $data['cf1'],
				'cf2'   					=> $data['cf2'],
				'cf3'   					=> $data['cf3'],
				'cf4'   					=> $data['cf4'],
				'cf5'   					=> $data['cf5'],
				'cf6'   					=> $data['cf6'],
                                'details'   					=> $data['details']
			);
		} else {
			// Product data
			$productData = array(
				'code'	     			=> $data['code'],
				'name'   				=> $data['name'],
				'category_id'   		=> $data['category_id'],
				'subcategory_id'   		=> $data['subcategory_id'],
				'unit' 					=> $data['unit'],
				'size' 					=> $data['size'],
				'cost'	     			=> $data['cost'],
				'price'	     			=> $data['price'],
				'alert_quantity'   		=> $data['alert_quantity'],
				'tax_rate'   			=> $data['tax_rate'],
				'track_quantity'   		=> $data['track_quantity'],
				'cf1'   					=> $data['cf1'],
				'cf2'   					=> $data['cf2'],
				'cf3'   					=> $data['cf3'],
				'cf4'   					=> $data['cf4'],
				'cf5'   					=> $data['cf5'],
				'cf6'   					=> $data['cf6'],
                                'details'   					=> $data['details'],
				'image'   				=> $photo
			);
		}

		if($this->db->insert('products', $productData)) {
			return true;
		} else {
			return false;
		}
	}
	
	public function add_products($data = array())
	{
		
		if($this->db->insert_batch('products', $data)) {
			return true;
		} else {
			return false;
		}
	}
	
	public function updatePrice($data = array())
	{
		
		if($this->db->update_batch('products', $data, 'code')) {
			return true;
		} else {
			return false;
		}
	}
	
	public function updateProduct($id, $photo, $data = array())
	{
		
		
		if($photo == NULL) {
			// Product data
			$productData = array(
				'code'	     			=> $data['code'],
				'name'   				=> $data['name'],
				'category_id'   		=> $data['category_id'],
				'subcategory_id'   		=> $data['subcategory_id'],
				'unit' 					=> $data['unit'],
				'size' 					=> $data['size'],
				'cost'	     			=> $data['cost'],
				'price'	     			=> $data['price'],
				'alert_quantity'   		=> $data['alert_quantity'],
				'tax_rate'   			=> $data['tax_rate'],
				'track_quantity'   		=> $data['track_quantity'],
				'cf1'   					=> $data['cf1'],
				'cf2'   					=> $data['cf2'],
				'cf3'   					=> $data['cf3'],
				'cf4'   					=> $data['cf4'],
				'cf5'   					=> $data['cf5'],
				'cf6'   					=> $data['cf6'],
                                'details'   					=> $data['details']
			);
		} else {
			// Product data
			$productData = array(
				'code'	     			=> $data['code'],
				'name'   				=> $data['name'],
				'category_id'   		=> $data['category_id'],
				'subcategory_id'   		=> $data['subcategory_id'],
				'unit' 					=> $data['unit'],
				'size' 					=> $data['size'],
				'cost'	     			=> $data['cost'],
				'price'	     			=> $data['price'],
				'alert_quantity'   		=> $data['alert_quantity'],
				'tax_rate'   			=> $data['tax_rate'],
				'track_quantity'   		=> $data['track_quantity'],
				'cf1'   					=> $data['cf1'],
				'cf2'   					=> $data['cf2'],
				'cf3'   					=> $data['cf3'],
				'cf4'   					=> $data['cf4'],
				'cf5'   					=> $data['cf5'],
				'cf6'   					=> $data['cf6'],
                                'details'   					=> $data['details'],
				'image'   				=> $photo
			);
		}
		
		
		$this->db->where('id', $id);
		if($this->db->update('products', $productData)) {
			return true;
		} else {
			return false;
		}
	}
	
	public function deleteProduct($id) 
	{
		if($this->db->delete('products', array('id' => $id)) && $this->db->delete('warehouses_products', array('product_id' => $id)) ) {
			return true;
		}
	return FALSE;
	}
	
	
	
	public function getAllCategories() 
	{
		$q = $this->db->get('categories');
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
	}
	
	public function totalCategoryProducts($category_id) 
	{
		$q = $this->db->get_where('products', array('category_id' => $category_id));
				
			return $q->num_rows();
		
	}
	
	public function getCategoryByID($id) 
	{
		$q = $this->db->get_where('categories', array('id' => $id), 1); 
		  if( $q->num_rows() > 0 )
		  {
			return $q->row();
		  } 
		
		  return FALSE;

	}
	
	public function getCategoryByCode($code) 
	{
		$q = $this->db->get_where('categories', array('code' => $code), 1); 
		  if( $q->num_rows() > 0 )
		  {
			return $q->row();
		  } 
		
		  return FALSE;

	}
        
        public function getTaxRateByName($name) 
	{
		$q = $this->db->get_where('tax_rates', array('name' => $name), 1); 
		  if( $q->num_rows() > 0 )
		  {
			return $q->row();
		  } 
		
		  return FALSE;

	}
	
	
	public function getSubCategoriesByCategoryID($category_id) 
	{
		$q = $this->db->get_where("subcategories", array('category_id' => $category_id));
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
		
		return FALSE;
	}
	
	public function getDamagePdByID($id) 
	{

		$q = $this->db->get_where('damage_products', array('id' => $id), 1); 
		  if( $q->num_rows() > 0 )
		  {
			return $q->row();
		  } 
		
		  return FALSE;

	}
	
	public function addDamage($product_id, $date, $quantity, $warehouse, $note)
	{
		
		if($wh_qty_details = $this->getProductQuantity($product_id, $warehouse)) {
			$balance_qty = $wh_qty_details['quantity'] - $quantity;
			$this->updateQuantity($product_id, $warehouse, $balance_qty);
		} else {
			$balance_qty = 0 - $quantity;
			$this->insertQuantity($product_id, $warehouse, $balance_qty);
		}
                $prd = $this->getProductByID($product_id);
                $nQTY = $prd->quantity - $quantity;
		
		$data = array(
				'date'	     		=> $date,
				'product_id'   			=> $product_id,
				'quantity'   			=> $quantity,
				'warehouse_id'   		=> $warehouse,
				'note'   			=> $note,
				'user'				=> USER_NAME
			);
			
		if($this->db->insert('damage_products', $data) && $this->db->update('products', array('quantity' => $nQTY), array('id' => $product_id))) {
			return true;
		} else {
			return false;
		}
	}
	
	public function updateDamage($id, $product_id, $date, $quantity, $warehouse, $note)
	{
		
		$wh_qty_details = $this->getProductQuantity($product_id, $warehouse);
		$dp_details = $this->getDamagePdByID($id);
		$old_quantity = $wh_qty_details['quantity'] + $dp_details->quantity;
		$balance_qty = $old_quantity - $quantity;
                $prd = $this->getProductByID($product_id);
                $nQTY = ($prd->quantity + $dp_details->quantity)- $quantity;
		
		$data = array(
				'date'	     		=> $date,
				'product_id'   			=> $product_id,
				'quantity'   			=> $quantity,
				'warehouse_id'   		=> $warehouse,
				'note'   				=> $note,
				'user'				=> USER_NAME
			);
			
		if($this->db->update('damage_products', $data, array('id' => $id)) && $this->updateQuantity($product_id, $warehouse, $balance_qty) && $this->db->update('products', array('quantity' => $nQTY), array('id' => $product_id))) {
			return true;
		} else {
			return false;
		}
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
	
	public function deleteDamage($id)
	{
	
		if($this->db->delete('damage_products', array('id' => $id))) {
			return true;
		}
		
	return false;
	}
        
    public function products_count($category_id) {
        if($category_id) {
            $this->db->where('category_id', $category_id);
        }
        $this->db->from('products');
        return $this->db->count_all_results();
    }

    public function fetch_products($category_id, $limit, $start) {
	$this->db->select('name, code');
        $this->db->limit($limit, $start);
        if($category_id) {
            $this->db->where('category_id', $category_id);
        }
	$this->db->order_by("id", "asc"); 
        $query = $this->db->get("products");

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
   }
	
	
}
