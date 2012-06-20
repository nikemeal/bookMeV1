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
			 	
			 	//add an entry to the block_bookings table with some info on the booking
			 	$active_year = $this->Settings_model->get_active_year();
			 	$year_id = $active_year['0']['year_id'];
			 	$block_array = array
				 	(
				 		'subject_id' => $subject_id,
				 		'booking_classname' => $booking_classname,
				 		'year_id' => $year_id
				 	);
			 	$this->db->insert('block_bookings',$block_array);
			 	
			 	//get the id from that insert to use in the main booking
			  	$block_booking_id = $this->db->insert_id();
			 	$booking_isblock = '1';
			 	
			 	//create date objects for the booking date and end of year date
			 	$booking_date = date_create($booking_date);
			 	$end_date = date_create($active_year['0']['year_end']);

			 	while ($booking_date <= $end_date)
				{
					//convert the booking date to a string, add it to the 
					//booking table and increase the date by 7 days
					$date_to_add = $booking_date->format('Y-m-d');
					$this->Booking_model->add_booking($subject_id, $period_id, $room_id, $booking_username, $booking_displayname, $booking_classname, $date_to_add, $booking_isblock, $block_booking_id);
					date_add($booking_date, date_interval_create_from_date_string('7 days'));
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
	
	function process_delete_booking()
	{
		//this is the page the user came from, so we can send them back there when done
		$data['previous_url'] = $_POST['url'];
		
		//lets check how many cells have been selected
		$initialcount = count($_POST);

		//if there are no cells selected (user possibly hit button by mistake) 
		//show error modal and return them to previous page
		if ($initialcount == '1')
		{
			$data['error_reason'] = "no bookings selected";
			$this->load->view('booking/booking_error', $data);
		}
		
		//if there is at least 1 booking, we carry on
		elseif ($initialcount > '1')
		{
			//now we know there are cells selected we can count them
			$deletecount = count($_POST['booking']);
			
			//if there is more than one cell selected, throw an error
			//as we don't want multiple deletions taking place
			if ($deletecount > 1)
			{
				$data['error_reason'] = "multiple cells selected";
				$this->load->view('booking/booking_error', $data);	
			}
			//if there is only one cell selected, we can continue
			else
			{
				//check to see if the selected cell is bookable
				if ($_POST['booking']['0']['bookable'])
				{
					//if it is, tell the user they cannot delete
					//empty cells!
					$data['error_reason'] = "cell is empty";
					$this->load->view('booking/booking_error', $data);
				}
				else 
				{
					//cell is not empty, so we carry on
					//now we need to get details of the selected cell
					$booking_id = $_POST['booking']['0']['booking_id'];
					$booking = $this->Booking_model->get_single_booking_info($booking_id);
					
					//is the booking a single booking or part of a block booking
					
					//this is a single booking
					if (!($booking['0']['booking_isblock']))
					{
						//check if the username of the booking and the username logged
						//in are the same, or if the username logged in is an admin
						
						//if username and session name match or admin is logged in
						if ($booking['0']['booking_username'] == $this->session->userdata('username') || $this->session->userdata('accesslevel') == "admin")
						{
							//show booking delete form with info 
							$data['classname'] = $booking['0']['booking_classname'];
							$data['username'] = $booking['0']['booking_username'];
							$data['displayname'] = $booking['0']['booking_displayname'];
							$periodname = $this->Settings_model->get_period_info($booking['0']['period_id']);
							$data['periodname'] = $periodname['period_name'];
							$roomname = $this->Settings_model->get_room_info($booking['0']['room_id']);
							$data['roomname'] = $roomname['room_name'];
							$subjectname = $this->Settings_model->get_subject_info($booking['0']['subject_id']);
							$data['subjectname'] = $subjectname['subject_name'];
							$data['prettydate'] = $this->Booking_model->get_pretty_date($booking['0']['booking_date']);
							$data['booking_id'] = $booking_id;
							$data['delete_type'] = "single";
							$this->load->view('booking/booking_delete', $data);
						}
						else 
						{
							$data['error_reason'] = "not your booking";
							$this->load->view('booking/booking_error', $data);
						}
					}
					else 
					{
						//this is a block booking
						if ($this->session->userdata('accesslevel') !== "admin")
						{
							//if the user isn't an admin, error out as we don't
							//want non admin users delete block bookings
							$data['error_reason'] = "not admin block delete";
							$this->load->view('booking/booking_error', $data);
						}
						else 
						{
							//the user is an admin, so we can now check if they want 
							//to delete an instance or the whole 
							$data['classname'] = $booking['0']['booking_classname'];
							$data['username'] = $booking['0']['booking_username'];
							$data['displayname'] = $booking['0']['booking_displayname'];
							$periodname = $this->Settings_model->get_period_info($booking['0']['period_id']);
							$data['periodname'] = $periodname['period_name'];
							$roomname = $this->Settings_model->get_room_info($booking['0']['room_id']);
							$data['roomname'] = $roomname['room_name'];
							$subjectname = $this->Settings_model->get_subject_info($booking['0']['subject_id']);
							$data['subjectname'] = $subjectname['subject_name'];
							$data['prettydate'] = $this->Booking_model->get_pretty_date($booking['0']['booking_date']);
							$data['booking_id'] = $booking_id;
							$data['delete_type'] = "block";
							$this->load->view('booking/booking_delete', $data);
						}
					}
				}
				
			}
			
		}
		
	}
	
	function delete_booking()
	{
		$previous_url = $_POST['previous_url'];
		
		//first we need to check what type of booking is being returned from the
		//booking_delete view
		
		//if single, remove that single entry from the bookings table
		if ($_POST['delete_type'] == "single" || $_POST['delete_type'] == "block-single")
		{
			$booking_id = $_POST['booking_id'];
			$this->Booking_model->delete_single_booking($booking_id);
			redirect($previous_url, 'refresh');
		}
		elseif ($_POST['delete_type'] == "block-all")
		{
			//delete the whole block booking and block_booking_id
			$booking_id = $_POST['booking_id'];
			$booking = $this->Booking_model->get_single_booking_info($booking_id);
			$block_booking_id = $booking['0']['block_booking_id'];
			
			$this->Booking_model->delete_block_booking($block_booking_id);
			redirect($previous_url, 'refresh');
		}
	}
	
function process_edit_booking()
	{
		//this is the page the user came from, so we can send them back there when done
		$data['previous_url'] = $_POST['url'];
		
		//lets check how many cells have been selected
		$initialcount = count($_POST);

		//if there are no cells selected (user possibly hit button by mistake) 
		//show error modal and return them to previous page
		if ($initialcount == '1')
		{
			$data['error_reason'] = "no bookings selected";
			$this->load->view('booking/booking_error', $data);
		}
		
		//if there is at least 1 booking, we carry on
		elseif ($initialcount > '1')
		{
			//now we know there are cells selected we can count them
			$deletecount = count($_POST['booking']);
			
			//if there is more than one cell selected, throw an error
			//as we don't want multiple deletions taking place
			if ($deletecount > 1)
			{
				$data['error_reason'] = "multiple cells selected";
				$this->load->view('booking/booking_error', $data);	
			}
			//if there is only one cell selected, we can continue
			else
			{
				//check to see if the selected cell is bookable
				if ($_POST['booking']['0']['bookable'])
				{
					//if it is, tell the user they cannot delete
					//empty cells!
					$data['error_reason'] = "cell is empty";
					$this->load->view('booking/booking_error', $data);
				}
				else 
				{
					//cell is not empty, so we carry on
					//now we need to get details of the selected cell
					$booking_id = $_POST['booking']['0']['booking_id'];
					$booking = $this->Booking_model->get_single_booking_info($booking_id);
					
					//is the booking a single booking or part of a block booking
					
					//this is a single booking
					if (!($booking['0']['booking_isblock']))
					{
						//check if the username of the booking and the username logged
						//in are the same, or if the username logged in is an admin
						
						//if username and session name match or admin is logged in
						if ($booking['0']['booking_username'] == $this->session->userdata('username') || $this->session->userdata('accesslevel') == "admin")
						{
							//show booking edit form with info already filled in
							$data['classname'] = $booking['0']['booking_classname'];
							$data['username'] = $booking['0']['booking_username'];
							$data['displayname'] = $booking['0']['booking_displayname'];
							$subjectname = $this->Settings_model->get_subject_info($booking['0']['subject_id']);
							$subject = $subjectname['subject_name'];
							//we now need to get a list of the subjects, with the one in the booking
							//at the top of the list
							$query = $this->db->query
							("
							SELECT subjects.subject_id, subjects.subject_name
							FROM subjects
							ORDER BY CASE subject_name
							WHEN ".$this->db->escape($subject)."
							THEN 1 
							ELSE 4 
							END 
							");
							$data['subjects'] = $query->result_array();
							$data['booking_id'] = $booking_id;
							$data['bookingtype'] = "single";
							$this->load->view('booking/booking_edit', $data);
						}
						else 
						{
							$data['error_reason'] = "not your booking";
							$this->load->view('booking/booking_error', $data);
						}
					}
					else 
					{
						//this is a block booking
						if ($this->session->userdata('accesslevel') !== "admin")
						{
							//if the user isn't an admin, error out as we don't
							//want non admin users editing block bookings
							$data['error_reason'] = "not admin block delete";
							$this->load->view('booking/booking_error', $data);
						}
						else 
						{
							//the user is an admin, so we can now check if they want 
							//to edit an instance or the whole 
							$data['classname'] = $booking['0']['booking_classname'];
							$data['username'] = $booking['0']['booking_username'];
							$data['displayname'] = $booking['0']['booking_displayname'];
							$subjectname = $this->Settings_model->get_subject_info($booking['0']['subject_id']);
							$subject = $subjectname['subject_name'];
							//we now need to get a list of the subjects, with the one in the booking
							//at the top of the list
							$query = $this->db->query
							("
							SELECT subjects.subject_id, subjects.subject_name
							FROM subjects
							ORDER BY CASE subject_name
							WHEN ".$this->db->escape($subject)."
							THEN 1 
							ELSE 4 
							END 
							");
							$data['subjects'] = $query->result_array();
							$data['booking_id'] = $booking_id;
							$data['bookingtype'] = "block";
							$this->load->view('booking/booking_edit', $data);
						}
					}
				}
				
			}
			
		}
		
	}
	
	function edit_booking()
	{
		$previous_url = $_POST['previous_url'];
		
		$booking_classname = $_POST['booking_classname'];
		$subject_id = $_POST['subject_id'];
		$booking_username = $_POST['booking_username'];
		$booking_displayname = $_POST['booking_displayname'];
		$booking_id = $_POST['booking_id'];
		
		//first we need to check what type of booking is being returned from the
		//booking_edit view
		
		//if single, edit that single entry from the bookings table
		if ($_POST['edit_type'] == "single")
		{
			$this->Booking_model->edit_single_booking($booking_id, $booking_classname, $subject_id, $booking_username, $booking_displayname);
			redirect($previous_url, 'refresh');
		}
		elseif ($_POST['edit_type'] == "block")
		{
			//edit the whole block booking and block_booking_id
			$booking = $this->Booking_model->get_single_booking_info($booking_id);
			$block_booking_id = $booking['0']['block_booking_id'];
			
			$this->Booking_model->edit_block_booking($booking_classname, $subject_id, $booking_username, $booking_displayname, $block_booking_id);
			redirect($previous_url, 'refresh');
		}
	}
}