<?php
error_reporting(0);
session_start();
include_once 'config/koneksi.php';
include_once 'controllers/usersclass.php';
include_once 'controllers/barangclass.php';
include_once 'controllers/permohonanclass.php';
include_once 'controllers/barangmasukclass.php';
include_once 'controllers/barangkeluarclass.php';
include_once 'controllers/satuanclass.php';
include_once 'controllers/opnameclass.php';

$db = new Database();

// koneksi ke MySQL via method
$db->connectMySQLi();

$user     	= new User();
$barang   	= new Barang();
$barangin 	= new BarangMasuk();
$barangout	= new BarangKeluar();
$satuan   	= new Satuan();
$permohonan = new Permohonan();

$iduser = $_SESSION['idQC'];
$idsub=$_SESSION['subQC'];
if (!$user->get_sesi()) {
    header("location:index");
}
if ($_GET['page'] == 'logout') {
    $user->user_logout();
    header("location:index");
}
?>
<?php
//set base constant
if (!isset($_SESSION['userQC'])) {
    ?>
<script>setTimeout("location.href='./index'",500);</script>
<?php
 die('Illegal Acces');
} elseif (!isset($_SESSION['passQC'])) {
    ?>
<script>setTimeout("location.href='./lockscreen'",500);</script>
<?php
 die('Illegal Acces');
}
//request page
$page = isset($_GET['page'])?$_GET['page']:'';
$act  = isset($_GET['act'])?$_GET['act']:'';
$id   = isset($_GET['id'])?$_GET['id']:'';
$page = strtolower($page);
?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>GKG Stock | <?php echo $page; ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="bower_components/select2/dist/css/select2.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- X Editable -->
  <link href="bower_components/editable/bootstrap-editable.css" rel="stylesheet"/>
  <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect. -->
  <link rel="stylesheet" href="dist/css/skins/skin-red-light.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <!-- <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic"> -->
        <style>
            body{
      		font-family: Calibri, "sans-serif", "Courier New";  /* "Calibri Light","serif" */
      		font-style: normal;
      	}
			
    		.blink_me {
            animation: blinker 1s linear infinite;
        }

        .bulat {
            border-radius: 50%;
        }

        .border-dashed {
            border: 3px dashed #083255;
        }

        .border-dashed-tujuan {
            border: 3px dashed #FF0007;
        }

        @keyframes blinker {
            50% {
                opacity: 0;
            }
        }
      </style>
  <link rel="icon" type="image/png" href="dist/img/index.ico">
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->

