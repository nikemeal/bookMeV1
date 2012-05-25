<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Authentication extends CI_Controller
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
	
function auth_settings()
	{
		$data['ldap_server'] = $this->Settings_model->get_ldap_server();
		
		//need to test and see if next two lines below are needed or can be picked up
		//when adLDAP is invoked 
		$data['ldap_account_suffix'] = $this->Settings_model->get_ldap_account_suffix();
		$data['ldap_basedn'] = $this->Settings_model->get_ldap_basedn();
		$data['ldap_username'] = $this->Settings_model->get_ldap_username();
		$data['ldap_password'] = $this->Settings_model->get_ldap_password();
		$data['ldap_standard_users'] = $this->Settings_model->get_ldap_standard_users();
		$data['ldap_admin_users'] = $this->Settings_model->get_ldap_admin_users();
		
		$this->load->view('settings/settings_auth', $data);
	}
	
	function submit_auth_settings()
	{
		//need one here once rest of the auth settings page has been done
	}
	
}