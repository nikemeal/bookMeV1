<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Booking extends CI_Controller 
{
	/**
	 * Index Page for the site which will load
	 * the main view for staff and the additional
	 * menu items for admin users such as
	 * block bookings and settings
	 */
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('Settings_model');
		$this->load->view('template/header_view', array( 'bg_colour' => $this->Settings_model->get_bg_colour()));
		$this->load->view('main_menu', array( 'school_name' => $this->Settings_model->get_school_name()));
	}
	
	/*
	 * as and when bookings controller is tidied up and separated out, the following views need to be edited too:
	 * main_body_booking.php -> a href link changed to reflect subfolder/class 
	 */
	
	function index()
	{
		echo "Index function of bookings";
	}

function booking_room_overview($room_id=1, $date='')
	{
	
		$this->load->model('Booking_model');
		$this->load->model('Settings_model');
		if ($date == '') 
		{
			// If todays date is a Wednesday, we still need to show the start of the week
			// i.e. Monday - this code does that
			$data['date'] = date('Y-m-d', mktime(0,0,0,date('m'), date('d')-date('w')+1, date('Y')));
			
			// Also need to add 7 days onto this to get the last day of the week
			$enddate = date('Y-m-d', mktime(0,0,0,date('m'), date('d')-date('w')+7, date('Y')));
		}
		
		// A date has been given (through the URL). We need to split this down, find the start
		// of the week for the given date and then piece it all back together
		else 
		{
			// Split the given date down into day, month, and year values
			list($year,$month,$day) = explode('-', $date);
			
			// Our temporary date is used to find out the day number of the chosen date
			// i.e. Friday return number 5
			$tmpdate = new DateTime($date);
			$dayname = $tmpdate->format('w');
			
			// Piece together the date, changing the date to that of the start of the week
			$data['date'] = date('Y-m-d', mktime(0,0,0,$month, $day-$dayname+1, $year));
			
			// Also, we need the date for the last day of the week too
			$enddate = date('Y-m-d', mktime(0,0,0,$month, $day-$dayname+7, $year));
		}
		
		//get the first day of the week and give it a readable format to display
		$arr =explode("-",$data['date']);
 		$arr=array_reverse($arr);
 		$displayday = $arr['0'];
		$displaymonth = $arr['1'];
		$displayyear = $arr['2'];
		$data['week_commencing'] = date('jS \o\f F Y', mktime(0,0,0,$displaymonth, $displayday, $displayyear));
 		
		$data['room_id'] = $room_id;
		$data['periods'] = $this->Settings_model->get_all_periods();
		$data['datepicker'] = $date;
		
		// in future the block bookings won't be added as a single item so 
		// the checks done for what a block booking is will need to change
		$data['bookings'] = $this->Booking_model->get_bookings($room_id,$data['date'],$enddate);
		
		// Load the view passing in all collected data

		$this->load->view('booking/booking_room_overview', $data);

	}
	
	function make_booking()
	{
		
		foreach ($_GET as $booking1)
		{
			foreach ($booking1 as $booking)
			{
				echo "Period : " . $booking['period'];
				echo "<br>";
				echo "Day : " . $booking['day'];
				echo "<br><br>";
			}
		}
	}
}