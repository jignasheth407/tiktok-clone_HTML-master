<?php 
   defined('BASEPATH') OR exit('No direct script access allowed');
   use Restserver\Libraries\REST_Controller;
   require APPPATH . 'libraries/REST_Controller.php';
   require APPPATH . 'libraries/Format.php';
   require_once('vendor/autoload.php');
   require_once('application/libraries/S3.php');
   //require APPPATH . 'libraries/config_paytm.php';
   //require APPPATH . 'libraries/encdec_paytm.php';
   date_default_timezone_set('Asia/Kolkata');

   class Api extends REST_Controller { 
     public $z=1;
     public $i=0;
       function __construct()
       {
           parent::__construct();
           $this->load->helper('url');
           $this->load->model('Api_model', 'api');
           //$this->load->model('Email_model');
           $this->load->library('session');
           $this->load->library('email');
           $this->load->library('form_validation');
           $this->load->library('S3_upload');
           $this->load->library('S3');
           $this->config->load('s3', TRUE);
           $s3_config = $this->config->item('s3');
           $this->bucket_name = $s3_config['bucket_name'];
           $this->video_image_path = $s3_config['image_path'];
           $this->video_path = $s3_config['video_path'];
           $this->s3_url = $s3_config['s3_url'];
       }
        /*****************************Registration 07/12/19****************************************/
        function genrateids(){
          $random = mt_rand(10000000,99999999);
          if($this->common->accessrecord(TBL_USER,[],['sponsor_id'=>$random],'row')){
            $this->genrateids();
          }else{
            return $random;
          }
        }
        public function register_post(){
          extract($_POST);
          if(!empty($email)&&!empty($mobile)){
            $condition = "`email`='$email' || `mobile`='$mobile'";
            $resuser = $this->api->check(TBL_USER, [], $condition, 'row');
            $count = $this->common->accessrecord(TBL_USER,['COUNT(id) as total'],['mobile'=>$mobile],'row');
            if (empty($resuser) || ($count->total<=10)) {
              $isSet=1;
              if(!empty($refferal_id)){
                $getString =  substr($refferal_id,0,PRE_COUNT);
                if($getString==PREFIX){
                  $refferal_id = substr($refferal_id,PRE_COUNT);
                  if(!$this->common->accessrecord(TBL_USER,['sponsor_id'],['sponsor_id'=>$refferal_id],'row')){
                    $isSet=0;
                  }
                }else{
                  $isSet=0;
                }
              }
              if($isSet==1){
                $refferal_by = $insert['refferal_by'] = !empty($refferal_id) ? $refferal_id : '12345678';
                $insert['sponsor_id'] =  $this->genrateids();
                $insert['full_name'] = $name;
                $insert['email'] = $email;
                $insert['mobile'] = $mobile;
                $insert['password'] = sha1($password);
                $insert['pwd'] = $password;
                $insert['user_name'] = $user_name;
                $insert['last_date'] = date('Y-m-d',strtotime("+10 days"));
                $insert['country_code'] = $country_code;
                $insert['access_token'] =  $this->getRandom(50);
                $insert['fcm_token'] = $fcm_token;
                if($lastid = $this->common->insertData(TBL_USER,$insert)){
                    $this->distributeReferralPoint($insert['sponsor_id'],$insert['sponsor_id']);
                    $data = $this->common->accessrecord(TBL_USER,['sponsor_id as ID,full_name as name,email,mobile,image,access_token'],['id'=>$lastid],'row');
                    $data->address= '';
                    $data->username = PREFIX.$data->ID;;
                    $data->imageurl = BASE_URL.PROFILE_PIC.$data->image;
                    unset($data->image);

                    $refferal['point'] = 100;
                    $refferal['to_sponsor_id'] = $insert['sponsor_id'];
                    $refferal['from_sponsor_id'] = 0;
                    $refferal['level'] = 0;
                    $this->common->insertData(TBL_REFFERAL_POINT,$refferal);
                    $this->common->setMethod(TBL_USER,"+",'referral_point',100,['id'=>$lastid]);
                    registration($user_name, PREFIX.$insert['sponsor_id'],$password, $mobile);
                    $message = array(
                      'status' => TRUE,
                      'message' => 'Registration successfully',
                      'data' => $data
              );
              $this->set_response($message, REST_Controller::HTTP_OK);
                  }else{
                    $message = array(
                      'status' => False,
                      'message' => 'Something went wrong please try again'
                );
                $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
                }
            }else{
              $message = array(
                'status' => False,
                'message' => 'Referral id not valid'
           );
           $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
            }
            }else{
                $message = array(
                    'status' => FALSE,
                    'message' => 'Email Or mobile no. allready used!!'
                );
                $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
            }
          }else{
              $message = array(
                   'status' => FALSE,
                   'message' => 'Email, mobile are required!!'
              );
              $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
          }
          // echo "<pre>"; print_r($_POST);
        }

        function forgotMemberid_post(){
          $mobile = $this->post('mobile_number');
          if($data = $this->common->accessrecord(TBL_USER,['GROUP_CONCAT(CONCAT("'.PREFIX.'",sponsor_id)) as member_id'],['mobile'=>$mobile],'row')){
            forgotmemberid($mobile,$data->member_id);
            $message = array(
              'status' => true,
              'message' => 'Data send'
         );
         $this->set_response($message, REST_Controller::HTTP_OK);
          }else{
            $message = array(
              'status' => false,
              'message' => 'mobile number not found'
         );
         $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
          }
        }
        function check_get(){
          $this->distributeReferralPoint($id='99559952',$newid='99559952');
        }
        private function distributeReferralPoint($id,$newid){
          $this->z++;
          $data = $this->common->accessrecord(TBL_USER,['refferal_by as sponsor_id,access_token'],['sponsor_id'=>$id],'row');
         
          if(!empty($data->access_token)){
            $array=[];
              if($this->z<7){
                if($this->z==2){
                  $level=1;
                  $point=10;
                }
                if($this->z==3){
                  $level=2;
                  $point=5;
                }
                if($this->z==4){
                  $level=3;
                  $point=3;
                }
                if($this->z==5){
                  $level=4;
                  $point=2;
                }
                if($this->z==6){
                  $level=5;
                  $point=1;
                }
                if(!empty($data->sponsor_id))
                $array[] = array('to_sponsor_id'=>$data->sponsor_id,'from_sponsor_id'=>$newid,'level'=>$level,'point'=>$point);
                $this->distributeReferralPoint($data->sponsor_id,$newid);
                foreach($array as $row){
                  $this->common->setMethod(TBL_USER,"+",'referral_point',$point,['sponsor_id'=>$data->sponsor_id]);
                  $this->common->insertData(TBL_REFFERAL_POINT,$row);
                }
               
                //$this->common->insertBatch(TBL_REFFERAL_POINT,$array);
            }
          }
           
        }

      /* ======================= wallet informatin========= 25 march 2020================= */
      
      /* ===============end===========wallet information====== 25 march 2020============== */
      public function readnotification_post()
      {
       $token = $_SERVER['HTTP_ACCESS_TOKEN'];
        if ($id = $this->verifyToken($token)) {
          $status = $this->input->post('read_status');
          $username = $this->input->post('username');
          if(!empty($status)&&!empty($username)){
            $res = $this->api->updateRecord('notification', ['read_notifi'=>$status], ['username_to'=>$id['sponsor_id']]);
            $message = array(
               'status'  => TRUE,
               'message' => "notification read successfully"
            );
            $this->set_response($message, REST_Controller::HTTP_OK);
          }else{
            $message = array(
               'status' => FALSE,
               'message' => 'Invalid Request!!'
            );
            $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
          }
        }else{
          $message = array(
            'status' => FALSE,
            'message' => 'Invalid access token'
          );
          $this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);
        }
      }

       public function delvideo_post()
    {
      $token = $_SERVER['HTTP_ACCESS_TOKEN'];
      if ($id = $this->verifyToken($token)) {
        $vid = $this->input->post('video_id');
        $username = $this->input->post('username');
        if(!empty($vid)&&!empty($username)){
          $res = $this->common->deleteRecord('task_category_videos', array('ID'=>$vid, 'customer_id'=>$username));
          // $dt=array('username'=>$username,'video_id'=>$vid);
          // $resid = $this->api->insert('removed_video',$dt);
          $message = array(
             'status'  => TRUE,
             'message' => $res
          );
          $this->set_response($message, REST_Controller::HTTP_OK);
        }else{
          $message = array(
             'status' => FALSE,
             'message' => 'Invalid Request!!'
          );
          $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
        }
      }else{
        $message = array(
          'status' => FALSE,
          'message' => 'Invalid access token'
        );
        $this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);
      }
    }


    public function login_post(){
           $email = $this->post('email');
           $password = $this->post('password');
           $token = $this->post('fcm_token');
           if($email!="" && $password!=""){
              $getstring = strtoupper(substr($email,0,PRE_COUNT));
              $number = substr($email,PRE_COUNT);
              if(($getstring==PREFIX) && (strlen($number)==8)){
                  $userid = substr($email,PRE_COUNT);
              }elseif((strlen($email)==8) && ($getstring!=PREFIX)){
                $userid =  $this->getRandom(50);
              }else{
                $userid =  $email;
              }
                $random[] = array('key' => ' WHERE sponsor_id = "'. $userid.'" OR mobile ="'. $userid.'" OR user_name = "'.$userid.'" AND password = "'.sha1($password).'"' ,'value'=>'');
                if($data = $this->common->custumQuery(TBL_USER,[' sponsor_id as ID, full_name as name, email, mobile, image,access_token, status,plan_id '],[],$random,'row')){
                  if($data->status==2){
                    $message = array(
                      'status' => FALSE,
                      'message' => 'You are banned by admin!!'
                  );
                  $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
                  }else{
                    $accessToken = $this->getRandom(50);
                    $this->common->updateData(TBL_USER,['access_token'=>$accessToken,'fcm_token'=>$token],['sponsor_id'=>$data->ID]);
                    $data->address='';
                    $data->username=PREFIX.$data->ID;
                    $data->imageurl = BASE_URL.PROFILE_PIC.$data->image;
                    $data->access_token =  $accessToken;
                    unset($data->image);
                    $message = array(
                      'status' => true,
                      'message' => 'Login successfully',
                      'data' => $data
                  );
                  $this->set_response($message, REST_Controller::HTTP_OK);
                  }
               }else{
                  $message = array(
                    'status' => FALSE,
                    'message' => 'Incorrect Credeantial'
                );
                $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
               }
              
          }else{
            $message = array(
                   'status' => FALSE,
                   'message' => 'Please fill all remember feilds'
               );
               $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
          }
        }
      // function clean($string) {
      //    $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

      //    return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
      // }
       function searchusername_post(){
          $username =  $this->post('user_name');
          //$check = $this->clean($username);
          if($username){
             $username = $this->common->accessrecord(TBL_USER,['user_name'],['user_name'=>$username],'row');
             if($username){
                $message = array(
                   'status' => FALSE,
                   'message' => 'Already Taken'
               );
               $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
             }else{
                 $message = array(
                   'status' => true,
                   'message' => 'Available'
               );
               $this->set_response($message, REST_Controller::HTTP_OK);
             }
          }else{
             $message = array(
                   'status' => FALSE,
                   'message' => 'Some special character detected, please remove special character'
               );
               $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
          }
       }
       function viewProfile_get(){
         $token = $_SERVER['HTTP_ACCESS_TOKEN'];
          if ($id=$this->verifyToken($token)) {
               $join[] = array('key'=> ' LEFT JOIN '.TBL_USER.' t1 ON','value'=>'t1.sponsor_id='.TBL_USER.'.refferal_by');
               $join[] = array('key'=>' WHERE '.TBL_USER.'.id=','value'=>$id['id']);
               $join[] = array('key'=>'','value'=>'row');
               $data = $this->common->accessrecordwithjoin([TBL_USER.'.*,t1.full_name as sponser_name,'.TBL_PACKAGE.'.package_amount'],TBL_USER,TBL_PACKAGE,[TBL_PACKAGE.'.id',TBL_USER.'.plan_id'],[],'left',$join);
             
               $array['name'] = $data->full_name;
               $array['member_id'] = PREFIX.$data->sponsor_id;
               $array['user_name'] = !empty($data->user_name) ? $data->user_name : '';
               $array['mobile_no'] = $data->mobile;
               $array['email'] = $data->email;
               $array['package_amount'] = !empty($data->package_amount) ? "$".$data->package_amount : '';
               $array['sub_date'] = !empty($data->activation_date) ? $data->activation_date : '';
               $array['sponsor_name'] = !empty($data->sponser_name) ? $data->sponser_name : '' ;
               $array['sponsor_id'] = !empty($data->refferal_by) ? PREFIX.$data->refferal_by : '';
               $array['image'] = BASE_URL.PROFILE_PIC.$data->image;

                $message = array(
                    'status' => true,
                    'message' => 'Profile Fatched',
                    'data' => $array
                );
                $this->set_response($message, REST_Controller::HTTP_OK);

          }else{
             $message = array(
              'status' => FALSE,
              'message' => 'Invalid access token'
            );
            $this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);  
          }         
       }
     public function changepassowrd_post()
        {
       
          $token = $_SERVER['HTTP_ACCESS_TOKEN'];

          $old_password = $this->input->post('old_password');
          $password = $this->input->post('password');

          if ($id = $this->verifyToken($token)) {
            if($this->common->accessrecord(TBL_USER,['id'],['password'=>sha1($old_password),'id'=>$id['id']],'row')){
                $this->common->updateData(TBL_USER,['password'=>sha1($password),'pwd'=>$password],['id'=>$id['id']]);
                $message = array(
                  'status' => True,
                  'message' => 'Password Updated'
                );
                $this->set_response($message, REST_Controller::HTTP_OK);  
            }else{
              $message = array(
                'status' => FALSE,
                'message' => 'Old password not matched'
              );
              $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);  
            }
          }else{
            $message = array(
              'status' => FALSE,
              'message' => 'Invalid access token'
            );
            $this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);  
          }
        }
        function profileImage_post(){
            $token = $_SERVER['HTTP_ACCESS_TOKEN'];
            if($id = $this->verifyToken($token)){
              if(!empty($_FILES['profile']['name'])) {
              $image = uploadimage('profile',PROFILE_PIC);
              $isTrue=1;
              if($image){
                $data['image'] = $image;
              }else{
               $isTrue=0;
              }
              if($isTrue==1){
                  $this->common->updateData(TBL_USER,$data,['id'=>$id['id']]);
                    $data  = $this->common->accessrecord(TBL_USER,['sponsor_id as ID, full_name as name, email, mobile, image,access_token, status,plan_id'],['id'=>$id['id']],'row');
                    $data->address='';
                    $data->username=PREFIX.$data->ID;
                    $data->imageurl = BASE_URL.PROFILE_PIC.$data->image;
                    unset($data->image);
                   $message = array(
                  'status' => true,
                  'message' => 'Profile Picture Updated',
                  'data'=>$data
                );
                $this->set_response($message, REST_Controller::HTTP_OK);  
              }else{
                $message = array(
                'status' => FALSE,
                'message' => 'Image format not valid'
              );
              $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);  
              }
            }else{
               $message = array(
              'status' => FALSE,
              'message' => 'Invalid access token'
            );
            $this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);  
          }
            }
        }
        public function forgotpassowrd_post()
        {
            $member_id = $this->input->post('member_id');
            $mobileno = $this->input->post('mobile_no');
            $newpassword = $this->input->post('new_password');
            $string = strtoupper($member_id);
            if(PREFIX==substr($string,0,PRE_COUNT)){
              $member_id  = substr($string,PRE_COUNT);
              $username = $this->common->accessrecord(TBL_USER, [], ['sponsor_id'=>$member_id,'mobile'=>$mobileno], 'row');
             
              if (!empty($username)) {
                   forgotpassword($mobileno,$newpassword);
                    $response = $this->common->updateData(TBL_USER, array('password' => sha1($newpassword),'pwd'=>$newpassword), array('sponsor_id' => $member_id));
                  $message = array(
                    'status'  => TRUE,
                    'message' => 'Your password successfully update',
                    'new_password'    => $newpassword
                  );
                  $this->set_response($message, REST_Controller::HTTP_OK);
              }
            else{
              $message = array(
                  'status' => FALSE,
                  'message' => 'Member id not exit!!'
              );
              $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
            }
          }else{
            $message = array(
              'status' => FALSE,
              'message' => 'Invalid Member id!'
          );
          $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
          }
        }
      
    function objectToArray($d) {
        if (is_object($d)) {
            $d = get_object_vars($d);
        }
        if (is_array($d)) {
            return array_map(__FUNCTION__, $d);
        }
        else {
            return $d;
        }
    }

