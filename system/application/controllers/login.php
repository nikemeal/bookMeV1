<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('Main_model');
		$this->load->model('Settings_model');
		$this->load->view('template/header_view', array( 'bg_colour' => $this->Settings_model->get_bg_colour()));

		
	}
	
	function index()
	{

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
		$this->db->select('setting_value as allow_local_login from settings');
 		$this->db->where('setting_name = \'allow_local_login\'');
		$query = $this->db->get();
 		$row = $query->row_array();
		$allow_local_login = $row['allow_local_login'];
		
		//local usernames OK but local login not allowed
		if ($_POST['username'] == 'bookme_admin' && $allow_local_login == false xor $_POST['username'] == 'bookme_staff' && $allow_local_login == false)
		{
			$this->session->set_userdata('local_login', 'denied');
			$this->session->set_userdata('authenticated', false);
		}
		//local username and password OK and local login allowed
		elseif ($_POST['username'] == 'bookme_admin' && $_POST['password'] == 'cr3ation' && $allow_local_login == true xor $_POST['username'] == 'bookme_staff' && $_POST['password'] == 'cr3ation' && $allow_local_login == true)
		{
			$this->session->set_userdata('authenticated', true);
			$this->session->set_userdata('accesslevel', 'admin');
			$this->session->set_userdata('fullname', 'BookMe Local Admin');
			$this->session->set_userdata('username', 'bookme_admin');
			redirect('/', 'refresh');
		}
		//otherwise let's check the name against LDAP  
		else
		{
		$this->Main_model->authenticate_user($_POST['username'],$_POST['password']);
		}
		/*
		 * If user is authenticated, let's get their group membership and then
		 * check that membership against the allowed groups
		 * else throw them out with a user/password error
		 */
		$authenticated = $this->session->userdata('authenticated');
		if ($authenticated == 1) 
		{
			//the user is authenticated so lets get their details
			$this->Main_model->get_user_details($_POST['username']);	
			$groups = $this->Main_model->get_user_groups($_POST['username']);
			//need function to check group membership before redirecting
		
			
	
			redirect('/', 'refresh');
		}
		
		else 
		{
			//user has failed authentication - show why
			$this->load->view('login_failed');
			$this->load->view('template/footer');
		}
	}
	
	function reset()
		{
			$this->session->sess_destroy();
			redirect('/', 'refresh');
		}
	
	function logout()
		{
			$this->session->sess_destroy();
			redirect('/', 'refresh');
		}
	
}