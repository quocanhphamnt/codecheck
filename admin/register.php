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
<body class="hold-transition register-page">
    <div class="register-box">
        <div class="card card-outline card-primary">
          <div class="card-header text-center">
            <a href="javascript:;" class="h1">Admin Dashboard</a>
          </div>
          <div class="card-body">
            <p class="login-box-msg">Register a new account</p>

            <form action="" method="POST">
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
              <div class="input-group mb-3">
                <input type="password" class="form-control" name="repassword" placeholder="Re-Password">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                <?php 
                  if (isset($_REQUEST['username'])) {
                    //Check user table if not create table
                    $result = $db->query("SELECT * FROM user");
                    if(!$result){
                      $newTable = $db->query("CREATE TABLE `$dbName`.`user` (`id` INT NOT NULL AUTO_INCREMENT , `username` VARCHAR(50) NOT NULL , `password` VARCHAR(50) NOT NULL , PRIMARY KEY (`id`), UNIQUE (`username`)) ENGINE = InnoDB;");
                    }
                    // removes backslashes
                    $username = stripslashes($_REQUEST['username']);
                    $password = stripslashes($_REQUEST['password']);
                    $repassword = stripslashes($_REQUEST['repassword']);
                    //escapes special characters in a string
                    $username = $db->real_escape_string($username);
                    $password = $db->real_escape_string($password);
                    $repassword = $db->real_escape_string($repassword);
                    //Check all filed blank
                    if(!empty($username) && !empty($password) && !empty($repassword)) {
                      // Check password and re-password
                      if($password===$repassword ) {
                        //Check username already exists in the database
                        $result = $db->query("SELECT username FROM user WHERE username = '".$username."'");
                        if($result->num_rows > 0){
                          $error = "Username already exists";
                        } else{
                          $insert = $db->query("INSERT INTO user (username, password) VALUES ('".$username."','".md5($password)."')");
                          header("Location: login.php");
                        }
                      } else {
                        $error = "Password not match";
                      }
                    } else {
                      $error = "Please filed all blank";
                    }
                    echo "<p class='text-danger m-0'>".$error."</p>";
                  }
                ?>
                  
                </div>
              </div>
              <div class="row">
                <div class="col-8">
                  <div class="icheck-primary">
                    <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                    <label for="agreeTerms">
                    I agree to the <a href="javascript:;">terms</a>
                    </label>
                  </div>
                </div>
                <!-- /.col -->
                <div class="col-4">
                  <button type="submit" class="btn btn-primary btn-block">Register</button>
                </div>
                <!-- /.col -->
              </div>
            </form>
            <a href="login.php" class="text-center">I already have a membership</a>
          </div>
          <!-- /.form-box -->
        </div><!-- /.card -->
      </div>
      <!-- /.register-box -->

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
<script src="js/app.js"></script>

</body>
</html>
