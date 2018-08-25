<?php
Class News_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->website = config_item('website');
	}

	/********************************************************************
	Page functions
	********************************************************************/
	function get_news($parent = 0)
	{
		$this->db->order_by('sequence', 'ASC');
		$this->db->where('parent_id', $parent);
		$this->db->where('website', $this->website);
		$result = $this->db->get('news')->result();
		return $result;
		
		$return	= array();
		foreach($result as $page)
		{

			// Set a class to active, so we can highlight our current page
			if($this->uri->segment(1) == $page->slug) {
				$page->active = true;
			} else {
				$page->active = false;
			}

			$return[$page->id]				= $page;
			$return[$page->id]->children	= $this->get_pages($page->id);
		}
		
		return $return;
	}

	function get_news_tiered()
    {
		$this->db->order_by('sequence', 'ASC');
		$this->db->order_by('title', 'ASC');
		$this->db->where('website', $this->website);
		$pages = $this->db->get('news')->result();
		
		$results	= array();
		foreach($pages as $page)
		{
			$results[$page->parent_id][$page->id] = $page;
		}
		
		return $results;
	}

	function get_news_detail($id)
	{
		$this->db->where('id', $id);
		$this->db->where('website', $this->website);
		$result = $this->db->get('news')->row();
		
		return $result;
	}
	
	function get_slug($id)
	{
		$page = $this->get_news_detail($id);
		if($page) 
		{
			return $page->slug;
		}
	}
	
	function save($data)
	{
		if($data['id'])
		{
			$this->db->where('id', $data['id']);
			$this->db->update('news', $data);
			return $data['id'];
		}
		else
		{
			$data['website'] = $this->website;
			$this->db->insert('news', $data);
			return $this->db->insert_id();
		}
	}
	
	function delete_news($id)
	{
		//delete the page
		$this->db->where('id', $id);
		$this->db->delete('news');
	
	}
	
	function get_news_by_slug($slug)
	{
		$this->db->where('slug', $slug);
		$this->db->where('website', $this->website);
		$result = $this->db->get('news')->row();
		
		return $result;
	}
}