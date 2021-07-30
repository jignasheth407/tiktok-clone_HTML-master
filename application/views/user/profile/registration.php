<div class="breadcrumbbar">
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title">My Account</h4>
            <div class="breadcrumb-list">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:;">Create New Account</a></li>
                    <li class="breadcrumb-item active" aria-current="page">New Account</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="contentbar">
    <div class="row">
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-3 header-title">New Account</h4>
                    <?= form_open('',array('onSubmit'=>'registration(); return false;','id'=>'registration')); ?>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Sponsor Id</label>
                        <input type="text" class="form-control" readonly name="added_by" value="<?= PREFIX.sponsor(); ?>"
                            required aria-describedby="emailHelp" placeholder="Enete Referral Id">
                        <small id="added_by" class="form-text text-muted"><?= form_error('added_by');?></small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Full Name</label>
                        <input type="text" name="full_name"  class="form-control" placeholder="Enter Full Name">
                        <small id="full_name" class="form-text text-muted"><?= form_error('full_name');?></small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Email Id</label>
                        <input type="text" name="email"  class="form-control" placeholder="Enter Email address">
                        <small id="email" class="form-text text-muted"><?= form_error('email');?></small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Mobile</label>
                        <input type="text" name="mobile"  class="form-control"
                            placeholder="Enter Mobile Number">
                        <small id="mobile" class="form-text text-muted"><?= form_error('mobile');?></small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Enter Password">
                        <small id="password" 
                            class="form-text text-muted"><?= form_error('password');?></small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Confirm Password</label>
                        <input type="password" name="confirmpassword" class="form-control" value=""
                            placeholder="Enter Confirm password">
                        <small id="confirmpassword"  class="form-text text-muted"><?= form_error('branch');?></small>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" value="1" name="checkbox" class="agree-term" checked='checked' />
                        <label for="agree-term" class="label-agree-term"><span><span></span></span>I agree all
                            statements in <a href="#" class="term-service">Terms of service</a></label>
                    </div>
                    <input type="submit" class="btn btn-primary waves-effect waves-light"  value="Save">
                    <?= form_close(); ?>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div>
       
    </div>
</div>

<div class="modal fade right" id="centralModalSuccess" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog cus-tom modal-side modal-notify" role="document">
            <!--Content-->
            <div class="modal-content">
                <!--Header-->
                <div class="modal-header">
                    <p class="heading lead">Registration Information</p>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="white-text">&times;</span>
                    </button>
                </div>
                <!--Body-->
                <div class="modal-body">
                    <div class="text-center">
                        <i class="fas fa-check fa-4x mb-3 animated rotateIn"></i>
                        <p>Thank you for registration in <?= BASE_URL ?>, your login detail has been sent in your given e-mail address, if you not get any email so my be wrong email address given by you
                        so please registered again with simple correct email address.</p>
                        <div id="regmsg1"></div>
                    </div>
                </div>

                <!--Footer-->
                <div class="modal-footer justify-content-center">
                    <a href="login" class="btn read">Get it now <i class="far fa-gem ml-1 text-white"></i></a>
                    <a type="button" class="btn read btn-outline-success waves-effect" data-dismiss="modal">No, thanks</a>
                </div>
            </div>
            <!--/.Content-->
        </div>
    </div>
    <script>

 function registration() {
    
        $.ajax({
            url: 'signup',
            type: 'POST',
            data: $("#registration").serialize(),
            dataType: 'json',
            beforeSend: function() {
                $("#custom-loader").css('display', 'block');
            },
            success: function(result) {
                $("#custom-loader").css('display', 'none');
                if (result.error) {
                    $.each(result.error, function(key, value) {
                        if (key != '' && value != '') {
                            $("#" + key).css({
                                'border': '1px solid red',
                                'color': 'red'
                            });
                        } else {
                            $("#" + key).css({
                                'border': '',
                                'color': ''
                            });
                        }
                    });

                    // if(result.error.mobile==''){

                    //     $("#otpbox").css('display','block');
                    // }

                } else if (result.wrong) {
                    $("#errormsg").html(result.wrong);
                } else if (result.success) {
                    $("#centralModalSuccess").modal('show');
                    $("#regmsg1").html(result.success);
                    $('#registration').each(function() {
                       this.reset();
                    });
                    $("#otpbox").css('display', 'none');
                }
            },
            error: function() {
                $("#errormsg").html(
                    '<div class="alert alert-danger">Something went wrong please</div>');
                $(".custom-loader").css('display', 'block');
            }
        });
        return false;
    }

    </script>