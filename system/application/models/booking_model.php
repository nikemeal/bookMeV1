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
	
	function get_dayname($day_id)
	{
		if ($day_id == 0)
		{
			$result = "Monday";
		}  
		elseif ($day_id == 1)
		{
			$result = "Tuesday";
		} 
		elseif ($day_id == 2)
		{
			$result = "Wednesday";
		} 
		elseif ($day_id == 3)
		{
			$result = "Thursday";
		} 
		elseif ($day_id == 4)
		{
			$result = "Friday";
		} 
		return $result;
	}
	
	function get_pretty_date($date)
	{
		$arr =explode("-",$date);
 		$displayday = $arr['2'];
		$displaymonth = $arr['1'];
		$displayyear = $arr['0'];
		$result = date('jS F Y', mktime(0,0,0,$displaymonth, $displayday, $displayyear));
		return $result;
	}
	
	function get_roomname($room_id)
	{
		$query = $this->db->get_where('rooms', "room_id = $room_id");
		$row = $query->row_array();
		$result = $row['room_name'];
		return $result;
	}
	
	function add_booking($subject_id, $period_id, $room_id, $booking_username, $booking_displayname, $booking_classname, $booking_date, $booking_isblock='0', $block_booking_id=null)
	{
		$data = array(
		'subject_id' => $subject_id,
		'period_id' => $period_id,
		'room_id' => $room_id,
		'booking_username' => $booking_username,
		'booking_displayname' => $booking_displayname,
		'booking_classname' => $booking_classname,
		'booking_date' => $booking_date,
		'booking_isblock' => $booking_isblock,
		'block_booking_id' => $block_booking_id
		);
		$result = $this->db->insert('bookings',$data);
		return $result;
	}
	
	function get_single_booking_info($booking_id)
	{
		$query = $this->db->get_where('bookings', "booking_id = $booking_id");
		$result = $query->result_array();
		return $result;
	}
	
	function delete_single_booking($booking_id)
	{
		$this->db->delete('bookings', array('booking_id' => $booking_id)); 
	}
	
	function delete_block_booking($block_booking_id)
	{
		$this->db->delete('bookings', array('block_booking_id' => $block_booking_id));
		$this->db->delete('block_bookings', array('block_booking_id' => $block_booking_id));
	}
	
	function edit_single_booking($booking_id, $booking_classname, $subject_id, $booking_username, $booking_displayname)
	{
		$data = array(
                'booking_classname' => $booking_classname,
                'subject_id' => $subject_id,
                'booking_username' => $booking_username,
                'booking_displayname' => $booking_displayname
             );
 
		$this->db->where('booking_id', $booking_id);
 		$this->db->update('bookings', $data); 
	}
	
	function edit_block_booking($booking_classname, $subject_id, $booking_username, $booking_displayname, $block_booking_id)
	{
		$data = array(
                'booking_classname' => $booking_classname,
                'subject_id' => $subject_id,
                'booking_username' => $booking_username,
                'booking_displayname' => $booking_displayname
             );
 		$this->db->where('block_booking_id', $block_booking_id);
 		$this->db->update('bookings', $data);
 		
 		$data = array(
 				'booking_classname' => $booking_classname,
                'subject_id' => $subject_id
 			);
 		$this->db->where('block_booking_id', $block_booking_id);
 		$this->db->update('block_bookings', $data);
	}
	
	function get_all_holidays()
	{
		$query = $this->db->get('holidays');
		$result = $query->result_array();
		return $result;
	}
}