<?php namespace GoCart\Controller;
/**
 * AdminProducts Class
 *
 * @package     GoCart
 * @subpackage  Controllers
 * @category    AdminProducts
 * @author      Clear Sky Designs
 * @link        http://gocartdv.com
 */

class AdminMedia extends Admin {

    public function __construct()
    {
        parent::__construct();

        \CI::auth()->check_access('Admin', true);
        \CI::load()->library('adminMedia');
    }

    public function index()
    {
        $selected_path = \CI::input()->post('selectedPath');
        if(isset($selected_path) && $selected_path != "null") {  // We got ajax call with selected path
            if (strpos($selected_path,'uploads') == false) {  // 1. Make sure uploads is there.
                // Uploads is not here - TODO write error to LOG
                $data['html'] = 'Ooooppssss... something went wrong. check the logs.';
                return json_encode($data['html']);
            }
            $selected_path = \CI::input()->post('selectedPath');
        }else{
            $selected_path = NULL;
        }
        $data_ajax = \CI::AdminMedia()->index($selected_path);
        $data['html'] = $this->partial('file_manager', $data_ajax, TRUE);
        $data['error_warning'] = '';
        echo json_encode($data);
    }

    public function product_multiple_image_upload(){
        $data = \CI::AdminMedia()->saveImagesInTmpUpload($_FILES);  // 1. Save all the files from Drag&Drop to tmp_upload
        echo json_encode($data);
    }

    public function product_resize_images(){
        $data = \CI::AdminMedia()->resize($_FILES);  // 2. Save all the images in tmp_upload in all the relevant sizes.
        echo json_encode($data);
    }

    public function product_image_upload()
    {
        $data = \CI::AdminMedia()->resize($_FILES);
        echo json_encode($data);
        return;
        if ( \CI::upload()->do_upload())
        {
            $upload_data    = \CI::upload()->data();

            \CI::load()->library('image_lib');

            $config['image_library'] = 'gd2';
            $config['source_image'] = 'uploads/images/full/'.$upload_data['file_name'];
            $config['new_image'] = 'uploads/images/medium/'.$upload_data['file_name'];
            $config['maintain_ratio'] = TRUE;
            $config['width'] = 600;
            $config['height'] = 500;
            \CI::image_lib()->initialize($config);
            \CI::image_lib()->resize();
            \CI::image_lib()->clear();

            //small image
            $config['image_library'] = 'gd2';
            $config['source_image'] = 'uploads/images/medium/'.$upload_data['file_name'];
            $config['new_image'] = 'uploads/images/small/'.$upload_data['file_name'];
            $config['maintain_ratio'] = TRUE;
            $config['width'] = 235;
            $config['height'] = 235;
            \CI::image_lib()->initialize($config);
            \CI::image_lib()->resize();
            \CI::image_lib()->clear();

            //cropped thumbnail
            $config['image_library'] = 'gd2';
            $config['source_image'] = 'uploads/images/small/'.$upload_data['file_name'];
            $config['new_image'] = 'uploads/images/thumbnails/'.$upload_data['file_name'];
            $config['maintain_ratio'] = TRUE;
            $config['width'] = 150;
            $config['height'] = 150;
            \CI::image_lib()->initialize($config);
            \CI::image_lib()->resize();
            \CI::image_lib()->clear();

            $data['file_name'] = $upload_data['file_name'];
        }

        if(\CI::upload()->display_errors() != '')
        {
            $data['error'] = \CI::upload()->display_errors();
        }
        //$this->partial('iframe/product_image_uploader', $data);
    }

}
