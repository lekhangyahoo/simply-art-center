<?php
Class Center_model extends CI_Model
{
	
	function get_centers()
	{
		return	$this->db->where('delete_flag', 0)->order_by('id', 'ASC')->get('centers')->result();
	}

	function get_center($id){
		if($id > 0){
			return	$this->db->where('delete_flag', 0)->where('id', $id)->get('centers')->result();
		}
		return null;

	}

	function delete_center($id){
		$this->db->where('id', $id)->update('centers', array('delete_flag' => 1));
	}

	function insert_center($id = 0, $data = array()){
		if($id){
			$this->db->where('id', $id)->update('centers', $data);
		}else{
			$this->db->insert('centers', $data);
			$id = $this->db->insert_id();
		}
		return $id;
	}

	function get_schedules($conditions = array())
	{
		if(isset($conditions['center_id']) && $conditions['center_id'] > 0){
			$this->db->where('schedules.center_id', $conditions['center_id']);
		}
		if(isset($conditions['course_id']) && $conditions['course_id'] > 0){
			$this->db->where('schedules.course_id', $conditions['course_id']);
		}
		$this->db->select('schedules.*, centers.name as center_name, courses.title as course_title');
		$this->db->join('centers', 'centers.id = schedules.center_id AND centers.delete_flag = 0');
		$this->db->join('courses', 'courses.id = schedules.course_id AND courses.delete_flag = 0');
		$this->db->where('schedules.delete_flag', 0);
		$this->db->where('schedules.delete_flag', 0);
		$this->db->where('schedules.delete_flag', 0);
		$this->db->order_by('schedules.center_id', 'ASC');
		$this->db->order_by('schedules.course_id', 'ASC');
		$this->db->order_by('schedules.day', 'DESC');
		$this->db->order_by('schedules.start_time', 'ASC');
		return $this->db->get('schedules')->result();
	}

	function get_schedule($id){
		if($id > 0){
			return	$this->db->where('delete_flag', 0)->where('id', $id)->get('schedules')->result();
		}
		return null;

	}

	function delete_schedule($id){
		$this->db->where('id', $id)->update('schedules', array('delete_flag' => 1));
	}

	function insert_schedule($id = 0, $data = array()){
		if($id){
			$this->db->where('id', $id)->update('schedules', $data);
		}else{
			$this->db->insert('schedules', $data);
			$id = $this->db->insert_id();
		}
		return $id;
	}

	function get_courses()
	{
		return	$this->db->where('delete_flag', 0)->order_by('id', 'ASC')->get('courses')->result();
	}

	function get_course($id){
		if($id > 0){
			return	$this->db->where('delete_flag', 0)->where('id', $id)->get('courses')->row();
		}
		return null;

	}

	function delete_course($id){
		$this->db->where('id', $id)->update('courses', array('delete_flag' => 1));
	}

	function insert_course($id = 0, $data = array()){
		if($id){
			$this->db->where('id', $id)->update('courses', $data);
		}else{
			$this->db->insert('courses', $data);
			$id = $this->db->insert_id();
		}
		return $id;
	}

	function get_students($data=array(), $condition = array())
	{
		if(!empty($data['rows']))
		{
			$this->db->limit($data['rows']);
		}

		//grab the offset
		if(!empty($data['page']))
		{
			$this->db->offset($data['page']);
		}
		if(isset($condition['key_word'])){
			$this->db->where('(name like "%'.$condition['key_word'].'%")');
		}
		if(isset($condition['key_word_birthday'])){
			$this->db->where('(birthday like "%'.$condition['key_word_birthday'].'%")');
		}
		return	$this->db->where('delete_flag', 0)->order_by('id', 'DESC')->get('students')->result();
	}

	function get_student($id){
		if($id > 0){
			$this->db->select('students.*, districts.name as district_name, wards.name as ward_name');
			$this->db->join('districts', 'districts.id = students.district_id', 'left');
			$this->db->join('wards', 'wards.id = students.ward_id', 'left');
			return	$this->db->where('delete_flag', 0)->where('students.id', $id)->get('students')->row();
		}
		return null;
	}

	function search_student($tern){
		if($tern != ''){
			$this->db->where("delete_flag = 0 AND name LIKE '%".$tern."%' OR phone LIKE '%".$tern."%'");
			return $this->db->get('students')->result();
		}
		return null;
	}

	function delete_student($id){
		$this->db->where('id', $id)->update('students', array('delete_flag' => 1));
	}

	function student_registration($id){
		//$this->db->where('id', $id)->update('students', array('delete_flag' => 1));
	}

	function student_detail($id){
		//$this->db->where('id', $id)->update('students', array('delete_flag' => 1));
	}

	function insert_student($id = 0, $data = array()){
		if($id){
			$this->db->where('id', $id)->update('students', $data);
		}else{
			$this->db->insert('students', $data);
			$id = $this->db->insert_id();
		}
		return $id;
	}

	function count_students(){
		return $this->db->where('delete_flag', 0)->count_all_results('students');
	}

	function student_registry($data){
		$this->db->insert('student_registry', $data);
		return $this->db->insert_id();
	}

	function registered($course_ids = array()){
		if(!empty($course_ids)){
			$this->db->where('delete_flag', 0)->count_all_results('students');
		}
	}

	function get_student_registered($id, $student_registry_id_list = array(), $get_invoice_number = false){
		if($id > 0){
			if(!empty($student_registry_id_list)){
				$this->db->where_in('student_registry.id', $student_registry_id_list);
				$this->db->where('student_registry.invoice_status', 0);
			}
			if($get_invoice_number){
				$this->db->select('invoices.invoice_number');
				$this->db->join('invoice_registries', 'invoice_registries.student_registry_id = student_registry.id', 'left');
				$this->db->join('invoices', 'invoices.id = invoice_registries.invoice_id', 'left');
			}
			$this->db->select('student_registry.*, centers.name as center_name, courses.title as course_title, schedules.title as schedule_title, course_numbers.title as course_number_title, schedules.start_time, schedules.end_time');
			$this->db->join('centers', 'centers.id = student_registry.center_id', 'left');
			$this->db->join('courses', 'courses.id = student_registry.course_id', 'left');
			$this->db->join('schedules', 'schedules.id = student_registry.schedule_id', 'left');
			$this->db->join('course_numbers', 'course_numbers.id = student_registry.course_number_id', 'left');
			return $this->db->where('student_registry.delete_flag', 0)->where('student_registry.student_id', $id)->order_by('student_registry.id', 'DESC')->get('student_registry')->result();
		}
		return null;
	}

	function detail_invoice($invoice_number){
		$this->db->select('invoices.id as invoice_id, invoices.invoice_number, invoices.total as invoice_total, invoices.create_date as invoice_create_date');
		$this->db->select('student_registry.*, centers.name as center_name, courses.title as course_title, schedules.title as schedule_title, course_numbers.title as course_number_title, schedules.start_time, schedules.end_time');

		$this->db->join('invoice_registries', 'invoice_registries.invoice_id = invoices.id');
		$this->db->join('student_registry', 'student_registry.id = invoice_registries.student_registry_id');
		$this->db->join('centers', 'centers.id = student_registry.center_id', 'left');
		$this->db->join('courses', 'courses.id = student_registry.course_id', 'left');
		$this->db->join('schedules', 'schedules.id = student_registry.schedule_id', 'left');
		$this->db->join('course_numbers', 'course_numbers.id = student_registry.course_number_id', 'left');
		$this->db->where('student_registry.delete_flag', 0);
		$this->db->where('invoices.invoice_number', $invoice_number);
		return $this->db->order_by('student_registry.id', 'DESC')->get('invoices ')->result();
	}

	function get_course_numbers($all = false)
	{
		if($all == false){
			$this->db->where('end_date > ' . date('Y-m-d'));
		}
		return	$this->db->where('delete_flag', 0)->order_by('id', 'DESC')->get('course_numbers')->result();
	}

	function print_invoice($student_id, $course_id){

	}

	function print_course($student_id, $course_id){

	}
}