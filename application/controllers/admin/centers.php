<?php

class Centers extends Admin_Controller {

	function __construct()
	{		
		parent::__construct();
		$this->auth->check_access('Admin', true);
		$this->load->model(array('Center_model'));
		$this->load->helper('form');
		$this->lang->load('center');
		$this->_admin = $this->session->userdata('admin');
	}

	function index()
	{
		$data['page_title']	= lang('centers');
		$data['centers']	= $this->Center_model->get_centers();

		$this->view($this->config->item('admin_folder').'/centers', $data);
	}

	function insert_center()
	{
		if(trim($this->input->post('name')) != '' && trim($this->input->post('address'))) {
			$id = $this->input->post('id');
			$data = array(
				'name' => trim($this->input->post('name')),
				'address' => trim($this->input->post('address')),
				'phone' => trim($this->input->post('phone')),
				'active' => trim($this->input->post('active'))
			);
			$this->Center_model->insert_center($id, $data);
			if($id > 0) {
				echo json_encode(array('success' => 1, 'message' => lang('update_center_success')));
			}else{
				echo json_encode(array('success' => 1, 'message' => lang('add_center_success')));
			}
		}else{
			echo json_encode(array('success' => 0, 'message' => lang('validate_add_center')));
		}
	}

	function delete_center()
	{
		$id = $this->input->post('id');
		if($id > 0) {
			$this->Center_model->delete_center($id);
			echo json_encode(array('success' => 1, 'message' => lang('delete_success')));
		}else{
			echo json_encode(array('success' => 0, 'message' => lang('error_not_found')));
		}

	}

	function schedules()
	{
		$data['page_title']	= lang('schedules');
		$data['schedules']	= $this->Center_model->get_schedules();
		$this->view($this->config->item('admin_folder').'/schedules', $data);
	}

	function schedule_form($id)
	{
		$data['title'] 			= '';
		$data['start_date'] 	= '';
		$data['end_date'] 		= '';
		$data['active'] 		= '';
		$data['content'] 		= '';
		$data['center_id'] 		= '';
		$data['course_id'] 		= '';

		if($id > 0){
			$schedule = $this->Center_model->get_schedule($id);
			if($schedule){
				$data['title'] 			= $schedule->title;
				$data['start_date'] 	= $schedule->start_date;
				$data['end_date'] 		= $schedule->end_date;
				$data['active'] 		= $schedule->active;
				$data['content'] 		= $schedule->content;
				$data['center_id'] 		= $schedule->center_id;
				$data['course_id'] 		= $schedule->course_id;
			}
		}
		$this->form_validation->set_rules('title', 'Title', 'trim');
		$this->form_validation->set_rules('start_date', 'Start date', 'trim');

		if ($this->form_validation->run() == FALSE)
		{
			$this->view($this->config->item('admin_folder').'/schedule_form', $data);
		}
		else {
			$id 	= $this->input->post('id');
			$data 	= array(
				'title' 		=> trim($this->input->post('title')),
				'start_date' 	=> trim($this->input->post('start_date')),
				'end_date' 		=> $this->input->post('end_date'),
				'content' 		=> trim($this->input->post('content')),
				'active' 		=> $this->input->post('active'),
				'center_id' 	=> $this->input->post('center_id'),
				'course_id' 	=> $this->input->post('course_id'),
				'user_id'		=> $this->_admin->id
			);
			if($id > 0){
				$data['update_date'] = date('Y-m-d H:i:s');
			}else{
				$data['create_date'] = date('Y-m-d H:i:s');
			}
			$this->Center_model->insert_schedule($id, $data);
			redirect('/admin/centers/schedules');
		}

	}

	function delete_schedule($id)
	{
		$this->Center_model->delete_schedule($id);
	}

	function students()
	{
		$data['page_title']	= lang('schedules');
		$data['centers']	= $this->Center_model->schedules();
		$this->view($this->config->item('admin_folder').'/students', $data);
	}

