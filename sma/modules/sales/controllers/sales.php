<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sales extends MX_Controller {

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
| MODULE: 			Sales
| -----------------------------------------------------
| This is sales module controller file.
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
		$this->load->model('sales_model');

	}
/* -------------------------------------------------------------------------------------------------------------------------------- */
//index or inventories page
	
   function index()
   {
	  
		if ($this->ion_auth->in_group('purchaser'))
		{
			$this->session->set_flashdata('message', $this->lang->line("access_denied"));
			$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			redirect('module=home', 'refresh');
		}
				
	   $data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
	   $data['success_message'] = $this->session->flashdata('success_message');

	   $data['warehouses'] = $this->sales_model->getAllWarehouses();
      $meta['page_title'] = $this->lang->line("sales");
	  $data['page_title'] = $this->lang->line("sales");
      $this->load->view('commons/header', $meta);
      $this->load->view('content', $data);
      $this->load->view('commons/footer');
   }
   
   function getdatatableajax()
   {
 		if($this->input->get('search_term')) { $search_term = $this->input->get('search_term'); } else { $search_term = false;}
		
	   $this->load->library('datatables');
	   $this->datatables
			->select("sales.id as sid, date, reference_no, biller_name, customer_name, total_tax, total_tax2, total, internal_note")
			->from('sales');
			$this->datatables->add_column("Actions", 
			"<center><a href='#' title='$2' class='tip' data-html='true'><i class='icon-folder-close'></i></a> <a href='#' onClick=\"MyWindow=window.open('index.php?module=sales&view=view_invoice&id=$1', 'MyWindow','toolbar=0,location=0,directories=0,status=0,menubar=yes,scrollbars=yes,resizable=yes,width=1000,height=600'); return false;\" title='".$this->lang->line("view_invoice")."' class='tip'><i class='icon-fullscreen'></i></a> 
			<a href='index.php?module=sales&view=add_delivery&id=$1' title='".$this->lang->line("add_delivery_order")."' class='tip'><i class='icon-road'></i></a>
			<a href='index.php?module=sales&view=pdf&id=$1' title='".$this->lang->line("download_pdf")."' class='tip'><i class='icon-file'></i></a> 
			<a href='index.php?module=sales&view=email_invoice&id=$1' title='".$this->lang->line("email_invoice")."' class='tip'><i class='icon-envelope'></i></a>
			<a href='index.php?module=sales&amp;view=edit&amp;id=$1' title='".$this->lang->line("edit_invoice")."' class='tip'><i class='icon-edit'></i></a>
			<a href='index.php?module=sales&amp;view=delete&amp;id=$1' onClick=\"return confirm('". $this->lang->line('alert_x_invoice') ."')\" title='".$this->lang->line("delete_invoice")."' class='tip'><i class='icon-trash'></i></a></center>", "sid, internal_note")
		
		->unset_column('sid')
		->unset_column('internal_note');
		
	   echo $this->datatables->generate();

   }
   
   
   function warehouse($warehouse = DEFAULT_WAREHOUSE)
   {
	   if($this->input->get('warehouse_id')){ $warehouse = $this->input->get('warehouse_id'); }
	   
	  $data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
	  
	  $data['warehouses'] = $this->sales_model->getAllWarehouses();
	  $data['warehouse_id'] = $warehouse;

      $meta['page_title'] = $this->lang->line("sales");
	  $data['page_title'] = $this->lang->line("sales");
      $this->load->view('commons/header', $meta);
      $this->load->view('warehouse', $data);
      $this->load->view('commons/footer');
   }
   
   function getwhinv($warehouse_id = NULL)
   {
	   if($this->input->get('warehouse_id')){ $warehouse_id = $this->input->get('warehouse_id'); }
   
   		$this->load->library('datatables');
	  
	   $this->datatables
			->select("id, date, reference_no, biller_name, customer_name, total_tax, total_tax2, total")
			->from('sales')
			->where('warehouse_id', $warehouse_id)
			->add_column("Actions", 
			"<center><a href='#' onClick=\"MyWindow=window.open('index.php?module=sales&view=view_invoice&id=$1', 'MyWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=1000,height=600'); return false;\" title='".$this->lang->line("view_invoice")."' class='tip'><i class='icon-fullscreen'></i></a> 
			<a href='index.php?module=sales&view=add_delivery&id=$1' title='".$this->lang->line("add_delivery_order")."' class='tip'><i class='icon-road'></i></a>
			<a href='index.php?module=sales&view=pdf&id=$1' title='".$this->lang->line("download_pdf")."' class='tip'><i class='icon-file'></i></a> 
			<a href='index.php?module=sales&view=email_invoice&id=$1' title='".$this->lang->line("email_invoice")."' class='tip'><i class='icon-envelope'></i></a>
			<a href='index.php?module=sales&amp;view=edit&amp;id=$1' title='".$this->lang->line("edit_invoice")."' class='tip'><i class='icon-edit'></i></a>
			<a href='index.php?module=sales&amp;view=delete&amp;id=$1' onClick=\"return confirm('". $this->lang->line('alert_x_invoice') ."')\" title='".$this->lang->line("delete_invoice")."' class='tip'><i class='icon-trash'></i></a></center>", "id")
		
		->unset_column('id');
		
		
	   echo $this->datatables->generate();

   }
   
   function total()
   {
	   $data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
	   
	  $data['monthly_sales'] = $this->sales_model->getmonthlySales();
	  $data['monthly_purchases'] = $this->sales_model->getmonthlyPurchases();
	
      $meta['page_title'] = $this->lang->line("total_sales");
	  $data['page_title'] = $this->lang->line("total_sales");
      $this->load->view('commons/header', $meta);
      $this->load->view('sales', $data);
      $this->load->view('commons/footer');
   }
/* -------------------------------------------------------------------------------------------------------------------------------- */
//view inventory as html page
   
   function view_invoice()
   {
	   if($this->input->get('id')){ $sale_id = $this->input->get('id'); } else { $sale_id = NULL; }
	   if($this->input->get('quote_id')){ $quote_id = $this->input->get('quote_id'); } else { $quote_id = NULL; }
	   
	   	   $data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
		   $data['rows'] = $this->sales_model->getAllInvoiceItemsWithDetails($sale_id);
		   
		   $inv = $this->sales_model->getInvoiceBySaleID($sale_id);
		   $biller_id = $inv->biller_id;
		   $customer_id = $inv->customer_id;
		   $invoice_type_id = $inv->invoice_type;
		   $data['biller'] = $this->sales_model->getBillerByID($biller_id);
		   $data['customer'] = $this->sales_model->getCustomerByID($customer_id);
		   $data['invoice_types_details'] = $this->sales_model->getInvoiceTypeByID($invoice_type_id);
		   
		   $data['inv'] = $inv;

	  $data['page_title'] = $this->lang->line("invoice");
	
      $this->load->view('view_invoice', $data);

   }
