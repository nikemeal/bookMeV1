<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Years extends CI_Controller
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
	
	function year_settings()
	{
		$data['year_count'] = $this->Settings_model->get_year_count();

		//if no years exist, load a view to show year add page
		if ($data['year_count'] == 0)
		{
			$this->load->view('settings/settings_year_add', array('error' => ' ' ));
			$this->load->view('template/footer');
		} else 

		//else get the list of holidays in the database and show them
		{
			$query = $this->db->order_by('year_start', 'asc')->get('years');
			$result = $query->result_array();
			$data['years'] = $result;
		
			$this->load->view('settings/settings_year_edit',$data);
			$this->load->view('template/footer');
		}
	}
	
	function submit_new_year()
	{
		//update the database with the details given
		$year_name = $this->input->post('year_name');
		//reverse the start and end dates before submitting them for UK method
		$temp_start_date= $this->input->post('year_start');
 		$arr =explode("-",$temp_start_date);
 		$arr=array_reverse($arr);
 		$year_start =implode($arr,"-");
 		$temp_end_date= $this->input->post('year_end');
 		$arr =explode("-",$temp_end_date);
 		$arr=array_reverse($arr);
 		$year_end =implode($arr,"-");
		 		
		$this->Settings_model->add_year($year_name, $year_start, $year_end);
			
		//then load the view
		$this->load->view('settings/settings_year_update');
		$this->load->view('template/footer');
	}
	
	function edit_year()
	{
		$year_id = $this->uri->segment(4);
		$data = $this->Settings_model->get_year_info($year_id);
		$this->load->view('settings/edit_year', $data);
		$this->load->view('template/footer');
	}
	
	function update_year()
	{
		$year_id = $this->input->post('year_id');
		$year_name = $this->input->post('year_name');
		//reverse the start and end dates before submitting them for UK method
		$temp_start_date= $this->input->post('year_start');
 		$arr =explode("-",$temp_start_date);
 		$arr=array_reverse($arr);
 		$year_start =implode($arr,"-");
		$temp_end_date= $this->input->post('year_end');
 		$arr =explode("-",$temp_end_date);
 		$arr=array_reverse($arr);
 		$year_end =implode($arr,"-");
		
		$this->Settings_model->update_year($year_id, $year_name, $year_start, $year_end);
		
		//load the view
		$this->load->view('settings/settings_year_update');
		$this->load->view('template/footer');
	}
	
	function add_year()
	{
		$this->load->view('settings/settings_year_add', array('error' => ' ' ));
		$this->load->view('template/footer');
	}
	
	function year_delete()
	{
		$this->load->model('Main_model');
		$year_id = $this->uri->segment(4);
		$query = $this->db->delete('years', array('year_id' => $year_id)); 
		
		$this->load->view('settings/settings_year_update');	
		$this->load->view('template/footer');
	}

}