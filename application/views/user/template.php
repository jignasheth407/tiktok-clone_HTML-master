<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="Themesbox">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Tip Top || User</title>
   
    <link rel="shortcut icon" href="assets/images/favicon.ico">
   
	<?php 
	  $CI =& get_instance(); 
	  $CI->load->model(array('jscss','common'));
	  $profile = $CI->common->accessrecord(TBL_USER,[],['id'=>userid()],'row');
	  $css = $CI->jscss->css($page);
	  $jss = $CI->jscss->js($page);
 
	   foreach($css as $cs){
		   echo $cs;
	   }
	?>
    <!-- End css -->
</head>
<body class="vertical-layout">
  
    <div class="infobar-settings-sidebar-overlay"></div>
    <!-- End Infobar Setting Sidebar -->
    <!-- Start Containerbar -->
    <div id="containerbar">
        <!-- Start Leftbar -->
       <?php $this->load->view('user/layout/sidebar');?>
        <!-- End Leftbar -->
        <!-- Start Rightbar -->
        <div class="rightbar">
            <!-- Start Topbar Mobile -->
            <div class="topbar-mobile">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        
                        <div class="mobile-togglebar">
                            <ul class="list-inline mb-0">
                                <li class="list-inline-item">
                                    
                                </li>
                                <li class="list-inline-item">
                                    <div class="menubar">
                                        <a class="menu-hamburger" href="javascript:void();">
                                            <img src="<?= BASE_URL ?>assets/images/svg-icon/collapse.svg" class="img-fluid menu-hamburger-collapse" alt="collapse">
                                            <img src="<?= BASE_URL ?>assets/images/svg-icon/close.svg" class="img-fluid menu-hamburger-close" alt="close">
                                         </a>
                                     </div>
                                </li>                                
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="topbar">
                <!-- Start row -->
                <div class="row align-items-center">
                    <!-- Start col -->
                    <div class="col-md-12 align-self-center">
                        <div class="togglebar">
                            <ul class="list-inline mb-0">
                                <li class="list-inline-item">
                                    <div class="menubar">
                                        <a class="menu-hamburger" href="javascript:void();">
                                           <img src="<?= BASE_URL ?>assets/images/svg-icon/collapse.svg" class="img-fluid menu-hamburger-collapse" alt="collapse">
                                           <img src="<?= BASE_URL ?>assets/images/svg-icon/close.svg" class="img-fluid menu-hamburger-close" alt="close">
                                         </a>
                                     </div>
                                </li>
                                <li class="list-inline-item">
                                    
                                </li>
                            </ul>
                        </div>
                        <div class="infobar">
                            <ul class="list-inline mb-0">
                               
                            </ul>
                        </div>
                    </div>
                    <!-- End col -->
                </div> 
                <!-- End row -->
            </div>
            <?php $this->load->view('user/'.$content); ?>
            <div class="footerbar">
                <footer class="footer">
                    <p class="mb-0">© 2020 Tip-Top  All Rights Reserved.</p>
                </footer>
            </div>
        </div>
    </div>
    <?php 
       foreach($jss as $js){
           echo $js;
       }
    ?>

<?php if(!empty($this->session->flashdata('heading'))) { ?>
    <script>
        window.onload=function(){
            $("#simple-toasts").appendTo($("body")), 
            $("#simple-toasts").toast({
                delay: 5000
            }),
            $("#simple-toasts").toast("show")
        }
    </script>
    <!--================toaster=-====================-->
        <div aria-live="polite" aria-atomic="true">
            <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" style="position: absolute; top: 30px; right: 30px;" id="simple-toasts">
                <div class="toast-header bg-<?= $this->session->flashdata('success') ? 'success' : 'danger' ?>">
                    <i class="feather icon-alert-triangle text-danger mr-2"></i>  
                    <span class="toast-title mr-auto"><?= $this->session->flashdata('heading')?></span>
                </div>
                <div class="toast-body">
                    <?= !empty($this->session->flashdata('success')) ? $this->session->flashdata('success') : $this->session->flashdata('error') ; ?>
                </div>
            </div>
        </div>
<?php } ?>
    <!--===============end==========end==========end==--->
   
</body>
</html>