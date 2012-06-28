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
		$this->load->library('encrypt');
	}
	
	function index()
	{

	}
	
function auth_settings()
	{
		$data['ldap_server'] = $this->Settings_model->get_ldap_server();
		$data['ldap_account_suffix'] = $this->Settings_model->get_ldap_account_suffix();
		$data['ldap_basedn'] = $this->Settings_model->get_ldap_basedn();
		$data['ldap_username'] = $this->Settings_model->get_ldap_username();
		$encrypted_ldap_password = $this->Settings_model->get_ldap_password();
		$data['ldap_password'] = $this->encrypt->decode($encrypted_ldap_password);
		$ldap_standard_users = $this->Settings_model->get_ldap_standard_users();
		$ldap_admin_users = $this->Settings_model->get_ldap_admin_users();
		$data['ldap_standard_users'] = $this->Settings_model->split_semi_colon($ldap_standard_users);
		$data['ldap_admin_users'] = $this->Settings_model->split_semi_colon($ldap_admin_users);
		
		//check to see if ldap can connect. show groups if so, if not, show error
		if (empty($data['ldap_server']) || empty($data['ldap_account_suffix']) || empty($data['ldap_basedn']) || empty($data['ldap_username']) || empty($data['ldap_password']))
		{
			$data['ldap_groups'] = false;	
		}
		else 
		{
			$ldap_conn_info = array
				(
				'domain_controllers' => array($this->Settings_model->get_ldap_server()),
				'account_suffix' => $this->Settings_model->get_ldap_account_suffix(),
				'base_dn' => $this->Settings_model->get_ldap_basedn(),
				'admin_username' => $this->Settings_model->get_ldap_username(),
				'admin_password' => $this->encrypt->decode($this->Settings_model->get_ldap_password())
				);
			$data['ldap_groups'] = $this->Settings_model->get_all_ldap_groups($ldap_conn_info);	
		}
		
		
		
		$this->load->view('settings/settings_auth', $data);
		$this->load->view('template/footer');
	}
	
	function submit_auth_settings()
	{
		$ldap_servers = $this->input->post('ldap_servers');
		$ldap_account_suffix = $this->input->post('ldap_account_suffix');
		$ldap_basedn = $this->input->post('ldap_basedn');
		$ldap_username = $this->input->post('ldap_username');
		$this->load->library('encrypt');
		$ldap_password = $this->encrypt->encode($this->input->post('ldap_password'));
		
		$this->Settings_model->update_ldap_servers($ldap_servers);
		$this->Settings_model->update_ldap_account_suffix($ldap_account_suffix);
		$this->Settings_model->update_ldap_basedn($ldap_basedn);
		$this->Settings_model->update_ldap_username($ldap_username);
		$this->Settings_model->update_ldap_password($ldap_password);
		
		$ldap_conn_info = array
			(
			'domain_controllers' => array($this->Settings_model->get_ldap_server()),
			'account_suffix' => $this->Settings_model->get_ldap_account_suffix(),
			'base_dn' => $this->Settings_model->get_ldap_basedn(),
			'admin_username' => $this->Settings_model->get_ldap_username(),
			'admin_password' => $this->encrypt->decode($this->Settings_model->get_ldap_password())
			);
		$data['test_ldap'] = $this->Settings_model->test_ldap_settings($ldap_conn_info);
		$this->load->view('settings/settings_auth_update', $data);
		$this->load->view('template/footer');
	}
	
	function submit_auth_users()
	{
		$ldap_admin_users = $this->input->post('admin_users');
		$ldap_standard_users = $this->input->post('standard_users');
		
		if ($ldap_admin_users)
		{
			$this->Settings_model->save_ldap_admin_groups($ldap_admin_users);
		}
		
		if ($ldap_standard_users)
		{
			$this->Settings_model->save_ldap_standard_groups($ldap_standard_users);
		}
		$this->load->view('settings/settings_auth_update');
		$this->load->view('template/footer');
	}
	
}