<?php 
  // Load the database configuration file 
  include_once '../dbConfig.php';

  session_start();
  if(!isset($_SESSION["username"])) {
      header("Location: login.php");
      exit();
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>codecheck.marcweissparis</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="css/bootstrap/icons/icons.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="css/bootstrap/toastr.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="css/datatables/dataTables.bootstrap4.css">
  <link rel="stylesheet" href="css/datatables/responsive.bootstrap4.css">
  <link rel="stylesheet" href="css/datatables/buttons.bootstrap4.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="css/bootstrap/adminlte.css">
  <!-- Custom style -->
  <link rel="stylesheet" href="css/style.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed login-page">
  <div class="wrapper" style="width: 100%">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-dark">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="javascript:;" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="index.php" class="nav-link">Home</a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="javascript:;" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="javascript:;" role="button">
            <i class="fas fa-adjust"></i>
          </a>
        </li>
        <li class="nav-item">
          <a  class="nav-link" onclick="document.getElementById('endsession').submit()" role="button">
            <i class="fas fa-ban"></i>
          </a>
          <form method="POST" id="endsession">
            <input type="hidden" name="endsession">
          </form>
          <?php if (isset($_POST['endsession'])){session_destroy(); header("Location: index.php");} ?>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4 text-center">
      <!-- Brand Logo -->
      <a href="index.php" class="brand-link">
        <span class="brand-text font-weight-light">Admin Code Check</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex justify-content-center">
          <div class="image">
            <img src="img/nh23-white.png" class="elevation-2" alt="Image">
          </div>
          <div class="info">
            <a href="javascript:;" class="d-block"><?php echo $_SESSION["username"]; ?></a>
          </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
          <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-sidebar">
                <i class="fas fa-search fa-fw"></i>
              </button>
            </div>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                 with font-awesome or any other icon font library -->
            <li class="nav-item menu-open">
              <a href="javascript:;" class="nav-link active">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Dashboard
                </p>
              </a>
            </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Code List</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
              <li class="breadcrumb-item active">Codelist</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">DataTable</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-12">
                    <h5 class="title">Import</h5>
                    <div class="dt-buttons btn-group flex-wrap">
                      <form action="importData.php" method="post" enctype="multipart/form-data">
                        <input type="submit" class="btn btn-secondary buttons-html5" name="importSubmit" value="Import">
                        <input type="file" class="" name="file" id="fileInput" />
                      </form>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12">
                    <h5 class="title">Export</h5>
                  </div>
                </div>
                <table id="codelist" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>Code</th>
                    <th>Checked</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php
                      // Get code rows 
                      $result = $db->query("SELECT * FROM code ORDER BY id DESC");
                      if($result) {
                        if($result->num_rows > 0){ 
                          foreach($result as $row){
                            ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['checked']; ?></td>
                            </tr>
                            <?php
                          } 
                        }
                      } else {
                        ?>
                        <tr>
                          <td colspan="100%">No code(s) found...</td>
                        </tr>
                        <?php 
                      }
                    ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- Table -->

      </div>
      <!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="js/bootstrap/jquery.js"></script>
<!-- Bootstrap -->
<script src="js/bootstrap/bootstrap.bundle.js"></script>
<!-- Toastr -->
<script src="js/bootstrap/toastr.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="js/datatables/jquery.dataTables.js"></script>
<script src="js/datatables/dataTables.bootstrap4.js"></script>
<script src="js/datatables/dataTables.responsive.js"></script>
<script src="js/datatables/responsive.bootstrap4.js"></script>
<script src="js/datatables/dataTables.buttons.js"></script>
<script src="js/datatables/buttons.bootstrap4.js"></script>
<script src="js/datatables/jszip.js"></script>
<script src="js/datatables/pdfmake.js"></script>
<script src="js/datatables/vfs_fonts.js"></script>
<script src="js/datatables/buttons.html5.js"></script>
<script src="js/datatables/buttons.print.js"></script>
<script src="js/datatables/buttons.colVis.js"></script>
<!-- AdminLTE App -->
<script src="js/bootstrap/adminlte.js"></script>
<!--App -->
<script src="js/main.js"></script>

<?php
  // Get status message 
  if(!empty($_GET['status'])){ 
    switch($_GET['status']){ 
        case 'succ': 
            echo "<script>
                  $(function () {
                    toastr.success('Codes data has been imported successfully.')
                  });
                </script>";
          break; 
        case 'err': 
          echo "<script>
                $(function () {
                  toastr.warning('Something went wrong, please try again.')
                });
            </script>";
        break;  
        case 'invalid_file': 
          echo "<script>
              $(function () {
                toastr.error('Please upload a valid Excel file.');
              });
          </script>";
      break;
    } 
  }
?>

</body>
</html>