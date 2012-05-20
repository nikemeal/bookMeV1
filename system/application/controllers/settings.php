<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends CI_Controller 
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
	}
	
	function index()
	{
		$this->load->model('settings_model');
		$this->load->view('template/header_view');
		$this->load->view('main_menu');
		
		/*
		 * these ready to be copied in to separate functions
		$data['ldap_server'] = $this->Settings_model->get_ldap_server();
		$data['ldap_basedn'] = $this->Settings_model->get_ldap_basedn();
		$data['ldap_username'] = $this->Settings_model->get_ldap_username();
		$data['ldap_password'] = $this->Settings_model->get_ldap_password();
		$data['ldap_standard_users'] = $this->Settings_model->get_ldap_standard_users();
		$data['ldap_admin_users'] = $this->Settings_model->get_ldap_admin_users();
		*/
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
		$this->load->view('template/header_view');
		$this->load->view('main_menu');
		//load body with data
		$this->load->view('settings_general', $data);
	}
	
	function submit_general_settings()
	{
		$this->load->model('Settings_model');
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
		$load = uri_string();
		$this->load->view('settings_general_update', $load);
	}
	
	function auth_settings()
	{
		$this->load->model('Settings_model');
		$data['ldap_server'] = $this->Settings_model->get_ldap_server();
		
		//need to test and see if two lines below are needed or can be picked up
		//when adLDAP is invoked 
		$data['ldap_account_suffix'] = $this->Settings_model->get_ldap_account_suffix();
		$data['ldap_basedn'] = $this->Settings_model->get_ldap_basedn();
		
		$data['ldap_username'] = $this->Settings_model->get_ldap_username();
		$data['ldap_password'] = $this->Settings_model->get_ldap_password();
		$data['ldap_standard_users'] = $this->Settings_model->get_ldap_standard_users();
		$data['ldap_admin_users'] = $this->Settings_model->get_ldap_admin_users();
		
		$this->load->view('template/header_view');
		$this->load->view('main_menu');
		//load body with data
		$this->load->view('settings_auth', $data);
	}
	
	function submit_auth_settings()
	{
		//need one here once rest of the auth settings page has been done
	}
	
	function room_settings()
	{
		$this->load->model('Main_model');
		$this->load->model('Settings_model');
		$data['room_count'] = $this->Main_model->get_room_count();

		//if no rooms exist, load a view to show button linking to room add page
		if ($data['room_count'] == 0)
		{
			
			$this->load->view('template/header_view');
			$this->load->view('main_menu');
			$this->load->view('settings_rooms_add', array('error' => ' ' ));
		} else 
		//else show the list of rooms in the database
		{
			$this->load->view('template/header_view');
			$this->load->view('main_menu');
			$this->load->view('settings_rooms_show');
		}
	}
	
	function submit_new_room()
	{
		$this->load->model('Main_model');
		$this->load->model('Settings_model');
		$config['upload_path'] = './img/room_images/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '100';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload())
		{
			/*
			 * if there is an error with the file being uploaded, return
			 * the user to the previous page with the error to be shown
			 */ 
			$error = array('error' => $this->upload->display_errors());
			$this->load->view('template/header_view');
			$this->load->view('main_menu');
			$this->load->view('settings_rooms_add', $error);
		}
		else
		{
			//update the database with the details given
			$room_name = $this->input->post('room_name');
			$pc_count = $this->input->post('pc_count');
			$data = array('upload_data' => $this->upload->data());			
			$image = $data['upload_data']['file_name'];
			$this->Settings_model->add_room($room_name, $pc_count, $image);
			
			//then load the views
			$this->load->view('template/header_view');
			$this->load->view('main_menu');
			$this->load->view('settings_rooms_update');
		}		
	}
}