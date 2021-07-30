<?php defined('BASEPATH') OR exit('No direct script access allowed');
//date_default_timezone_set('Asia/Kolkata');

class Api_model extends CI_Model

	{

		function __construct(){
			parent::__construct();
			ob_start();
			date_default_timezone_set('Asia/Kolkata');
		}

		public function insert($tbl,$fields)
		{
			$this->db->insert($tbl,$fields);
			return $this->db->insert_id();
		}

		

		public function login($tbl='', $fields='',  $email='', $password='',  $result='')

		{
			
			$this->db->select(implode(',', $fields));
			if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
			    $this->db->where('email', $email);
			    $this->db->where('password', $password);
			   	return	$res = $this->db->get($tbl)->row();
			} else if(strlen((string)$email)==10){
			   	$this->db->where('mobile', $email);
				$this->db->where('password', $password);
			   return	$res = $this->db->get($tbl)->row();
			}else{
				return 'invalid';
			}
			

		}





		public function accesssinglerow_login($tbl='', $fields='',  $where='', $where1='', $where2='', $result='')

		{
			$this->db->select(implode(',', $fields));
			if (!empty($where['email'])) {
				$this->db->where($where);
			}else if (!empty($where1)) {
				$this->db->where($where1);
			}
			$this->db->where($where2);
			if ($result=='row') {
				$res = $this->db->get($tbl)->row();
			}else{
				$res = $this->db->get($tbl)->result();
			}
			return $res;
		}

	

		public function updateRecord($tbl='', $fields='',  $where=''){
			return $this->db->where($where)->update($tbl, $fields);
		}
		
		function accessrecord($tbl='', $fields='', $where='',  $orderby='',  $ordertype='', $limit='', $result=''){
		    $this->db->select(implode(',', $fields));
		    if(!empty($where)){
		    	$this->db->where($where);
		    }
		    if(!empty($orderby)){
		    	$this->db->order_by($orderby, $ordertype);
		    }
		    if(!empty($limit)){
		    	$this->db->limit($limit, 0);
		    }
			if ($result=='row') {
				$res = $this->db->get($tbl)->row();
			}else{
				$res = $this->db->get($tbl)->result();
			}
			
			return $res;
		}
		
		public function check($tbl='', $fields='', $where='', $result)
		{
			$this->db->select(implode($fields));
			$this->db->where($where);
			if ($result=='row') {
				$res = $this->db->get($tbl)->row();
			}else{
				$res = $this->db->get($tbl)->result();
			}
			return $res;
		}

		//*****************************Like*********************************************************
		public function checklike($tbl='', $where='', $restype='')
		{
			$this->db->where($where);
			if ($restype=='row') {
				return $this->db->get($tbl)->row(); 
			}else{
				return $this->db->get($tbl)->result(); 
			}
		}

		public function insertlike($tbl='', $data=''){
			$this->db->insert($tbl, $data);
			$insert_id = $this->db->insert_id();
			if (!empty($insert_id)) {
				$likes = $this->db->where('video_id', $data['video_id'])->count_all_results($tbl);
			}
			return $likes;
		}



		public function followinsertlike($tbl='', $data=''){
			$this->db->insert($tbl, $data);
			$insert_id = $this->db->insert_id();
			
			return ;
		}


		public function totallikecount($video_id='')
		{
			return $this->db->select('username, likes')->where('video_id', $video_id)->order_by("id", "DESC")->limit(1)->get('likeunlike')->row();
			
		}

		
		//*****************************Comment list *********************************************************

		public function insert_with_backresult($tbl='', $fields='')
		{
			$mcomm = array();
			$this->db->insert($tbl, $fields);
			$insert_id = $this->db->insert_id();
			if (!empty($insert_id)) {
				$comments = $this->db->where('video_id', $fields['video_id'])->get($tbl)->result();
				if (!empty($comments)) {
					foreach ($comments as $ckey => $cval) {
						$userd = $this->db->select('sponsor_id as ID, full_name as name,  image')->where('sponsor_id', $cval->username)->get(TBL_USER)->row();
						if (!empty($userd)) {
							$comments[$ckey]->user_ID = $userd->ID;
							$comments[$ckey]->name = $userd->name;
							$comments[$ckey]->username = PREFIX.$userd->ID;
							$comments[$ckey]->com_date = date('d-m-Y', strtotime($cval->created));
							$comments[$ckey]->com_user_image = BASE_URL.PROFILE_PIC.$userd->image;
						}
						unset($cval->created);
					}
				}
			}
			return $comments; 
		}

		public function commentlist($tbl='', $vid='')
		{
			$comments = $this->db->where('video_id', $vid)->get($tbl)->result();
			if (!empty($comments)) {
				foreach ($comments as $ckey => $cval) {
					$userd = $this->db->select('sponsor_id as ID, full_name as name, image')->where('sponsor_id', $cval->username)->get(TBL_USER)->row();
					if (!empty($userd)) {
						$comments[$ckey]->user_ID = $userd->ID;
						$comments[$ckey]->name = $userd->name;
						$comments[$ckey]->username = $userd->ID;
						$comments[$ckey]->com_date = date('d-m-Y', strtotime($cval->created));
						$comments[$ckey]->com_user_image = BASE_URL.PROFILE_PIC.$userd->image;
						
					}
					unset($cval->created);
				}
			}
			return $comments;
		}
		//*****************************END Comment list *********************************************************
		
		
		public function mylikevideobyme($tbl='', $where='', $acc='', $type='', $restype='')
		{
			$this->db->where($where);
			if ($restype=='row') {
				$this->db->order_by($acc, $type);
				return $this->db->get($tbl)->row(); 
			}else{
				$this->db->order_by($acc, $type);
				return $this->db->get($tbl)->result(); 
			}
		}
		public function searchuser($user_title)
        {
     	
			 $query = $this->db->query("select id,username,name,imageurl FROM `userlist` WHERE `username` LIKE '$user_title%' OR `name` LIKE '$user_title%'");

			 $data = $query->result();
			  return $data;
        } 

        public function usertransaction(){
        	
        }
		
		 public function delrecord($tbl='',   $where='')
        {
        	$this->db->delete($tbl, $where);
        	if (!$this->db->affected_rows()) {
			    $result = "Error! ID -> ".$where['ID']. " not found";
			} else {
			    $result = 'Record successfully deleted';
			}
			return $result;
        }
        public function checkDayLimit($username,$daylimit){
        	
                    $current_date=date('d-M-Y');
                    //$current_date=date('02-Feb-2020');
                	$this->db->select('*')->from('transaction');
					$this->db->like('date',$current_date);
					$this->db->where('username',$username);
					$this->db->where('remark','WITHDRAWAL REQUEST');
					

					
					

			        $daylimitss=$this->db->get()->result();
			       
			        if(!empty($daylimit)){
			        
			        	$daylm=0;
			        	foreach ($daylimitss as $k => $val) {
			        		$daylm=$daylm+$val->amount;
			        	}
			        	
			        	if($daylm < $daylimit && $daylm!=$daylimit){
                         return 'true'; 
			        	}else{
			        	  $msg='Your Daily withdrawal limit is over';
                         return $msg;
                        
                         
			        	}
			        }else{
			        	return 'true';	
			        }
        } 
        public function checkMonthLimit($username,$monthlimit){
            // $tra_history=$this->accessrecord('transaction',[],array('username'=>$username,'remark'=>'WITHDRAWAL REQUEST'),'id','Desc','','result');
            $select_month=date('M');
            //$username='user';
            //$select_month='Jan';
            $this->db->select('*')->from('transaction');
			$this->db->like('date',$select_month);
			$this->db->where('username',$username);
			$this->db->where('remark','WITHDRAWAL REQUEST');
			$tra_history=$this->db->get()->result();
			$monthsum=0;
			if(!empty($tra_history)){
                foreach ($tra_history as $key => $value) {
                	$monthsum=$monthsum+$value->amount;
                }
                //if($monthsum<$monthlimit){
                if($monthsum < $monthlimit && $monthsum!=$monthlimit){	
                		
                		return 'true';
                }else{
                    $msg='Your Monthly withdrawal limit is over';
                	return $msg;
                	/*$current_date=date('Y-M-d');
                	$this->db->select('*')->from('transaction');
					$this->db->like('date',$current_date);
					$this->db->where('username',$username);
			        $daylimit=$this->db->get()->result();
			        if(!empty($daylimit)){
			        	$daylm=0;
			        	foreach ($daylimit as $k => $val) {
			        		$daylm=$daylm+$val->amount;
			        	}
			        	if($daylm>=$daylimit){
                         $msg='Your Daily withdrawal limit is over';
                         return $msg;
			        	}else{
			        	  return 'true';	
			        	}
			        }else{
			        	return 'true';	
			        }*/
                	//return 1;
                	
                }
			}else{
				return 'true';	
			}
			//echo $this->db->last_query();
			//print_r($qry);


           // echo '<pre>';print_r($tra_history);die;

        }

        public function duration($created_date){
    	date_default_timezone_set('Asia/Kolkata'); //India time (GMT+5:30)
           
            $date1 = strtotime($created_date);  
            $date= date('Y-m-d h:i:s');
            $date2 = strtotime($date);
            $diff = abs($date2 - $date1);  
            $years = floor($diff / (365*60*60*24));
            $months = floor(($diff - $years * 365*60*60*24) 
                                           / (30*60*60*24));
            $days = floor(($diff - $years * 365*60*60*24 -  
                         $months*30*60*60*24)/ (60*60*24)); 
            $hours = floor(($diff - $years * 365*60*60*24  
                   - $months*30*60*60*24 - $days*60*60*24) 
                                               / (60*60));  
            $minutes = floor(($diff - $years * 365*60*60*24  
                     - $months*30*60*60*24 - $days*60*60*24  
                                      - $hours*60*60)/ 60); 
            $seconds = floor(($diff - $years * 365*60*60*24  
                     - $months*30*60*60*24 - $days*60*60*24 
                            - $hours*60*60 - $minutes*60)); 

            if ($years != 0) {
                $ago = $years." year ago";
            }elseif($months != 0) {
               $ago = $months." month ago";
            }elseif($days != 0 ) {
               $ago = $days." day ago";
            }elseif($hours != 0 ) {
                $ago = $hours." hour ago";
            }elseif($minutes != 0 ) {
                $ago = $minutes." minute ago";
            }elseif($seconds != 0 ) {
                $ago = $seconds." seconds ago";
            }
            if(!empty($ago)){
            return $ago;

        }else{
        	return 'Just Now';
        }

    }
		
		
		




	}