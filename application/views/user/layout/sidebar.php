<?php $user = $this->common->accessrecord(TBL_USER,[],['id'=>userid()],'row');
?>
 <div class="leftbar">
            <!-- Start Sidebar -->
            <div class="sidebar">
                <!-- Start Logobar -->
                <div class="logobar">
                    <a href="javascript:;" class="logo logo-large"><img src="<?= BASE_URL ?>assets/images/logo1.png" class="img-fluid" alt="logo" style="width:20%"></a>
                    <a href="javascript:;" class="logo logo-small"><img src="<?= BASE_URL ?>assets/images/logo1.png" class="img-fluid" alt="logo"></a>
                </div>
                <div class="profilebar text-center">
                    <img src="<?= BASE_URL.PROFILE_PIC.$user->image ?>" class="img-fluid" alt="profile">
                    <div class="profilename">
                      <h5 class="text-white"><?= $user->full_name ?></h5>
                      <p><?= PREFIX.sponsor()?></p>
                    </div>
                    <div class="userbox">
                        <ul class="list-inline mb-0">
                            <li class="list-inline-item"><a href="profile" class="profile-icon"><img src="<?= BASE_URL ?>assets/images/svg-icon/user.svg" class="img-fluid" alt="user"></a></li>
                            <li class="list-inline-item"><a href="logout" class="profile-icon"><img src="<?= BASE_URL ?>assets/images/svg-icon/logout.svg" class="img-fluid" alt="logout"></a></li>
                        </ul>
                      </div>
                </div>
                <div class="navigationbar">
                    <ul class="vertical-menu">
                        <li class="vertical-header">Main</li>
                        <li>
                            <a href="dashboard">
                                <img src="<?= BASE_URL ?>assets/images/svg-icon/dashboard.svg" class="img-fluid" alt="widgets"><span>Dashboard</span>
                            </a>
                        </li>
                      
                        <li>
                            <a href="subscribe-package">
                                <img src="<?= BASE_URL ?>assets/images/svg-icon/dashboard.svg" class="img-fluid" alt="widgets"><span>Packages</span>
                            </a>
                        </li>
                        <!--=============for only school= services end==============-->
                        <li>
                            <a href="javaScript:void();">
                              <img src="<?= BASE_URL ?>assets/images/svg-icon/dashboard.svg" class="img-fluid" alt="dashboard"><span>My Profile</span><i class="feather icon-chevron-right pull-right"></i>
                            </a>
                            <ul class="vertical-submenu">
                                <li><a href="profile"><i class="mdi mdi-circle"></i>Profile</a></li>
                                <li><a href="bank-account"><i class="mdi mdi-circle"></i>Bank Account</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javaScript:void();">
                              <img src="<?= BASE_URL ?>assets/images/svg-icon/dashboard.svg" class="img-fluid" alt="dashboard"><span>My Earning</span><i class="feather icon-chevron-right pull-right"></i>
                            </a>
                            <ul class="vertical-submenu">
                                <li><a href="upload-income"><i class="mdi mdi-circle"></i>Video Upload Income</a></li>
                                <li><a href="shared-income"><i class="mdi mdi-circle"></i>Shared Income</a></li>
                                <li><a href="like-income"><i class="mdi mdi-circle"></i>Like Income</a></li>
                                <li><a href="level-income"><i class="mdi mdi-circle"></i>Level Income</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javaScript:void();">
                              <img src="<?= BASE_URL ?>assets/images/svg-icon/dashboard.svg" class="img-fluid" alt="dashboard"><span>My Community</span><i class="feather icon-chevron-right pull-right"></i>
                            </a>
                            <ul class="vertical-submenu">
                                <li><a href="new-referral"><i class="mdi mdi-circle"></i>Add New Referral</a></li>
                                <li><a href="direct-member"><i class="mdi mdi-circle"></i>Direct Member</a></li>
                                <li><a href="level-member"><i class="mdi mdi-circle"></i>Level Member</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="ticket-list">
                                <img src="<?= BASE_URL ?>assets/images/svg-icon/dashboard.svg" class="img-fluid" alt="widgets"><span>Help Desk</span>
                            </a>
                        </li>
                       
                    </ul>
                </div>
            </div>
        </div>