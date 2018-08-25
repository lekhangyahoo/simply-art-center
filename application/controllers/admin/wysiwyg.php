<?php

class wysiwyg extends Admin_Controller {
    private $year;
    function __construct()
    {
        parent::__construct();
        $this->year = date("Y");
        // create folder if don't exist folder
    }
    function upload_image()
    {
        $config['upload_path'] = 'uploads/wysiwyg/images/'.$this->year;
        $config['allowed_types'] = 'gif|jpg|png';

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('file'))
        {
            $error = array('error' => $this->upload->display_errors());
            echo stripslashes(json_encode($error));
        }
        else
        {
            $data = $this->upload->data();

            //upload successful generate a thumbnail
            $config['image_library'] = 'gd2';
            $config['source_image'] = 'uploads/wysiwyg/images/'.$this->year.'/'.$data['file_name'];
            $config['new_image'] = 'uploads/wysiwyg/thumbnails/'.$this->year.'/'.$data['file_name'];
            $config['create_thumb'] = FALSE;
            $config['maintain_ratio'] = TRUE;
            $config['width']     = 75;
            $config['height']   = 50;

            $this->load->library('image_lib', $config); 

            $this->image_lib->resize();

            
            $data = array('filelink' => base_url('uploads/wysiwyg/images/'.$this->year.'/'.$data['file_name']), 'filename'=>$data['file_name']);
            echo stripslashes(json_encode($data));
        }
    }

    function upload_file()
    {
        $config['upload_path'] = 'uploads/wysiwyg/'.$this->year;
        $config['allowed_types'] = '*';

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('file'))
        {
            $error = array('error' => $this->upload->display_errors());
            echo stripslashes(json_encode($error));
        }
        else
        {
            $data = $this->upload->data();
            $data = array('filelink' => base_url('uploads/wysiwyg/'.$this->year.'/'.$data['file_name']), 'filename'=>$data['file_name']);
            echo stripslashes(json_encode($data));
        }
    }

    function get_images()
    {
        $files = get_filenames('uploads/wysiwyg/thumbnails/'.$this->year);

        $return = array();
        foreach($files as $file)
        {
            $return[] = array('thumb'=>base_url('uploads/wysiwyg/thumbnails/'.$this->year.'/'.$file), 'image'=>base_url('uploads/wysiwyg/images/'.$this->year.'/'.$file));
        }
        echo stripslashes(json_encode($return));
    }

}