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
		function authenticate_user($username, $password)
		{	
			$authenticated = $this->adldap->user()->authenticate($username, $password);
			if ($authenticated == 1) {
				$this->session->set_userdata('authenticated', true);
			}
			return $authenticated;
		} 
		
		function get_user_details($username)
		{
			$userinfo = $this->adldap->user()->info($username, array("samaccountname","displayname","mail"));
			$fullname = $userinfo[0]["displayname"][0];
			$username = $userinfo[0]["samaccountname"][0];
			$email = $userinfo[0]["mail"][0];
			$this->session->set_userdata('fullname', $fullname);
			$this->session->set_userdata('username', $username);
			$this->session->set_userdata('email', $email);
		}
		
		function get_user_groups($username)
		{
			/*
			 * check which groups the user is a member of
			 */
			$groups = $this->adldap->user()->groups($username, false);
			return $groups;
		}
		
		function user_ingroup($username,$group)
		{
			/*
			 * initially this will check the username passed to it against 
			 * a static list of groups.  in the future this will read the list
			 * from the groups selected by the user
			 */
			$ingroup = $this->adldap->user()->ingroup($username,$group,false);
			return $ingroup;
		}
}