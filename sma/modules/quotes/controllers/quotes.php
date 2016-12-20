<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Quotes extends MX_Controller {
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
      | MODULE: 			Quotes
      | -----------------------------------------------------
      | This is quotes module controller file.
      | -----------------------------------------------------
     */

    function __construct() {
        parent::__construct();

        // check if user logged in 
        if (!$this->ion_auth->logged_in()) {
            redirect('module=auth&view=login');
        }
        $this->load->library('form_validation');
        $this->load->model('quotes_model');
    }

    /* -------------------------------------------------------------------------------------------------------------------------------- */

//index or inventories page


    function index() {

        if ($this->ion_auth->in_group('purchaser')) {
            $this->session->set_flashdata('message', $this->lang->line("access_denied"));
            $data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
            redirect('module=home', 'refresh');
        }

        $data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
        $data['success_message'] = $this->session->flashdata('success_message');

        $data['warehouses'] = $this->quotes_model->getAllWarehouses();
        $meta['page_title'] = $this->lang->line("quotes");
        $data['page_title'] = $this->lang->line("quotes");
        $this->load->view('commons/header', $meta);
        $this->load->view('quotes', $data);
        $this->load->view('commons/footer');
    }

    function getquotes() {

        $this->load->library('datatables');
        $this->datatables
                ->select("id, date, reference_no, biller_name, customer_name, total, internal_note")
                ->from('quotes')
                ->add_column("Actions", "<center><a href='#' title='$2' class='tip' data-html='true'><i class='icon-folder-close'></i></a> <a href='#' onClick=\"MyWindow=window.open('index.php?module=quotes&view=view_quote&id=$1', 'MyWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=1000,height=600'); return false;\" title='" . $this->lang->line("view_quote") . "' class='tip'><i class='icon-fullscreen'></i></a> 
								<a href='index.php?module=sales&view=quote_to_invoice&quote_id=$1' title='" . $this->lang->line("convert_to_invoice") . "' class='tip'><i class='icon-random'></i></a> 
								<a href='index.php?module=quotes&view=pdf&id=$1' title='" . $this->lang->line("download_pdf") . "' class='tip'><i class='icon-file'></i></a> 
								
								<a href='index.php?module=quotes&view=email_quote&id=$1' title='" . $this->lang->line("email_quote") . "' class='tip'><i class='icon-envelope'></i></a>
								<a href='index.php?module=quotes&amp;view=edit&amp;id=$1' title='" . $this->lang->line("edit_quote") . "' class='tip'><i class='icon-edit'></i></a>
							    <a href='index.php?module=quotes&amp;view=delete&amp;id=$1' onClick=\"return confirm('" . $this->lang->line('alert_x_quote') . "')\" title='" . $this->lang->line("delete_quote") . "' class='tip'><i class='icon-trash'></i></a></center>", "id, internal_note")
                ->unset_column('id')
                ->unset_column('internal_note');


        echo $this->datatables->generate();
    }

    /* -------------------------------------------------------------------------------------------------------------------------------- */

//view inventory as html page

    function view_quote() {
        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        } else {
            $id = NULL;
        }

        $data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));

        $data['rows'] = $this->quotes_model->getAllQuoteItemsWithDetails($id);

        $inv = $this->quotes_model->getQuoteByID($id);
        $biller_id = $inv->biller_id;
        $customer_id = $inv->customer_id;
        $invoice_type_id = $inv->invoice_type;
        $data['biller'] = $this->quotes_model->getBillerByID($biller_id);
        $data['customer'] = $this->quotes_model->getCustomerByID($customer_id);

        $data['inv'] = $inv;
        $data['id'] = $id;

        $data['page_title'] = $this->lang->line("quote");

        $this->load->view('view_quote', $data);
    }

    /* -------------------------------------------------------------------------------------------------------------------------------- */

