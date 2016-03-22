<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Media Manager for Codeigniter
 *
 * @package		CodeIgniter
 * @author 		Prashant Pareek
 * @link 		http://codecanyon.net/item/media-manager-for-codeigniter/9517058
 * @since 		Version 1.0.0
 */

/**
 * Media class
 */

define('DIR_IMAGE_FULL_PATH', 'D:/xampp/htdocs/local.unismoke.com/uploads/images/');  // All the category & product images should be places in the folder.
define('DIR_ORIGINAL_SIZE', 'full');  // All the category & product images should be places in the folder.
define('DIR_477_522', '477_522');
define('DIR_400_500', '400_500');
define('DIR_200_250', '200_250');
define('DIR_175_175','175_175');
define('DIR_100_100','100_100');
define('DIR_78_78','78_78');
define('DIR_70_70','70_70');
define('DIR_FULL_FULL','full_full');  // Original images full size.
define('DIR_TMP_UPLOAD','tmp_upload');  // Original images full size.
define('DIR_UPLOADS_IMAGES','uploads/images/');

class AdminMedia {
	private $_originalImageFullPath = '';
	private $_imageOriginalName = '';
	private $_imageSizes = array(
		DIR_IMAGE_FULL_PATH.DIR_477_522 => array('w'=>477,'h'=>522),
		DIR_IMAGE_FULL_PATH.DIR_400_500 => array('w'=>400,'h'=>500),
		DIR_IMAGE_FULL_PATH.DIR_200_250 => array('w'=>200,'h'=>250),
		DIR_IMAGE_FULL_PATH.DIR_175_175 => array('w'=>175,'h'=>175),
		DIR_IMAGE_FULL_PATH.DIR_100_100 => array('w'=>100,'h'=>100),
		DIR_IMAGE_FULL_PATH.DIR_78_78 => array('w'=>78,'h'=>78),
		DIR_IMAGE_FULL_PATH.DIR_70_70 => array('w'=>70,'h'=>70),
		DIR_IMAGE_FULL_PATH.DIR_FULL_FULL => array('w'=>'full','h'=>'full'),
	);

	public function index($sub_folder=NULL) {
		if(empty($sub_folder)){
			$data['current_path'] = DIR_IMAGE_FULL_PATH;
			$sub_folder_clean = NULL;
		}else{
			if(substr($sub_folder, -1) == '/') {  // Removing the last '/' from the path.
				$sub_folder = substr($sub_folder, 0, -1);
			}
			if (strpos($sub_folder,'/') !== false) {
				$sub_folder_clean = substr($sub_folder, strrpos($sub_folder, '/') + 1);  // Getting everything after the last slash for example 100_100
			}else{
				$sub_folder_clean = $sub_folder;
			}
			if($sub_folder_clean == 'images'){
				$sub_folder_clean = NULL;
				$data['current_path'] = DIR_IMAGE_FULL_PATH;
			}else {
				$data['current_path'] = DIR_IMAGE_FULL_PATH . $sub_folder_clean . '/';
			}
		}

		$data['images'] = array();

		$directories = glob($data['current_path'] . $sub_folder_clean . '*', GLOB_ONLYDIR);  // Get all directories

		if (!$directories) {
			$directories = array();
		}

		$files = glob($data['current_path'] . '*.{jpg,jpeg,png,gif,JPG,JPEG,PNG,GIF}', GLOB_BRACE);  // Get All images

		if (!$files) {
			$files = array();
		}

		// Merge directories and files
		$images = array_merge($directories, $files);

		foreach ($images as $image) {
			$name = substr($image, strrpos($image, '/') + 1);  // Getting the name of the file or the folder.
			$this->_setImageOriginalName($name);
			$this->_setOriginalImageFullPath($name);

			if (is_dir($this->_originalImageFullPath)) {  // If Folder
				$data['images'][] = array(
					'thumb' => '',
					'name'  => substr($name,0,10),
					'type'  => 'directory',
					'path'  => $this->_originalImageFullPath,
					'href'  => $this->_originalImageFullPath  // Front-end path.
				);
			} elseif (is_file($image)) {  // if File
				$newFileName = $this->_imageOriginalName;  // TODO this might slow down things if there are many images... a better solution might be needed.
				$nameTrimmed = $name;
				if(strlen($name) > 10){
					$nameTrimmed = substr($name,0,10).'...';
				}
				$imageThumbnail = $this->_getImageThumbNail($sub_folder_clean);
				if($sub_folder_clean != DIR_100_100){
					$sub_folder_dir = $sub_folder_clean;
					$imageThumbnail = $name;
				}else{
					$sub_folder_dir = DIR_100_100;
				}
				$data['images'][] = array(
					'thumb' => base_url() . DIR_UPLOADS_IMAGES . $sub_folder_dir . '/' . $imageThumbnail,  // Getting the thumbnail relative path.
					'name'  => $nameTrimmed,
					'type'  => 'image',
					'path'  => $this->_originalImageFullPath,
					'href'  => $this->_originalImageFullPath  // Front-end path to full size image.
				);
				if($sub_folder_clean==DIR_TMP_UPLOAD){
					$this->resize();  // Resize the original file, save a copy in DIR_FULL_FULL folder and delete the file from the tmp folder.
				}
			}
		}
		return $data;
	}

