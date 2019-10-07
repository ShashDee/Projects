<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>EEMS</title>

     <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url('assets/css/bootstrap.css'); ?>" rel="stylesheet" type="text/css">

    <!-- animate -->
    <link href="<?php echo base_url('assets/css/animate.css'); ?>" rel="stylesheet" type="text/css">

    <!-- MetisMenu CSS -->
    <link href="<?php echo base_url('vendor/metisMenu/metisMenu.min.css'); ?>" rel="stylesheet" type="text/css">

    <!-- Custom Fonts -->
    <link href="<?php echo base_url('vendor/font-awesome/css/font-awesome.min.css'); ?>" rel="stylesheet" type="text/css">

    <!-- Custom CSS -->
    <link href="<?php echo base_url('dist/css/sb-admin-2.css'); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url('assets/css/custom_style.css'); ?>" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
    <div class="middle-box text-center loginscreen animated fadeInDown">        
        <div class="m-t-xxl">
            <div>
                <img class="img-responsive" src="assets/img/eems.png">
            </div>
            <br><h3 class="panel-title text-center text-primary"><strong>Please Sign In</strong></h3>
            <?php echo form_open('login/submit_login','role="form" id = "login_form" name = "login_form"'); ?>
                <?php
                    if(!empty($this->session->flashdata('e')))
                       echo '<div class="alert alert-danger text-center"><strong>Login Failed! </strong><p>'. $this->session->flashdata('e') .'</p></div>';
                    if(!empty($this->session->flashdata('s')))
                       echo '<div class="alert alert-success text-center"><strong>Log Out Successful! </strong><p>'. $this->session->flashdata('s') .'</p></div>';
                ?>
                <fieldset>
                    <div class="form-group">
                        <input class="form-control" placeholder="Username" name="username" type="text" value = "" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control" placeholder="Password" name="password" type="password" value="" required>
                    </div>
                    
                    <button class="btn btn-lg btn-primary btn-block" type = "submit" id = "login_btn">Login</button>
                </fieldset>
            <?php echo form_close(); ?>
                <br><p class="text-center"> <small>Solutions by Final Project &copy; <?php echo date('Y'); ?></small> </p>
        </div>        
    </div>

    <!-- jQuery -->
    <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?php echo base_url('vendor/metisMenu/metisMenu.min.js'); ?>"></script>

    <!-- Custom Theme JavaScript -->
    <script src="<?php echo base_url('dist/js/sb-admin-2.js'); ?>"></script>

</body>

</html>
