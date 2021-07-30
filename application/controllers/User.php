<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->library('paypal_lib');
		if(empty(userid())){
			redirect('signin');
		}
	}
	function test(){
		$this->data['page'] = 'test';
		$this->data['content'] = 'dashboard/test';
		$this->load->view('user/template',$this->data);
	}
	function index(){
		$spo = $this->data['profile'] = $this->common->accessrecord(TBL_USER,[],['id'=>userid()],'row');
		$this->data['sponsor'] = $this->common->accessrecord(TBL_USER,[],['sponsor_id'=>$spo->refferal_by],'row');
		$this->data['news'] = $this->common->accessrecord(TBL_NEWS,[],['status'=>1],'row');
		$this->data['kyc'] = $this->common->accessrecord(TBL_KYC,[],['sponsor_id'=>sponsor()],'result');
		$this->data['bank'] = $this->common->accessrecord(TBL_BANK_INFO,['bank_status'],['user_id'=>userid()],'row');
		$this->data['income'] = $this->common->accessrecord(TBL_VIDEO_INCOME,[],['sponsor_id'=>sponsor()],'result');
		asort($this->data['income']);
		$this->data['page'] = 'index';
		$this->data['content'] = 'dashboard/index';
		$this->load->view('user/template',$this->data);
	}
	function profile(){
		$this->form_validation->set_rules('full_name','Full Name','trim|xss_clean|required');
		if($this->form_validation->run() == FALSE){
		}else{
			$isTrue=1;
			if(!empty($_FILES['image']['name'])){
				$image = uploadimage('image',PROFILE_PIC);
				if($image){
					$data['image'] = $image;
				}else{
					$isTrue=0;
				}
			}
			if($isTrue==1){
				$data['full_name'] = $this->input->post('full_name');
				$this->common->updateData(TBL_USER,$data,['id'=>userid()]);
				$this->session->set_flashdata('heading','Profile Upated');
				$this->session->set_flashdata('success','Profile successfully updated');
			}else{
				$this->session->set_flashdata('heading','Image Error');
				$this->session->set_flashdata('error','Image not uploade, please choose proper format');
			}
		}
		$this->data['profile'] = $this->common->accessrecord(TBL_USER,[],['id'=>userid()],'row');
		$this->data['page'] = 'profile';
		$this->data['content'] = 'profile/profile';
		$this->load->view('user/template',$this->data);
	}
	function emailupdate(){
	 
		$this->form_validation->set_rules('email','Email','required|valid_email');
		if($this->form_validation->run() == FALSE){
			$array['error'] = array('email'=>form_error('email'));
		}else{
			extract($_POST);
			$getEmail = $this->common->accessrecord(TBL_USER,['email'],['id'=>userid()],'row');
			if($getEmail->email==$email){
				$array['wrong'] = array('msg'=>'Already updated','success'=>0);
			}elseif(!$this->common->accessrecord(TBL_USER,['email'],['email'=>$email],'row')){
				$this->common->updateData(TBL_USER,['email'=>$email],['id'=>userid()]);
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
				if($this->common->accessrecord(TBL_USER,['id'],['id'=>userid(),'password'=>sha1($old)],'row')){
					$this->common->updateData(TBL_USER,['password'=>sha1($new_password)],['id'=>userid()]);
					$array['wrong'] = array('msg'=>'Password Upated Successfully','success'=>1);
				}else{
					$array['wrong'] = array('msg'=>'Old Password Not Matched','success'=>0);
				}
				
		}
		echo json_encode($array);
	}
	function bankinfo(){
		//$this->session->unset_userdata('OTP');
		   $bankdata = [];
			if(!empty($_POST) && (!empty($_POST['bank']))) {
				unset($_POST['bank']);
				//$bankdata=$_POST;
				// if(empty($this->session->userdata('OTP'))){
    			// 	$rand = rand(100000,999999);
    			// 	$message = "Your one time password is ". $rand;
    			// 	$this->session->set_userdata('OTP',$rand);
    			// 	message(urlencode($message),Tree::mobilenumber());
    			// 	$this->session->set_flashdata('checkOTP','1');
				// }
				// if(empty($this->input->post('otp'))){
				// 	$this->session->set_flashdata('heading','OTP Sent');
				// 	$this->session->set_flashdata('error','OTP send in your mobile number');
				// }
				//else if($this->input->post('otp')==$this->session->userdata('OTP')){
					unset($_POST['otp']);
					$data=$_POST;
					$isTrue=1;
					$this->session->unset_userdata('OTP');
					if(!empty($_FILES['image']['name'])){
						$image = uploadimage('image',BANK_IMAGE);
						if($image){
							$data['image'] = $image;
						}else{
							$isTrue=0;
						}
					}
					if($isTrue==1){
						$this->bankmethod($data,'bank_count');
					$this->session->set_flashdata('heading','Bank Details updated');
					$this->session->set_flashdata('success','Bank Detail successfully saved');
					}else{
						$this->session->set_flashdata('heading','Image format error');
					$this->session->set_flashdata('error','Image format not valid please choose proper format');
					}
					
					$this->session->set_flashdata('checkOTP','0');
					
				// }else{
				// 	$this->session->set_flashdata('heading','OTP Error');
				// 	$this->session->set_flashdata('error','Invalid OTP please enter correct OTP');
				// 	$this->session->set_flashdata('checkOTP','1');
				// }
			}elseif(!empty($_POST) && (!empty($_POST['upi']))) {
				unset($_POST['upi']);
				 $data = $_POST;
				 $this->bankmethod($data,'upi_count');
				 $this->session->set_flashdata('heading','Upi Information');
				 $this->session->set_flashdata('success','Bank Detail successfully saved');    
			}elseif(!empty($_POST) && (!empty($_POST['phonepe']))){
				unset($_POST['phonepe']);
				$data = $_POST;
				$this->bankmethod($data,'phonep_count');
				$this->session->set_flashdata('heading','PhoneP Saved');
				$this->session->set_flashdata('success','Bank Detail successfully saved');    
			}elseif(!empty($_POST) && (!empty($_POST['paytm']))){
				unset($_POST['paytm']);
				$data = $_POST;
				$this->bankmethod($data,'paytm_coun');
				$this->session->set_flashdata('heading','Paytm Number');
				$this->session->set_flashdata('success','Bank Detail successfully saved');    
			}
			elseif(!empty($_POST) && (!empty($_POST['tez']))){
				unset($_POST['tez']);
				$data = $_POST;
				$this->bankmethod($data,'tez_count');
				$this->session->set_flashdata('heading','Tez Number');
				$this->session->set_flashdata('success','Bank Detail successfully saved');    
			}
			elseif(!empty($_POST) && (!empty($_POST['bit']))){
				unset($_POST['bit']);
				$data = $_POST;
				$this->bankmethod($data,'bitcoint_count');
				$this->session->set_flashdata('heading','Bitcoin address');
				$this->session->set_flashdata('success','Bitcoin Address updated successfully');    
			}
		$this->data['bank'] = empty($bankdata) ?  $this->common->accessrecord(TBL_BANK_INFO,[],['user_id'=>userid()],'row') : (object)$bankdata;
		$this->data['history'] = $this->common->accessrecord(TBL_BANK_HISTORY,[],['user_id'=>userid()],'result');
		$this->data['page'] = 'bank';
		$this->data['content'] = 'kyc_form/bank';
		$this->load->view('user/template',$this->data);
	}
	private function bankmethod($data,$method){
        if($this->common->accessrecord(TBL_BANK_INFO,[],['user_id'=>userid()],'row')){
            $this->common->updateData(TBL_BANK_INFO,$data,['user_id'=>userid()]);
            $this->session->set_flashdata('heading','Bank Details Updated');
            $this->session->set_flashdata('success','Bank Detail successfully saved');
    }else{
        $data['user_id'] = userid();
        $this->common->insertData(TBL_BANK_INFO,$data);
        $this->session->set_flashdata('heading','Bank Detail Updated');
        $this->session->set_flashdata('success','Bank Detail successfully saved');
    }
	}
	function subscribe_package(){
		$this->data['package'] = $this->common->accessrecord(TBL_PACKAGE,[],[],'result');
		$this->data['page'] = 'package';
		$this->data['content'] = 'packages/package';
		$this->load->view('user/template',$this->data);
	}
	function buy(){
		extract($_POST);
        // Set variables for paypal form
        $returnURL = site_url('paypal/success');
        $cancelURL = site_url('paypal/cancel');
        $notifyURL = site_url('paypal/ipn');
        
        // Get product data from the database
        $product = $this->common->accessrecord(TBL_PACKAGE,[],['id'=>$id],'row');
        
        // Get current user ID from the session
        $userID = userid();
        
        // Add fields to paypal form
        $this->paypal_lib->add_field('return', $returnURL);
        $this->paypal_lib->add_field('cancel_return', $cancelURL);
        $this->paypal_lib->add_field('notify_url', $notifyURL);
        $this->paypal_lib->add_field('item_name','TipTok Package');
        $this->paypal_lib->add_field('custom', $userID);
        $this->paypal_lib->add_field('item_number',  $id);
        $this->paypal_lib->add_field('amount',  $product->package_amount);
        
        // Render paypal form
        $this->paypal_lib->paypal_auto_form();
    }
	function getLastNDays(){
		$date = date('2020-03-21');
		for($i=0; $i<7; $i++){
			echo date('Y-m-d',strtotime($date."-$i day"))."<br>";
		}
	}
	function directMemberForGraph(){
		$lastDate = $this->common->accessrecord(TBL_USER,[],['refferal_by'=>sponsor()],'row');
		if(!empty($lastDate)){

	    $firstDate  = date('Y-m-d',strtotime($lastDate->create_at));
		$getLastDate = date('Y-m-d',strtotime(date('Y-m-d',strtotime($lastDate->create_at))." - 7 days"));
		$data = $this->common->accessrecord(TBL_USER,['count(id) as total , date_format(create_at,"%Y-%m-%d") as date'],['date_format(create_at,"%Y-%m-%d")>='=>$getLastDate,'date_format(create_at,"%Y-%m-%d")<='=>$firstDate],'result');
		$result = [];
		$dateList = [];
		for($i=0; $i<7; $i++){
			$dateList[] = date('Y-m-d',strtotime($firstDate."-$i day"));
		}
		for($i=0; $i<count($dateList); $i++){
			foreach($data as $row){
				if($row->date==$dateList[$i]){
					$resutl[] = array('visits'=>$row->total,'country'=>$row->date);
				}else{
					$resutl[] = array('visits'=>0,'country'=>$dateList[$i]);
				}
			}
		}
		// foreach($data as $row){
		// 	$resutl[] = array('visits'=>$row->total,'country'=>$row->date);
		// }
		return $resutl;
		
	}
	}
	function mydirect(){
		
		$this->data['data'] = $this->common->accessrecord(TBL_USER,[],['refferal_by'=>sponsor()],'result');
		$this->data['page'] = 'direct';
		$this->data['content'] = 'downline/direct';
		$this->load->view('user/template',$this->data);
	}
	function getmember($id){
	
		return	$this->common->accessrecordwithjoin([TBL_USER.'.full_name,'.TBL_USER.'.email,'.TBL_USER.'.mobile,'.TBL_USER.'.plan_id,'.TBL_PACKAGE.'.package_amount,'.TBL_USER.'.activation_date'],TBL_USER,TBL_PACKAGE,[TBL_USER.'.plan_id',TBL_PACKAGE.'.id'],[TBL_USER.'.refferal_by'=>$id],'left',[]);
	}
	function levelmember($id='12345678'){
		$data = $this->getmember($id);
		$result = array();
		if(!empty($data)){
			$result['First Level'] = $data;
			foreach($data as $second){
				
			}
		}
	}
	function supportticket(){
		$this->form_validation->set_rules('category','Category','required');
		$this->form_validation->set_rules('subject','Subject','trim|required|xss_clean');
		$this->form_validation->set_rules('message','Message','required|xss_clean');
		if($this->form_validation->run()==false){}else{
			$data=$_POST;
			unset($data['ticket']);
			$isTrue=1;
			if(!empty($_FILES['image']['name'])){
				   $image = uploadimage('image',SUPPORT);
					if(!$image){
						$isTrue=0;
					}else{
						$data['attechment'] = $image;
					}
			}
			if($isTrue==1){
				
				$data['user_id'] = userid();
				$data['ticket_number'] = date('YmdHis');
				$this->common->insertData(TBL_SUPPORT,$data);
				$this->session->set_flashdata('heading','Ticket Created');
				$this->session->set_flashdata('success','Support ticket successfully created');
			
			}else{
				$this->session->set_flashdata('heading','Opps! Image formats');
				$this->session->set_flashdata('error','Image formats should be jpg, jpeg or png');
			
			}
		}if(!empty($_POST) && (!empty($_POST['ticket']))) {
			redirect('dashboard');
		}else{
		$this->data['page'] = 'support';
		$this->data['content'] = 'support/support';
		$this->load->view('user/template',$this->data);
		}
	}
	function support(){
		$this->data['ticket'] = $this->common->accessrecord(TBL_SUPPORT,[],['user_id'=>userid()],'result');
		$this->data['page'] = 'support_list';
		$this->data['content'] = 'support/support_list';
		$this->load->view('user/template',$this->data);
	}
	function ticket_information(){
		$id = base64_decode($_GET['id']);
		if(!empty($_POST)){
			extract($_POST);
			global $currentDateTime;
			$name = $this->common->accessrecord(TBL_USER,['full_name'],['id'=>userid()],'row');
		$isTrue=1;
		$data['image']='';
		$data['date'] = $currentDateTime;
		$data['message'] = $message;
		$data['by'] = $name->full_name;
		$img = '';
		if(!empty($_FILES['image']['name'])){
			$image = uploadimage('image',SUPPORT);
			if(!$image==0){
				$isTrue=0;
			}else{
				$data['image'] = $image;
				// $img = '<img src="'.BASE_URL.SUPPORT.$data['image'].'"
				// width="100px">';
			}
		}
		if($isTrue==1){
			$record = $this->common->accessrecord(TBL_SUPPORT,['reply'],['id'=>$id],'row');
			$reply[] = $data;
			if(!empty($record->reply)){
				$reply = unserialize($record->reply);
				$reply[] = $data;
			}
			$this->common->updateData(TBL_SUPPORT,['reply'=>serialize($reply)],['id'=>$id]);
			$this->session->set_flashdata('success','Message sent to admin');
		}else{
			$this->session->set_flashdata('error','Attachment Error! only jpg,png, jpeg, gif format are supported');
		}
	}
		$this->data['ticket'] = $this->common->accessrecord(TBL_SUPPORT,[],['id'=>$id],'row');
		$this->data['page'] = 'description';
		$this->data['content'] = 'support/description';
		$this->load->view('user/template',$this->data);
	}
	function id_card(){
		if(!empty($_POST)){
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
				$data['sponsor_id'] = sponsor();
				$data['id_type'] = $this->input->post('id_type');
				$data['id_number'] = $this->input->post('id_number');
				$this->common->insertData(TBL_KYC,$data);
				$this->session->set_flashdata('heading','Id card Uploaded');
				$this->session->set_flashdata('success','Id Card successfully uploded');
			}else{
				$this->session->set_flashdata('heading','Image error');
				$this->session->set_flashdata('error','Image not have an proper format');
			}
		}
		$this->data['page'] = 'id_card';
		$this->data['content'] = 'kyc_form/id_card';
		$this->load->view('user/template',$this->data);
	}
	function pan_card(){
		if(!empty($_POST)){
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
				$data['sponsor_id'] = sponsor();
				$data['id_number'] = $this->input->post('id_number');
				$data['dob'] = $this->input->post('dob');
				$this->common->insertData(TBL_KYC,$data);
				$this->session->set_flashdata('heading','Pan card Uploaded');
				$this->session->set_flashdata('success','Pan Card successfully uploded');
			}else{
				$this->session->set_flashdata('heading','Image error');
				$this->session->set_flashdata('error','Image not have an proper format');
			}
		}
		$this->data['page'] = 'pan_card';
		$this->data['content'] = 'kyc_form/pan_card';
		$this->load->view('user/template',$this->data);
	}
	function new_referral(){
		$this->data['page'] ='registration';
		$this->data['content'] = 'profile/registration';
		$this->load->view('user/template',$this->data);
	}
	
	function video_upload_income(){
		if(!empty($_GET['from_date']) && !empty($_GET['to_date'])){
			$from_date = date('Y-m-d',strtotime($_GET['from_date'])); 
			$to_date = date('Y-m-d',strtotime($_GET['to_date']));
			$where = ['date_format(create_at,"%Y-%m-%d")>='=>$from_date,'date_format(create_at,"%Y-%m-%d")<='=>$to_date,'sponsor_id'=>sponsor(),'type'=>0];
		}else{
			$where = ['sponsor_id'=>sponsor(),'type'=>0];
		}
		$this->data['earning'] = $this->common->accessrecord(TBL_VIDEO_INCOME,[],$where,'result');
		asort($this->data['earning']);
		$this->data['page'] ='upload_income';
		$this->data['content'] = 'my_earning/upload_income';
		$this->load->view('user/template',$this->data);
	}
	function video_shared_income(){
		if(!empty($_GET['from_date']) && !empty($_GET['to_date'])){
			$from_date = date('Y-m-d',strtotime($_GET['from_date'])); 
			$to_date = date('Y-m-d',strtotime($_GET['to_date']));
			$where = ['date_format(create_at,"%Y-%m-%d")>='=>$from_date,'date_format(create_at,"%Y-%m-%d")<='=>$to_date,'sponsor_id'=>sponsor(),'type'=>1];
		}else{
			$where = ['sponsor_id'=>sponsor(),'type'=>1];
		}
		$this->data['earning'] = $this->common->accessrecord(TBL_VIDEO_INCOME,[],$where,'result');
		asort($this->data['earning']);
		$this->data['page'] ='shared_income';
		$this->data['content'] = 'my_earning/shared_income';
		$this->load->view('user/template',$this->data);
	}
	function video_like_income(){
		if(!empty($_GET['from_date']) && !empty($_GET['to_date'])){
			$from_date = date('Y-m-d',strtotime($_GET['from_date'])); 
			$to_date = date('Y-m-d',strtotime($_GET['to_date']));
			$where = ['date_format(create_at,"%Y-%m-%d")>='=>$from_date,'date_format(create_at,"%Y-%m-%d")<='=>$to_date,'sponsor_id'=>sponsor(),'type'=>2];
		}else{
			$where = ['sponsor_id'=>sponsor(),'type'=>2];
		}
		$this->data['earning'] = $this->common->accessrecord(TBL_VIDEO_INCOME,[],$where,'result');
		asort($this->data['earning']);
		//echo $this->db->last_query(); die;
		$this->data['page'] ='like_income';
		$this->data['content'] = 'my_earning/like_income';
		$this->load->view('user/template',$this->data);
	}
	function logout(){
		$this->session->unset_userdata('user');
		$this->session->sess_destroy();
		redirect(BASE_URL);
	}
}