public function videosbyloginid_post()
    {
      $token = $_SERVER['HTTP_ACCESS_TOKEN'];
      if ($id = $this->verifyToken($token)) {

        $totLikeVidbyme = array();
        $totLikeVid = array();
        $follolists = array();
        $followlist = array();
        $likeVideos = array();
        $username = $this->input->post('username'); 
          if (!empty($username)) {
            $myAllLikeVideos = $this->api->mylikevideobyme('likeunlike', ['username'=>$username, 'likes'=>1], 'ID','desc', 'result');
            if(!empty($myAllLikeVideos)){
                  $mylikevvv=array();
              foreach ($myAllLikeVideos as $myalkey => $myalval) {

                $likevideos=array();
                $likevideos = $this->api->accessrecord(TBL_TASKCATEGORYVIDEOS, [], ['ID'=>$myalval->video_id], '','', '', 'row');
                if(!empty($likevideos)){
                $vidpostuser= $this->common->accessrecord(TBL_USER, [], ['sponsor_id'=>$likevideos->customer_id],'row');
                $likeVideos['user_image'] =BASE_URL.PROFILE_PIC.$vidpostuser->image; 
                $likeVideos['post_by'] = $vidpostuser->full_name;
                $likeVideos['user_type'] = '';
               
                if(!empty($likevideos->thumbnail)){
                  $likeVideos['thumbnail'] = BASE_URL.VIDEO_THUMBNAIL_PATH.$likevideos->thumbnail;
                }else{
                  $likeVideos['thumbnail'] = BASE_URL.PROFILE_PIC.$vidpostuser->image;
                }
                $filename = pathinfo($likevideos->path, PATHINFO_FILENAME);
                $likeVideos['path'] = VIDEO_PATH."DIR_".$likevideos->customer_id."/".$filename."/".$filename.".m3u8";
                $likeVideos['audio_video_path'] = array('mp4'=>MUSIC_VIDEO."DIR_".$likevideos->customer_id."/".$filename.".mp4",
                                  'mp3'=>BASE_URL.MP3.$likevideos->customer_id.'/'.$filename.".mp3",
                                  'aac'=>@file_get_contents(BASE_URL.AAC.$catval->customer_id."/".$filename.".aac") ? BASE_URL.AAC.$catval->customer_id."/".$filename.".aac"  : VIDEO_PATH."DIR_".$likevideos->customer_id."/".$filename."/".$filename."aac_00001.aac",
                                  "song_name" => !empty($vidpostuser->user_name) ? "original song - ".$vidpostuser->user_name . " - ". $vidpostuser->full_name : " original sound -". $vidpostuser->full_name
                              ); 
                $likeVideos['description'] = $likevideos->description;
                $likeVideos['category_id'] = $likevideos->category_id;
                $likeVideos['customer_id'] = $likevideos->customer_id;
                $likeVideos['ID'] = $likevideos->ID;
                $likeVideos['views'] = $likevideos->views;
                $likeVideos['date'] = $likevideos->date;

                if (!empty($myalval->video_id)) {
                  $like_coun = $this->api->checklike('likeunlike', ['video_id'=>$myalval->video_id, 'likes'=>1], 'result');
                     
                  if (!empty($like_coun)) {
                    $likeVideos['like_count'] = count($like_coun);
                    array_push($totLikeVidbyme, $likeVideos['like_count']);
                  }else{
                    $likeVideos['like_count'] = 0;
                  }
                  $mycommentlist = $this->api->commentlist('comments', $myalval->video_id);
                  if (!empty($mycommentlist)) {
                    $likeVideos['comment_count'] = count($mycommentlist);
                    $likeVideos['comment_list'] = $mycommentlist;
                  }else{
                    $likeVideos['comment_count'] = 0;
                    $likeVideos['comment_list'] = [];
                  }
                }
                 $likeVideos['likeed'] = 1;
                 $likeVideos['myfollow'] =0;

                 if($likevideos->customer_id==$username){
                  $likeVideos['myfollow'] =1;
                }
                $array = json_decode(json_encode($likeVideos), True);
                array_push($mylikevvv,$array);
                //$mylikevvv[] =$array;    
              }
            }
            }
           //echo '<pre>';print_r($mylikevvv);die;
//             
            $user= $this->common->accessrecord(TBL_USER, [], ['sponsor_id'=>$username], 'row');
            unset($user->country_code);
            $user->username = $user->sponsor_id;
            $condi1 = "followers='$username' AND status='1'";
            $followings = $this->api->check('tblfollowing', [], $condi1, 'result');
            if (!empty($followings)) {
               $follolists=$followings;
            }
            $condi2 = "following='$username' AND status='1'";
            $fans = $this->api->check('tblfollowing', [], $condi2, 'result');
            if (!empty($fans)) {
              foreach ($fans as $fanskey => $fansval) {
              }
              $followlist=$fans;
            }

            if(!empty($user->image)){
              //$user->user_image =base_url('uploads/'.$user->imageurl); 
              $user->user_image = BASE_URL.PROFILE_PIC.$user->image; 
            }else{
              $user->user_image =base_url('uploads/./images/default.png'); 
            }
             // ***********************
              $myfollowusername = $this->common->accessrecord(TBL_USER, ['sponsor_id as username'], ['id'=>$id['id']], 'row');
              // ************************************
                  $isfollow = $this->api->check('tblfollowing',[],['following'=>$username,'followers'=>$myfollowusername->username,'status'=>1], 'row');
                   
                if (!empty($isfollow)) {
                  $user->myfollow=1;
                }elseif($myfollowusername->username==$username){
                  $user->myfollow=2;
                }else{
                   $user->myfollow=0;
                }
            unset($user->imageurl);
            $users['user_data'] =  $user; 
            if(!empty($users)){
              $videos = $this->api->accessrecord(TBL_TASKCATEGORYVIDEOS, [], ['customer_id'=>$user->username], 'ID','desc', '', 'result');

              if(!empty($videos)){
                foreach ($videos as $catkey => $catval) {
                   // *******************************
                 $videos[$catkey]->date =$this->api->duration($catval->date);

                // *********************************
                 
                  if(!empty($user->image)){
                    //$videos[$catkey]->user_image =base_url('uploads/'.$user->imageurl); 
                    $videos[$catkey]->user_image = BASE_URL.PROFILE_PIC.$user->image; 

                  }else{
                    $videos[$catkey]->user_image =base_url('uploads/./images/default.png'); 

                  }
                  $videos[$catkey]->post_by = $user->full_name;
                  if(!empty($catval->thumbnail)){
                  
                      $videos[$catkey]->thumbnail = BASE_URL.VIDEO_THUMBNAIL_PATH.$catval->thumbnail;
                  }else{
                    $videos[$catkey]->thumbnail = base_url('uploads/images/video-thumbnail/valentine2.jpg');
                  }
                  $filename1 = pathinfo($catval->path, PATHINFO_FILENAME);
                  $videos[$catkey]->user_type = '';
                  $videos[$catkey]->path = VIDEO_PATH."DIR_".$username."/".$filename1."/".$filename1.".m3u8";
                  $videos[$catkey]->audio_video_path= array('mp4'=>MUSIC_VIDEO."DIR_".$username."/".$filename1.".mp4",
                              'mp3'=>BASE_URL.MP3.$username.'/'.$filename1.".mp3",
                              'aac'=>@file_get_contents(BASE_URL.AAC.$catval->customer_id."/".$filename1.".aac") ? BASE_URL.AAC.$catval->customer_id."/".$filename1.".aac"  : VIDEO_PATH."DIR_".$catval->customer_id."/".$filename1."/".$filename1."aac_00001.aac",
                              "song_name" => !empty($user->user_name) ? "original song - ".$user->user_name . " - ". $user->full_name : " original sound -". $user->full_name
                          ); 
                  $videos[$catkey]->description = $catval->description;

                  if (!empty($catval->ID)) {
                    $resuser1 = $this->api->checklike('likeunlike', ['video_id'=>$catval->ID, 'likes'=>1], 'result');

                    if (!empty($resuser1)) {
                      $videos[$catkey]->like_count = count($resuser1);
                      array_push($totLikeVid, $videos[$catkey]->like_count);
                    }else{
                      $videos[$catkey]->like_count = 0;
                    }
                    $commentlist = $this->api->commentlist('comments', $catval->ID);
                    if (!empty($commentlist)) {
                      $videos[$catkey]->comment_count = count($commentlist);
                      $videos[$catkey]->comment_list = $commentlist;
                    }else{
                      $videos[$catkey]->comment_count = 0;
                      $videos[$catkey]->comment_list = [];
                    }
                  }
                   $videos[$catkey]->likeed = 0;
                    // ************************************
                  $isfollow = $this->api->check('tblfollowing',[],['following'=>$user->username,'followers'=>$myfollowusername->username,'status'=>1], 'row');
                   
                    if (!empty($isfollow)) {
                      $videos[$catkey]->myfollow=1;
                    }elseif($myfollowusername->username==$username){
                      $videos[$catkey]->myfollow=2;
                    }else{
                       $videos[$catkey]->myfollow=0;
                    }
             
                }
                
                if(sizeof($videos) >100){
                 $videosnew = array_slice($videos, 0, 50, true); 
                 $users['post_videos'] = $videosnew;
                }else{
                   $users['post_videos'] = $videos;
                }
                if(!empty($follolists)){
                  $users['following'] = sizeof($follolists);
                }else{
                  $users['following'] =0;
                }
                if (!empty($followlist)) {
                  $users['follwers'] = sizeof($followlist);
                }else{
                  $users['follwers'] =0;
                }
                if(!empty($totLikeVid)){
                  $users['vidtotc'] = array_sum($totLikeVid);
                }else{
                  $users['vidtotc'] = 0;
                }
               if (!empty($mylikevvv)) {
                  if(sizeof($mylikevvv) >100){
                   $likenew = array_slice($mylikevvv, 0, 50, true); 
                   $users['myLikes_videos'] = $likenew;
                  }else{
                     $users['myLikes_videos'] = $mylikevvv;
                  } 

                }else{
                  $users['myLikes_videos'] = [];
                }
              $message = array(
                     'status'  => TRUE,
                     'message' => 'Data fetch successfully!!',
                     'data'    =>  $users
                 );
                 $this->set_response($message, REST_Controller::HTTP_OK);
            }else{
              $users['post_videos'] =[];
              if(!empty($follolists)){
                  $users['following'] = sizeof($follolists);
                }else{
                  $users['following'] =0;
                }
                if (!empty($followlist)) {
                  $users['follwers'] = sizeof($followlist);
                }else{
                  $users['follwers'] =0;
                }
                if(!empty($totLikeVid)){
                  $users['vidtotc'] = array_sum($totLikeVid);
                }else{
                  $users['vidtotc'] = 0;
                }
                if (!empty($mylikevvv)) {
                  $users['myLikes_videos'] = $mylikevvv;
                }else{
                  $users['myLikes_videos'] = [];
                }
              $message = array(
                     'status'  => TRUE,
                     'message' => 'Data fetch successfully!!',
                     'data'    =>  $users
                 );
                 $this->set_response($message, REST_Controller::HTTP_OK);
            }
          }else {
               $message = array(
                   'status' => FALSE,
                   'message' => 'Data not found!!'
               );
               $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
          }
        }else{
          $message = array(
            'status' => FALSE,
            'message' => 'Invalid username'
          );
          $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
        }
     }else{
            $message = array(
              'status' => FALSE,
              'message' => 'Invalid access token'
            );
            $this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);  
          }
      
    }

    public function likeunlikevideo_post()
    {
      $defaultLike = 0.0013; //0.10 inr
      $video_id = $this->input->post('vid');
      $username = $this->input->post('username');
      $get= $this->common->accessrecord(TBL_USER,['plan_id'],['sponsor_id'=>$username],'row');
      $user= $this->common->accessrecord(TBL_TASKCATEGORYVIDEOS,['ID,customer_id'],['ID'=>$video_id], 'row');
      $plan_id = $get->plan_id!=0 ? $get->plan_id :0;
      if (!empty($username)&&!empty($video_id)) {
      	$resuser = $this->common->accessrecord(TBL_LIKE_UNLIKE,[], ['video_id'=>$video_id, 'username'=>$username], 'row');
      	if (!empty($resuser)) {
      		if ($resuser->likes==0) {
      			$this->common->updateData(TBL_LIKE_UNLIKE, ['likes'=>1], ['video_id'=>$video_id, 'username'=>$username]);
      		}else{

              // $this->common->setMethod(TBL_USER,"-",'wallet_amount',$defaultLike,['sponsor_id'=>$user->customer_id]);
              // $this->common->setMethod(TBL_USER,"-",'total_amount',$defaultLike,['sponsor_id'=>$user->customer_id]);
              // $this->mylevel->paymentHistory($user->customer_id,$defaultLike,0,'UnLike a video');
              // $this->common->deleteRecord(TBL_VIDEO_INCOME,['sponsor_id'=>$user->customer_id,'video_id'=>$video_id,'type'=>2]);

            $this->common->updateData(TBL_LIKE_UNLIKE, ['likes'=>0], ['video_id'=>$video_id, 'username'=>$username]);
            if($plan_id){
                $data = $this->getpackageBenifit($plan_id);
                $this->common->setMethod(TBL_USER,"-",'wallet_amount',$data->share_like_amount,['sponsor_id'=>$username]);
                $this->common->setMethod(TBL_USER,"-",'total_amount',$data->share_like_amount,['sponsor_id'=>$username]);
                $this->mylevel->paymentHistory($username,$data->share_like_amount,0,'UnLike a video');
                $this->common->deleteRecord(TBL_VIDEO_INCOME,['sponsor_id'=>$username,'video_id'=>$video_id,'type'=>2]);
            }
      		}
      		$resuser1 = $this->common->accessrecord(TBL_LIKE_UNLIKE,['COUNT(id) as total'], ['video_id'=>$video_id, 'likes'=>1], 'row');
          $resuser2 =  $this->common->accessrecord(TBL_LIKE_UNLIKE,[], ['video_id'=>$video_id, 'username'=>$username], 'row');
      	}else{
      		$this->common->insertData(TBL_LIKE_UNLIKE, array('video_id'=>$video_id, 'likes' => 1, 'username' => $username,'plan_id'=>$plan_id));
      		$resuser1 = $this->common->accessrecord(TBL_LIKE_UNLIKE,['COUNT(id) as total'], ['video_id'=>$video_id, 'likes'=>1], 'row');
          $resuser2 = $this->common->accessrecord(TBL_LIKE_UNLIKE,[], ['video_id'=>$video_id, 'username'=>$username], 'row');
      	}
      	if (!empty($resuser1)) {
          if ($resuser2->likes==1) {
            $likeed = 1;
            
            $userdetail= $this->common->accessrecord(TBL_USER,['full_name as name,plan_id,CONCAT("'.BASE_URL.PROFILE_PIC.'",image) as image,user_name,sponsor_id'],['sponsor_id'=>$username],'row');
            if(!empty($user->customer_id)&&!empty($username)){
              if ($user->customer_id!==$username) {
                $resid = $this->common->insertData(TBL_NOTIFICATION,array('type'=>'video','username_to'=>$user->customer_id,'message'=>'has like your video','username_by'=>$username,'video_id'=>$video_id));
                if($userdetail->plan_id){
                  $currentDate = date('Y-m-d');
                  $planAmount = $this->common->accessrecord(TBL_PACKAGE,['per_share_like_dollor as amount'],['id'=>$userdetail->plan_id],'row');
                  $getTotalLike = $this->common->accessrecord(TBL_VIDEO_INCOME,['COUNT(id) as total'],['date_format(create_at,"%Y-%m-%d")'=>$currentDate,'plan_id'=>$plan_id,'income'=>$planAmount->amount,'type'=>2,'sponsor_id'=>$username],'row')->total;
                  $data = $this->getpackageBenifit($userdetail->plan_id);
               
                  $defaultIncome['income'] = $defaultLike;
                  $defaultIncome['sponsor_id'] = $user->customer_id;
                  $defaultIncome['plan_id'] =0;
                  $defaultIncome['type'] = 2;
                  $defaultIncome['video_id'] = $video_id;
                  $defaultIncome['create_at'] = date('Y-m-d H:i:s');
                  $this->common->insertData(TBL_VIDEO_INCOME,$defaultIncome);
                  $this->common->setMethod(TBL_USER,"+",'wallet_amount',$defaultLike,['sponsor_id'=>$user->customer_id]);
                  $this->common->setMethod(TBL_USER,"+",'total_amount',$defaultLike,['sponsor_id'=>$user->customer_id]);
                  $this->mylevel->paymentHistory($user->customer_id,$defaultLike,1,'Like a video');

                    if($data->like_count>$getTotalLike){

                      $shareIncome['income'] = $data->share_like_amount;
                      $shareIncome['sponsor_id'] = $username;
                      $shareIncome['plan_id'] = $userdetail->plan_id;
                      $shareIncome['type'] = 2;
                      $shareIncome['video_id'] = $video_id;
                      $shareIncome['create_at'] = date('Y-m-d H:i:s');
                      $this->common->insertData(TBL_VIDEO_INCOME,$shareIncome);
                      $this->common->setMethod(TBL_USER,"+",'wallet_amount',$data->share_like_amount,['sponsor_id'=>$username]);
                      $this->common->setMethod(TBL_USER,"+",'total_amount',$data->share_like_amount,['sponsor_id'=>$username]);
                      $this->mylevel->paymentHistory($username,$data->share_like_amount,1,'Like a video');
                      $this->mylevel->getsponsorlevel($username,$username,$data->share_like_amount,2);
                    }
                  }
                }

                 /* =================== notification send============================== */

                 $ROW[] = array('key'=>'','value'=>'row');
                 $check = $this->common->accessrecordwithjoin([TBL_USER.'.fcm_token','CONCAT("'.BASE_URL.VIDEO_THUMBNAIL_PATH.'",'.TBL_TASKCATEGORYVIDEOS.'.thumbnail) as videoimage'],TBL_USER,TBL_TASKCATEGORYVIDEOS,[TBL_USER.'.sponsor_id',TBL_TASKCATEGORYVIDEOS.'.customer_id'],[TBL_TASKCATEGORYVIDEOS.'.ID'=>$video_id],'inner',$ROW);
                 if(!empty($check->fcm_token)){
                     $title = " ".$userdetail->name;
                     $username = !empty($userdetail->user_name) ? $userdetail->user_name : PREFIX.$userdetail->sponsor_id;
                     $notification = [
                       "title" => $title."(".$username.")",
                       "body" => " has like your video",
                       "icon" => $check->videoimage,
                       "icon1" => $userdetail->image,
                       "sound" => true,
                       "video_id"=>$video_id,
                       "sponsor_id" => PREFIX.$userdetail->sponsor_id,
                       "action_type" => "1",
                       "click_action" => "action link"
       
                   ];
                     $fcmNotification = [
                       'registration_ids' => [$check->fcm_token], //multple token array
                       'data'=> $notification
                     ];
                     fcmmsg($fcmNotification);
                 }

                 /* ================ notification end========end=======end============= */
              }
          }else{
            $likeed = 0;
            //$this->send_notification();
          }
      		$like_count = $resuser1->total;
      		$message = array(
	           'status'  => TRUE,
	           'message' => 'Data fetch successfully!!',
	           'like_count' => $like_count,
             'likeed' => $likeed
	        );
	        $this->set_response($message, REST_Controller::HTTP_OK);
      	}else{
      		$message = array(
             'status'  => TRUE,
             'message' => 'Data fetch successfully!!',
             'like_count' => 0,
             'likeed' => 0
          );
          $this->set_response($message, REST_Controller::HTTP_OK);
      	}
      }else{
      	$message = array(
          'status' => FALSE,
          'message' => 'Incorrect Credeantial'
        );
        $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
      }
    }

    /* ============================  payment history============ 27 March 2020================== */
    //  private function level->paymentHistory($id,$amount,$type,$message){
    //    $history['sponsor_id'] = $id;
    //    $history['amount'] = $amount;
    //    $history['type'] = $type;
    //    $history['remark'] = $message;
    //    $history['create_at'] = date('Y-m-d H:i:s');
    //    $this->common->insertData(TBL_PAYMENT_HISTORY, $history);
    //  }
    /* =====================payment history end========= 27 March 2020========================== */

