<?php
class Blogs extends Admin_Controller
{
	
	function __construct()
	{
		parent::__construct();

		$this->auth->check_access('Admin', true);
		$this->load->model('Blog_model');
		$this->lang->load('blog');
		$this->load->helper('upload_image');
		$this->website = config_item('website');
	}
		
	function index()
	{
		$data['page_title']	= lang('blog');
		$data['blogs']		= $this->Blog_model->get_blogs();
		
		
		$this->view($this->config->item('admin_folder').'/blogs', $data);
	}
	
	/********************************************************************
	edit page
	********************************************************************/
	function form($id = false)
	{
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		//set the default values
		$data['id']			= '';
		$data['title']		= '';
		$data['menu_title']	= '';
		$data['slug']		= '';
		$data['sequence']	= 0;
		$data['content']	= '';
		$data['description']= '';
		$data['seo_title']	= '';
		$data['meta']		= '';
		$data['image'] 		= null;
		$data['meta_keyword'] = '';
		
		$data['page_title']	= lang('blog_form');
		
		if($id)
		{
			
			$blog			= $this->Blog_model->get_blog($id);

			if(!$blog)
			{
				//page does not exist
				$this->session->set_flashdata('error', lang('error_page_not_found'));
				redirect($this->config->item('admin_folder').'/blogs');
			}
			
			
			//set values to db values
			$data['id']				= $blog->id;
			$data['title']			= $blog->title;
			$data['menu_title']		= $blog->menu_title;
			$data['sequence']		= $blog->sequence;
			$data['content']		= $blog->content;
			$data['description']	= $blog->description;
			$data['seo_title']		= $blog->seo_title;
			$data['meta']			= $blog->meta;
			$data['slug']			= $blog->slug;
			$data['image'] 			= $blog->image;
			$data['meta_keyword'] 	= $blog->meta_keyword;
		}
		
		$this->form_validation->set_rules('title', 'lang:title', 'trim|required');
		$this->form_validation->set_rules('menu_title', 'lang:menu_title', 'trim');
		$this->form_validation->set_rules('slug', 'lang:slug', 'trim');
		$this->form_validation->set_rules('seo_title', 'lang:seo_title', 'trim');
		$this->form_validation->set_rules('meta', 'lang:meta', 'trim');
		$this->form_validation->set_rules('sequence', 'lang:sequence', 'trim|integer');
		$this->form_validation->set_rules('content', 'lang:content', 'trim');
		
		// Validate the form
		if($this->form_validation->run() == false)
		{
			$this->view($this->config->item('admin_folder').'/blog_form', $data);
		}
		else
		{
			$this->load->helper('text');
			
			//first check the slug field
			$slug = $this->input->post('slug');
			
			//if it's empty assign the name field
			if(empty($slug) || $slug=='')
			{
				$slug = $this->input->post('title');
			}
			
			$slug	= url_title(convert_accented_characters($slug), 'dash', TRUE);
			
			//validate the slug
			$this->load->model('Routes_model');
			if($id)
			{
				$slug		= $this->Routes_model->validate_slug($slug, $blog->route_id);
				$route_id	= $blog->route_id;
			}
			else
			{
				$slug			= $this->Routes_model->validate_slug($slug);
				$route['slug']	= $slug;	
				$route_id		= $this->Routes_model->save($route);
			}
			
			
			$save = array();
			$save['id']			= $id;
			$save['parent_id']	= $this->input->post('parent_id');
			$save['title']		= $this->input->post('title');
			$save['menu_title']	= $this->input->post('menu_title'); 
			$save['sequence']	= $this->input->post('sequence');
			$save['content']	= $this->input->post('content');
			$save['description']= $this->input->post('description');
			$save['seo_title']	= $this->input->post('seo_title');
			$save['meta']		= $this->input->post('meta');
			$save['route_id']	= $route_id;
			$save['slug']		= $slug;
			$save['meta_keyword'] = $this->input->post('meta_keyword');
			
			//set the menu title to the page title if if is empty
			if ($save['menu_title'] == '')
			{
				$save['menu_title']	= $this->input->post('title');
			}
			$image_upload = do_upload_image('blogs');
			if(isset($image_upload['success'])){
				$save['image'] = $image_upload['success'];
			}
			//save the page
			$blog_id	= $this->Blog_model->save($save);
			
			//save the route
			$route['id']	= $route_id;
			$route['slug']	= $slug;
			$route['route']	= 'cart/blog/'.$blog_id;
			
			$this->Routes_model->save($route);
			
			$this->session->set_flashdata('message', lang('message_saved_page'));
			
			//go back to the page list
			redirect($this->config->item('admin_folder').'/blogs');
		}
	}

	/********************************************************************
	delete page
	********************************************************************/
	function delete($id)
	{
		
		$blog	= $this->Blog_model->get_blog($id);
		
		if($blog)
		{
			$this->load->model('Routes_model');
			
			$this->Routes_model->delete($blog->route_id);
			$this->Blog_model->delete_blog($id);
			$this->session->set_flashdata('message', lang('message_deleted_page'));
		}
		else
		{
			$this->session->set_flashdata('error', lang('error_page_not_found'));
		}
		
		redirect($this->config->item('admin_folder').'/blogs');
	}
}	