/* -------------------------------------------------------------------------------------------------------------------------------- */
//generate pdf and force to download  

function pdf()
   {
	   if($this->input->get('id')){ $sale_id = $this->input->get('id'); } else { $sale_id = NULL; }
	   
	   	   $data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
		   $data['rows'] = $this->sales_model->getAllInvoiceItemsWithDetails($sale_id);
		   
		   $inv = $this->sales_model->getInvoiceBySaleID($sale_id);
		   $biller_id = $inv->biller_id;
		   $customer_id = $inv->customer_id;
		   $invoice_type_id = $inv->invoice_type;
		   $data['biller'] = $this->sales_model->getBillerByID($biller_id);
		   $data['customer'] = $this->sales_model->getCustomerByID($customer_id);
		   $data['invoice_types_details'] = $this->sales_model->getInvoiceTypeByID($invoice_type_id);
		   
		   $data['inv'] = $inv;

	  	   $data['page_title'] = $this->lang->line("invoice");
	
                $html =  $this->load->view('view_invoice', $data, TRUE);
	 
	 	$this->load->library('MPDF/mpdf');
			  
		$mpdf=new mPDF('utf-8','A4', '12', '', 10, 10, 10, 10, 9, 9); 
		$mpdf->useOnlyCoreFonts = true;
		$mpdf->SetProtection(array('print'));
		$mpdf->SetTitle(SITE_NAME);
		$mpdf->SetAuthor(SITE_NAME);
		$mpdf->SetCreator(SITE_NAME);
		$mpdf->SetDisplayMode('fullpage');
		$mpdf->SetAutoFont();
                $stylesheet = file_get_contents('assets/css/bootstrap-'.THEME.'.css');
                $mpdf->WriteHTML($stylesheet,1);
                
		$name = $this->lang->line("invoice"). " ".$this->lang->line("no")." ".$inv->id.".pdf";
		
		$search = array("<div class=\"row-fluid\">", "<div class=\"span6\">", "<div class=\"span5\">", "<div class=\"span5 offset2\">");
		$replace = array("<div style='width: 100%;'>", "<div style='width: 48%; float: left;'>", "<div style='width: 40%; float: left;'>", "<div style='width: 40%; float: right;'>");
		$html = str_replace($search, $replace, $html);

		$mpdf->WriteHTML($html);
	
		$mpdf->Output($name, 'D'); 

		exit;

   }
   
 
/* -------------------------------------------------------------------------------------------------------------------------------- */
//email inventory as html and send pdf as attachment   

   function email($id, $to, $cc = NULL, $bcc = NULL, $from_name, $from, $subject, $note)
   {
	 	if($this->input->get('id')){ $sale_id = $this->input->get('id'); } else { $sale_id = NULL; }
	   
	   	   $data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
		   $data['rows'] = $this->sales_model->getAllInvoiceItemsWithDetails($sale_id);
		   
		   $inv = $this->sales_model->getInvoiceBySaleID($sale_id);
		   $biller_id = $inv->biller_id;
		   $customer_id = $inv->customer_id;
		   $invoice_type_id = $inv->invoice_type;
		   $data['biller'] = $this->sales_model->getBillerByID($biller_id);
		   $data['customer'] = $this->sales_model->getCustomerByID($customer_id);
		   $data['invoice_types_details'] = $this->sales_model->getInvoiceTypeByID($invoice_type_id);
		   
		   $data['inv'] = $inv;
		   $data['sid'] = $sale_id; 

	  	   $data['page_title'] = $this->lang->line("invoice");
	
     	$html =  $this->load->view('view_invoice', $data, TRUE);
	 
	 	$this->load->library('MPDF/mpdf');
			  
		$mpdf=new mPDF('utf-8','A4', '12', '', 10, 10, 10, 10, 9, 9); 
		$mpdf->useOnlyCoreFonts = true;
		$mpdf->SetProtection(array('print'));
		$mpdf->SetTitle(SITE_NAME);
		$mpdf->SetAuthor(SITE_NAME);
		$mpdf->SetCreator(SITE_NAME);
		$mpdf->SetDisplayMode('fullpage');
		$mpdf->SetAutoFont();
                $stylesheet = file_get_contents('assets/css/bootstrap-'.THEME.'.css');
                $mpdf->WriteHTML($stylesheet,1);
                
		$name = $this->lang->line("invoice"). " ".$this->lang->line("no")." ".$inv->id.".pdf";
		
		$search = array("<div class=\"row-fluid\">", "<div class=\"span6\">", "<div class=\"span5\">", "<div class=\"span5 offset2\">");
		$replace = array("<div style='width: 100%;'>", "<div style='width: 48%; float: left;'>", "<div style='width: 40%; float: left;'>", "<div style='width: 40%; float: right;'>");
		$html = str_replace($search, $replace, $html);
		
		$mpdf->WriteHTML($html);
		
		$mpdf->Output($name,'F');
		
		if($note) { $message = $note."<br><hr>".$html; } else { $message = $html; }
	 		
		$this->load->library('email');
		
		$config['mailtype'] = 'html';
		$config['wordwrap'] = TRUE;
	
		$this->email->initialize($config);
		
		$this->email->from($from, $from_name);
		$this->email->to($to); 
		if($cc) { $this->email->cc($cc);}
		if($bcc) { $this->email->bcc($bcc);}
	
		$this->email->subject($subject);
		$this->email->message($message);
		$this->email->attach($name);	
		
		if($this->email->send()) {
			// email sent		
			unlink($name);
			return true;
		} else {
			//email not sent
			unlink($name);
			//echo $this->email->print_debugger();
			return false;
		}
		

   }
   
   function email_invoice()
   {
	   if($this->input->get('id')){ $id = $this->input->get('id'); } else { $id = NULL; }
	   if($this->input->get('quote_id')){ $quote_id = $this->input->get('quote_id'); } else { $quote_id = NULL; }
		
		//validate form input
		$this->form_validation->set_rules('to', $this->lang->line("to")." ".$this->lang->line("email"), 'trim|required|valid_email|xss_clean');
		$this->form_validation->set_rules('subject', $this->lang->line("subject"), 'trim|required|xss_clean');
		$this->form_validation->set_rules('cc', $this->lang->line("cc"), 'trim|xss_clean');
		$this->form_validation->set_rules('bcc', $this->lang->line("bcc"), 'trim|xss_clean');
		$this->form_validation->set_rules('note', $this->lang->line("message"), 'trim|xss_clean');
		
		if ($this->form_validation->run() == true)
		{
			$to = $this->input->post('to');
			$subject= $this->input->post('subject');
			if($this->input->post('cc')) { $cc = $this->input->post('cc'); } else { $cc = NULL; }
			if($this->input->post('bcc')) { $bcc = $this->input->post('bcc'); } else { $bcc = NULL; }
			$message = $this->ion_auth->clear_tags($this->input->post('note'));
			$user = $this->ion_auth->user()->row();	
			$from_name = $user->first_name." ".$user->last_name;
			$from = $user->email;
		}
		
		if ( $this->form_validation->run() == true && $this->email($id, $to, $cc, $bcc, $from_name, $from, $subject, $message) )
		{  	
				$this->session->set_flashdata('success_message', $this->lang->line("sent"));
				redirect("module=sales", 'refresh');		
		}
		else
		{ 
		
			$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
		
			$data['to'] = array('name' => 'to',
				'id' => 'to',
				'type' => 'text',
				'value' => $this->form_validation->set_value('to'),
			);

			$data['note'] = array('name' => 'note',
				'id' => 'note',
				'type' => 'text',
				'value' => $this->form_validation->set_value('note'),
			);
			
			
		$user = $this->ion_auth->user()->row();	
	    $data['from_name'] = $user->first_name." ".$user->last_name;
		$data['from_email'] = $user->email;


			$inv = $this->sales_model->getInvoiceByID($id);
			$customer_id = $inv->customer_id;
		
			$data['cus'] = $this->sales_model->getCustomerByID($customer_id);
			$data['id'] = $id;
			$data['quote_id'] = NULL;
			$meta['page_title'] = $this->lang->line("email"). " " . $this->lang->line("invoice");
	  		$data['page_title'] = $this->lang->line("email"). " " . $this->lang->line("invoice");
		
      
      $this->load->view('commons/header', $meta);
      $this->load->view('email', $data);
      $this->load->view('commons/footer');
			
		}
   }
