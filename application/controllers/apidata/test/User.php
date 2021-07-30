<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    use Restserver\Libraries\REST_Controller;
    require APPPATH . 'libraries/REST_Controller.php';
    require APPPATH . 'libraries/Format.php';
    class User extends REST_Controller { 
      public $z=1;
      public $i=0;
    
        function __construct()
        {
            parent::__construct();
           
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
        /* ======================== function user fevorites ====================== start============ */

            function UserFevorites_post(){
                $token = $_SERVER['HTTP_ACCESS_TOKEN'];
                $songid = $this->post('song_id');
                if ($id = $this->verifyToken($token)) {

                    if($check = $this->common->accessrecord(TBL_USER_FEVORATES,[],['song_id'=>$songid,'sponsor_id'=>$id['sponsor_id']],'row')){
                        $status = $check->status==0 ? 1 : 0 ;
                        $this->common->updateData(TBL_USER_FEVORATES,['status'=>$status],['song_id'=>$songid,'sponsor_id'=>$id['sponsor_id']]);
                        $msg = $check->status==1 ? "Song Removed From fevorites list" : "Fevorites Set";
                    }else{
                        $insert['sponsor_id'] = $id['sponsor_id'];
                        $insert['song_id'] = $songid;
                        $insert['status'] = 1;
                        $this->common->insertData(TBL_USER_FEVORATES,$insert);
                        $msg = "Fevorites Set";
                    }
                    
                      $message = array(
                        'status' => true,
                        'message' => $msg
                      );
                      $this->set_response($message, REST_Controller::HTTP_OK);
                }else{
                   $message = array(
                      'status' => FALSE,
                      'message' => 'Session Expired, Please login again...'
                    );
                    $this->set_response($message, REST_Controller::HTTP_UNAUTHORIZED);
                }
            }

        /* ======================= function user fevorites ================= end======end===========*/
        /* ========================= dicover =======================================================*/
        	function discover_post(){
        			$keyword = $this->post('keyword');
        			if(!empty($keyword)){
        				if(strtoupper(substr($keyword,0,PRE_COUNT))==PREFIX) {
        					$keyword = substr($keyword,PRE_COUNT);
        				}
        				$data = $this->db->query('SELECT CONCAT("'.PREFIX.'",sponsor_id) as member_id , (CASE WHEN user_name IS NULL THEN full_name ELSE user_name END) as user_name , full_name as name,CONCAT("'.BASE_URL.PROFILE_PIC.'",image) as userimage, "0" as totalpost FROM '. TBL_USER. ' WHERE sponsor_id LIKE "%'.$keyword.'%" OR user_name LIKE "%'.$keyword.'%" OR full_name LIKE "%'.$keyword.'%"')->result();		
        			}else{
        				$array[] = array('key'=>' GROUP BY '.TBL_TASKCATEGORYVIDEOS.'.customer_id','value'=>' ORDER BY totalpost DESC LIMIT 50');
        				$data = $this->common->accessrecordwithjoin(['CONCAT("'.PREFIX.'",'.TBL_USER.'.sponsor_id) as member_id, ( CASE WHEN '.TBL_USER.'.user_name IS NULL THEN '.TBL_USER.'.full_name ELSE '.TBL_USER.'.user_name END) as user_name,'.TBL_USER.'.full_name as name,CONCAT("'.BASE_URL.PROFILE_PIC.'",'.TBL_USER.'.image) as userimage,COUNT('.TBL_TASKCATEGORYVIDEOS.'.id) as totalpost'],TBL_USER,TBL_TASKCATEGORYVIDEOS,[TBL_TASKCATEGORYVIDEOS.'.customer_id',TBL_USER.'.sponsor_id'],[],'inner',$array);
        			
        			}

        			if(!empty($data)){
        				 $message = array(
	                        'status' => true,
	                        'message' => 'Data found',
	                        'data' => $data
	                      );
	                      $this->set_response($message, REST_Controller::HTTP_OK);
        			}else{
        				  $message = array(
	                        'status' => FALSE,
	                        'message' => 'Data not found'
	                      );
	                      $this->set_response($message, REST_Controller::HTTP_BAD_REQUEST);
        			}
        	}
        /* ============================ end discove=================================================*/
       
    }