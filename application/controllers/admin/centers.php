<?php

class Centers extends Admin_Controller {

	function __construct()
	{		
		parent::__construct();
		$this->auth->check_access('Admin', true);
		$this->load->model(array('Center_model'));
		$this->load->library('form_validation');
		$this->load->helper('form');
		$this->load->helper('formatting');
		$this->load->helper('upload_image');
		$this->lang->load('center');
		$this->_admin = $this->session->userdata('admin');
		$this->_days = array(
			8 => 'Chủ Nhật',
			7 => 'Thứ Bảy',
			6 => 'Thứ Sáu',
			5 => 'Thứ Năm',
			4 => 'Thứ Tư',
			3 => 'Thứ Ba',
			2 => 'Thứ Hai'
		);
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
		$data['centers']	= $this->Center_model->get_centers();
		$data['courses']	= $this->Center_model->get_courses();
		$data['schedules']	= $this->Center_model->get_schedules();
		$data['days']	 	= $this->_days;
		//echo $this->db->last_query();
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
				'user_id'		=> $this->_admin['id']
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
		$data['page_title']	= lang('students');
		$conditions = array();
		$post = $this->input->post();
		if(isset($post['search'])) {
			if(isset($post['key_word']) && trim($post['key_word']) != '') {
				$conditions['key_word'] = trim($post['key_word']);
				$data['key_word'] = trim($post['key_word']);
			}
			if(isset($post['key_word_birthday']) && trim($post['key_word_birthday']) != '') {
				$conditions['key_word_birthday'] = trim($post['key_word_birthday']);
				$data['key_word_birthday'] = trim($post['key_word_birthday']);
			}
		}

		$data['students']	= $this->Center_model->get_students(null, $conditions);
		$this->view($this->config->item('admin_folder').'/students', $data);
	}

	function student_form($id = 0)
	{
		//pr($this->input->post());exit;
		$post = $this->input->post();
		$data['message_error'] = '';
		$data['message_success'] = '';
		$data['districts'] = $this->db->get('districts')->result();
		$data['centers'] = $this->Center_model->get_centers();
		$data['courses'] = $this->Center_model->get_courses();
		$data['course_numbers'] = $this->Center_model->get_course_numbers();
		$data['page_title']	= lang('students');
		$data['id'] 		= $id;
		$data['name'] 		= '';
		$data['phone'] 		= '';
		$data['email'] 		= '';
		$data['address'] 	= '';
		$data['district_id']= '';
		$data['ward_id'] 	= '';
		$data['gender'] 	= 1;
		$data['birthday'] 	= '';
		$data['parent_name']= '';
		$data['school_id'] 	= '';
		$data['active'] 	= '';
		$data['note'] 		= '';
		if($id > 0){
			$student = $this->Center_model->get_student($id);
			$data['student_registered'] = $this->Center_model->get_student_registered($id);
			//echo $this->db->last_query();pr($data['student_registry']);exit;
			//pr($student);
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
				$data['active'] 	= $student->active;
				$data['note'] 		= $student->note;
				if($data['district_id'] > 0){
					$data['wards'] = $this->db->where('district_id', $data['district_id'])->get('wards')->result();
				}
			}
		}