//generate pdf and force to download  

    function pdf() {
        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        } else {
            $id = NULL;
        }

        $data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
        $data['rows'] = $this->quotes_model->getAllQuoteItemsWithDetails($id);

        $inv = $this->quotes_model->getQuoteByID($id);
        $biller_id = $inv->biller_id;
        $customer_id = $inv->customer_id;
        $invoice_type_id = $inv->invoice_type;
        $data['biller'] = $this->quotes_model->getBillerByID($biller_id);
        $data['customer'] = $this->quotes_model->getCustomerByID($customer_id);

        $data['inv'] = $inv;
        $data['id'] = $id;

        $data['page_title'] = $this->lang->line("quote");

        $html = $this->load->view('view_quote', $data, TRUE);

        $this->load->library('MPDF/mpdf');

        $mpdf = new mPDF('utf-8', 'A4', '12', '', 10, 10, 10, 10, 9, 9);
        $mpdf->useOnlyCoreFonts = true;
        $mpdf->SetProtection(array('print'));
        $mpdf->SetTitle(SITE_NAME);
        $mpdf->SetAuthor(SITE_NAME);
        $mpdf->SetCreator(SITE_NAME);
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetAutoFont();
        $stylesheet = file_get_contents('assets/css/bootstrap-'.THEME.'.css');
        $mpdf->WriteHTML($stylesheet,1);
        $name = $this->lang->line("quote") . " " . $this->lang->line("no") . " " . $inv->id . ".pdf";

        $search = array("<div class=\"row-fluid\">", "<div class=\"span6\">", "<div class=\"span5\">", "<div class=\"span5 offset2\">");
        $replace = array("<div style='width: 100%;'>", "<div style='width: 48%; float: left;'>", "<div style='width: 40%; float: left;'>", "<div style='width: 40%; float: right;'>");
        $html = str_replace($search, $replace, $html);
		
       $mpdf->WriteHTML($html);

       $mpdf->Output($name, 'D');
		exit;

    }

    /* -------------------------------------------------------------------------------------------------------------------------------- */

//email inventory as html and send pdf as attachment   

    function email($id = NULL, $to, $cc = NULL, $bcc = NULL, $from_name, $from, $subject, $note) {
        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        } 

        $data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
        $data['rows'] = $this->quotes_model->getAllQuoteItemsWithDetails($id);

        $inv = $this->quotes_model->getQuoteByID($id);
        $biller_id = $inv->biller_id;
        $customer_id = $inv->customer_id;
        $invoice_type_id = $inv->invoice_type;
        $data['biller'] = $this->quotes_model->getBillerByID($biller_id);
        $data['customer'] = $this->quotes_model->getCustomerByID($customer_id);

        $data['inv'] = $inv;
        $data['id'] = $id;

        $data['page_title'] = $this->lang->line("quote");

        $html = $this->load->view('view_quote', $data, TRUE);

        $this->load->library('MPDF/mpdf');

        $mpdf = new mPDF('utf-8', 'A4', '12', '', 10, 10, 10, 10, 9, 9);
        $mpdf->useOnlyCoreFonts = true;
        $mpdf->SetProtection(array('print'));
        $mpdf->SetTitle(SITE_NAME);
        $mpdf->SetAuthor(SITE_NAME);
        $mpdf->SetCreator(SITE_NAME);
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetAutoFont();
        $stylesheet = file_get_contents('assets/css/bootstrap-'.THEME.'.css');
        $mpdf->WriteHTML($stylesheet,1);
        $name = $this->lang->line("quote") . " " . $this->lang->line("no") . " " . $inv->id . ".pdf";

        $search = array("<div class=\"row-fluid\">", "<div class=\"span6\">", "<div class=\"span5\">", "<div class=\"span5 offset2\">");
        $replace = array("<div style='width: 100%;'>", "<div style='width: 48%; float: left;'>", "<div style='width: 40%; float: left;'>", "<div style='width: 40%; float: right;'>");
        $html = str_replace($search, $replace, $html);

        $mpdf->WriteHTML($html);

        $mpdf->Output($name, 'F');

        if ($note) {
            $message = html_entity_decode($note) . "<br><hr>" . $html;
        } else {
            $message = $html;
        }

        $this->load->library('email');

        $config['mailtype'] = 'html';
        $config['wordwrap'] = TRUE;

        $this->email->initialize($config);

        $this->email->from($from, $from_name);
        $this->email->to($to);
        if ($cc) {
            $this->email->cc($cc);
        }
        if ($bcc) {
            $this->email->bcc($bcc);
        }

        $this->email->subject($subject);
        $this->email->message($message);
        $this->email->attach($name);

        if ($this->email->send()) {
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

    function email_quote() {
        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        } else {
            $id = NULL;
        }

        //validate form input
        $this->form_validation->set_rules('to', $this->lang->line("to") . " " . $this->lang->line("email"), 'trim|required|valid_email|xss_clean');
        $this->form_validation->set_rules('subject', $this->lang->line("subject"), 'trim|required|xss_clean');
        $this->form_validation->set_rules('cc', $this->lang->line("cc"), 'trim|xss_clean');
        $this->form_validation->set_rules('bcc', $this->lang->line("bcc"), 'trim|xss_clean');
        $this->form_validation->set_rules('note', $this->lang->line("message"), 'trim|xss_clean');

        if ($this->form_validation->run() == true) {
            $to = $this->input->post('to');
            $subject = $this->input->post('subject');
            if ($this->input->post('cc')) {
                $cc = $this->input->post('cc');
            } else {
                $cc = NULL;
            }
            if ($this->input->post('bcc')) {
                $bcc = $this->input->post('bcc');
            } else {
                $bcc = NULL;
            }
            $message = $this->ion_auth->clear_tags($this->input->post('note'));
            $user = $this->ion_auth->user()->row();
            $from_name = $user->first_name . " " . $user->last_name;
            $from = $user->email;
        }

        if ($this->form_validation->run() == true && $this->email($id, $to, $cc, $bcc, $from_name, $from, $subject, $message)) {
            $this->session->set_flashdata('success_message', $this->lang->line("sent"));
            redirect("module=quotes", 'refresh');
        } else {

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
            $data['from_name'] = $user->first_name . " " . $user->last_name;
            $data['from_email'] = $user->email;


            $inv = $this->quotes_model->getQuoteByID($id);
            $customer_id = $inv->customer_id;

            $data['cus'] = $this->quotes_model->getCustomerByID($customer_id);
            $data['id'] = $id;
            $data['quote_id'] = NULL;
            $meta['page_title'] = $this->lang->line("email") . " " . $this->lang->line("quote");
            $data['page_title'] = $this->lang->line("email") . " " . $this->lang->line("quote");


            $this->load->view('commons/header', $meta);
            $this->load->view('email', $data);
            $this->load->view('commons/footer');
        }
    }

    /* -------------------------------------------------------------------------------------------------------------------------------- */