/* -------------------------------------------------------------------------------------------------------------------------------- */ 
//Add new invoice

   function add()
   {
	   $groups = array('purchaser', 'viewer');
		if ($this->ion_auth->in_group($groups))
		{
			$this->session->set_flashdata('message', $this->lang->line("access_denied"));
			$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			redirect('module=sales', 'refresh');
		}
		
		$this->form_validation->set_message('is_natural_no_zero', $this->lang->line("no_zero_required"));
		//validate form input
		$this->form_validation->set_rules('reference_no', $this->lang->line("reference_no"), 'required|xss_clean');
		$this->form_validation->set_rules('date', $this->lang->line("date"), 'required|xss_clean');
		$this->form_validation->set_rules('biller', $this->lang->line("biller"), 'required|is_natural_no_zero|xss_clean');
		$this->form_validation->set_rules('customer', $this->lang->line("customer"), 'required|is_natural_no_zero|xss_clean');
		$this->form_validation->set_rules('warehouse', $this->lang->line("warehouse"), 'is_natural_no_zero|required|xss_clean');
		$this->form_validation->set_rules('note', $this->lang->line("note"), 'xss_clean');
		$this->form_validation->set_rules('shipping', $this->lang->line("shipping"), 'xss_clean');
		if(TAX2) { $this->form_validation->set_rules('tax2', $this->lang->line("tax2"), 'required|is_natural_no_zero|xss_clean'); }
		if(DISCOUNT_OPTION == 1) { $this->form_validation->set_rules('inv_discount', $this->lang->line("discount"), 'required|is_natural_no_zero|xss_clean'); }

		$quantity = "quantity";
		$product = "product";
		$unit_price = "unit_price";
		$tax_rate = "tax_rate";
		$sl = "serial";
		$dis = "discount";
			
		if ($this->form_validation->run() == true)
		{
			$date = $this->ion_auth->fsd(trim($this->input->post('date')));
			$reference_no = $this->input->post('reference_no');
			$warehouse_id = $this->input->post('warehouse');
			$biller_id = $this->input->post('biller');
			$biller_details = $this->sales_model->getBillerByID($biller_id);
			$biller_name = $biller_details->name;
			$customer_id = $this->input->post('customer');
			$customer_details = $this->sales_model->getCustomerByID($customer_id);
			$customer_name = $customer_details->name;
			if(DISCOUNT_OPTION == 1) { $inv_discount = $this->input->post('inv_discount'); }
			if(TAX2) {  $tax_rate2 = $this->input->post('tax2'); }
			$note = $this->ion_auth->clear_tags($this->input->post('note'));
			$internal_note = $this->ion_auth->clear_tags($this->input->post('internal_note'));
			$shipping = $this->input->post('shipping');
			
			$inv_total_no_tax = 0;

				for($i=1; $i<=500; $i++){
					if( $this->input->post($quantity.$i) && $this->input->post($product.$i) && $this->input->post($unit_price.$i) ) {
                         $product_details = $this->sales_model->getProductByCode($this->input->post($product.$i));
                         if(RESTRICT_SALE) {	
                            if($pr_ck = $this->sales_model->getWarehouseProductQuantity($warehouse_id, $product_details->id)) {
								if($pr_ck->quantity < $this->input->post($quantity.$i) && $product_details->track_quantity == 1) {
										$this->session->set_flashdata('message', $this->lang->line("wh_qty_less_then_sale")." (".$product_details->name.")");
										redirect("module=sales&view=add", 'refresh');
								}
							} else {
								$this->session->set_flashdata('message', $this->lang->line("wh_qty_less_then_sale")." (".$product_details->name.")");
								redirect("module=pos", 'refresh');
							}
                        }
			if(DISCOUNT_METHOD == 1 && DISCOUNT_OPTION == 2) {
						
							$discount_id = $this->input->post($dis.$i);
							$ds_details = $this->sales_model->getDiscountByID($discount_id);
							$ds = $ds_details->discount;
							$dsType = $ds_details->type;	
							$dsID[] = $discount_id;	
							
							if($dsType == 1 && $ds != 0) {
							    $pds = (($this->input->post($quantity.$i)) * ($this->input->post($unit_price.$i)) * $ds / 100);
							$val_ds[] = $pds;
							} else {
							    $pds = $ds * ($this->input->post($quantity.$i));
							$val_ds[] = $pds;
							}
							
							if($dsType == 1) { $discount[] = $ds."%"; } else { $discount[] = $ds;  }	
						
						} else { $pds = 0; }
						
						if(TAX1) { 
							$tax_id = $this->input->post($tax_rate.$i);
							$tax_details = $this->sales_model->getTaxRateByID($tax_id);
							$taxRate = $tax_details->rate;
							$taxType = $tax_details->type;	
							$tax_rate_id[] = $tax_id;	
							
							if($taxType == 1 && $taxRate != 0) {
							$item_tax = ((($this->input->post($quantity.$i)) * ($this->input->post($unit_price.$i))-$pds) * $taxRate / 100);
							$val_tax[] = $item_tax;
							} else {
							$item_tax = $taxRate;	
							$val_tax[] = $item_tax;
							}
							
							if($taxType == 1) { $tax[] = $taxRate."%"; } else { $tax[] = $taxRate;  }			
						} else {
							$item_tax = 0;
							$tax_rate_id[] = 0;
							$val_tax[] = 0;
							$tax[] = "";
						}
						
						if(DISCOUNT_METHOD == 2 && DISCOUNT_OPTION == 2) {
						
							$discount_id = $this->input->post($dis.$i);
							$ds_details = $this->sales_model->getDiscountByID($discount_id);
							$ds = $ds_details->discount;
							$dsType = $ds_details->type;	
							$dsID[] = $discount_id;	
							
							if($dsType == 1 && $ds != 0) {
							$val_ds[] = (((($this->input->post($quantity.$i)) * ($this->input->post($unit_price.$i)) + $item_tax) * $ds) / 100);
							} else {
							$val_ds[] = $ds * ($this->input->post($quantity.$i));
							}
							
							if($dsType == 1) { $discount[] = $ds."%"; } else { $discount[] = $ds;  }	
						
						} elseif(DISCOUNT_OPTION != 2) {
							$val_ds[] = 0;
							$dsID[] = 0;
							$discount[] = "";
						}
						
						if(PRODUCT_SERIAL) { $serial[] = $this->input->post($sl.$i); } else { $serial[] = ""; }
						$inv_quantity[] = $this->input->post($quantity.$i);
						//$inv_product_code[] = $this->input->post($product.$i);
						$product_id[] = $product_details->id;
						$product_name[] = $product_details->name;
						$product_code[] = $product_details->code;
						$product_unit[] = $product_details->unit;
						$inv_unit_price[] = $this->input->post($unit_price.$i);
						$inv_gross_total[] = (($this->input->post($quantity.$i)) * ($this->input->post($unit_price.$i)));
						
						$inv_total_no_tax += (($this->input->post($quantity.$i)) * ($this->input->post($unit_price.$i)));
						
					}
				}
			
			
			if(DISCOUNT_OPTION == 2) {
				$total_ds = array_sum($val_ds);
			} else {
				$total_ds = 0;
			}
			
			
			if(TAX1) {
				$total_tax = array_sum($val_tax);
			} else {
				$total_tax = 0;
			}
			
			
		/*	if(!empty($inv_product_code)) {	 
				foreach($inv_product_code as $pr_code){
					$product_details = $this->sales_model->getProductByCode($pr_code);
					$product_id[] = $product_details->id;
					$product_name[] = $product_details->name;
					$product_code[] = $product_details->code;
					$product_unit[] = $product_details->unit;
				}
			}*/
		
			$keys = array("product_id","product_code","product_name","product_unit", "tax_rate_id", "tax","quantity","unit_price", "gross_total", "val_tax", "serial_no", "discount_val", "discount", "discount_id");
		
			$items = array();
			foreach ( array_map(null, $product_id, $product_code, $product_name, $product_unit, $tax_rate_id, $tax, $inv_quantity, $inv_unit_price, $inv_gross_total, $val_tax, $serial, $val_ds, $discount, $dsID) as $key => $value ) {
				$items[] = array_combine($keys, $value);
			}
			
			if(DISCOUNT_METHOD == 1 && DISCOUNT_OPTION == 1) {
				
				$ds_dts = $this->sales_model->getDiscountByID($inv_discount);
				$ds = $ds_dts->discount;
				$dsTp = $ds_dts->type;	
					
				if($dsTp == 1 && $ds != 0) {
					$val_discount = (($inv_total_no_tax+$total_tax) * $ds / 100);
				} else {
					$val_discount = $ds;
				}
			
			} 
			
			if(TAX2) {
				$tax_dts = $this->sales_model->getTaxRateByID($tax_rate2);
				$taxRt = $tax_dts->rate;
				$taxTp = $tax_dts->type;	
				$t_ds = ($total_ds != 0) ? $total_ds : $val_discount;	
				if($taxTp == 1 && $taxRt != 0) {
					$val_tax2 = (($inv_total_no_tax+$total_tax-$t_ds) * $taxRt / 100);
				} else {
					$val_tax2 = $taxRt;
				}
				
			} else {
				$val_tax2 = 0;
				$tax_rate2 = 0;
			}
			
			if(DISCOUNT_METHOD == 2 && DISCOUNT_OPTION == 1) {
				
				$ds_dts = $this->sales_model->getDiscountByID($inv_discount);
				$ds = $ds_dts->discount;
				$dsTp = $ds_dts->type;	
					
				if($dsTp == 1 && $ds != 0) {
					$val_discount = ((($inv_total_no_tax + $total_tax + $val_tax2) * $ds) / 100);
				} else {
					$val_discount = $ds;
				}
				
			} elseif(DISCOUNT_OPTION != 1) {
				$val_discount = $total_ds;
				$inv_discount = 0;
			}
			
			$gTotal = $inv_total_no_tax + $total_tax + $val_tax2 - $val_discount;
			
			$saleDetails = array('reference_no' => $reference_no,
					'date' => $date,
					'biller_id' => $biller_id,
					'biller_name' => $biller_name,
					'customer_id' => $customer_id,
					'customer_name' => $customer_name,
					'note' => $note,
					'internal_note' => $internal_note,
					'inv_total' => $inv_total_no_tax,
					'total_tax' => $total_tax,
					'total' => $gTotal,
					'total_tax2' => $val_tax2,
					'tax_rate2_id' => $tax_rate2,
					'inv_discount' => $val_discount,
					'discount_id' => $inv_discount,
					'user'	=> USER_NAME,
					'shipping' => $shipping
				);
				
		}
		
		
		if ( $this->form_validation->run() == true && !empty($items) )
		{ 
			if($this->sales_model->addSale($saleDetails, $items, $warehouse_id)) {		
				$this->session->set_flashdata('success_message', $this->lang->line("sale_added"));
				redirect("module=sales", 'refresh');
			}
			
		}
		else
		{  
		
			$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			
			$data['date'] = array('name' => 'date',
				'id' => 'date',
				'type' => 'text',
				'value' => $this->form_validation->set_value('date'),
			);
			$data['biller'] = array('name' => 'biller',
				'id' => 'biller',
				'type' => 'select',
				'value' => $this->form_validation->set_select('biller'),
			);
			$data['customer'] = array('name' => 'customer',
				'id' => 'customer',
				'type' => 'select',
				'value' => $this->form_validation->set_select('customer'),
			);
			$data['note'] = array('name' => 'note',
				'id' => 'note',
				'type' => 'textarea',
				'value' => $this->form_validation->set_value('note'),
			);
			
		
	   $data['billers'] = $this->sales_model->getAllBillers();
	   $data['customers'] = $this->sales_model->getAllCustomers();
	   $data['warehouses'] = $this->sales_model->getAllWarehouses();
	   $data['products'] = $this->sales_model->getAllProducts();
	   $data['tax_rates'] = $this->sales_model->getAllTaxRates();
	   $data['discounts'] = $this->sales_model->getAllDiscounts();
	   $data['rnumber'] = $this->sales_model->getNextAI();
	   if(DISCOUNT_OPTION == 1) { 
			$discount_details = $this->sales_model->getDiscountByID(DEFAULT_DISCOUNT);
			
	  		$data['discount_rate'] = $discount_details->discount;
 			$data['discount_type'] = $discount_details->type;
			$data['discount_name'] = $discount_details->name;
	  } 
	  if(DISCOUNT_OPTION == 2) { 
			$discount2_details = $this->sales_model->getDiscountByID(DEFAULT_DISCOUNT);
	  		$data['discount_rate2'] = $discount2_details->discount;
 			$data['discount_type2'] = $discount2_details->type;
	  } 
	  if(TAX1) {
	  $tax_rate_details = $this->sales_model->getTaxRateByID(DEFAULT_TAX);
	  $data['tax_rate'] = $tax_rate_details->rate;

 		$data['tax_type'] = $tax_rate_details->type;
		$data['tax_name'] = $tax_rate_details->name;
	   	
	  }
	  if(TAX2) {
		$tax_rate2_details = $this->sales_model->getTaxRateByID(DEFAULT_TAX2);
	  	$data['tax_rate2'] = $tax_rate2_details->rate;
		$data['tax_name2'] = $tax_rate2_details->name;
 		$data['tax_type2'] = $tax_rate2_details->type;
	  }
	   
      $meta['page_title'] = $this->lang->line("add_sale");
	  $data['page_title'] = $this->lang->line("add_sale");
      $this->load->view('commons/header', $meta);
      $this->load->view('add', $data);
      $this->load->view('commons/footer');
	  
		}
   }


