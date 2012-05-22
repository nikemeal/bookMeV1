<?php
			
class Settings_model extends CI_Model {
 
	
		private $adldap;
		
		function __construct()
		{
			parent::__construct();
			//uncomment the lines below when finished testing
			//require ('application/libraries/adLDAP.php');
			//$this->adldap = new adldap();
		}
		
		function get_school_name()
		{
			$this->db->select('setting_value as school_name from settings');
 			$this->db->where('setting_name = \'school_name\'');
			$query = $this->db->get();
 			$row = $query->row_array();
			$result = $row['school_name'];
 			return $result; 
		}
		
		function get_ldap_server()
		{
			$this->db->select('setting_value as ldap_server from settings');
 			$this->db->where('setting_name = \'ldap_server\'');
			$query = $this->db->get();
 			$row = $query->row_array();
			$result = $row['ldap_server'];
 			return $result; 
		}
		
		function get_ldap_account_suffix()
		{
			$this->db->select('setting_value as ldap_account_suffix from settings');
 			$this->db->where('setting_name = \'ldap_account_suffix\'');
			$query = $this->db->get();
 			$row = $query->row_array();
			$result = $row['ldap_account_suffix'];
 			return $result; 
		}
		
		function get_ldap_basedn()
		{
			$this->db->select('setting_value as ldap_basedn from settings');
 			$this->db->where('setting_name = \'ldap_basedn\'');
			$query = $this->db->get();
 			$row = $query->row_array();
			$result = $row['ldap_basedn'];
 			return $result; 
		}
		
		function get_ldap_username()
		{
			$this->db->select('setting_value as ldap_username from settings');
 			$this->db->where('setting_name = \'ldap_username\'');
			$query = $this->db->get();
 			$row = $query->row_array();
			$result = $row['ldap_username'];
 			return $result; 
		}
		
		function get_ldap_password()
		{
			$this->db->select('setting_value as ldap_password from settings');
 			$this->db->where('setting_name = \'ldap_password\'');
			$query = $this->db->get();
 			$row = $query->row_array();
			$result = $row['ldap_password'];
 			return $result; 
		}
		
		function get_ldap_standard_users()
		{
			$this->db->select('setting_value as ldap_standard_users from settings');
 			$this->db->where('setting_name = \'ldap_standard_users\'');
			$query = $this->db->get();
 			$row = $query->row_array();
			$result = $row['ldap_standard_users'];
 			return $result; 
		}
		
		function get_ldap_admin_users()
		{
			$this->db->select('setting_value as ldap_admin_users from settings');
 			$this->db->where('setting_name = \'ldap_admin_users\'');
			$query = $this->db->get();
 			$row = $query->row_array();
			$result = $row['ldap_admin_users'];
 			return $result; 
		}
		
		function get_bookme_version()
		{
			$this->db->select('setting_value as bookme_version from settings');
 			$this->db->where('setting_name = \'bookme_version\'');
			$query = $this->db->get();
 			$row = $query->row_array();
			$result = $row['bookme_version'];
 			return $result; 
		}
		
		function get_bg_colour()
		{
			$this->db->select('setting_value as bg_colour from settings');
 			$this->db->where('setting_name = \'bg_colour\'');
			$query = $this->db->get();
 			$row = $query->row_array();
			$result = $row['bg_colour'];
 			return $result; 
		}
		
		function get_allow_local_login()
		{
			$this->db->select('setting_value as allow_local_login from settings');
 			$this->db->where('setting_name = \'allow_local_login\'');
			$query = $this->db->get();
 			$row = $query->row_array();
			$result = $row['allow_local_login'];
 			return $result; 
		}
		
		function update_school_name($school_name)
		{
			$data = array('setting_value' => $school_name,);
			$this->db->update('settings',$data, 'setting_name = \'school_name\'');
		}
		
		function update_allow_local_login($allow_local_login)
		{
			$data = array('setting_value' => $allow_local_login,);
			$this->db->update('settings',$data, 'setting_name = \'allow_local_login\'');
		}
		
		function update_bg_colour($bg_colour)
		{
			$data = array('setting_value' => $bg_colour,);
			$this->db->update('settings',$data, 'setting_name = \'bg_colour\'');
		}
		
		function add_room($room_name, $pc_count, $image, $image_tn)
		{
			$data = array('room_name' => $room_name, 'room_pc_count' => $pc_count, 'room_image' => $image, 'room_image_tn' => $image_tn);
			$this->db->insert('rooms',$data);
		}
		
		function get_room_info($room_id)
		{
			$query = $this->db->get_where('rooms',array('room_id' => $room_id));
			$result = $query->row_array();
			return $result;
		}

		function update_room($room_id, $room_name, $pc_count, $image, $image_tn)
		{
			$data = array(
                'room_name' => $room_name,
                'room_pc_count' => $pc_count,
                'room_image' => $image,
				'room_image_tn' => $image_tn
             );

 			$this->db->update('rooms', $data, "room_id = $room_id"); 
			
		}
		
		function wipebookings()
		{
			$result = $this->db->truncate('bookings');
			return $result; 
		}
		
		function get_booking_count()
		{
			$query = $this->db->get('bookings');
			return $query->num_rows();
		}
		
		function get_period_count()
		{
			$query = $this->db->get('periods');
			return $query->num_rows();
		}
		
		function add_period($period_name, $period_start, $period_end, $period_bookable)
		{
			$data = array('period_name' => $period_name, 'period_start' => $period_start, 'period_end' => $period_end, 'period_bookable' => $period_bookable);
			$this->db->insert('periods',$data);
		}
		
		function get_period_info($period_id)
		{
			$query = $this->db->get_where('periods',array('period_id' => $period_id));
			$result = $query->row_array();
			return $result;
		}
		
		function update_period($period_id, $period_name, $period_start, $period_end, $period_bookable)
		{
			$data = array(
                'period_name' => $period_name,
                'period_start' => $period_start,
                'period_end' => $period_end,
				'period_bookable' => $period_bookable
             );

 			$this->db->update('periods', $data, "period_id = $period_id"); 
			
		}
		
		function get_subject_count()
		{
			$query = $this->db->get('subjects');
			return $query->num_rows();
		}
		
		function add_subject($subject_name, $subject_use_shading, $subject_colour)
		{
			$data = array('subject_name' => $subject_name, 'subject_use_shading' => $subject_use_shading, 'subject_colour' => $subject_colour);
			$this->db->insert('subjects',$data);
		}
		
		function get_subject_info($subject_id)
		{
			$query = $this->db->get_where('subjects',array('subject_id' => $subject_id));
			$result = $query->row_array();
			return $result;
		}
		
		function update_subject($subject_id, $subject_name, $subject_use_shading, $subject_colour)
		{
			$data = array(
                'subject_name' => $subject_name,
                'subject_use_shading' => $subject_use_shading,
                'subject_colour' => $subject_colour
             );

 			$this->db->update('subjects', $data, "subject_id = $subject_id"); 
		}
}