<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reports extends CI_Controller 
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
		$this->load->model('Settings_model');
		$this->load->model('Booking_model');
		$this->load->model('Reports_model');
		$this->load->view('template/header_view', array( 'bg_colour' => $this->Settings_model->get_bg_colour()));
		$this->load->view('main_menu', array( 'school_name' => $this->Settings_model->get_school_name(), 'user_reports' => $this->Settings_model->get_user_reports()));
	}
	
	function index()
	{
		$this->load->view('reports/reports');
	}
	
	function room_report_overview()
	{
		$this->db->order_by("room_name", "asc"); 
		$query = $this->db->get('rooms');
		$result = $query->result_array();
		$data['rooms'] = $result;
		$this->load->view('reports/room_report_overview', $data);
	}
	
	function room_report($room_id)
	{
		//set default search period of 1 month in the past
		$date_from = date('Y-m-d',strtotime("-1 month"));
		$date_to = date('Y-m-d');
		
		//check to see if alternative search dates given, if so, set them instead
		if ($this->input->post('date_from') AND $this->input->post('date_to'))
		{
			$date_from = date($this->input->post('date_from'));
			$date_to = date($this->input->post('date_to'));
		}
		$data['room_name'] = $this->Booking_model->get_roomname($room_id);
		$data['dept_report'] = $this->Reports_model->room_report_by_dept($room_id, $date_from, $date_to);
		$data['dept_report_count'] = $this->Reports_model->room_report_count($room_id, $date_from, $date_to);
		$data['user_report'] = $this->Reports_model->room_report_by_user($room_id, $date_from, $date_to);
		$data['date_from_readable'] = $this->Booking_model->get_pretty_date($date_from);
		$data['date_to_readable'] = $this->Booking_model->get_pretty_date($date_to);
		$this->load->view('reports/room_report', $data);
	}
	
	function dept_report_overview()
	{
		$this->db->order_by("subject_name", "asc"); 
		$query = $this->db->get('subjects');
		$result = $query->result_array();
		$data['depts'] = $result;
		$this->load->view('reports/dept_report_overview', $data);
	}
	
	function dept_report($subject_id)
	{
		//set default search period of 1 month in the past
		$date_from = date('Y-m-d',strtotime("-1 month"));
		$date_to = date('Y-m-d');
		
		//check to see if alternative search dates given, if so, set them instead
		if ($this->input->post('date_from') AND $this->input->post('date_to'))
		{
			$date_from = date($this->input->post('date_from'));
			$date_to = date($this->input->post('date_to'));
		}
		$subject_name = $this->Settings_model->get_subject_info($subject_id);
		$data['subject_name'] = $subject_name['subject_name'];
		$data['dept_report'] = $this->Reports_model->dept_report_by_room($subject_id, $date_from, $date_to);
		$data['dept_report_count'] = $this->Reports_model->dept_report_count($subject_id, $date_from, $date_to);
		$data['user_report'] = $this->Reports_model->dept_report_by_user($subject_id, $date_from, $date_to);
		$data['date_from_readable'] = $this->Booking_model->get_pretty_date($date_from);
		$data['date_to_readable'] = $this->Booking_model->get_pretty_date($date_to);
		$this->load->view('reports/dept_report', $data);
	}
	
	function user_report()
	{
		//set default search period of 1 month in the past
		$date_from = date('Y-m-d',strtotime("-1 month"));
		$date_to = date('Y-m-d');
		
		//check to see if alternative search dates given, if so, set them instead
		if ($this->input->post('date_from') AND $this->input->post('date_to'))
		{
			$date_from = date($this->input->post('date_from'));
			$date_to = date($this->input->post('date_to'));
		}
		$data['user_report'] = $this->Reports_model->user_report($date_from, $date_to);
		$data['user_report_count'] = $this->Reports_model->user_report_count($date_from, $date_to);
		$data['date_from_readable'] = $this->Booking_model->get_pretty_date($date_from);
		$data['date_to_readable'] = $this->Booking_model->get_pretty_date($date_to);
		$this->load->view('reports/user_report', $data);
	}
	
}