<body class="hold-transition skin-red-light sidebar-mini fixed">
  <div class="wrapper">

    <!-- Main Header -->
    <header class="main-header">

      <!-- Logo -->
      <a href="home" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>GKG</b>STK BS</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>GKG</b>STOCK BS</span>
      </a>
      <?php $JmlRow= $barang->jmlMinRow($idsub);?>
      <!-- Header Navbar -->
      <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
          <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-primary  <?php if($JmlRow>0){ echo "blink_me"; } ?> "><?php echo $JmlRow; ?></span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">Ada <?php echo "<b><font color=red>".$JmlRow."</font></b>"; ?> Barang yang harus ditambah</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <?php foreach($barang->cekMinimal($idsub) as $rowd){ ?>
                  <li>
                    <a href="#" class="open_addstokin" id="<?php echo $rowd['id'];?>">
                      <i class="fa fa-warning text-yellow  blink_me"></i> <?php echo "Kode <b>".$rowd['kode']."</b>, Min Atas ".$rowd['jumlah_min_a']." ".$rowd['satuan'];?>
                    </a>
                  </li>
                <?php } ?>
               </ul>
              </li>
              <li class="footer"><a href="#">View all</a></li>
            </ul>
          </li>
            <!-- User Account Menu -->
            <li class="dropdown user user-menu">
              <!-- Menu Toggle Button -->
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <!-- The user image in the navbar-->
                <img src="dist/img/<?php echo $_SESSION['fotoQC']; ?>" class="user-image" alt="User Image">
                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                <span class="hidden-xs">
                  <?php echo strtoupper($_SESSION['userQC']);?></span>
              </a>
              <ul class="dropdown-menu">
                <!-- The user image in the menu -->
                <li class="user-header">
                  <img src="dist/img/<?php echo $_SESSION['fotoQC']; ?>" class="img-circle" alt="User Image">

                  <p>
                    <?php echo strtoupper($_SESSION['userQC']);?> -
                    <?php echo $_SESSION['jabatanQC']; ?>
                    <small>Member since
                      <?php echo $_SESSION['mamberQC']; ?></small>
                  </p>
                </li>
                <!-- Menu Body -->
                 <li class="user-body">
                <div class="row">
                  <div class="col-xs-8 pull-right">
                    <a href="#" id='<?php echo $iduser; ?>' class="btn btn-default open_change_password">Change Password</a>
                  </div>
                  <!-- <div class="col-xs-4 text-center">
                    <a href="#">Sales</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Friends</a>
                  </div> -->
                </div>
                <!-- /.row -->
            </li>
            <!-- Menu Footer-->
            <li class="user-footer">
              <div class="pull-left">
                <a href="lockscreen" class="btn btn-default btn-flat">LockScreen</a>
              </div>
              <div class="pull-right">
                <a href="logout" class="btn btn-default btn-flat">Sign out</a>
              </div>
            </li>
          </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <!-- <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li> -->
          </ul>
        </div>
      </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">

      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
          <div class="pull-left image">
            <img src="dist/img/<?php echo $_SESSION['fotoQC']; ?>" class="img-circle" alt="User Image">
          </div>
          <div class="pull-left info">
            <p>
              <?php echo strtoupper($_SESSION['userQC']);?>
            </p>
            <!-- Status -->
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
          </div>
        </div>
        <!-- search form (Optional) -->
        <!--<form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
              </button>
            </span>
        </div>
      </form>-->
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
          <li class="header">SUB DEPT: <?php echo $_SESSION['subQC']; ?></li>
          <!-- Optionally, you can add icons to the links -->
          <li class="<?php if ($page=="home" or $page=="" ) { echo"active"; } ?>"><a href="home"><i class="fa fa-dashboard text-black"></i> <span>DashBoard</span></a></li>
          <li class="treeview <?php if ($page=="barang" or $page=="stok-in" or $page=="stok-out" or $page=="lapstok-in" or $page=="lapstok-out" or $page=="stok-opname" or $page=="lapstok-opname" ) { echo"active"; }?>">
            <a href="#"><i class="fa fa-database text-blue"></i> <span>Stock</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li class="<?php if ($page=="barang") { echo"active"; } ?>"><a href="barang"><i class="fa fa-bank text-purple"></i> <span>Data Stock</span></a></li>
			  <!-- <?php if($_SESSION['lvlQC']!=3) {?>
			  <li class="<?php if ($page=="permohonan") { echo"active"; } ?>"><a href="permohonan"><i class="fa fa-file text-yellow"></i> <span>Bon Permohonan</span></a></li>		
			  <?php  } ?> -->
			  <li class="<?php if ($page=="stok-in") { echo"active"; } ?>"><a href="stok-in"><i class="fa fa-arrow-left text-green"></i> <span>Stock In</span></a></li>
              <li class="<?php if ($page=="stok-out") { echo"active"; } ?>"><a href="stok-out"><i class="fa fa-arrow-right text-red"></i> <span>Stock Out</span></a></li>
               <?php if($_SESSION['lvlQC']!=3) {?>
			  <li class="<?php if ($page=="stok-opname") { echo"active"; } ?>"><a href="stok-opname"><i class="fa fa-exchange text-blue"></i> <span>Opname</span></a></li>
			   <?php  } ?>
			  <li class="<?php if ($page=="kartu-stok") { echo"active"; } ?>"><a href="kartu-stok"><i class="fa fa-file text-yellow"></i> <span>Kartu Stok</span></a></li>
			 <li class="treeview <?php if ($page=="lapstok-in" or $page=="lapstok-out") { echo"active"; } ?>">
                <a href="#"><i class="fa fa-bar-chart text-navy"></i> Reports
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <li class="<?php if ($page=="lapstok-in") { echo"active"; } ?>">
                    <a href="lapstok-in"><i class="fa fa-arrow-left text-green"></i> <span>LapStock In</span></a>
                  </li>
                  <li class="<?php if ($page=="lapstok-out") { echo"active"; } ?>">
                    <a href="lapstok-out"><i class="fa fa-arrow-right text-red"></i> <span>LapStock Out</span></a>
                  </li>
                  
                </ul>
              </li>
			  
			  
			  
			  
            </ul>
          </li>
		  
		  
		   <li class="treeview <?php if ($page=="bs-barang" or $page=="bs-suratjalan" or $page=="bs-suratjalan-out") { echo"active"; } ?>">
                <a href="#"><i class="fa fa-bank text-purple"></i> BS
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <li class="<?php if ($page=="bs-barang") { echo"active"; } ?>">
                    <a href="bs-barang"><i class="fa fa-file text-yellow"></i> <span>Barang BS</span></a>
                  </li>
				  
				   <li class="<?php if ($page=="bs-suratjalan") { echo"active"; } ?>">
                    <a href="bs-suratjalan"><i class="fa fa-arrow-left text-green"></i> <span>IN</span></a>
                  </li>
				  
				   <li class="<?php if ($page=="bs-suratjalan-out") { echo"active"; } ?>">
                    <a href="bs-suratjalan-out"><i class="fa fa-arrow-right text-red"></i> <span>OUT</span></a>
                  </li>
               
               
                  
                </ul>
              </li>
			  
			  
          <?php if ($_SESSION['lvlQC']=="1") { ?>
          <li class="treeview <?php if ($page=="user" or $page=="satuan") { echo"active"; } ?>">
            <a href="#"><i class="fa fa-folder text-yellow"></i> <span>Masters</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">

              <li class="<?php if ($page=="user") { echo"active"; } ?>"><a href="user"><i class="fa fa-user text-navy"></i> <span>User</span></a></li>
              <li class="<?php if ($page=="satuan") { echo"active"; } ?>"><a href="satuan"><i class="fa fa-circle text-orange"></i> <span>Satuan</span></a></li>
            </ul>
          </li>
            <?php } ?>
        </ul>
        <!-- /.sidebar-menu -->
      </section>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          <?php echo ucwords($_GET['page']);?>
          <small></small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="home"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">Here</li>
        </ol>
      </section>

      <!-- Main content -->
      <section class="content container-fluid">

        <?php
          if (!empty($page) and !empty($act)) {
              $files = 'views/pages/'.$page.'.'.$act.'.php';
          } elseif (!empty($page)) {
              $files = 'views/pages/'.$page.'.php';
          } else {
              $files = 'views/pages/home.php';
          }

          if (file_exists($files)) {
              include_once($files);
          } else {
              include_once("blank.php");
          }
         ?>

      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer">
      <!-- To the right -->
      <div class="pull-right hidden-xs">
        DIT
      </div>
      <!-- Default to the left -->
      <strong>Copyright &copy; 2019 <a href="#">Indo Taichen Textile Industry</a>.</strong> All rights reserved.
    </footer>

    <div class="control-sidebar-bg"></div>
  </div>
  <!-- ./wrapper -->
  <!-- Modal Popup untuk Change Password-->
  <div id="ChangePassword" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  </div>
  <div id="StokInAdd" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  </div>
  <!-- REQUIRED JS SCRIPTS -->

  <!-- jQuery 3 -->
  <script src="bower_components/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>
  <!-- DataTables -->
  <script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
  <!-- Select2 -->
  <script src="bower_components/select2/dist/js/select2.full.min.js"></script>
  <!-- bootstrap datepicker -->
  <script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
  <!-- date-range-picker -->
  <script src="bower_components/moment/min/moment.min.js"></script>
  <script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
  <!-- Slimscroll -->
  <script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
  <!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. -->
  <script src="bower_components/editable/bootstrap-editable.min.js"></script>

  <script>
    //Date picker
    $('#datepicker').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
        todayHighlight: true,
      }),
      //Date picker
      $('#datepicker1').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
        todayHighlight: true,
      }),
      //Date picker
      $('#datepicker2').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
        todayHighlight: true,
      }),
      //Date picker
      $('#datepicker3').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
        todayHighlight: true,
      }),
      $('#reservation').daterangepicker()
  </script>
  <script>
    $(function() {

      $('#example1').DataTable({})
      $('#example2').DataTable()
      $('#example3').DataTable({})
	  $("#example4").DataTable({
        'paging': true,
		dom: 'Bfrtip',
        buttons: [
          'excel',
        ]  
      })	
	  $('.example_allpage').DataTable({
    "pageLength": -1
})

    })
    $(function () {
   //Initialize Select2 Elements
   $('.select2').select2()
 });
	$(function () {
   //Initialize Select2 Elements
   $('.select2t').select2()
 });  
  </script>
  <!-- Javascript untuk popup modal Edit-->
  <script type="text/javascript">
	
	$(document).on('click', '.open_detailbarang', function(e) {
      var m = $(this).attr("id");
      $.ajax({
        url: "views/pages/barang_detail.php",
        type: "GET",
        data: {
          id: m,
        },
        success: function(ajaxData) {
          $("#BarangEdit").html(ajaxData);
          $("#BarangEdit").modal('show', {
            backdrop: 'true'
          });
        }
      });
    });
	
	
    $(document).on('click', '.open_editbarang', function(e) {
      var m = $(this).attr("id");
      $.ajax({
        url: "views/pages/barang_edit.php",
        type: "GET",
        data: {
          id: m,
        },
        success: function(ajaxData) {
          $("#BarangEdit").html(ajaxData);
          $("#BarangEdit").modal('show', {
            backdrop: 'true'
          });
        }
      });
    }); 
	$(document).on('click', '.add_detail_permohonan', function(e) {
      var m = $(this).attr("id");
      $.ajax({
        url: "views/pages/permohonan_add.php",
        type: "GET",
        data: {
          id: m,
        },
        success: function(ajaxData) {
          $("#PermohonanDetailAdd").html(ajaxData);
          $("#PermohonanDetailAdd").modal('show', {
            backdrop: 'true'
          });
        }
      });
    });
	$(document).on('click', '.open_detailmohon', function(e) {
      var m = $(this).attr("id");
      $.ajax({
        url: "views/pages/detail_mohon.php",
        type: "GET",
        data: {
          id: m,
        },
        success: function(ajaxData) {
          $("#PermohonanDetail").html(ajaxData);
          $("#PermohonanDetail").modal('show', {
            backdrop: 'true'
          });
        }
      });
    }); 
	$(document).on('click', '.open_editpermohonan', function(e) {
      var m = $(this).attr("id");
      $.ajax({
        url: "views/pages/permohonan_edit.php",
        type: "GET",
        data: {
          id: m,
        },
        success: function(ajaxData) {
          $("#PermohonanEdit").html(ajaxData);
          $("#PermohonanEdit").modal('show', {
            backdrop: 'true'
          });
        }
      });
    });  
    $(document).on('click', '.open_addstokin', function(e) {
      var m = $(this).attr("id");
      $.ajax({
        url: "views/pages/stok-in_add.php",
        type: "GET",
        data: {
          id: m,
        },
        success: function(ajaxData) {
          $("#StokInAdd").html(ajaxData);
          $("#StokInAdd").modal('show', {
            backdrop: 'true'
          });
        }
      });
    });
    $(document).on('click', '.open_editstokin', function(e) {
      var m = $(this).attr("id");
      $.ajax({
        url: "views/pages/stok-in_edit.php",
        type: "GET",
        data: {
          id: m,
        },
        success: function(ajaxData) {
          $("#StokInEdit").html(ajaxData);
          $("#StokInEdit").modal('show', {
            backdrop: 'true'
          });
        }
      });
    });
    $(document).on('click', '.open_editstokout', function(e) {
      var m = $(this).attr("id");
      $.ajax({
        url: "views/pages/stok-out_edit.php",
        type: "GET",
        data: {
          id: m,
        },
        success: function(ajaxData) {
          $("#StokOutEdit").html(ajaxData);
          $("#StokOutEdit").modal('show', {
            backdrop: 'true'
          });
        }
      });
    });

    $(document).ready(function () {
    $('.ubah_lokasi').editable({
        type: 'text',
        disabled: false,
        url: 'views/pages/editable/editable_posisi.php',
      });
    });


    $(document).on('click', '.user_edit', function(e) {
      var m = $(this).attr("id");
      $.ajax({
        url: "views/pages/user_edit.php",
        type: "GET",
        data: {
          id: m,
        },
        success: function(ajaxData) {
          $("#UserEdit").html(ajaxData);
          $("#UserEdit").modal('show', {
            backdrop: 'true'
          });
        }
      });
    });
    $(document).on('click', '.open_change_password', function(e) {
      var m = $(this).attr("id");
      $.ajax({
        url: "views/pages/change_password.php",
        type: "GET",
        data: {
          id: m,
        },
        success: function(ajaxData) {
          $("#ChangePassword").html(ajaxData);
          $("#ChangePassword").modal('show', {
            backdrop: 'true'
          });
        }
      });
    });
    $(document).on('click', '.satuan_edit', function(e) {
      var m = $(this).attr("id");
      $.ajax({
        url: "views/pages/satuan_edit.php",
        type: "GET",
        data: {
          id: m,
        },
        success: function(ajaxData) {
          $("#SatuanEdit").html(ajaxData);
          $("#SatuanEdit").modal('show', {
            backdrop: 'true'
          });
        }
      });
    });
    $(document).on('click', '.open_detailinout', function(e) {
      var m = $(this).attr("id");
      $.ajax({
        url: "views/pages/detailin_out.php",
        type: "GET",
        data: {
          id: m,
        },
        success: function(ajaxData) {
          $("#DetailInOut").html(ajaxData);
          $("#DetailInOut").modal('show', {
            backdrop: 'true'
          });
        }
      });
    });
  </script>

</body>

</html>
