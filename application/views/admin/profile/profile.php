<div class="breadcrumbbar">
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title">My Account</h4>
            <div class="breadcrumb-list">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:;">Profile</a></li>
                    <li class="breadcrumb-item active" aria-current="page">My Account</li>
                </ol>
            </div>
        </div>
       
    </div>          
</div>
<!-- End Breadcrumbbar -->
<!-- Start Contentbar -->    
<div class="contentbar">                
    <!-- Start row -->
    <div class="row">
        <!-- Start col -->
        <div class="col-lg-5 col-xl-3">
            <div class="card m-b-30">
                <div class="card-header">                                
                    <h5 class="card-title mb-0">My Account</h5>                                       
                </div>
                <div class="card-body">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link mb-2 active" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false"><i class="feather icon-user mr-2"></i>My Profile</a>
                        <a class="nav-link mb-2" id="v-pills-email-tab" data-toggle="pill" href="#v-pills-email" role="tab" aria-controls="v-pills-profile" aria-selected="false"><i class="feather icon-mail mr-2"></i>My Email</a>
                        <a class="nav-link mb-2" id="v-pills-password-tab" data-toggle="pill" href="#v-pills-password" role="tab" aria-controls="v-pills-profile" aria-selected="false"><i class="feather icon-key mr-2"></i>Change Password</a>
                       
                    </div>
                </div>
            </div>
        </div>
        <!-- End col -->
        <!-- Start col -->
        <div class="col-lg-7 col-xl-9">
            <div class="tab-content" id="v-pills-tabContent">
               <div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                    <div class="card m-b-30">
                        <div class="card-header">                                
                            <h5 class="card-title mb-0">My Profile</h5>                                       
                        </div>
                        <div class="card-body">
                            <div class="profilebox pt-4 text-center">
                                <ul class="list-inline">
                                   
                                    <li class="list-inline-item">
                                        <img src="assets/images/users/profile.svg" class="img-fluid" alt="profile">
                                    </li>
                                  
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card m-b-30">
                        <div class="card-header">                                
                            <h5 class="card-title mb-0">Edit Profile Informations</h5>                                       
                        </div>
                        <div class="card-body">
                            <form method="post">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="username">Full Name</label>
                                        <input type="text" class="form-control" name="full_name" value="<?= isset($profile->full_name) ? $profile->full_name : '' ?>" id="username">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="useremail">Mobile Number</label>
                                        <input type="text" class="form-control" name="mobile" value="<?= isset($profile->mobile) ? $profile->mobile : '' ?>" id="useremail">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary-rgba font-16"><i class="feather icon-save mr-2"></i>Update</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="v-pills-email" role="tabpanel" aria-labelledby="v-pills-email-tab">
                    
                    <div class="card m-b-30">
                        <div class="card-header">                                
                            <h5 class="card-title mb-0">Update My Email <span id="errorMsg"></span></h5>                                       
                        </div>
                        <div class="card-body">
                            <form id="email" method="post">
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="username">Email Address<span id="e-email"></span></label>
                                        <input type="text" class="form-control" name="email" value="<?= isset($profile->email) ? $profile->email : '' ?>">
                                    </div>
                                   
                                </div>
                               
                                <button type="submit" class="btn btn-primary-rgba font-16"><i class="feather icon-save mr-2"></i>Update</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="v-pills-password" role="tabpanel" aria-labelledby="v-pills-password-tab">
                    
                    <div class="card m-b-30">
                        <div class="card-header">                                
                            <h5 class="card-title mb-0">Update Your Password <span id="perrorMsg"></span></h5>                                       
                        </div>
                        <div class="card-body">
                            <form id="password">
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="username">Old Password<span id="p-old"></span></label>
                                        <input type="password" name="old" class="form-control">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="useremail">New Password<span id="p-new_password"></span></label>
                                        <input type="password" name="new_password" class="form-control" >
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="useremail">Confirm Password<span id="p-confirm"></span></label>
                                        <input type="password" name="confirm" class="form-control">
                                    </div>
                                </div>
                               
                                <button type="submit" class="btn btn-primary-rgba font-16"><i class="feather icon-save mr-2"></i>Update</button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- My Profile End -->
                <!-- My Logout Start -->
               
                <!-- My Logout End -->                            
            </div>                        
        </div>
        <!-- End col -->
    </div>
    <!-- End row -->                  
</div>