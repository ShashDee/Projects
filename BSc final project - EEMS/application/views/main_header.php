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

    <!-- datetimepicker -->
    <link href = "<?php echo base_url('vendor/bootstrap-datetimepicker-master/build/css/bootstrap-datetimepicker.css'); ?>" rel="stylesheet" type="text/css">

    <!-- selectpicker -->
    <link href="<?php echo base_url('vendor/bootstrap-select-1.11.0/dist/css/bootstrap-select.min.css'); ?>" rel="stylesheet" type="text/css">

    <!-- DataTables CSS -->
    <link href="<?php  echo base_url('vendor/datatables-plugins/dataTables.bootstrap.css'); ?>" rel="stylesheet" type="text/css">
    <link href="<?php  echo base_url('vendor/datatables/css/jquery.dataTables.css'); ?>" rel="stylesheet" type="text/css">

    <!-- DataTables Responsive CSS -->
    <link href="<?php  echo base_url('vendor/datatables-responsive/dataTables.responsive.css'); ?>" rel="stylesheet" type="text/css">

    <!-- Social Buttons CSS -->
    <link href="<?php  echo base_url('vendor/bootstrap-social/bootstrap-social.css'); ?>" rel="stylesheet" type="text/css">

    <!-- iCheck -->
    <link href="<?php echo base_url('vendor/iCheck/_all.css'); ?>" rel = "stylesheet" type="text/css">

    <!-- Switchery -->
    <link href="<?php echo base_url('vendor/switchery/switchery.css'); ?>" rel = "stylesheet" type="text/css">

    <!-- Toastr Notifications -->
    <link href="<?php echo base_url('vendor/toastr-master/build/toastr.min.css'); ?>" rel = "stylesheet" type="text/css">

    <!-- front-end validation -->
    <link href="<?php echo base_url('vendor/jQuery-Form-Validator-master/form-validator/theme-default.min.css') ?>" rel="stylesheet" type="text/css">

    <!-- Full Calendar -->
    <link href="<?php echo base_url('vendor/fullcalendar-3.0.0/fullcalendar.css') ?>" rel="stylesheet" type="text/css">

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

    <div id="wrapper animated fadeInRight">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand"><?php echo $this->session->userdata('username'); ?></a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user animated flipInX">
                        <li><a href="<?php echo site_url('/dashboard/logout'); ?>"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse" id = "sidebar_menu">
                    <ul class="nav" id="side-menu"><!-- Side menu start  -->
                        <li>
                            <a  href="<?php echo site_url('dashboard'); ?>"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        <?php if($this->session->userdata('user_group') == "admin"): ?> <!-- user access level check -->
                        <li>
                            <a href="#"><i class="fa fa-cogs fa-fw"></i> Configuration<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a onclick = "loadModule('config/event_type/event_type_lookup_view');"><i class="fa fa-list-alt fa-fw"></i> Event Types</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <?php endif; ?>
                        <li>
                            <a href="#"><i class="fa fa-file-archive-o fa-fw"></i> Master<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a onclick = "loadModule('master/supplier/supplier_lookup_view');"><i class="fa fa-plane fa-fw"></i> Suppliers</a>
                                </li>
                                <li>
                                    <a onclick = "loadModule('master/customer/customer_lookup_view');"><i class="fa fa-user fa-fw"></i> Customers</a>
                                </li>
                                <?php if($this->session->userdata('user_group') == "admin"): ?>
                                <li>
                                    <a onclick = "loadModule('master/employee/employee_lookup_view');"><i class="glyphicon glyphicon-briefcase fa-fw"></i> Employees</a>
                                </li>
                                <li>
                                    <a onclick = "loadModule('master/user/user_lookup_view');"><i class="fa fa-users fa-fw"></i> Users</a>
                                </li>
                                <?php endif; ?>
                                <li>
                                    <a onclick = "loadModule('master/venue/venue_lookup_view');"><i class="fa fa-globe fa-fw"></i> Venues</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-money fa-fw"></i> Transactions<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="#"><i class="fa fa-gift fa-fw"></i> Events <span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level">
                                        <li>
                                            <a onclick = "loadModule('transaction/event/event_view');"><i class="fa fa-gift fa-fw"></i> Event</a>
                                        </li>
                                        <li>
                                            <a onclick = "loadModule('transaction/checklist/checklist_lookup_view');"><i class="fa fa-list-alt fa-fw"></i> Event Activity Checklist</a>
                                        </li>
                                        <li>
                                            <a onclick = "loadModule('transaction/agenda/agenda_view');"><i class="fa fa-list fa-fw"></i> Event Agenda</a>
                                        </li>
                                    </ul>
                                    <!-- /.nav-third-level -->
                                </li>
                                <?php if($this->session->userdata('user_group') == "admin"): ?>
                                <li>
                                    <a onclick = "loadModule('transaction/schedule/schedule_view');"><i class="glyphicon glyphicon-calendar fa-fw"></i> Schedule</a>
                                </li>
                                <?php endif; ?>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-bar-chart fa-fw"></i> Reports<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a onclick = "loadModule('reports/event_summary_report/event_summary_report_view');"><i class="fa fa-bar-chart fa-fw"></i> Event Summary Report</a>
                                </li>
                                <li>
                                    <a onclick = "loadModule('reports/event_rate_report/event_rate_report_view');"><i class="fa fa-bar-chart fa-fw"></i> Event Rate Report</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <!-- Page Content -->
        <div id="page-wrapper">
            
        </div>
        <!-- /#page-wrapper -->