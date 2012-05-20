<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller 
{
	/**
	 * Index Page for the site which will load
	 * the main view for staff and the additional
	 * menu items for admin users such as
	 * block bookings and settings
	 */
	function index()
	{
		$this->load->helper('url');
		$this->load->model('Main_model');
		$this->load->model('Settings_model');
		$data['room_count'] = $this->Main_model->get_room_count();
		$this->load->view('template/header_view');
		$this->load->view('main_menu', $data);
		$this->load->view('main_body', $data);	
		
	}
	
	function login()
	{
		$this->load->view('login');
	}
	function processlogin()
	{
		/*
		 * function passed from the login box. will authenticate user against
		 * LDAP and try to get other user details. 
		 * if successfully authenticated, check group membership and select whether admin or 
		 * staff member (set accesslevel to admin/staff)
		 * if login success, load login success view then redirect back to main 
		 * page which should now show other info 
		 */
		$this->load->model('Main_model');
		$this->load->helper('url');
		$this->db->select('setting_value as allow_local_login from settings');
 		$this->db->where('setting_name = \'allow_local_login\'');
			$query = $this->db->get();
 			$row = $query->row_array();
			$allow_local_login = $row['allow_local_login'];
		
		if ($_POST['username'] == 'bookme_admin' && $_POST['password'] == 'cr3ation' && $allow_local_login == true)
		{
			$this->session->set_userdata('authenticated', true);
			$this->session->set_userdata('accesslevel', 'admin');
			$this->session->set_userdata('fullname', 'BookMe Local Admin');
			$this->session->set_userdata('username', 'bookme_admin');
			redirect('/', 'refresh');
		} else {
		$this->Main_model->authenticate_user($_POST['username'],$_POST['password']);
		$authenticated = $this->session->userdata('authenticated');
		
		/*
		 * If user is authenticated, let's get their group membership and then
		 * check that membership against the allowed groups
		 * else throw them out with a user/password error
		 */
		if ($authenticated == 1) 
		{
			$this->Main_model->get_user_details($_POST['username']);	
			$groups = $this->Main_model->get_user_groups($_POST['username']);
			//need function to check group membership before redirecting
			//this will need to be cleaned up for the future
			$group1 = "Domain Admins";
			$group2 = "Junior Teaching Staff - Security Group";
			$ingroup1 = $this->Main_model->user_ingroup($_POST['username'],$group1);
			$ingroup2 = $this->Main_model->user_ingroup($_POST['username'],$group2);	 
			if ($ingroup1 == 1) {
				$this->session->set_userdata('accesslevel', 'admin');
			}
			if ($ingroup2 == 1) {
				$this->session->set_userdata('accesslevel', 'staff');
			}
			//end of function that needs to be cleaned up
			redirect('/', 'refresh');
		}
		
		else 
		{
			$this->load->view('template/header_view');
			$this->load->view('main_menu');
			$this->load->view('main_body');
 			$this->load->view('login_failed');
		}
		}
	}
	
	function logout()
		{
			$this->session->sess_destroy();
			$this->load->helper('url');
			redirect('/', 'refresh');
		}
}