	function student_form($id)
	{
		$data['title'] 			= '';
		$data['description'] 	= '';
		$data['content'] 		= '';
		$data['active'] 		= '';
		if($id > 0){
			$student = $this->Center_model->get_student($id);
			if($student){
				$data['name'] 		= $student->name;
				$data['phone'] 		= $student->phone;
				$data['phone_2'] 	= $student->phone_2;
				$data['email'] 		= $student->email;
				$data['address'] 	= $student->address;
				$data['district_id']= $student->district_id;
				$data['ward_id'] 	= $student->ward_id;
				$data['gender'] 	= $student->gender;
				$data['birthday'] 	= $student->birthday;
				$data['parent_name']= $student->parent_name;
				$data['school_id'] 	= $student->school_id;
				$data['active'] 	= $student->active;
				$data['note'] 		= $student->note;
			}
		}
		$this->form_validation->set_rules('name', 'Name', 'trim');
		$this->form_validation->set_rules('phone', 'Phone', 'trim');
		$this->form_validation->set_rules('content', 'lang:course_content', 'trim');

		if ($this->form_validation->run() == FALSE)
		{
			$this->view($this->config->item('admin_folder').'/product_form', $data);
		}
		else {
			$id 	= $this->input->post('id');
			$data 	= array(
				'name' 			=> trim($this->input->post('name')),
				'phone' 		=> trim($this->input->post('phone')),
				'phone_2' 		=> trim($this->input->post('phone_2')),
				'email' 		=> trim($this->input->post('email')),
				'address' 		=> trim($this->input->post('address')),
				'district_id' 	=> $this->input->post('district_id'),
				'ward_id' 		=> $this->input->post('ward_id'),
				'gender' 		=> trim($this->input->post('gender')),
				'birthday' 		=> trim($this->input->post('birthday')),
				'parent_name' 	=> trim($this->input->post('parent_name')),
				'school_id' 	=> $this->input->post('school_id'),
				'active' 		=> $this->input->post('active'),
				'note' 			=> trim($this->input->post('note')),
				'user_id'		=> $this->_admin->id
			);
			if($id > 0){
				$data['update_date'] = date('Y-m-d H:i:s');
			}else{
				$data['create_date'] = date('Y-m-d H:i:s');
			}
			$this->Center_model->insert_student($id, $data);
			redirect('/admin/centers/students');
		}
	}

	function delete_student($id)
	{
		$this->Center_model->delete_student($id);
	}

	function courses()
	{
		$data['page_title']	= lang('courses');
		$data['courses']	= $this->Center_model->get_courses();
		$this->view($this->config->item('admin_folder').'/courses', $data);
	}

	function course_form($id = 0)
	{
		//pr($this->input->post(), 1);
		$this->load->library('form_validation');
		$data['page_title']	= lang('courses');
		$data['id'] 			= $id;
		$data['title'] 			= '';
		$data['description'] 	= '';
		$data['content'] 		= '';
		$data['active'] 		= 1;
		if($id > 0){
			$course = $this->Center_model->get_course($id);
			if($course){
				$data['title'] 			= $course->title;
				$data['description'] 	= $course->description;
				$data['content'] 		= $course->content;
				$data['active'] 		= $course->active;
			}
		}
		$this->form_validation->set_rules('title', 'lang:course_title', 'trim|required');
		$this->form_validation->set_rules('content', 'lang:course_content', 'trim|required');

		if ($this->form_validation->run() == FALSE)
		{
			if($this->input->post('submit') == 'submit'){
				$data['title'] 			= $this->input->post('title');
				$data['description'] 	= $this->input->post('description');
				$data['content'] 		= $this->input->post('content');
			}
			$this->view($this->config->item('admin_folder').'/course_form', $data);
		}
		else {
			$data 	= array(
				'title' 		=> trim($this->input->post('title')),
				'description' 	=> trim($this->input->post('description')),
				'content' 		=> trim($this->input->post('content')),
				'active' 		=> $this->input->post('active'),
				'user_id'		=> $this->_admin->id
			);
			if($id > 0){
				$data['update_date'] = date('Y-m-d H:i:s');
			}else{
				$data['create_date'] = date('Y-m-d H:i:s');
			}
			$this->Center_model->insert_course($id, $data);
			redirect('/admin/centers/courses');
		}
		//$this->Center_model->insert_course($id, $data);
	}

	function delete_course()
	{
		$id = $this->input->post('id');
		if($id > 0) {
			$this->Center_model->delete_course($id);
			echo json_encode(array('success' => 1, 'message' => lang('delete_success')));
		}else{
			echo json_encode(array('success' => 0, 'message' => lang('error_not_found')));
		}
	}




	//basic category search
	function product_autocomplete()
	{
		$name	= trim($this->input->post('name'));
		$limit	= $this->input->post('limit');
		
		if(empty($name))
		{
			echo json_encode(array());
		}
		else
		{
			$results	= $this->Product_model->product_autocomplete($name, $limit);
			
			$return		= array();
			
			foreach($results as $r)
			{
				$return[$r->id]	= $r->name;
			}
			echo json_encode($return);
		}
		
	}
	
