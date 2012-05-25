<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Holidays extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('Settings_model');
		$this->load->view('template/header_view', array( 'bg_colour' => $this->Settings_model->get_bg_colour()));
		$this->load->view('main_menu', array( 'school_name' => $this->Settings_model->get_school_name()));
		
	}
	
	function index()
	{

	}
	
	function holiday_settings()
	{
		$data['holiday_count'] = $this->Settings_model->get_holiday_count();

		//if no subjects exist, load a view to show holiday add page
		if ($data['holiday_count'] == 0)
		{
			$this->load->view('settings_holidays_add', array('error' => ' ' ));
		} else 

		//else get the list of holidays in the database and show them
		{
			$query = $this->db->order_by('holiday_start', 'asc')->get('holidays');
			$result = $query->result_array();
			$data['holidays'] = $result;
		
			$this->load->view('settings_holidays_edit',$data);
		}
	}
	
	function submit_new_holiday()
	{
		//update the database with the details given
		$holiday_name = $this->input->post('holiday_name');
		//reverse the start and end dates before submitting them for UK method
		$temp_start_date= $this->input->post('holiday_start');
 		$arr =explode("-",$temp_start_date);
 		$arr=array_reverse($arr);
 		$holiday_start =implode($arr,"-");
 		$temp_end_date= $this->input->post('holiday_end');
 		$arr =explode("-",$temp_end_date);
 		$arr=array_reverse($arr);
 		$holiday_end =implode($arr,"-");

		$this->Settings_model->add_holiday($holiday_name, $holiday_start, $holiday_end);
			
		//then load the view
		$this->load->view('settings_holidays_update');
	}
	
	function edit_holiday()
	{
		$holiday_id = $this->uri->segment(4);
		$data = $this->Settings_model->get_holiday_info($holiday_id);
		$this->load->view('edit_holiday', $data);
	}
	
	function update_holiday()
	{
		$holiday_id = $this->input->post('holiday_id');
		$holiday_name = $this->input->post('holiday_name');
		//reverse the start and end dates before submitting them for UK method
		$temp_start_date= $this->input->post('holiday_start');
 		$arr =explode("-",$temp_start_date);
 		$arr=array_reverse($arr);
 		$holiday_start =implode($arr,"-");
		$temp_end_date= $this->input->post('holiday_end');
 		$arr =explode("-",$temp_end_date);
 		$arr=array_reverse($arr);
 		$holiday_end =implode($arr,"-");
		
		$this->Settings_model->update_holiday($holiday_id, $holiday_name, $holiday_start, $holiday_end);
		
		//load the view
		$this->load->view('settings_holidays_update');
	}
	
	function add_holiday()
	{
		$this->load->view('settings_holidays_add', array('error' => ' ' ));
	}
	
	function holiday_delete()
	{
		$this->load->model('Main_model');
		$holiday_id = $this->uri->segment(4);
		$query = $this->db->delete('holidays', array('holiday_id' => $holiday_id)); 
		
		$this->load->view('settings_holidays_update');	
	}
	
}