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
	}
	
	function index()
	{
		echo "Index function of bookings";
	}

	function booking_room_overview()
	{
		echo "Hi from the booking overview page";
	}
	
}