/**************************Follwing follwers 241219*******************************************************/

    function followunfollow_post()
    {
      $followers = $this->input->post('follower');//my id
      $following = $this->input->post('following');//jisko mene follow kiya hai
      if (!empty($followers)&&!empty($following)) {
        $follow = $this->common->accessrecord('tblfollowing', [],['followers'=>$followers, 'following'=>$following], 'row');
        if (!empty($follow)) {
          if ($follow->status==0) {
            $this->common->updateData('tblfollowing', ['status'=>1], ['followers'=>$followers, 'following'=>$following]);
          }else{
            $this->common->updateData('tblfollowing', ['status'=>0], ['followers'=>$followers, 'following'=>$following]);
          }
          $user2 = $this->common->accessrecord('tblfollowing',[], ['followers'=>$followers, 'status'=>1], 'result');
          $user1 = $this->common->accessrecord('tblfollowing',[], ['followers'=>$followers, 'following'=>$following], 'row');
        }else{
          // $this->api->insertlike('likeunlike', array('video_id'=>$video_id, 'likes' => 1, 'username' => $username));
          if(!empty($following)&&!empty($followers)){
            if($following!==$followers){
              $user = $this->common->insertData('tblfollowing', ['followers'=>$followers, 'following'=>$following, 'status'=> 1]);
            }
          }
          $user2 = $this->common->accessrecord('tblfollowing', [],['followers'=>$followers, 'status'=>1], 'result');
          $user1 = $this->common->accessrecord('tblfollowing', [],['followers'=>$followers, 'following'=>$following], 'row');
        }
        if (!empty($user1)) {
          if ($user1->status==1) {
            $follower_status = 1;
            $followtype="follow";
            $userdetail= $this->common->accessrecord(TBL_USER, ['full_name as name,user_name,sponsor_id,CONCAT("'.BASE_URL.PROFILE_PIC.'",image) as image'], ['sponsor_id'=>$followers], 'row');
            if(!empty($following)&&!empty($followers)){
              if ($following!==$followers) {
                $resid = $this->common->insertData('notification',array('type'=>'profile','username_to'=>$following,'message'=>$userdetail->name.' has follow your profile','username_by'=>$followers));
             
                       /* =================== notification send============================== */

                 
                 $check = $this->common->accessrecord(TBL_USER,['fcm_token'],['sponsor_id'=>$following],'row');
                 if(!empty($check->fcm_token)){
                     $title = " ".$userdetail->name;
                     $username = !empty($userdetail->user_name) ? $userdetail->user_name : PREFIX.$userdetail->sponsor_id;
                     $notification = [
                       "title" => $title."(".$username.")",
                       "body" => " has follow your profile ",
                       "icon" => "",
                       "icon1" => $userdetail->image,
                       "sound" => true,
                       "video_id"=>"",
                       "sponsor_id" => PREFIX.$userdetail->sponsor_id,
                       "action_type" => "0",
                       "click_action" => "action link"
       
                   ];
                     $fcmNotification = [
                       'registration_ids' => [$check->fcm_token], //multple token array
                       'data'=> $notification
                     ];
                     fcmmsg($fcmNotification);
                 }

                 /* ================ notification end========end=======end============= */
             
              }
            }
          }else{
            $follower_status = 0;
            $followtype="unfollow";
            // $resid = $this->api->insert('notification',array('type'=>'profile','username_to'=>$followers,'message'=>'one new user has follow your page','username_by'=>$folloing));

          }
          $follower_count = count($user2);
          $message = array(
             'status'  => TRUE,
             'message' => 'Data fetch successfully!!',
             'follower_count' => $follower_count,
             'follower_status' => $follower_status,
             'follow_type'=>$followtype
          );
          $this->set_response($message, REST_Controller::HTTP_OK);
        }else{
          $message = array(
             'status'  => TRUE,
             'message' => 'Data fetch successfully!!',
             'follower_count' => 0,
             'follower_status' => 0
          );
          $this->set_response($message, REST_Controller::HTTP_OK);
        }
      }else{
        $message = array(
          'status' => FALSE,
          'message' => 'Incorrect Credeantial'
        );
        $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
      }
    }
    /**============================= multiple followers= start=====  June 08, 2020=== */
      function randomUser_get(){
        $random[] = array('key'=>' ORDER BY RAND()  ','value'=> ' LIMIT 10 ');
        $data = $this->common->custumQuery(TBL_USER,[" ID as id,sponsor_id,image,(CASE WHEN user_name IS NOT NULL THEN user_name ELSE sponsor_id END) as user_name,CONCAT('".BASE_URL.PROFILE_PIC."',image) as image,full_name "],[],$random,'result');
        $message = array(
          'status'  => TRUE,
          'message' => 'Following list',
          'data'    =>  $data
       );
       $this->set_response($message, REST_Controller::HTTP_OK);
      }
      function multipleFollower_post(){
         $follower = $this->post('follower');
         $following = $this->post('following');
         $follow=[];
         for($i=0; $i<count($following); $i++){
            $follows['followers'] = $following[$i];
            $follows['following'] = $follower;
            $follows['status'] =1;
            $follow[] = $follows;
         }
         $this->common->insertBatch(TBL_FOLLOWING,$follow);
         $message = array(
          'status'  => TRUE,
          'message' => 'Following successfully'
       );
       $this->set_response($message, REST_Controller::HTTP_OK);
       
      }
    /* ===================== end============= multiple followers end===end=========== */
    function viewvideocount_post()
    {
      $video_id = $this->input->post('vid');
      $current_count = $this->input->post('view_count');
      $totalview = intval($current_count)+1;

      if(!empty($video_id)&&!empty($current_count)){
        if($this->api->updateRecord(TBL_TASKCATEGORYVIDEOS, array('views' => $totalview), array('ID' => $video_id))){
          $res = $this->api->check(TBL_TASKCATEGORYVIDEOS, ['ID, views'], ['ID'=>$video_id], 'row');
          $message = array(
             'status'  => TRUE,
             'message' => 'Data fetch successfully!!',
             'data'    =>  $res
          );
          $this->set_response($message, REST_Controller::HTTP_OK);
        }
      }else{
        $message = array(
          'status' => FALSE,
          'message' => 'Incorrect Credeantial'
        );
        $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
      }
    }

    public function videoscomment_post()
    {
      $video_id = $this->input->post('video_id');
      $username = $this->input->post('username');
      $comment = $this->input->post('comment');
      if(!empty($video_id)&&!empty($username)&&!empty($comment)){
        $username = substr($username,PRE_COUNT);
        $data=$_POST;
        $data['username'] = $username;
        $comm = $this->api->insert_with_backresult('comments', $data);
        //$this->common->insertData('comments',$data);
        
        if (!empty($comm)) {
        	$user= $this->api->check('task_category_videos',['ID,customer_id'],['ID'=>$video_id], 'row');
            $userdetail= $this->api->check(TBL_USER, ['full_name as name'], ['sponsor_id'=>$username], 'row');
            if(!empty($user->customer_id)&&!empty($username)){
              if($user->customer_id!==$username){
                $resid = $this->api->insert('notification',array('type'=>'video','username_to'=>$user->customer_id,'message'=>$userdetail->name.' has comment on  your video','username_by'=>$username,'video_id'=>$video_id));
              }
            }
           $message = array(
             'status'  => TRUE,
             'message' => 'Data fetch successfully!!',
             'comment_list' =>  $comm
          );
          $this->set_response($message, REST_Controller::HTTP_OK);
        }else{
          $message = array(
            'status' => FALSE,
            'message' => 'You have some error'
          );
          $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
        }
      }else{
        $message = array(
          'status' => FALSE,
          'message' => 'Incorrect Credeantial'
        );
        $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
      }
    }



    //******************************My Refferal ZUBAIR - 14/12/2019***********************************//

    public function myrefferal_post()
    {
     
      $token = $_SERVER['HTTP_ACCESS_TOKEN'];

      $refferal_id = $this->input->post('refferal_id'); 
      if ($id = $this->verifyToken($token)) {
          	if (!empty($refferal_id)) {
          		
	            $refferal= $this->api->accessrecord(TBL_USERLIST, ['ID, username, name, email, mobile, imageurl, date, city, editenable'], ['refferal_id'=>$refferal_id, 'ID!='=>$id], 'ID','desc', '', 'result');
	            if (!empty($refferal)) {
	            	foreach ($refferal as $refkey => $refval) {
	            		if(!empty($refval->imageurl)){
			           
                    $refferal[$refkey]->user_image =PROFILE_BASE_PATH.$refval->imageurl; 

			            }else{
			              $refferal[$refkey]->user_image =base_url('uploads/./images/default.png'); 
			            }
			            unset($refval->imageurl);

                  $refferal[$refkey]->enable =$refval->editenable; 
                  unset($refval->editenable);
	            	}
	            	$message = array(
						'status'  => TRUE,
						'message' => 'Data fetch successfully!!',
						'refferal_list' =>  $refferal
			        );
			          $this->set_response($message, REST_Controller::HTTP_OK);
	            }else{
	            	$message = array(
			          'status' => FALSE,
			          'message' => 'Record not found'
			        );
			        $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
	            }
          	}else{
  	          	$message = array(
  		          'status' => FALSE,
  		          'message' => 'Record not found'
  		        );
  		        $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
            }

      }else{
        $message = array(
          'status' => FALSE,
          'message' => 'Invalid access token'
        );
        $this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);
      }
    }

    public function allplanlist_get()
    {
      $token = $_SERVER['HTTP_ACCESS_TOKEN'];
      if ($id = $this->verifyToken($token)) {
      $myplan= $this->common->accessrecord(TBL_PACKAGE,[],[],'result');
      asort($myplan);
      if (!empty($myplan)) {
        $result=[];
        foreach ($myplan as $row) {
          $result[] = array('id' => $row->id,
                          'package_name'=>'Wedo Ent. Package',
                          'package_amount' => "$".$row->package_amount,
                          'like_count' => 'Per Day '. $row->like_count . " Video Like",
                          'share_count' => 'Per Day '. $row->share_count ." Video Share",
                          'upload_benifit' => !empty($row->video_upload) ? "Per Day ". $row->video_upload ." Video Upload" : "", 
                          "like_benifit" => "Per Video Like $0.040",
                          'share_benifit' => "Per Video Share $0.040",
                          'upload_income' => !empty($row->video_upload) ? "Per Video Upload $0.50" : ''
                        );

        }

        $message = array(
          'status'  => TRUE,
          'message' => 'Data fetch successfully!!',
          'plan_id'=> !empty($id['plan_id']) ? $id['plan_id'] : "0",
          'comment_list' =>  $result
        );
        $this->set_response($message, REST_Controller::HTTP_OK);
      }else{
        $message = array(
          'status' => FALSE,
          'message' => 'Record not found'
        );
        $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
      }
    }else{
      $message = array(
        'status' => FALSE,
        'message' => 'Session expired'
      );
      $this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);
    }
    }

    public function followinglist_post(){
      $username = $this->input->post('username');
      if (!empty($username)) { 
          $user= $this->api->check(TBL_USER, ['ID,sponsor_id as username,image,full_name as name'], ['sponsor_id'=>$username], 'row');
          if (!empty($user)) {
           $condi1 = "followers='$username' AND status='1'";
            $followings = $this->api->check('tblfollowing', [], $condi1, 'result');
            if (!empty($followings)) {
             // $follolists=$followings;
              foreach ($followings as $fkey => $fval) {
                $user2= $this->api->check(TBL_USER, [], ['sponsor_id'=>$fval->following], 'row');
                if(!empty($user2->full_name)){
                	$follolists[$fkey]['name'] = $user2->full_name;
                }else{
                	$follolists[$fkey]['name'] ='';
                }
                
                  //$follolists[$fkey]['user_image'] =base_url('uploads/'.$user2->imageurl); 
                  $follolists[$fkey]['user_image'] =BASE_URL.PROFILE_PIC.$user2->image; 
               

                $follolists[$fkey]['username'] = $fval->following;
                $follolists[$fkey]['status'] = $fval->status;
                $follolists[$fkey]['fstatus'] = $fval->fstatus;
                // ***********************
                $isfollow = $this->api->check('tblfollowing', [], ['following'=>$fval->following,'followers'=>$username,'status'=>1], 'row');
                if (!empty($isfollow)) {
                  $follolists[$fkey]['myfollow'] =1;
                }else{
                  $follolists[$fkey]['myfollow'] =0;
                }
                // ***********************
              }
               $message = array(
              'status'  => TRUE,
              'message' => 'Data fetch successfully!!',
              'following_list' => $follolists
            );
        $this->set_response($message, REST_Controller::HTTP_OK);
            }else {
               $message = array(
                   'status' => FALSE,
                   'message' => 'Data not found!!'
               );
               $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
          }
        }else{
          $message = array(
            'status' => FALSE,
            'message' => 'Invailid username'
          );
          $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
        }
      }else{
          $message = array(
            'status' => FALSE,
            'message' => 'Invailid Request'
          );
          $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
        }   
    }
   public function followerlist_post(){
      $username = $this->input->post('username');
      if (!empty($username)) { 
        //$username = substr($username,PRE_COUNT);
          $user= $this->api->check(TBL_USER, ['ID,sponsor_id as username,image,full_name  as name'], ['sponsor_id'=>$username], 'row');
          if (!empty($user)) {
              $followlist = array();
            $condi2 = "following='$username' AND status='1'";
            $fans = $this->api->check('tblfollowing', [], $condi2, 'result');
            if (!empty($fans)) {
              foreach ($fans as $fanskey => $fansval) {
                  $user3= $this->api->check(TBL_USER, [], ['sponsor_id'=>$fansval->followers], 'row');
                  if(!empty($user3->full_name)){
                    $followlist[$fanskey]['name'] = $user3->full_name;
                  }else{
                    $followlist[$fanskey]['name'] = '';
                  }
                $followlist[$fanskey]['user_image'] =BASE_URL.PROFILE_PIC.$user3->image; 
                $followlist[$fanskey]['username'] = $fansval->followers;
                $followlist[$fanskey]['status'] = $fansval->status;
                $followlist[$fanskey]['fstatus'] = $fansval->fstatus;
                // ***********************
                $isfollow = $this->api->check('tblfollowing', [], ['following'=>$fansval->followers,'followers'=>$username,'status'=>1], 'row');
                if (!empty($isfollow)) {
                  $followlist[$fanskey]['myfollow'] =1;
                }else{
                  $followlist[$fanskey]['myfollow'] =0;
                }
                // ***********************
              }
              $message = array(
              'status'  => TRUE,
              'message' => 'Data fetch successfully!!',
              'follower_list' => $followlist
            );
        $this->set_response($message, REST_Controller::HTTP_OK);
            }else {
               $message = array(
                   'status' => FALSE,
                   'message' => 'Data not found!!'
               );
               $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
          }
        }else{
          $message = array(
            'status' => FALSE,
            'message' => 'Invailid username'
          );
          $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
        }
      }else{
          $message = array(
            'status' => FALSE,
            'message' => 'Invailid Request'
          );
          $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
        }   
    }
       public function termandcondition_get()
       {
          $this->data['content'] = "webviews/terms-condition";
          $this->load->view('template1', $this->data);
       }
       public function about_get()
       {
          $this->data['content'] = "webviews/about-us";
          $this->load->view('template1', $this->data);
       }
       public function privicy_get()
       {
          $this->data['content'] = "webviews/privacy";
          $this->load->view('template1', $this->data);
       }

       public function downloadapp_get()
       {
          $this->data['content'] = "webviews/download";
          $this->load->view('template1', $this->data);
       }
        public function paymentdetail_get()
       {
          $message = array(
                'status'  => TRUE,
                'message' => 'Data fetch successfully!!',
                'paymentdetail' => base_url('downloadApp/paytm-7billions.jpeg')
              );
          $this->set_response($message, REST_Controller::HTTP_OK);
       }
       protected function getRandom($length){
          $char = array_merge(range(0, 9), range('A', 'Z'), range('a', 'z'));
          $code = '';
          for ($i = 0; $i < $length; $i++) {
             $code .= $char[mt_rand(0, count($char) - 1)];
          }
          return $code;
        }
       
        protected function verifyToken($token)
      {
        if ($record = $this->common->accessrecord(TBL_USER, ['id,sponsor_id,access_token,plan_id'],['access_token'=>$token], 'row')) {
            if (!empty($record)) {
               return array('id'=>$record->id,'sponsor_id'=>$record->sponsor_id,'token'=>$record->access_token,'plan_id'=>!empty($record->plan_id) ? $record->plan_id : '');
            }
        } else {
            return FALSE;
        }
      }
      public function add_video_post() {
        $token = $_SERVER['HTTP_ACCESS_TOKEN'];
          if ($id = $this->verifyToken($token)) { 
          //$plan_id = $this->input->post('plan_id');
          $username = $this->input->post('username');
          $description = $this->input->post('description');
          $plan_idcheck = $this->common->accessrecord(TBL_USER,['plan_id,user_name,full_name'],['id'=>$id['id']],'row');
          $plan_id = !empty($plan_idcheck->plan_id) ? $plan_idcheck->plan_id : 0;
          if (!empty($_FILES['video']['name'])&&!empty($username)) {
           date_default_timezone_set('Asia/Kolkata');
            $insdata['date'] = date('Y-m-d H:i:s');
            $insdata['customer_id'] = $username;
            $insdata['description'] = $description;
            //$insdata['category_id'] = $category_id;
            $insdata['plan_id'] = $plan_id;
            $isTrue=1;
            
            $_FILES['file']['name']     = $_FILES['video']['name'];
            $_FILES['file']['type']     = $_FILES['video']['type'];
            $_FILES['file']['tmp_name'] = $_FILES['video']['tmp_name'];
            $_FILES['file']['error']    = $_FILES['video']['error'];
            $_FILES['file']['size']     = $_FILES['video']['size'];

            //$amazon_path = "aud_{$uid}/videos/{$rna}.".pathinfo($_FILES['userfile']['name'], PATHINFO_EXTENSION);
            //echo __DIR__ ; die;
            $dir = dirname($_FILES["video"]["tmp_name"]);
            $destination = $dir . DIRECTORY_SEPARATOR . $_FILES["video"]["name"];
            rename($_FILES["file"]["tmp_name"], $destination);
            $key= 'DIR_'.$id['sponsor_id'].'/';
            //$key= 'UpendraSingh/';
            $upload = $this->s3_upload->upload_file($destination,$key); 
            if($upload!=false){
                $insdata['path'] = $upload;
            }else{
                $isTrue=0;
            }
            if(!empty($base64_string=$this->input->post('thumbnail'))) {
               $insdata['thumbnail']=$this->base64_to_jpeg($this->input->post('thumbnail'));
            }
            if($isTrue==1){
              $inst = $this->common->insertData(TBL_TASKCATEGORYVIDEOS, $insdata);
              //$inst = $this->common->insertData('mp4video',$insdata);
              if(!empty($inst)){
              
               $currentDate = date('Y-m-d');
                $totalUpload = $this->common->accessrecord(TBL_TASKCATEGORYVIDEOS,['COUNT(id) as total'],['date_format(date,"%Y-%m-%d")'=>$currentDate,'plan_id'=>$plan_id,'customer_id'=>$id['sponsor_id']],'row')->total;
                $data = $this->getpackageBenifit($plan_id);
                  if(!empty($data) && ($data->upload_count>=$totalUpload)){
                    $uploadIncome['income'] = $data->upload_amount;
                    $uploadIncome['sponsor_id'] = $username;
                    $uploadIncome['plan_id'] = $plan_id;
                    $uploadIncome['video_id'] =  $inst;
                    $uploadIncome['create_at'] = date('Y-m-d H:i:s');
                    $this->common->insertData(TBL_VIDEO_INCOME,$uploadIncome);
                    $this->common->setMethod(TBL_USER,"+",'wallet_amount',$data->upload_amount,['sponsor_id'=>$username]);
                    $this->common->setMethod(TBL_USER,"+",'total_amount',$data->upload_amount,['sponsor_id'=>$username]);
                    $this->mylevel->paymentHistory($username,$data->upload_amount,1,'Upload a video');
                    $this->mylevel->getsponsorlevel($username,$username,$data->upload_amount,0);

                      if($data = $this->common->accessrecord(TBL_FOLLOWING,['GROUP_CONCAT(followers) as ids'],['following'=>$id['sponsor_id']],'row')){
                          $alltoken = $this->common->wherein(TBL_USER,['fcm_token'],'sponsor_id',$data->ids,'result',['fcm_token!='=>""]);

                          $row[] = array('key'=>'','value'=>'row');
                          $check = $this->common->accessrecordwithjoin([TBL_USER.'.full_name,'.TBL_USER.'.user_name,CONCAT("'.PREFIX.'",'.TBL_USER.'.sponsor_id) as sponsor_id,CONCAT("'.BASE_URL.PROFILE_PIC.'",'.TBL_USER.'.image) as image,CONCAT("'.BASE_URL.VIDEO_THUMBNAIL_PATH.'",'.TBL_TASKCATEGORYVIDEOS.'.thumbnail) as videoimage'],TBL_USER,TBL_TASKCATEGORYVIDEOS,[TBL_USER.'.sponsor_id',TBL_TASKCATEGORYVIDEOS.'.customer_id'],[TBL_TASKCATEGORYVIDEOS.'.ID'=>$inst],'inner',$row);
                          if(!empty($alltoken)){
                              $title = " ".$check->full_name;
                              $username = !empty($check->user_name) ? $check->user_name : PREFIX.$check->sponsor_id;
                              $notification = [
                                "title" => $title."(".$username.")",
                                "body" => " has uploaded new video",
                                "icon" => $check->videoimage,
                                "icon1" => $check->image,
                                "sound" => true,
                                "video_id"=>$inst,
                                "action_type" => "0",
                                "click_action" => "action link"
                
                            ];
                              $fcmNotification = [
                                'registration_ids' => explode(',', $alltoken->token), //multple token array
                                'data'=> $notification
                              ];
                              fcmmsg($fcmNotification);
                          }
                      }
                  } 
                $message = array(
                  'status'  => TRUE,
                  'message' => 'Video Uploaded Successfully!',
                );
            }
          $this->set_response($message, REST_Controller::HTTP_OK);
          }else{
              $message = array(
                'status'  => false,
                'message' => 'Technical Error, Uploading time too long please try again'
              );
              $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
          }
        }else{
            $message = array(
              'status' => FALSE,
              'message' => 'Something is missing, please try again'
            );
            $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
          }
        }else{
          $message = array(
            'status' => FALSE,
            'message' => 'Session expired or login again'
          );
          $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
        }
        
      }
      /* ============== get mp3 ============================= */
          private function convertmp3andimage($id){
              $getfilename = $this->common->accessrecord(TBL_TASKCATEGORYVIDEOS,['path,customer_id'],['ID'=>$id],'row');
              $plan_idcheck = $this->common->accessrecord(TBL_USER,['user_name,full_name'],['sponsor_id'=>$getfilename->customer_id],'row');
              $filename = pathinfo($getfilename->path, PATHINFO_FILENAME);
              $savemp3 = BASE_URL.MP3;
		          $saveaac = BASE_URL.AAC;
              $mp4 =  MUSIC_VIDEO."DIR_".$getfilename->customer_id."/".$filename.".mp4";
              //$mp4 =  LOCALVIDEO_PATH.$filename.".mp4";
              $mp3folder = $savemp3.$getfilename->customer_id;
              if(!file_exists($mp3folder)){
                	  mkdir($mp3folder);
              }
              $aacfolder = $saveaac.$getfilename->customer_id;
              if(!file_exists($aacfolder)){
                  mkdir($aacfolder);
              }
              $music_name = !empty($plan_idcheck->user_name) ? "original sound - ". $plan_idcheck->user_name . " - ". $plan_idcheck->full_name : "original sound - " .$plan_idcheck->full_name;
              
              $mp3commd =  'ffmpeg -i '.$mp4. $mp3folder.'/'.$filename.'.mp3 2>&1';
              $acccomd = 'ffmpeg -i '.$mp4.' -vn -acodec copy '.$aacfolder.'/'.$filename.'.aac 2>&1';
             
              //$imagec = 'ffmpeg -i E:\aws\new\nena.mp4 -vframes 1 E:\aws\new\image1.jpeg';
              exec($mp3commd,$output,$response);
              exec($acccomd);
              if($response==0){
                $music['video_id'] = $inst;
                $music['music_name'] = $music_name;
                $music['sponsor_id'] = $id['sponsor_id'];
                $music['original'] = $filename.".mp3";
                $this->common->insertData(TBL_USER_MUSIC,$music);
              }
          }
      /* ================== end============ end============== */
      /* ======================package benifit ============================ 27 March 2020======== */
        private function getpackageBenifit($id){
          $data = $this->common->accessrecord(TBL_PACKAGE,[],['id'=>$id],'row');
          if($data){
            return (object) array('upload_amount'=>$data->upload_amount_doller,'share_like_amount'=>$data->per_share_like_dollor,'share_count'=>$data->share_count,'like_count'=>$data->like_count,'upload_count'=>$data->video_upload);
          }
        }
      /* ==================package benifit end=========== 27 March 2020 ========================= */
      public function itsupport_post()
      {
        $title = $this->input->post('title');
        $email = $this->input->post('email');
        $discription = $this->input->post('description');
        $imgn = '';
          if(!empty($email)&&!empty($title)&&!empty($discription)){
            $isTrue=1;
            if(!empty($_FILES['screenshot']['name'])){
              $imgn = uploadimage('screenshot',SUPPORT);
              if(!empty($imgn)){
                $data['screenshot'] = $imgn;
              }else{
                $isTrue=0;
              }
            }
            if($isTrue==1){
            $data['title'] = $title;
            $data['email'] = $email;
            $data['description'] = $discription;
            $resmsg = $this->api->insert('itSupport', $data);
            if(!empty($resmsg)){
              $message = array(
                'status'  => TRUE,
                'message' => 'Your request successfully sended. Please wait our expert contact you soon'
              );
              $this->set_response($message, REST_Controller::HTTP_OK);
              
            }else{
              $message = array(
                'status'  => False,
                'message' => 'Something is wrong please try again'
              );
              $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
            }
            
            }else{
              $message = array(
                'status'  => False,
                'message' => 'Image Format Not Supported'
              );
              $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
            }

          }else{
            $message = array(
              'status' => FALSE,
              'message' => 'Invalid Request'
            );
            $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
          }

      }

      function base64_to_jpeg($image) {
        $filename = md5(date('Y-m-d H:i:s')).".png";
        $binary = base64_decode($image);
       // $file = './uploads/images/video-thumbnail/'.$filename;
        //$file = '/home/billions/public_html/images/video-thumbnail/'.$filename;
        $file = VIDEO_THUMBNAIL_PATH.$filename;
        file_put_contents($file,$binary);
        return $filename; 
      }

      public function uploadVideo($updata='', $path='', $type='')
      {
        $result = '';
        $config['upload_path'] = $path;
        $config['allowed_types'] = $type;
        $config['max_size']= '';
        $config['overwrite'] = FALSE;
        $config['remove_spaces'] = TRUE;
        $config['encrypt_name'] = TRUE;
     
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!$this->upload->do_upload($updata)) {
          
          $result = '';
        }else{
          $upload_data= $this->upload->data();
          $result = $upload_data['file_name'];
        }
        return $result;
      }

    public function editprofile_post(){
          $token = $_SERVER['HTTP_ACCESS_TOKEN'];
          if ($id = $this->verifyToken($token)) { 
             extract($_POST);
            if(!empty($name)&&!empty($email)&&!empty($mobile)){
            $resuser = $this->common->accessrecord(TBL_USER,[], ['id'=>$id['id']], 'row');
            //echo "<pre>"; print_r($resuser); exit;
            if (!empty($resuser)) {
              $datad['full_name'] = $name;
              $datad['email'] = $email;
              $datad['mobile'] = $mobile;
              if(!empty($_FILES['profile']['name'])) {
              $upvid = uploadimage('profile',PROFILE_PIC);
              if(!empty($upvid)){
                $datad['image'] = $upvid;
                 $isimage=true;
              }else{
               $isimage=false; 
              }
              }else{
                $isimage=true;
              }
             
              if($isimage==true){
                  if($this->common->updateData(TBL_USER,$datad,['id'=>$id['id']])){
                   $resuser = $this->common->accessrecord(TBL_USER, ['sponsor_id as ID,full_name as name, email, mobile, image, access_token,plan_id'],['id'=>$id['id']], 'row');
                   $resuser->username= PREFIX.$resuser->ID;
                   $resuser->address='';
                   $resuser->imageurl = BASE_URL.PROFILE_PIC.$resuser->image; 
                    $message = array(
                    'status'  => TRUE,
                    'message' => 'Profile Update successfully',
                    'data' => $resuser
                  );
                    $this->set_response($message, REST_Controller::HTTP_OK);
                    }else{
                       $message = array(
                      'status' => FALSE,
                      'message' => 'Try again'
                       );
                      $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
                    } 
                  }else{
                     $message = array(
                    'status' => FALSE,
                    'message' => 'Fail to upload image!'
                     );
                    $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
                  }
              }else{
               $message = array(
                   'status' => FALSE,
                   'message' => 'Invalid User !'
              );
              $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
            }
            }else{
               $message = array(
                   'status' => FALSE,
                   'message' => 'Invalid Request'
              );
              $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
            }
          }else{
          $message = array(
          'status' => FALSE,
          'message' => 'Invalid access token'
        );
        $this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);
      } 
    }
    public function usersearch_post(){
       /* $headers = array();
          foreach (getallheaders() as $name => $value) {
              $headers[$name] = $value;
          }
          $token = $headers['Access-Token'];*/
          $token = $_SERVER['HTTP_ACCESS_TOKEN'];
          if ($id = $this->verifyToken($token)) {
            if(!empty($this->input->post('search'))){
                 $user2=$this->api->searchuser($this->input->post('search'));
                 if(!empty($user2)){
                 	 $userdata= $this->api->check(TBL_USERLIST, ['username'], ['id'=>$id], 'row');
                 foreach ($user2 as $key => $value) {
                  
                 
                 if(!empty($value->imageurl)){
                    //$user2[$key]->user_image=base_url('uploads/'.$value->imageurl); 
                    $user2[$key]->user_image=PROFILE_BASE_PATH.$value->imageurl; 

                  }else{
                    $user2[$key]->user_image= base_url('uploads/./images/default.png'); 
                  }
                  // *************************************
                   

	                $isfollow = $this->api->check('tblfollowing', [],['following'=>$value->username,'followers'=>$userdata->username,'status'=>1], 'row');
	                if (!empty($isfollow)) {
	                  $user2[$key]->myfollow =1;
	                }else{
	                  $user2[$key]->myfollow =0;
	                }
                // ******************************************
                }  
                 $message = array(
                    'status'  => TRUE,
                    'message' => 'Profile Update successfully',
                    'data' => $user2
                  );
                    $this->set_response($message, REST_Controller::HTTP_OK);
                }else{
                  $message = array(
                    'status' => FALSE,
                    'message' => 'No Record Found'
                     );
                    $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
                }    
             }else{
               $message = array(
                    'status' => FALSE,
                    'message' => 'Search value blank'
                     );
                    $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
             }     

          }else{
          $message = array(
          'status' => FALSE,
          'message' => 'Invalid access token'
        );
        $this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);
      }   
    }
    
    public function notificationlist_post(){
     
          $token = $_SERVER['HTTP_ACCESS_TOKEN'];
          if ($id = $this->verifyToken($token)) {
          	 $userdetail= $this->api->check(TBL_USER, ['sponsor_id as username,full_name as name'], ['id'=>$id['id']], 'row');

          	 $notification = $this->api->accessrecord('notification',[],['username_to'=>$userdetail->username],'id','desc', '', 'result');
             if (!empty($notification)) {
                foreach ($notification as $nkey => $nval) {
                  if(!empty($nval->username_to)){
                    // $notification[$nkey]->username_to_img
                    $username_toimg= $this->api->check(TBL_USER, ['image'], ['sponsor_id'=>$nval->username_to], 'row');
                    $notification[$nkey]->username_to_img=BASE_URL.PROFILE_PIC.$username_toimg->image;
                  }

                  if(!empty($nval->username_by)){
                    $username_byimg= $this->api->check(TBL_USER, ['image,full_name'], ['sponsor_id'=>$nval->username_by], 'row');
                     $notification[$nkey]->username_by = $nval->username_by ;
                     $notification[$nkey]->name_by =  !empty($username_byimg->full_name) ? $username_byimg->full_name : $nval->username_by;
                    if(!empty($username_byimg->image)){
                      $notification[$nkey]->username_by_img=BASE_URL.PROFILE_PIC.$username_byimg->image;
                    }
                  }
                   if($nval->type=="profile"){
                       $isfollow = $this->api->check('tblfollowing', [], ['following'=>$nval->username_by,'followers'=>$userdetail->username,'status'=>1], 'row');
                          if (!empty($isfollow)) {
                            $notification[$nkey]->follow_status="1";
                          }else{
                            $notification[$nkey]->follow_status="0";
                          }
                   }
                   if($nval->type=="video"){
                     $videodetail = $this->api->check('task_category_videos', [], ['ID'=>$nval->video_id],'row');
                      if(!empty($videodetail->thumbnail)){
                        $notification[$nkey]->thumbnail = BASE_URL.VIDEO_THUMBNAIL_PATH.$videodetail->thumbnail;
                      } 
                   }
                   if(!empty($nval->created_date)){
                      $notification[$nkey]->date = time_ago_in_php($nval->created_date);
                      $notification[$nkey]->time = date('h:i a', strtotime($nval->created_date));
                   }else{
                    $notification[$nkey]->date = '';
                    $notification[$nkey]->time = '';
                   }
                   unset($nval->created_date);
                  // *************************************
                }
             }

              if(!empty($notification)){
                  $nticount = $this->db->where('read_notifi', 0)->where('username_to', $userdetail->username)->count_all_results('notification');
                  if(!empty($nticount)){
                    $total_notifi = $nticount;
                  }else{
                    $total_notifi = 0;
                  }
              	$message = array(
                    'status'  => TRUE,
                    'message' => 'Notification list',
                    'total_notifi' => $total_notifi,
                    'data' => $notification
                  );
                    $this->set_response($message, REST_Controller::HTTP_OK);
              }else{
              	$message = array(
                    'status' => FALSE,
                    'message' => 'No record found'
                     );
                    $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
              }

          }else{
          $message = array(
          'status' => FALSE,
          'message' => 'Invalid access token'
        );
        $this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);
      }    
    }

    public function addbank_post(){
          $token = $_SERVER['HTTP_ACCESS_TOKEN'];
          if ($id = $this->verifyToken($token)) {
            $data['bank_name']=$this->input->post('bank');
            $data['account_number']=$this->input->post('account_number');
            $data['branch']=$this->input->post('branch');
            $data['ifsc_code']=$this->input->post('ifsc');
            $data['ac_holder_name'] = $this->input->post('accont_holder_name');
            
            if(!empty($data['bank_name']) && !empty($data['account_number']) && !empty($data['branch']) && !empty($data['ifsc_code'])){
              $isTrue=1; 
              if(!empty($_FILES['image']['name'])){
                  $image = uploadimage('image',BANK_IMAGE);
                  if($image){
                    $data['image'] = $image;
                  }else{
                    $isTrue=0;
                  }
                }
                if($isTrue==1){
                    if($this->common->accessrecord(TBL_BANK_INFO,[],['user_id'=>$id['id']],'row')){
                        $this->common->updateData(TBL_BANK_INFO,$data,['user_id'=>$id['id']]);
                    }else{
                        $this->common->insertData(TBL_BANK_INFO,$data);
                    }
                    $message = array(
                      'status' => true,
                      'message' => 'Bank Details Added successfully'
                     );
                     $this->set_response($message, REST_Controller::HTTP_OK);
                }else{
                  $message = array(
                    'status' => FALSE,
                    'message' => 'Image format not valid'
                   );
                   $this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);
                }
            }   
            else{
              $message = array(
               'status' => FALSE,
               'message' => 'Something is missing please fill all feild'
              );
              $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
            }
          }else{
          $message = array(
          'status' => FALSE,
          'message' => 'Invalid access token'
        );
        $this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);
      }  
    }
    function kycDocument_post(){
      $token = $_SERVER['HTTP_ACCESS_TOKEN'];
      if ($id = $this->verifyToken($token)) {
        $type = $this->input->post('kyc_type');
        $array=array();
          if($type==1){
              $bank = $this->common->accessrecord(TBL_BANK_INFO,[],['user_id'=>$id['id']],'row');
              $array['ifsc'] = !empty($bank->ifsc_code) ? $bank->ifsc_code : '';
              $array['account_number'] = !empty($bank->account_number) ? $bank->account_number : '';
              $array['bank_name'] = !empty($bank->bank_name) ? $bank->bank_name : '';
              $array['account_holder_name'] = !empty($bank->ac_holder_name) ? $bank->ac_holder_name : '';
              $array['branch_name'] = !empty($bank->branch) ? $bank->branch : '';
              $array['image'] = !empty($bank->image) ? BASE_URL.BANK_IMAGE.$bank->image : '';
              $array['bank_status'] = !empty($bank->bank_status) ? 'Bank Kyc Pending' : 'Bank Kyc Approved';
          }elseif($type==2){
            $idCard = $this->common->accessrecord(TBL_KYC,[],['sponsor_id'=>$id['sponsor_id']],'row');
            $array['id_type'] = !empty($idCard->id_type) ? $idCard->id_type : '';
            $array['id_number'] = !empty($idCard->id_number) ? $idCard->id_number : '';
            $array['front_image'] = !empty($idCard->front_image) ? BASE_URL.BANK_IMAGE.$idCard->front_image : '';
            $array['back_image'] = !empty($idCard->back_image) ? BASE_URL.BANK_IMAGE.$idCard->back_image : '';
            $array['status'] = !empty($idCard->status) && $idCard->status==0 ? 'Id Card Kyc Pending' : 'Id Card Kyc Approved';
          } elseif($type==3){
            $pancard = $this->common->accessrecord(TBL_KYC,[],['sponsor_id'=>$id['sponsor_id']],'row');
            $array['pan_number'] = !empty($pancard->id_number) ? $pancard->id_number : '';
            $array['dob'] = !empty($pancard->dob) ? $pancard->dob : '';
            $array['dob'] = !empty($pancard->dob) ? $pancard->dob : '';
            $array['pan_image'] = !empty($pancard->front_image) ? $pancard->front_image : '';
            $array['status'] = !empty($pancard->status) && $pancard->status==0 ? 'Pan Card Kyc Pending' : 'Pan Card Kyc Approved';
          }
          $message = array(
            'status' => true,
            'message' => 'Data Fatched',
            'data' => $array
          );
          $this->set_response($message, REST_Controller::HTTP_OK);
       }else{
        $message = array(
          'status' => false,
          'message' => 'Session time out , please login again'
        );
        $this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);
      }
    }
    function idCard_post(){
      $token = $_SERVER['HTTP_ACCESS_TOKEN'];
      if ($id = $this->verifyToken($token)) { 
        $idCardId = $this->input->post('id_card_id');
        $isTrue=1;
        if(!empty($_FILES['front_image']['name'])){
            $front_image = uploadimage('front_image',BANK_IMAGE);
              if($front_image){
                $data['front_image'] = $front_image;
              }else{
                $isTrue=0;
              }
        }
        if(!empty($_FILES['back_image']['name'])){
            $back_image = uploadimage('back_image',BANK_IMAGE);
              if($back_image){
                $data['back_image'] = $back_image;
              }else{
                $isTrue=0;
              }
        }
        if($isTrue==1){
          $data['sponsor_id'] = $id['sponsor_id'];
          $data['id_type'] = $this->input->post('id_type');
          $data['id_number'] = $this->input->post('id_number');
          if(!empty($idCardId)){
            $this->common->updateData(TBL_KYC,$data,['id'=>$idCardId]);
          }else{
            $this->common->insertData(TBL_KYC,$data);
          }
          $data = $this->common->accessrecord(TBL_KYC,[],['sponsor_id'=>$id['sponsor_id']],'row');
          $result['id'] = $data->id;
          $result['id_type'] = $data->id_type;
          $result['id_number'] = $data->id_number;
          $result['front_image'] = !empty($data->front_image) ? BASE_URL.BANK_IMAGE.$data->front_image : '';
          $result['back_image'] = !empty($data->back_image) ? BASE_URL.BANK_IMAGE.$data->back_image : '';
          $result['status'] = !empty($data->status) && ($data->status==0) ? 'Id Card KYC is Pending' : 'ID card KYC is Approved';
          $message = array(
            'status' => True,
            'message' => 'Id Card Uploaded successfully',
            'data' => $result
          );
          $this->set_response($message, REST_Controller::HTTP_OK);
        }else{
          $message = array(
            'status' => FALSE,
            'message' => 'Image format not valid'
          );
          $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
        }
      }else{
        $message = array(
          'status' => FALSE,
          'message' => 'Session time out, please login again'
        );
        $this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);
      }
    }
    function PanCard_post(){
      $token = $_SERVER['HTTP_ACCESS_TOKEN'];
      if ($id = $this->verifyToken($token)) { 
        $panCard = $this->input->post('pan_card_id');
        $isTrue=1;
        if(!empty($_FILES['front_image']['name'])){
            $front_image = uploadimage('front_image',BANK_IMAGE);
              if($front_image){
                $data['front_image'] = $front_image;
              }else{
                $isTrue=0;
              }
        }
        if($isTrue==1){
          $data['sponsor_id'] = $id['sponsor_id'];
          $data['dob'] = date('d/m/Y',strtotime($this->input->post('dob')));
          $data['id_number'] = $this->input->post('id_number');
          if(!empty($panCard)){
            $data['status'] = 0;
            $this->common->updateData(TBL_KYC,$data,['id'=>$panCard]);
          }else{
            $this->common->insertData(TBL_KYC,$data);
          }
          $data = $this->common->accessrecord(TBL_KYC,[],['sponsor_id'=>$id['sponsor_id']],'row');
          $result['id'] = $data->id;
          $result['id_number'] = $data->id_number;
          $result['dob'] = $data->dob;
          $result['front_image'] = !empty($data->front_image) ? BASE_URL.BANK_IMAGE.$data->front_image : '';
          $result['status'] = !empty($data->status) && ($data->status==0) ? 'Pancard KYC is Pending' : 'Pancard KYC Approved';
          $message = array(
            'status' => True,
            'message' => 'Id Card Uploaded successfully',
            'data' => $result
          );
          $this->set_response($message, REST_Controller::HTTP_OK);
        }else{
          $message = array(
            'status' => FALSE,
            'message' => 'Image format not valid'
          );
          $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
        }
      }else{
        $message = array(
          'status' => FALSE,
          'message' => 'Session time out, please login again'
        );
        $this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);
      }
    }
    public function transectionHistory_post(){
    
           $token = $_SERVER['HTTP_ACCESS_TOKEN'];
          if ($id = $this->verifyToken($token)) {  
                $username = $this->input->post('username');
                if (!empty($username)) { 
                    $user= $this->api->check(TBL_USERLIST, ['ID,username,imageurl,name'], ['username'=>$username], 'row');
                    if (!empty($user)) {
                      $trans= $this->api->accessrecord('transaction', [], ['username'=>$username], 'id','desc', '', 'result');
                      foreach ($trans as $key => $value) {
                        $trans[$key]->type=($value->type==1)?'Debit':'Credit';

                  
                  if($trans[$key]->status==0)
                  {
                    $trans[$key]->status="Pending";
                  }
                  elseif($trans[$key]->status==1)
                  {
                    $trans[$key]->status="In-process";
                  }
                  elseif($trans[$key]->status==2)
                  {
                    $trans[$key]->status="Completed";
                  }
                      }
                      $message = array(
                    'status'  => TRUE,
                    'message' => 'Profile Update successfully',
                    'data' => $trans
                  );
                $this->set_response($message, REST_Controller::HTTP_OK);

                    }else{
                    $message = array(
                      'status' => FALSE,
                      'message' => 'Invailid username'
                    );
                    $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
                  }
                 }else{
                    $message = array(
                      'status' => FALSE,
                      'message' => 'Invailid Request'
                    );
                    $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
                  } 
           }else{
          $message = array(
          'status' => FALSE,
          'message' => 'Invalid access token'
        );
        $this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);
      }    
    }

   
    function getwallet_get(){
      $token = $_SERVER['HTTP_ACCESS_TOKEN'];
      if ($id = $this->verifyToken($token)) {
          $data = $this->common->accessrecord(TBL_USER,['wallet_amount'],['id'=>$id['id']],'row');
          $message = array(
            'status' => true,
            'message' => 'wallet amount',
            'wallet_amount' => $data->wallet_amount
          );
          $this->set_response($message, REST_Controller::HTTP_OK);
      }else{
        $message = array(
          'status' => FALSE,
          'message' => 'Invalid access token'
        );
        $this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);
      }
    }
    function myrefferal_get(){
      $token = $_SERVER['HTTP_ACCESS_TOKEN'];
      if ($id = $this->verifyToken($token)) {
        $content[] = array('key'=>'Every successfully Download Get' ,'value'=>'100 point');
        $content[] = array('key'=>'Every Successfully Referral Get','value'=>'',);
        $content[] = array('key'=>'1 Level' ,'value'=>'10 Point');
        $content[] = array('key'=>'2 Level','value'=>'05 Point');
        $content[] = array('key'=>'3 Level','value'=>'03 Point');
        $content[] = array('key'=>'4 Level','value'=>'02 Point');
        $content[] = array('key'=>'5 Level','value'=>'01 Point');
        $array = array('logo'=>BASE_URL.'assets/web/images/logo1.png',
                      'referral_code'=>PREFIX.$id['sponsor_id'],
                      'content'=> $content);
        $message = array(
          'status' => true,
          'message' => 'Refferal Code',
          'data' => $array
        );
        $this->set_response($message, REST_Controller::HTTP_OK);
      }else{
        $message = array(
          'status' => FALSE,
          'message' => 'Invalid access token'
        );
        $this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);
      }
    }
   

    
     public function sharevideo_post(){
      $token = $_SERVER['HTTP_ACCESS_TOKEN'];
      if ($id = $this->verifyToken($token)) {
     
         $video_id = $this->input->post('video_id');
         if(!empty($video_id)){
          if($this->common->setMethod(TBL_TASKCATEGORYVIDEOS,"+","share",'1',['id'=>$video_id])){
              $shareHistory['video_id'] = $video_id;
              $shareHistory['plan_id'] = $id['plan_id'];
              $shareHistory['sponsor_id'] = $id['sponsor_id'];
              $shareHistory['create_at'] = date('Y-m-d H:i:s');
              $this->common->insertData(TBL_SHARE_LIKE_HISTORY,$shareHistory);
              if($id['plan_id']){
                $currentDate = date('Y-m-d');
                  $totalShared = $this->common->accessrecord(TBL_SHARE_LIKE_HISTORY,['COUNT(id) as total'],['date_format(create_at,"%Y-%m-%d")'=>$currentDate,'plan_id'=>$id['plan_id'],'sponsor_id'=>$id['sponsor_id']],'row')->total;
                  $data = $this->getpackageBenifit($id['plan_id']);
                  if($data->share_count>=$totalShared){
                    $shareIncome['income'] = $data->share_like_amount;
                    $shareIncome['sponsor_id'] = $id['sponsor_id'];
                    $shareIncome['plan_id'] = $id['plan_id'];
                    $shareIncome['type'] = 1;
                    $shareIncome['video_id'] = $video_id;
                    $shareIncome['create_at'] = date('Y-m-d H:i:s');
                    $this->common->insertData(TBL_VIDEO_INCOME,$shareIncome);
                    $this->common->setMethod(TBL_USER,"+",'wallet_amount',$data->share_like_amount,['sponsor_id'=>$id['sponsor_id']]);
                    $this->common->setMethod(TBL_USER,"+",'total_amount',$data->share_like_amount,['sponsor_id'=>$id['sponsor_id']]);
                    $this->mylevel->paymentHistory($id['sponsor_id'],$data->share_like_amount,1,'Shared a video');
                    $this->mylevel->getsponsorlevel($id['sponsor_id'],$id['sponsor_id'],$data->share_like_amount,1);
                  }
              }
             $message = array(
                 'status'  => TRUE,
                 'message' => 'Video Share successfully!!'
              );
              $this->set_response($message, REST_Controller::HTTP_OK);
           }else{
              $message = array(
                   'status' => FALSE,
                   'message' =>'Try again!!'
                );
               $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
           }   
         }else{
          $message = array(
                   'status' => FALSE,
                   'message' => 'Vedio id can not be blank!!'
                );
               $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
         }
      }else{
        $message = array(
          'status' => FALSE,
          'message' => 'Invalid access token'
        );
        $this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);
      }

    }
  

    public function getchecksum_post(){

      $checkSum = "";

      // below code snippet is mandatory, so that no one can use your checksumgeneration url for other purpose .
      $findme   = 'REFUND';
      $findmepipe = '|';
       //print_r($_POST);die;
      $paramList = array();

      $paramList["MID"] = $this->input->post('MID');
      $paramList["ORDER_ID"] = $this->input->post('ORDER_ID');
      $paramList["CUST_ID"] = $this->input->post('CUST_ID');
      $paramList["INDUSTRY_TYPE_ID"] =$this->input->post('INDUSTRY_TYPE_ID');
      $paramList["CHANNEL_ID"] = $this->input->post('CHANNEL_ID');
      $paramList["TXN_AMOUNT"] =  $this->input->post('TXN_AMOUNT');
      $paramList["WEBSITE"] = $this->input->post('WEBSITE');
      $paramList["CALLBACK_URL"]=$this->input->post('CALLBACK_URL');
      $paramList["EMAIL"] = $this->input->post('EMAIL');
      $paramList["MOBILE_NO"]=$this->input->post('MOBILE_NO');
      if(!empty($paramList["MID"]) && !empty($paramList["ORDER_ID"]) && !empty($paramList["CUST_ID"]) && !empty($paramList["INDUSTRY_TYPE_ID"]) && !empty($paramList["CHANNEL_ID"]) && !empty($paramList["TXN_AMOUNT"]) && !empty($paramList["WEBSITE"]) && !empty($paramList["CALLBACK_URL"]) && !empty($paramList["EMAIL"]) && !empty($paramList["MOBILE_NO"])){
          foreach($_POST as $key=>$value)
          {  
            $pos = strpos($value,$findme);
            $pospipe = strpos($value, $findmepipe);
            if ($pos === false || $pospipe === false) 
              {
                  $paramList[$key] = $value;
              }
          }
        
      //Here checksum string will return by getChecksumFromArray() function.
      $checkSum = getChecksumFromArray($paramList,PAYTM_MERCHANT_KEY);
      // echo json_encode(array("CHECKSUMHASH" => $checkSum,"ORDER_ID" => $_POST["ORDER_ID"], "payt_STATUS" => "1"),JSON_UNESCAPED_SLASHES);
      $res=array("CHECKSUMHASH" => $checkSum,"ORDER_ID" => $_POST["ORDER_ID"], "payt_STATUS" => "1");
        $message = array(
                  'status'  => TRUE,
                  'message' => 'Data fetch successfully!!',
                  'data' =>$res
                );
                $this->set_response($message, REST_Controller::HTTP_OK);
      }else{
       
              $message = array(
                'status' => FALSE,
                'message' => 'Invalid Request'
              );
              $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
      }          
     
    }
    
    function sendotherOtp_post(){
      $mobile_number = $this->input->post("mobile");
      $hash = $this->input->post('hash');
      $rand=rand(1000,9999);
          message($rand,$mobile_number,$hash);
          $message = array(
              'status'  => TRUE,
              'message' => 'OTP sent in given mobile number',
              'otp' => $rand
          );
          $this->set_response($message, REST_Controller::HTTP_OK);
    }
  
    public function forceupdate_get(){
      $this->response([
                  'status' => True,
                  'message' => 'New Update Found',
                  'version' => 2

              ], REST_Controller::HTTP_OK); 
    }

    public function newnotification_get(){
    
      $token = $_SERVER['HTTP_ACCESS_TOKEN'];
     
      if ($id = $this->verifyToken($token)) {
         $userdetail= $this->common->accessrecord(TBL_USER, ['full_name as name,sponsor_id'], ['id'=>$id['id']], 'row');
      $notification = $this->common->accessrecord('notification',[],['username_to'=>$id['sponsor_id'],'read_notifi'=>0],'result');
             if (!empty($notification)) {
               $this->response([
                  'status' => True,
                  'message' =>'New Notification',
                  'data' =>sizeof($notification)

              ], REST_Controller::HTTP_OK); 

             }else{
               $message = array(
              'status' => FALSE,
              'message' => 'No new notification found'
            );
            $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);  
             }
       }else{
            $message = array(
              'status' => FALSE,
              'message' => 'Invalid access token'
            );
            $this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);  
      } 
    }