		if (!isset($post['submit']))
		{
			$this->view($this->config->item('admin_folder').'/student_form', $data);
		}
		else {
			if($post['submit'] == 'save-regis-continue' || $post['submit'] == 'save-regis'){
				$course_id = $this->input->post('course_id');
				$schedule_id = $this->input->post('schedule_id');
				$course_number_id = $this->input->post('course_number_id');
				$this->db->where('student_id', $id)->where('course_id', $course_id)->where('schedule_id', $schedule_id);
				$check_student_registry = $this->db->get('student_registry')->row();
				if($check_student_registry){
					$data['message_error'] = 'This student was registered this course.';
				}else {
					$course = $this->Center_model->get_course($schedule_id);
					$data = array(
						'student_id' => $id,
						'center_id' => $this->input->post('center_id'),
						'course_id' => $schedule_id,
						'course_number_id' => $course_number_id,
						'schedule_id' => $schedule_id,
						'price' => isset($course->price) ? $course->price : null,
						'price_sale' => isset($course->price_sale) ? $course->price_sale : null,
						'create_date' => date('Y-m-d H:i:s'),
						'user_id' => $this->_admin['id']
					);
					$this->db->insert('student_registry', $data);
				}
			}else {
				$this->form_validation->set_rules('name', 'Name', 'trim');
				$this->form_validation->set_rules('phone', 'Phone', 'trim');
				$this->form_validation->set_rules('content', 'lang:course_content', 'trim');
				if ($this->form_validation->run() == FALSE){
					$this->view($this->config->item('admin_folder').'/student_form', $data);
				}else {
					$data = array(
						'name' => trim($this->input->post('name')),
						'phone' => trim($this->input->post('phone')),
						'phone_2' => trim($this->input->post('phone_2')),
						'email' => trim($this->input->post('email')),
						'address' => trim($this->input->post('address')),
						'district_id' => $this->input->post('district_id'),
						'ward_id' => $this->input->post('ward_id'),
						'gender' => $this->input->post('gender'),
						'birthday' => $this->input->post('birthday'),
						'parent_name' => trim($this->input->post('parent_name')),
						'school_id' => $this->input->post('school_id'),
						'active' => $this->input->post('active'),
						'note' => trim($this->input->post('note')),
						'user_id' => $this->_admin['id']
					);
					if ($id > 0) {
						$data['update_date'] = date('Y-m-d H:i:s');
					} else {
						$data['create_date'] = date('Y-m-d H:i:s');
					}
					$id = $this->Center_model->insert_student($id, $data);
				}
			}
			if($post['submit'] == 'save-regis-continue' || $post['submit'] == 'save-continue'){
				redirect('/admin/centers/student_form/' . $id);
			}else {
				redirect('/admin/centers/students');
			}
		}
	}

	function student_invoice($id = 0)
	{
		$data['page_title']	= lang('students');
		$post = $this->input->post();
		//pr($this->input->post());exit;
		$data['id'] = $id;
		if($id > 0){
			$student = $this->Center_model->get_student($id);
			$data['student'] = $student;
			if($student) {
				if (!isset($post['submit'])){
					$data['student_registered'] = $this->Center_model->get_student_registered($id, null, true);
					$this->view($this->config->item('admin_folder').'/student_invoice', $data);
				}else{
					$data['student_registered'] = $this->Center_model->get_student_registered($id, $post['id']);
					$this->view($this->config->item('admin_folder').'/student_create_invoice', $data);
				}
			}else{
				redirect('/admin/centers/students');
			}
			//echo $this->db->last_query();pr($data['student_registry']);exit;
		}else{
			redirect('/admin/centers/students');
		}
	}

	function student_create_invoice()
	{
		$post = $this->input->post();
		//pr($this->input->post());exit;
		$data['student_id'] = $post['student_id'];
		$data['id'] = $post['id'];
		if($data['student_id'] > 0 && !empty($data['id'])){
			$student = $this->Center_model->get_student($data['student_id']);
			$student_registered = $this->Center_model->get_student_registered($data['student_id'], $post['id']);
			if(count($student_registered) == count($data['id'])){
				$total_price = 0;
				foreach($student_registered as $registered){
					if($registered->price_sale > 0 && $registered->price_sale < $registered->price){
						$price = $registered->price_sale;
						$flag_sale_off = true;
					}else{
						$price = $registered->price;
					}
					$total_price = $total_price + $price;
				}
				if($total_price > 0){
					$invoice = $this->db->order_by('invoice_number', 'DESC')->get('invoices')->row();
					if($invoice){
						$invoice_number = $invoice->invoice_number + 1;
					}else{
						$invoice_number = 180001;
					}
					$this->db->insert('invoices', array(
						'invoice_number' => $invoice_number,
						'total' => $total_price,
						'create_date' => date('Y-m-d H:i:s'),
						'user_id' => $this->_admin['id']
					));
					$invoice_id = $this->db->insert_id();
					foreach($student_registered as $registered){
						$this->db->insert('invoice_registries', array(
							'invoice_id' 			=> $invoice_id,
							'student_registry_id' 	=> $registered->id
						));
					}
					$this->db->where_in('id', $data['id'])->update('student_registry', array(
						'invoice_status' => 1
					));
				}
				echo json_encode(array('success' => 1));
			}else{
				echo json_encode(array('success' => 0));
			}
		}else{
			echo json_encode(array('success' => 0));
		}
		exit;
	}

	function delete_student($id)
	{
		$this->Center_model->delete_student($id);
	}

	function student_detail($id)
	{
		$this->Center_model->student_detail($id);
	}
	function student_registration($id)
	{
		$this->Center_model->student_registration($id);
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
		//pr(do_upload_image('courses'));exit;
		$data['page_title']	= lang('courses');
		$data['id'] 			= $id;
		$data['title'] 			= '';
		$data['description'] 	= '';
		$data['content'] 		= '';
		$data['image'] 			= null;
		$data['active'] 		= 1;
		$data['price']			= null;
		$data['price_sale']		= null;
		if($id > 0){
			$course = $this->Center_model->get_course($id);
			if($course){
				$data['title'] 			= $course->title;
				$data['description'] 	= $course->description;
				$data['content'] 		= $course->content;
				$data['active'] 		= $course->active;
				$data['image'] 			= $course->image;
				$data['price'] 			= $course->price;
				$data['price_sale'] 	= $course->price_sale;
			}
		}
		$this->form_validation->set_rules('title', 'lang:course_title', 'trim|required');

		if ($this->form_validation->run() == FALSE)
		{
			if($this->input->post('submit') == 'submit'){
				$data['title'] 			= $this->input->post('title');
				$data['description'] 	= $this->input->post('description');
				$data['content'] 		= $this->input->post('content');
				$data['price'] 			= $this->input->post('price');
				$data['price_sale'] 	= $this->input->post('price_sale');
			}
			$this->view($this->config->item('admin_folder').'/course_form', $data);
		}
		else {
			$data 	= array(
				'title' 		=> trim($this->input->post('title')),
				'description' 	=> trim($this->input->post('description')),
				'content' 		=> trim($this->input->post('content')),
				'price' 		=> trim($this->input->post('price')),
				'price_sale' 	=> trim($this->input->post('price_sale')),
				'active' 		=> $this->input->post('active'),
				'user_id'		=> $this->_admin['id']
			);
			$image_upload = do_upload_image('courses');
			if(isset($image_upload['success'])){
				$data['image'] = $image_upload['success'];
			}
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

	function get_option_schedules(){
		$center_id = $this->input->post('center_id');
		$course_id = $this->input->post('course_id');
		$schedules = $this->Center_model->get_schedules(array('center_id' => $center_id, 'course_id' => $course_id));
		$option = '<option value>-- Select Schedule --</option>';
		foreach($schedules as $schedule){
			$schedule->title = $schedule->title . ' (' . $schedule->start_time . ' - '. $schedule->end_time . ')';
			$option = $option . '<option value="' . $schedule->id .'">' . $schedule->title. '</option>';
		}
		echo json_encode(array('option' => $option));
		exit;
	}

	function get_option_ward_from_district(){
		$district_id = $this->input->post('district_id');
		$wards = $this->db->where('district_id', $district_id)->get('wards')->result();
		$option = '';
		foreach($wards as $ward){
			$option = $option . '<option class="value-ward" value="' . $ward->id .'">' . $ward->name. '</option>';
		}
		echo json_encode(array('option' => $option));
		exit;
	}

	function print_invoice($invoice_number = 0)
	{
		$this->load->helper('html2pdf');

		$data['invoice_number'] = $invoice_number;
		if($invoice_number > 0){
			$detail_invoice = $this->Center_model->detail_invoice($invoice_number);
			$data['detail_invoice'] = $detail_invoice;
			//pr($detail_invoice);exit;
			if($detail_invoice) {
				$html = $this->load->view($this->config->item('admin_folder').'/template_invoice', $data, true);
				echo $html;exit;
				return html2pdf($html, 'invoice_'.$invoice_number, true, 'A4');
			}else{
				redirect('/admin/centers/students');
			}
			//echo $this->db->last_query();pr($data['student_registry']);exit;
		}else{
			redirect('/admin/centers/students');
		}
	}

	function upload_image($type = 'others')
	{
		$config_image = config_item('image');
		$config_type = $config_image[$type];
		$config['upload_path'] = $config_type['path'];
		$config['allowed_types'] = 'gif|jpg|png';
		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('file'))
		{
			$error = array('error' => $this->upload->display_errors());
			return $error;
			//echo stripslashes(json_encode($error));
		}
		else
		{
			$data = $this->upload->data();

			//upload successful generate a thumbnail
			$config['image_library'] = 'gd2';
			$config['source_image'] = $config_type['path'].'/'.$data['file_name'];
			$config['new_image'] = $config_type['path_medium'].'/'.$data['file_name'];
			$config['create_thumb'] = FALSE;
			$config['maintain_ratio'] = TRUE;
			$config['width']     = $config_type['width_medium'];
			$config['height']   = $config_type['height_medium'];

			$this->load->library('image_lib', $config);

			$this->image_lib->resize();
		}
		return $data['file_name'];
	}

	function teachers()
	{
		$data['page_title']	= lang('teachers');
		$conditions = array();
		$post = $this->input->post();
		if(isset($post['search'])) {
			if(isset($post['key_word']) && trim($post['key_word']) != '') {
				$conditions['key_word'] = trim($post['key_word']);
				$data['key_word'] = trim($post['key_word']);
			}
		}

		$data['teachers']	= $this->Center_model->get_teachers(null, $conditions);
		$this->view($this->config->item('admin_folder').'/teachers', $data);
	}

	function teacher_form($id = 0)
	{
		$post = $this->input->post();
		$data['message_error'] = '';
		$data['message_success'] = '';
		$data['districts'] = $this->db->get('districts')->result();
		$data['page_title']	= lang('teachers');
		$data['id'] 		= $id;
		$data['name'] 		= '';
		$data['phone'] 		= '';
		$data['email'] 		= '';
		$data['address'] 	= '';
		$data['district_id']= '';
		$data['ward_id'] 	= '';
		$data['gender'] 	= 1;
		$data['birthday'] 	= '';
		$data['parent_name']= '';
		$data['school_id'] 	= '';
		$data['active'] 	= '';
		$data['note'] 		= '';
		$data['description']= '';
		if($id > 0){
			$teacher = $this->Center_model->get_teacher($id);
			if($teacher){
				$data['name'] 		= $teacher->name;
				$data['phone'] 		= $teacher->phone;
				$data['email'] 		= $teacher->email;
				$data['address'] 	= $teacher->address;
				$data['district_id']= $teacher->district_id;
				$data['ward_id'] 	= $teacher->ward_id;
				$data['gender'] 	= $teacher->gender;
				$data['birthday'] 	= $teacher->birthday;
				$data['active'] 	= $teacher->active;
				$data['note'] 		= $teacher->note;
				$data['image']		= $teacher->image;
				$data['description']= $teacher->description;
				if($data['district_id'] > 0){
					$data['wards'] = $this->db->where('district_id', $data['district_id'])->get('wards')->result();
				}
			}
		}

		if (!isset($post['submit']))
		{
			$this->view($this->config->item('admin_folder').'/teacher_form', $data);
		}
		else {
			$this->form_validation->set_rules('name', 'Name', 'trim');
			$this->form_validation->set_rules('phone', 'Phone', 'trim');
			if ($this->form_validation->run() == FALSE){
				$this->view($this->config->item('admin_folder').'/teacher_form', $data);
			}else {
				$data = array(
					'name' => trim($this->input->post('name')),
					'phone' => trim($this->input->post('phone')),
					'email' => trim($this->input->post('email')),
					'address' => trim($this->input->post('address')),
					'district_id' => $this->input->post('district_id'),
					'ward_id' => $this->input->post('ward_id'),
					'gender' => $this->input->post('gender'),
					'birthday' => $this->input->post('birthday'),
					'active' => $this->input->post('active'),
					'note' => trim($this->input->post('note')),
					'description' => trim($this->input->post('description')),
					'user_id' => $this->_admin['id']
				);
				$image_upload = do_upload_image('teachers');
				if(isset($image_upload['success'])){
					$data['image'] = $image_upload['success'];
				}else{
					pr($image_upload);exit;
				}
				if ($id > 0) {
					$data['update_date'] = date('Y-m-d H:i:s');
				} else {
					$data['create_date'] = date('Y-m-d H:i:s');
				}
				$id = $this->Center_model->insert_teacher($id, $data);
			}
			if($post['submit'] == 'save-regis-continue' || $post['submit'] == 'save-continue'){
				redirect('/admin/centers/teacher_form/' . $id);
			}else {
				redirect('/admin/centers/teachers');
			}
		}
	}
}