//Add new quote

    function add() {
        $groups = array('purchaser', 'viewer');
        if ($this->ion_auth->in_group($groups)) {
            $this->session->set_flashdata('message', $this->lang->line("access_denied"));
            $data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
            redirect('module=quotes', 'refresh');
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
        if (TAX2) {
            $this->form_validation->set_rules('tax2', $this->lang->line("tax2"), 'required|is_natural_no_zero|xss_clean');
        }
        if (DISCOUNT_OPTION == 1) {
            $this->form_validation->set_rules('inv_discount', $this->lang->line("discount"), 'required|is_natural_no_zero|xss_clean');
        }

        $quantity = "quantity";
        $product = "product";
        $unit_price = "unit_price";
        $tax_rate = "tax_rate";
        $dis = "discount";

        if ($this->form_validation->run() == true) {
            $date = $this->ion_auth->fsd(trim($this->input->post('date')));
            $reference_no = $this->input->post('reference_no');
            $warehouse_id = $this->input->post('warehouse');
            $biller_id = $this->input->post('biller');
            $biller_details = $this->quotes_model->getBillerByID($biller_id);
            $biller_name = $biller_details->name;
            $customer_id = $this->input->post('customer');
            $customer_details = $this->quotes_model->getCustomerByID($customer_id);
            $customer_name = $customer_details->name;
            if (DISCOUNT_OPTION == 1) {
                $inv_discount = $this->input->post('inv_discount');
            }
            if (TAX2) {
                $tax_rate2 = $this->input->post('tax2');
            }
            $note = $this->ion_auth->clear_tags($this->input->post('note'));
            $internal_note = $this->ion_auth->clear_tags($this->input->post('internal_note'));
            $shipping = $this->input->post('shipping');

            $inv_total_no_tax = 0;

            for ($i = 1; $i <= 500; $i++) {
                if ($this->input->post($quantity . $i) && $this->input->post($product . $i) && $this->input->post($unit_price . $i)) {

                    $product_details = $this->quotes_model->getProductByCode($this->input->post($product . $i));
                    $pr_ck = $this->quotes_model->getWarehouseProductQuantity($warehouse_id, $product_details->id);
                    if (RESTRICT_SALE) {
                        if ($pr_ck->quantity < $this->input->post($quantity . $i) && $product_details->track_quantity == 1) {
                            $this->session->set_flashdata('message', $this->lang->line("wh_qty_less_then_quote") . " (" . $product_details->name . ")");
                            redirect("module=quotes&view=add", 'refresh');
                        }
                    }
                    if (TAX1) {
                        $tax_id = $this->input->post($tax_rate . $i);
                        $tax_details = $this->quotes_model->getTaxRateByID($tax_id);
                        $taxRate = $tax_details->rate;
                        $taxType = $tax_details->type;
                        $tax_rate_id[] = $tax_id;

                        if ($taxType == 1 && $taxRate != 0) {
                            $item_tax = (($this->input->post($quantity . $i)) * ($this->input->post($unit_price . $i)) * $taxRate / 100);
                            $val_tax[] = $item_tax;
                        } else {
                            $item_tax = $taxRate;
                            $val_tax[] = $item_tax;
                        }

                        if ($taxType == 1) {
                            $tax[] = $taxRate . "%";
                        } else {
                            $tax[] = $taxRate;
                        }
                    } else {
                        $tax_rate_id[] = 0;
                        $val_tax[] = 0;
                        $tax[] = "";
                    }

                    if (DISCOUNT_METHOD == 1 && DISCOUNT_OPTION == 2) {

                        $discount_id = $this->input->post($dis . $i);
                        $ds_details = $this->quotes_model->getDiscountByID($discount_id);
                        $ds = $ds_details->discount;
                        $dsType = $ds_details->type;
                        $dsID[] = $discount_id;

                        if ($dsType == 1) {
                            $val_ds[] = (($this->input->post($quantity . $i)) * ($this->input->post($unit_price . $i)) * $ds / 100);
                        } else {
                            $val_ds[] = $ds * ($this->input->post($quantity . $i));
                        }

                        if ($dsType == 1) {
                            $discount[] = $ds . "%";
                        } else {
                            $discount[] = $ds;
                        }
                    } elseif (DISCOUNT_METHOD == 2 && DISCOUNT_OPTION == 2) {

                        $discount_id = $this->input->post($dis . $i);
                        $ds_details = $this->quotes_model->getDiscountByID($discount_id);
                        $ds = $ds_details->discount;
                        $dsType = $ds_details->type;
                        $dsID[] = $discount_id;

                        if ($dsType == 1) {
                            $val_ds[] = (((($this->input->post($quantity . $i)) * ($this->input->post($unit_price . $i)) + $item_tax) * $ds) / 100);
                        } else {
                            $val_ds[] = $ds * ($this->input->post($quantity . $i));
                        }

                        if ($dsType == 1) {
                            $discount[] = $ds . "%";
                        } else {
                            $discount[] = $ds;
                        }
                    } else {
                        $val_ds[] = 0;
                        $dsID[] = 0;
                        $discount[] = "";
                    }
                    $inv_quantity[] = $this->input->post($quantity . $i);
                    //$inv_product_code[] = $this->input->post($product.$i);
                    $product_id[] = $product_details->id;
                    $product_name[] = $product_details->name;
                    $product_code[] = $product_details->code;
                    $product_unit[] = $product_details->unit;
                    $inv_unit_price[] = $this->input->post($unit_price . $i);
                    $inv_gross_total[] = (($this->input->post($quantity . $i)) * ($this->input->post($unit_price . $i)));

                    $inv_total_no_tax += (($this->input->post($quantity . $i)) * ($this->input->post($unit_price . $i)));
                }
            }


            if (DISCOUNT_OPTION == 2) {
                $total_ds = array_sum($val_ds);
            } else {
                $total_ds = 0;
            }


            if (TAX1) {
                $total_tax = array_sum($val_tax);
            } else {
                $total_tax = 0;
            }


            /* if(!empty($inv_product_code)) {	 
              foreach($inv_product_code as $pr_code){
              $product_details = $this->quotes_model->getProductByCode($pr_code);
              $product_id[] = $product_details->id;
              $product_name[] = $product_details->name;
              $product_code[] = $product_details->code;
              $product_unit[] = $product_details->unit;
              }
              } */

            $keys = array("product_id", "product_code", "product_name", "product_unit", "tax_rate_id", "tax", "quantity", "unit_price", "gross_total", "val_tax", "discount_val", "discount", "discount_id");

            $items = array();
            foreach (array_map(null, $product_id, $product_code, $product_name, $product_unit, $tax_rate_id, $tax, $inv_quantity, $inv_unit_price, $inv_gross_total, $val_tax, $val_ds, $discount, $dsID) as $key => $value) {
                $items[] = array_combine($keys, $value);
            }

            if (TAX2) {
                $tax_dts = $this->quotes_model->getTaxRateByID($tax_rate2);
                $taxRt = $tax_dts->rate;
                $taxTp = $tax_dts->type;

                if ($taxTp == 1 && $taxRt != 0) {
                    $val_tax2 = ($inv_total_no_tax * $taxRt / 100);
                } else {
                    $val_tax2 = $taxRt;
                }
            } else {
                $val_tax2 = 0;
                $tax_rate2 = 0;
            }

            if (DISCOUNT_METHOD == 1 && DISCOUNT_OPTION == 1) {

                $ds_dts = $this->quotes_model->getDiscountByID($inv_discount);
                $ds = $ds_dts->discount;
                $dsTp = $ds_dts->type;

                if ($dsTp == 1 && $dsTp != 0) {
                    $val_discount = ($inv_total_no_tax * $ds / 100);
                } else {
                    $val_discount = $ds;
                }
            } elseif (DISCOUNT_METHOD == 2 && DISCOUNT_OPTION == 1) {

                $ds_dts = $this->quotes_model->getDiscountByID($inv_discount);
                $ds = $ds_dts->discount;
                $dsTp = $ds_dts->type;

                if ($dsTp == 1 && $dsTp != 0) {
                    $val_discount = ((($inv_total_no_tax + $total_tax + $val_tax2) * $ds) / 100);
                } else {
                    $val_discount = $ds;
                }
            } else {
                $val_discount = $total_ds;
                $inv_discount = 0;
            }

            $gTotal = $inv_total_no_tax + $total_tax + $val_tax2 - $val_discount;

            $quoteDetails = array('reference_no' => $reference_no,
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
                'user' => USER_NAME,
                'shipping' => $shipping
            );
        }


        if ($this->form_validation->run() == true && !empty($items)) {
            if ($this->quotes_model->addQuote($quoteDetails, $items, $warehouse_id)) {
                $this->session->set_flashdata('success_message', $this->lang->line("quote_added"));
                redirect("module=quotes", 'refresh');
            }
        } else {
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



            $data['billers'] = $this->quotes_model->getAllBillers();
            $data['customers'] = $this->quotes_model->getAllCustomers();
            $data['warehouses'] = $this->quotes_model->getAllWarehouses();
            $data['products'] = $this->quotes_model->getAllProducts();
            $data['tax_rates'] = $this->quotes_model->getAllTaxRates();
            $data['discounts'] = $this->quotes_model->getAllDiscounts();
            $data['rnumber'] = $this->quotes_model->getNextAI();
            if (DISCOUNT_OPTION == 1) {
                $discount_details = $this->quotes_model->getDiscountByID(DEFAULT_DISCOUNT);

                $data['discount_rate'] = $discount_details->discount;
                $data['discount_type'] = $discount_details->type;
                $data['discount_name'] = $discount_details->name;
            }
            if (DISCOUNT_OPTION == 2) {
                $discount2_details = $this->quotes_model->getDiscountByID(DEFAULT_DISCOUNT);
                $data['discount_rate2'] = $discount2_details->discount;
                $data['discount_type2'] = $discount2_details->type;
            }
            if (TAX1) {
                $tax_rate_details = $this->quotes_model->getTaxRateByID(DEFAULT_TAX);
                $data['tax_rate'] = $tax_rate_details->rate;

                $data['tax_type'] = $tax_rate_details->type;
                $data['tax_name'] = $tax_rate_details->name;
            }
            if (TAX2) {
                $tax_rate2_details = $this->quotes_model->getTaxRateByID(DEFAULT_TAX2);
                $data['tax_rate2'] = $tax_rate2_details->rate;
                $data['tax_name2'] = $tax_rate2_details->name;
                $data['tax_type2'] = $tax_rate2_details->type;
            }

            $meta['page_title'] = $this->lang->line("add_quote");
            $data['page_title'] = $this->lang->line("add_quote");
            $this->load->view('commons/header', $meta);
            $this->load->view('add', $data);
            $this->load->view('commons/footer');
        }
    }

    /* -------------------------------------------------------------------------------------------------------------------------------- */

//Edit inventory

    function edit() {
        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        } else {
            $id = NULL;
        }

        $groups = array('purchaser', 'viewer');
        if ($this->ion_auth->in_group($groups)) {
            $this->session->set_flashdata('message', $this->lang->line("access_denied"));
            $data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
            redirect('module=quotes', 'refresh');
        }

        $this->form_validation->set_message('is_natural_no_zero', $this->lang->line("no_zero_required"));
        //validate form input
        $this->form_validation->set_rules('reference_no', $this->lang->line("reference_no"), 'required|xss_clean');
        $this->form_validation->set_rules('date', $this->lang->line("date"), 'required|xss_clean');
        $this->form_validation->set_rules('biller', $this->lang->line("biller"), 'required|is_natural_no_zero|xss_clean');
        $this->form_validation->set_rules('customer', $this->lang->line("customer"), 'required|is_natural_no_zero|xss_clean');
        $this->form_validation->set_rules('note', $this->lang->line("note"), 'xss_clean');
        $this->form_validation->set_rules('shipping', $this->lang->line("shipping"), 'xss_clean');
        if (TAX2) {
            $this->form_validation->set_rules('tax2', $this->lang->line("tax2"), 'required|is_natural_no_zero|xss_clean');
        }
        if (DISCOUNT_OPTION == 1) {
            $this->form_validation->set_rules('inv_discount', $this->lang->line("discount"), 'required|is_natural_no_zero|xss_clean');
        }

        $quantity = "quantity";
        $product = "product";
        $unit_price = "unit_price";
        $tax_rate = "tax_rate";
        $dis = "discount";

        if ($this->form_validation->run() == true) {
            $date = $this->ion_auth->fsd(trim($this->input->post('date')));
            $reference_no = $this->input->post('reference_no');
            $warehouse_id = $this->input->post('warehouse');
            $biller_id = $this->input->post('biller');
            $biller_details = $this->quotes_model->getBillerByID($biller_id);
            $biller_name = $biller_details->name;
            $customer_id = $this->input->post('customer');
            $customer_details = $this->quotes_model->getCustomerByID($customer_id);
            $customer_name = $customer_details->name;
            if (DISCOUNT_OPTION == 1) {
                $inv_discount = $this->input->post('inv_discount');
            }
            if (TAX2) {
                $tax_rate2 = $this->input->post('tax2');
            }
            $note = $this->ion_auth->clear_tags($this->input->post('note'));
            $internal_note = $this->ion_auth->clear_tags($this->input->post('internal_note'));
            $in_voice = $this->quotes_model->getQuoteByID($id);
            $warehouse_id = $in_voice->warehouse_id;
            $shipping = $this->input->post('shipping');

            $inv_total_no_tax = 0;

            for ($i = 1; $i <= 500; $i++) {
                if ($this->input->post($quantity . $i) && $this->input->post($product . $i) && $this->input->post($unit_price . $i)) {

                    if (TAX1) {
                        $tax_id = $this->input->post($tax_rate . $i);
                        $tax_details = $this->quotes_model->getTaxRateByID($tax_id);
                        $taxRate = $tax_details->rate;
                        $taxType = $tax_details->type;
                        $tax_rate_id[] = $tax_id;

                        if ($taxType == 1 && $taxRate != 0) {
                            $item_tax = (($this->input->post($quantity . $i)) * ($this->input->post($unit_price . $i)) * $taxRate / 100);
                            $val_tax[] = $item_tax;
                        } else {
                            $item_tax = $taxRate;
                            $val_tax[] = $item_tax;
                        }

                        if ($taxType == 1) {
                            $tax[] = $taxRate . "%";
                        } else {
                            $tax[] = $taxRate;
                        }
                    } else {
                        $tax_rate_id[] = 0;
                        $val_tax[] = 0;
                        $tax[] = "";
                    }

                    if (DISCOUNT_METHOD == 1 && DISCOUNT_OPTION == 2) {

                        $discount_id = $this->input->post($dis . $i);
                        $ds_details = $this->quotes_model->getDiscountByID($discount_id);
                        $ds = $ds_details->discount;
                        $dsType = $ds_details->type;
                        $dsID[] = $discount_id;

                        if ($dsType == 1) {
                            $val_ds[] = (($this->input->post($quantity . $i)) * ($this->input->post($unit_price . $i)) * $ds / 100);
                        } else {
                            $val_ds[] = $ds * ($this->input->post($quantity . $i));
                        }

                        if ($dsType == 1) {
                            $discount[] = $ds . "%";
                        } else {
                            $discount[] = $ds;
                        }
                    } elseif (DISCOUNT_METHOD == 2 && DISCOUNT_OPTION == 2) {

                        $discount_id = $this->input->post($dis . $i);
                        $ds_details = $this->quotes_model->getDiscountByID($discount_id);
                        $ds = $ds_details->discount;
                        $dsType = $ds_details->type;
                        $dsID[] = $discount_id;

                        if ($dsType == 1) {
                            $val_ds[] = (((($this->input->post($quantity . $i)) * ($this->input->post($unit_price . $i)) + $item_tax) * $ds) / 100);
                        } else {
                            $val_ds[] = $ds * ($this->input->post($quantity . $i));
                        }

                        if ($dsType == 1) {
                            $discount[] = $ds . "%";
                        } else {
                            $discount[] = $ds;
                        }
                    } else {
                        $val_ds[] = 0;
                        $dsID[] = 0;
                        $discount[] = "";
                    }
                    $inv_quantity[] = $this->input->post($quantity . $i);
                    $inv_product_code[] = $this->input->post($product . $i);
                    $inv_unit_price[] = $this->input->post($unit_price . $i);
                    $inv_gross_total[] = (($this->input->post($quantity . $i)) * ($this->input->post($unit_price . $i)));

                    $inv_total_no_tax += (($this->input->post($quantity . $i)) * ($this->input->post($unit_price . $i)));
                }
            }


            if (DISCOUNT_OPTION == 2) {
                $total_ds = array_sum($val_ds);
            } else {
                $total_ds = 0;
            }


            if (TAX1) {
                $total_tax = array_sum($val_tax);
            } else {
                $total_tax = 0;
            }


            if (!empty($inv_product_code)) {
                foreach ($inv_product_code as $pr_code) {
                    $product_details = $this->quotes_model->getProductByCode($pr_code);
                    $product_id[] = $product_details->id;
                    $product_name[] = $product_details->name;
                    $product_code[] = $product_details->code;
                    $product_unit[] = $product_details->unit;
                }
            }

            $keys = array("product_id", "product_code", "product_name", "product_unit", "tax_rate_id", "tax", "quantity", "unit_price", "gross_total", "val_tax", "discount_val", "discount", "discount_id");

            $items = array();
            foreach (array_map(null, $product_id, $product_code, $product_name, $product_unit, $tax_rate_id, $tax, $inv_quantity, $inv_unit_price, $inv_gross_total, $val_tax, $val_ds, $discount, $dsID) as $key => $value) {
                $items[] = array_combine($keys, $value);
            }

            if (TAX2) {
                $tax_dts = $this->quotes_model->getTaxRateByID($tax_rate2);
                $taxRt = $tax_dts->rate;
                $taxTp = $tax_dts->type;

                if ($taxTp == 1 && $taxRt != 0) {
                    $val_tax2 = ($inv_total_no_tax * $taxRt / 100);
                } else {
                    $val_tax2 = $taxRt;
                }
            } else {
                $val_tax2 = 0;
                $tax_rate2 = 0;
            }

            if (DISCOUNT_METHOD == 1 && DISCOUNT_OPTION == 1) {

                $ds_dts = $this->quotes_model->getDiscountByID($inv_discount);
                $ds = $ds_dts->discount;
                $dsTp = $ds_dts->type;

                if ($dsTp == 1 && $dsTp != 0) {
                    $val_discount = ($inv_total_no_tax * $ds / 100);
                } else {
                    $val_discount = $ds;
                }
            } elseif (DISCOUNT_METHOD == 2 && DISCOUNT_OPTION == 1) {

                $ds_dts = $this->quotes_model->getDiscountByID($inv_discount);
                $ds = $ds_dts->discount;
                $dsTp = $ds_dts->type;

                if ($dsTp == 1 && $dsTp != 0) {
                    $val_discount = ((($inv_total_no_tax + $total_tax + $val_tax2) * $ds) / 100);
                } else {
                    $val_discount = $ds;
                }
            } else {
                $val_discount = $total_ds;
                $inv_discount = 0;
            }

            $gTotal = $inv_total_no_tax + $total_tax + $val_tax2 - $val_discount;

            $quoteDetails = array('reference_no' => $reference_no,
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
                'user' => USER_NAME,
                'shipping' => $shipping
            );
        }

        if ($this->form_validation->run() == true && !empty($items)) {
            if ($this->quotes_model->updateQuote($id, $quoteDetails, $items, $warehouse_id)) {
                $this->session->set_flashdata('success_message', $this->lang->line("quote_updated"));
                redirect("module=quotes", 'refresh');
            }
        } else { //display the create biller form
            //set the flash data error message if there is one
            $data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));

            $data['billers'] = $this->quotes_model->getAllBillers();
            $data['customers'] = $this->quotes_model->getAllCustomers();

            $data['tax_rates'] = $this->quotes_model->getAllTaxRates();
            $data['discounts'] = $this->quotes_model->getAllDiscounts();
            $data['inv'] = $this->quotes_model->getQuoteByID($id);
            $data['inv_products'] = $this->quotes_model->getAllQuoteItems($id);
            $data['id'] = $id;
            $meta['page_title'] = $this->lang->line("update_quote");
            $data['page_title'] = $this->lang->line("update_quote");

            $this->load->view('commons/header', $meta);
            $this->load->view('edit', $data);
            $this->load->view('commons/footer');
        }
    }

    /* ------------------------------- */

    function delete($id = NULL) {

        if (!$this->ion_auth->in_group('owner')) {
            $this->session->set_flashdata('message', $this->lang->line("access_denied"));
            $data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
            redirect('module=quotes', 'refresh');
        }

        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        } else {
            $id = NULL;
        }

        if ($this->quotes_model->deleteQuote($id)) {
            $this->session->set_flashdata('message', $this->lang->line("quote_deleted"));
            redirect('module=quotes&view=quotes', 'refresh');
        }
    }

    /* -------------------------------------------------------------------------------------------------------------------------------- */

    function scan_item() {
        if ($this->input->get('code')) {
            $code = $this->input->get('code');
        }

        if ($item = $this->quotes_model->getProductByCode($code)) {

            $product_name = $item->name;
            $product_price = $item->price;

            $product = array('name' => $product_name, 'price' => $product_price);
        }

        echo json_encode($product);
    }

    function add_item() {
        if ($this->input->get('name')) {
            $name = $this->input->get('name');
        }

        if ($item = $this->quotes_model->getProductByName($name)) {

            $code = $item->code;
            $price = $item->price;

            $product = array('code' => $code, 'price' => $price);
        }

        echo json_encode($product);
    }

    function suggestions() {
        $term = $this->input->get('term', TRUE);

        if (strlen($term) < 2) die();

        $rows = $this->quotes_model->getProductNames($term);

        $json_array = array();
        foreach ($rows as $row)
            array_push($json_array, $row->name);

        echo json_encode($json_array);
    }
    
    function codeSuggestions()
	{
		$term = $this->input->get('term',TRUE);
	
		if (strlen($term) < 2) die();
	
		$rows = $this->quotes_model->getProductCodes($term);
	
		$json_array = array();
		foreach ($rows as $row)
			 array_push($json_array, $row->code);
	
		echo json_encode($json_array); 
	}

}
