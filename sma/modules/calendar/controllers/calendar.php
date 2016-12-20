<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Calendar extends MX_Controller {

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
| MODULE: 			Calendar
| -----------------------------------------------------
| This is calendar module controller file.
| -----------------------------------------------------
*/

	 
	function __construct()
	{
		parent::__construct();
		
		// check if user logged in 
		if (!$this->ion_auth->logged_in()) {
			redirect('module=auth&view=login');
	  	}
		$this->load->model('calendar_model');
	}
	
   
   function index()
   {
	   if($this->input->get('year')){ $year = $this->input->get('year'); } else { $year = date('Y'); }
	   if($this->input->get('month')){ $month = $this->input->get('month'); } else { $month = date('m'); }
	   
	   if ($day = $this->input->post('day')) {
		   if(!$this->input->post('data')) {
			   $this->calendar_model->deleteEvent("$year-$month-$day");
		   } else {
			$this->calendar_model->add_calendar_data("$year-$month-$day", $this->input->post('data'));
		   }
		}
	   
	   $data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
	    $data['success_message'] = $this->session->flashdata('success_message');	
		
		$config['translated_day_names'] = array($this->lang->line("sunday"), $this->lang->line("monday"), $this->lang->line("tuesday"), $this->lang->line("wednesday"), $this->lang->line("thursday"), $this->lang->line("friday"), $this->lang->line("saturday"));
		$config['translated_month_names'] = array('01' => $this->lang->line("january"), '02' => $this->lang->line("february"), '03' => $this->lang->line("march"), '04' => $this->lang->line("april"), '05' => $this->lang->line("may"), '06' => $this->lang->line("june"), '07' => $this->lang->line("july"), '08' => $this->lang->line("august"), '09' => $this->lang->line("september"), '10' => $this->lang->line("october"), '11' => $this->lang->line("november"), '12' => $this->lang->line("december"));

		$config['template'] = '

   			{table_open}<table border="0" cellpadding="0" cellspacing="0" class="table table-bordered" style="min-width:522px;">{/table_open}
			
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

		
		$this->load->library('month_cal', $config);
		
		
	   $cal_data = $this->calendar_model->get_calendar_data($year, $month);
	   $data['calender'] = $this->month_cal->generate($year, $month, $cal_data);
	   
      $meta['page_title'] = $this->lang->line("calendar");
	  $data['page_title'] = $this->lang->line("calendar");
      $this->load->view('commons/header', $meta);
      $this->load->view('calendar', $data);
      $this->load->view('commons/footer');
   }
   

}

/* End of file calendar.php */ 
/* Location: ./sma/modules/calendar/controllers/calendar.php */