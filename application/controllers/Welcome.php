<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// require_once 'vendor/autoload.php'; 
ini_set('memory_limit', '-1');
class Welcome extends CI_Controller {
	public $i=1;
	public $level=1;
	public function index(){
		
		$this->load->view('index');
		
	}
	function adminlogin(){
		if(!empty($_POST)){
			extract($_POST);
			if($data = $this->common->accessrecord(TBL_USER,[],['email'=>$email,'password'=>sha1($password),'type'=>1],'row')){
					$session['id'] = $data->id;
					$this->session->set_userdata('admin',$session);
					redirect('authdashboard');
			}else{	
				$this->session->set_flashdata('error','Login Credentials not matched');
			}
		}
		$this->load->view('adminlogin');
	}
	public function login()
	{
		
		$data = array('email'=>$this->input->post('email',true),'password'=>sha1($this->input->post('password',true)));
		if($admin= $this->common->accessrecord(TBL_USER,[],$data,'row')){
			if($admin->type==1 || $admin->type==2){
			$session['id'] =$admin->id;
			$this->session->set_userdata('admin',$session);
				
			redirect('dashboard'); 
			}else{
			
				$this->session->set_flashdata('error','email address or password not mathced');	
			}
		}else{
			
			$this->session->set_flashdata('error','email address or password not mathced');
		}

		$this->load->view('login');
	}
	
	
	function getusername(){
		$id = strtoupper($_GET['id']);
		$string = substr($id,0,PRE_COUNT);
		if($string==PREFIX){
			$id = substr($id,PRE_COUNT);
		$array = array();
		if($data = $this->common->accessrecord(TBL_USER,[],['sponsor_id'=>$id],'row')){
			$array = array('success'=>1,'name'=>$data->full_name,'id'=>$data->id);
		}else{
			$array = array('success'=>0,'name'=>'Invalid sponsor id','id');
		}
	}else{
		$array = array('success'=>0,'name'=>'Invalid sponsor id','id');
	}
		echo json_encode($array);
	}
	function userlogin(){
			$this->form_validation->set_rules('sponsor_id','User id','trim|required');
			$this->form_validation->set_rules('password','Password','required');
			if($this->form_validation->run()==false){
			}else{
			extract($_POST);
			$userid = 0;
			$action = 'Login';
		    if(strtoupper(substr($sponsor_id,0,PRE_COUNT))==PREFIX){
				$userid = substr($sponsor_id,PRE_COUNT);
				if($data = $this->common->accessrecord(TBL_USER,[],['sponsor_id'=>$userid,'password'=>sha1($password)],'row')){
						$session['id'] = $data->id;
						$session['sponsor_id'] = $data->sponsor_id;
						$this->session->set_userdata('user',$session);
						createhistory($userid,1,$action);
						redirect('dashboard');
				}else{
					createhistory($userid,0,$action);
					$this->session->set_flashdata('msg','Invalid user id and password');
					//$array['wrong'] = array('Invalid login creadentials');
				}
			}else{
				createhistory($userid,0,$action);
				$this->session->set_flashdata('msg','Invalid user id and password');
				//$array['wrong'] = array('Invalid login creadentials');
			}
		}
		
		$this->load->view('login');
		
	}
	function checkUpline($str){
		$upper = strtoupper($str);
		$string = substr($upper,0,PRE_COUNT);
		if($string==PREFIX){
			$str = substr($str,PRE_COUNT);
			if($check= $this->common->accessrecord(TBL_USER,[],['sponsor_id'=>$str],'row')){
						return true;
			}else{
					$this->form_validation->set_message('checkUpline','Sponsor id not valid');
					return false;
			}
		}else{
			$this->form_validation->set_message('checkUpline','Sponsor id not valid');
			return false;
		}
	}
	function checksponsor($str){
		if($str==''){
			$this->form_validation->set_message('checksponsor','Sponsor id is required');
			return false;
		}else{
			$upper = strtoupper($str);
			$string = substr($upper,0,PRE_COUNT);
			if($string==PREFIX){
				if($check= $this->common->accessrecord(TBL_USER,[],['sponsor_id'=>substr($str,PRE_COUNT)],'row')){
					return true;
					// if($check->status==1){
					// 	return true;
					// }else{
					// 	$this->form_validation->set_message('checksponsor','Sponsor id not active');
					// 	return false;
					// }
				}else{
					$this->form_validation->set_message('checksponsor','Sponsor id not valid');
					return false;
				}
		}else{
			$this->form_validation->set_message('checksponsor','Sponsor id not valid');
			return false;
		}
		}
	}
	function checkpackage($str){
		if($str==''){
			$this->form_validation->set_message('checkpackage','Joining Package is required');
			return false;
		}else{
			if($this->common->accessrecord(TBL_PACKAGE,[],['pv'=>$str],'row')){
				return true;
			}else{
				$this->form_validation->set_message('checkpackage','Soory Illegel price choose');
				return false;
			}
		}
	}
	function checkmobile($str){
		if($str==''){
			$this->form_validation->set_message('checkmobile','Please enter mobile number');
			return false;
		}else{
			if (!preg_match('/^[0-9]*$/', $str)) {
				$this->form_validation->set_message('checkmobile','Mobile number accept only number');
				return false;
			}else{
				if(strlen($str)==10){
					// $rand = rand(10000,99999);
					// $message = 'One Time Password is '.$rand;
					// if(empty($this->session->userdata('message'))){
					// 	message(urlencode($message),$str);
					// 	$this->session->set_userdata('message',$rand);
					// }
					return true;
				}else{
					$this->form_validation->set_message('checkmobile','Mobile number accept only 10 digit');
				return false;
				}
			}
		}
	}
	function checkotp($str){
		if($str==''){
			$this->form_validation->set_message('checkotp','OTP feild is required');
			return false;
		}else{
			if($this->session->userdata('message')==$str){
				return true;
			}else{
				$this->form_validation->set_message('checkotp','OTP not valid');
			return false;
			}
		}
	}
	function resendsignupotp(){
		extract($_POST);
		$rand = rand(10000,99999);
		$message = 'One Time Password is '.$rand;
		message(urlencode($message),$mobile);
		$this->session->set_userdata('message',$rand);
		echo 1;
	}
	function registration(){
		if(!empty($_POST)){
		if($this->input->post('added_by'))
		$this->form_validation->set_rules('added_by','Sponsor id','trim|callback_checksponsor');
		//$this->form_validation->set_rules('placement','Placement','required');
		$this->form_validation->set_rules('full_name','full_name','trim|required|xss_clean');
		$this->form_validation->set_rules('email','email','required|valid_email');
		$this->form_validation->set_rules('mobile','Mobile number','trim|callback_checkmobile');
		$this->form_validation->set_rules('password','password','required');
		// if(!empty($this->input->post('upline'))){
		// 	$this->form_validation->set_rules('upline','upline','trim|callback_checkUpline');
		// }
		$this->form_validation->set_rules('confirmpassword','password','required|matches[password]');
		//$this->form_validation->set_rules('otp','OTP','callback_checkotp');
		$this->form_validation->set_rules('checkbox','Term & Condition','required');
		if($this->form_validation->run()==false){
			$array['error'] = array(
				'added_by' => form_error('added_by'),
				'password' => form_error('password'),
				'confirmpassword' => form_error('confirmpassword'),
				'mobile' => form_error('mobile'),
				'email' => form_error('email'),
				'full_name' => form_error('full_name'),
				'checkbox' => form_error('checkbox'),
				//'placement' => form_error('placement'),
				'upline' => form_error('upline')
				//'package' => form_error('package')
			);
		}else{
			extract($_POST);
			$this->session->unset_userdata('message');
			$this->session->sess_destroy();
			$insert['refferal_by'] = !empty($added_by) ? $added_by : '12345678';
			$insert['sponsor_id'] =  $this->genrateids();
			$insert['full_name'] = $full_name;
			$insert['email'] = $email;
			$insert['password'] = sha1($password);
			$insert['pwd'] = $password;
			$lastid = $this->common->insertData(TBL_USER,$insert);
			if($lastid){
				$array['success'] = '<div class="row">
										<div class="col-6">
											<p style="color:mediumseagreen;"><b>User id: </b> '.PREFIX . $insert['sponsor_id'] . '</p>
										</div>
										<div class="col-6">
											<p style="color:mediumseagreen;"><b>Password: </b>' . $password . '</p>
										</div>
									</div>';
			}else{
				$array['wrong'] = 'Something is wrong please try after some time';
			}

		}
		echo json_encode($array);
		}else{
			$this->load->view('registration');
		}
	}
	function genrateids(){
		$random = mt_rand(10000000,99999999);
		if($this->common->accessrecord(TBL_USER,[],['sponsor_id'=>$random],'row')){
			$this->genrateids();
		}else{
			return $random;
		}
	}
	function distributeReferralPoint($id,$newid){
		echo $this->i++;
		$data = $this->common->accessrecord(TBL_USER,['sponsor_id'],['refferal_by'=>$id],'row');
		$array=[];
		if(!empty($data->sponsor_id)){
				if($this->i<5){
					if($this->i==2){
						$level=1;
						$point=10;
						$data->sponsor_id = $id;
					}
					if($this->i==3){
						$level=2;
						$point=5;
					}
					if($this->i==4){
						$level=3;
						$point=3;
					}
					$array[] = array('to_sponsor_id'=>$data->sponsor_id,'from_sponsor_id'=>$newid,'level'=>$level,'point'=>$point);
					$this->distributeReferralPoint($data->sponsor_id,$newid);
					$this->common->insertBatch(TBL_REFFERAL_POINT,$array);
			}
			
		}
	   
	}
	function check_left_postion($id)
	{
		$this->common->getLeftChild($id);
		$get = $this->common->getChildLeftempty();
		return $get->self_id;
	}
	function check_right_postion($id)
	{
		$this->common->getRightChild($id);
		$get = $this->common->getChildLeftempty();
		return $get->self_id;
	}
	function test($id='12345678'){
		$level=1;
		$data = $this->buildTree($id,$level);
		echo "<pre>"; print_r($data);
	}
	function buildTree($parent_id,$level) {
		$branch = array();
		$data = $this->common->accessrecord(TBL_USER,['refferal_by,sponsor_id,full_name'],['refferal_by'=>$parent_id],'result');
		$data = array_map(function ($value) {
		  if(!$value->sponsor_id){
			//unset($value->sponsor_id);
		  }
				  return (array)$value;
				}, $data);
	  if(count($data)){
		$demo=1;
		  foreach ($data as $element) {
				  $children = $this->buildTree($element['sponsor_id'],$level);
				  if ($children) {
					  $element['children'] = $children;
					  $element['level'] = $demo+1;
				  }else{
					$element['level'] =$demo++;
				  }
				  //$branch['level'] = $level++;
				  $branch[] = $element;
				  
		  }
	  }
		return $branch;
  }