public function newtaskcategoryvideos_post()
       {
            $username1 = $this->input->post('username');
            $category_id = $this->input->post('category_id');
            $type = $this->input->post('type');
            $last_record_count=$this->input->post('last_record_count');
            $caties=[];
            if(empty($type)){
              $caties = $this->db->query('SELECT * FROM '.TBL_TASKCATEGORYVIDEOS.' WHERE date + INTERVAL 20 MINUTE < now() and is_home=1 ORDER by rand()')->result();
            }elseif(!empty($type) && ($type==1)){
              $caties = $this->db->query('SELECT * FROM '.TBL_TASKCATEGORYVIDEOS.' WHERE date + INTERVAL 20 MINUTE < now() and is_popular=1 ORDER by rand()')->result();
            }elseif(!empty($type) && ($type==2)){
              $check = $this->common->accessrecord(TBL_FOLLOWING,['GROUP_CONCAT(following) as ids'],['followers'=>$username1],'row');
              if($check->ids){
                $caties = $this->db->query('SELECT * FROM '.TBL_TASKCATEGORYVIDEOS.' WHERE customer_id IN ('.$check->ids.') and is_home=1 ORDER BY rand()')->result();
                
              }
            } // type=2 for following
            if(!empty($caties)){
             
              $page = (int)$last_record_count;
              $per_page = 100;
              $total_rows = count($caties);
              $total_page = ceil($total_rows / $per_page);

             if(empty($last_record_count)){
                $categories = array_slice($caties,0,100);

             }else{
              $last_record_count=(int)$last_record_count*$per_page;
                $categories = array_slice($caties, $last_record_count, 100);

             }
             
              foreach ($categories as $catkey => $catval) {

                $categories[$catkey]->date =$this->api->duration($catval->date);
                $isfollow = $this->common->accessrecord('tblfollowing', [], ['following'=>$catval->customer_id,'followers'=>$username1,'status'=>1], 'row');
                if (!empty($isfollow)) {
                  $categories[$catkey]->myfollow =(string)1;
                }else{
                  $categories[$catkey]->myfollow =(string)0;
                }
                if($catval->customer_id==$username1){
                  $categories[$catkey]->myfollow =(string)1;
                }
                // ***********************
                $username = $this->common->accessrecord(TBL_USER, [], ['sponsor_id'=>$catval->customer_id], 'row');
                if(!empty($username)){
                  $categories[$catkey]->post_by = !empty($username->user_name) ? $username->user_name : (!empty($username->full_name) ? $username->full_name : 'Unknown');
                  $categories[$catkey]->user_type = !empty($username->user_type) ? $username->user_type : '';
                  $categories[$catkey]->user_image =BASE_URL.PROFILE_PIC.$username->image; 
                  if(!empty($catval->thumbnail)){
                    //$categories[$catkey]->thumbnail = base_url('uploads/images/video-thumbnail/'.$catval->thumbnail);
                    $categories[$catkey]->thumbnail =  BASE_URL.VIDEO_THUMBNAIL_PATH.$catval->thumbnail;
                  }else{
                    $categories[$catkey]->thumbnail = base_url('uploads/images/video-thumbnail/valentine2.jpg');
                  }
                  //$categories[$catkey]->path = base_url('uploads/'.$catval->path);
                  $filename = pathinfo($catval->path, PATHINFO_FILENAME);
                  $categories[$catkey]->path = VIDEO_PATH."DIR_".$catval->customer_id."/".$filename."/".$filename.".m3u8";
                  // $categories[$catkey]->path =  'https://tip-top-video-aws-video-transcoder.s3.ap-south-1.amazonaws.com/DIR_35405605/output-filtered-DIWpht4zsYmNDIT/output-filtered-DIWpht4zsYmNDIT.m3u8';
                  $aac = @file_get_contents($row->image);
                 // BASE_URL.AAC.$catval->customer_id.'/'.$filename.".aac
                  $categories[$catkey]->audio_video_path = array('mp4'=>MUSIC_VIDEO."DIR_".$catval->customer_id."/".$filename.".mp4",
                        'mp3'=>BASE_URL.MP3.$catval->customer_id.'/'.$filename.".mp3",
                        'aac'=> @file_get_contents(BASE_URL.AAC.$catval->customer_id."/".$filename.".aac") ? BASE_URL.AAC.$catval->customer_id."/".$filename.".aac"  : VIDEO_PATH."DIR_".$catval->customer_id."/".$filename."/".$filename."aac_00001.aac",
                        "song_name" => !empty($username->user_name) ? "original song - ".$username->user_name . " - ". $username->full_name : " original sound -". $username->full_name
                      ); 
                  if (!empty($catval->ID)) {
                    // $like_count = $this->api->totallikecount($catval->ID);
                    $resuser1 = $this->common->accessrecord('likeunlike', [],['video_id'=>$catval->ID, 'likes'=>1], 'result');
                    if (!empty($resuser1)) {
                      $categories[$catkey]->like_count = (string)count($resuser1);
                      foreach ($resuser1 as $likebkey => $likebval) {
                        if ($likebval->username==trim($username1)) {
                          $categories[$catkey]->likeed = 1;
                        }else{
                          $categories[$catkey]->likeed = 0;
                        }
                      }
                    }else{
                      $categories[$catkey]->like_count = (string)0;
                      $categories[$catkey]->likeed = 0;
                    }


                    $commentlist = $this->common->commentlist('comments', $catval->ID);
                    if (!empty($commentlist)) {
                      $categories[$catkey]->comment_count = (string)count($commentlist);
                      $categories[$catkey]->comment_list = $commentlist;
                    }else{
                      $categories[$catkey]->comment_count = (string)0;
                      $categories[$catkey]->comment_list = [];
                    }
                  }
                }
              }
           
              // $datas['videos_list'] = $categories;
              $message = array(
                 'status'  => TRUE,
                 'message' => 'Data fetch successfully!!',
                 'page' => $page,
                 'per_page' => $per_page,
                 'total' => $total_rows,
                 'total_pages' => $total_page,
                 'data'    => $categories
              );


              $this->set_response($message, REST_Controller::HTTP_OK);
            }else {
                $message = array(
                   'status' => FALSE,
                   'message' => 'Data not found!!'
                );
               $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
            }
       }
     
       public function iswithdraw_get(){
           $currentdate=date('d');
          //$currentdate=6;
          // $currentdate=1;
         if ($currentdate<=5 && $currentdate>=1){
               $this->response([
                  'status' => True,
                  'message' =>'Withdaw now',
                 

              ], REST_Controller::HTTP_OK); 

             }else{
               $message = array(
              'status' => FALSE,
              'message' => 'You can withdrawal between 1 to 5'
            );
                $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);

       }
       }

       /* ============================= wallet information =====  27 March 2020============ */

        function totalIncome_get(){
          $token = $_SERVER['HTTP_ACCESS_TOKEN'];
          if ($id = $this->verifyToken($token)) {
             $data =  $this->common->accessrecord(TBL_USER,['TRUNCATE(wallet_amount,3) as wallet_amount,TRUNCATE(total_amount,3) as total_amount'],['id'=>$id['id']],'row');
             $videoIncome = $this->common->accessrecord(TBL_VIDEO_INCOME,[],['sponsor_id'=>$id['sponsor_id']],'result');
             $levelincome = $this->common->accessrecord(TBL_LEVEL_INCOME,['SUM(amount) as total'],['sponsor_id'=>$id['sponsor_id'],'status'=>1],'row');
             $boosterIncome = $this->common->accessrecord(TBL_BOOSTER_INCOME,[],['sponsor_id'=>$id['sponsor_id']],'result');
             $likeIncome = 0;
             $sharedIncome=0;
             $uploadIncome=0;
             $boostUploadincome=0;
             $boostLikeincome=0;
             $boostSharedincome=0;
             if(!empty($videoIncome)){
                 foreach($videoIncome as $row){
                   if($row->type==0){
                     $uploadIncome+= $row->income;
                   }if($row->type==1){
                     $sharedIncome+= $row->income;
                   }if($row->type==2){
                     $likeIncome+= $row->income;
                   }
                 }
             }
             if(!empty($boosterIncome)){
                foreach($boosterIncome as $row){
                  if($row->type==0){
                    $boostUploadincome+= $row->amount;
                  }if($row->type==1){
                    $boostSharedincome+= $row->amount;
                  }if($row->type==2){
                    $boostLikeincome+= $row->amount;
                  }
                }
             }
             $data->video_upload_income = "$uploadIncome";
             $data->video_share_income = "$sharedIncome";
             $data->video_like_income = "$likeIncome";
             $data->level_income = !empty($levelincome->total) ? $levelincome->total : "0"; 
             $data->booster_upload_income = "$boostUploadincome";
             $data->booster_share_income = "$boostSharedincome";
             $data->booster_like_income = "$boostLikeincome";
             $message = array(
              'status' => true,
              'data' => $data
            );
                $this->set_response($message, REST_Controller::HTTP_OK);
          }else{
            $message = array(
              'status' => FALSE,
              'message' => 'Session Expired'
            );
                $this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);
          }
        }
        function getwalletHistory_post(){
          $token = $_SERVER['HTTP_ACCESS_TOKEN'];
          if ($id = $this->verifyToken($token)) {
            $type= $this->input->post('wallet_type');
            if($data = $this->common->accessrecord(TBL_VIDEO_INCOME,['income,date_format(create_at,"%Y-%m-%d") as income_date'],['type'=>$type,'sponsor_id'=>$id['sponsor_id']],'result')){

              $message = array(
                'status' => true,
                'message'=> 'Getting information',
                'data' => $data
              );
                  $this->set_response($message, REST_Controller::HTTP_OK);
            }else{
              $message = array(
                'status' => FALSE,
                'message' => 'No Record Found!'
              );
                  $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
            }
          }else{
            $message = array(
              'status' => FALSE,
              'message' => 'Session Expired'
            );
                $this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);
          } 
          
        }
       /* =======================end============end============end= wallet information===== */

       /* ===================== level income history======================================== */
       function getlevelincomeHistory_get(){
        $token = $_SERVER['HTTP_ACCESS_TOKEN'];
        if ($id = $this->verifyToken($token)) {
          $array[] = array('key'=>' INNER JOIN '. TBL_USER.' t1 ON ','value'=> TBL_LEVEL_INCOME.'.from_sponsor=t1.sponsor_id');
          $array[] = array('key'=>' WHERE '.TBL_LEVEL_INCOME.'.sponsor_id=','value'=>$id['sponsor_id']);
          $data =$this->common->accessrecordwithjoin(['CONCAT("'.PREFIX.'",'.TBL_LEVEL_INCOME.'.from_sponsor) as from_sponsor , CONCAT("$",'.TBL_LEVEL_INCOME.'.amount) as amount ,CONCAT("$",'.TBL_LEVEL_INCOME.'.on_amount) as package_amount, '.TBL_LEVEL_INCOME.'.level, DATE_FORMAT('.TBL_LEVEL_INCOME.'.on_date,"%d-%m-%Y") as on_date,'.TBL_LEVEL_INCOME.'.status,t1.full_name as fromsponsor_name'],TBL_LEVEL_INCOME,TBL_USER,[TBL_LEVEL_INCOME.'.sponsor_id',TBL_USER.'.sponsor_id'],[],'inner',$array);
          if($data){
            $message = array(
              'status' => true,
              'message'=> 'Getting information',
              'data' => $data
            );
                $this->set_response($message, REST_Controller::HTTP_OK);
          }else{
            $message = array(
              'status' => FALSE,
              'message' => 'No Record Found!'
            );
                $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
          }
        }else{
          $message = array(
            'status' => FALSE,
            'message' => 'Session Expired'
          );
              $this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);
        } 
        
      }
       /* ====================end========level income history=============================== */
       /* =================== booster income ========= start========start===================*/
         function boosterRoiIncome_post(){
            $token = $_SERVER['HTTP_ACCESS_TOKEN'];
            if ($id = $this->verifyToken($token)) {
              $type =  $this->input->post('type'); 
              $array[] = array('key'=>' INNER JOIN '. TBL_USER.' t1 ON ','value'=> TBL_BOOSTER_INCOME.'.from_user=t1.sponsor_id');
              $array[] = array('key'=>' WHERE '.TBL_BOOSTER_INCOME.'.sponsor_id=','value'=>$id['sponsor_id'].' AND '.TBL_BOOSTER_INCOME.'.type='.$type);
              $data =$this->common->accessrecordwithjoin(['CONCAT("'.PREFIX.'",'.TBL_BOOSTER_INCOME.'.from_user) as from_sponsor , CONCAT("$",'.TBL_BOOSTER_INCOME.'.amount) as amount ,CONCAT("$",'.TBL_BOOSTER_INCOME.'.on_amount) as package_amount, '.TBL_BOOSTER_INCOME.'.on_level, DATE_FORMAT('.TBL_BOOSTER_INCOME.'.create_at,"%d-%m-%Y") as on_date,t1.full_name as fromsponsor_name'],TBL_BOOSTER_INCOME,TBL_USER,[TBL_BOOSTER_INCOME.'.sponsor_id',TBL_USER.'.sponsor_id'],[],'inner',$array);
              if($data){
                $message = array(
                  'status' => true,
                  'message'=> 'Getting information',
                  'data' => $data
                );
                    $this->set_response($message, REST_Controller::HTTP_OK);
              }else{
                $message = array(
                  'status' => FALSE,
                  'message' => 'No Record Found!'
                );
                    $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
              }
            }else{
              $message = array(
                'status' => FALSE,
                'message' => 'Session Expired'
              );
                  $this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);
            }   
         }
       /* ===================== booster income end=============end=-========================*/
       /* ============= referral report======== start================= 10 May, 2020======== */
        
       function refferalReport_get(){
        $token = $_SERVER['HTTP_ACCESS_TOKEN'];
        if ($id = $this->verifyToken($token)) {
           $point =  $this->common->accessrecord(TBL_USER,['referral_point'],['id'=>$id['id']],'row');
           $array[] = array('key'=>' LEFT JOIN '. TBL_USER.' t1 ON ','value'=> TBL_REFFERAL_POINT.'.from_sponsor_id=t1.sponsor_id');
           $array[] = array('key'=>' WHERE '.TBL_REFFERAL_POINT.'.to_sponsor_id=','value'=>$id['sponsor_id']);
           $data =$this->common->accessrecordwithjoin([' ( CASE WHEN '.TBL_REFFERAL_POINT.'.from_sponsor_id=0 THEN 0 ELSE CONCAT("'.PREFIX.'",'.TBL_REFFERAL_POINT.'.from_sponsor_id) END) as from_sponsor ,'.TBL_REFFERAL_POINT.'.point ,'.TBL_REFFERAL_POINT.'.level, DATE_FORMAT('.TBL_REFFERAL_POINT.'.create_at,"%d-%m-%Y") as on_date,(CASE WHEN t1.full_name!=""  THEN t1.full_name ELSE "" END) as fromsponsor_name'],TBL_REFFERAL_POINT,TBL_USER,[TBL_REFFERAL_POINT.'.to_sponsor_id',TBL_USER.'.sponsor_id'],[],'inner',$array);
           $message = array(
            'status' => true,
            'referral_point' => $point->referral_point,
            'data'=> !empty($data) ? $data :[]
          );
              $this->set_response($message, REST_Controller::HTTP_OK);
        }else{
          $message = array(
            'status' => FALSE,
            'message' => 'Session Expired'
          );
              $this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);
        }
      }
       /* ===============refferal report =========end===========end===== 10 May, 2020====== */
       /* ============== all transaction history======== March 27, 2020=================== */
        function allpaymenthisory_get(){
          $token = $_SERVER['HTTP_ACCESS_TOKEN'];
          if ($id = $this->verifyToken($token)) {
              if($data = $this->common->accessrecord(TBL_PAYMENT_HISTORY,[],['sponsor_id'=>$id['sponsor_id']],'result')){
                $message = array(
                  'status' => true,
                  'message' =>'Information Fetched',
                  'data' => $data
                );
                    $this->set_response($message, REST_Controller::HTTP_OK);
              }else{
                $message = array(
                  'status' => FALSE,
                  'message' => 'No Transaction History here!'
                );
                    $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
              }
          }else{
            $message = array(
              'status' => FALSE,
              'message' => 'Session Expired'
            );
                $this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);
          }
        }
       /* ===============all transaction information====end====== March 27, 2020========== */
       function checkaddress($add){
        if(preg_match('/^[13][a-zA-Z0-9]{27,34}$/',$add)){
          return true;
        }else{
          return false;
        }
      }
       /* =================================== add bank details============================= */
          function BtcAddress_post(){
            $token = $_SERVER['HTTP_ACCESS_TOKEN'];
            if ($id = $this->verifyToken($token)) {
              $msg='Please enter correct BTC address';
              $btc = $this->common->accessrecord(TBL_BTC_ADDRESS,['btc_address'],['sponsor_id'=>$id['sponsor_id']],'row');
              $address= !empty($btc->btc_address) ? $btc->btc_address : '' ;
              $status = REST_Controller::HTTP_OK;
              if(!empty($this->post('btc_address'))){
              $this->form_validation->set_rules('btc_address','Btc Address','callback_checkaddress');
              if($this->form_validation->run() == FALSE){
                $status = REST_Controller::HTTP_BAD_REQUEST;
              }else{
                    if($this->common->accessrecord(TBL_BTC_ADDRESS,[],['sponsor_id'=>$id['sponsor_id']],'row')){
                        $this->common->updateData(TBL_BTC_ADDRESS,['btc_address'=>$this->post('btc_address')],['sponsor_id'=>$id['sponsor_id']]);
                    }else{
                        $this->common->insertData(TBL_BTC_ADDRESS,['btc_address'=>$this->post('btc_address'),'sponsor_id'=>$id['sponsor_id']]);
                    }
                  $btc = $this->common->accessrecord(TBL_BTC_ADDRESS,['btc_address'],['sponsor_id'=>$id['sponsor_id']],'row');
                  $address = $btc->btc_address;
                }
              }
              $message = array(
                'status' => $status==REST_Controller::HTTP_BAD_REQUEST ? False : true,
                'message' => $msg,
                'address' => $address
              );
            
                  $this->set_response($message, $status);
            }else{
              $message = array(
                'status' => FALSE,
                'message' => 'Session Expired'
              );
                  $this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);
            }
          }
       /**======================add bank details end==========end========================== */

       /* ========================= level data =============== start==== start============ */
       function getlevelCount($ids){
        $sql = "SELECT COUNT(sponsor_id) as totalId, GROUP_CONCAT(sponsor_id) as sponsor_id FROM ". TBL_USER." WHERE refferal_by IN ($ids)";
        return $this->db->query($sql)->row();
      }
       function getuserdetails($ids){
        $sql = "SELECT (CASE WHEN ".TBL_PACKAGE.".package_amount!='' THEN ".TBL_PACKAGE.".package_amount ELSE '' END) as package_amount,".TBL_USER.".full_name,CONCAT('TP',".TBL_USER.".sponsor_id) as sponsor_id,DATE_FORMAT(".TBL_USER.".create_at,'%d-%m-%Y') as joinig_date,(CASE WHEN DATE_FORMAT(".TBL_USER.".activation_date,'%d-%m-%Y')!='' THEN DATE_FORMAT(".TBL_USER.".activation_date,'%d-%m-%Y') ELSE '' END) as activation_date,CONCAT('".BASE_URL.PROFILE_PIC."',image) as image,".TBL_USER.".status"." FROM ".TBL_USER.' LEFT JOIN '.TBL_PACKAGE." ON ".TBL_PACKAGE.'.id='.TBL_USER.".plan_id WHERE ".TBL_USER.'.sponsor_id IN('.$ids.')';
       return $this->db->query($sql)->result();
      }
        function levelData_get(){
          $token = $_SERVER['HTTP_ACCESS_TOKEN'];
          if ($id = $this->verifyToken($token)) {
            $data = $this->getlevelCount($id['sponsor_id']);
            $level= array();
            $firstLevel= '0';
            $firstData=[];

            $secondLevel='0';
            $secondData=[];

            $thiredLevel='0';
            $thiredData=[];

            $fourthLevel='0';
            $fourthData=[];

            $fifthLevel='0';
            $fifthData=[];

            $sixLevel='0';
            $sixData=[];

            $sevenLevel='0';
            $sevenData=[];

            $eightLevel='0';
            $eightData=[];

            $ninthLevel='0';
            $ninthData=[];
            
            $tenthLevel='0';
            $tenthData=[];

            $elevenLevel='0';
            $elevenData=[];

            $twelthLevel='0';
            $twelthData=[];

            $thirteenLevel='0';
            $thirteenData=[];

            $fourteenLevel=0;
            $fourteenData=[];

            $fifteenLevel='0';
            $fifteenData=[];

            $sixteenLevel='0';
            $sixteenData=[];

            $seventeenLevel='0';
            $seventeenData=[];

            $eighteenLevel='0';
            $eighteenData=[];

            $nineteenLevel='0';
            $nineteenData=[];

            $tweentyLevel='0';
            $tweentyData=[];

            $twantyoneLevel='0';
            $twantyoneData=[];
            $currentLevel = 0;
            if(!empty($data->totalId)){
              $currentLevel=1;
              $firstLevel = $data->totalId;
              $firstData= $this->getuserdetails($data->sponsor_id);
              $second = $this->getlevelCount($data->sponsor_id);
              if(!empty($second->totalId)){
                $currentLevel=2;
                $secondLevel = $second->totalId;
                $secondData=$this->getuserdetails($second->sponsor_id);
                $thired = $this->getlevelCount($second->sponsor_id);
                if(!empty($thired->totalId)){
                  $currentLevel=3;
                  $thiredLevel=$thired->totalId;
                  $thiredData = $this->getuserdetails($thired->sponsor_id);
                	$fourth = $this->getlevelCount($thired->sponsor_id);
                	if(!empty($fourth->totalId)){
                    $currentLevel=4;
                    $fourthLevel=$fourth->totalId;
                    $fourthData = $this->getuserdetails($fourth->sponsor_id);
                		$fifth = $this->getlevelCount($fourth->sponsor_id);
                		if(!empty($fifth->totalId)){
                      $currentLevel=5;
                      $fifthLevel = $fifth->totalId;
                      $fifthData= $this->getuserdetails($fifth->sponsor_id);
                			$six =  $this->getlevelCount($fifth->sponsor_id);
                			if(!empty($six->totalId)){
                        $currentLevel=6;
                        $sixLevel=$six->totalId;
                        $sixData= $this->getuserdetails($six->sponsor_id);
                				$seven= $this->getlevelCount($six->sponsor_id);
                				if(!empty($seven->totalId)){
                          $currentLevel=7;
                          $sevenLevel= $seven->totalId;
                          $sevenData = $this->getuserdetails($seven->sponsor_id);
                					$eight = $this->getlevelCount($seven->sponsor_id);
                					if(!empty($eight->totalId)){
                            $currentLevel=8;
                            $eightLevel=$eight->totalId;
                            $eightData = $this->getuserdetails($eight->sponsor_id);
                            $nine = $this->getlevelCount($eight->sponsor_id);
                            if(!empty($nine->totalId)){
                              $currentLevel=9;
                              $ninthLevel= $nine->totalId;
                              $ninthData = $this->getuserdetails($nine->sponsor_id);
                              $ten = $this->getlevelCount($nine->sponsor_id);
                              if(!empty($ten->totalId)){
                                $currentLevel=10;
                                 $tenthLevel= $ten->totalId;
                                 $tenthData = $this->getuserdetails($ten->sponsor_id);
                                 $eleven = $this->getlevelCount($ten->sponsor_id);
                                 if(!empty($eleven->totalId)){
                                  $currentLevel=11;
                                   $elevenLevel = $eleven->totalId;
                                   $elevenData = $this->getuserdetails($eleven->sponsor_id);
                                   $twelth = $this->getlevelCount($eleven->sponsor_id);
                                   if(!empty($twelth->totalId)){
                                    $currentLevel=12;
                                     $twelthLevel = $twelth->totalId;
                                     $twelthData= $this->getuserdetails($twelth->sponsor_id);
                                     $thirteen = $this->getlevelCount($twelth->sponsor_id);
                                     if(!empty($thirteen->totalId)){
                                      $currentLevel=13;
                                       $thirteenLevel= $thirteen->totalId;
                                       $thirteenData = $this->getuserdetails($thirteen->sponsor_id);
                                       $fourteen = $this->getlevelCount($thirteen->sponsor_id);
                                       if(!empty($fourteen->totalId)){
                                        $currentLevel=14;
                                         $fourteenLevel= $fifteen->totalId;
                                         $fourteenData = $this->getuserdetails($fourteen->sponsor_id);
                                         $fifteen = $this->getlevelCount($fourteen->sponsor_id);
                                         if(!empty($fifteen->totalId)){
                                          $currentLevel=15;
                                           $fifteenLevel = $fifteen->totalId;
                                           $fifteenData = $this->getuserdetails($fifteen->sponsor_id);
                                           $sixteen = $this->getlevelCount($fifteen->sponsor_id);
                                           if(!empty($sixteen->totalId)){
                                            $currentLevel=16;
                                             $sixteenLevel = $sixteen->totalId;
                                             $sixteenData = $this->getuserdetails($sixteen->sponsor_id);
                                             $seventeen = $this->getlevelCount($sixteen->sponsor_id);
                                             if(!empty($seventeen->totalId)){
                                              $currentLevel=17;
                                               $eighteenLevel= $seventeen->totalId;
                                               $eighteenData= $this->getuserdetails($seventeen->sponsor_id);
                                               $eighteen = $this->getlevelCount($seventeen->sponsor_id);
                                               if(!empty($eighteen->totalId)){
                                                $currentLevel=18;
                                                 $eighteenLevel= $eighteen->totalId;
                                                 $eighteenData= $this->getuserdetails($eighteen->sponsor_id);
                                                 $nineteen = $this->getlevelCount($eighteen->sponsor_id);
                                                 if(!empty($nineteen->totalId)){
                                                  $currentLevel=19;
                                                   $tweentyLevel= $nineteen->totalId;
                                                   $tweentyData= $this->getuserdetails($nineteen->sponsor_id);
                                                   $twenty = $this->getlevelCount($nineteen->sponsor_id);
                                                   if(!empty($twenty->totalId)){
                                                    $currentLevel=20;
                                                     $tweentyLevel= $twenty->totalId;
                                                     $tweentyData= $this->getuserdetails($twenty->sponsor_id);
                                                     $twentyone = $this->getlevelCount($twenty->sponsor_id);
                                                     if(!empty($twentyone)){
                                                      $currentLevel=21;
                                                       $twantyoneLevel = $twentyone->totalId;
                                                       $twantyoneData = $this->getuserdetails($twentyone->sponsor_id);
                                                     }
                                                   }
                                                 }
                                               }
                                             }
                                           }
                                         }
                                       }
                                     }
                                   }
                                 }
                              }
                            }
                					}
                				}
                			}
                		}
                	}
                }
              }
            }
            $level[] = array('key'=>'First Level','value'=>$firstLevel,'leveldata'=>$firstData,'level'=>1);
            $level[] = array('key'=>'Second Level','value'=>$secondLevel,'leveldata'=>$secondData,'level'=>2);
            $level[] = array('key'=>'Third Level','value'=>$thiredLevel,'leveldata'=>$thiredData,'level'=>3);
            $level[] = array('key'=>'Fourth Level','value'=>$fourthLevel,'leveldata'=>$fourthData,'level'=>4);
            $level[] = array('key'=>'Fifth Level','value'=>$fifthLevel,'leveldata'=>$fifthData,'level'=>5);
            $level[] = array('key'=>'Sixth Level','value'=>$sixLevel,'leveldata'=>$sixData,'level'=>6);
            $level[] = array('key'=>'Seventh Level','value'=>$sevenLevel,'leveldata'=>$sevenData,'level'=>7);
            $level[] = array('key'=>'Eighth Level','value'=>$eightLevel,'leveldata'=>$eightData,'level'=>8);
            $level[] = array('key'=>'Ninth Level','value'=>$ninthLevel,'leveldata'=>$ninthData,'level'=>9);
            $level[] = array('key'=>'Tenth Level','value'=>$tenthLevel,'leveldata'=>$tenthData,'level'=>10);
            $level[] = array('key'=>'Eleventh Level','value'=>$elevenLevel,'leveldata'=>$elevenData,'level'=>11);
            $level[] = array('key'=>'Twelfth Level','value'=>$twelthLevel,'leveldata'=>$twelthData,'level'=>12);
            $level[] = array('key'=>'Thirteenth Level','value'=>$thirteenLevel,'leveldata'=>$thirteenData,'level'=>13);
            $level[] = array('key'=>'Fourteenth Level','value'=>$fourteenLevel,'leveldata'=>$fourteenData,'level'=>14);
            $level[] = array('key'=>'Fifteenth Level','value'=>$fifteenLevel,'leveldata'=>$fifteenData,'level'=>15);
            $level[] = array('key'=>'Sixteenth Level','value'=>$sixteenLevel,'leveldata'=>$sixteenData,'level'=>16);
            $level[] = array('key'=>'Seventeenth Level','value'=>$seventeenLevel,'leveldata'=>$seventeenData,'level'=>17);
            $level[] = array('key'=>'Eighteenth Level','value'=>$eighteenLevel,'leveldata'=>$eighteenData,'level'=>18);
            $level[] = array('key'=>'Nineteenth Level','value'=>$nineteenLevel,'leveldata'=>$nineteenData,'level'=>19);
            $level[] = array('key'=>'Twentieth Level','value'=>$tweentyLevel,'leveldata'=>$tweentyData,'level'=>20);
            $level[] = array('key'=>'Twenty-first Level','value'=>$twantyoneLevel,'leveldata'=>$twantyoneData,'level'=>21);
            $total = $firstLevel + $secondLevel + $thiredLevel + $fourthLevel+ $fifthLevel+$sixLevel+$sevenLevel + $eightLevel + $ninthLevel + $tenthLevel + $elevenLevel + $twelthLevel + $thirteenLevel + $fifteenLevel + $sixteenLevel + $seventeenLevel + $eighteenLevel + $nineteenLevel + $tweentyLevel + $twantyoneLevel;
            $message = array(
              'status' => TRUE,
              'message' => 'Data Found',
              'current_level'=>$currentLevel,
              'total_member'=> $total,
              'data' => $level
            );
                $this->set_response($message, REST_Controller::HTTP_OK);
          }else{
              $message = array(
                'status' => FALSE,
                'message' => 'Session Expired'
              );
                  $this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);
            }
          }
        
       /* ======================= level data ==========end=======end====================== */

       function walletwithdrawal_post(){
       	$token = $_SERVER['HTTP_ACCESS_TOKEN'];
          if ($id = $this->verifyToken($token)) {
          	 $amount = $this->input->post('amount');
          	 $check = $this->common->accessrecord(TBL_USER,['wallet_amount'],['id'=>$id['id']],'row');
          	 if($check->wallet_amount >= $amount){
          	 		if($amount>=10){
	          	 			$withdrawal['sponsor_id'] = $id['sponsor_id'];
							$withdrawal['amount'] = $amount;
							$withdrawal['tds'] = 0;
							$withdrawal['admin'] = $amount*10/100;
							$withdrawal['repurchase_deducation'] = 0;
							$withdrawal['approved_money'] = $amount - $withdrawal['tds'] - $withdrawal['admin'] - $withdrawal['repurchase_deducation'];
							$withdrawal['transaction_id'] = "TD".date('YmdHis');
							$withdrawal['date'] = date('Y-m-d H:i:s');
							$this->common->insertData(TBL_WITHDRAWAL,$withdrawal);
							$this->common->setMethod(TBL_USER,'-','wallet_amount',$amount,array('sponsor_id'=>$id['sponsor_id']));
							$this->mylevel->paymentHistory($id['sponsor_id'],$amount,0,'withdrawal amount');
							$wallet_balance = $this->common->accessrecord(TBL_USER,['wallet_amount'],['id'=>$id['id']],'row');

							$message = array(
				                'status' => true,
				                'message' => 'withdrawal successfully, please wait for approval',
				                'wallet_balance' => number_format($wallet_balance->wallet_amount,2)
				              );
				                $this->set_response($message, REST_Controller::HTTP_OK);
          	 		}else{
          	 				$message = array(
				                'status' => FALSE,
				                'message' => 'Insufficient balance'
				              );
				            $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
          	 		}
          	 }else{
          	 	 $message = array(
                'status' => FALSE,
                'message' => 'Insufficient balance'
              );
              $this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);
            }
          }else{
          	$message = array(
                'status' => FALSE,
                'message' => 'Session Expired'
              );
                  $this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);
            }
          }
       /*================================ withdrawal information============start=============*/
       	function withdrawalHistory_get(){
       			$token = $_SERVER['HTTP_ACCESS_TOKEN'];
          if ($id = $this->verifyToken($token)) {
          	if($data = $this->db->query('SELECT DATE_FORMAT(date,"%Y-%m-%d") as on_date FROM '.TBL_WITHDRAWAL.' where sponsor_id='.$id['sponsor_id']." GROUP BY date ")->result()){
          				foreach($data as $row){
          					$row->history =  $this->common->accessrecord(TBL_WITHDRAWAL,['amount,approved_money,status'],['sponsor_id'=>$id['sponsor_id'],'DATE_FORMAT(date,"%Y-%m-%d")'=> $row->on_date],'result');
          					$row->on_date = date('l, d M Y',strtotime($row->on_date));
          				
          				}
          		$message = array(
                'status' => true,
                'message' => 'Data found',
                'data'=>$data
              );
              $this->set_response($message, REST_Controller::HTTP_OK);	
          	}else{
			 $message = array(
	                'status' => FALSE,
	                'message' => 'No withdrawal Record Found'
	              );
	              $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
			}
          }else{
          	$message = array(
                'status' => FALSE,
                'message' => 'Session Expired'
              );
            $this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);
          }
      }
       /* ================= end =========end====== ===========================================*/

       function testNotification_post(){
        $videoid = $this->post('video_id');
        $fcmid = $this->post('fcm_id');
        if($data = $this->common->accessrecord(TBL_FOLLOWING,['GROUP_CONCAT(followers) as ids'],['following'=>'50745399'],'row')){
          $alltoken = $this->common->wherein(TBL_USER,['GROUP_CONCAT(fcm_token) as token'],'sponsor_id',explode(',',$data->ids),'row',['fcm_token!='=>""]);
          $row[] = array('key'=>'','value'=>'row');

          $check = $this->common->accessrecordwithjoin([TBL_USER.'.full_name,'.TBL_USER.'.user_name,CONCAT("'.PREFIX.'",'.TBL_USER.'.sponsor_id) as sponsor_id,CONCAT("'.BASE_URL.PROFILE_PIC.'",'.TBL_USER.'.image) as image,CONCAT("'.BASE_URL.VIDEO_THUMBNAIL_PATH.'",'.TBL_TASKCATEGORYVIDEOS.'.thumbnail) as videoimage'],TBL_USER,TBL_TASKCATEGORYVIDEOS,[TBL_USER.'.sponsor_id',TBL_TASKCATEGORYVIDEOS.'.customer_id'],[TBL_TASKCATEGORYVIDEOS.'.ID'=>$videoid],'inner',$row);
          if(!empty($alltoken)){
              $title = " ".$check->full_name;
              $username = !empty($check->user_name) ? $check->user_name : PREFIX.$check->sponsor_id;
              $notification = [
                "title" => $title."(".$username.")",
                "body" => " has uploaded new video",
                "icon" => $check->videoimage,
                "icon1" => $check->image,
                "sound" => true,
                "video_id" =>$videoid,
                "sponsor_id" => "90096620",
                "action_type" => "0",
                "click_action" => "action link"

            ];
              $fcmNotification = [
                'registration_ids' =>[$fcmid], //multple token array
                'data'=> $notification
              ];

              fcmmsg($fcmNotification);
              $this->set_response($fcmNotification, REST_Controller::HTTP_OK);	
          }
        }
          // $result = fcmmsg($fcmNotification);
        
          // $this->set_response($fcmNotification, REST_Controller::HTTP_OK);	
       }
        

       /* ================== for only mp4========================================== start======================== */
       public function mp4video_post()
       {
        $username1 = $this->input->post('username');
        $category_id = $this->input->post('category_id');
        // $category_id = $this->input->post('category_id');
        $last_record_count=$this->input->post('last_record_count');
        if(!empty($category_id)){
          $caties = $this->common->accessrecord(TBL_TASKCATEGORYVIDEOS, [], ['category_id'=>$category_id], 'result');
          asort($caties);
        }else{
          //$caties = $this->common->accessrecord(TBL_TASKCATEGORYVIDEOS, [], [],'result','asc');
          $caties = $this->common->accessrecord('mp4video',[],[],'result');
          // $categories = $this->api->accessrecord(TBL_TASKCATEGORYVIDEOS, [], [], 'ID','desc', 15, 'result');
        }

        if(!empty($caties)){
         
          $page = (int)$last_record_count;
          $per_page = 100;
          $total_rows = count($caties);
          $total_page = ceil($total_rows / $per_page);

         if(empty($last_record_count)){
            $categories = array_slice($caties,0,100);

         }else{
          $last_record_count=(int)$last_record_count*$per_page;
            $categories = array_slice($caties, $last_record_count, 100);

         }
         
          foreach ($categories as $catkey => $catval) {

            $categories[$catkey]->date =$this->api->duration($catval->date);
            $isfollow = $this->common->accessrecord('tblfollowing', [], ['following'=>$catval->customer_id,'followers'=>$username1,'status'=>1], 'row');
            if (!empty($isfollow)) {
              $categories[$catkey]->myfollow =(string)1;
            }else{
              $categories[$catkey]->myfollow =(string)0;
            }
            if($catval->customer_id==$username1){
              $categories[$catkey]->myfollow =(string)1;
            }
            // ***********************
            $username = $this->common->accessrecord(TBL_USER, [], ['sponsor_id'=>$catval->customer_id], 'row');
            if(!empty($username)){
              $categories[$catkey]->post_by = !empty($username->user_name) ? $username->user_name : (!empty($username->full_name) ? $username->full_name : 'Unknown');
              $categories[$catkey]->user_type = !empty($username->user_type) ? $username->user_type : '';
              $categories[$catkey]->user_image =BASE_URL.PROFILE_PIC.$username->image; 
              if(!empty($catval->thumbnail)){
                //$categories[$catkey]->thumbnail = base_url('uploads/images/video-thumbnail/'.$catval->thumbnail);
                $categories[$catkey]->thumbnail =  BASE_URL.VIDEO_THUMBNAIL_PATH.$catval->thumbnail;
              }else{
                $categories[$catkey]->thumbnail = base_url('uploads/images/video-thumbnail/valentine2.jpg');
              }
              //$categories[$catkey]->path = base_url('uploads/'.$catval->path);
              $filename = pathinfo($catval->path, PATHINFO_FILENAME);
              $categories[$catkey]->path = VIDEO_PATH."MP4_".$catval->customer_id."/".$filename."/".$filename.".mp4";
              // $categories[$catkey]->path =  'https://tip-top-video-aws-video-transcoder.s3.ap-south-1.amazonaws.com/DIR_35405605/output-filtered-DIWpht4zsYmNDIT/output-filtered-DIWpht4zsYmNDIT.m3u8';
              $categories[$catkey]->audio_video_path = array('mp4'=>"",
                    'mp3'=>"",
                    'aac'=>@file_get_contents(BASE_URL.AAC.$catval->customer_id."/".$filename.".aac") ? BASE_URL.AAC.$catval->customer_id."/".$filename.".aac"  : VIDEO_PATH."DIR_".$catval->customer_id."/".$filename."/".$filename."aac_00001.aac",
                    "song_name" => !empty($username->user_name) ? "original song - ".$username->user_name . " - ". $username->full_name : " original sound -". $username->full_name
                  ); 
              if (!empty($catval->ID)) {
                // $like_count = $this->api->totallikecount($catval->ID);
                $resuser1 = $this->common->accessrecord('likeunlike', [],['video_id'=>$catval->ID, 'likes'=>1], 'result');
                if (!empty($resuser1)) {
                  $categories[$catkey]->like_count = (string)count($resuser1);
                  foreach ($resuser1 as $likebkey => $likebval) {
                    if ($likebval->username==trim($username1)) {
                      $categories[$catkey]->likeed = 1;
                    }else{
                      $categories[$catkey]->likeed = 0;
                    }
                  }
                }else{
                  $categories[$catkey]->like_count = (string)0;
                  $categories[$catkey]->likeed = 0;
                }


                $commentlist = $this->common->commentlist('comments', $catval->ID);
                if (!empty($commentlist)) {
                  $categories[$catkey]->comment_count = (string)count($commentlist);
                  $categories[$catkey]->comment_list = $commentlist;
                }else{
                  $categories[$catkey]->comment_count = (string)0;
                  $categories[$catkey]->comment_list = [];
                }
              }
            }
          }
       
          // $datas['videos_list'] = $categories;
          $message = array(
             'status'  => TRUE,
             'message' => 'Data fetch successfully!!',
             'page' => $page,
             'per_page' => $per_page,
             'total' => $total_rows,
             'total_pages' => $total_page,
             'data'    => $categories
          );


          $this->set_response($message, REST_Controller::HTTP_OK);
        }else {
            $message = array(
               'status' => FALSE,
               'message' => 'Data not found!!'
            );
           $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
        }
   }
     /* ===================end================end=========================end================================== */

     /* ====================== category==================== start========================== */
      function category_get(){
        $token = $_SERVER['HTTP_ACCESS_TOKEN'];
          if ($id = $this->verifyToken($token)) {
            $data = $this->common->accessrecord(TBL_CATEGORY,['CONCAT("'.BASE_URL.MUSIC_ICON.'thumb/'.'",icon) as image, name, id'],[],'result','asc');
                foreach($data as $row){
                  
                  $row->sub = $this->common->accessrecord(TBL_CATEGORY_MUSIC,['CONCAT("'.MUSIC_VIDEO.$row->name.'/",music) as song,CONCAT("'.BASE_URL.MUSIC_ICON.$row->name."/thumb/".'",image) as thumbnail, artist,song_name,id'],['category_id'=>$row->id],'result');
                  foreach($row->sub as $ro){
                    $ro->is_fevorites=0;
                    if($this->common->accessrecord(TBL_USER_FEVORATES,[],['song_id'=>$ro->id],'row')){
                      $ro->is_fevorites=1;
                    }
                  }
                }
            $fovorates = $this->common->accessrecordwithjoin(['CONCAT("'.BASE_URL.CATE_MUSIC.'",'.TBL_CATEGORY_MUSIC.'.music) as song,CONCAT("'.BASE_URL.MUSIC_THUMBNAIL.'",'.TBL_CATEGORY_MUSIC.'.image) as thumbnail, '.TBL_CATEGORY_MUSIC.'.artist,'.TBL_CATEGORY_MUSIC.'.song_name'],TBL_USER_FEVORATES,TBL_CATEGORY_MUSIC,[TBL_USER_FEVORATES.'.song_id',TBL_CATEGORY_MUSIC.'.id'],[TBL_USER_FEVORATES.'.sponsor_id'=>$id['sponsor_id']],'inner',[]);
           
            $fetured = $this->common->accessrecord(TBL_CATEGORY_MUSIC,['CONCAT("'.BASE_URL.CATE_MUSIC.'",music) as song,CONCAT("'.BASE_URL.MUSIC_THUMBNAIL.'",image) as thumbnail, artist,song_name'],[],'result');
            foreach($fetured as $row){
              $row->song = 'http://13.127.44.203/assets/music/aac/90096620/output-filtered-ZmAPdUYRF2jWEYi.aac';
            }
            $array = array('category'=>$data,'featured'=>[],'favorites'=>$fovorates);
            $message = array(
              'status' => true,
              'message' => 'Category Found',
              'data' => $array
          );
          $this->set_response($message, REST_Controller::HTTP_OK);
        }else{
          $message = array(
            'status' => FALSE,
            'message' => 'Session expired'
         );
        $this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);
        }
      }
     /* ===========================category========end============end===================== */

   
    }