<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Kolkata');
class Admin extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->library('S3_upload');
		$this->load->library('S3');
		$this->config->load('s3', TRUE);
		$s3_config = $this->config->item('s3');
		$this->bucket_name = $s3_config['bucket_name'];
		$this->video_image_path = $s3_config['image_path'];
		$this->video_path = $s3_config['video_path'];
		$this->s3_url = $s3_config['s3_url'];
		if(empty(adminid())){
			redirect('wedoadmin_panel_');
		}
	}
	public function dashboard()
	{
		
		$this->data['page'] ='index';
		$this->data['content'] = 'dashboard/index';
		$this->load->view('template',$this->data);
	}
	function profile(){
		$this->form_validation->set_rules('full_name','Full name','required|xss_clean');
		$this->form_validation->set_rules('mobile','mobile','required|is_numeric|min_length[10]|max_length[10]');
		if($this->form_validation->run() == FALSE){}else{
			$this->common->updateData(TBL_USER,$_POST,['id'=>adminid()]);
			$this->session->set_flashdata('heading','Sucess Profile updated');
			$this->session->set_flashdata('success','Profile updated successfully');
		}
		$this->data['profile'] = $this->common->accessrecord(TBL_USER,[],['id'=>adminid()],'row');
		$this->data['page'] ='profile';
		$this->data['content'] = 'profile/profile';
		$this->load->view('template',$this->data);
	}
	function emailupdate(){
	 
		$this->form_validation->set_rules('email','Email','required|valid_email');
		if($this->form_validation->run() == FALSE){
			$array['error'] = array('email'=>form_error('email'));
		}else{
			extract($_POST);
			$getEmail = $this->common->accessrecord(TBL_USER,['email'],['id'=>adminid()],'row');
			if($getEmail->email==$email){
				$array['wrong'] = array('msg'=>'Already updated','success'=>0);
			}elseif(!$this->common->accessrecord(TBL_USER,['email'],['email'=>$email],'row')){
				$this->common->updateData(TBL_USER,['email'=>$email],['id'=>adminid()]);
				$array['wrong'] = array('msg'=>'Email updated successfully','success'=>1);
			}else{
				$array['wrong'] = array('msg'=>'Email Already Taken','success'=>0);
			}
		}
		echo json_encode($array);
	}
	function passwordupdate(){
		$this->form_validation->set_rules('old','Old Password','required');
		$this->form_validation->set_rules('new_password','New Password','required');
		$this->form_validation->set_rules('confirm','Confirm Password','required|matches[new_password]');
		if($this->form_validation->run() == FALSE){
			$array['error'] = array('old'=>form_error('old'),
									'new_password' => form_error('new_password'),
									'confirm' => form_error('confirm')
								);
		}else{
			extract($_POST);
				$this->common->updateData(TBL_USER,['password'=>sha1($new_password)],['id'=>adminid()]);
				$array['wrong'] = array('msg'=>'Password Upated Successfully','success'=>1);
		}
		echo json_encode($array);
	}
	
	function all_video(){
		$type = base64_decode($_GET['type']);
		if($type!='-1'){
			$array[] = array('key'=>' WHERE '.TBL_TASKCATEGORYVIDEOS.'.status=','value'=>$type);
		}
		$array[] = ['key'=>' GROUP BY '.TBL_TASKCATEGORYVIDEOS.'.customer_id ','value'=>''];
		$d=$this->data['all'] = $this->common->accessrecordwithjoin([TBL_USER.'.full_name,'.TBL_USER.'.user_name,CONCAT("'.BASE_URL.PROFILE_PIC.'",image) as image,COUNT('.TBL_TASKCATEGORYVIDEOS.'.id) as total,SUM(CASE WHEN '.TBL_TASKCATEGORYVIDEOS.'.status=1 THEN 1 ELSE 0 END) as active_video, SUM(CASE WHEN '.TBL_TASKCATEGORYVIDEOS.'.status=0 THEN 1 ELSE 0 END) as pending_video ,SUM(CASE WHEN '.TBL_TASKCATEGORYVIDEOS.'.status=2 THEN 1 ELSE 0 END) as rejected_video,'.TBL_TASKCATEGORYVIDEOS.'.*'],TBL_USER,TBL_TASKCATEGORYVIDEOS,[TBL_USER.'.sponsor_id',TBL_TASKCATEGORYVIDEOS.'.customer_id'],[],'inner',$array);
		$this->data['page'] ='all_videos';
		$this->data['content'] = 'video/all_videos';
		$this->load->view('template',$this->data);
	}
	function view_video(){
		
		$limit=3;
		$type = !empty($_GET['type']) ? base64_decode($_GET['type']) : '';
		$sponsor_id = !empty($_GET['id']) ? base64_decode($_GET['id']) : '';
		$want = !empty($_GET['want']) ? base64_decode($_GET['want']) : '';
		$where=[];
		if(empty($want)){
			$where['customer_id'] = $sponsor_id;
			$array[] = ['key'=>' WHERE '.TBL_TASKCATEGORYVIDEOS.'.customer_id=','value'=>$sponsor_id];
		}
		if($type!='-1'){
			$array[] = ['key'=>' AND '.TBL_TASKCATEGORYVIDEOS.'.status=','value'=>$type];
			if($type==1){
				$array[] = ['key'=>' AND '.TBL_TASKCATEGORYVIDEOS.'.is_home=','value'=>1];
			}
			$where['status'] = $type;
		}
		$array[] = ['key'=>' LIMIT ','value'=>$limit];
		$this->data['view_vedio'] = $this->common->accessrecordwithjoin([TBL_USER.'.full_name,'.TBL_USER.'.user_name,CONCAT("'.BASE_URL.PROFILE_PIC.'",image) as image,'.TBL_TASKCATEGORYVIDEOS.'.*'],TBL_USER,TBL_TASKCATEGORYVIDEOS,[TBL_USER.'.sponsor_id',TBL_TASKCATEGORYVIDEOS.'.customer_id'],[],'inner',$array);

		$this->data['allcount'] = $this->common->accessrecord(TBL_TASKCATEGORYVIDEOS,['COUNT(ID) as total'],$where,'row')->total;
		
		if($sponsor_id)
		$this->data['userinfo'] = $this->common->accessrecord(TBL_USER,['CONCAT("'.PREFIX.'",sponsor_id) as sponsor_id,user_name,full_name'],['sponsor_id'=>$sponsor_id],'row');
		$this->data['page'] ='view_videos';
		$this->data['content'] = 'video/view_videos';
		$this->load->view('template',$this->data);
	}
	
	function getnextvideo(){
		extract($_POST);
		$perpage=3;
		$type = !empty($type) ? base64_decode($type) : '';
		$sponsorid = !empty($sponsorid) ? base64_decode($sponsorid) : '';
		if(empty($want))
		$array[] = ['key'=>' WHERE '.TBL_TASKCATEGORYVIDEOS.'.customer_id=','value'=>$sponsorid];
		if($type!='-1'){
			$array[] = ['key'=>' AND '.TBL_TASKCATEGORYVIDEOS.'.status=','value'=>$type];
			if($type==1){
				$array[] = ['key'=>' AND '.TBL_TASKCATEGORYVIDEOS.'.is_home=','value'=>1];
			}
		}
		$array[] = ['key'=>' LIMIT '.$limit.' ,','value'=>$perpage];
		$data['view_vedio'] = $this->common->accessrecordwithjoin([TBL_USER.'.full_name,'.TBL_USER.'.user_name,CONCAT("'.BASE_URL.PROFILE_PIC.'",image) as image,'.TBL_TASKCATEGORYVIDEOS.'.*'],TBL_USER,TBL_TASKCATEGORYVIDEOS,[TBL_USER.'.sponsor_id',TBL_TASKCATEGORYVIDEOS.'.customer_id'],[],'inner',$array);
			$this->data['userinfo'] = $this->common->accessrecord(TBL_USER,['CONCAT("'.PREFIX.'",sponsor_id) as sponsor_id,user_name,full_name'],['sponsor_id'=>$sponsorid],'row');
		$res=array();
		if(count($data['view_vedio'])){
			$res['data'] = $this->load->view('admin/video/next_videos',$data,true);
			$res['status'] =1;
			echo json_encode($res);die;
		}else{
			$res['status'] =0;
			echo json_encode($res);die;
		}
	}
	function updation(){
		//extract($_POST);
		unset($_POST['link'][0]);
		$data = explode('&', $_POST['link'][1]);
		$id = $data[0];
		$status = $data[1];
		
			$check = $this->common->accessrecord(TBL_TASKCATEGORYVIDEOS,['status'],['id'=>$id],'row')->status;
		if(($status!=3) || ($status==3 && $check==1)){
			$stdata['status'] = $status;
			if($status==3){
				$stdata['status'] =1;	
				$stdata['is_home'] =1;	
			}elseif($status==2){
				$stdata['is_home'] =0;	
			}elseif($status==4){
				$stdata['is_home'] = 1;
				$stdata['is_popular'] =1;
			}
			$this->common->updateData(TBL_TASKCATEGORYVIDEOS,$stdata,['ID'=>$id]);
			if($status==1){
				$msg = 'User video successfully activated, now is available for home screen';
				$class='success';
				$button='btn btn-success btn-block btn-lg font-16';
				$text='Approved';
			}elseif($status==3){
				$msg = 'User video successfully transfer for home screen, now is available in home screen';
				$class='success';
				$button='btn btn-info btn-block btn-lg font-16';
				$text='In Home Screen';
			}elseif($status==4){
				$msg = 'User video successfully add for home popular screen';
				$class='success';
				$button='btn btn-info btn-block btn-lg font-16';
				$text='Home + Polular';
			}else{
				$msg = 'User video deactivated, is not available for home screen, but available in own profile screen';
				$class='error';
				$button='btn btn-danger btn-block btn-lg font-16';
				$text='Rejected';
			}
		}else{
				$msg = 'Befor activation, video can`t be placed in home screen';
				$class='error';
				$button='btn btn-danger btn-block btn-lg font-16';
				$text='Warning! Approved first!';
		}
		echo json_encode(array('msg'=>$msg,'class'=>$class,'button'=>$button,'text'=>$text,'id'=>$id));
	}
	function category_list(){
		if(empty($_GET['id'])){
			$data = $this->common->accessrecord(TBL_CATEGORY,[],['parent_id'=>0],'result');
			foreach($data as $row){
				$subCount =  $this->common->accessrecord(TBL_CATEGORY,['COUNT(id) as total, GROUP_CONCAT(id) as subid'],['parent_id'=>$row->id],'row');
				$ids = strlen($subCount->subid>0) ? $subCount->subid : $row->id;

				$row->totalSong = $this->db->query('SELECT COUNT(id) as total FROM '. TBL_CATEGORY_MUSIC.' WHERE category_id IN ('.$ids.')')->row()->total;
				$row->subCount = $subCount->total;
			}
		}else{
			$id = base64_decode($_GET['id']);
			$data = $this->common->accessrecord(TBL_CATEGORY,[],['parent_id'=>$id],'result');
			foreach($data as $row){
				$row->totalSong = $this->common->accessrecord(TBL_CATEGORY_MUSIC,['COUNT(id) as total'],['category_id'=>$row->id],'row')->total;
			}
			$this->data['catename'] = $this->common->accessrecord(TBL_CATEGORY,['name'],['id'=>$id],'row');
		}
		//echo "<pre>"; print_r($data); die;
		$this->data['category'] = $data;
		$this->data['page'] ='category_list';
		$this->data['content'] = 'category/category_list';
		$this->load->view('template',$this->data);
	}
	function add_music_category(){
		$id = !empty($_GET['id']) ? base64_decode($_GET['id']) : 0;
		if(!empty($_POST)){
			extract($_POST);
				if((!empty($id)) || (!empty($_FILES['image']['name']))){
					if(!empty($_FILES['image']['name'])){
						$image = musicCategory('image',MUSIC_ICON,500);
						if($image['success']==0){
							$array = array('msg'=> $image['msg'],'success'=>0);	
						}else{
							$data['icon'] = $image['msg'];
						}
					}
					$data['name'] = $name;
					if($id){
						
						$this->common->updateData(TBL_CATEGORY,$data,['id'=>$id]);
						$array = array('msg'=>' Category record Updated successfully','success'=>1);
					}else{
						$array = array('msg'=>' Category record created successfully','success'=>1);
						$this->common->insertData(TBL_CATEGORY,$data);
					}
				}else{
					$array = array('msg'=>' Please choose image file, it should be less than or equal to 100kb and .png format','success'=>0);
				}
				echo json_encode($array);
		}else{
			if($id)
			$this->data['record'] = $this->common->accessrecord(TBL_CATEGORY,[],['id'=>$id],'row');
			$this->data['page'] ='add_category';
			$this->data['content'] = 'category/add_category';
			$this->load->view('template',$this->data);
		}
	}
	function add_music_sub_category(){
		$id = !empty($_GET['id']) ? base64_decode($_GET['id']) : 0;
		if(!empty($_POST)){
			extract($_POST);
				$isTrue=1;
				if((!empty($id)) || (!empty($_FILES['image']['name']))){
					if(!empty($_FILES['image']['name'])){
						$image = musicCategory('image',MUSIC_ICON,'500');
						if($image['success']==0){
							$array = array('msg'=> $image['msg'],'success'=>0);	
							$isTrue=0;
						}else{
							$data['icon'] = $image['msg'];
						}
					}
					if($isTrue==1){
						$data['name'] = $name;
						$data['parent_id'] = $parent_id;
						if($id){
							$this->common->updateData(TBL_CATEGORY,$data,['id'=>$id]);
							$array = array('msg'=>' Sub-Category record Updated successfully','success'=>1);
						}else{
							$array = array('msg'=>' Sub-Category record created successfully','success'=>1);
							$this->common->insertData(TBL_CATEGORY,$data);
						}
					}else{
						$array;
					}
				}else{
					$array = array('msg'=>' Please choose image file, it should be less than or equal to 100kb and .png format','success'=>0);
				}
				echo json_encode($array);
		}else{
			if($id){
				$this->data['record'] = $this->common->accessrecord(TBL_CATEGORY,[],['id'=>$id],'row');
			}
			$this->data['category'] = $this->common->accessrecord(TBL_CATEGORY,[],['parent_id'=>0],'result');
			$this->data['page'] ='add_sub_category';
			$this->data['content'] = 'category/add_sub_category';
			$this->load->view('template',$this->data);
		}
	}
	function musiclist(){
		$id = !empty($_GET['id']) ? base64_decode($_GET['id']) : exit();
		$this->data['musiclist'] = $this->common->accessrecord(TBL_CATEGORY_MUSIC,[],['category_id'=>$id],'result');
		$cate[] = array('key'=>'' ,'value'=>'row');
		$this->data['name'] = $this->common->accessrecordwithjoin([TBL_CATEGORY.'.name , t1.name as catename'],TBL_CATEGORY,TBL_CATEGORY.' t1', [TBL_CATEGORY.'.parent_id',"t1.id"] ,[TBL_CATEGORY.'.id'=>$id],'left',$cate);
		$this->data['page'] ='music_list';
		$this->data['content'] = 'category/music_list';
		$this->load->view('template',$this->data);
	}
	function deleteMusicCategory($id){
		if(!$this->common->accessrecord(TBL_CATEGORY_MUSIC,[],['category_id'=>$id],'row')){
			$this->common->deleteRecord(TBL_CATEGORY,['id'=>$id]);
			$this->session->set_flashdata('heading','Category Delete');
			$this->session->set_flashdata('success','Category successfully deleted');
		}else{
			$this->session->set_flashdata('heading','Category Delete Error');
			$this->session->set_flashdata('error','Before delete category music list main category can`t be deleted');
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
	function deleteSubcategory($id){
		if(!$this->common->accessrecord(TBL_CATEGORY_MUSIC,[],['category_id'=>$id],'row')){
			$this->common->deleteRecord(TBL_CATEGORY,['id'=>$id]);
			$this->session->set_flashdata('heading','Sub-Category Delete');
			$this->session->set_flashdata('success','SubCategory successfully deleted');
		}else{
			$this->session->set_flashdata('heading','Sub-Category Delete Error');
			$this->session->set_flashdata('error','Before delete sub-category music list  sub-category can`t be deleted');
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
	function getsub_categorylist(){
		extract($_POST);
		$data = $this->common->accessrecord(TBL_CATEGORY,[],['parent_id'=>$id],'result');
		$option ='';
		if($data){

			foreach($data as $row){
				$option .= "<option value=$row->id>$row->name</option>";
			}
		}else{
			$option = '<option value="">No Record Found</option>';
		}
		echo json_encode($option);
	}
	/* ======================= create music ============= start=========== =======  */
	function checkstring($str){
		if($str==''){
			$this->form_validation->set_message('checkstring','Please enter required feild');
			return false;
		}else{
			if(preg_match("/^[a-zA-Z ]*$/",$str)){
					return true;
			}else{	
				$this->form_validation->set_message('checkstring','Please remove non of string word');
				return false;
			}
		}
	}
	function check(){
		$aacPath =  ABS_PATH."./assets/music/";
		$mp4 =  'E:/aws/tiktikcode/new.mp4';
		// if(file_exists($mp4)){
		// 	echo "nhi hai";
		// }else{
		// 	echo "hai";
		// }
		// die;
		$path = './assets/music/';
		$uplodedfile = musicfile('music',$path);
		//	print_r($uplodedfile); die;
			if($uplodedfile['success']==0){
				$array = array('msg'=> $uplodedfile['msg'],'success'=>0);	
				echo $uplodedfile['msg'];
			}else{
				echo $uplodedfile['msg']; die;
			}
		$name = 'Aai me to aai';
		$songname = str_replace(' ', '_', $name);
		//$acccomd = 'ffmpeg -i '.$_FILES['music']['tmp_name'].'  '.$aacPath.'/'.$songname.'.aac';
		$acccomd = 'ffmpeg -i '.$mp4.' -vn -acodec copy '.$aacPath.'/'.$songname.'.aac 2>&1';
		//$acccomd = 'fmpeg -i '.$mp4.' -c:a libfdk_aac -profile:a aac_he_v2 -b:a 32k '.$aacPath.'/'.$songname.'.m4a';
		exec($acccomd,$output,$response);
		echo "<pre>"; print_r($response);
		print_r($output);
	}
	 function create_music(){
		if(!empty($_POST)){
			$array=[];
			$this->form_validation->set_rules('name','Song Name','required|callback_checkstring');
			$this->form_validation->set_rules('artist','Artist Name','required|callback_checkstring');
			if (empty($_FILES['image']['name']))
			{
				$this->form_validation->set_rules('image', 'Music Icon', 'required');
			}
			if (empty($_FILES['music']['name']))
			{
				$this->form_validation->set_rules('music', 'Audio/Video file', 'required');
			}
			if($this->form_validation->run()== FALSE){
				
				$array['error'] = array('name'=>form_error('name'),
										'artist'=>form_error('artist'),
										'image' => form_error('image'),
										'music' => form_error('music')
									);
				//echo json_encode($array);
			}else{
				extract($_POST);
				//print_r($_FILES); die;
				$isTrue=1;	
				$musicType=['mp3'];
				$categoryname = $this->common->accessrecord(TBL_CATEGORY,['name'],['id'=>$category],'row')->name;
				$categoryFolder = MUSIC_ICON."/".$categoryname;
					if(!file_exists($categoryFolder)){
						mkdir($categoryFolder);
					}
				if(!empty($_FILES['image']['name'])){
					$image = musicCategory('image',$categoryFolder,250);
					if($image['success']==0){
						$array = array('msg'=> $image['msg'],'success'=>0);	
						$isTrue=2;
					}else{
						$music['image'] = $image['msg'];
					}
				}
				if($isTrue==1){
					$ok=0;
					$aacPath =  ABS_PATH."./assets/music/";
					$path = './assets/music/';
					$songname = str_replace(' ', '_', $name);
					$target_dir = "./assets/music/";
					
					if($type!=1){
						$target_file = $target_dir . basename($_FILES["music"]["name"]);
						if (move_uploaded_file($_FILES["music"]["tmp_name"], $target_file)) {
							$uploadeMusic = BASE_URL.$path.basename($_FILES["music"]["name"]);
							$fullimage = $path.basename($_FILES["music"]["name"]);
							if($type==0){
								$acccomd = 'ffmpeg -i '.$uploadeMusic.'  '.$aacPath.'/'.$songname.'.aac';
							}elseif($type==2){
								$acccomd = 'ffmpeg -i '.$uploadeMusic.' -vn -acodec copy '.$aacPath.'/'.$songname.'.aac 2>&1';
							}
							exec($acccomd,$output,$response);
							if(empty($output) || $response==0){
								$filename = $aacPath.'/'.$songname.'.aac';
								$ok=1;
							}
						}else{
							$array = array('success'=>0,'msg'=>'File not uploded please try another file or try again');
						}
					}else{
						$dir = dirname($_FILES["music"]["tmp_name"]);
						$filename = $dir . DIRECTORY_SEPARATOR . $_FILES["music"]["name"];
						rename($_FILES["music"]["tmp_name"], $destination);
						$ok=1;
					}
					if($ok==1){
						if(file_exists($filename)){
							$upload = $this->s3_upload->upload_file($filename,$categoryname."/");
							if($upload!=false){
								$music['music'] = $upload;
							}
							$music['conversion_type'] = $type;
							$music['category_id'] = !empty($subcategory) ? $subcategory : $category;
							$music['artist'] = $artist;
							$music['song_name'] = $name;
							$this->common->insertData(TBL_CATEGORY_MUSIC,$music);
							if(file_exists(ABS_PATH.$fullimage))
							unlink(ABS_PATH.$fullimage);
							$array = array('success'=>1,'msg'=>' Music gallery song listed succesfully');
						}else{
							$array = array('success'=>0,'msg'=>' File Not Found');
						}
					}else{
						$array = array('success'=>0,'msg'=>'Sorry! Bad file format or Used file are demage or rename the file name');
					}
					
				}else{
					if($isTrue==2){
						$array;
					}else{
						$array = array('success'=>0,'msg'=>' Something missing while creating music');
					}
				}
				
			}
			echo json_encode($array);
		}else{
			$this->data['music'] = $this->common->accessrecord(TBL_CATEGORY,[],['parent_id'=>0],'result');
			$this->data['page'] ='add_music';
			$this->data['content'] = 'category/add_music';
			$this->load->view('template',$this->data);
		}
	 }
	 function checkext($extname,$file){
		if(!empty($file['music']['name'])){
			$filename = $file['music']['name'];
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			if (!in_array($ext, $extname)) {
				return array('success'=>0,'msg'=>' According to selected music type format not matched');
			}elseif($file['music']['error']==1){
				return array('success'=>0,'msg'=>' Selected music file is demaged please choose another file or try again');
			}else{
				return true;
			}
		}
	 }

	/* ===============  music section end===========end=========================== */
}