  function uploadoVedio(){
	  if(!empty($_FILES)){
		
		$ffmpeg = FFMpeg\FFMpeg::create();
		$video = $ffmpeg->open('video.mpg');
		$video
			->filters()
			->resize(new FFMpeg\Coordinate\Dimension(320, 240))
			->synchronize();
		$video
			->frame(FFMpeg\Coordinate\TimeCode::fromSeconds(10))
			->save('frame.jpg');
		$video
			->save(new FFMpeg\Format\Video\X264(), 'export-x264.mp4')
			->save(new FFMpeg\Format\Video\WMV(), 'export-wmv.wmv')
			->save(new FFMpeg\Format\Video\WebM(), 'export-webm.webm');
	  }else{
		  $this->load->view('vedio');
	  }
	}
	
	function down(){
		$data = $this->common->accessrecord(TBL_TASKCATEGORYVIDEOS,[],['ID'=>2],'result');
		foreach($data as $row){
			$url_to_image = BASE_URL.VIDEO_PATH.$row->path;
			$my_save_dir = 'E:/aws/new/';
			$filename = basename($url_to_image);
			$complete_save_loc = $my_save_dir . $filename;
			file_put_contents($complete_save_loc, file_get_contents($url_to_image));
		//	sleep(10);
		}
	}
	function aboutus(){
		echo "About us coming soon";
	}
	function privacypolicy(){
		$this->load->view('privacy_policy');
	}
	function termscondition(){
		$this->load->view('termsofuse');
	}
	function cookie_policy(){
		$this->load->view('cokkie_policy');
	}
	function law_policy(){
		$this->load->view('law');
	}
	function comminity_policy()
	{
		$this->load->view('community_guidlines');
	}
	function guidline(){
		echo "grand";
	}
	function copyright_policy(){
		$this->load->view('copyright');
	}

