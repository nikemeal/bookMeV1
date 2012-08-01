<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller 
{
	/**
	 * Index Page for the site which will load
	 * the main view for staff and the additional
	 * menu items for admin users such as
	 * block bookings and settings
	 */
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('Main_model');
		$this->load->model('Settings_model');
		$this->load->view('template/header_view', array( 'bg_colour' => $this->Settings_model->get_bg_colour()));
		$this->load->view('main_menu', array( 'school_name' => $this->Settings_model->get_school_name(), 'user_reports' => $this->Settings_model->get_user_reports()));
	}
	
	function index()
	{
		$data['room_count'] = $this->Main_model->get_room_count();
		$data['period_count'] = $this->Settings_model->get_period_count();
		$data['subject_count'] = $this->Settings_model->get_subject_count();
		$data['year_count'] = $this->Settings_model->get_year_count();
		/*
		 * if at least one room, subject and period exists, show the booking page
		 */
		if ($data['year_count'] > 0 && $data['room_count'] > 0 && $data['period_count'] > 0 && $data['subject_count'] > 0)
		{
			$this->db->order_by("room_name", "asc"); 
			$query = $this->db->get('rooms');
			$result = $query->result_array();
			$data['rooms'] = $result;
			$this->load->view('main_body_booking', $data);
			$this->load->view('template/footer');
		}
		else
		{
			/*
			 * if any of the required settings are missing, load the main body with text informing the user
			 */
			$this->load->view('main_body', $data);	
			$this->load->view('template/footer');
		}
	}
	
}