	public function upload() {
		$this->load->language('common/filemanager');

		$json = array();

		// Check user has permission
		if (!$this->user->hasPermission('modify', 'common/filemanager')) {
			$json['error'] = $this->language->get('error_permission');
		}

		// Make sure we have the correct directory
		if (isset($this->request->get['directory'])) {
			$directory = rtrim(DIR_IMAGE . 'catalog/' . str_replace(array('../', '..\\', '..'), '', $this->request->get['directory']), '/');
		} else {
			$directory = DIR_IMAGE . 'catalog';
		}

		// Check its a directory
		if (!is_dir($directory)) {
			$json['error'] = $this->language->get('error_directory');
		}

		if (!$json) {
			if (!empty($this->request->files['file']['name']) && is_file($this->request->files['file']['tmp_name'])) {
				// Sanitize the filename
				$filename = basename(html_entity_decode($this->request->files['file']['name'], ENT_QUOTES, 'UTF-8'));

				// Validate the filename length
				if (($this->_utf8_strlen($filename) < 3) || ($this->_utf8_strlen($filename) > 255)) {
					$json['error'] = $this->language->get('error_filename');
				}

				// Allowed file extension types
				$allowed = array(
					'jpg',
					'jpeg',
					'gif',
					'png'
				);

				if (!in_array(utf8_strtolower($this->_utf8_substr(strrchr($filename, '.'), 1)), $allowed)) {
					$json['error'] = $this->language->get('error_filetype');
				}

				// Allowed file mime types
				$allowed = array(
					'image/jpeg',
					'image/pjpeg',
					'image/png',
					'image/x-png',
					'image/gif'
				);

				if (!in_array($this->request->files['file']['type'], $allowed)) {
					$json['error'] = $this->language->get('error_filetype');
				}

				// Check to see if any PHP files are trying to be uploaded
				$content = file_get_contents($this->request->files['file']['tmp_name']);

				if (preg_match('/\<\?php/i', $content)) {
					$json['error'] = $this->language->get('error_filetype');
				}

				// Return any upload error
				if ($this->request->files['file']['error'] != UPLOAD_ERR_OK) {
					$json['error'] = $this->language->get('error_upload_' . $this->request->files['file']['error']);
				}
			} else {
				$json['error'] = $this->language->get('error_upload');
			}
		}

		if (!$json) {
			move_uploaded_file($this->request->files['file']['tmp_name'], $directory . '/' . $filename);

			$json['success'] = $this->language->get('text_uploaded');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function folder() {
		//$this->load->language('common/filemanager');

		$json = array();

		// Check user has permission
		/*
		if (!$this->user->hasPermission('modify', 'common/filemanager')) {
			$json['error'] = $this->language->get('error_permission');
		}
		*/

		// Make sure we have the correct directory
		if (isset($this->request->get['directory'])) {
			$directory = rtrim(DIR_IMAGE . 'images/' . str_replace(array('../', '..\\', '..'), '', $this->request->get['directory']), '/');
		} else {
			$directory = DIR_IMAGE . 'images';
		}

		// Check its a directory
		if (!is_dir($directory)) {
			$json['error'] = 'This is not a category';  // TODO use one language file.
		}

		if (!$json) {
			// Sanitize the folder name
			$folder = str_replace(array('../', '..\\', '..'), '', basename(html_entity_decode($this->request->post['folder'], ENT_QUOTES, 'UTF-8')));

			// Validate the filename length
			if (($this->_utf8_strlen($folder) < 3) || ($this->_utf8_strlen($folder) > 128)) {
				$json['error'] = $this->language->get('error_folder');
			}

			// Check if directory already exists or not
			if (is_dir($directory . '/' . $folder)) {
				$json['error'] = 'Folder Exist';
			}
		}

		if (!$json) {
			mkdir($directory . '/' . $folder, 0777);
			chmod($directory . '/' . $folder, 0777);

			$json['success'] = 'Directory was succssfully created.';
		}

		return(json_encode($json));
		//$this->response->addHeader('Content-Type: application/json');
		//$this->response->setOutput(json_encode($json));
	}

	public function delete() {
		$this->load->language('common/filemanager');

		$json = array();

		// Check user has permission
		if (!$this->user->hasPermission('modify', 'common/filemanager')) {
			$json['error'] = $this->language->get('error_permission');
		}

		if (isset($this->request->post['path'])) {
			$paths = $this->request->post['path'];
		} else {
			$paths = array();
		}

		// Loop through each path to run validations
		foreach ($paths as $path) {
			$path = rtrim(DIR_IMAGE . str_replace(array('../', '..\\', '..'), '', $path), '/');

			// Check path exsists
			if ($path == DIR_IMAGE . 'catalog') {
				$json['error'] = $this->language->get('error_delete');

				break;
			}
		}

		if (!$json) {
			// Loop through each path
			foreach ($paths as $path) {
				$path = rtrim(DIR_IMAGE . str_replace(array('../', '..\\', '..'), '', $path), '/');

				// If path is just a file delete it
				if (is_file($path)) {
					unlink($path);

					// If path is a directory beging deleting each file and sub folder
				} elseif (is_dir($path)) {
					$files = array();

					// Make path into an array
					$path = array($path . '*');

					// While the path array is still populated keep looping through
					while (count($path) != 0) {
						$next = array_shift($path);

						foreach (glob($next) as $file) {
							// If directory add to path array
							if (is_dir($file)) {
								$path[] = $file . '/*';
							}

							// Add the file to the files to be deleted array
							$files[] = $file;
						}
					}

					// Reverse sort the file array
					rsort($files);

					foreach ($files as $file) {
						// If file just delete
						if (is_file($file)) {
							unlink($file);

							// If directory use the remove directory function
						} elseif (is_dir($file)) {
							rmdir($file);
						}
					}
				}
			}

			$json['success'] = $this->language->get('text_delete');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	private function _getNameWithoutExtension(){
		$nameWithoutExtension = preg_replace('/\\.[^.\\s]{3,4}$/', '', $this->_imageOriginalName);
		return $nameWithoutExtension;
	}

	private function _getImageThumbNail($current_image_dimensions=NULL){
		$fileExtension = ".".$this->_getFileExtension();
		if($current_image_dimensions != NULL){
			$current_image_dimensions = str_replace('_','x',$current_image_dimensions);
			$imageThumbnail = str_replace($current_image_dimensions, "100x100", $this->_imageOriginalName);
		}else{
			$imageThumbnail = $this->_imageOriginalName;
		}
		return $imageThumbnail;
	}

	private function _getFileExtension(){
		return pathinfo($this->_originalImageFullPath, PATHINFO_EXTENSION);
	}

	public function saveImagesInTmpUpload(){
		$tmp_name = $_FILES['file']["tmp_name"];
		$name = $_FILES['file']["name"];
		$this->_setImageOriginalName($name);
		$this->_setOriginalImageFullPath($name);
		if (file_exists(DIR_IMAGE_FULL_PATH.DIR_TMP_UPLOAD.'/'.$_FILES['file']["name"])) {  //  Image with this name already exist in this folder
			$data['error'] = 'This image name already exist in the tmp_full folder, please user another name or delete the existing image.';  // Image is missing. TODO LOG it, this should never happen.
		}else {  // Copy The file to the tmp folder
			move_uploaded_file($tmp_name, DIR_IMAGE_FULL_PATH . DIR_TMP_UPLOAD . '/' . $name);
			$data['image']['name'] = DIR_UPLOADS_IMAGES.DIR_TMP_UPLOAD.'/'.$name;
			$thumbnail = $this->_renameFileByDimension();
			$data['image']['save_to_db_name'] = DIR_UPLOADS_IMAGES.DIR_100_100.'/'.$thumbnail;
		}

		// Start / Get Image top 5 colors
		$params = array('image' => $this->_originalImageFullPath, 'precision' => 10, 'maxnumcolors' => 5, 'trueper' => true);  // $image, $precision = 10, $maxnumcolors = 5, $trueper = true
		\CI::load()->library('ColorsExtract');
		\CI::ColorsExtract()->setParams($params);
		$img_colors = \CI::ColorsExtract()->getProminentColors();
		/*
		\CI::load()->library('Colors');
		foreach($img_colors as $key => $color){
			$colors[$key]['name'] = \CI::Colors()->getColor($color);
		}
		*/
		$data['image']['img_colors'] = $img_colors;  // http://www.imagemagick.org/script/color.php
		// End / Get Image top 3 colors
		return $data;
	}

	private function _renameFileByDimension($width='100',$height='100'){  // Thumbnail default size.
		$filename_withoutExt = $this->_getNameWithoutExtension();
		$extension = $this->_getFileExtension();
		$new_image = $filename_withoutExt . '_' . $width . 'x' . $height;  // File name with width and height.
		$new_image = $new_image . '.' . $extension;
		return $new_image;
	}

	public function resize() {
		$file_path_full_full = DIR_UPLOADS_IMAGES . DIR_FULL_FULL . '/' . $this->_imageOriginalName;
		if (file_exists($file_path_full_full)) {  //  Image with this name already exist in this folder
			$data['error'] = 'This image name already exist in the tmp_full folder, please user another name or delete the existing image.';  // Image is missing. TODO LOG it, this should never happen.
		}

		$filename_withoutExt = $this->_getNameWithoutExtension();

		$extension = $this->_getFileExtension();

		foreach($this->_imageSizes as $full_folder_path => $dimensions) {
			$new_image = $filename_withoutExt . '_' . $dimensions['w'] . 'x' . $dimensions['h'];  // File name with width and height.
			$new_image_full_path = $full_folder_path .'/'. $new_image . '.' . $extension;  // Getting the extension again and add the full path.

			if ( !is_file($new_image_full_path) ) {  // If file doesn't exist or if a new version is being created.
				$folders = substr($new_image_full_path, strpos($new_image_full_path, 'uploads/images') + strlen('uploads/images'));  // Get all the folders after uploads/images
				$folders = substr($folders, 0, strrpos( $folders, '/'));  // Removing the file from the folders.
				$directories = explode("/",$folders);  // Get All directories after upload images.
				foreach ($directories as $directory) {
					if (!is_dir(DIR_IMAGE_FULL_PATH . $directory)) {  // If the directory doesn't exist create it.
						@mkdir(DIR_IMAGE_FULL_PATH . $directory, 0777);
					}
				}

				if (!file_exists($new_image_full_path)) {
					\CI::load()->library('SimpleImage');
					\CI::SimpleImage()->load($this->_originalImageFullPath);
					if(is_numeric($dimensions['w'])  && is_numeric($dimensions['h'])) {
						\CI::SimpleImage()->resize($dimensions['w'], $dimensions['h']);
					}
					\CI::SimpleImage()->save($new_image_full_path);  // Save the new image
				}
			}
		}

		$newFileName = $filename_withoutExt.'_100x100'.'.'.$extension;  // Return Thumbnail
		return $newFileName;
		/*
		if ($this->request->server['HTTPS']) {

		} else {
			return DIR_IMAGE . $new_image;
		}*/
	}

	private function _utf8_substr($string, $offset, $length = null) {
		if ($length === null) {
			return mb_substr($string, $offset, $this->_utf8_strlen($string));
		} else {
			return mb_substr($string, $offset, $length);
		}
	}

	private function _utf8_strlen($string) {
		return iconv_strlen($string, 'UTF-8');
	}

	private function _utf8_strrpos($string, $needle) {
		return iconv_strrpos($string, $needle, 'UTF-8');
	}

	private function _setOriginalImageFullPath($name){ // Can be Image or Folder.
		$this->_originalImageFullPath = DIR_IMAGE_FULL_PATH . DIR_TMP_UPLOAD . '/' . $name;  // This is the folder where all the images will be uploaded to and converted from.
	}

	private function _setImageOriginalName($name){ // Can be Image or Folder.
		$this->_imageOriginalName = $name;
	}
}

/* End of file Media.php */
/* Location: ./application/controllers/Media.php */