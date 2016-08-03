<!DOCTYPE html>
<html>
<head>
  <title><?php echo config_item('app_name') ?></title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <link rel="stylesheet" href="<?php echo base_url("assets/plugins/jquery-ui-1.11.2/jquery-ui.min.css") ?>">
  <link rel="stylesheet" href="<?php echo base_url("assets/plugins/AdminLTE-2.3.3/bootstrap/css/bootstrap.min.css") ?>">
  <link rel="stylesheet" href="<?php echo base_url("assets/plugins/font-awesome-4.6.3/css/font-awesome.min.css") ?>">
  <link rel="stylesheet" href="<?php echo base_url("assets/plugins/ionicons-2.0.1/css/ionicons.min.css") ?>">
  <link rel="stylesheet" href="<?php echo base_url("assets/plugins/AdminLTE-2.3.3/dist/css/AdminLTE.min.css") ?>">
  <link rel="stylesheet" href="<?php echo base_url("assets/plugins/AdminLTE-2.3.3/dist/css/skins/skin-blue.min.css") ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/select2-4.0.3/css/select2.min.css')?>"/>
  <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css')?>"/>
  
  <script type="text/javascript" src="<?php echo base_url("assets/plugins/AdminLTE-2.3.3/plugins/jQuery/jQuery-2.2.0.min.js") ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/plugins/select2-4.0.3/js/select2.min.js')?>"/></script>
  <script type="text/javascript" src="<?php echo base_url("assets/plugins/jquery-ui-1.11.2/jquery-ui.min.js") ?>"></script>
  <script type="text/javascript" src="<?php echo base_url("assets/plugins/AdminLTE-2.3.3/bootstrap/js/bootstrap.min.js") ?>"></script>
  <script type="text/javascript" src="<?php echo base_url("assets/plugins/AdminLTE-2.3.3/dist/js/app.min.js") ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/plugins/price_format_plugin.js')?>"/></script>
  <script type="text/javascript" src="<?php echo base_url('assets/js/general.js')?>"/></script>  
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
  <header class="main-header">
    <a href="<?php echo base_url() ?>" class="logo">
      <span class="logo-mini"><b>SBK</b></span>
      <span class="logo-lg"><b><?php echo config_item('app_name') ?></b></span>
    </a>
    <nav class="navbar navbar-static-top" role="navigation">
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <span class="hidden-xs"><?php echo $this->user_login['name'] ?></span>
            </a>
            <ul class="dropdown-menu">
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
  <aside class="main-sidebar">
    <section class="sidebar">
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
            <li class="<?php echo active_menu('kabupaten')?>"><?php echo anchor('kabupaten','<i class="fa fa-circle-o"></i> Master Kabupaten')?></li>
            <li class="<?php echo active_menu('bidang_unit')?>"><?php echo anchor('bidang_unit','<i class="fa fa-circle-o"></i> Master Unit Bidang')?></li>
            <li class="<?php echo active_menu('bidang_unit_kerja')?>"><?php echo anchor('bidang_unit_kerja','<i class="fa fa-circle-o"></i> Master Unit Kerja')?></li>
            <li class="<?php echo active_menu('bidang_unit_kerja_lokasi')?>"><?php echo anchor('bidang_unit_kerja_lokasi','<i class="fa fa-circle-o"></i> Master Lokasi')?></li>
            <li class="<?php echo active_menu('bidang_unit_kerja_ruangan')?>"><?php echo anchor('bidang_unit_kerja_ruangan','<i class="fa fa-circle-o"></i> Master Ruangan')?></li>
            <li class="<?php echo active_menu('perusahaan_rekanan')?>"><?php echo anchor('perusahaan_rekanan','<i class="fa fa-circle-o"></i> Perusahaan Rekanan')?></li>
          </ul>
        </li> 
        <li class="treeview">
          <a href="#">
            <i class="fa fa-tasks"></i> <span><?php echo $this->lang->line('menu_transaction') ?></span> <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li class="<?php echo active_menu('rencana_pengadaan_barang')?>"><?php echo anchor('rencana_pengadaan_barang','<i class="fa fa-circle-o"></i> Rencana Pengadaan Barang')?></li>
            <li class="<?php echo active_menu('rencana_pemeliharaan_barang')?>"><?php echo anchor('rencana_pemeliharaan_barang','<i class="fa fa-circle-o"></i> Rencana Pemeliharaan Barang')?></li>
            <li class="<?php echo active_menu('formulir_isian_pengadaan_barang')?>"><?php echo anchor('formulir_isian_pengadaan_barang','<i class="fa fa-circle-o"></i> Formulir Isisan Pengadaan Barang')?></li>
          </ul>
        </li> 
        <li class="treeview">
          <a href="#">
            <i class="fa fa-book"></i> <span><?php echo $this->lang->line('menu_reference') ?></span> <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li class="<?php echo active_menu('reference','barang_jenis')?>"><?php echo anchor('reference/barang_jenis','<i class="fa fa-circle-o"></i> Jenis Barang')?></li>
            <li class="<?php echo active_menu('reference','provinsi')?>"><?php echo anchor('reference/provinsi','<i class="fa fa-circle-o"></i> Provinsi')?></li>
            <li class="<?php echo active_menu('reference','pemilik')?>"><?php echo anchor('reference/pemilik','<i class="fa fa-circle-o"></i> Pemilik')?></li>
            <li class="<?php echo active_menu('reference','bidang')?>"><?php echo anchor('reference/bidang','<i class="fa fa-circle-o"></i> Bidang')?></li>
            <li class="<?php echo active_menu('reference','satuan')?>"><?php echo anchor('reference/satuan','<i class="fa fa-circle-o"></i> Satuan')?></li>
            <li class="<?php echo active_menu('reference','warna')?>"><?php echo anchor('reference/warna','<i class="fa fa-circle-o"></i> Warna')?></li>
            <li class="<?php echo active_menu('reference','pangkat')?>"><?php echo anchor('reference/pangkat','<i class="fa fa-circle-o"></i> Pangkat')?></li>
            <li class="<?php echo active_menu('reference','perusahaan_bentuk')?>"><?php echo anchor('reference/perusahaan_bentuk','<i class="fa fa-circle-o"></i> Bentuk Perusahaan')?></li>
            <li class="<?php echo active_menu('reference','bank')?>"><?php echo anchor('reference/bank','<i class="fa fa-circle-o"></i> Bank')?></li>
            <li class="<?php echo active_menu('reference','tahun_anggaran')?>"><?php echo anchor('reference/tahun_anggaran','<i class="fa fa-circle-o"></i> Tahun Anggaran')?></li>
            <li class="<?php echo active_menu('reference','jenis_dana')?>"><?php echo anchor('reference/jenis_dana','<i class="fa fa-circle-o"></i> Jenis Dana')?></li>
            <li class="<?php echo active_menu('reference','bukti_pembayaran')?>"><?php echo anchor('reference/bukti_pembayaran','<i class="fa fa-circle-o"></i> Bukti Pembayaran')?></li>
            <li class="<?php echo active_menu('reference','cara_perolehan')?>"><?php echo anchor('reference/cara_perolehan','<i class="fa fa-circle-o"></i> Cara Perolehan')?></li>
            <li class="<?php echo active_menu('reference','dasar_perolehan')?>"><?php echo anchor('reference/dasar_perolehan','<i class="fa fa-circle-o"></i> Dasar Perolehan')?></li>
          </ul>
        </li> 
        <?php if ($this->user_login['level']==1): ?>          
        <li class="treeview <?php echo active_menu('users')?>"><?php echo anchor('users','<i class="fa fa-user"></i> <span>'.$this->lang->line('menu_user').'</span>')?></li>
        <?php endif ?>                       
      </ul>
    </section>
  </aside>

  <div class="content-wrapper">
    <?php echo $content ?>
  </div>

  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      Version 1.0
    </div>
    <strong>Copyright &copy; 2016 <a href="#">Damzsoft</a>.</strong> All rights reserved.
  </footer>
  <div class="control-sidebar-bg"></div>
</div>
<script type="text/javascript">
  $('li.active').parent().parent().addClass('active');
  $('li.active').parent().parent().parent().parent().addClass('active');
</script>     
</body>
</html>
