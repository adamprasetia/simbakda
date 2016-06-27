<!DOCTYPE html>
<html>
<head>
  <title><?php echo config_item('app_name') ?></title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <link rel="stylesheet" href="<?php echo base_url("assets/plugins/AdminLTE-2.3.3") ?>/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="<?php echo base_url("assets/plugins/AdminLTE-2.3.3") ?>/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="<?php echo base_url("assets/plugins/AdminLTE-2.3.3") ?>/dist/css/skins/skin-blue.min.css">
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/select2-4.0.3/css/select2.min.css')?>"/>
  <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css')?>"/>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <!-- Main Header -->
  <header class="main-header">

    <!-- Logo -->
    <a href="<?php echo base_url() ?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>SBK</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b><?php echo config_item('app_name') ?></b></span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account Menu -->
          <li class="dropdown user user-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!-- hidden-xs hides the username on small devices so only the image appears. -->
              <span class="hidden-xs"><?php echo $this->user_login['name'] ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- The user image in the menu -->
              <li class="user-header">
                <p>
                  <?php echo $this->user_login['name'] ?>
                  <small><?php echo $this->user_login['level_name'] ?></small>
                </p>
              </li>
              <li class="user-footer">
                <div class="pull-left">
                  <?php echo anchor('change_password',$this->lang->line('change_password'),array('class'=>'btn btn-default btn-flat')) ?>
                </div>
                <div class="pull-right">
                  <?php echo anchor('home/logout',$this->lang->line('logout'),array('class'=>'btn btn-default btn-flat')) ?>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar Menu -->
      <ul class="sidebar-menu">
        <li class="header"><?php echo strtoupper($this->lang->line('menu')) ?></li>
        <li class="treeview <?php echo active_menu('home')?>"><?php echo anchor('home','<i class="fa fa-home"></i> <span>'.$this->lang->line('home').'</span>')?></li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-database"></i> <span><?php echo $this->lang->line('menu_master_data') ?></span> <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li class="treeview">
              <a href="#">
                <i class="fa fa-database"></i> <span>Master Barang Daerah</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li class="<?php echo active_menu('barang_golongan')?>"><?php echo anchor('barang_golongan','<i class="fa fa-circle-o"></i> Golongan Barang')?></li>
                <li class="<?php echo active_menu('barang_bidang')?>"><?php echo anchor('barang_bidang','<i class="fa fa-circle-o"></i> Bidang Barang')?></li>
                <li class="<?php echo active_menu('barang_kelompok')?>"><?php echo anchor('barang_kelompok','<i class="fa fa-circle-o"></i> Kelompok Barang')?></li>
                <li class="<?php echo active_menu('barang_sub_kelompok')?>"><?php echo anchor('barang_sub_kelompok','<i class="fa fa-circle-o"></i> Sub Kelompok Barang')?></li>
                <li class="<?php echo active_menu('barang_sub_sub_kelompok')?>"><?php echo anchor('barang_sub_sub_kelompok','<i class="fa fa-circle-o"></i> Sub-Sub Kelompok Barang')?></li>
              </ul>
            </li>
          </ul>
        </li> 
        <li class="treeview">
          <a href="#">
            <i class="fa fa-book"></i> <span><?php echo $this->lang->line('menu_reference') ?></span> <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li class="<?php echo active_menu('master','barang_jenis')?>"><?php echo anchor('master/barang_jenis','<i class="fa fa-circle-o"></i> Jenis Barang')?></li>
          </ul>
        </li> 
        <?php if ($this->user_login['level']==1): ?>          
        <li class="treeview <?php echo active_menu('user')?>"><?php echo anchor('user','<i class="fa fa-user"></i> <span>'.$this->lang->line('menu_user').'</span>')?></li>
        <?php endif ?>                       
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <?php echo $content ?>
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
      Version 1.0
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2016 <a href="#">Damzsoft</a>.</strong> All rights reserved.
  </footer>

  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 2.2.0 -->
<script src="<?php echo base_url("assets/plugins/AdminLTE-2.3.3") ?>/plugins/jQuery/jQuery-2.2.0.min.js"></script>
<!-- jQuery UI -->
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js" integrity="sha256-xNjb53/rY+WmG+4L6tTl9m6PpqknWZvRt0rO1SRnJzw=" crossorigin="anonymous"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo base_url("assets/plugins/AdminLTE-2.3.3") ?>/bootstrap/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url("assets/plugins/AdminLTE-2.3.3") ?>/dist/js/app.min.js"></script>
<!-- Custom JS -->
<script type="text/javascript" src="<?php echo base_url('assets/plugins/select2-4.0.3/js/select2.min.js')?>"/></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/general.js')?>"/></script>
<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. Slimscroll is required when using the
     fixed layout. -->
<script type="text/javascript">
  $('li.active').parent().parent().addClass('active');
  $('li.active').parent().parent().parent().parent().addClass('active');
</script>     
</body>
</html>
