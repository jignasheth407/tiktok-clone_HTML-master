<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Jscss extends CI_Model {
	public function __construct()
	{
	}
	function css($page){
		$css_array = array();
		$css_array[]='<link href="'.BASE_URL.'assets/plugins/switchery/switchery.min.css" rel="stylesheet">';
		$css_array[]='<link href="'.BASE_URL.'assets/plugins/jvectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet">';
		$css_array[]='<link href="'.BASE_URL.'assets/plugins/datepicker/datepicker.min.css" rel="stylesheet" type="text/css">';
		$css_array[]='<link href="'.BASE_URL.'assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">';
		$css_array[]='<link href="'.BASE_URL.'assets/css/icons.css" rel="stylesheet" type="text/css">';
		$css_array[]='<link href="'.BASE_URL.'assets/css/flag-icon.min.css" rel="stylesheet" type="text/css">';
		$css_array[]='<link href="'.BASE_URL.'assets/css/style.css" rel="stylesheet" type="text/css">';
		$css_array[]='<link href="https://res.cloudinary.com/dxfq3iotg/raw/upload/v1557232134/toasty.css" rel="stylesheet" />';
		
		if($page=='pan_card' || $page=='upload_income' || $page=='shared_income' || $page=='like_income'){
			$css_array[] = '  <link href="'.BASE_URL.'assets/plugins/datepicker/datepicker.min.css" rel="stylesheet" type="text/css">';
		}
		/*===========dataTables=================== */
		if($page=='direct' || $page=='upload_income' || $page=='shared_income' || $page=='like_income'){
			$css_array[]='<link href="'.BASE_URL.'assets/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />';
			$css_array[]='<link href="'.BASE_URL.'assets/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />';
			$css_array[]='<link href="'.BASE_URL.'assets/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />';
		}
		/*===============end========end========== */
		/* ==========modal=============== */
		 if($page=='city_list' || $page=='location_list' || $page=='class_list'){
			 $css_array[]=' <link href="'.BASE_URL.'assets/plugins/animate/animate.css" rel="stylesheet" type="text/css">';
		 }
		/* =============end============== */
		/**===========================multiselect =start=========================== */
		 if($page=='post_coaching' || $page=='add_totur'){
			 $css_array[] = '<link href="'.BASE_URL.'assets/plugins/select2/select2.min.css" rel="stylesheet" type="text/css">';
		 }
		 if($page=='sidebar_module'){
			 $css_array[]= '<link href="'.BASE_URL.'assets/plugins/jstree/jstree.min.css" rel="stylesheet" type="text/css">';
		 }
		 if($page=='view_videos' || $page=='web_view'){
			$css_array[]= '<link href="'.BASE_URL.'assets/css/video-js.css" rel="stylesheet" type="text/css">';
			$css_array[]= '<script src="'.BASE_URL.'assets/js/video.js"></script>';
			$css_array[]= '<script src="'.BASE_URL.'assets/js/videojs-contrib-hls.js"></script>';
		 }
		/*================end===============end===============end================== */
		return $css_array;
	}

	function js($page){
	$js_array=[];
	$js_array[]='<script src="'.BASE_URL.'assets/js/jquery.min.js"></script>';
    $js_array[]='<script src="'.BASE_URL.'assets/js/popper.min.js"></script>';
    $js_array[]='<script src="'.BASE_URL.'assets/js/bootstrap.min.js"></script>';
    $js_array[]='<script src="'.BASE_URL.'assets/js/modernizr.min.js"></script>';
    $js_array[]='<script src="'.BASE_URL.'assets/js/detect.js"></script>';
    $js_array[]='<script src="'.BASE_URL.'assets/js/jquery.slimscroll.js"></script>';
    $js_array[]='<script src="'.BASE_URL.'assets/js/vertical-menu.js"></script>';
	$js_array[]='<script src="'.BASE_URL.'assets/plugins/switchery/switchery.min.js"></script>';
	$js_array[]='<script src="https://res.cloudinary.com/dxfq3iotg/raw/upload/v1557232134/toasty.js"></script>';
    
    
	if($page=='pan_card' || $page=='upload_income' || $page=='shared_income'){
		$js_array[] =  '<script src="'.BASE_URL.'assets/plugins/datepicker/datepicker.min.js"></script>';
		$js_array[] =  '<script src="'.BASE_URL.'assets/plugins/datepicker/i18n/datepicker.en.js"></script>';
		$js_array[] =  '<script src="'.BASE_URL.'assets/js/custom/custom-form-datepicker.js"></script>';
		

	}
	if($page=='index'){
	
		$js_array[] =  '<script src="'.BASE_URL.'assets/js/waterTank.js"></script>';
		$js_array[] =  '<script src="'.BASE_URL.'assets/js/waterTank.min.js"></script>';
	}
	$js_array[]='<script src="'.BASE_URL.'assets/js/core.js"></script>';	
	/* ============= for dataTables============== */
	if($page=='direct'|| $page=='upload_income' || $page=='shared_income' || $page=='like_income'){
		$js_array[]='<script src="'.BASE_URL.'assets/plugins/datatables/jquery.dataTables.min.js"></script>';
		$js_array[]='<script src="'.BASE_URL.'assets/plugins/datatables/dataTables.bootstrap4.min.js"></script>';
		$js_array[]='<script src="'.BASE_URL.'assets/plugins/datatables/dataTables.buttons.min.js"></script>';
		$js_array[]='<script src="'.BASE_URL.'assets/plugins/datatables/buttons.bootstrap4.min.js"></script>';
		$js_array[]='<script src="'.BASE_URL.'assets/plugins/datatables/jszip.min.js"></script>';
		$js_array[]='<script src="'.BASE_URL.'assets/plugins/datatables/pdfmake.min.js"></script>';
		$js_array[]='<script src="'.BASE_URL.'assets/plugins/datatables/vfs_fonts.js"></script>';
		$js_array[]='<script src="'.BASE_URL.'assets/plugins/datatables/buttons.html5.min.js"></script>';
		$js_array[]='<script src="'.BASE_URL.'assets/plugins/datatables/buttons.print.min.js"></script>';
		$js_array[]='<script src="'.BASE_URL.'assets/plugins/datatables/buttons.colVis.min.js"></script>';
		$js_array[]='<script src="'.BASE_URL.'assets/plugins/datatables/dataTables.responsive.min.js"></script>';
		$js_array[]='<script src="'.BASE_URL.'assets/plugins/datatables/responsive.bootstrap4.min.js"></script>';
		$js_array[]='<script src="'.BASE_URL.'assets/js/custom/custom-table-datatable.js"></script>';
	}
	/* ===========end========end================== */
	/* ==========================modal======================== */
	if($page=='city_list'|| $page=='location_list' || $page=='class_list'){
		$js_array[]=' <script src="'.BASE_URL.'assets/js/custom/custom-model.js"></script>';
	}
	/* ==================modal end=========end================ */

	/* ===========for form-validation======================================== */
		if($page=='post_coaching' || $page=='add_totur' || $page=='profile' || $page=='location_list'){
			$js_array[]='<script src="'.BASE_URL.'assets/plugins/validatejs/validate.min.js"></script>';
			$js_array[]='<script src="'.BASE_URL.'assets/js/custom/custom-validate.js"></script>';
			$js_array[]='<script src="'.BASE_URL.'assets/js/custom/custom-form-validation.js"></script>';
		}
	/* =============validation end=============end============end============ */
	/* ================= form multiselect ================start==============*/
	 if($page=='post_coaching' || $page=='add_totur'){
		 $js_array[] = '<script src="'.BASE_URL.'assets/plugins/select2/select2.min.js"></script>    ';
		 $js_array[] = '<script src="'.BASE_URL.'assets/js/custom/custom-form-select.js"></script>';
	 }
	 if($page=='sidebar_module'){
		$js_array[] = '<script src="'.BASE_URL.'assets/plugins/jstree/jstree.min.js"></script>';
		$js_array[] ='<script src="'.BASE_URL.'assets/js/custom/custom-jstree.js"></script>';
	 }
	 if($page=='view_videos'|| $page=='web_view'){
		$js_array[]= '<script src="'.BASE_URL.'assets/js/custom/scroll.js"></script>';
	 }
	 if($page=='add_category' || $page=='add_music' || $page=='add_sub_category'){
		 $js_array[] = '<script src="'.BASE_URL.'assets/js/custom/admin-category.js"></script>';
	 }
	/* ===============end===========end==========end========end============== */
	return $js_array;
	}
} 
?>
