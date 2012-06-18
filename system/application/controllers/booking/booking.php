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
 						$data['booking_period'] = $period['period_name'];
 						$data['period_id'] = $period['period_id'];
 						$data['booking_room'] = $room['room_name'];
 						$data['room_id'] = $room['room_id'];
 						$data['booking_date'] = $bookings['date'];
 						$data['prettydate'] = $this->Booking_model->get_pretty_date($bookings['date']);
 						$data['booking_dayname'] = $this->Booking_model->get_dayname($bookings['day']);
 						$data['booking_type'] = "single";
						$this->load->view('booking/booking_form', $data);
					}

				}	
			}
			else 
			{
				/*
				 * 1. get list of bookings
				 * 2. check to see if any are already booked - if so, fail with error
				 * 3. if all are ok, add each to new [booking] array with $count number
				 * 4. pass new array to $data to load into page
				 */
				$count = '1';
				foreach ($_POST['booking'] as $bookings)
				{
					//first lets check to see if any periods selected are already booked
					if ($bookings['bookable'])
					{
						$period = $this->Settings_model->get_period_info($bookings['period']);
						$room = $this->Settings_model->get_room_info($bookings['room']);
 						$data['bookings'][$count]['booking_period'] = $period['period_name'];
 						$data['bookings'][$count]['period_id'] = $period['period_id'];
 						$data['bookings'][$count]['booking_room'] = $room['room_name'];
 						$data['bookings'][$count]['room_id'] = $room['room_id'];
 						$data['bookings'][$count]['booking_date'] = $bookings['date'];
 						$data['bookings'][$count]['prettydate'] = $this->Booking_model->get_pretty_date($bookings['date']);
 						$data['bookings'][$count]['booking_dayname'] = $this->Booking_model->get_dayname($bookings['day']);
 						$count = $count + 1;
					}
					else 
					{
						$data['error_reason'] = "period already booked";
						$this->load->view('booking/booking_error', $data);	
					}
					
 					
				}
				$data['booking_type'] = "multi";
				$this->load->view('booking/booking_form_multi', $data);
			}
		}
	}
	
	function add_booking()
	{
		//we need to check if this is a single booking or a multi booking
		if ($_POST['booking_type'] == "single")
		{
			//set all the variables we'll need first
			$subject_id = $_POST['subject_id'];
			$period_id = $_POST['period_id'];
			$room_id = $_POST['room_id'];
			$booking_username = $_POST['booking_username'];
			$booking_displayname = $_POST['booking_displayname'];
			$booking_classname = $_POST['booking_classname'];
			$booking_date = $_POST['booking_date'];
			$previous_url = $_POST['previous_url'];
			
			//if this is a single booking, and is not a block booking
			if (!isset($_POST['booking_isblock']))
			{
				//add the booking with all the relevant data
				$this->Booking_model->add_booking($subject_id, $period_id, $room_id, $booking_username, $booking_displayname, $booking_classname, $booking_date);
				//redirect back to the booking_overview page they came from
				redirect($previous_url, 'refresh');
			 }
			 else 
			 {
			 	//this is a block booking
			 	
			 	/*
			 	
	
			 	 * 3. add the booking, using the block_booking id in the normal booking
			 	 */
			 	//add an entry to the block_bookings table with some info on the booking
			 	$block_array = array
				 	(
				 		'subject_id' => $subject_id,
				 		'booking_classname' => $booking_classname
				 	);
			 	$this->db->insert('block_bookings',$block_array);
			 	//get the id from that insert to use in the main booking
			  	$block_booking_id = $this->db->insert_id();
			 	$booking_isblock = '1';
			 	for ($i=0; $i == 60; $i++)
				{
					$this->Booking_model->add_booking($subject_id, $period_id, $room_id, $booking_username, $booking_displayname, $booking_classname, $booking_date, $booking_isblock, $block_booking_id);
				}
			 	 	
			 	//redirect back to the booking_overview page they came from
				redirect($previous_url, 'refresh');
			 }
		}
		else
		{
			//this is a multi booking, so we'll loop through the bookings and add
			//each one in turn
			foreach($_POST['booking'] as $booking)
			{
				$subject_id = $_POST['subject_id'];
				$period_id = $booking['period_id'];
				$room_id = $booking['room_id'];
				$booking_username = $booking['booking_username'];
				$booking_displayname = $booking['booking_displayname'];
				$booking_classname = $_POST['booking_classname'];
				$booking_date = $booking['booking_date'];
				$this->Booking_model->add_booking($subject_id, $period_id, $room_id, $booking_username, $booking_displayname, $booking_classname, $booking_date);
			}
			//redirect back to the booking_overview page they came from
			$previous_url = $_POST['previous_url'];
			redirect($previous_url, 'refresh');
		}
	}
}