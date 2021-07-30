<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Restserver\Libraries\REST_Controller;
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';
require_once('vendor/autoload.php');
require_once('application/libraries/S3.php');
class Videoupload extends REST_Controller
{

    function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('S3_upload');
        $this->load->library('S3');
        $this->config->load('s3', TRUE);
        $this->load->model('Api_model', 'api');
        $s3_config = $this->config->item('s3');
        $this->bucket_name = $s3_config['bucket_name'];
        $this->video_image_path = $s3_config['image_path'];
        $this->video_path = $s3_config['video_path'];
        $this->s3_url = $s3_config['s3_url'];
    }

    public function addImages($id='')
    {       
        $filesCount = count($_FILES['files']['name']);
            for($i = 0; $i < $filesCount; $i++){
                $_FILES['file']['name']     = $_FILES['files']['name'][$i];
                $_FILES['file']['type']     = $_FILES['files']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
                $_FILES['file']['error']    = $_FILES['files']['error'][$i];
                $_FILES['file']['size']     = $_FILES['files']['size'][$i];

                $dir = dirname($_FILES["file"]["tmp_name"]);
                $destination = $dir . DIRECTORY_SEPARATOR . $_FILES["file"]["name"];
                rename($_FILES["file"]["tmp_name"], $destination);
                $upload = $this->s3_upload->upload_file($destination); 
                           
            }     
    }
    private function verifyToken($token)
    {
      if ($record = $this->common->accessrecord(TBL_USER, ['id,sponsor_id,access_token,plan_id'],['access_token'=>$token], 'row')) {
          if (!empty($record)) {
             return array('id'=>$record->id,'sponsor_id'=>$record->sponsor_id,'token'=>$record->access_token,'plan_id'=>!empty($record->plan_id) ? $record->plan_id : '');
          }
      } else {
          return FALSE;
      }
    }
     /* ======================package benifit ============================ 27 March 2020======== */
     private function getpackageBenifit($id){
        $data = $this->common->accessrecord(TBL_PACKAGE,[],['id'=>$id],'row');
        if($data){
          return (object) array('upload_amount'=>$data->upload_amount_doller,'share_like_amount'=>$data->per_share_like_dollor,'share_count'=>$data->share_count,'like_count'=>$data->like_count,'upload_count'=>$data->video_upload);
        }
      }
    /* ==================package benifit end=========== 27 March 2020 ========================= */
  
    public function add_video_post() {
        $token = $_SERVER['HTTP_ACCESS_TOKEN'];
          if ($id = $this->verifyToken($token)) { 
          $plan_id = $this->input->post('plan_id');
          $username = $this->input->post('username');
          $description = $this->input->post('description');
          if(!empty($_FILES['video']['name'])&&!empty($username)) {
           date_default_timezone_set('Asia/Kolkata');
            $insdata['date'] = date('Y-m-d H:i:s');
            $insdata['customer_id'] = $username;
            $insdata['description'] = $description;
            $insdata['plan_id'] = $plan_id;
            $isTrue=1;

                $_FILES['file']['name']     = $_FILES['video']['name'];
                $_FILES['file']['type']     = $_FILES['video']['type'];
                $_FILES['file']['tmp_name'] = $_FILES['video']['tmp_name'];
                $_FILES['file']['error']    = $_FILES['video']['error'];
                $_FILES['file']['size']     = $_FILES['video']['size'];

                $dir = dirname($_FILES["video"]["tmp_name"]);
                $destination = $dir . DIRECTORY_SEPARATOR . $_FILES["video"]["name"];
                rename($_FILES["file"]["tmp_name"], $destination);
                $upload = $this->s3_upload->upload_file($destination); 
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
              if(!empty($inst)){
                $currentDate = date('Y-m-d');
                $totalUpload = $this->common->accessrecord(TBL_TASKCATEGORYVIDEOS,['COUNT(id) as total'],['date_format(date,"%Y-%m-%d")'=>$currentDate,'plan_id'=>$plan_id],'row')->total;
                $data = $this->getpackageBenifit($plan_id);
                  if(!empty($data) && ($data->upload_count>=$totalUpload)){
                    $uploadIncome['income'] = $data->upload_amount;
                    $uploadIncome['sponsor_id'] = $username;
                    $uploadIncome['plan_id'] = $plan_id;
                    $uploadIncome['video_id'] =  $inst;
                    $this->common->insertData(TBL_VIDEO_INCOME,$uploadIncome);
                    $this->common->setMethod(TBL_USER,"+",'wallet_amount',$data->upload_amount,['sponsor_id'=>$username]);
                    $this->common->setMethod(TBL_USER,"+",'total_amount',$data->upload_amount,['sponsor_id'=>$username]);
                    $this->paymentHistory($username,$data->upload_amount,1,'Upload a video');
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
   
    function base64_to_jpeg($image) {
        $filename = md5(date('Y-m-d H:i:s')).".png";
        $binary = base64_decode($image);
        $file = VIDEO_THUMBNAIL_PATH.$filename;
        //$this->s3_upload->upload_baseImage($file);
        file_put_contents($file,$binary);
        return $filename; 
      }
      public function testingvideo_post()
       {
            $username1 = $this->input->post('username');
            $category_id = $this->input->post('category_id');
            // $category_id = $this->input->post('category_id');
            $last_record_count=$this->input->post('last_record_count');
            if(!empty($category_id)){
              $categories = $this->common->accessrecord(TBL_TASKCATEGORYVIDEOS, [], ['category_id'=>$category_id], 'result');
            }else{
              $categories = $this->common->accessrecord(TBL_TASKCATEGORYVIDEOS, [], [],'result');
              // $categories = $this->api->accessrecord(TBL_TASKCATEGORYVIDEOS, [], [], 'ID','desc', 15, 'result');
            }

            if(!empty($categories)){
             
              $page = 0;
              $per_page = 0;
              $total_rows = 0;
              $total_page = 0;

            //  if(empty($last_record_count)){
            //     $categories = array_slice($caties,0,5);

            //  }else{
            //   $last_record_count=(int)$last_record_count*$per_page;
            //     $categories = array_slice($caties, $last_record_count, 5);

            //  }
             
              foreach ($categories as $catkey => $catval) {

                // ***********************
                  $categories[$catkey]->date =$this->api->duration($catval->date);


                // ***********************
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
                if (!empty($username->full_name)) {
                  $categories[$catkey]->post_by = $username->full_name;
                }else{
                  $categories[$catkey]->post_by = '';
                }
                 if (!empty($username->user_type)) {
                  $categories[$catkey]->user_type = $username->user_type;
                }else{
                  $categories[$catkey]->user_type = '';
                }



                if(!empty($username->image)){
                 // $categories[$catkey]->user_image =base_url('uploads/'.$username->imageurl); 
                  $categories[$catkey]->user_image =BASE_URL.PROFILE_PIC.$username->image; 

                }else{
                  $categories[$catkey]->user_image =base_url('uploads/images/default.png'); 
                }
                if(!empty($catval->thumbnail)){
                  //$categories[$catkey]->thumbnail = base_url('uploads/images/video-thumbnail/'.$catval->thumbnail);
                  $categories[$catkey]->thumbnail =  BASE_URL.VIDEO_THUMBNAIL_PATH.$catval->thumbnail;
                }else{
                  $categories[$catkey]->thumbnail = base_url('uploads/images/video-thumbnail/valentine2.jpg');
                }
                //$categories[$catkey]->path = base_url('uploads/'.$catval->path);
                $categories[$catkey]->path =  VIDEO_PATH.$catval->path;
             
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


       function notification(){
        $deviceid = $this->post('fcm_id');
        $videoid = $this->post('video_id');
        $notification = [
          "title" => "Sudheer shrivastava(sud007)",
          "body" => "has uploaded new video",
          "icon" => 'https://www.pngfind.com/pngs/m/546-5460875_globe-png-transparent-world-globe-transparent-png-download.png',
          "icon1" => "https://www.pinclipart.com/picdir/middle/372-3725108_user-profile-avatar-scalable-vector-graphics-icon-woman.png",
          "sound" => true,
          "video_id"=>$videoid,
          "click_action" => "action link"

      ];
        $fcmNotification = [
          'registration_ids' =>  [$deviceid], //multple token array
          //'to'        => $deviceid, //single token
          'data'=> $notification
        ];
     

       $result = fcmmsg($fcmNotification);
        
       $this->set_response($fcmNotification, REST_Controller::HTTP_OK);	
}
}