/* -------------------------------------------------------------------------------------------------------------------------------- */ 
//Edit inventory

   function edit()
   {
	   if($this->input->get('id')) { $id = $this->input->get('id'); } else { $id = NULL; }
	   
	   $groups = array('purchaser', 'viewer');
		if ($this->ion_auth->in_group($groups))
		{
			$this->session->set_flashdata('message', $this->lang->line("access_denied"));
			$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			redirect('module=sales', 'refresh');
		}
		
		$this->form_validation->set_message('is_natural_no_zero', $this->lang->line("no_zero_required"));
		//validate form input
		$this->form_validation->set_rules('reference_no', $this->lang->line("reference_no"), 'required|xss_clean');
		$this->form_validation->set_rules('date', $this->lang->line("date"), 'required|xss_clean');
		$this->form_validation->set_rules('biller', $this->lang->line("biller"), 'required|is_natural_no_zero|xss_clean');
		$this->form_validation->set_rules('customer', $this->lang->line("customer"), 'required|is_natural_no_zero|xss_clean');
		$this->form_validation->set_rules('note', $this->lang->line("note"), 'xss_clean');
		$this->form_validation->set_rules('shipping', $this->lang->line("shipping"), 'xss_clean');
		if(TAX2) { $this->form_validation->set_rules('tax2', $this->lang->line("tax2"), 'required|is_natural_no_zero|xss_clean'); }
		if(DISCOUNT_OPTION == 1) { $this->form_validation->set_rules('inv_discount', $this->lang->line("discount"), 'required|is_natural_no_zero|xss_clean'); }

		$quantity = "quantity";
		$product = "product";
		$unit_price = "unit_price";
		$tax_rate = "tax_rate";
		$sl = "serial";
		$dis = "discount";
			
		if ($this->form_validation->run() == true)
		{
			$date = $this->ion_auth->fsd(trim($this->input->post('date')));
			$reference_no = $this->input->post('reference_no');
			$warehouse_id = $this->input->post('warehouse');
			$biller_id = $this->input->post('biller');
			$biller_details = $this->sales_model->getBillerByID($biller_id);
			$biller_name = $biller_details->name;
			$customer_id = $this->input->post('customer');
			$customer_details = $this->sales_model->getCustomerByID($customer_id);
			$customer_name = $customer_details->name;
			if(DISCOUNT_OPTION == 1) { $inv_discount = $this->input->post('inv_discount'); }
			if(TAX2) {  $tax_rate2 = $this->input->post('tax2'); }
			$note = $this->ion_auth->clear_tags($this->input->post('note'));
			$internal_note = $this->ion_auth->clear_tags($this->input->post('internal_note'));
			$in_voice = $this->sales_model->getInvoiceByID($id); 
			$warehouse_id = $in_voice->warehouse_id;
			$shipping = $this->input->post('shipping');
			
			$inv_total_no_tax = 0;

				for($i=1; $i<=500; $i++){
					if( $this->input->post($quantity.$i) && $this->input->post($product.$i) && $this->input->post($unit_price.$i) ) {
					
                                            $product_details = $this->sales_model->getProductByCode($this->input->post($product.$i));
                                          /*  if(RESTRICT_SALE) {	
                                                $pr_ck = $this->sales_model->getWarehouseProductQuantity($warehouse_id, $product_details->id);
                                                    if($pr_ck->quantity < $this->input->post($quantity.$i) && $product_details->track_quantity == 1) {
                                                            $this->session->set_flashdata('message', $this->lang->line("wh_qty_less_then_sale")." (".$product_details->name.")");
                                                            redirect("module=sales&view=add", 'refresh');
                                                    }
                                            }*/
					
						if(TAX1) { 
							$tax_id = $this->input->post($tax_rate.$i);
							$tax_details = $this->sales_model->getTaxRateByID($tax_id);
							$taxRate = $tax_details->rate;
							$taxType = $tax_details->type;	
							$tax_rate_id[] = $tax_id;	
							
							if($taxType == 1 && $taxRate != 0) {
							$item_tax = (($this->input->post($quantity.$i)) * ($this->input->post($unit_price.$i)) * $taxRate / 100);
							$val_tax[] = $item_tax;
							} else {
							$item_tax = $taxRate;	
							$val_tax[] = $item_tax;
							}
							
							if($taxType == 1) { $tax[] = $taxRate."%"; } else { $tax[] = $taxRate;  }			
						} else {
							$item_tax = 0;
							$tax_rate_id[] = 0;
							$val_tax[] = 0;
							$tax[] = "";
						}
						
						if(DISCOUNT_METHOD == 1 && DISCOUNT_OPTION == 2) {
						
							$discount_id = $this->input->post($dis.$i);
							$ds_details = $this->sales_model->getDiscountByID($discount_id);
							$ds = $ds_details->discount;
							$dsType = $ds_details->type;	
							$dsID[] = $discount_id;	
							
							if($dsType == 1 && $ds != 0) {
							$val_ds[] = (($this->input->post($quantity.$i)) * ($this->input->post($unit_price.$i)) * $ds / 100);
							} else {
							$val_ds[] = $ds * ($this->input->post($quantity.$i));
							}
							
							if($dsType == 1) { $discount[] = $ds."%"; } else { $discount[] = $ds;  }	
						
						} elseif(DISCOUNT_METHOD == 2 && DISCOUNT_OPTION == 2) {
						
							$discount_id = $this->input->post($dis.$i);
							$ds_details = $this->sales_model->getDiscountByID($discount_id);
							$ds = $ds_details->discount;
							$dsType = $ds_details->type;	
							$dsID[] = $discount_id;	
							
							if($dsType == 1 && $ds != 0) {
							$val_ds[] = (((($this->input->post($quantity.$i)) * ($this->input->post($unit_price.$i)) + $item_tax) * $ds) / 100);
							} else {
							$val_ds[] = $ds * ($this->input->post($quantity.$i));
							}
							
							if($dsType == 1) { $discount[] = $ds."%"; } else { $discount[] = $ds;  }	
						
						} else {
							$val_ds[] = 0;
							$dsID[] = 0;
							$discount[] = "";
							
						}
						if(PRODUCT_SERIAL) { $serial[] = $this->input->post($sl.$i); } else { $serial[] = ""; }
						$inv_quantity[] = $this->input->post($quantity.$i);
						//$inv_product_code[] = $this->input->post($product.$i);
						$product_id[] = $product_details->id;
						$product_name[] = $product_details->name;
						$product_code[] = $product_details->code;
						$product_unit[] = $product_details->unit;
						$inv_unit_price[] = $this->input->post($unit_price.$i);
						$inv_gross_total[] = (($this->input->post($quantity.$i)) * ($this->input->post($unit_price.$i)));
						
						$inv_total_no_tax += (($this->input->post($quantity.$i)) * ($this->input->post($unit_price.$i)));
						
					}
				}
			
			
			if(DISCOUNT_OPTION == 2) {
				$total_ds = array_sum($val_ds);
			} else {
				$total_ds = 0;
			}
			
			
			if(TAX1) {
				$total_tax = array_sum($val_tax);
			} else {
				$total_tax = 0;
			}
			
			
			/*if(!empty($inv_product_code)) {	 
				foreach($inv_product_code as $pr_code){
					$product_details = $this->sales_model->getProductByCode($pr_code);
					$product_id[] = $product_details->id;
					$product_name[] = $product_details->name;
					$product_code[] = $product_details->code;
					$product_unit[] = $product_details->unit;
				}
			}*/
		
			$keys = array("product_id","product_code","product_name","product_unit", "tax_rate_id", "tax","quantity","unit_price", "gross_total", "val_tax", "serial_no", "discount_val", "discount", "discount_id");
		
			$items = array();
			foreach ( array_map(null, $product_id, $product_code, $product_name, $product_unit, $tax_rate_id, $tax, $inv_quantity, $inv_unit_price, $inv_gross_total, $val_tax, $serial, $val_ds, $discount, $dsID) as $key => $value ) {
				$items[] = array_combine($keys, $value);
			}
			
			if(TAX2) {
				$tax_dts = $this->sales_model->getTaxRateByID($tax_rate2);
				$taxRt = $tax_dts->rate;
				$taxTp = $tax_dts->type;	
					
				if($taxTp == 1 && $taxRt != 0) {
					$val_tax2 = ($inv_total_no_tax * $taxRt / 100);
				} else {
					$val_tax2 = $taxRt;
				}
				
			} else {
				$val_tax2 = 0;
				$tax_rate2 = 0;
			}
			
			if(DISCOUNT_METHOD == 1 && DISCOUNT_OPTION == 1) {
				
				$ds_dts = $this->sales_model->getDiscountByID($inv_discount);
				$ds = $ds_dts->discount;
				$dsTp = $ds_dts->type;	
					
				if($dsTp == 1 && $ds != 0) {
					$val_discount = ($inv_total_no_tax * $ds / 100);
				} else {
					$val_discount = $ds;
				}
			
			} elseif(DISCOUNT_METHOD == 2 && DISCOUNT_OPTION == 1) {
				
				$ds_dts = $this->sales_model->getDiscountByID($inv_discount);
				$ds = $ds_dts->discount;
				$dsTp = $ds_dts->type;	
					
				if($dsTp == 1 && $ds != 0) {
					$val_discount = ((($inv_total_no_tax + $total_tax + $val_tax2) * $ds) / 100);
				} else {
					$val_discount = $ds;
				}
				
			} else {
				$val_discount = $total_ds;
				$inv_discount = 0;
			}
			
			$gTotal = $inv_total_no_tax + $total_tax + $val_tax2 - $val_discount;
			
			$saleDetails = array('reference_no' => $reference_no,
					'date' => $date,
					'biller_id' => $biller_id,
					'biller_name' => $biller_name,
					'customer_id' => $customer_id,
					'customer_name' => $customer_name,
					'note' => $note,
					'internal_note' => $internal_note,
					'inv_total' => $inv_total_no_tax,
					'total_tax' => $total_tax,
					'total' => $gTotal,
					'total_tax2' => $val_tax2,
					'tax_rate2_id' => $tax_rate2,
					'inv_discount' => $val_discount,
					'discount_id' => $inv_discount,
					'user'	=> USER_NAME,
					'shipping' => $shipping
				);
		}
		
		
		if ( $this->form_validation->run() == true && !empty($items)  )
		{ 
			if($this->sales_model->updateSale($id, $saleDetails, $items, $warehouse_id)) {		
				$this->session->set_flashdata('success_message', $this->lang->line("sale_updated"));
				redirect("module=sales", 'refresh');
			}
			
		}
		else
		{ //display the create biller form
			//set the flash data error message if there is one
		
		$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
				
	  $data['billers'] = $this->sales_model->getAllBillers();
	  $data['customers'] = $this->sales_model->getAllCustomers();
	  if(DISCOUNT_OPTION == 1) { 
			$discount_details = $this->sales_model->getDiscountByID(DEFAULT_DISCOUNT);
			
	  		$data['discount_rate'] = $discount_details->discount;
 			$data['discount_type'] = $discount_details->type;
			$data['discount_name'] = $discount_details->name;
	  } 
	  if(DISCOUNT_OPTION == 2) { 
			$discount2_details = $this->sales_model->getDiscountByID(DEFAULT_DISCOUNT);
	  		$data['discount_rate2'] = $discount2_details->discount;
 			$data['discount_type2'] = $discount2_details->type;
	  } 
	  if(TAX1) {
	  $tax_rate_details = $this->sales_model->getTaxRateByID(DEFAULT_TAX);
	  $data['tax_rate'] = $tax_rate_details->rate;

 		$data['tax_type'] = $tax_rate_details->type;
		$data['tax_name'] = $tax_rate_details->name;
	   	
	  }
	  if(TAX2) {
		$tax_rate2_details = $this->sales_model->getTaxRateByID(DEFAULT_TAX2);
	  	$data['tax_rate2'] = $tax_rate2_details->rate;
		$data['tax_name2'] = $tax_rate2_details->name;
 		$data['tax_type2'] = $tax_rate2_details->type;
	  }
		  $data['tax_rates'] = $this->sales_model->getAllTaxRates();
		  $data['discounts'] = $this->sales_model->getAllDiscounts();				  
		  $data['inv'] = $this->sales_model->getInvoiceByID($id);
		  $data['inv_products'] =  $this->sales_model->getAllInvoiceItems($id);
		  $data['id'] = $id;
		  $meta['page_title'] = $this->lang->line("update_sale");
		  $data['page_title'] = $this->lang->line("update_sale");
		
      $this->load->view('commons/header', $meta);
      $this->load->view('edit', $data);
      $this->load->view('commons/footer');
	  
	  }
   }   
