<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registration</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/signup/fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/signup/css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <style>
    .custom-loader{
                    position: fixed;
    width: 100%;
    height: 100vh;
    background: rgba(241, 238, 238, 0.78);
    z-index: 9;
    display: flex;
    align-items: center;
    justify-content: center;
            }
    .custom-select {
        width: 100%;
        display: block;
        border: none;
        border-bottom: 1px solid #999;
        padding: 6px 30px;
        font-family: Poppins;
        box-sizing: border-box;
    }
    
	.modal.left .modal-dialog,
	.modal.right .modal-dialog {
		position: fixed;
		margin: auto;
		width: 320px;
		height: 100%;
		-webkit-transform: translate3d(0%, 0, 0);
		    -ms-transform: translate3d(0%, 0, 0);
		     -o-transform: translate3d(0%, 0, 0);
		        transform: translate3d(0%, 0, 0);
	}

	.modal.left .modal-content,
	.modal.right .modal-content {
		height: 100%;
		overflow-y: auto;
	}
	
	.modal.left .modal-body,
	.modal.right .modal-body {
		padding: 15px 15px 80px;
	}

/*Left*/
	.modal.left.fade .modal-dialog{
		left: -320px;
		-webkit-transition: opacity 0.3s linear, left 0.3s ease-out;
		   -moz-transition: opacity 0.3s linear, left 0.3s ease-out;
		     -o-transition: opacity 0.3s linear, left 0.3s ease-out;
		        transition: opacity 0.3s linear, left 0.3s ease-out;
	}
	
	.modal.left.fade.in .modal-dialog{
		left: 0;
	}
        
/*Right*/
	.modal.right.fade .modal-dialog {
		right: -320px;
		-webkit-transition: opacity 0.3s linear, right 0.3s ease-out;
		   -moz-transition: opacity 0.3s linear, right 0.3s ease-out;
		     -o-transition: opacity 0.3s linear, right 0.3s ease-out;
		        transition: opacity 0.3s linear, right 0.3s ease-out;
	}
	
	.modal.right.fade.in .modal-dialog {
		right: 0;
	}

/* ----- MODAL STYLE ----- */
	.modal-content {
		border-radius: 0;
		border: none;
	}

	.modal-header {
		border-bottom-color: #EEEEEE;
		background-color: #FAFAFA;
	}

/* ----- v CAN BE DELETED v ----- */
body {
	background-color: #78909C;
}

.demo {
	padding-top: 60px;
	padding-bottom: 110px;
}

.btn-demo {
	margin: 15px;
	padding: 10px 15px;
	border-radius: 0;
	font-size: 16px;
	background-color: #FFFFFF;
}

.btn-demo:focus {
	outline: 0;
}

.demo-footer {
	position: fixed;
	bottom: 0;
	width: 100%;
	padding: 15px;
	background-color: #212121;
	text-align: center;
}

.demo-footer > a {
	text-decoration: none;
	font-weight: bold;
	font-size: 16px;
	color: #fff;
}

.modal-open .modal .modal-dialog.cus-tom.modal-side.modal-notify{
    right: 30px;
    bottom: 0;
    height: auto;
    border-radius: 10px;
    overflow: hidden;
}
.modal-open .modal .modal-dialog.cus-tom.modal-side.modal-notify p.heading.lead {
    color: #091394;
    font-weight: 500;
    font-size: 19px;
}
.modal-open .modal .modal-dialog.cus-tom.modal-side.modal-notify .modal-footer a.btn.read {
    background: #4659e2;
    color: #fff;
}
.main.padding-no{
    padding-top: 10px;
    padding-bottom: 10px;
}
.main.padding-no section.signup {
    margin: 0;
}
.main.padding-no section.signup .signup-content {
    padding: 10px;
}
.main.padding-no section.signup .container {
    background: rgba(0, 0, 0, .9);
}
.main.padding-no {
    padding-top: 10px;
    padding-bottom: 10px;
    background-image: url(assets/web/images/bg/7.jpg);
}
.main.padding-no section.signup .signup-content .signup-form h2.form-title {
    color: #fff;
}
.main.padding-no section.signup .signup-content .signup-form form.register-form .form-group input {
    background: transparent;
    border-bottom: 1px solid #fff;
    color: #fff;
}
.main.padding-no section.signup .signup-content label.label-agree-term a.term-service {
    color: #03A9F4;
}
.main.padding-no section.signup .signup-content .signup-form form.register-form .form-group input.form-submit {
    background: #4659e2;
    border: 1px solid #4659e2;
    padding: 10px 20px;
}
.main.padding-no section.signup .signup-content .signup-form form.register-form .form-group input.form-submit:hover {
    background: #ff7a01;
    border: 1px solid #fff;
}
.main.padding-no section.signup .signup-content .form-group select {
    background: transparent;
    color: #fff;
}
.main.padding-no section.signup .signup-content .form-group label.label-agree-term {
    color: #fff;
}
.main.padding-no section.signup .signup-content .signup-form form.register-form .form-group a.signup-image-link {
    color: #03A9F4;
    float: right;
    margin-top: 35px;
}
.main.padding-no section.signup .signup-content .form-group i {
    color: #fff;
}
.main.padding-no section.signup .signup-content .form-group select option {
    color: black;
}

    </style>

</head>

