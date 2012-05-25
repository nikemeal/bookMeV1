<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class General extends CI_Controller
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
	
	function general_settings()
	{
		$this->load->model('Settings_model');
		/*
		 * get the settings from the database and pass them to the general
		 * settings view
		 */
		$data['school_name'] = $this->Settings_model->get_school_name();
		$data['bookme_version'] = $this->Settings_model->get_bookme_version();
		$data['allow_local_login'] = $this->Settings_model->get_allow_local_login();
		$data['bg_colour'] = $this->Settings_model->get_bg_colour();
		$data['booking_count'] = $this->Settings_model->get_booking_count();				
		
		//load body with data
		$this->load->view('settings_general', $data);
	}
	
	function submit_general_settings()
	{
		$school_name = $this->input->post('school_name');
		$allow_local_login = $this->input->post('allow_local_login');
		$bg_colour = $this->input->post('bg_colour');
		$this->Settings_model->update_school_name($school_name);
		$this->Settings_model->update_allow_local_login($allow_local_login);
		$this->Settings_model->update_bg_colour($bg_colour);
		/*
		 * need some form of error checking to see if all DB updates were successful.
		 * if not then load an error page detailing why, otherwise load the relevant 
		 * settings update page
		 */
		$this->load->view('settings_general_update');
	}
	
	function deleteallbookings()
	{
		if ($this->input->post('action') == 'delete_all_bookings')
		{
		$result['success'] = $this->Settings_model->wipebookings();
		$this->load->view('delete_all_bookings_result', $result);
		}
	}
	
}