/*-------------------------------*/
function delete($id = NULL)
    {
		if (DEMO) {
			$this->session->set_flashdata('message', $this->lang->line("disabled_in_demo"));
			redirect('module=home', 'refresh');
		}
		
		$groups = array('admin', 'purchaser', 'salesman', 'viewer');
        if ($this->ion_auth->in_group($groups))
        {
            $this->session->set_flashdata('message', $this->lang->line("access_denied"));
            $data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
            redirect('module=sales', 'refresh');
        }
		
        if($this->input->get('id')){ $id = $this->input->get('id'); } else { $id = NULL; }
		

			if ( $this->sales_model->deleteInvoice($id) )
			{ 
				$this->session->set_flashdata('message', $this->lang->line("invoice_deleted"));
				redirect('module=sales', 'refresh');
			} 

       
    }   
/* -------------------------------------------------------------------------------------------------------------------------------- */

function quote_to_invoice()
    {
        if($this->input->get('quote_id')){ $quote_id = $this->input->get('quote_id'); } else { $quote_id = NULL; }
	   $groups = array('purchaser', 'viewer');
		if ($this->ion_auth->in_group($groups))
		{
			$this->session->set_flashdata('message', $this->lang->line("access_denied"));
			$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			redirect('module=sales', 'refresh');
		}
		
			
   		$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
				
		  $data['billers'] = $this->sales_model->getAllBillers();
		  $data['customers'] = $this->sales_model->getAllCustomers();
		  $data['warehouses'] = $this->sales_model->getAllWarehouses();
		  $data['tax_rates'] = $this->sales_model->getAllTaxRates();
		  $data['discounts'] = $this->sales_model->getAllDiscounts();		

		  $data['inv'] = $this->sales_model->getQuoteByID($quote_id);
		  $data['inv_products'] =  $this->sales_model->getAllQuoteItems($quote_id);
	  	  $data['invoice_types'] = $this->sales_model->getAllInvoiceTypesFor();
		  $data['id'] = NULL;
		  $data['quote_id'] = $quote_id;
		  $meta['page_title'] = $this->lang->line("add_invoice_from_quote");
		  $data['page_title'] = $this->lang->line("add_invoice_from_quote");
		$data['rnumber'] = $this->sales_model->getNextAI();
		
      $this->load->view('commons/header', $meta);
      $this->load->view('quote2invoice', $data);
      $this->load->view('commons/footer');
		  				
		
    }  
	
	/* --------------------------------------------------------------------------------*/
	function deliveries()
   {
	  
		if ($this->ion_auth->in_group('purchaser'))
		{
			$this->session->set_flashdata('message', $this->lang->line("access_denied"));
			$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			redirect('module=home', 'refresh');
		}
				
	   $data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
	   $data['success_message'] = $this->session->flashdata('success_message');

      $meta['page_title'] = $this->lang->line("deliveries");
	  $data['page_title'] = $this->lang->line("deliveries");
      $this->load->view('commons/header', $meta);
      $this->load->view('deliveries', $data);
      $this->load->view('commons/footer');
   }
   
   function getdeliveries()
   {
		
	   $this->load->library('datatables');
	   $this->datatables
			->select("id, date, time, reference_no, customer, address")
			->from('deliveries');
			$this->datatables->add_column("Actions", 
			"<center><a href='#' onClick=\"MyWindow=window.open('index.php?module=sales&view=view_delivery&id=$1', 'MyWindow','toolbar=0,location=0,directories=0,status=0,menubar=yes,scrollbars=yes,resizable=yes,width=1000,height=600'); return false;\" title='".$this->lang->line("view_delivery")."' class='tip'><i class='icon-fullscreen'></i></a> 
			<a href='index.php?module=sales&amp;view=edit_delivery&amp;id=$1' title='".$this->lang->line("edit_delivery")."' class='tip'><i class='icon-edit'></i></a>
			<a href='index.php?module=sales&amp;view=delete_delivery&amp;id=$1' onClick=\"return confirm('". $this->lang->line('alert_x_delivery') ."')\" title='".$this->lang->line("delete_delivery")."' class='tip'><i class='icon-trash'></i></a></center>", "id")
		
		->unset_column('id');
		
	   echo $this->datatables->generate();

   }
   
   function view_delivery()
   {
	   if($this->input->get('id')){ $id = $this->input->get('id'); } else { $id = NULL; }
	   
	  $data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));

	  $data['delivery'] =  $this->sales_model->getDeliveryByID($id);

	  $data['page_title'] = $this->lang->line("delivery_details");
	
      $this->load->view('view_delivery', $data);

   }
   
	function add_delivery()
   {
	   if($this->input->get('id')){ $id = $this->input->get('id'); } else { $id = NULL; }
	   
	   $groups = array('purchaser', 'viewer');
		if ($this->ion_auth->in_group($groups))
		{
			$this->session->set_flashdata('message', $this->lang->line("access_denied"));
			$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			redirect('module=sales', 'refresh');
		}
		
		//validate form input
		$this->form_validation->set_rules('reference_no', $this->lang->line("reference_no"), 'required|xss_clean');
		$this->form_validation->set_rules('date', $this->lang->line("date"), 'required|xss_clean');
		$this->form_validation->set_rules('time', $this->lang->line("time"), 'required|xss_clean');
		$this->form_validation->set_rules('customer', $this->lang->line("customer"), 'required|xss_clean');
		$this->form_validation->set_rules('address', $this->lang->line("address"), 'required|xss_clean');
		$this->form_validation->set_rules('note', $this->lang->line("note"), 'xss_clean');
			
		if ($this->form_validation->run() == true)
		{
			$date = $this->ion_auth->fsd(trim($this->input->post('date')));
			$dlDetails = array(
					'date' => $date,
					'time' => $this->input->post('time'),
					'reference_no' => $this->input->post('reference_no'),
					'customer' => $this->input->post('customer'),
					'address' => $this->input->post('address'),
					'note' => $this->ion_auth->clear_tags($this->input->post('note')),
					'user'	=> USER_NAME
			);
			
			
		}
		
		
		if ( $this->form_validation->run() == true && $this->sales_model->addDelivery($dlDetails) )
		{ 
				$this->session->set_flashdata('success_message', $this->lang->line("delivery_added"));
				redirect("module=sales&view=deliveries", 'refresh');
			
		}
		else
		{  
		
			$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			
	  $sale = $this->sales_model->getInvoiceByID($id);
	  $data['customer'] =  $this->sales_model->getCustomerByID($sale->customer_id);
	  $data['inv'] = $sale;
      $meta['page_title'] = $this->lang->line("add_delivery_order");
	  $data['page_title'] = $this->lang->line("add_delivery_order");
      $this->load->view('commons/header', $meta);
      $this->load->view('add_delivery', $data);
      $this->load->view('commons/footer');
	  
		}
   }
   
   function edit_delivery()
   {
	   if($this->input->get('id')){ $id = $this->input->get('id'); } else { $id = NULL; }
	   
	   $groups = array('purchaser', 'viewer');
		if ($this->ion_auth->in_group($groups))
		{
			$this->session->set_flashdata('message', $this->lang->line("access_denied"));
			$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			redirect('module=sales', 'refresh');
		}
		
		//validate form input
		$this->form_validation->set_rules('reference_no', $this->lang->line("reference_no"), 'required|xss_clean');
		$this->form_validation->set_rules('date', $this->lang->line("date"), 'required|xss_clean');
		$this->form_validation->set_rules('time', $this->lang->line("time"), 'required|xss_clean');
		$this->form_validation->set_rules('customer', $this->lang->line("customer"), 'required|xss_clean');
		$this->form_validation->set_rules('address', $this->lang->line("address"), 'required|xss_clean');
		$this->form_validation->set_rules('note', $this->lang->line("note"), 'xss_clean');
			
		if ($this->form_validation->run() == true)
		{
			$date = $this->ion_auth->fsd(trim($this->input->post('date')));
			$dlDetails = array(
					'date' => $date,
					'time' => $this->input->post('time'),
					'reference_no' => $this->input->post('reference_no'),
					'customer' => $this->input->post('customer'),
					'address' => $this->input->post('address'),
					'note' => $this->ion_auth->clear_tags($this->input->post('note')),
					'updated_by'	=> USER_NAME
			);
			
			
		}
		
		
		if ( $this->form_validation->run() == true && $this->sales_model->updateDelivery($id, $dlDetails) )
		{ 
				$this->session->set_flashdata('success_message', $this->lang->line("delivery_updated"));
				redirect("module=sales&view=deliveries", 'refresh');
			
		}
		else
		{  
		
			$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			

	  $data['delivery'] =  $this->sales_model->getDeliveryByID($id);
	  $data['id'] = $id;
      $meta['page_title'] = $this->lang->line("edit_delivery");
	  $data['page_title'] = $this->lang->line("edit_delivery");
      $this->load->view('commons/header', $meta);
      $this->load->view('edit_delivery', $data);
      $this->load->view('commons/footer');
	  
		}
   }
   
   function delete_delivery($id = NULL)
    {
		if (DEMO) {
			$this->session->set_flashdata('message', $this->lang->line("disabled_in_demo"));
			redirect('module=home', 'refresh');
		}
		
		$groups = array('admin', 'purchaser', 'salesman', 'viewer');
        if ($this->ion_auth->in_group($groups))
        {
            $this->session->set_flashdata('message', $this->lang->line("access_denied"));
            $data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
            redirect('module=sales', 'refresh');
        }
		
        if($this->input->get('id')){ $id = $this->input->get('id'); } else { $id = NULL; }
		

			if ( $this->sales_model->deleteDelivery($id) )
			{ 
				$this->session->set_flashdata('success_message', $this->lang->line("delivery_deleted"));
				redirect('module=sales&view=deliveries', 'refresh');
			} 

       
    } 
	
	/* --------------------------------------------------------------------------------*/ 
	
	function scan_item()
   {
	   if($this->input->get('code')) { $code = $this->input->get('code'); }
	   
	   if($item = $this->sales_model->getProductByCode($code)) {
	   		
			$product_name = $item->name;
			$product_price = $item->price;
			$product_tax = $item->tax_rate;
			
			$tax_rate = $this->sales_model->getTaxRateByID($product_tax);
			
			$product = array('name' => $product_name, 'price' => $product_price, 'tax_rate' => $tax_rate);	
		
	   }
	   
	  echo json_encode($product);

   }
  
    function add_item()
   {
	   if($this->input->get('name')) { $name = $this->input->get('name'); }
	   
	   if($item = $this->sales_model->getProductByName($name)) {
	   		
			$code = $item->code;
			$price = $item->price;
			$product_tax = $item->tax_rate;
			
			$tax_rate = $this->sales_model->getTaxRateByID($product_tax);
			
			$product = array('code' => $code, 'price' => $price, 'tax_rate' => $tax_rate);	
		
	   }
	   
	  echo json_encode($product);

   }
   
   function suggestions()
	{
		$term = $this->input->get('term',TRUE);
	
                if (strlen($term) < 2) { die(); }
	
		$rows = $this->sales_model->getProductNames($term);
	
		$json_array = array();
		foreach ($rows as $row)
			 array_push($json_array, $row->name);
	
		echo json_encode($json_array); 
	}
	
	function tax_rates()
   {
	   if($this->input->get('id')) { $id = $this->input->get('id'); }
	   if($this->input->get('old_id')) { $old_id = $this->input->get('old_id'); } else { $old_id = NULL; }
	   $new_tax_rate_details = $this->sales_model->getTaxRateByID($id);
	   
	   if($old_id) {
		   $old_tax_rate_details = $this->sales_model->getTaxRateByID($old_id);
		   
		   $tax = array('old_tax_rate' => $old_tax_rate_details->rate, 
						'old_tax_type' => $old_tax_rate_details->type,
						'new_tax_rate' => $new_tax_rate_details->rate, 
						'new_tax_type' => $new_tax_rate_details->type);	
	   } else { 
	   		$tax = array('new_tax_rate' => $new_tax_rate_details->rate, 
						'new_tax_type' => $new_tax_rate_details->type);
	   }
	  echo json_encode($tax);

   }
   
   function discounts()
   {
	   if($this->input->get('id')) { $id = $this->input->get('id'); }
	   if($this->input->get('old_id')) { $old_id = $this->input->get('old_id'); } else { $old_id = NULL; }
	   $new_discount_details = $this->sales_model->getDiscountByID($id);
	   
	   if($old_id) {
		   $old_discount_details = $this->sales_model->getDiscountByID($old_id);
		   
		   $ds = array('old_discount' => $old_discount_details->discount, 
						'old_discount_type' => $old_discount_details->type,
						'new_discount' => $new_discount_details->discount, 
						'new_discount_type' => $new_discount_details->type);	
	   } else { 
	   		$ds = array('new_discount' => $new_discount_details->discount, 
						'new_discount_type' => $new_discount_details->type);
	   }
	  echo json_encode($ds);

   }
   
   function codeSuggestions()
	{
		$term = $this->input->get('term',TRUE);
	
		if (strlen($term) < 2) die();
	
		$rows = $this->sales_model->getProductCodes($term);
	
		$json_array = array();
		foreach ($rows as $row)
			 array_push($json_array, $row->code);
	
		echo json_encode($json_array); 
	}
	
}