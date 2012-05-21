<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends CI_Controller 
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
		$this->load->model('settings_model');
		$this->load->view('template/header_view');
		$this->load->view('main_menu');
	}
	
	function general_settings()
	{
		$this->load->model('Settings_model');
		/*
		 * get the settings from the database and pass them to the general
		 * settings view
		 */
		$data['school_name'] = $this->Settings_model->get_school_name();
		$data['bookme_version'] = $this->Settings_model->get_bookme_version();
		$data['allow_local_login'] = $this->Settings_model->get_allow_local_login();
		$data['bg_colour'] = $this->Settings_model->get_bg_colour();				
		$this->load->view('template/header_view');
		$this->load->view('main_menu');
		
		//load body with data
		$this->load->view('settings_general', $data);
	}
	
	function submit_general_settings()
	{
		$this->load->model('Settings_model');
		$school_name = $this->input->post('school_name');
		$allow_local_login = $this->input->post('allow_local_login');
		$bg_colour = $this->input->post('bg_colour');
		$this->Settings_model->update_school_name($school_name);
		$this->Settings_model->update_allow_local_login($allow_local_login);
		$this->Settings_model->update_bg_colour($bg_colour);
		/*
		 * need some form of error checking to see if all DB updates were successful.
		 * if not then load an error page detailing why, otherwise load the relevant 
		 * settings update page
		 */
		$load = uri_string();
		$this->load->view('settings_general_update', $load);
	}
	
	function auth_settings()
	{
		$this->load->model('Settings_model');
		$data['ldap_server'] = $this->Settings_model->get_ldap_server();
		
		//need to test and see if two lines below are needed or can be picked up
		//when adLDAP is invoked 
		$data['ldap_account_suffix'] = $this->Settings_model->get_ldap_account_suffix();
		$data['ldap_basedn'] = $this->Settings_model->get_ldap_basedn();
		
		$data['ldap_username'] = $this->Settings_model->get_ldap_username();
		$data['ldap_password'] = $this->Settings_model->get_ldap_password();
		$data['ldap_standard_users'] = $this->Settings_model->get_ldap_standard_users();
		$data['ldap_admin_users'] = $this->Settings_model->get_ldap_admin_users();
		
		$this->load->view('template/header_view');
		$this->load->view('main_menu');
		
		//load body with data
		$this->load->view('settings_auth', $data);
	}
	
	function submit_auth_settings()
	{
		//need one here once rest of the auth settings page has been done
	}
	
	function room_settings()
	{
		$this->load->model('Main_model');
		$this->load->model('Settings_model');
		$data['room_count'] = $this->Main_model->get_room_count();

		//if no rooms exist, load a view to show button linking to room add page
		
		if ($data['room_count'] == 0)
		{
			
			$this->load->view('template/header_view');
			$this->load->view('main_menu');
			$this->load->view('settings_rooms_add', array('error' => ' ' ));
		} else 
		//else get the list of rooms in the database and show them
		{
			$query = $this->db->get('rooms');
			$result = $query->result_array();
			$data['rooms'] = $result;
		
			$this->load->view('template/header_view');
			$this->load->view('main_menu');
			$this->load->view('settings_rooms_edit',$data);
		}
	}
	
	function submit_new_room()
	{
		$this->load->model('Main_model');
		$this->load->model('Settings_model');
		$config['upload_path'] = './img/room_images/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '1024';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';

		$this->load->library('upload', $config);
	
		/*
		 * check to see if user selected an image file
		 */
		if ($_FILES['userfile']['name']!="") {
		
		/*
		 * if yes, run the following - checking other image related errors
		 */
		if ( ! $this->upload->do_upload())
		{
			/*
			 * if there is an error with the file being uploaded, return
			 * the user to the previous page with the error to be shown
			 */ 
			$error = array('error' => $this->upload->display_errors());
			$this->load->view('template/header_view');
			$this->load->view('main_menu');
			$this->load->view('settings_rooms_add', $error);
		}
			else
		{
			/*
			 * no errors with the image, carry on
			 */
			$data = array('upload_data' => $this->upload->data());	
			$imagepath = $data['upload_data']['full_path'];

			//create/move the image and create thumbnail
			$tn['image_library'] = 'gd2';
			$tn['source_image'] = $imagepath;
			$tn['new_image'] = "tn_".$data['upload_data']['file_name'];
 			$tn['create_thumb'] = FALSE;
 			$tn['maintain_ratio'] = TRUE;
 			$tn['width'] = 100;
 			$tn['height'] = 75;
 			
 			$this->load->library('image_lib', $tn); 
			$this->image_lib->resize();

			//update the database with the details given
			$room_name = $this->input->post('room_name');
			$pc_count = $this->input->post('pc_count');
			$image = $data['upload_data']['file_name'];
			$image_tn = $tn['new_image'];
			$this->Settings_model->add_room($room_name, $pc_count, $image, $image_tn);
			
			//then load the views
			$this->load->view('template/header_view');
			$this->load->view('main_menu');
			$this->load->view('settings_rooms_update');
		}

		}else 
		{
		/*
		 * no image was selected so just add the rest of the details
		 * to the database and use a generic 'no-image' picture to fill
		 * in
		 */	

			$room_name = $this->input->post('room_name');
			$pc_count = $this->input->post('pc_count');
			$image = '';
			$image_tn = 'test.png';
			$this->Settings_model->add_room($room_name, $pc_count, $image, $image_tn);
			
			//load the views
			$this->load->view('template/header_view');
			$this->load->view('main_menu');
			$this->load->view('settings_rooms_update');
		}
	}
	
	function add_room()
	{
		$this->load->model('Main_model');
		$this->load->model('Settings_model');
		$this->load->view('template/header_view');
		$this->load->view('main_menu');
		$this->load->view('settings_rooms_add', array('error' => ' ' ));
	}
	
	function edit_room()
	{
		/*
		 * need to find a way that clicking on an image will forward to here and
		 * pass through the room_id.
		 * then load a room_edit view with prefilled data and when submitted goes
		 * to a room_update function
		 */
		$this->load->model('Settings_model');
		$room_id = $this->uri->segment(3);
		
		$data = $this->Settings_model->get_room_info($room_id);

		$this->load->view('template/header_view');
		$this->load->view('main_menu');
		$this->load->view('edit_room', $data);
		
	}
	
	function update_room()
	{
		$this->load->model('Main_model');
		$this->load->model('Settings_model');
		$config['upload_path'] = './img/room_images/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '1024';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';

//check to see if user selected delete images
//if so, set image data to '' and process rest
//of info.  otherwise carry on as normal
		if ($this->input->post('deleteimage' == 1))
		{
			$room_id = $this->input->post('room_id');
			$room_name = $this->input->post('room_name');
			$pc_count = $this->input->post('pc_count');
			$image = 'no-image.png';
			$image_tn = 'no-image.png';
			$this->Settings_model->update_room($room_id, $room_name, $pc_count, $image, $image_tn);
		
			$this->load->view('template/header_view');
			$this->load->view('main_menu');
			$this->load->view('settings_rooms_update');
			echo "image delete set to yes";
		} else {
		
		
		$this->load->library('upload', $config);
	
		/*
		 * check to see if user selected an image file
		 */
		if ($_FILES['userfile']['name']!="") {
		
		/*
		 * if yes, run the following - checking other image related errors
		 */
		if ( ! $this->upload->do_upload())
		{
			/*
			 * if there is an error with the file being uploaded, return
			 * the user to the previous page with the error to be shown
			 */ 
			$error = array('error' => $this->upload->display_errors());
			$this->load->view('template/header_view');
			$this->load->view('main_menu');
			$this->load->view('settings_rooms_add', $error);
			echo "1";
		}
			else
		{
			/*
			 * no errors with the image, carry on
			 */
			$data = array('upload_data' => $this->upload->data());	
			$imagepath = $data['upload_data']['full_path'];

			//create/move the image and create thumbnail
			$tn['image_library'] = 'gd2';
			$tn['source_image'] = $imagepath;
			$tn['new_image'] = "tn_".$data['upload_data']['file_name'];
 			$tn['create_thumb'] = FALSE;
 			$tn['maintain_ratio'] = TRUE;
 			$tn['width'] = 100;
 			$tn['height'] = 75;
 			
 			$this->load->library('image_lib', $tn); 
			$this->image_lib->resize();

			//update the database with the details given
			$room_id = $this->input->post('room_id');
			$room_name = $this->input->post('room_name');
			$pc_count = $this->input->post('pc_count');
			$image = $data['upload_data']['file_name'];
			$image_tn = $tn['new_image'];
			$this->Settings_model->update_room($room_id, $room_name, $pc_count, $image, $image_tn);
			
			//then load the views
			$this->load->view('template/header_view');
			$this->load->view('main_menu');
			$this->load->view('settings_rooms_update');
			echo "2";
		}

		}else 
		{
		/*
		 * no image was selected so just add the rest of the details
		 * to the database and leave the image as is
		 */	
			$room_id = $this->input->post('room_id');
			$room_name = $this->input->post('room_name');
			$pc_count = $this->input->post('pc_count');
			$image = 'no-image.png';
			$image_tn = 'no-image.png';
			$this->Settings_model->update_room($room_id, $room_name, $pc_count, $image, $image_tn);
			
			//load the views
			$this->load->view('template/header_view');
			$this->load->view('main_menu');
			$this->load->view('settings_rooms_update');
			echo "3";
		}
	}
	}
}