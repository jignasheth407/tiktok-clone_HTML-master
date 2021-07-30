<?php $user = $this->common->accessrecord(TBL_USER,[],['id'=>adminid()],'row');
?>
 <div class="leftbar">
            <!-- Start Sidebar -->
            <div class="sidebar">
                <!-- Start Logobar -->
               
                <div class="profilebar text-center">
                    <img src="<?= BASE_URL ?>assets/web/images/logo1.png" class="img-fluid" alt="profile">
                    <div class="profilename">
                      <h5 class="text-white"><?= $user->full_name ?></h5>
                      <p><?= $user->type==1? 'Admin':'Sub-admin' ?></p>
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
                            <a href="authdashboard">
                                <img src="assets/images/svg-icon/dashboard.svg" class="img-fluid" alt="widgets"><span>Dashboard</span>
                            </a>
                        </li>
                     
                        <!--=============for only school= services end==============-->
                        <li>
                            <a href="javaScript:void();">
                              <img src="<?= BASE_URL ?>assets/images/svg-icon/dashboard.svg" class="img-fluid" alt="dashboard"><span>Video List</span><i class="feather icon-chevron-right pull-right"></i>
                            </a>
                            <ul class="vertical-submenu">
                                <li><a href="view-video?want=<?= base64_encode(3)."&type=".base64_encode(-1)?>"><i class="mdi mdi-circle"></i>All Video</a></li>
                                <li><a href="view-video?want=<?= base64_encode(3)."&type=".base64_encode(1)?>"><i class="mdi mdi-circle"></i>Home Video</a></li>
                                <li><a href="view-video?want=<?= base64_encode(4)."&type=".base64_encode(4)?>"><i class="mdi mdi-circle"></i>Popular Videos</a></li>
                                <!-- <li><a href="view-video?want=<?= base64_encode(3)."&type=".base64_encode(0)?>"><i class="mdi mdi-circle"></i>New Video</a></li> -->
                                <li><a href="view-video?want=<?= base64_encode(3)."&type=".base64_encode(0)?>"><i class="mdi mdi-circle"></i>Pending Video</a></li>
                                <li><a href="view-video?want=<?= base64_encode(3)."&type=".base64_encode(2)?>"><i class="mdi mdi-circle"></i>Rejected Video</a></li>
                            </ul>
                        </li>
                        <!-- <li>
                            <a href="city-list">
                                <img src="<?= BASE_URL ?>assets/images/svg-icon/dashboard.svg" class="img-fluid" alt="widgets"><span>City & Locations</span>
                            </a>
                        </li> -->

                        <li>
                            <a href="javaScript:void();">
                              <img src="<?= BASE_URL ?>assets/images/svg-icon/dashboard.svg" class="img-fluid" alt="dashboard"><span>Music Category</span><i class="feather icon-chevron-right pull-right"></i>
                            </a>
                            <ul class="vertical-submenu">
                                <li><a href="category-list"><i class="mdi mdi-circle"></i>Category List</a></li>
                                <li><a href="create-music"><i class="mdi mdi-circle"></i>Create Music</a></li>

                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>