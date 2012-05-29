<?php
			
class Booking_model extends CI_Model {
 
	
	function __construct()
	{
		parent::__construct();
	}
		
	function get_bookings($room_id,$startdate,$enddate)
	{
		// First we check for all bookings of the chosen room_id, that fall in the timescale
		// of the week being viewed (don't return them without dates as this could return
		// thousands of records for no reason)
		// We also check for any bookings in the database that are block booked
		// and that also match the id of the room (no good returning bookings for another item)
		$query = $this->db->query('
			SELECT booking_id, bookings.subject_id, subjects.subject_name, bookings.period_id, periods.period_name, bookings.room_id, rooms.room_name, booking_username, booking_displayname, booking_classname, booking_isblock, booking_date, subjects.subject_colour, subjects.subject_use_shading
			FROM bookings
			LEFT JOIN subjects ON bookings.subject_id = subjects.subject_id
			LEFT JOIN periods ON bookings.period_id = periods.period_id
			LEFT JOIN rooms ON bookings.room_id = rooms.room_id
			WHERE bookings.room_id =\''.$room_id.'\'
		');
		return $query->result_array();
	}
	
}