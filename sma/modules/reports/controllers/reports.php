<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reports extends MX_Controller {

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
| MODULE: 			REPORTS
| -----------------------------------------------------
| This is reports module controller file.
| -----------------------------------------------------
*/

	 
	function __construct()
	{
		parent::__construct();
		
		// check if user logged in 
		if (!$this->ion_auth->logged_in())
	  	{
			redirect('module=auth&view=login');
	  	}
		
		$this->load->model('reports_model');

	}
	
   function index()
   {
	   
	   $data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
	   
      $meta['page_title'] = $this->lang->line("reports");
	  $data['page_title'] = $this->lang->line("reports");
      $this->load->view('commons/header', $meta);
      $this->load->view('content', $data);
      $this->load->view('commons/footer');
   }
   
   function products($alerts = "alerts")
   {
	   

	//$data['n'] = $this->reports_model->get_total_alerts();
	  $meta['page_title'] = $this->lang->line("product_reports");
	  $data['page_title'] = $this->lang->line("product_reports");
      $this->load->view('commons/header', $meta);
      $this->load->view('alerts', $data);
      $this->load->view('commons/footer');
   }
   
    function getProductAlerts()
   {
 
	   $this->load->library('datatables');

	   $this->datatables
			->select('products.id as productid, products.image as image, products.code as code, products.name as name, products.unit, products.price, quantity, alert_quantity')
			->from('products')
			->where('alert_quantity >= quantity', NULL)
			->where('track_quantity', 1);

			$this->datatables->add_column("Actions", 
			"<center><a id='$4 - $3' href='index.php?module=products&view=gen_barcode&code=$3&height=200' title='".$this->lang->line("view_barcode")."' class='barcode tip'><i class='icon-barcode'></i></a>
			<a href='#' onClick=\"MyWindow=window.open('index.php?module=products&view=product_details&id=$1', 'MyWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=600,height=500'); return false;\" class='tip' title='".$this->lang->line("product_details")."'><i class='icon-fullscreen'></i></a>
			<a class='image tip' id='$4 - $3' href='".$this->config->base_url()."uploads/$2' title='".$this->lang->line("view_image")."'><i class='icon-picture'></i></a>
			<a href='index.php?module=products&amp;view=edit&amp;id=$1' class='tip' title='".$this->lang->line("edit_product")."'><i class='icon-edit'></i></a>
			<a href='index.php?module=products&amp;view=delete&amp;id=$1' onClick=\"return confirm('". $this->lang->line('alert_x_product') ."')\" class='tip' title='".$this->lang->line("delete_product")."'><i class='icon-trash'></i></a></center>", "productid, image, code, name");
		
		$this->datatables->unset_column('productid');
		$this->datatables->unset_column('image');
				
	    echo $this->datatables->generate();

   }
   
   function overview()
   {
	   
	  $data['monthly_sales'] = $this->reports_model->getChartData();
	  $data['stock'] = $this->reports_model->getStockValue();
	  $meta['page_title'] = $this->lang->line("stock_chart");
	  $data['page_title'] = $this->lang->line("stock_chart");
      $this->load->view('commons/header', $meta);
      $this->load->view('chart', $data);
      $this->load->view('commons/footer');
   }
   
   function warehouse_stock()
   {
	  if($this->input->get('warehouse')){ $warehouse = $this->input->get('warehouse'); } else { $warehouse = DEFAULT_WAREHOUSE; }
	   
	  $data['stock'] = $this->reports_model->getWarehouseStockValue($warehouse);
	  $data['warehouses'] = $this->reports_model->getAllWarehouses();
	  $data['warehouse_id'] = $warehouse;
	  $meta['page_title'] = $this->lang->line("warehouse_stock_value");
	  $data['page_title'] = $this->lang->line("stock_value");
      $this->load->view('commons/header', $meta);
      $this->load->view('stock', $data);
      $this->load->view('commons/footer');
   }
   
   
   
   function sales()
   {
	  $data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');	   
	  $data['users'] = $this->reports_model->getAllUsers();
	  $data['warehouses'] = $this->reports_model->getAllWarehouses();
	  $data['customers'] = $this->reports_model->getAllCustomers();
	  $data['billers'] = $this->reports_model->getAllBillers();
	   
      $meta['page_title'] = $this->lang->line("sale_reports");
	  $data['page_title'] = $this->lang->line("sale_reports");
      $this->load->view('commons/header', $meta);
      $this->load->view('sales', $data);
      $this->load->view('commons/footer');
   }
   
   function getSales()
   {
 		//if($this->input->get('name')){ $name = $this->input->get('name'); } else { $name = NULL; }
		if($this->input->get('user')){ $user = $this->input->get('user'); } else { $user = NULL; }
		if($this->input->get('customer')){ $customer = $this->input->get('customer'); } else { $customer = NULL; }
		if($this->input->get('biller')){ $biller = $this->input->get('biller'); } else { $biller = NULL; }
		if($this->input->get('warehouse')){ $warehouse = $this->input->get('warehouse'); } else { $warehouse = NULL; }
		if($this->input->get('reference_no')){ $reference_no = $this->input->get('reference_no'); } else { $reference_no = NULL; }
		if($this->input->get('start_date')){ $start_date = $this->input->get('start_date'); } else { $start_date = NULL; }
		if($this->input->get('end_date')){ $end_date = $this->input->get('end_date'); } else { $end_date = NULL; }
		if($start_date) {
                    $start_date = $this->ion_auth->fsd($start_date);
                    $end_date = $this->ion_auth->fsd($end_date);
		}
	   $this->load->library('datatables');
	   $this->datatables
			->select("sales.id as sid,date, reference_no, biller_name, customer_name, GROUP_CONCAT(CONCAT(sale_items.product_name, ' (', sale_items.quantity, ')') SEPARATOR ', <br>') as iname, total_tax, total_tax2, total", FALSE)
			->from('sales')
			->join('sale_items', 'sale_items.sale_id=sales.id', 'left')
			->join('warehouses', 'warehouses.id=sales.warehouse_id', 'left')
			->group_by('sales.id');
			
			
			if($user) { $this->datatables->like('sales.user', $user); }
			//if($name) { $this->datatables->like('sale_items.product_name', $name, 'both'); }
			if($biller) { $this->datatables->like('sales.biller_id', $biller); }
			if($customer) { $this->datatables->like('sales.customer_id', $customer); }
			if($warehouse) { $this->datatables->like('sales.warehouse_id', $warehouse); }
			if($reference_no) { $this->datatables->like('sales.reference_no', $reference_no, 'both'); }
			if($start_date) { $this->datatables->where('sales.date BETWEEN "'. $start_date. '" and "'.$end_date.'"'); }
			
		/*$this->datatables->add_column("Actions", 
			"<center><a href='#' onClick=\"MyWindow=window.open('index.php?module=sales&view=view_invoice&id=$1', 'MyWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=1000,height=600'); return false;\" title='".$this->lang->line("view_invoice")."' class='tip'><i class='icon-fullscreen'></i></a> 
			<a href='index.php?module=sales&view=pdf&id=$1' title='".$this->lang->line("download_pdf")."' class='tip'><i class='icon-file'></i></a> 
			<a href='index.php?module=sales&view=email_invoice&id=$1' title='".$this->lang->line("email_invoice")."' class='tip'><i class='icon-envelope'></i></a>
			<a href='index.php?module=sales&amp;view=edit&amp;id=$1' title='".$this->lang->line("edit_invoice")."' class='tip'><i class='icon-edit'></i></a>
			<a href='index.php?module=sales&amp;view=delete&amp;id=$1' onClick=\"return confirm('". $this->lang->line('alert_x_invoice') ."')\" title='".$this->lang->line("delete_invoice")."' class='tip'><i class='icon-trash'></i></a></center>", "sid");*/
		
		$this->datatables->unset_column('sid');
		
		
	   echo $this->datatables->generate();
   }
   
   function purchases()
   {
	  $data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');	   
	  $data['users'] = $this->reports_model->getAllUsers();
	  $data['warehouses'] = $this->reports_model->getAllWarehouses();
	  $data['suppliers'] = $this->reports_model->getAllSuppliers();
	   
      $meta['page_title'] = $this->lang->line("purchase_reports");
	  $data['page_title'] = $this->lang->line("purchase_reports");
      $this->load->view('commons/header', $meta);
      $this->load->view('purchases', $data);
      $this->load->view('commons/footer');
   }
   
   function getPurchases()
   {
 		//if($this->input->get('name')){ $name = $this->input->get('name'); } else { $name = NULL; }
		if($this->input->get('user')){ $user = $this->input->get('user'); } else { $user = NULL; }
		if($this->input->get('supplier')){ $supplier = $this->input->get('supplier'); } else { $supplier = NULL; }
		if($this->input->get('warehouse')){ $warehouse = $this->input->get('warehouse'); } else { $warehouse = NULL; }
		if($this->input->get('reference_no')){ $reference_no = $this->input->get('reference_no'); } else { $reference_no = NULL; }
		if($this->input->get('start_date')){ $start_date = $this->input->get('start_date'); } else { $start_date = NULL; }
		if($this->input->get('end_date')){ $end_date = $this->input->get('end_date'); } else { $end_date = NULL; }
		if($start_date) {
                    $start_date = $this->ion_auth->fsd($start_date);
                    $end_date = $this->ion_auth->fsd($end_date);
		}
	   $this->load->library('datatables');
	   $this->datatables
			->select("purchases.id as id, date, reference_no, warehouses.name as wname, supplier_name, GROUP_CONCAT(CONCAT(purchase_items.product_name, ' (', purchase_items.quantity, ')') SEPARATOR ', <br>') as iname, COALESCE(inv_total, 0), COALESCE(total_tax, 0), total", FALSE)
			->from('purchases')
			->join('purchase_items', 'purchase_items.purchase_id=purchases.id', 'left')
			->join('warehouses', 'warehouses.id=purchases.warehouse_id', 'left')
			->group_by('purchases.id');
			
			if($user) { $this->datatables->like('purchases.user', $user); }
			//if($name) { $this->datatables->like('purchase_items.product_name', $name); }
			if($supplier) { $this->datatables->like('purchases.supplier_id', $supplier); }
			if($warehouse) { $this->datatables->like('purchases.warehouse_id', $warehouse); }
			if($reference_no) { $this->datatables->like('purchases.reference_no', $reference_no, 'both'); }
			if($start_date) { $this->datatables->where('purchases.date BETWEEN "'. $start_date. '" and "'.$end_date.'"'); }
			
		$this->datatables->add_column("Actions", 
			"<center><a href='#' onClick=\"MyWindow=window.open('index.php?module=inventories&view=view_inventory&id=$1', 'MyWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=1000,height=600'); return false;\" title='".$this->lang->line("view_inventory")."' class='tip'><i class='icon-fullscreen'></i></a> <a href='index.php?module=inventories&view=pdf&id=$1' title='".$this->lang->line("download_pdf")."' class='tip'><i class='icon-file'></i></a> <a href='index.php?module=inventories&view=email_inventory&id=$1' title='".$this->lang->line("email_inventory")."' class='tip'><i class='icon-envelope'></i></a> <a href='index.php?module=inventories&amp;view=edit&amp;id=$1' title='".$this->lang->line("edit_inventory")."' class='tip'><i class='icon-edit'></i></a> <a href='index.php?module=inventories&amp;view=delete&amp;id=$1' onClick=\"return confirm('". $this->lang->line('alert_x_inventory') ."')\" title='".$this->lang->line("delete_inventory")."' class='tip'><i class='icon-trash'></i></a></center>", "id")
		->unset_column('id');
		
	   echo $this->datatables->generate();
   }
   
   function daily_sales()
   {
	   if($this->input->get('year')){ $year = $this->input->get('year'); } else { $year = date('Y'); }
	   if($this->input->get('month')){ $month = $this->input->get('month'); } else { $month = date('m'); }
	  
	   $data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
	   	
		$config['translated_day_names'] = array($this->lang->line("sunday"), $this->lang->line("monday"), $this->lang->line("tuesday"), $this->lang->line("wednesday"), $this->lang->line("thursday"), $this->lang->line("friday"), $this->lang->line("saturday"));
		$config['translated_month_names'] = array('01' => $this->lang->line("january"), '02' => $this->lang->line("february"), '03' => $this->lang->line("march"), '04' => $this->lang->line("april"), '05' => $this->lang->line("may"), '06' => $this->lang->line("june"), '07' => $this->lang->line("july"), '08' => $this->lang->line("august"), '09' => $this->lang->line("september"), '10' => $this->lang->line("october"), '11' => $this->lang->line("november"), '12' => $this->lang->line("december"));

		$config['template'] = '

   			{table_open}<table border="0" cellpadding="0" cellspacing="0" class="table table-bordered">{/table_open}
			
			{heading_row_start}<tr>{/heading_row_start}
			
			{heading_previous_cell}<th><a href="{previous_url}">&lt;&lt;</a></th>{/heading_previous_cell}
			{heading_title_cell}<th colspan="{colspan}" id="month_year">{heading}</th>{/heading_title_cell}
			{heading_next_cell}<th><a href="{next_url}">&gt;&gt;</a></th>{/heading_next_cell}
			
			{heading_row_end}</tr>{/heading_row_end}
			
			{week_row_start}<tr>{/week_row_start}
			{week_day_cell}<td class="cl_wday">{week_day}</td>{/week_day_cell}
			{week_row_end}</tr>{/week_row_end}
			
			{cal_row_start}<tr class="days">{/cal_row_start}
			{cal_cell_start}<td class="day">{/cal_cell_start}
			
			{cal_cell_content}
				<div class="day_num">{day}</div>
				<div class="content">{content}</div>
			{/cal_cell_content}
			{cal_cell_content_today}
				<div class="day_num highlight">{day}</div>
				<div class="content">{content}</div>
			{/cal_cell_content_today}
			
			{cal_cell_no_content}<div class="day_num">{day}</div>{/cal_cell_no_content}
			{cal_cell_no_content_today}<div class="day_num highlight">{day}</div>{/cal_cell_no_content_today}
			
			{cal_cell_blank}&nbsp;{/cal_cell_blank}
			
			{cal_cell_end}</td>{/cal_cell_end}
			{cal_row_end}</tr>{/cal_row_end}
			
			{table_close}</table>{/table_close}
';


		$this->load->library('daily_cal', $config);
				 
		$sales = $this->reports_model->getDailySales($year, $month);
		
		$num = cal_days_in_month(CAL_GREGORIAN, $month, $year);
		
		if(!empty($sales)) {
			foreach($sales as $sale){
				$daily_sale[$sale->date] = "<table class='table table-bordered table-hover table-striped table-condensed data' style='margin:0;'><tr><td>".$this->lang->line("discount")."</td><td>". $this->ion_auth->formatMoney($sale->discount) ."</td></tr><tr><td>".$this->lang->line("tax1")."</td><td>". $this->ion_auth->formatMoney($sale->tax1) ."</td></tr><tr><td>".$this->lang->line("tax2")."</td><td>". $this->ion_auth->formatMoney($sale->tax2) ."</td></tr><tr><td>".$this->lang->line("total")."</td><td>". $this->ion_auth->formatMoney($sale->total) ."</td></tr></table>";	
			}
			
		/*for ($i = 1; $i <= $num; $i++){
       		
       			if(isset($cal_data[$i])) {
        			$daily_sale[$i] = $cal_data[$i]; 
				} else { 
					$daily_sale[$i] = $this->lang->line('no_sale');
				}
        	
    	}
		
		
		} else {
			for($i=1; $i<=$num; $i++) {
			$daily_sale[$i] = $this->lang->line('no_sale');
		}*/
		} else { $daily_sale = array(); }
		
	   $data['calender'] = $this->daily_cal->generate($year, $month, $daily_sale);
	   
	   
	  $meta['page_title'] = $this->lang->line("daily_sales");
	  $data['page_title'] = $this->lang->line("daily_sales");
      $this->load->view('commons/header', $meta);
      $this->load->view('daily', $data);
	  $this->load->view('commons/footer');
   }
   
  
   function monthly_sales()
   {
	   if($this->input->get('year')){ $year = $this->input->get('year'); } else { $year = date('Y'); }

	   $data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
	   
		$data['year'] = $year;
		
	   $data['sales'] = $this->reports_model->getMonthlySales($year);
	   
      $meta['page_title'] = $this->lang->line("monthly_sales");
	  $data['page_title'] = $this->lang->line("monthly_sales");
      $this->load->view('commons/header', $meta);
	  $this->load->view('monthly', $data);
	  $this->load->view('commons/footer');
   }
   
   function custom_products()
   {
	  
	   $data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
	   if($this->input->post('start_date')){ $dt = "From ".$this->input->post('start_date')." to ".$this->input->post('end_date'); } else { $dt = "Till ".$this->input->post('end_date'); }
      //$meta['page_title'] = $this->lang->line("reports")." ".$dt;
	  $data['products'] = $this->reports_model->getAllProducts();
      $meta['page_title'] = $this->lang->line("product_reports")." ".$dt;
	  $data['page_title'] = $this->lang->line("product_reports");
      $this->load->view('commons/header', $meta);
      $this->load->view('products', $data);
      $this->load->view('commons/footer');
   }
   function getCP()
   {
	    if($this->input->get('product')){ $product = $this->input->get('product'); } else { $product = NULL; }
            if($this->input->get('start_date')){ $start_date = $this->input->get('start_date'); } else { $start_date = NULL; }
            if($this->input->get('end_date')){ $end_date = $this->input->get('end_date'); } else { $end_date = NULL; }
            if($start_date) {
                    $start_date = $this->ion_auth->fsd($start_date);
                    $end_date = $this->ion_auth->fsd($end_date);
                    
                $pp =    "( SELECT pi.product_id, SUM( pi.quantity ) purchasedQty from purchases p JOIN purchase_items pi on p.id = pi.purchase_id where
                         p.date >= '{$start_date}' and p.date < '{$end_date}'
                         group by pi.product_id ) PCosts";
                
                $sp = "( SELECT si.product_id, SUM( si.quantity ) soldQty, SUM( si.gross_total ) totalSale from sales s JOIN sale_items si on s.id = si.sale_id where
                       s.date >= '{$start_date}' and s.date < '{$end_date}'
                       group by si.product_id ) PSales";
            } else {
                $pp ="( SELECT pi.product_id, SUM( pi.quantity ) purchasedQty from purchase_items pi group by pi.product_id ) PCosts";
                $sp = "( SELECT si.product_id, SUM( si.quantity ) soldQty, SUM( si.gross_total ) totalSale from sale_items si group by si.product_id ) PSales";
            }
	  
        $this->load->library('datatables');
        $this->datatables
                ->select("p.name,
                        p.code,
                        COALESCE( PCosts.purchasedQty, 0 ) as PurchasedQty,
                        COALESCE( PSales.soldQty, 0 ) as SoldQty,
                        COALESCE( PSales.totalSale, 0 ) as TotalSales,
                        ROUND(COALESCE( PSales.totalSale, 0 ) - ( COALESCE( PSales.soldQty, 0 ) * p.Cost ), 2) as GrossProfit", FALSE)
                ->from('products p', FALSE)
                ->join($sp, 'p.id = PSales.product_id', 'left')
                ->join($pp, 'p.id = PCosts.product_id', 'left');
                       // ->group_by('p.id');

		if($product) { $this->datatables->where('p.id', $product); }	

	   echo $this->datatables->generate();

   }
      
}