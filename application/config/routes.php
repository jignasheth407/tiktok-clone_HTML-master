<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$route['default_controller'] = 'welcome';
$route['signin'] = 'welcome/userlogin';
$route['signup'] = 'welcome/registration';

$route['wedoadmin_panel_'] = 'welcome/adminlogin';

$route['forgot'] = 'welcome/forgot';
$route['legal'] = 'welcome/certificate';
$route['contact'] = 'welcome/contact_us';
$route['getusername'] = 'welcome/getusername'; 

$route['resend-signup-otp'] = 'welcome/resendsignupotp';
//$route['about-us'] = 'welcome/about';
$route['contact-us'] = 'welcome/contact';
$route['bank-info'] = 'welcome/bank';
$route['plan-info'] = 'welcome/plan';
$route['about-us'] = 'welcome/aboutus';
$route['privacy-policy'] = 'welcome/privacypolicy';
$route['termscondition'] = 'welcome/termscondition';
$route['cookie-policy'] = 'welcome/cookie_policy';
$route['law-policy'] = 'welcome/law_policy';
$route['community-policy'] = 'welcome/comminity_policy';
$route['copyright'] = 'welcome/copyright_policy';
$route['guidline'] = 'welcome/guidline';


/* ===========start======user section=================start=============== */

$route['dashboard'] = 'user/index';
$route['profile'] = 'user/profile';
$route['passwordupdate'] = 'user/passwordupdate';
$route['emailupdate'] = 'user/emailupdate';
$route['logout']  = 'user/logout';
$route['bank-account'] = 'user/bankinfo';
$route['direct-member'] = 'user/mydirect';
$route['subscribe-package'] = 'user/subscribe_package';
$route['create-ticket'] = 'user/supportticket';
$route['ticket-list'] = 'user/support';
$route['information'] = 'user/ticket_information';
$route['id-card'] = 'user/id_card';
$route['pan-card'] = 'user/pan_card';
$route['new-referral']  = 'user/new_referral';
$route['upload-income'] = 'user/video_upload_income';
$route['shared-income'] = 'user/video_shared_income';
$route['like-income'] = 'user/video_like_income';
/* ================end===========end============user section============== */

/* =============== admin============start================================== */
 $route['authdashboard'] = 'admin/dashboard';
 $route['home-video'] = 'admin/home_video';
 $route['video-category'] = 'admin/all_video';
 $route['view-video'] = 'admin/view_video/$1';
 $route['next-video'] = 'admin/getnextvideo';
 $route['activation'] = 'admin/updation';
 $route['is_homevideo'] = 'admin/homeupdation';

 $route['category-list'] = 'admin/category_list';
 $route['add-music-category'] = 'admin/add_music_category';
 $route['add-music-category-icon'] = 'admin/add_music_category_icon';
 $route['deleteMusicCategory/(:num)'] = 'admin/deleteMusicCategory/$1';
 $route['create-music'] =  'admin/create_music';
 $route['add-music-sub-category'] = 'admin/add_music_sub_category';
 $route['getsub-categorylist'] = 'admin/getsub_categorylist';
 $route['SubCategory-list'] = 'admin/SubCategory_list';
 $route['deleteSubcategory/(:num)'] = 'admin/deleteSubcategory/$1';
 $route['music-list'] = 'admin/musiclist';
/* =================== end-============end==========end==================== */

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
