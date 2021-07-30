<?php defined('BASEPATH') OR exit('No direct script access allowed');
function userid(){
	$CI =& get_instance();
return isset($CI->session->userdata['user']['id']) ?  $CI->session->userdata['user']['id'] : ""; 
}
function sponsor(){
	$CI =& get_instance();
 return  isset($CI->session->userdata['user']['sponsor_id']) ? $CI->session->userdata['user']['sponsor_id'] : "";
}
function adminid(){
	$CI =& get_instance();
	return isset($CI->session->userdata['admin']['id']) ? $CI->session->userdata['admin']['id'] : "";
}
function emailid(){
	$CI =& get_instance();
	return isset($CI->session->userdata['admin']['email']) ? $CI->session->userdata['admin']['email'] : "";
}
function type(){
	$CI =& get_instance();
	return isset($CI->session->userdata['admin']['type']) ? $CI->session->userdata['admin']['type'] : "";
}
function forbidden(){
	$ci =& get_instance();
	$ci->load->view('back/error/403');
}
function notfound(){
	$ci =& get_instance();
	$ci->load->view('back/error/404');
}
function jobimage($filename, $path)
	{
		$ci =& get_instance();
		$config['upload_path']          = $path;
		$config['allowed_types']        = 'pdf|doc|docx';
		$config['encrypt_name']        = TRUE;
		$config['remove_spaces']        = TRUE;
		$config['detect_mime']        = TRUE;
		$config['mod_mime_fix']        = TRUE;
		$ci->load->library('upload', $config);
		if (!$ci->upload->do_upload($filename)) {
			return false;
		} else {
			$name = $ci->upload->data();
			return $image = $name['file_name'];
		}
	}
function uploadimage($filename, $path)
	{
		$ci =& get_instance();
		$config['upload_path']          = $path;
		$config['allowed_types']        = 'gif|jpg|png|jpeg';
		$ci->load->library('upload', $config);
		if (!$ci->upload->do_upload($filename)) {
			return false;
		} else {
			$name = $ci->upload->data();
			return $image = $name['file_name'];
		}
	}
	function schoolLogo($filename, $path)
	{
		$ci =& get_instance();
		$config['upload_path']          = $path;
		$config['allowed_types']        = 'gif|jpg|png|jpeg';
		$ci->load->library('upload', $config);
		if (!$ci->upload->do_upload($filename)) {
			return false;
		} else {
			$name = $ci->upload->data();
			return $image = $name['file_name'];
		}
	}
	function multiimageUpload($files, $path)
	{
		$ci =& get_instance();
		$config = array(
			'upload_path'   => $path,
			'allowed_types' => 'jpg|gif|png|jpeg|png',
			'overwrite'     => 1,
		);
		$ci->load->library('upload', $config);
		$images = array();
		foreach ($files['name'] as $key => $image) {
			$_FILES['images[]']['name'] = $files['name'][$key];
			$_FILES['images[]']['type'] = $files['type'][$key];
			$_FILES['images[]']['tmp_name'] = $files['tmp_name'][$key];
			$_FILES['images[]']['error'] = $files['error'][$key];
			$_FILES['images[]']['size'] = $files['size'][$key];
			$config['file_name'] = $image;
			$imagey[] = $image;
			if ($ci->upload->do_upload('images[]')) {
				$images = $imagey;
			} else {
				return 0;
			}
		}
		return $images;
	}
