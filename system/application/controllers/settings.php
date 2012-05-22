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
		$data['booking_count'] = $this->Settings_model->get_booking_count();				
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

		//if no rooms exist, load a view to show room add page
		
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
			$image_tn = 'no-image.png';
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

		//check to see if user selected delete images
		//if so, set image data to previous setting and submit rest
		//of info
		if ($this->input->post('deleteimage') == 1)
		{

			$room_id = $this->input->post('room_id');
			$room_name = $this->input->post('room_name');
			$pc_count = $this->input->post('pc_count');

			//get the original image filenames ready to delete the files
			$imagetemp = $this->Settings_model->get_room_info($room_id);
			$image_todel = $imagetemp['room_image'];
			$image_tn_todel = $imagetemp['room_image_tn'];
			
			//delete the files from room_images
			$del_image = 'img/room_images/'.$image_todel;
			$del_image_tn = 'img/room_images/'.$image_tn_todel;
			unlink($del_image);
			unlink($del_image_tn);
			
			
			//set the images in the DB to no-image and update all details
			$image = 'no-image.png';
			$image_tn = 'no-image.png';
			$this->Settings_model->update_room($room_id, $room_name, $pc_count, $image, $image_tn);
			
			//all done, so lets load the views	
			$this->load->view('template/header_view');
			$this->load->view('main_menu');
			$this->load->view('settings_rooms_update');

		} else {

			//otherwise carry on as normal
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

				//save and move the image and create thumbnail
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

			}

		}
		else 
		{
		   /*
			* no image was selected so just add the rest of the details
		 	* to the database and leave the image as is
		 	*/	
			$room_id = $this->input->post('room_id');
			$room_name = $this->input->post('room_name');
			$pc_count = $this->input->post('pc_count');
			$imagetemp = $this->Settings_model->get_room_info($room_id);
			$image = $imagetemp['room_image'];
			$image_tn = $imagetemp['room_image_tn'];
			$this->Settings_model->update_room($room_id, $room_name, $pc_count, $image, $image_tn);
			
			//load the views
			$this->load->view('template/header_view');
			$this->load->view('main_menu');
			$this->load->view('settings_rooms_update');

		}
		}
	}
	
	function deleteallbookings()
	{
		$this->load->model('Settings_model');
		$result['success'] = $this->Settings_model->wipebookings();
		$this->load->view('template/header_view');
		$this->load->view('main_menu');
		$this->load->view('delete_all_bookings_result', $result);
	}
	
	function period_settings()
	{
		$this->load->model('Settings_model');
		$data['period_count'] = $this->Settings_model->get_period_count();

		//if no periods exist, load a view to show period add page
		
		if ($data['period_count'] == 0)
		{
			$this->load->view('template/header_view');
			$this->load->view('main_menu');
			$this->load->view('settings_periods_add', array('error' => ' ' ));
		} else 
		//else get the list of periods in the database, order them
		//by period_start ascending and show them
		{
			$query = $this->db->order_by('period_start', 'asc')->get('periods');
			$result = $query->result_array();
			$data['periods'] = $result;
		
			$this->load->view('template/header_view');
			$this->load->view('main_menu');
			$this->load->view('settings_periods_edit',$data);

		}
	}
	
	function submit_new_period()
	{
		$this->load->model('Settings_model');
		//update the database with the details given
		$period_name = $this->input->post('period_name');
		$period_start = $this->input->post('period_start');
		$period_end = $this->input->post('period_end');
		$period_bookable = $this->input->post('period_bookable');
		$this->Settings_model->add_period($period_name, $period_start, $period_end, $period_bookable);
			
		//then load the views
		$this->load->view('template/header_view');
		$this->load->view('main_menu');
		$this->load->view('settings_periods_update');
	}
	
	function edit_period()
	{
		$this->load->model('Settings_model');
		$period_id = $this->uri->segment(3);
		$data = $this->Settings_model->get_period_info($period_id);
		$this->load->view('template/header_view');
		$this->load->view('main_menu');
		$this->load->view('edit_period', $data);
	}
	
	function update_period()
	{
		$this->load->model('Settings_model');
		$period_id = $this->input->post('period_id');
		
		$periodtimes = $this->Settings_model->get_period_info($period_id);
		
		$period_name = $this->input->post('period_name');
		$period_start = $periodtimes['period_start'];
		$period_end = $periodtimes['period_end'];
		$period_bookable = $this->input->post('period_bookable');
		$this->Settings_model->update_period($period_id, $period_name, $period_start, $period_end, $period_bookable);
		
		//load the views
		$this->load->view('template/header_view');
		$this->load->view('main_menu');
		$this->load->view('settings_periods_update');
	}
	
	function add_period()
	{
		$this->load->model('Settings_model');
		$this->load->view('template/header_view');
		$this->load->view('main_menu');
		$this->load->view('settings_periods_add', array('error' => ' ' ));
	}
	
	function subject_settings()
	{
		$this->load->model('Settings_model');
		$data['subject_count'] = $this->Settings_model->get_subject_count();

		//if no subjects exist, load a view to show subject add page
		
		if ($data['subject_count'] == 0)
		{
			$this->load->view('template/header_view');
			$this->load->view('main_menu');
			$this->load->view('settings_subjects_add', array('error' => ' ' ));
		} else 

		//else get the list of subjects in the database and show them
		{
			$query = $this->db->get('subjects');
			$result = $query->result_array();
			$data['subjects'] = $result;
		
			$this->load->view('template/header_view');
			$this->load->view('main_menu');
			$this->load->view('settings_subjects_edit',$data);
		}
	}
	
	function submit_new_subject()
	{
		$this->load->model('Settings_model');
		//update the database with the details given
		$subject_name = $this->input->post('subject_name');
		$subject_use_shading = $this->input->post('subject_use_shading');
		$subject_colour = $this->input->post('subject_colour');
		$this->Settings_model->add_subject($subject_name, $subject_use_shading, $subject_colour);
			
		//then load the views
		$this->load->view('template/header_view');
		$this->load->view('main_menu');
		$this->load->view('settings_subjects_update');
	}
	
	function edit_subject()
	{
		$this->load->model('Settings_model');
		$subject_id = $this->uri->segment(3);
		$data = $this->Settings_model->get_subject_info($subject_id);
		$this->load->view('template/header_view');
		$this->load->view('main_menu');
		$this->load->view('edit_subject', $data);
	}
	
	function update_subject()
	{
		$this->load->model('Settings_model');
		$subject_id = $this->input->post('subject_id');
		$subject_name = $this->input->post('subject_name');
		$subject_use_shading = $this->input->post('subject_use_shading');
		$subject_colour = $this->input->post('subject_colour');
		
		$this->Settings_model->update_subject($subject_id, $subject_name, $subject_use_shading, $subject_colour);
		
		//load the views
		$this->load->view('template/header_view');
		$this->load->view('main_menu');
		$this->load->view('settings_subjects_update');
	}
	
	function add_subject()
	{
		$this->load->model('Settings_model');
		$this->load->view('template/header_view');
		$this->load->view('main_menu');
		$this->load->view('settings_subjects_add', array('error' => ' ' ));
	}
	
}