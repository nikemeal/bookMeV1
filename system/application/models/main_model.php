<?php
			
class Main_model extends CI_Model {
 
	
		private $adldap;
		
		function __construct()
		{
			parent::__construct();
		}
		
		/*
		 * This function will get the number of rooms/bookable resources in the
		 * database. If none are found, assume this is a new install and show some
		 * dialog on what to do next
		 */
		

		function get_room_count()
		{
			$query = $this->db->get('rooms');
			return $query->num_rows();
		}
		
		/*
		 * This function simply authenticates the user against LDAP, passing the
		 * username and password variables given by the login form.
		 * If the authentication is successful, true is returned, otherwise
		 * false is returned
		 */
		function authenticate_user($username, $password, $ldap_conn_info)
		{	
		try 
			{
				require_once('adldap/adLDAP.php');
				$adldap = new adldap($ldap_conn_info);
			}
			catch (adLDAPException $e) 
			{
   				return $e->getMessage();
   				exit();   
			}
			
			$authenticated = $adldap->user()->authenticate($username, $password);
			if ($authenticated == 1) {
				$this->session->set_userdata('authenticated', true);
			}
			return $authenticated;
		} 
		
		function get_user_details($username, $ldap_conn_info)
		{
			try 
			{
				require_once('adldap/adLDAP.php');
				$adldap = new adldap($ldap_conn_info);
			}
			catch (adLDAPException $e) 
			{
   				return $e->getMessage();
   				exit();   
			}
		
			$userinfo = $adldap->user()->info($username, array("samaccountname","displayname","mail"));
			$fullname = $userinfo[0]["displayname"][0];
			$username = $userinfo[0]["samaccountname"][0];
			
			if (!empty($userinfo[0]["mail"][0]))
			{
				$email = $userinfo[0]["mail"][0];
			}else 
			{
				$email = null;
			}
			$this->session->set_userdata('fullname', $fullname);
			$this->session->set_userdata('username', $username);
			$this->session->set_userdata('email', $email);
		}
		
		function get_user_groups($username, $ldap_conn_info)
		{
			/*
			 * check which groups the user is a member of
			 */
		try 
			{
				require_once('adldap/adLDAP.php');
				$adldap = new adldap($ldap_conn_info);
			}
			catch (adLDAPException $e) 
			{
   				return $e->getMessage();
   				exit();   
			}
			$groups = $adldap->user()->groups($username, false);
			return $groups;
		}
		
		function user_ingroup($username,$groups, $ldap_conn_info)
		{
		try 
			{
				require_once('adldap/adLDAP.php');
				$adldap = new adldap($ldap_conn_info);
			}
			catch (adLDAPException $e) 
			{
   				return $e->getMessage();
   				exit();   
			}
			$ingroup = 0;
			foreach ($groups as $group)
			{
				$ingroup = $adldap->user()->ingroup($username,$group,false);
				if ($ingroup)
				{
					$ingroup = 1;
					break;
				}
			}
			return $ingroup;
		}
}