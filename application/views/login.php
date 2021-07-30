<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/signup/fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/signup/css/style.css">

<style>

body {
    margin: 0px;
}
.main.padding-no{
    padding-top: 10px;
    padding-bottom: 10px;
}
.main.padding-no section.sign-in {
    margin: 0;
}
.main.padding-no section.sign-in .signin-content {
    padding: 10px;
}
.main.padding-no section.sign-in .container {
    background: rgba(0, 0, 0, .8);
}
.main.padding-no {
    padding-top: 10px;
    padding-bottom: 10px;
    background-image: url(assets/web/images/bg/8.jpg);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
}
.main.padding-no section.sign-in .signin-content .signin-form h2.form-title {
    color: #fff;
    font-size: 19px;
    font-weight: 600;
}
.main.padding-no section.sign-in .signin-content .signin-form form.register-form .form-group input {
    background: transparent;
    border-bottom: 1px solid #fff;
    color: #fff;
}
.main.padding-no section.sign-in .signin-content .signin-form .form-group i {
    color: #fff;
}
.main.padding-no section.sign-in .signin-content .form-group label a {
    color: #03A9F4;
}
.main.padding-no section.sign-in .signin-content .form-group label {
    color: #fff;
}
.main.padding-no section.sign-in .signin-content .signin-form form.register-form .form-group input.form-submit {
    background: #4659e2;
    border: 1px solid #4659e2;
    padding: 10px 20px;
}
.main.padding-no section.sign-in .signin-content .signin-form form.register-form .form-group input.form-submit:hover {
    background: #ff7a01;
    border: 1px solid #fff;
}
.main.padding-no section.sign-in .signin-content .signin-form form.register-form .form-group a.signup-image-link {
    color: #03A9F4;
    float: right;
    margin-top: 35px;
}

</style>    
</head>
<body>
    
    <div class="main padding-no">

        <!-- Sign up form -->
        

        <!-- Sing in  Form -->
       <section class="sign-in">
            <div class="container">
                <div class="signin-content">
                    <div class="signin-image">
                        <figure><img src="<?= BASE_URL ?>assets/web/images/logo1.png" alt="sing up image"></figure>
                    </div>

                    <div class="signin-form">
                        <h2 class="form-title">Login account</h2>
                        <?php if(!empty($this->session->flashdata('msg'))){ ?> <div style="color: red;font-weight: 800;"><?= $this->session->flashdata('msg'); ?></div><?php } ?>
                        <form method="POST" class="register-form" id="login-form">
                            <div class="form-group">
                                <label for="your_name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="sponsor_id" id="your_name" placeholder="Enter user id"/>
                            </div>
                            <div class="form-group">
                                <label for="your_pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="password" id="your_pass" placeholder="Password"/>
                            </div>
                            <div class="form-group">
                                <label for="remember-me" class="label-agree-term"><a href="forgot">Forgot Password?</a></label>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="remember-me" id="remember-me" class="agree-term" />
                                <label for="remember-me" class="label-agree-term"><span><span></span></span>Remember me</label>
                               
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" id="signin" class="form-submit" value="Log in"/>
                                <a href="signup" class="signup-image-link">Create an account?</a>
                            </div>
                            
                        </form>
                        
                    </div>
                </div>
            </div>
        </section>

    </div>

    <!-- JS -->
    <script src="<?= BASE_URL ?>assets/signup/vendor/jquery/jquery.min.js"></script>
    <script src="<?= BASE_URL ?>assets/signup/js/main.js"></script>
</body>
</html>