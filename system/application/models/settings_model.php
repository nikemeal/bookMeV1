<?php
			
class Settings_model extends CI_Model {
 
	
		function __construct()
		{
			parent::__construct();
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
			$this->db->select('setting_value as ldap_servers from settings');
 			$this->db->where('setting_name = \'ldap_servers\'');
			$query = $this->db->get();
 			$row = $query->row_array();
			$result = $row['ldap_servers'];
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
		
		function get_all_ldap_groups($ldap_conn_info)
		{
		try 
			{
				include('adldap/adLDAP.php');
				$adldap = new adldap($ldap_conn_info);
			}
			catch (adLDAPException $e) 
			{
   				$error =  $e->getMessage();
   				return false;
   				exit();   
			}
			
			$ldap_groups = $adldap->group()->allSecurity();
			return $ldap_groups;
		}
		
		function test_ldap_settings($ldap_conn_info)
		{
			try 
			{
				include('adldap/adLDAP.php');
				$adldap = new adldap($ldap_conn_info);
			}
			catch (adLDAPException $e) 
			{
   				return $e->getMessage();
   				exit();   
			}
			return "Success";
		}
		
		function save_ldap_admin_groups($groups)
		{
			$user = '';
			// For each 'users' group chosen, stack it into a string seperated by a semi-colon
			foreach ($groups as $group) 
			{
				$user .= $group.';';
			}
			
			$data = array('setting_value' => $user);
			$this->db->update('settings',$data, 'setting_name = \'ldap_admin_users\'');
		}
		
		function save_ldap_standard_groups($groups)
		{
			$user = '';
			// For each 'users' group chosen, stack it into a string seperated by a semi-colon
			foreach ($groups as $group) 
			{
				$user .= $group.';';
			}
			
			$data = array('setting_value' => $user);
			$this->db->update('settings',$data, 'setting_name = \'ldap_standard_users\'');
		}
		
		function split_semi_colon($string)
		{
			$data = explode(';',$string);
			return $data;
		}
		
		function update_ldap_servers($ldap_servers)
		{
			$data = array('setting_value' => $ldap_servers,);
			$this->db->update('settings',$data, 'setting_name = \'ldap_servers\'');
		}
		
		function update_ldap_account_suffix($ldap_account_suffix)
		{
			$data = array('setting_value' => $ldap_account_suffix,);
			$this->db->update('settings',$data, 'setting_name = \'ldap_account_suffix\'');
		}
		function update_ldap_basedn($ldap_basedn)
		{
			$data = array('setting_value' => $ldap_basedn,);
			$this->db->update('settings',$data, 'setting_name = \'ldap_basedn\'');
		}
		function update_ldap_username($ldap_username)
		{
			$data = array('setting_value' => $ldap_username,);
			$this->db->update('settings',$data, 'setting_name = \'ldap_username\'');
		}
		function update_ldap_password($ldap_password)
		{
			$data = array('setting_value' => $ldap_password,);
			$this->db->update('settings',$data, 'setting_name = \'ldap_password\'');
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
		
		function get_users_book_ahead()
		{
			$this->db->select('setting_value as book_ahead from settings');
 			$this->db->where('setting_name = \'user_book_in_advance\'');
			$query = $this->db->get();
 			$row = $query->row_array();
			$result = $row['book_ahead'];
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
		
		function update_book_ahead($book_ahead)
		{
			$data = array('setting_value' => $book_ahead,);
			$this->db->update('settings',$data, 'setting_name = \'user_book_in_advance\'');
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
		
		function get_all_periods()
		{
			$query = $this->db->order_by('period_start', 'asc')->get('periods');
			$result = $query->result_array();
			return $result;
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
		
		function get_all_subjects()
		{
			$query = $this->db->get('subjects');
			$result = $query->result_array();
			return $result;
		}
		
		function get_holiday_count()
		{
			$query = $this->db->get('holidays');
			return $query->num_rows();
		}
		
		function add_holiday($holiday_name, $holiday_start, $holiday_end)
		{
			$data = array('holiday_name' => $holiday_name, 'holiday_start' => $holiday_start, 'holiday_end' => $holiday_end);
			$this->db->insert('holidays',$data);
		}
		
		function get_holiday_info($holiday_id)
		{
			$query = $this->db->get_where('holidays',array('holiday_id' => $holiday_id));
			$result = $query->row_array();
			return $result;
		}
		
		function update_holiday($holiday_id, $holiday_name, $holiday_start, $holiday_end)
		{
			$data = array(
                'holiday_name' => $holiday_name,
                'holiday_start' => $holiday_start,
                'holiday_end' => $holiday_end
             );

 			$this->db->update('holidays', $data, "holiday_id = $holiday_id"); 
		}
		
		function get_year_count()
		{
			$query = $this->db->get('years');
			return $query->num_rows();
		}
		
		function get_active_year()
		{
			$query = $this->db->get_where('years', "year_isactive = 1");
			$result = $query->result_array();
			return $result;
		}
		
		function add_year($year_name, $year_start, $year_end, $year_isactive)
		{
			$data = array('year_name' => $year_name, 'year_start' => $year_start, 'year_end' => $year_end, 'year_isactive' => $year_isactive);
			$this->db->insert('years',$data);
			$year_id = $this->db->insert_id();
			return $year_id;
		}
		
		function get_year_info($year_id)
		{
			$query = $this->db->get_where('years',array('year_id' => $year_id));
			$result = $query->row_array();
			return $result;
		}
		
		function update_year($year_id, $year_name, $year_start, $year_end, $year_isactive)
		{
			$data = array(
                'year_name' => $year_name,
                'year_start' => $year_start,
                'year_end' => $year_end,
				'year_isactive' => $year_isactive
             );

 			$this->db->update('years', $data, "year_id = $year_id"); 
		}
		
		
		function set_active_year($year_id)
		{
			//first we need to set all years as inactive
			$this->db->set('year_isactive', '0', FALSE); 
			$this->db->update('years');
			
			//then we need to set the selected year to active
			
			$data = array(
			'year_isactive' => '1'
			); 
			$this->db->update('years', $data, "year_id = $year_id"); 
		}
}