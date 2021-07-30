<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Common extends CI_Model {
	public $array = array();
	public function __construct()
	{
		$this->load->database();
		//$otherdb = $this->load->database('sudheer', TRUE);
	}
	function insertData(string $table, array $data){
		$this->db->insert($table,$data);
		return $this->db->insert_id();
	}
	function insertBatch($table,$data){
		
		$this->db->insert_batch($table,$data);
	}
	function accessrecord(string $table, array $select, array $where, string $want,string $desc="desc"){
		$this->db->select(implode(',',$select));
		if($desc=="desc" || $desc=='asc'){
		$this->db->order_by('id',$desc);
		}else{
			$this->db->order_by('rand()');
		}
		$data = $this->db->get_where($table,$where);
		return $want=='row' ? $data->row() : $data->result();
		echo $this->db->last_query(); die;
	}
	function updateData(string $table, array $data, array $where){
		$this->db->update($table,$data,$where);
		return $this->db->affected_rows();
	}
	function deleteRecord(string $table, array $data){
		$this->db->delete($table,$data);
		return $this->db->affected_rows();
	}

	function setMethod(string $table, string $method, string $feild, string $value, array $where){
			$this->db->set($feild,$feild."".$method ."". $value,false);
			$this->db->where($where);
			$this->db->update($table);
			return $this->db->affected_rows();
	}
	function custumQuery(string $table, array $select, array $where,array $random, string $want){
		$custom='';
		if(!empty($random)){
			for($i=0; $i<count($random); $i++){
				$custom.= $random[$i]['key']. " ". $random[$i]['value'];
			}
		}
		$where='';
		if(!empty($where)){
			$where = " WHERE ".  implode('and',$where);
		}
		$select = !empty($select) ? implode(',',$select) : "*";
		$sql = "SELECT" . $select. "FROM ". $table. $where. $custom;
		return $want=='row' ? $this->db->query($sql)->row() : $this->db->query($sql)->result();
		echo $this->db->last_query(); die;
	}
	function accessrecordwithjoin(array $select, string $from, string $to, array $join, array $where, string $what, array $yourQuery){
		$custum = '';
		$possition = 0;
		$rows = 1;
		if(!empty($yourQuery)){
			for($i=0; $i<count($yourQuery); $i++){
				if(empty($yourQuery[$i]['key'])){
					$possition=1;
				}
				if(empty($yourQuery[$i]['key']) && ($yourQuery[$i]['value'])=='row'){
					$rows=0;
				}
				$custum.= $yourQuery[$i]['key']. " " .$yourQuery[$i]['value'];
			}
		}
		$custumwhere = '';
		if(!empty($where)){
			 $data = array();
					 foreach ($where as $key => $value) {
						 $data[] = $key."=".$value;
					 }
			$custumwhere = " WHERE ".implode(' and ', $data);
		}
		$temp = $custumwhere;
		$tempj = chop($custum,'row');
		if($possition==1){
		   $custum = $temp;
		   $custumwhere = $tempj;
		}
		$query = "SELECT ". implode(',', $select). " FROM ". $from. " ". $what. " JOIN  ".$to." ON ". implode('=', $join). " ".$custumwhere." ".$custum  ;
		$result = $this->db->query($query);
		//echo $this->db->last_query(); die;
		return $rows==1 ? $result->result(): $result->row();
		echo $this->db->last_query(); die;
	}
	/**
	 *   assing epin to another sponsor
	 * 
	 */
	 function assignepin($ids,$id){
		 $this->db->where_in('id',$ids);
		 $this->db->update(TBL_EPIN,array('user_id'=>$id));
		// echo $this->db->last_query(); die;
	 }
	 function wherein($table,$select,$feild,$where_in,$want,$extra){
		$this->db->select(implode(',',$select));
		$this->db->where_in($feild,$where_in);
		if(!empty($extra)){
			$this->db->where($extra);
		}
		$result = $this->db->get($table);
//		echo $this->db->last_query(); die;
		return $want=='row' ? $result->row() :  $result->result();
	}
	 /**
	  * get epin list
	  */
	  function getepinlist($id){
		$array[]  = array('key'=> ' LEFT JOIN '.TBL_USER.' t2 ON '.TBL_EPIN_HISTORY.'.from_sponsor=t2.sponsor_id ','value'=>' WHERE '.TBL_EPIN_HISTORY.'.to_sponsor='.$id.' OR '.TBL_EPIN_HISTORY.'.from_sponsor='.$id);
		$data = $this->accessrecordwithjoin([TBL_EPIN_HISTORY.'.*, t1.full_name, t2.full_name as recivername'],TBL_EPIN_HISTORY,TBL_USER." t1 ",[TBL_EPIN_HISTORY.'.to_sponsor','t1.sponsor_id'],[],'inner',$array);
		$result= array();
		foreach($data as $row){
			$exp = explode(',',$row->epin_list);
				$this->db->select('epins,status');
				$this->db->where_in('id',$exp);
			$row->epins = 	$this->db->get(TBL_EPIN)->result();
			$result[] = $row;
		}
		return $result;
	}

	
	/* ===============registeration ===========start==============start====================start=============== */
	
	function getLeftChild($sponser_id)
	{
		$Id = $this->db->get_where('tree', ['self_id' => $sponser_id])->row();
		$child_left = $Id->child_left;
		if (!empty($child_left)) {
			$this->getLeftChild($Id->child_left);
		} else {
			$this->array = $Id;
		}
	}
	function getChildLeftempty()
	{
		return $this->array;
	}
	function getRightChild($sponser_id)
	{
		$Id = $this->db->get_where('tree', ['self_id' => $sponser_id])->row();
		if (!empty($Id->child_right)) {
			$this->getRightChild($Id->child_right);
		} else {
			return $this->array = $Id;
		}
	}
	private function generateSponsorId()
	{
		$randnum = mt_rand(10000000, 99999999);
		$this->db->select('self_id');
		$res = $this->db->get_where('tree', array('self_id' => $randnum));
		if ($res->num_rows() > 0) {
			return $this->generateSponsorId();
		} else {
			return  $randnum;
		}
	}
	public function register($sponsor_id, $upline_id, $placement, $password, $mobile, $email, $full_name, $package, $capping)
	{
		date_default_timezone_set('Asia/Kolkata');
		$selfleft = "";
		$baseid = date('yd0000');
		$selfusernewid = $this->generateSponsorId();
		$this->db->trans_start();
		$insert['sponsor_id'] = $selfusernewid;
		$insert['password'] = sha1($password);
		$insert['pwd'] = $password;
		$insert['mobile'] = $mobile;
		$insert['full_name'] = $full_name;
		$insert['position'] = $placement;
		$insert['email'] = $email;
		//$insert['epin']=$epin;
		$insert['capping_amount'] = $capping;
		$insert['joining_pv'] = $package;
		$insert['create_at'] = date('Y-m-d H:i:s');
		$this->db->insert(TBL_USER, $insert);
		$userID = $this->db->insert_id();
		//=========================================================================INSERT START TREE TABLE ===================================================
		$tree['self_id'] = $selfusernewid;
		$tree['upline_id']=$upline_id;
		$tree['added_by'] = $sponsor_id;
		$tree['user_id'] = $userID;
		$this->db->insert(TBL_TREE, $tree);
		$selfuserID = $this->db->insert_id();
		 if($placement=="left")
		{
			$this->db->update(TBL_TREE,array('child_left' => $selfusernewid ) ,array('self_id' =>$upline_id));
		}
		else
		{
			$this->db->update(TBL_TREE,array('child_right' => $selfusernewid ) ,array('self_id' =>$upline_id));
		}
		$this->db->trans_complete();
		return $selfusernewid;
	}
	/* =====================end======================end=====================end=============================== */
	public function commentlist($tbl='', $vid='')
		{
			$comments = $this->db->where('video_id', $vid)->get($tbl)->result();
			if (!empty($comments)) {
				foreach ($comments as $ckey => $cval) {
					$userd = $this->db->select('sponsor_id as ID, full_name as name,image')->where('sponsor_id', $cval->username)->get(TBL_USER)->row();
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
			return $comments;
		}
	
}
