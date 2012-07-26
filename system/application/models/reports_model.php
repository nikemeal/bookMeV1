<?php
			
class Reports_model extends CI_Model {
 
	
	function __construct()
	{
		parent::__construct();
	}
		
	function room_report_by_dept($room_id, $date_from, $date_to)
	{
		$query = $this->db->query("
			SELECT subjects.subject_name AS Subject, COUNT(*)AS Count
			FROM bookings
			LEFT JOIN Subjects ON bookings.subject_id = subjects.subject_id
			WHERE booking_isblock = 1
			AND room_id = '".$room_id."'
			AND booking_date >='".$date_from."'
			AND booking_date <='".$date_to."'
			GROUP BY subjects.subject_name
			ORDER BY Count DESC
		");
		return $query->result_array();
	}
	
	function room_report_by_dept_count($room_id, $date_from, $date_to)
	{
		$query = $this->db->query("
			SELECT COUNT(*)AS Count
			FROM bookings
			WHERE booking_isblock = 1
			AND room_id = '".$room_id."'
			AND booking_date >='".$date_from."'
			AND booking_date <='".$date_to."'
		");
		return $query->row_array();
	}
	
	function room_report_by_user($room_id, $date_from, $date_to)
	{
		$query = $this->db->query("
			SELECT booking_displayname AS Name, subjects.subject_name AS Subject, COUNT(*)AS Count
			FROM bookings
			LEFT JOIN Subjects ON bookings.subject_id = subjects.subject_id
			WHERE booking_isblock = 1
			AND room_id = '".$room_id."'
			AND booking_date >='".$date_from."'
			AND booking_date <='".$date_to."'
			GROUP BY Name, Subject
			ORDER BY Count DESC
		");
		return $query->result_array();
	}
	
	
}