	function unl(){
		$data = $this->common->accessrecord(TBL_TASKCATEGORYVIDEOS,[],[],'result');
		foreach ($data as $row) {
			unlink(VIDEO_THUMBNAIL_PATH.$row->thumbnail);
		}
	}

	
	function convert(){

		$ids = $this->common->accessrecord(TBL_USER_MUSIC,['GROUP_CONCAT(video_id) as ids'],[],'row')->ids;
		$array[] = array('key'=>' WHERE '.TBL_TASKCATEGORYVIDEOS.'.ID NOT IN ','value'=>'('.$ids.')');
		$data = $this->common->accessrecordwithjoin([TBL_USER.'.user_name,'.TBL_USER.'.full_name,'.TBL_TASKCATEGORYVIDEOS.'.*'],TBL_USER,TBL_TASKCATEGORYVIDEOS,[TBL_USER.'.sponsor_id',TBL_TASKCATEGORYVIDEOS.'.customer_id'],[],'inner',$array);
		//echo $this->db->last_query(); die;
		//echo "<pre>"; print_r($data); die;
		
		$savemp3 = ABS_PATH.MP3;
		$saveaac = ABS_PATH.AAC;
		$name=array();
		foreach($data as $row){
			   $filename = pathinfo($row->path, PATHINFO_FILENAME);
			   $mp4 = MUSIC_VIDEO."DIR_".$row->customer_id."/".$filename.".mp4";
			   $mp3folder = $savemp3.$row->customer_id;
			   $mfilename = $filename.'.mp3';
			   $array['original'] = $mfilename;
			   $array['video_id'] = $row->ID;
			   $name[] = $array;
			  $music_name = !empty($row->user_name) ? "original sound - ". $row->user_name . " - ". $row->full_name : "original sound - " .$row->full_name;
				if(!file_exists($mp3folder)){
				  mkdir($mp3folder);
			   }
			   $aacfolder = $saveaac.$row->customer_id;
			   if(!file_exists($aacfolder)){
					mkdir($aacfolder);
			 	}
			    $mp3commd =  'ffmpeg -i '.$mp4.' -codec:a libmp3lame -qscale:a 9 '.$mp3folder.'/'.$filename.'.mp3 2>&1';
				$acccomd = 'ffmpeg -i '.$mp4.' -vn -acodec copy '.$aacfolder.'/'.$filename.'.aac 2>&1';
			   exec($mp3commd,$output,$response);
			   exec($acccomd);
			  if($response==0){
				  $music['video_id'] = $row->ID;
				  $music['music_name'] = $music_name;
				  $music['sponsor_id'] = $row->customer_id;
				  $music['original'] = $mfilename;
				  $this->common->insertData(TBL_USER_MUSIC,$music);
			  }
			}
			//$this->db->update_batch(TBL_USER_MUSIC,$name,'video_id');
		//echo"<pre>"; print_r($name);
		

	}

	function homevideo(){
		$limit = 10;
		$where=[];
		$array[] = ['key'=>' LIMIT ','value'=>$limit];
		$this->data['view_vedio'] = $this->common->accessrecordwithjoin([TBL_USER.'.full_name,'.TBL_USER.'.user_name,CONCAT("'.BASE_URL.PROFILE_PIC.'",image) as image,'.TBL_TASKCATEGORYVIDEOS.'.*'],TBL_USER,TBL_TASKCATEGORYVIDEOS,[TBL_USER.'.sponsor_id',TBL_TASKCATEGORYVIDEOS.'.customer_id'],[],'inner',$array);

		$this->data['allcount'] = $this->common->accessrecord(TBL_TASKCATEGORYVIDEOS,['COUNT(ID) as total'],$where,'row')->total;
		$this->load->view('admin/video/web_view',$this->data);
	}
	
	function mp3toaac(){
		$aacPath =  ABS_PATH."assets/music/";
		$songname = "mera dil bhi kitna pagal hai";
		$handle = fopen($_FILES["UploadFileName"]["tmp_name"], 'r');
		$acccomd = 'ffmpeg -i '.$mp4.' -vn -acodec copy '.$aacPath.'/'.$songname.'.aac 2>&1';
	}
}