function validateYouTubeUrl($url)
		{
			$rx = '~
			^(?:https?://)?                           # Optional protocol
			 (?:www[.])?                              # Optional sub-domain
			 (?:youtube[.]com/watch[?]v=|youtu[.]be/) # Mandatory domain name (w/ query string in .com)
			 ([^&]{11})                               # Video id of 11 characters as capture group 1
			  ~x';
		 if(preg_match($rx, $url)){
			 return true;
		 }else{
			 return false;
		 }
		}
	function getYoutubeEmbedUrl($url)
	{
		$shortUrlRegex = '/youtu.be\/([a-zA-Z0-9_]+)\??/i';
		$longUrlRegex = '/youtube.com\/((?:embed)|(?:watch))((?:\?v\=)|(?:\/))(\w+)/i';
		if (preg_match($longUrlRegex, $url, $matches)) {
		$id = $matches[count($matches) - 1];
		}
		if (preg_match($shortUrlRegex, $url, $matches)) {
		$id = $matches[count($matches) - 1];
		}
		return isset($id) ? $id : 'error';
	}

function message($message, $contact)
	{
		$authKey = "d768fa521747be1bf7a2caf1b6427fe1";
		$senderId = "AYDSOP";
		$route = "template";
		$mobileNumber = $contact;
		$postData = array(
			'authkey' => $authKey,
			'mobiles' => $mobileNumber,
			'message' => $message,
			'sender' => $senderId,
			'route' => $route
		);
		$url = "http://sms.bulksmsserviceproviders.com/api/send_http.php";
		// reciver account to get a message
		$ch = curl_init();
		curl_setopt_array($ch, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => $postData
		));
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		$output = curl_exec($ch);
		if (curl_errno($ch)) {
			echo 'error:' . curl_error($ch);
		}
		curl_close($ch);
	}
	/*================================end======================end=============================end==========*/
// function message($message, $mobile_number)
//     {
//         $AUTH_KEY = 'a044df5e4a11b911378e5d66a2e8b8f';
//         $url = 'http://msg.icloudsms.com/rest/services/sendSMS/sendGroupSms?AUTH_KEY='.$AUTH_KEY.'&message='.$message.'&senderId=TSHOPY&routeId=1&mobileNos='.$mobile_number.'&smsContentType=english';
//         $curl = curl_init();
//         curl_setopt_array($curl, array(
//           CURLOPT_URL => $url,
//           CURLOPT_RETURNTRANSFER => true,
//           CURLOPT_ENCODING => "",
//           CURLOPT_MAXREDIRS => 10,
//           CURLOPT_TIMEOUT => 30,
//           CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//           CURLOPT_CUSTOMREQUEST => "GET",
//           CURLOPT_HTTPHEADER => array(
//             "cache-control: no-cache",
//             "postman-token: cf477dcf-c2ec-aabe-b39a-d01e84066949"
//           ),
//         ));
//         $response = curl_exec($curl);
//         $err = curl_error($curl);
//         curl_close($curl);
//         if ($err) {
//           //echo "cURL Error #:" . $err;
//         } else {
//           //echo $response;
//         }
//     }
function time_ago_in_php($timestamp){
	date_default_timezone_set("Asia/Kolkata");         
	$time_ago        = strtotime($timestamp);
	$current_time    = time();
	$time_difference = $current_time - $time_ago;
	$seconds         = $time_difference;
	$minutes = round($seconds / 60); // value 60 is seconds  
	$hours   = round($seconds / 3600); //value 3600 is 60 minutes * 60 sec  
	$days    = round($seconds / 86400); //86400 = 24 * 60 * 60;  
	$weeks   = round($seconds / 604800); // 7*24*60*60;  
	$months  = round($seconds / 2629440); //((365+365+365+365+366)/5/12)*24*60*60  
	$years   = round($seconds / 31553280); //(365+365+365+365+366)/5 * 24 * 60 * 60
	if ($seconds <= 60){
	  return "Just Now";
	} else if ($minutes <= 60){
	  if ($minutes == 1){
		return "one minute ago";
	  } else {
		return "$minutes minutes ago";
	  }
	} else if ($hours <= 24){
	  if ($hours == 1){
		return "an hour ago";
	  } else {
		return "$hours hrs ago";
	  }
	} else if ($days <= 7){
	  if ($days == 1){
		return "yesterday";
	  } else {
		return "$days days ago";
	  }
	} else if ($weeks <= 4.3){
	  if ($weeks == 1){
		return "a week ago";
	  } else {
		return "$weeks weeks ago";
	  }
	} else if ($months <= 12){
	  if ($months == 1){
		return "a month ago";
	  } else {
		return "$months months ago";
	  }
	} else {
	  if ($years == 1){
		return "one year ago";
	  } else {
		return "$years years ago";
	  }
	}
  }