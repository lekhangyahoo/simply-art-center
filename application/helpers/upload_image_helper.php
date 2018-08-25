<?php

function do_upload_image($type = 'others', $file = 'userfile')
{
	$CI =& get_instance();
	$config_image = config_item('image');
	$config_type = $config_image[$type];
	$config['upload_path'] = $config_type['path'];
	$config['allowed_types'] = 'gif|jpg|png';
	$CI->load->library('upload', $config);

	if ( ! $CI->upload->do_upload($file))
	{
		$error = array('error' => $CI->upload->display_errors());
		return $error;
		//echo stripslashes(json_encode($error));
	}
	else
	{
		$data = $CI->upload->data();

		//upload successful generate a medium
		$config['image_library'] = 'gd2';
		$config['source_image'] = $config_type['path'].'/'.$data['file_name'];
		$config['new_image'] = $config_type['path_medium'].'/'.$data['file_name'];
		$config['create_thumb'] = FALSE;
		$config['maintain_ratio'] = TRUE;
		$config['width']    = $config_type['width_medium'];
		$config['height']   = $config_type['height_medium'];

		$CI->load->library('image_lib', $config);

		$CI->image_lib->resize();
		$CI->image_lib->clear();
		if(isset($config_type['path_small'])){
			//generate a thumbnail
			$config['image_library'] = 'gd2';
			$config['source_image'] = $config_type['path_medium'].'/'.$data['file_name'];
			$config['new_image'] = $config_type['path_small'].'/'.$data['file_name'];
			$config['create_thumb'] = FALSE;
			$config['maintain_ratio'] = TRUE;
			$config['width']    = $config_type['width_small'];
			$config['height']   = $config_type['height_small'];

			$CI->load->library('image_lib', $config);

			$CI->image_lib->resize();
		}
	}
	$success = array('success' => $data['file_name']);
	return $success;
}