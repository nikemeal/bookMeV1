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
		$this->load->model('Booking_model');
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
	
	function process_booking()
	{
		//this is the URL they came from, and will be used to redirect
		//back to after success or an error
		$data['previous_url'] = $_POST['url'];
		
		// check booking count
		$initialcount = count($_POST);

		//if there are no bookings (user possibly hit button by mistake) 
		//show error modal and return them to previous page
		if ($initialcount == '1')
		{
			$data['error_reason'] = "no period selected";
			$this->load->view('booking/booking_error', $data);
		}
		
		//if there is at least 1 booking, we carry on
		elseif ($initialcount > '1')
		{
			
			//now we know there are actual bookings we can count them
			$bookingcount = count($_POST['booking']);
			
			//if only one period is to be booked
			if ($bookingcount == '1')
			{
				foreach ($_POST['booking'] as $bookings)
				{
					//if the period selected has already been booked
					//load the error page and explain this
					if ($bookings['bookable'] == 0)
					{
						$data['error_reason'] = "period already booked";
						$this->load->view('booking/booking_error', $data);
					}
					else 
					{
						//period is bookable, so now we will get the details of 
						//the booking then load the booking form view
						
						//lets get the data in a printable format as well as the IDs
 						$period = $this->Settings_model->get_period_info($bookings['period']);
						$room = $this->Settings_model->get_room_info($bookings['room']);
 						$data['bookingperiod'] = $period['period_name'];
 						$data['period_id'] = $period['period_id'];
 						$data['bookingroom'] = $room['room_name'];
 						$data['room_id'] = $room['room_id'];
 						$data['bookingdate'] = $this->Booking_model->get_pretty_date($bookings['date']);
 						$data['bookingdayname'] = $this->Booking_model->get_dayname($bookings['day']);
						$this->load->view('booking/booking_form', $data);
					}

				}	
			}
			else 
			{
				//functions here for multibookings
			}
			
				
				
		
			
		}
	}
}