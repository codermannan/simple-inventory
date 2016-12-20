<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Home_model extends CI_Model
{
	function __construct()
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
	
	public function getProductsQuantity($product_id, $warehouse = DEFAULT_WAREHOUSE) 
	{
		$q = $this->db->get_where('warehouses_products', array('product_id' => $product_id, 'warehouse_id' => $warehouse), 1); 
		  if( $q->num_rows() > 0 )
		  {
			return $q->row_array();
		  } 
		
		  return FALSE;
		
	}
	
	function get_calendar_data($year, $month) {
		
		$query = $this->db->select('date, data')->from('calendar')
			->like('date', "$year-$month", 'after')->get();
			
		$cal_data = array();
		
		foreach ($query->result() as $row) {
			$day = (int)substr($row->date,8,2);
			$cal_data[$day] = str_replace("|", "<br>", html_entity_decode($row->data));
		}
		
		return $cal_data;
		
	}
	
	public function updateComment($comment)
	{
			if($this->db->update('comment', array('comment' => $comment))) {
			return true;
		}
		return false;
	}
	
	public function getComment()
	{
		$q = $this->db->get('comment'); 
		  if( $q->num_rows() > 0 )
		  {
			return $q->row();
		  } 
		
		  return FALSE;
	}
	
	public function getChartData() 
	{
		$myQuery = "SELECT S.month,
					   COALESCE(S.sales, 0) as sales,
					   COALESCE( P.purchases, 0 ) as purchases,
					   COALESCE(S.tax1, 0) as tax1,
					   COALESCE(S.tax2, 0) as tax2,
					   COALESCE( P.ptax, 0 ) as ptax
					FROM (	SELECT	date_format(date, '%Y-%m') Month,
								SUM(total) Sales,
								SUM(total_tax) tax1,
								SUM(total_tax2) tax2
						FROM sales
						WHERE sales.date >= date_sub( now( ) , INTERVAL 12 MONTH )
						GROUP BY date_format(date, '%Y-%m')) S
					LEFT JOIN (	SELECT	date_format(date, '%Y-%m') Month,
									SUM(total_tax) ptax,
									SUM(total) purchases
							FROM purchases
							GROUP BY date_format(date, '%Y-%m')) P
					ON S.Month = P.Month
					GROUP BY S.Month
					ORDER BY S.Month";
		$q = $this->db->query($myQuery);
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
	}
	
	public function getStockValue() 
	{
		$q = $this->db->query("SELECT SUM(by_price) as stock_by_price, SUM(by_cost) as stock_by_cost FROM ( Select COALESCE(sum(warehouses_products.quantity), 0)*price as by_price, COALESCE(sum(warehouses_products.quantity), 0)*cost as by_cost FROM products JOIN warehouses_products ON warehouses_products.product_id=products.id GROUP BY products.id )a");
		 if( $q->num_rows() > 0 )
		  {
			return $q->row();
		  } 
		
		  return FALSE;
	}
	
	public function topProducts()
	{
		$m = date('Y-m');
		$this->db->select('product_code, product_name, sum(quantity) as quantity')->order_by('sum(quantity)', 'desc')->limit(10)->group_by('product_code')
		->join('sales', 'sales.id=sale_items.sale_id', 'left')->like('sales.date', $m, 'both');
		$q = $this->db->get('sale_items');
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
	}
	
	
}

/* End of file home_model.php */ 
/* Location: ./sma/modules/home/models/home_model.php */
