<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?=$this->auth->gettitle();?></title>       
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="theme-color" content="#5190fd" />
    <link href="<?=$this->auth->getlogo();?>" rel="shortcut icon" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css">    
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/style-main.css"> 
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/jquery.mCustomScrollbar.min.css"> 
    <?php
    $this->load->view('includes/theme');
    ?>
    <?php
    if ($this->customlib->getRTL() != "") {
        ?>
        <!-- Bootstrap 3.3.5 RTL -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/rtl/bootstrap-rtl/css/bootstrap-rtl.min.css"/> <!-- Theme RTL style -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/rtl/dist/css/AdminLTE-rtl.min.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/rtl/dist/css/ss-rtlmain.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/rtl/dist/css/skins/_all-skins-rtl.min.css" />
        <?php
    }
    ?> 
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/all.css">   
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/font-awesome.min.css">      
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/ionicons.min.css">       
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/iCheck/flat/blue.css">      
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/morris/morris.css">       
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/jvectormap/jquery-jvectormap-1.2.2.css">        
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datepicker/datepicker3.css"> 
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/colorpicker/bootstrap-colorpicker.css"> 

    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/daterangepicker/daterangepicker-bs3.css">      
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/custom_style.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/datepicker/css/bootstrap-datetimepicker.css">
    <!--file dropify-->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/dropify.min.css">
    <!--file nprogress-->
    <link href="<?php echo base_url(); ?>assets/dist/css/nprogress.css" rel="stylesheet">

    <!--print table-->
    <link href="<?php echo base_url(); ?>assets/dist/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/dist/datatables/css/buttons.dataTables.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/dist/datatables/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <!--print table mobile support-->
    <link href="<?php echo base_url(); ?>assets/dist/datatables/css/responsive.dataTables.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/dist/datatables/css/rowReorder.dataTables.min.css" rel="stylesheet">
    <script src="<?php echo base_url(); ?>assets/custom/jquery.min.js"></script>

    <script src="<?php echo base_url(); ?>assets/plugins/colorpicker/bootstrap-colorpicker.js"></script>
    <script src="<?php echo base_url(); ?>assets/datepicker/date.js"></script>       
    <script src="<?php echo base_url(); ?>assets/dist/js/jquery-ui.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/school-custom.js"></script>

    <link rel="stylesheet" href="<?=base_url()?>assets/all/toastr.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/all/garessi-notif.css">
    <!-- fullCalendar -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/fullcalendar/dist/fullcalendar.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/fullcalendar/dist/fullcalendar.print.min.css" media="print">

    <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/select2/select2.min.css">

    <style type="text/css">
        input[type=file] {
            opacity: 1;
        }

        .select2-container {
            width:100%! important; 
        }
    </style>

</head>
<script type="text/javascript">
    var baseurl = "<?php echo base_url(); ?>";
    var chk_validate = "<?php echo $this->config->item('SHLK') ?>";
</script>

<body class="hold-transition skin-blue fixed sidebar-mini">

    <script type="text/javascript">
        function collapseSidebar() {
            if (Boolean(sessionStorage.getItem('sidebar-toggle-collapsed'))) {
                sessionStorage.setItem('sidebar-toggle-collapsed', '');
            } else {
                sessionStorage.setItem('sidebar-toggle-collapsed', '1');
            }
        }

        function checksidebar() {
            if (Boolean(sessionStorage.getItem('sidebar-toggle-collapsed'))) {
                var body = document.getElementsByTagName('body')[0];
                body.className = body.className + ' sidebar-collapse';
            }
        }
        checksidebar();
    </script>
   
    <div class="wrapper">
      
        <header class="main-header" id="alert">    
        
            <a href="<?php echo base_url(); ?>dashboard" class="logo">                 
                <?=$this->auth->gettitle();?>
            </a>             
            <nav class="navbar navbar-static-top" role="navigation">                  
                <a href="#"  onclick="collapseSidebar()"  class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="col-md-5 col-sm-3 col-xs-5"> </div>

                <div class="col-md-7 col-sm-9 col-xs-7">
                    <div class="pull-right">   
                     
                        <div class="navbar-custom-menu">
                          
                            <ul class="nav navbar-nav headertopmenu"> 
                            
                                <li class="dropdown user-menu">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                                        <img src="<?=base_url()?>uploads/staff_images/no_image.png" class="topuser-image" alt="User Image">
                                        <?=ucfirst($this->session->userdata('user_type'));?> Login
                                    </a>
                                    <ul class="dropdown-menu dropdown-user menuboxshadow">
                                        <li> 
                                            <div class="sstopuser">
                                                <div class="ssuserleft">   
                                                    <img src="<?=base_url()?>uploads/staff_images/no_image.png" alt="User Image">
                                                </div>

                                                <div class="sstopuser-test">
                                                    <h5><?=ucfirst($this->session->userdata('user_type'));?></h5>   
                                                </div>
                                                <div class="divider"></div>
                                                <div class="sspass">
                                                    <!-- <a href="<?php echo base_url(); ?>changepass"><i class="fa fa-key"></i>Password</a> -->

                                                    <a class="pull-right" href="<?php echo base_url(); ?>index/logout"><i class="fa fa-sign-out fa-fw"></i>Logout</a>
                                                </div>  
                                            </div>
                                        </li>
                                    </ul>                             
                                </li>   
                            </ul>
                        </div>
                    </div>
                </div>   
            </nav>
        </header>

        <?php $this->load->view('includes/sidebar'); ?>
