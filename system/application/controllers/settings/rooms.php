<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rooms extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('Settings_model');
		$this->load->view('template/header_view', array( 'bg_colour' => $this->Settings_model->get_bg_colour()));
		$this->load->view('main_menu', array( 'school_name' => $this->Settings_model->get_school_name()));
		
	}
	
	function index()
	{

	}
	
function room_settings()
	{
		$this->load->model('Main_model');
		$data['room_count'] = $this->Main_model->get_room_count();

		//if no rooms exist, load a view to show room add page
		if ($data['room_count'] == 0)
		{
			$this->load->view('settings/settings_rooms_add', array('error' => ' ' ));
		} else 
		//else get the list of rooms in the database and show them
		{
			$query = $this->db->order_by('room_name', 'asc')->get('rooms');
			$result = $query->result_array();
			$data['rooms'] = $result;

			$this->load->view('settings/settings_rooms_edit',$data);
		}
	}
	
	function submit_new_room()
	{
		$this->load->model('Main_model');
		//set data to be used if picture is uploaded
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
			$this->load->view('settings/settings_rooms_add', $error);
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
			
			//then load the view
			$this->load->view('settings/settings_rooms_update');
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
			$image = 'no-image.png';
			$image_tn = 'no-image.png';
			$this->Settings_model->add_room($room_name, $pc_count, $image, $image_tn);
			
			//load the view
			$this->load->view('settings/settings_rooms_update');
		}
	}
	
	function add_room()
	{
		$this->load->view('settings/settings_rooms_add', array('error' => ' ' ));
	}
	
	function edit_room()
	{
		$room_id = $this->uri->segment(4);
		$data = $this->Settings_model->get_room_info($room_id);
		$this->load->view('settings/edit_room', $data);
	}
	
	function update_room()
	{
		$this->load->model('Main_model');

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
			
			//all done, so lets load the view
			$this->load->view('settings/settings_rooms_update');

		} else {

			//otherwise set upload data for image
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
				$this->load->view('settings/settings_rooms_add', $error);
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
			
				//then load the view
				$this->load->view('settings/settings_rooms_update');
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
			
			//load the view
			$this->load->view('settings/settings_rooms_update');
		}
		}
	}
	
	function room_delete()
	{
		$this->load->model('Main_model');
		$room_id = $this->uri->segment(4);
		$query = $this->db->delete('rooms', array('room_id' => $room_id)); 
		$this->load->view('settings/settings_rooms_update');	
	}

}