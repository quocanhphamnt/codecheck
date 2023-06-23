<?php 
  // Load the database configuration file 
  include_once '../dbConfig.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" sizes="256x256" href="img/TelesaleLogo.png">
  <title>codecheck.marcweissparis</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="css/bootstrap/icons/icons.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="css/bootstrap/icheck-bootstrap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="css/bootstrap/adminlte.css">
  <!-- Custom style -->
  <link rel="stylesheet" href="css/style.css">
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
          <div class="card-header text-center">
            <a href="javascript:;" class="h1">Admin Dashboard</a>
          </div>
          <div class="card-body">
            <p class="login-box-msg">Sign in to start your session</p>
            <form method="POST">
              <div class="input-group mb-3">
                <input type="text" class="form-control" name="username" placeholder="Username">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-user"></span>
                  </div>
                </div>
              </div>
              <div class="input-group mb-3">
                <input type="password" class="form-control" name="password" placeholder="Password">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                <?php
                  session_start();
                  // When form submitted, check and create user session.
                  if (isset($_POST['username'])) {
                    //Check user table exist
                    $result = $db->query("SELECT * FROM user");
                    if($result){
                      // removes backslashes
                      $username = stripslashes($_REQUEST['username']);
                      $username = $db->real_escape_string($username);
                      $password = stripslashes($_REQUEST['password']);
                      $password = $db->real_escape_string($password);
                      // Check user is exist in the database
                      $result = $db->query("SELECT * FROM user WHERE username = '".$username."' AND password ='".md5($password)."'");
                      if($result->num_rows > 0) {
                        $_SESSION['username'] = $username;
                        // Redirect to admin dashboard
                        header("Location: index.php");
                      } else {
                        echo "<p class='text-danger'>Incorrect Username/password.</p>";
                      }
                    } else {
                      echo "<p class='text-danger'>Please Register first.</p>";
                    }
                  }
                ?>
                </div>
              </div>
              <div class="row">
                <div class="col-8">
                  <div class="icheck-primary">
                    <input type="checkbox" id="remember">
                    <label for="remember">
                      Remember Me
                    </label>
                  </div>
                </div>
                <!-- /.col -->
                <div class="col-4">
                  <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                </div>
                <!-- /.col -->
              </div>
            </form>
            <p class="mb-1">
              <a href="javascript:;">I forgot my password</a>
            </p>
            <p class="mb-0">
              <a href="register.php" class="text-center">Register a new membership</a>
            </p>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.login-box -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="js/bootstrap/jquery.js"></script>
<!-- Bootstrap -->
<script src="js/bootstrap/bootstrap.bundle.js"></script>
<!-- AdminLTE App -->
<script src="js/bootstrap/adminlte.js"></script>
<!-- AdminLTE Control Sidebar -->
<script src="js/dashboard.js"></script>

<!-- Telesale App -->
<script src="app.js"></script>

</body>
</html>