	function bulk_save()
	{
		$products	= $this->input->post('product');
		
		if(!$products)
		{
			$this->session->set_flashdata('error',  lang('error_bulk_no_products'));
			redirect($this->config->item('admin_folder').'/products');
		}
				
		foreach($products as $id=>$product)
		{
			$product['id']	= $id;
			$this->Product_model->save($product);
		}
		
		$this->session->set_flashdata('message', lang('message_bulk_update'));
		redirect($this->config->item('admin_folder').'/products');
	}
	
	function form($id = false, $duplicate = false)
	{
		$this->product_id	= $id;
		$this->load->library('form_validation');
		$this->load->model(array('Option_model', 'Category_model', 'Digital_Product_model'));
		$this->lang->load('digital_product');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		
		$data['categories']		= $this->Category_model->get_categories_tiered();
		$data['file_list']		= $this->Digital_Product_model->get_list();

		$data['page_title']		= lang('product_form');

		//default values are empty if the product is new
		$data['id']					= '';
		$data['sku']				= '';
		$data['name']				= '';
		$data['slug']				= '';
		$data['description']		= '';
		$data['excerpt']			= '';
		$data['price']				= '';
		$data['saleprice']			= '';
		$data['weight']				= '';
		$data['track_stock'] 		= '';
		$data['seo_title']			= '';
		$data['meta']				= '';
		$data['shippable']			= '';
		$data['taxable']			= '';
		$data['fixed_quantity']		= '';
		$data['quantity']			= '';
		$data['enabled']			= '';
		$data['related_products']	= array();
		$data['product_categories']	= array();
		$data['images']				= array();
		$data['product_files']		= array();

		//create the photos array for later use
		$data['photos']		= array();

		if ($id)
		{	
			// get the existing file associations and create a format we can read from the form to set the checkboxes
			$pr_files 		= $this->Digital_Product_model->get_associations_by_product($id);
			foreach($pr_files as $f)
			{
				$data['product_files'][]  = $f->file_id;
			}
			
			// get product & options data
			$data['product_options']	= $this->Option_model->get_product_options($id);
			$product					= $this->Product_model->get_product($id);
			
			//if the product does not exist, redirect them to the product list with an error
			if (!$product)
			{
				$this->session->set_flashdata('error', lang('error_not_found'));
				redirect($this->config->item('admin_folder').'/products');
			}
			
			//helps us with the slug generation
			$this->product_name	= $this->input->post('slug', $product->slug);
			
			//set values to db values
			$data['id']					= $id;
			$data['sku']				= $product->sku;
			$data['name']				= $product->name;
			$data['seo_title']			= $product->seo_title;
			$data['meta']				= $product->meta;
			$data['slug']				= $product->slug;
			$data['description']		= $product->description;
			$data['excerpt']			= $product->excerpt;
			$data['price']				= $product->price;
			$data['saleprice']			= $product->saleprice;
			$data['weight']				= $product->weight;
			$data['track_stock'] 		= $product->track_stock;
			$data['shippable']			= $product->shippable;
			$data['quantity']			= $product->quantity;
			$data['taxable']			= $product->taxable;
			$data['fixed_quantity']		= $product->fixed_quantity;
			$data['enabled']			= $product->enabled;
			
			//make sure we haven't submitted the form yet before we pull in the images/related products from the database
			if(!$this->input->post('submit'))
			{
				
				$data['product_categories']	= array();
				foreach($product->categories as $product_category)
				{
					$data['product_categories'][] = $product_category->id;
				}
				
				$data['related_products']	= $product->related_products;
				$data['images']				= (array)json_decode($product->images);
			}
		}
		
		//if $data['related_products'] is not an array, make it one.
		if(!is_array($data['related_products']))
		{
			$data['related_products']	= array();
		}
		if(!is_array($data['product_categories']))
		{
			$data['product_categories']	= array();
		}

		
		//no error checking on these
		$this->form_validation->set_rules('caption', 'Caption');
		$this->form_validation->set_rules('primary_photo', 'Primary');

		$this->form_validation->set_rules('sku', 'lang:sku', 'trim');
		$this->form_validation->set_rules('seo_title', 'lang:seo_title', 'trim');
		$this->form_validation->set_rules('meta', 'lang:meta_data', 'trim');
		$this->form_validation->set_rules('name', 'lang:name', 'trim|required|max_length[64]');
		$this->form_validation->set_rules('slug', 'lang:slug', 'trim');
		$this->form_validation->set_rules('description', 'lang:description', 'trim');
		$this->form_validation->set_rules('excerpt', 'lang:excerpt', 'trim');
		$this->form_validation->set_rules('price', 'lang:price', 'trim|numeric|floatval');
		$this->form_validation->set_rules('saleprice', 'lang:saleprice', 'trim|numeric|floatval');
		$this->form_validation->set_rules('weight', 'lang:weight', 'trim|numeric|floatval');
		$this->form_validation->set_rules('track_stock', 'lang:track_stock', 'trim|numeric');
		$this->form_validation->set_rules('quantity', 'lang:quantity', 'trim|numeric');
		$this->form_validation->set_rules('shippable', 'lang:shippable', 'trim|numeric');
		$this->form_validation->set_rules('taxable', 'lang:taxable', 'trim|numeric');
		$this->form_validation->set_rules('fixed_quantity', 'lang:fixed_quantity', 'trim|numeric');
		$this->form_validation->set_rules('enabled', 'lang:enabled', 'trim|numeric');

		/*
		if we've posted already, get the photo stuff and organize it
		if validation comes back negative, we feed this info back into the system
		if it comes back good, then we send it with the save item
		
		submit button has a value, so we can see when it's posted
		*/
		
		if($duplicate)
		{
			$data['id']	= false;
		}
		if($this->input->post('submit'))
		{
			//reset the product options that were submitted in the post
			$data['product_options']	= $this->input->post('option');
			$data['related_products']	= $this->input->post('related_products');
			$data['product_categories']	= $this->input->post('categories');
			$data['images']				= $this->input->post('images');
			$data['product_files']		= $this->input->post('downloads');
			
		}
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->view($this->config->item('admin_folder').'/product_form', $data);
		}
		else
		{
			$this->load->helper('text');
			
			//first check the slug field
			$slug = $this->input->post('slug');
			
			//if it's empty assign the name field
			if(empty($slug) || $slug=='')
			{
				$slug = $this->input->post('name');
			}
			
			$slug	= url_title(convert_accented_characters($slug), 'dash', TRUE);
			
			//validate the slug
			$this->load->model('Routes_model');

			if($id)
			{
				$slug		= $this->Routes_model->validate_slug($slug, $product->route_id);
				$route_id	= $product->route_id;
			}
			else
			{
				$slug	= $this->Routes_model->validate_slug($slug);
				
				$route['slug']	= $slug;	
				$route_id	= $this->Routes_model->save($route);
			}

			$save['id']					= $id;
			$save['sku']				= $this->input->post('sku');
			$save['name']				= $this->input->post('name');
			$save['seo_title']			= $this->input->post('seo_title');
			$save['meta']				= $this->input->post('meta');
			$save['description']		= $this->input->post('description');
			$save['excerpt']			= $this->input->post('excerpt');
			$save['price']				= $this->input->post('price');
			$save['saleprice']			= $this->input->post('saleprice');
			$save['weight']				= $this->input->post('weight');
			$save['track_stock']		= $this->input->post('track_stock');
			$save['fixed_quantity']		= $this->input->post('fixed_quantity');
			$save['quantity']			= $this->input->post('quantity');
			$save['shippable']			= $this->input->post('shippable');
			$save['taxable']			= $this->input->post('taxable');
			$save['enabled']			= $this->input->post('enabled');
			$post_images				= $this->input->post('images');
			
			$save['slug']				= $slug;
			$save['route_id']			= $route_id;
			
			if($primary	= $this->input->post('primary_image'))
			{
				if($post_images)
				{
					foreach($post_images as $key => &$pi)
					{
						if($primary == $key)
						{
							$pi['primary']	= true;
							continue;
						}
					}	
				}
				
			}
			
			$save['images']				= json_encode($post_images);
			
			
			if($this->input->post('related_products'))
			{
				$save['related_products'] = json_encode($this->input->post('related_products'));
			}
			else
			{
				$save['related_products'] = '';
			}
			
			//save categories
			$categories			= $this->input->post('categories');
			if(!$categories)
			{
				$categories	= array();
			}
			
			
			// format options
			$options	= array();
			if($this->input->post('option'))
			{
				foreach ($this->input->post('option') as $option)
				{
					$options[]	= $option;
				}

			}	
			
			// save product 
			$product_id	= $this->Product_model->save($save, $options, $categories);
			
			// add file associations
			// clear existsing
			$this->Digital_Product_model->disassociate(false, $product_id);
			// save new
			$downloads = $this->input->post('downloads');
			if(is_array($downloads))
			{
				foreach($downloads as $d)
				{
					$this->Digital_Product_model->associate($d, $product_id);
				}
			}			

			//save the route
			$route['id']	= $route_id;
			$route['slug']	= $slug;
			$route['route']	= 'cart/product/'.$product_id;
			
			$this->Routes_model->save($route);
			
			$this->session->set_flashdata('message', lang('message_saved_product'));

			//go back to the product list
			redirect($this->config->item('admin_folder').'/products');
		}
	}
	
	function product_image_form()
	{
		$data['file_name'] = false;
		$data['error']	= false;
		$this->load->view($this->config->item('admin_folder').'/iframe/product_image_uploader', $data);
	}
	
	function product_image_upload()
	{
		$data['file_name'] = false;
		$data['error']	= false;
		
		$config['allowed_types'] = 'gif|jpg|png';
		//$config['max_size']	= $this->config->item('size_limit');
		$config['upload_path'] = 'uploads/images/full';
		$config['encrypt_name'] = true;
		$config['remove_spaces'] = true;

		$this->load->library('upload', $config);
		
		if ( $this->upload->do_upload())
		{
			$upload_data	= $this->upload->data();
			
			$this->load->library('image_lib');
			/*
			
			I find that ImageMagick is more efficient that GD2 but not everyone has it
			if your server has ImageMagick then you can change out the line
			
			$config['image_library'] = 'gd2';
			
			with
			
			$config['library_path']		= '/usr/bin/convert'; //make sure you use the correct path to ImageMagic
			$config['image_library']	= 'ImageMagick';
			*/			
			
			//this is the larger image
			$config['image_library'] = 'gd2';
			$config['source_image'] = 'uploads/images/full/'.$upload_data['file_name'];
			$config['new_image']	= 'uploads/images/medium/'.$upload_data['file_name'];
			$config['maintain_ratio'] = TRUE;
			$config['width'] = 600;
			$config['height'] = 500;
			$this->image_lib->initialize($config);
			$this->image_lib->resize();
			$this->image_lib->clear();

			//small image
			$config['image_library'] = 'gd2';
			$config['source_image'] = 'uploads/images/medium/'.$upload_data['file_name'];
			$config['new_image']	= 'uploads/images/small/'.$upload_data['file_name'];
			$config['maintain_ratio'] = TRUE;
			$config['width'] = 235;
			$config['height'] = 235;
			$this->image_lib->initialize($config); 
			$this->image_lib->resize();
			$this->image_lib->clear();

			//cropped thumbnail
			$config['image_library'] = 'gd2';
			$config['source_image'] = 'uploads/images/small/'.$upload_data['file_name'];
			$config['new_image']	= 'uploads/images/thumbnails/'.$upload_data['file_name'];
			$config['maintain_ratio'] = TRUE;
			$config['width'] = 150;
			$config['height'] = 150;
			$this->image_lib->initialize($config); 	
			$this->image_lib->resize();	
			$this->image_lib->clear();

			$data['file_name']	= $upload_data['file_name'];
		}
		
		if($this->upload->display_errors() != '')
		{
			$data['error'] = $this->upload->display_errors();
		}
		$this->load->view($this->config->item('admin_folder').'/iframe/product_image_uploader', $data);
	}
	
	function delete($id = false)
	{
		if ($id)
		{	
			$product	= $this->Product_model->get_product($id);
			//if the product does not exist, redirect them to the customer list with an error
			if (!$product)
			{
				$this->session->set_flashdata('error', lang('error_not_found'));
				redirect($this->config->item('admin_folder').'/products');
			}
			else
			{

				// remove the slug
				$this->load->model('Routes_model');
				$this->Routes_model->delete($product->route_id);

				//if the product is legit, delete them
				$this->Product_model->delete_product($id);

				$this->session->set_flashdata('message', lang('message_deleted_product'));
				redirect($this->config->item('admin_folder').'/products');
			}
		}
		else
		{
			//if they do not provide an id send them to the product list page with an error
			$this->session->set_flashdata('error', lang('error_not_found'));
			redirect($this->config->item('admin_folder').'/products');
		}
	}
}
