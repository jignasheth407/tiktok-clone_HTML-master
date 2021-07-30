<?php

class Mylevel {
	public $i=0;
	function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->model('common');
	}
	function getsponsorlevel($from_user,$sponsor_id,$desamount,$type)
    {  // for level income first payout
	
        date_default_timezone_set('Asia/Kolkata');
        
        $currentDate = date('Y-m-d H:i:s');

        $array = array();

        $data = $this->CI->common->accessrecord(TBL_USER, ['refferal_by as added_by'], ['sponsor_id' => $from_user], 'row');
        //$data->debit_amount = 10000;
        $sponsor_id = strtoupper($sponsor_id);
        $data->added_by = strtoupper($data->added_by);
        if (!empty($data->added_by && $this->CI->i < 21)) {

            if ($this->i == 0) {
                $level = 1;
                $amount = ($desamount*7)/100; // first level
                  $this->forlevelupdatation($data->added_by,  $level, $amount,$desamount, $sponsor_id,$type,7);
            }
            if ($this->i == 1) {
                $level = 2;
                $amount = ($desamount*5)/100; //second levelfrom_user
                  $this->forlevelupdatation($data->added_by,  $level, $amount, $desamount, $sponsor_id,$type,5);
            }
            if ($this->i == 2) {
                $level = 3;
                $amount = ($desamount*3)/100; // thired level
				$this->forlevelupdatation($data->added_by,  $level, $amount, $desamount, $sponsor_id,$type,3);
            }
            if ($this->i == 3) {
                $level = 4;
                $amount = ($desamount*2)/100; // fourth level
				$this->forlevelupdatation($data->added_by,  $level, $amount,$desamount, $sponsor_id,$type,2);
            }
            if ($this->i == 4) {
                $level = 5;
                $amount = ($desamount*1)/100; // fith level
				$this->forlevelupdatation($data->added_by,  $level, $amount, $desamount, $sponsor_id,$type,1);
            }
            if ($this->i == 5) {
              $level = 6;
              $amount = ($desamount*.50)/100; // six level
			  $this->forlevelupdatation($data->added_by,  $level, $amount, $desamount, $sponsor_id,$type,0.50);
            }
            if ($this->i == 6) {
              $level = 7;
              $amount = ($desamount*.50)/100; // six level
			  $this->forlevelupdatation($data->added_by,  $level, $amount, $desamount, $sponsor_id,$type,0.50);
            }
            if ($this->i == 7) {
              $level = 8;
              $amount = ($desamount*.50)/100; // six level
			  $this->forlevelupdatation($data->added_by,  $level, $amount, $desamount, $sponsor_id,$type,0.50);
            }
            if ($this->i == 8) {
              $level = 9;
              $amount = ($desamount*.50)/100; // six level
			  $this->forlevelupdatation($data->added_by,  $level, $amount, $desamount, $sponsor_id,$type,0.50);
            }
            if ($this->i == 9) {
              $level = 10;
              $amount = ($desamount*.50)/100; // six level
			  $this->forlevelupdatation($data->added_by,  $level, $amount, $desamount, $sponsor_id,$type,0.50);
            }
            if ($this->i == 10) {
              $level = 11;
              $amount = ($desamount*2)/100; // six level
			  $this->forlevelupdatation($data->added_by,  $level, $amount, $desamount, $sponsor_id,$type,0.50);
            }
            if ($this->i == 11) {
              $level = 12;
              $amount = ($desamount*.50)/100; // six level
			  $this->forlevelupdatation($data->added_by,  $level, $amount,$desamount, $sponsor_id,$type,0.50);
            }
            if ($this->i == 12) {
              $level = 13;
              $amount = ($desamount*.25)/100; // six level
			  $this->forlevelupdatation($data->added_by,  $level, $amount, $desamount, $sponsor_id,$type,0.50);
            }
            if ($this->i == 13) {
              $level = 14;
              $amount = ($desamount*.25)/100; // six level
			  $this->forlevelupdatation($data->added_by,  $level, $amount, $desamount, $sponsor_id,$type,0.50);
            }
            if ($this->i == 14) {
              $level = 15;
              $amount = ($desamount*.25)/100; // six level
			  $this->forlevelupdatation($data->added_by,  $level, $amount, $desamount, $sponsor_id,$type,0.50);
            }
            if ($this->i == 15) {
              $level = 16;
              $amount = ($desamount*.25)/100; // six level
			  $this->forlevelupdatation($data->added_by,  $level, $amount, $desamount, $sponsor_id,$type,0.50);
            }
            if ($this->i == 16) {
              $level = 17;
              $amount = ($desamount*.25)/100; // six level
			  $this->forlevelupdatation($data->added_by,  $level, $amount, $desamount, $sponsor_id,$type,0.50);
            }
            if ($this->i == 17) {
              $level = 18;
              $amount = ($desamount*.25)/100; // six level
			  $this->forlevelupdatation($data->added_by,  $level, $amount, $desamount,$sponsor_id,$type,0.50);
            }
            if ($this->i == 18) {
              $level = 19;
              $amount = ($desamount*.25)/100; // six level
			  $this->forlevelupdatation($data->added_by,  $level, $amount, $desamount,$sponsor_id,$type,0.50);
            }
            if ($this->i == 19) {
              $level = 20;
              $amount = ($desamount*.25)/100; // six level
			  $this->forlevelupdatation($data->added_by,  $level, $amount, $desamount,$sponsor_id,$type,0.25);
            }
            if ($this->i == 20) {
              $level = 21;
              $amount = ($desamount*2)/100; // six level
			  $this->forlevelupdatation($data->added_by,  $level, $amount, $desamount,$sponsor_id,$type,2);
            }
            
            $this->i++;
			$this->getsponsorlevel($data->added_by,$sponsor_id,$desamount,$type);
        }
    }
	function forlevelupdatation($sponsor_id,$level,$amount,$onamount,$from_user,$type,$percentage){
	
		if($check = $this->CI->common->accessrecord(TBL_USER,['id,status,last_date,plan_id'],['sponsor_id'=>$sponsor_id],'row')){
			  $currentDate = date('Y-m-d');
			  $message = $type==1 ? ' video share income' : 'video like income';
			if($type=='level'){

					$insert['sponsor_id'] = $sponsor_id;
					$insert['from_sponsor'] = $from_user;
					$insert['amount'] = $amount;
					$insert['level'] = $level;
					$insert['status'] = $check->status==1 ? 1 : 0;
					$insert['on_amount'] = $onamount;
					$insert['on_date'] = date('Y-m-d H:i:s');
					$this->CI->common->insertData(TBL_LEVEL_INCOME,$insert);

				$message = "Level ".$level." income";
				
			}else{
				$count = $this->CI->common->accessrecord(TBL_USER,['COUNT(id) as total'],['refferal_by'=>$sponsor_id,'last_date<='=>$check->last_date,'plan_id>='=>$check->plan_id],'row');
				if(!empty($count) && $count->total>=2){

					$likeS['sponsor_id'] =$sponsor_id;
					$likeS['amount'] = $amount;
					$likeS['type'] = $type;
					$likeS['create_at'] = date('Y-m-d H:i:s');
					$likeS['on_amount'] = $onamount;
					$likeS['percentage'] = $percentage;
					$likeS['on_level'] = $level;
					$likeS['from_user']= $from_user;
					$this->CI->common->insertData(TBL_BOOSTER_INCOME,$likeS);
					$message = "video ".$type==0 ? ' upload booster ' : ($type==1 ? ' share booster' : 'like booster')." income";
				}
      		}
      if($check->status==1){
        $this->CI->common->setMethod(TBL_USER,"+","wallet_amount",$amount,['sponsor_id'=>$sponsor_id]);
        $this->CI->common->setMethod(TBL_USER,"+","total_amount",$amount,['sponsor_id'=>$sponsor_id]);
        
        $this->paymentHistory($sponsor_id,$amount,1,$message);
      }
		  
		}
	}

	 function paymentHistory($id,$amount,$type,$message){
		$history['sponsor_id'] = $id;
		$history['amount'] = $amount;
		$history['type'] = $type;
		$history['remark'] = $message;
		$history['create_at'] = date('Y-m-d H:i:s');
		$this->CI->common->insertData(TBL_PAYMENT_HISTORY, $history);
	  }
}