<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="Themesbox">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Admin Login</title>
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <link href="<?= BASE_URL ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?= BASE_URL ?>assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="<?= BASE_URL ?>assets/css/style.css" rel="stylesheet" type="text/css">
</head>
<body class="vertical-layout">
    <!-- Start Containerbar -->
    <div id="containerbar" class="containerbar authenticate-bg">
        <!-- Start Container -->
        <div class="container">
            <div class="auth-box login-box">
                <!-- Start row -->
                <div class="row no-gutters align-items-center justify-content-center">                    
                    <!-- Start col -->
                    <div class="col-md-6 col-lg-5">
                        <div class="auth-box-left">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="text-white">Your comminuty awaits.</h4>
                                    <div class="auth-box-icon">
                                        <img src="<?= BASE_URL ?>assets/images/authentication/auth-box-icon.svg" class="img-fluid" alt="auth-box-icon">
                                    </div>
                                    <div class="auth-box-logo">
                                        <img src="<?= BASE_URL ?>assets/images/logo.svg" class="img-fluid " alt="logo">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Start end -->
                    <!-- Start col -->
                    <div class="col-md-6 col-lg-5">
                        <!-- Start Auth Box -->
                        <div class="auth-box-right">
                            <div class="card">
                                <div class="card-body">
                                    <form method="post">
                                        <h4 class="text-primary mb-4">Log in !</h4>
                                        <?php if(!empty($this->session->flashdata('error'))) { ?> <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div><?php } ?>
                                        <div class="form-group">
                                            <input type="text" name="email" class="form-control" id="username" placeholder="Enter Username here" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control" id="password" placeholder="Enter Password here" required>
                                        </div>
                                        <div class="form-row mb-3">
                                            <div class="col-sm-6">
                                                <div class="custom-control custom-checkbox">
                                                  <input type="checkbox" class="custom-control-input" id="rememberme">
                                                  <label class="custom-control-label font-14" for="rememberme">Remember Me</label>
                                                </div>                                
                                            </div>
                                            <div class="col-sm-6">
                                              <div class="forgot-psw"> 
                                                <a id="forgot-psw" href="user-forgotpsw.html" class="font-14">Forgot Password?</a>
                                              </div>
                                            </div>
                                        </div>                          
                                      <button type="submit" class="btn btn-success btn-lg btn-block font-18">Log in Now</button>
                                    </form>
                                  
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?= BASE_URL ?>assets/js/jquery.min.js"></script>
    <script src="<?= BASE_URL ?>assets/js/popper.min.js"></script>
    <script src="<?= BASE_URL ?>assets/js/bootstrap.min.js"></script>
    <script src="<?= BASE_URL ?>assets/js/modernizr.min.js"></script>
    <script src="<?= BASE_URL ?>assets/js/detect.js"></script>
    <script src="<?= BASE_URL ?>assets/js/jquery.slimscroll.js"></script>
</body>
</html>