<body>
    <div id="custom-loader" style="display:none;">
        <div class="custom-loader">
            <img src="<?= BASE_URL ?>assets/loader.gif" width="100px;">
        </div>
    </div>
    <div class="main padding-no">

        <!-- Sign up form -->
        <section class="signup">
            <div class="container">
                <div class="signup-content">
                    <div class="signup-form">
                        <h2 class="form-title">Registration Form</h2>
                        <form method="POST" class="register-form" id="registration">
                            <div class="form-group">
                                <lable id="spo_name"></lable>
                                <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="added_by" value="<?= !empty($_GET['id']) ? base64_decode($_GET['id']) : '' ?>" id="added_by" placeholder="Enter Referral id" />

                            </div>
                            <!-- <div class="form-group">
                                <lable id="up_name"></lable>
                                <label for="email"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" placeholder="Enter upline id (optional)" id="upline" name="upline"
                                    value="<?= !empty($_GET['upline']) ? base64_decode($_GET['upline']) : '' ?>">
                            </div> -->
                            <!-- <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-chevron-down material-icons-name"></i></label>
                                <select name="placement" class="custom-select" id="placement">
                                    <option value="">Select Placement</option>
                                    <option value="left"
                                        <?= isset($_GET['place']) && ($_GET['place']==0) ? 'selected' : '' ?>>Left
                                    </option>
                                    <option value="right"
                                        <?= isset($_GET['place']) && ($_GET['place']==1) ? 'selected=selected' : '' ?>>
                                        Right</option>
                                </select>
                            </div> -->
                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input id="full_name" placeholder="Enter Full Name" name="full_name"
                                    requiredonpaste="return false;" maxlength="20" minlength="3">
                            </div>
                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-email material-icons-name"></i></label>
                                <input id="email" name="email" placeholder="Enter email" required>
                            </div>
                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-phone material-icons-name"></i></label>
                                <input name="mobile" id="mobile" placeholder="Enter mobile number" required>
                            </div>

                            <div class="form-group">
                                <label for="pass"><i class="zmdi zmdi-lock material-icons-name"></i></label>
                                <input type="password" name="password" placeholder="Enter password" required
                                    id="password" onpaste="return false;" maxlength="15" minlength="6">
                            </div>
                            <div class="form-group">
                                <label for="re-pass"><i class="zmdi zmdi-lock-outline material-icons-name"></i></label>
                                <input type="password" name="confirmpassword" placeholder="Enter confirm password"
                                    required id="confirmpassword" onpaste="return false;" minlength="6" maxlength="15">
                            </div>
                            <div class="form-group">
                                <input type="checkbox" value="1" name="checkbox" class="agree-term" checked='checked' />
                                <label for="agree-term" class="label-agree-term"><span><span></span></span>I agree all
                                    statements in <a href="#" class="term-service">Terms of service</a></label>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="signup" id="signup" class="form-submit" value="Register" />
                                <!-- <button onclick="showModal();" type="button">Show Modal</button> -->
                                <a href="signin" class="signup-image-link">I am already member</a>
                            </div>
                        </form>
                    </div>
                    <div class="signup-image">
                        <figure><img src="<?= BASE_URL ?>assets/web/images/logo1.png" alt="sing up image"></figure>
                        
                    </div>
                </div>
            </div>
        </section>



    </div>
    <!--==================modal==========================-->
    <!-- Central Modal Medium Success -->
    <div class="modal fade right" id="centralModalSuccess" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog cus-tom modal-side modal-notify" role="document">
            <!--Content-->
            <div class="modal-content">
                <!--Header-->
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="white-text">&times;</span>
                    </button>
                    <p class="heading lead">Registration Information</p>

                   
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
    <!-- Central Modal Medium Success-->
    <!--==================modal=======end=========end====-->
    <!-- JS -->
    <script src="<?= BASE_URL ?>assets/signup/vendor/jquery/jquery.min.js"></script>
    <script src="<?= BASE_URL ?>assets/signup/js/main.js"></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script>
    function getpackage(str) {
        if(str.length!=0){
            if (str.length > 8) {
                $.ajax({
                    url: 'getusername?id=' + str,
                    dataType: 'json',
                    success: function(result) {
                        $("#showmsg").html(result.name).css('color', 'red');
                    }
                });
            } else {
                $("#showmsg").html('').css('color', 'red');
            }
        }
    }
    $("input[name=added_by]").on('keyup',function(){
        var value = $("input[name=added_by]").val();
        if(value.length!=0){
        if (value.length > 8) {
            $.ajax({
                url: 'getusername?id='+value,
                dataType: 'json',
                success: function(result) {
                    if(result.success==0){
                    $("#spo_name").html(result.name).css({'color':'red','font-weight':'800'});
                    }else{
                        $("#spo_name").html(result.name).css({'color':'green','font-weight':'800'});
                    }

                }
            });
        } else {
            $("#spo_name").html('Waiting...').css('color', 'red');
        }
    }else{
        $("#spo_name").html('');
    }
    });
    $("input[name=upline]").on('keyup',function(){
        var value = $("input[name=upline]").val();
        if (value.length > 8) {
            $.ajax({
                url: 'getusername?id='+value,
                dataType: 'json',
                success: function(result) {
                    if(result.success==0){
                    $("#up_name").html(result.name).css({'color':'red','font-weight':'800'});
                    }else{
                        $("#up_name").html(result.name).css({'color':'green','font-weight':'800'});
                    }

                }
            });
        } else {
            $("#up_name").html('Waiting...').css('color', 'red');
        }
    });
    $("#registration").submit(function() {
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
    })
    function showModal(){
        $("#centralModalSuccess").modal('show');
    }
    function sendOTP() {
        var mobile = $("input[name=mobile]").val();
        $.ajax({
            url: 'resend-signup-otp',
            type: 'POST',
            data: {
                mobile: mobile
            },
            beforeSend: function() {
                $("#resend").text('Loading...');
            },
            success: function(result) {
                if (result == 1) {
                    $("#resend").text('OTP Sent');
                }
            }
        });
    }
    </script>
</body>

</html>