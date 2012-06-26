<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Subjects extends CI_Controller
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
	
function subject_settings()
	{
		$data['subject_count'] = $this->Settings_model->get_subject_count();

		//if no subjects exist, load a view to show subject add page
		if ($data['subject_count'] == 0)
		{
			$this->load->view('settings/settings_subjects_add', array('error' => ' ' ));
			$this->load->view('template/footer');
		} else 

		//else get the list of subjects in the database and show them
		{
			$query = $this->db->get('subjects');
			$result = $query->result_array();
			$data['subjects'] = $result;
			$this->load->view('settings/settings_subjects_edit',$data);
			$this->load->view('template/footer');
		}
	}
	
	function submit_new_subject()
	{
		//update the database with the details given
		$subject_name = $this->input->post('subject_name');
		$subject_use_shading = $this->input->post('subject_use_shading');
		$subject_colour = $this->input->post('subject_colour');
		$this->Settings_model->add_subject($subject_name, $subject_use_shading, $subject_colour);
			
		//then load the view
		$this->load->view('settings/settings_subjects_update');
		$this->load->view('template/footer');
	}
	
	function edit_subject()
	{
		$subject_id = $this->uri->segment(4);
		$data = $this->Settings_model->get_subject_info($subject_id);
		$this->load->view('settings/edit_subject', $data);
		$this->load->view('template/footer');
	}
	
	function update_subject()
	{
		$subject_id = $this->input->post('subject_id');
		$subject_name = $this->input->post('subject_name');
		$subject_use_shading = $this->input->post('subject_use_shading');
		$subject_colour = $this->input->post('subject_colour');
		$this->Settings_model->update_subject($subject_id, $subject_name, $subject_use_shading, $subject_colour);
		
		//load the view
		$this->load->view('settings/settings_subjects_update');
		$this->load->view('template/footer');
	}
	
	function add_subject()
	{
		$this->load->view('settings/settings_subjects_add', array('error' => ' ' ));
		$this->load->view('template/footer');
	}
	
	function subject_delete()
	{
		$this->load->model('Main_model');
		$subject_id = $this->uri->segment(4);
		$query = $this->db->delete('subjects', array('subject_id' => $subject_id)); 
		
		$this->load->view('settings/settings_subjects_update');	
		$this->load->view('template/footer');
	}
	
}