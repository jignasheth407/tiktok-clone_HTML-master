<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/


$root = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on' ? 'https://'.$_SERVER['HTTP_HOST'] : 'http://'.$_SERVER['HTTP_HOST'];
$root .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);

defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

define('BASE_URL',$root);
//define('BASE_URL','http://13.127.44.203/tiptop/');

define('PREFIX','WD');
define('PRE_COUNT','2');
define('USERNAME','root');
define('DATABASE','tiptop');
define('PASSWORD','Asdf123zxc!@#');


define('PROFILE_PIC','./assets/images/profile/');

define('BANK_IMAGE','./assets/images/bank_receipt/');
define('FUND_IMAGE', './assets/back/assets/fund_image/');
define('SUPPORT', './assets/images/support_ticket/');
define('BROWSER_IMAGE', './assets/images/browser/');
define('VIDEO_THUMBNAIL_PATH', './assets/images/video/thumbnail/');
define('LOCALVIDEO_PATH', './assets/images/video/');
define('MUSIC_ICON','./assets/images/music_category/');
define('CATE_MUSIC','./assets/music/category_music/');
define('MUSIC_THUMBNAIL','./assets/music/category_music/thumbnai/');
//define('VIDEO_PATH', 'https://tip-top-video-aws-video-transcoder.s3.ap-south-1.amazonaws.com/');
define('VIDEO_PATH','https://d3g5m4mzeprxut.cloudfront.net/');
define('MUSIC_VIDEO','https://tip-top-video-aws-video.s3.ap-south-1.amazonaws.com/');
//define('MP3',chop('.\assets\music\mp3\s','s'));
define('MP3','assets/music/mp3/');
define('AAC','assets/music/aac/');
define('ABS_PATH',str_replace(chop('\s','s'),'/',explode('application',dirname(__FILE__))[0])); 
define('TBL_USER','user');

define('TBL_REFFERAL_POINT','refferal_point');
define('TBL_BANK_INFO','user_bank_info');
define('TBL_BANK_HISTORY','bank_history');
define('TBL_PACKAGE','package');
define('TBL_NEWS','news');
define('TBL_SUPPORT','support');
define('TBL_KYC','document_kyc');
define('TBL_IP','ip_history');
define('TBL_OTP','number_otp');
define('TBL_TASKCATEGORYVIDEOS',' task_category_videos');
define('TBL_PAYMENT','payments');
define('TBL_VIDEO_INCOME','video_share_like_upload_income');
define('TBL_SHARE_LIKE_HISTORY','video_share_like_history');
define('TBL_NOTIFICATION','notification');
define('TBL_LIKE_UNLIKE','likeunlike');
define('TBL_PAYMENT_HISTORY','payment_history');
define('TBL_BTC_ADDRESS','btc_address');
define('TBL_LEVEL_INCOME','level_income');
define('TBL_BOOSTER_INCOME','booster_income');
define('TBL_WITHDRAWAL','withdrawal_request');
define('TBL_BTC_TRANSACTION','btc_transaction');
define('TBL_USER_MUSIC','user_music');
define('TBL_FOLLOWING','tblfollowing');
define('TBL_CATEGORY','category');
define('TBL_CATEGORY_MUSIC','category_music');
define('TBL_USER_FEVORATES','my_favorite');
