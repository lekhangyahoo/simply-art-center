<?php
Class Center_model extends CI_Model
{
	
	function get_centers()
	{
		return	$this->db->where('delete_flag', 0)->order_by('id', 'DESC')->get('centers')->result();
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

	function get_schedules()
	{
		return	$this->db->where('delete_flag', 0)->order_by('id', 'DESC')->get('schedules')->result();
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
		return	$this->db->where('delete_flag', 0)->order_by('id', 'DESC')->get('courses')->result();
	}

	function get_course($id){
		if($id > 0){
			return	$this->db->where('delete_flag', 0)->where('id', $id)->get('courses')->result();
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

	function get_students($data=array())
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
		return	$this->db->where('delete_flag', 0)->order_by('id', 'DESC')->get('students')->result();
	}

	function get_student($id){
		if($id > 0){
			return	$this->db->where('delete_flag', 0)->where('id', $id)->get('students')->result();
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

	function print_invoice($student_id, $course_id){

	}

	function print_course($student_id, $course_id){

	}
}