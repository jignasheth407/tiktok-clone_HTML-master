<?php defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('UTC');
$currentTime = date('Y-m-d H:i:s');
 function getLocationInfoByIp(){
	/**
	 * code for get current location 
	 */
	$client  = @$_SERVER['HTTP_CLIENT_IP'];
	$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
	$remote  = @$_SERVER['REMOTE_ADDR'];
	$result  = array('country'=>'', 'state'=>'','city'=>'','country_code'=>'','currency_code'=>'','continent_name'=>'','ip_address'=>'');
	if(filter_var($client, FILTER_VALIDATE_IP)){
		$ip = $client;
	}elseif(filter_var($forward, FILTER_VALIDATE_IP)){
		$ip = $forward;
	}else{
		$ip = $remote;
	}
	$ip_data = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip));    
	if($ip_data && $ip_data->geoplugin_countryName != null){
		$result['country'] = $ip_data->geoplugin_countryName;
		$result['state'] = $ip_data->geoplugin_regionName;
		$result['city'] = $ip_data->geoplugin_city;
		$result['country_code'] = $ip_data->geoplugin_countryCode;
		$result['currency_code'] = $ip_data->geoplugin_currencyCode;
		$result['continent_name'] = $ip_data->geoplugin_continentName;
		$result['ip_address'] = $ip_data->geoplugin_request;
	}
	return $result;
}
function getcurrentBrowser(){
	/**
	 * get access code from browser name
	 */
		$attempt_history['browser_name']="Other";
		$attempt_history['browser_icon']="default.png";
		if(strrpos(strtolower($_SERVER["HTTP_USER_AGENT"]),strtolower("MSIE")))
		{
			$attempt_history['browser_name']="Internet Explorer";
			$attempt_history['browser_icon']= "explorer.png";
		}
		else if(strrpos(strtolower($_SERVER["HTTP_USER_AGENT"]),strtolower("Presto")))
		{
			$attempt_history['browser_name']="Opera";
			$attempt_history['browser_icon']= "opera.png";
			
		}
		else if(strrpos(strtolower($_SERVER["HTTP_USER_AGENT"]),strtolower("CHROME")))
		{
			$attempt_history['browser_name']="Google Chrome";
			$attempt_history['browser_icon']= "chrome.png";
		}
		else if(strrpos(strtolower($_SERVER["HTTP_USER_AGENT"]),strtolower("SAFARI")))
		{
			$attempt_history['browser_name']="Safari";
			$attempt_history['browser_icon']= "safari.png";

		}
		else if(strrpos(strtolower($_SERVER["HTTP_USER_AGENT"]),strtolower("FIREFOX")))
		{
			$attempt_history['browser_name']="Firefox";
			$attempt_history['browser_icon']= "mozilla.png";
			
		}
	return $attempt_history;
}

function createhistory($userid,$status,$action){
	date_default_timezone_set('UTC');

	$CI =& get_instance();
	$CI->load->model('common');
	$currentTime = date('Y-m-d H:i:s');;
		$browser = getcurrentBrowser();
		$history = getLocationInfoByIp();
		$loginHistory = [];
		$loginHistory['browser_name'] = $browser['browser_name'];
		$loginHistory['browser_icon'] = $browser['browser_icon'];
		$loginHistory['ip'] = $history['ip_address'];
		$loginHistory['on_time'] = $currentTime;
		$loginHistory['action'] = $action;
		$loginHistory['attempt_history'] = serialize($history);
		$loginHistory['user_id'] = $userid;
		$loginHistory['status'] = $status;
		$CI->common->insertData(TBL_IP,$loginHistory);
		
}
function createLogHistory($action,$data,$status,$message){
	date_default_timezone_set('UTC');
	$CI =& get_instance();
	$CI->load->model('common');
	$currentDateTime = date('Y-m-d H:i:s');
	$currentDate = date('Y-m-d');
	$loghistory['user_id'] = userid();
	$loghistory['date_time'] = $currentDateTime;
	$loghistory['on_date'] = $currentDate;
	$loghistory['action'] = $action;
	$loghistory['history'] = serialize($data);
	$loghistory['status'] = $status;
	$loghistory['faild_message'] = $message;
	$CI->common->insertData(TBL_LOGS,$loghistory);

}