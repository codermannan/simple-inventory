<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Products extends MX_Controller {

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
| This is products module controller file.
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
		
		$this->load->library('form_validation');
		$this->load->model('products_model');

	}
	
	function index()
   {
	    $data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
	  	$data['success_message'] = $this->session->flashdata('success_message');
	  $data['warehouses'] = $this->products_model->getAllWarehouses();
	  	
	  $meta['page_title'] = $this->lang->line("products");
	  $data['page_title'] = $this->lang->line("products"); 
	  
	  $this->load->view('commons/header', $meta);
      $this->load->view('index', $data);
      $this->load->view('commons/footer');
   }
   
	function getdatatableajaxcost()
   {
 
	   $this->load->library('datatables');
	   $this->datatables
			->select("products.id as productid, products.image as image, products.code as code, products.name as name, categories.name as cname, products.cost, products.price, COALESCE(quantity, 0) as quantity, products.unit, alert_quantity", FALSE)
			->from('products')
			->join('categories', 'products.category_id=categories.id', 'left')
			//->join('warehouses_products', 'products.id=warehouses_products.product_id', 'left')
			->group_by("products.id");
			$this->datatables->add_column("Actions", 
			"<center><a id='$4 - $3' href='index.php?module=products&view=gen_barcode&code=$3&height=200' title='".$this->lang->line("view_barcode")."' class='barcode tip'><i class='icon-barcode'></i></a> <a href='#' onClick=\"MyWindow=window.open('index.php?module=products&view=product_details&id=$1', 'MyWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=600,height=600'); return false;\" class='tip' title='".$this->lang->line("product_details")."'><i class='icon-fullscreen'></i></a> <a class='image tip' id='$4 - $3' href='".$this->config->base_url()."assets/uploads/$2' title='".$this->lang->line("view_image")."'><i class='icon-picture'></i></a> <a href='index.php?module=products&view=add_damage&product_id=$1' class='tip' title='".$this->lang->line("add_damage_qty")."'><i class='icon-filter'></i></a> <a href='index.php?module=products&view=edit&id=$1' class='tip' title='".$this->lang->line("edit_product")."'><i class='icon-edit'></i></a> <a href='index.php?module=products&view=delete&id=$1' onClick=\"return confirm('". $this->lang->line('alert_x_product') ."')\" class='tip' title='".$this->lang->line("delete_product")."'><i class='icon-trash'></i></a></center>", "productid, image, code, name");
		
		$this->datatables->unset_column('productid');
		$this->datatables->unset_column('image');
				
	    echo $this->datatables->generate();

   }
   
   function getdatatableajax()
   {
 
	   $this->load->library('datatables');
	   $this->datatables
			->select("products.id as productid, products.image as image, products.code as code, products.name as name, categories.name as cname, products.price, COALESCE(quantity, 0) as quantity, products.unit, alert_quantity", FALSE);
			$this->datatables->from('products');
			$this->datatables->join('categories', 'products.category_id=categories.id', 'left');			
			$this->datatables->group_by("products.id");
			$this->datatables->add_column("Actions", 
			"<center><a id='$4 - $3' href='index.php?module=products&view=gen_barcode&code=$3&height=200' title='".$this->lang->line("view_barcode")."' class='barcode tip'><i class='icon-barcode'></i></a> <a href='#' onClick=\"MyWindow=window.open('index.php?module=products&view=product_details&id=$1', 'MyWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=600,height=600'); return false;\" class='tip' title='".$this->lang->line("product_details")."'><i class='icon-fullscreen'></i></a> <a class='image tip' id='$4 - $3' href='".$this->config->base_url()."assets/uploads/$2' title='".$this->lang->line("view_image")."'><i class='icon-picture'></i></a> <a href='index.php?module=products&view=add_damage&product_id=$1' class='tip' title='".$this->lang->line("add_damage_qty")."'><i class='icon-filter'></i></a> <a href='index.php?module=products&view=edit&id=$1' class='tip' title='".$this->lang->line("edit_product")."'><i class='icon-edit'></i></a> <a href='index.php?module=products&view=delete&id=$1' onClick=\"return confirm('". $this->lang->line('alert_x_product') ."')\" class='tip' title='".$this->lang->line("delete_product")."'><i class='icon-trash'></i></a></center>", "productid, image, code, name");
		
		$this->datatables->unset_column('productid');
		$this->datatables->unset_column('image');
				
	    echo $this->datatables->generate();

   }
   
   /*function barcode($product_code = NULL) 
   {
		if($this->input->get('code')){ $product_code = $this->input->get('code'); }
		
		$data['product_details'] = $this->products_model->getProductByCode($product_code);
	    $data['img'] = "<img src='".$this->config->base_url()."index.php?module=products&view=gen_barcode&code={$product_code}' alt='{$product_code}' width='300' />";
		$this->load->view('barcode', $data);
		  
   }
   function product_barcode($product_code = NULL) 
   {
	   if($this->input->get('code')){ $product_code = $this->input->get('code'); }
	   
	   $img = $this->gen_barcode($product_code, 80);
	   return $img;
   }
   
    function gen_barcode($product_code = NULL, $height = 80)
    {
			if($this->input->get('code')){ $product_code = $this->input->get('code'); }
			if($this->input->get('height')){ $height = $this->input->get('height'); }
		
        $this->load->library('zend');
        $this->zend->load('Zend/Barcode');
		//'drawText' => FALSE
		$barcodeOptions = array('text' => $product_code, 'barHeight' => $height, 'stretchText' => TRUE );
		$rendererOptions = array('imageType'=>'png', 'horizontalPosition' => 'center', 'verticalPosition' => 'middle');
		$imageResource = Zend_Barcode::factory(BARCODE_SYMBOLOGY, 'image', $barcodeOptions, $rendererOptions)->render();
		return $imageResource;
		 
    }
    */
   
   function barcode($product_code = NULL) 
   {
		if($this->input->get('code')){ $product_code = $this->input->get('code'); }
		
		$data['product_details'] = $this->products_model->getProductByCode($product_code);
	    $data['img'] = "<img src='".$this->config->base_url()."index.php?module=products&view=gen_barcode&code={$product_code}' alt='{$product_code}' />";
		$this->load->view('barcode', $data);
		  
   }
   function product_barcode($product_code = NULL, $height = 60, $width = 210) 
   {
	   if($this->input->get('code')){ $product_code = $this->input->get('code'); }
		
		//$data['product_details'] = $this->products_model->getProductByCode($product_code);
	    return "<img src='".$this->config->base_url()."index.php?module=products&view=gen_barcode&code={$product_code}&height={$height}&width={$width}' alt='{$product_code}' />";
		
   }
   
    function gen_barcode($product_code = NULL, $height = 60, $width = 210)
    {
			if($this->input->get('code')){ $product_code = $this->input->get('code'); }
			if($this->input->get('height')){ $height = $this->input->get('height'); }
			if($this->input->get('width')){ $width = $this->input->get('width'); }
		
        $this->load->library('zend');
        $this->zend->load('Zend/Barcode');
		//'drawText' => FALSE
		$barcodeOptions = array('text' => $product_code, 'barHeight' => $height);
		$rendererOptions = array('imageType'=>'png', 'horizontalPosition' => 'center', 'verticalPosition' => 'middle', 'width' => $width);
		$imageResource = Zend_Barcode::factory(BARCODE_SYMBOLOGY, 'image', $barcodeOptions, $rendererOptions)->render();
		return $imageResource;
		 
    }
    function sheet()
	{
		$this->load->library('pagination');

		if($this->input->get('category_id')){ $category_id = $this->input->get('category_id'); } else { $category_id = 0; }
		//$this->table->set_heading('Id', 'The Title', 'The Content');
		if($this->input->get('per_page')){ $per_page = $this->input->get('per_page'); } else { $per_page = 0; }
		
		$config['base_url'] = base_url().'index.php?module=products&view=sheet&category_id='.$category_id;
		$config['total_rows'] = $this->products_model->products_count($category_id);
		$config['per_page'] = 16;
		$config['num_links'] = 4;

		$config['full_tag_open'] = '<ul>';
		$config['full_tag_close'] = '</ul>';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		
		$this->pagination->initialize($config);
		
		$products = $this->products_model->fetch_products($category_id, $config['per_page'], $per_page);
		$r = 1;
		$html = "";
		$html .= '<table class="table table-bordered">
        <tbody><tr>';
        	foreach($products as $pr) {
				if($r != 1) {$rw = (bool)($r & 1);
				$html .= $rw ? '</tr><tr>' : ''; }
				$html .= '<td><h4>'.SITE_NAME.'</h4><strong>'.$pr->name.'</strong><br>'.$this->product_barcode($pr->code, 60, 300).'</td>';
				$r++;
			} 
                        if(!(bool)($r & 1)) { $html .= '<td></td>'; }
        $html .= '</tr></tbody>
        </table>';

                $data['r'] = $r;	
                $data['html'] = $html;
		$data['page_title'] = $this->lang->line("barcode_sheet");
                $data['categories'] =  $this->products_model->getAllCategories();
		
		$this->load->view('sheet_view', $data);
		
	}
	
	function labels()
	{
		$this->load->library('pagination');
                if($this->input->get('category_id')){ $category_id = $this->input->get('category_id'); } else { $category_id = 0; }
		if($this->input->get('per_page')){ $per_page = $this->input->get('per_page'); } else { $per_page =0; }
		
		$config['base_url'] = base_url().'index.php?module=products&view=labels&category_id='.$category_id;
		$config['total_rows'] = $this->products_model->products_count($category_id);
		$config['per_page'] = 10;
		$config['num_links'] = 5;

		$config['full_tag_open'] = '<ul>';
		$config['full_tag_close'] = '</ul>';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		
		$this->pagination->initialize($config);
		
		$products = $this->products_model->fetch_products($category_id, $config['per_page'], $per_page);

		$html = "";
		$r = 1;
        	foreach($products as $pr) {
			$html .= '<div class="labels"><strong>'.$pr->name.'</strong><br>'.$this->product_barcode($pr->code, 30, 180).'</div>';
			$r++;
                } 

                $data['r'] = $r;
		$data['html'] = $html;
		$data['page_title'] = $this->lang->line("print_labels");
                $data['categories'] =  $this->products_model->getAllCategories();
		
		$this->load->view('print_labels', $data);
		
	}
	
   function warehouse($warehouse = DEFAULT_WAREHOUSE)
   {
	   if($this->input->get('warehouse_id')){ $warehouse = $this->input->get('warehouse_id'); }
	   
	  $data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
	  
	  $data['warehouses'] = $this->products_model->getAllWarehouses();
	  $data['warehouse_id'] = $warehouse;

      $meta['page_title'] = $this->lang->line("products");
	  $data['page_title'] = $this->lang->line("products");
      $this->load->view('commons/header', $meta);
      $this->load->view('warehouse', $data);
      $this->load->view('commons/footer');
   }
   
   function getwhproducts($warehouse_id = NULL)
   {
	   if($this->input->get('warehouse_id')){ $warehouse_id = $this->input->get('warehouse_id'); }
 
	   $this->load->library('datatables');
	   $this->datatables
			->select("warehouses_products.warehouse_id as wh, warehouses_products.product_id as productid, products.image as image, products.code as code, products.name as name, products.unit, products.price, warehouses_products.quantity, alert_quantity", FALSE)
			->from('warehouses_products')
			->join('products', 'products.id=warehouses_products.product_id', 'left')
			->where('warehouses_products.warehouse_id', $warehouse_id)
			->where('warehouses_products.quantity !=', 0)
			->group_by("products.id")
			->add_column("Actions", 
			"<center><a id='$4 - $3' href='index.php?module=products&view=gen_barcode&code=$3&height=200' title='".$this->lang->line("view_barcode")."' class='barcode tip'><i class='icon-barcode'></i></a>
			<a href='#' onClick=\"MyWindow=window.open('index.php?module=products&view=product_details&id=$1', 'MyWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=600,height=500'); return false;\" class='tip' title='".$this->lang->line("product_details")."'><i class='icon-fullscreen'></i></a>
			<a class='image tip' id='$4 - $3' href='".$this->config->base_url()."assets/uploads/$2' title='".$this->lang->line("view_image")."'><i class='icon-picture'></i></a>
			<a href='index.php?module=products&view=add_damage&product_id=$1&warehouse_id=$5' class='tip' title='".$this->lang->line("add_damage_qty")."'><i class='icon-filter'></i></a>
			<a href='index.php?module=products&view=edit&id=$1' class='tip' title='".$this->lang->line("edit_product")."'><i class='icon-edit'></i></a>
			<a href='index.php?module=products&view=delete&id=$1' onClick=\"return confirm('". $this->lang->line('alert_x_product') ."')\" class='tip' title='".$this->lang->line("delete_product")."'><i class='icon-trash'></i></a></center>", "productid, image, code, name, wh")
		
		->unset_column('productid')
		->unset_column('wh')
		->unset_column('image');
		
	 
	 echo $this->datatables->generate();

   }
   
   function search_results($sr = "")
   {
	   
	   $data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
	   
	   if($this->input->post('pr_name')) { $sr_name = $this->input->post('pr_name'); } else  { $sr_name = $sr; }
	   if($this->input->get('search_term')) { $sr_name = $this->input->get('search_term'); } 
	   
	  $data['sr_name'] = $sr_name; 
	  
      $meta['page_title'] = $this->lang->line("products");
	  $data['page_title'] = $this->lang->line("products");
      $this->load->view('commons/header', $meta);
      $this->load->view('search', $data);
      $this->load->view('commons/footer');
   }
	
	function getseatchresults($srq = NULL)
   {
 		if($this->input->get('srq')){ $srq = $this->input->get('srq'); }
		
	   $this->load->library('datatables');
	   $this->datatables
			->select("products.id as productid, image, code, name, unit, cost, price, (CASE WHEN sum(warehouses_products.quantity) Is Null THEN 0 ELSE sum(warehouses_products.quantity) END) as totalQuantity, alert_quantity", FALSE)
			->from('products')
			->like('name', $srq, 'both')
			->or_like('code', $srq, 'both')
			->join('warehouses_products', 'products.id=warehouses_products.product_id', 'left')
			->group_by("products.id")
			->add_column("Actions", 
			"<center><a href='#' onClick=\"MyWindow=window.open('index.php?module=products&view=barcode&code=$3', 'MyWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=425,height=275'); return false;\">
			
								<img src='".$this->config->base_url()."smlib/images/bar.png' width='16' height='16' title='".$this->lang->line("view_barcode")."' style='margin:1px;'/>
								</a>
								<a href='#' onClick=\"MyWindow=window.open('index.php?module=products&view=product_details&id=$1', 'MyWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=600,height=500'); return false;\">
			
								<img src='".$this->config->base_url()."smlib/images/view.png' width='16' height='16' title='".$this->lang->line("product_details")."' style='margin:1px;'/>
								</a>
								<a class='ajax cboxElement' href='".$this->config->base_url()."assets/uploads/$2'>
								<img src='".$this->config->base_url()."smlib/images/view_img.png' width='16' height='16' title='".$this->lang->line("view_image")."' style='margin:1px;'/>
								</a>
								
								<a href='index.php?module=products&view=edit&id=$1'>
								<img src='".$this->config->base_url()."smlib/images/edit.png' width='16' height='16' title='".$this->lang->line("edit_product")."' style='margin:1px;'/>
								</a>
							    <a href='index.php?module=products&view=delete&id=$1' onClick='return confirm('". $this->lang->line('alert_x_product') ."')'>
								<img src='".$this->config->base_url()."smlib/images/delete.png' width='16' height='16'' title='".$this->lang->line("delete_product")."' style='margin:1px;'/>
								</a></center>", "productid, image, code")
		
		->unset_column('productid')
		->unset_column('image');
		
		
	   echo $this->datatables->generate();

   }
   
	/* ---------------------------------------------------------------------------------------------------------------------------------------------------------------- */
	
	function add()
	{
		$groups = array('purchaser', 'salesman', 'viewer');
		if ($this->ion_auth->in_group($groups))
		{
			$this->session->set_flashdata('message', $this->lang->line("access_denied"));
			$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			redirect('module=products', 'refresh');
		}
		
		//validate form input
		$this->form_validation->set_rules('code', $this->lang->line("product_code"), 'trim|is_unique[products.code]|min_length[2]|max_length[50]|required|xss_clean');
		$this->form_validation->set_rules('name', $this->lang->line("product_name"), 'required|xss_clean');
		$this->form_validation->set_rules('category', $this->lang->line("cname"), 'required|xss_clean');
		$this->form_validation->set_rules('subcategory', $this->lang->line("subcategory"), 'xss_clean');
		$this->form_validation->set_rules('unit', $this->lang->line("product_unit"), 'required|xss_clean');
		$this->form_validation->set_rules('cost', $this->lang->line("product_cost"), 'xss_clean');
		$this->form_validation->set_rules('price', $this->lang->line("product_price"), 'required|xss_clean');
		$this->form_validation->set_rules('size', $this->lang->line("product_size"), 'xss_clean');
                $this->form_validation->set_rules('note', $this->lang->line("product_details_for_invoice"), 'xss_clean');
		$this->form_validation->set_rules('alert_quantity', $this->lang->line("alert_quantity"), 'required|xss_clean');
		if(TAX1) {
			$this->form_validation->set_rules('tax_rate', $this->lang->line("tax_rate"), 'required|xss_clean');
		} else {
			$this->form_validation->set_rules('tax_rate', $this->lang->line("tax_rate"), 'xss_clean');
		}
		$this->form_validation->set_rules('image', $this->lang->line("product_image"), 'xss_clean');
		$this->form_validation->set_rules('cf1', $this->lang->line("pcf1"), 'xss_clean');
		$this->form_validation->set_rules('cf2', $this->lang->line("pcf2"), 'xss_clean');
		$this->form_validation->set_rules('cf2', $this->lang->line("pcf3"), 'xss_clean');
		$this->form_validation->set_rules('cf4', $this->lang->line("pcf4"), 'xss_clean');
		$this->form_validation->set_rules('cf5', $this->lang->line("pcf5"), 'xss_clean');
		$this->form_validation->set_rules('cf6', $this->lang->line("pcf6"), 'xss_clean');

		
		
		if ($this->form_validation->run() == true)
		{
		
			$name = $this->input->post('name');
			$code = $this->input->post('code');

			$data = array('code' => $code,
				'name' => $this->input->post('name'),
				'category_id' => $this->input->post('category'),
				'subcategory_id' => $this->input->post('subcategory'),
				'unit' => $this->input->post('unit'),
				'size' => $this->input->post('size'),
				'cost' => $this->input->post('cost'),
				'price' => $this->input->post('price'),
				'alert_quantity' => $this->input->post('alert_quantity'),
				'tax_rate' => $this->input->post('tax_rate') ? $this->input->post('tax_rate') : NULL,
				'track_quantity' => $this->input->post('track_quantity') ? $this->input->post('track_quantity') : '0',
				'cf1' => $this->input->post('cf1'),
				'cf2' => $this->input->post('cf2'),
				'cf3' => $this->input->post('cf3'),
				'cf4' => $this->input->post('cf4'),
				'cf5' => $this->input->post('cf5'),
				'cf6' => $this->input->post('cf6'),
                                'details' => $this->input->post('note')
			);
			
		if($_FILES['userfile']['size'] > 0){
				
		$this->load->library('upload_photo');
		
 		$config['upload_path'] = 'assets/uploads/'; 
		$config['allowed_types'] = 'gif|jpg|png'; 
		$config['max_size'] = '500';
		$config['max_width'] = '800';
		$config['max_height'] = '800';
		$config['overwrite'] = FALSE; 
		
 			$this->upload_photo->initialize($config);
			
			if( ! $this->upload_photo->do_upload()){
			
 				$error = $this->upload_photo->display_errors();
				$this->session->set_flashdata('message', $error);
				redirect("module=products&view=add", 'refresh');
			} 
		
 		$photo = $this->upload_photo->file_name;
		
		$this->load->helper('file');
		$this->load->library('image_lib');
		$config['image_library'] = 'gd2';
		$config['source_image'] = 'assets/uploads/'.$photo;
		$config['new_image'] = 'assets/uploads/thumbs/'.$photo;
		$config['maintain_ratio'] = TRUE;
		$config['width'] = 76;
		$config['height'] = 76;
		
		$this->image_lib->clear();
        $this->image_lib->initialize($config);
		
		if ( ! $this->image_lib->resize())
		{
			echo $this->image_lib->display_errors();
			
		}
		
		} else {
			$photo = NULL;
		}
			
		}
		
		if ( $this->form_validation->run() == true && $this->products_model->addProduct($code, $name, $photo, $data))
		{  
			$this->session->set_flashdata('success_message', $this->lang->line("product_added"));
			redirect('module=products', 'refresh');
		}
		else
		{  
			$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));

			$data['code'] = array('name' => 'code',
				'id' => 'code',
				'type' => 'text',
				'value' => $this->form_validation->set_value('code'),
			);
			$data['name'] = array('name' => 'name',
				'id' => 'name',
				'type' => 'text',
				'value' => $this->form_validation->set_value('name'),
			);
			
			$data['unit'] = array('name' => 'unit',
				'id' => 'unit',
				'type' => 'text',
				'value' => $this->form_validation->set_value('unit'),
			);
			$data['cost'] = array('name' => 'cost',
				'id' => 'cost',
				'type' => 'text',
				'value' => $this->form_validation->set_value('cost'),
			);
			$data['price'] = array('name' => 'price',
				'id' => 'price',
				'type' => 'text',
				'value' => $this->form_validation->set_value('price'),
			);
			$data['size'] = array('name' => 'size',
				'id' => 'size',
				'type' => 'text',
				'value' => $this->form_validation->set_value('size'),
			);
			$data['alert_quantity'] = array('name' => 'alert_quantity',
				'id' => 'alert_quantity',
				'type' => 'text',
				'value' => $this->form_validation->set_value('alert_quantity'),
			);
			$data['image'] = array('name' => 'image',
				'id' => 'image',
				'type' => 'text',
				'value' => $this->form_validation->set_value('image')
			);
			
			
		$data['categories'] = $this->products_model->getAllCategories();
		$data['tax_rates'] = $this->products_model->getAllTaxRates();
		$meta['page_title'] = $this->lang->line("add_product");
		$data['page_title'] = $this->lang->line("add_product");
		$this->load->view('commons/header', $meta);
		$this->load->view('add', $data);
		$this->load->view('commons/footer');
		
		}
	}
	
		/* ---------------------------------------------------------------------------------------------------------------------------------------------------------------- */
	
	function edit()
	{
		if($this->input->get('id')){ $id = $this->input->get('id'); }
		$groups = array('owner', 'admin');
		if (!$this->ion_auth->in_group($groups))
		{
			$this->session->set_flashdata('message', $this->lang->line("access_denied"));
			$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			redirect('module=products', 'refresh');
		}
		

		//validate form input
		$this->form_validation->set_rules('code', $this->lang->line("product_code"), 'trim|min_length[2]|max_length[50]|required|xss_clean');
		$pr_details = $this->products_model->getProductByID($id);
			if ($this->input->post('code') != $pr_details->code) {
				$this->form_validation->set_rules('code', $this->lang->line("product_code"), 'is_unique[products.code]');
			}
		$this->form_validation->set_rules('name', $this->lang->line("product_name"), 'required|xss_clean');
		$this->form_validation->set_rules('category', $this->lang->line("cname"), 'required|xss_clean');
		$this->form_validation->set_rules('subcategory', $this->lang->line("subcategory"), 'xss_clean');
		$this->form_validation->set_rules('unit', $this->lang->line("product_unit"), 'required|xss_clean');
		$this->form_validation->set_rules('cost', $this->lang->line("product_cost"), 'required|xss_clean');
		$this->form_validation->set_rules('price', $this->lang->line("product_price"), 'required|xss_clean');
		$this->form_validation->set_rules('alert_quantity', $this->lang->line("alert_quantity"), 'required|xss_clean');
		if(TAX1) {
			$this->form_validation->set_rules('tax_rate', $this->lang->line("tax_rate"), 'required|xss_clean');
		} else {
			$this->form_validation->set_rules('tax_rate', $this->lang->line("tax_rate"), 'xss_clean');
		}
		$this->form_validation->set_rules('image', $this->lang->line("product_image"), 'xss_clean');
                $this->form_validation->set_rules('note', $this->lang->line("product_details_for_invoice"), 'xss_clean');
		$this->form_validation->set_rules('cf1', $this->lang->line("pcf1"), 'xss_clean');
		$this->form_validation->set_rules('cf2', $this->lang->line("pcf2"), 'xss_clean');
		$this->form_validation->set_rules('cf2', $this->lang->line("pcf3"), 'xss_clean');
		$this->form_validation->set_rules('cf4', $this->lang->line("pcf4"), 'xss_clean');
		$this->form_validation->set_rules('cf5', $this->lang->line("pcf5"), 'xss_clean');
		$this->form_validation->set_rules('cf6', $this->lang->line("pcf6"), 'xss_clean');
		
		if ($this->form_validation->run() == true)
		{
			$data = array('code' => $this->input->post('code'),
				'name' => $this->input->post('name'),
				'category_id' => $this->input->post('category'),
				'subcategory_id' => $this->input->post('subcategory'),
				'unit' => $this->input->post('unit'),
				'size' => $this->input->post('size'),
				'cost' => $this->input->post('cost'),
				'price' => $this->input->post('price'),
				'alert_quantity' => $this->input->post('alert_quantity'),
				'tax_rate' => $this->input->post('tax_rate') ? $this->input->post('tax_rate') : NULL,
				'track_quantity' => $this->input->post('track_quantity') ? $this->input->post('track_quantity') : '0',
				'cf1' => $this->input->post('cf1'),
				'cf2' => $this->input->post('cf2'),
				'cf3' => $this->input->post('cf3'),
				'cf4' => $this->input->post('cf4'),
				'cf5' => $this->input->post('cf5'),
				'cf6' => $this->input->post('cf6'),
                                'details' => $this->input->post('note')
			);
			
		if($_FILES['userfile']['size'] > 0){
				
		$this->load->library('upload_photo');
		
 		$config['upload_path'] = 'assets/uploads/'; 
		$config['allowed_types'] = 'gif|jpg|png'; 
		$config['max_size'] = '500';
		$config['max_width'] = '800';
		$config['max_height'] = '800';
		$config['overwrite'] = FALSE; 
		
 			$this->upload_photo->initialize($config);
			
			if( ! $this->upload_photo->do_upload()){
			
 				$error = $this->upload_photo->display_errors();
				$this->session->set_flashdata('message', $error);
				redirect("module=products&view=edit&id=".$id, 'refresh');
			} 
		
 		$photo = $this->upload_photo->file_name;
		
		$this->load->helper('file');
		$this->load->library('image_lib');
		$config['image_library'] = 'gd2';
		$config['source_image'] = 'assets/uploads/'.$photo;
		$config['new_image'] = 'assets/uploads/thumbs/'.$photo;
		$config['maintain_ratio'] = TRUE;
		$config['width'] = 76;
		$config['height'] = 76;
		
		$this->image_lib->clear();
                $this->image_lib->initialize($config);
		
		if ( ! $this->image_lib->resize())
		{
			echo $this->image_lib->display_errors();
			
		}
		
		} else {
			$photo = NULL;
		}
		
		}
		
		if ( $this->form_validation->run() == true && $this->products_model->updateProduct($id, $photo, $data))
		{  
			$this->session->set_flashdata('success_message', $this->lang->line("product_updated"));
			redirect("module=products", 'refresh');
		}
		else
		{  
			$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));

			
		$product_details = $this->products_model->getProductByID($id);
		$data['categories'] = $this->products_model->getAllCategories();
		$data['tax_rates'] = $this->products_model->getAllTaxRates();
		$data['subcategories'] = $this->products_model->getSubCategoriesByCategoryID($product_details->category_id);
		$meta['page_title'] = $this->lang->line("update_product");
		$data['id'] = $id;
		$data['product'] = $product_details;
		$data['page_title'] = $this->lang->line("update_product");
		$this->load->view('commons/header', $meta);
		$this->load->view('edit', $data);
		$this->load->view('commons/footer');
		
		}
	}
		/* ----------------------------------------------------------------------------------------------------------------------------------------- */
	
	function upload_csv()
	{
		$groups = array('purchaser', 'salesman', 'viewer');
		if ($this->ion_auth->in_group($groups))
		{
			$this->session->set_flashdata('message', $this->lang->line("access_denied"));
			$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			redirect('module=products', 'refresh');
		}
			
		$this->form_validation->set_rules('userfile', $this->lang->line("upload_file"), 'xss_clean');
		 
		if ($this->form_validation->run() == true)
		{
			
		if (DEMO) {
			$this->session->set_flashdata('message', $this->lang->line("disabled_in_demo"));
			redirect('module=home', 'refresh');
		}
		
		$category = $this->input->post('category');			
		if ( isset($_FILES["userfile"])) /*if($_FILES['userfile']['size'] > 0)*/
		{
				
		$this->load->library('upload_photo');
		
		$config['upload_path'] = 'assets/uploads/csv/'; 
		$config['allowed_types'] = 'csv'; 
		$config['max_size'] = '200';
		$config['overwrite'] = TRUE; 
		
			$this->upload_photo->initialize($config);
			
			if( ! $this->upload_photo->do_upload()){
			
				$error = $this->upload_photo->display_errors();
				$this->session->set_flashdata('message', $error);
				redirect("module=products&view=upload_csv", 'refresh');
			} 
		
		$csv = $this->upload_photo->file_name;
		
		$arrResult = array();
			$handle = fopen("assets/uploads/csv/".$csv, "r");
			if( $handle ) {
			while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
			$arrResult[] = $row;
			}
			fclose($handle);
			}
			$titles = array_shift($arrResult);
			
			$keys = array('code', 'name', 'category_code', 'unit', 'size', 'cost', 'price', 'alert_quantity', 'tax_rate');
			
			$final = array();
					
					foreach ( $arrResult as $key => $value ) {
								$final[] = array_combine($keys, $value);
					}
			$rw=2;
			foreach($final as $csv_pr) {
				if($this->products_model->getProductByCode($csv_pr['code'])) {
						$this->session->set_flashdata('message', $this->lang->line("check_product_code")." (".$csv_pr['code']."). ".$this->lang->line("code_already_exist")." ".$this->lang->line("line_no")." ".$rw);
						redirect("module=products&view=upload_csv", 'refresh');
				}
				if( $catd = $this->products_model->getCategoryByCode($csv_pr['category_code'])) {
					$pr_code[] = $csv_pr['code'];
					$pr_name[] = $csv_pr['name'];
					$pr_cat[] = $catd->id;
					$pr_unit[] = $csv_pr['unit'];
					$pr_size[] = $csv_pr['size'];
					$pr_cost[] = $csv_pr['cost'];
					$pr_price[] = $csv_pr['price'];
					$pr_aq[] = $csv_pr['alert_quantity'];
                                        $tax_details = $this->products_model->getTaxRateByName($csv_pr['tax_rate']);
                                        $pr_tax[] = $tax_details->id ? $tax_details->id : (DEFAULT_TAX ? DEFAULT_TAX  : NULL);
                                         
				} else {
					$this->session->set_flashdata('message', $this->lang->line("check_category_code")." (".$csv_pr['category_code']."). ".$this->lang->line("category_code_x_exist")." ".$this->lang->line("line_no")." ".$rw);
					redirect("module=products&view=upload_csv", 'refresh');
				}
				
			$rw++;	
			}
		} 

		$ikeys = array('code', 'name', 'category_id', 'unit', 'size', 'cost', 'price', 'alert_quantity', 'tax_rate');
		
					$items = array();
				foreach ( array_map(null, $pr_code, $pr_name, $pr_cat, $pr_unit, $pr_size, $pr_cost, $pr_price, $pr_aq, $pr_tax) as $ikey => $value ) {
					$items[] = array_combine($ikeys, $value);
				}
				
		$final = $this->mres($items);
		//$data['final'] = $final;
		}
	
		if ( $this->form_validation->run() == true && $this->products_model->add_products($final))
		{ 
			$this->session->set_flashdata('success_message', $this->lang->line("products_added"));
			redirect('module=products', 'refresh');
		}
		else
		{  
		
			$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			
			$data['userfile'] = array('name' => 'userfile',
				'id' => 'userfile',
				'type' => 'text',
				'value' => $this->form_validation->set_value('userfile')
			);

		$data['categories'] = $this->products_model->getAllCategories();
		$meta['page_title'] = $this->lang->line("csv_add_products");
		$data['page_title'] = $this->lang->line("csv_add_products");
		$this->load->view('commons/header', $meta);
		$this->load->view('upload_csv', $data);
		$this->load->view('commons/footer');
		
		}
	}
	
		/* -------------------------------------------------------------------------------------------------------------------------------------- */
		
	function update_price()
	{
		$groups = array('purchaser', 'salesman', 'viewer');
		if ($this->ion_auth->in_group($groups))
		{
			$this->session->set_flashdata('message', $this->lang->line("access_denied"));
			$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			redirect('module=products', 'refresh');
		}
			
		$this->form_validation->set_rules('userfile', $this->lang->line("upload_file"), 'xss_clean');
		 
		if ($this->form_validation->run() == true)
		{
		
		if (DEMO) {
			$this->session->set_flashdata('message', $this->lang->line("disabled_in_demo"));
			redirect('module=home', 'refresh');
		}
			
		if ( isset($_FILES["userfile"])) /*if($_FILES['userfile']['size'] > 0)*/
		{
				
		$this->load->library('upload_photo');
		
		$config['upload_path'] = 'assets/uploads/csv/'; 
		$config['allowed_types'] = 'csv'; 
		$config['max_size'] = '200';
		$config['overwrite'] = TRUE; 
		
			$this->upload_photo->initialize($config);
			
			if( ! $this->upload_photo->do_upload()){
			
				$error = $this->upload_photo->display_errors();
				$this->session->set_flashdata('message', $error);
				redirect("module=products&view=update_price", 'refresh');
			} 
		
		$csv = $this->upload_photo->file_name;
		
		$arrResult = array();
			$handle = fopen("assets/uploads/csv/".$csv, "r");
			if( $handle ) {
			while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
			$arrResult[] = $row;
			}
			fclose($handle);
			}
			$titles = array_shift($arrResult);
			
			$keys = array('code', 'price');
			
			$final = array();
					
					foreach ( $arrResult as $key => $value ) {
								$final[] = array_combine($keys, $value);
					}
			$rw=2;
			foreach($final as $csv_pr) {
				if(!$this->products_model->getProductByCode($csv_pr['code'])) {
						$this->session->set_flashdata('message', $this->lang->line("check_product_code")." (".$csv_pr['code']."). ".$this->lang->line("code_x_exist")." ".$this->lang->line("line_no")." ".$rw);
						redirect("module=products&view=update_price", 'refresh');
					}
			$rw++;	
			}
		} 

		$final = $this->mres($final);
		//$data['final'] = $final;
		}
	
		if ( $this->form_validation->run() == true && isset($_POST['submit']) )
		{ 
			$this->products_model->updatePrice($final);
			$this->session->set_flashdata('success_message', $this->lang->line("price_updated"));
			redirect('module=products', 'refresh');
		}
		else
		{
		
			$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			
			$data['userfile'] = array('name' => 'userfile',
				'id' => 'userfile',
				'type' => 'text',
				'value' => $this->form_validation->set_value('userfile')
			);

		
		$meta['page_title'] = $this->lang->line("update_price_csv");
		$data['page_title'] = $this->lang->line("update_price_csv");
		$this->load->view('commons/header', $meta);
		$this->load->view('update_price', $data);
		$this->load->view('commons/footer');
		
		}
	}
	
		/* ---------------------------------------------------------------------------------------------------------------------------------------- */
		
	function delete($id = NULL)
	{
		if($this->input->get('id')){ $id = $this->input->get('id'); }
		if (DEMO) {
			$this->session->set_flashdata('message', $this->lang->line("disabled_in_demo"));
			redirect('module=home', 'refresh');
		}
		
		$groups = array('admin', 'purchaser', 'salesman', 'viewer');
		if ($this->ion_auth->in_group($groups))
		{
			$this->session->set_flashdata('message', $this->lang->line("access_denied"));
			$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			redirect('module=products', 'refresh');
		}
		
		if ( $this->products_model->deleteProduct($id) )
		{  
			$this->session->set_flashdata('success_message', $this->lang->line("product_deleted"));
			redirect('module=products', 'refresh');
		}
		
	}
	
		/* ----------------------------------------------------------------------------------------------------------------------------- */
	
	function damage_products()
   {
	  $data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
	  $data['success_message'] = $this->session->flashdata('success_message');
	  $data['warehouses'] = $this->products_model->getAllWarehouses();
	  	
	  $meta['page_title'] = $this->lang->line("damage_products");
	  $data['page_title'] = $this->lang->line("damage_products"); 
	  
	  $this->load->view('commons/header', $meta);
      $this->load->view('damage_products', $data);
      $this->load->view('commons/footer');
   }
   
	function getdamageproducts()
   {
 
	   $this->load->library('datatables');
	   $this->datatables
			->select("damage_products.id as did, damage_products.product_id as productid, damage_products.date as date, products.image as image, products.code as code, products.name as pname, damage_products.quantity as quantity, warehouses.name as wh,");
			$this->datatables->from('damage_products');
			$this->datatables->join('products', 'products.id=damage_products.product_id', 'left');
			$this->datatables->join('warehouses', 'warehouses.id=damage_products.warehouse_id', 'left');
			$this->datatables->group_by("damage_products.id");
			$this->datatables->add_column("Actions", 
			"<center><a href='index.php?module=products&view=edit_damage&product_id=$1&id=$2' class='tip' title='".$this->lang->line("edit_damage_details")."'><i class='icon-edit'></i></a>
			<a href='index.php?module=products&view=delete_demage&id=$2' onClick=\"return confirm('". $this->lang->line('alert_x_damage_product') ."')\" class='tip' title='".$this->lang->line("delete_damage_product")."'><i class='icon-trash'></i></a></center>", "productid, did");
		
		$this->datatables->unset_column('did');
		$this->datatables->unset_column('productid');
		$this->datatables->unset_column('image');
				
	    echo $this->datatables->generate();

   }
   	
	function add_damage()
	{
		if($this->input->get('product_id')){ $product_id = $this->input->get('product_id'); }
		if($this->input->get('warehouse_id')){ $data['warehouse_id'] = $this->input->get('warehouse_id'); } else { $data['warehouse_id'] = NULL; }
		
		$groups = array('purchaser', 'salesman', 'viewer');
		if ($this->ion_auth->in_group($groups))
		{
			$this->session->set_flashdata('message', $this->lang->line("access_denied"));
			$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			redirect('module=products', 'refresh');
		}
		
		//validate form input
		$this->form_validation->set_rules('date', $this->lang->line("date"), 'required|xss_clean');
		$this->form_validation->set_rules('quantity', $this->lang->line("damage_quantity"), 'required|xss_clean');
		$this->form_validation->set_rules('warehouse', $this->lang->line("warehouse"), 'required|xss_clean');
		
		if ($this->form_validation->run() == true)
		{
		
			$date = $this->ion_auth->fsd(trim($this->input->post('date')));
			$product_id = $product_id;
			$quantity = $this->input->post('quantity');
			$warehouse = $this->input->post('warehouse');
			$note = $this->ion_auth->clear_tags($this->input->post('note'));
			
		}
		
		if ( $this->form_validation->run() == true && $this->products_model->addDamage($product_id, $date, $quantity, $warehouse, $note) )
		{  
			$this->session->set_flashdata('success_message', $this->lang->line("damage_product_added"));
			redirect('module=products&view=damage_products', 'refresh');
		}
		else
		{  
			$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			
		$data['product'] = $this->products_model->getProductByID($product_id);
		$data['warehouses'] = $this->products_model->getAllWarehouses();
		$data['product_id'] = $product_id;
		$meta['page_title'] = $this->lang->line("add_damage_product");
		$data['page_title'] = $this->lang->line("add_damage_product");
		$this->load->view('commons/header', $meta);
		$this->load->view('add_damage', $data);
		$this->load->view('commons/footer');
		
		}
	}
	
	function edit_damage()
	{
		if($this->input->get('id')){ $id = $this->input->get('id'); }
		if($this->input->get('product_id')){ $product_id = $this->input->get('product_id'); }
		$groups = array('purchaser', 'salesman', 'viewer');
		if ($this->ion_auth->in_group($groups))
		{
			$this->session->set_flashdata('message', $this->lang->line("access_denied"));
			$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			redirect('module=products', 'refresh');
		}
		
		//validate form input
		$this->form_validation->set_rules('date', $this->lang->line("date"), 'required|xss_clean');
		$this->form_validation->set_rules('quantity', $this->lang->line("damage_quantity"), 'required|xss_clean');
		$this->form_validation->set_rules('warehouse', $this->lang->line("warehouse"), 'required|xss_clean');
		
		if ($this->form_validation->run() == true)
		{
		
			$date = $this->ion_auth->fsd(trim($this->input->post('date')));
			$product_id = $product_id;
			$quantity = $this->input->post('quantity');
			$warehouse = $this->input->post('warehouse');
			$note = $this->ion_auth->clear_tags($this->input->post('note'));
			
		}
		
		if ( $this->form_validation->run() == true && $this->products_model->updateDamage($id, $product_id, $date, $quantity, $warehouse, $note) )
		{  
			$this->session->set_flashdata('success_message', $this->lang->line("damage_product_updated"));
			redirect('module=products&view=damage_products', 'refresh');
		}
		else
		{  
			$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			
		$data['product'] = $this->products_model->getProductByID($product_id);
		$data['damage'] = $this->products_model->getDamagePDByID($id);
		$data['warehouses'] = $this->products_model->getAllWarehouses();
		$data['id'] = $id;
		$data['product_id'] = $product_id;
		$meta['page_title'] = $this->lang->line("edit_damage_product");
		$data['page_title'] = $this->lang->line("edit_damage_product");
		$this->load->view('commons/header', $meta);
		$this->load->view('edit_damage', $data);
		$this->load->view('commons/footer');
		
		}
	}
	
	/* ------------------------------------------------------------------------------------------------------------------------ */
	
	function mres($q) {
		if(is_array($q))
			foreach($q as $k => $v)
				$q[$k] = $this->mres($v); //recursive
		elseif(is_string($q))
			$q = mysql_real_escape_string($q);
		return $q;
	}
	
	
	function product_details($id = NULL)
	{
		if($this->input->get('id')){ $id = $this->input->get('id'); }
		
		$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
		
		$pr_details = $this->products_model->getProductByID($id);
		$category_id = $pr_details->category_id;
		$data['barcode'] = "<img src='".$this->config->base_url()."index.php?module=products&view=gen_barcode&code=".$pr_details->code."' alt='".$pr_details->code."' />";	
		$data['product'] = $pr_details;
		$data['category'] = $this->products_model->getCategoryByID($category_id);
		$meta['page_title'] = $this->lang->line("product_details");
		$data['page_title'] = $this->lang->line("product_details");
		$this->load->view('details', $data);
		
	}
	
	   
	function getSubCategories()
	{
		$category_id = $this->input->get('category_id',TRUE);
	
		if($rows = $this->products_model->getSubCategoriesByCategoryID($category_id)) {
			$ct[""] = '';
				foreach($rows as $category){
					$ct[$category->id] = $category->name;
				}
				$data = form_dropdown('subcategory', $ct, '', 'class="span4" id="subcategory" data-placeholder="'.$this->lang->line("select")." ".$this->lang->line("subcategory").'"');
		} else { 
			$data = "";
		}
		echo $data; 
	}
	
	function delete_demage($id = NULL)
	{
	
		if($this->input->get('id')){ $id = $this->input->get('id'); }
			
		if (!$this->ion_auth->in_group('owner'))
		{
			$this->session->set_flashdata('message', $this->lang->line("access_denied"));
			$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			redirect('module=products&view=damage_products', 'refresh');
		}
		
		if ( $this->products_model->deleteDamage($id) )
		{
			$this->session->set_flashdata('success_message', $this->lang->line("damage_product_deleted"));
			redirect('module=products&view=damage_products', 'refresh');
		}
	
	}


}