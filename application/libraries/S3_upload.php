<?php

/**
 * Amazon S3 Upload PHP class
 *
 * @version 0.1
 */
class S3_upload {

	function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->library('s3');

		$this->CI->config->load('s3', TRUE);
		$s3_config = $this->CI->config->item('s3');
		$this->bucket_name = $s3_config['bucket_name'];
	
		$this->folder_name = $s3_config['video_path'];
		$this->image_path = $s3_config['image_path'];
		$this->s3_url = $s3_config['s3_url'];
	}

	function generateRandomString($length = 15) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
	function upload_file($file_path,$key)
	{
		// echo "<pre>"; print_r($file_path); 
		// echo "key ". $key; die;
		// generate unique filename
		$file = pathinfo($file_path);
		//print_r($file); die;
		$s3_file = $file['filename'].'-'.$this->generateRandomString().'.'.$file['extension'];
		$mime_type = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $file_path);
		$saved = $this->CI->s3->putObjectFile(
			$file_path,
			$this->bucket_name,
			$key.$s3_file,
			S3::ACL_PUBLIC_READ,
			array(),
			$mime_type
		);
		if ($saved) {
			//return $this->s3_url.$this->bucket_name.'/'.$this->folder_name.$s3_file;
			return $s3_file;
		}else{
			return false;
		}
	}

	function upload_baseImage($file_path)
	{
		// generate unique filename
		// $file = pathinfo($file_path);
		// //print_r($file); die;
		//$s3_file = $file['filename'].$file['extension'];
		echo $mime_type = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $file_path); die;
		$saved = $this->CI->s3->putObjectFile(
			$file_path,
			$this->bucket_name,
			$this->image_path.$s3_file,
			S3::ACL_PUBLIC_READ,
			array(),
			$mime_type
		);
		if ($saved) {
			//return $this->s3_url.$this->bucket_name.'/'.$this->folder_name.$s3_file;
			return $s3_file;
		}else{
			return fale;
		}
	}

	function musicupload($path,$file_path,$key)
	{
		$tempFilePath = basename($file_path);
		$tempFile = fopen($tempFilePath, "w") or die("Error: Unable to open file.");
		$fileContents = file_get_contents($file_path);
		$tempFile = file_put_contents($tempFilePath, $fileContents);
		$mime_type = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $file_path);
		$saved = $this->CI->s3->putObject(
			array(
				'Bucket'=>$this->bucket_name,
				'Key' =>  $key,
				'SourceFile' => $tempFilePath,
				'StorageClass' => 'REDUCED_REDUNDANCY'
			)
		);
		if ($saved) {
			//return $this->s3_url.$this->bucket_name.'/'.$this->folder_name.$s3_file;
			return $tempFilePath;
		}else{
			return false;
		}
	}
}