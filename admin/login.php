<?php
include "./dbconnection.php";
$admins = $conn->query("SELECT admin_username,admin_password from admins");
$admins_data = $admins->fetchAll();
session_start();
$msg = "";
if (isset($_POST['login'])) {
  foreach ($admins_data as $admin) {
    if (($admin['admin_username'] == $_POST['username']) && ($admin['admin_password'] == $_POST['password'])) {
      $_SESSION['username'] = $_POST['username'];
      $_SESSION['password'] = $_POST['password'];
      header("Location: users.php");
      exit();
    }
  }
  $msg = "Invalid username or password";
}
$msg2 = "";
if (isset($_POST['sign_up'])) {
  $full_name = $_POST['full_namer'];
  $username = $_POST['usernamer'];
  $email = $_POST['emailr'];
  $pwd = $_POST['passwordr'];
  $pic = addslashes(file_get_contents($_FILES['profile_picture']['tmp_name']));

  $sql = "INSERT INTO admins (admin_full_name,admin_username,admin_email,admin_password,admin_pic)
VALUES('$full_name','$username','$email','$pwd','$pic')";
  $conn->exec($sql);
  $msg2 = "Registration Done Successfully! Now you can login easily";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Wave Cafe Admin | Login/Register</title>

  <!-- Bootstrap -->
  <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <!-- NProgress -->
  <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
  <!-- Animate.css -->
  <link href="vendors/animate.css/animate.min.css" rel="stylesheet">

  <!-- Custom Theme Style -->
  <link href="build/css/custom.min.css" rel="stylesheet">
</head>

<body class="login">
  <div>
    <a class="hiddenanchor" id="signup"></a>
    <a class="hiddenanchor" id="signin"></a>

    <div class="login_wrapper">
      <div class="animate form login_form">
        <section class="login_content">
          <div class="error-message" style='color:red'>
            <?php echo $msg; ?>
          </div>
          <form action="login.php" method="POST">
            <h1>Login Form</h1>
            <div>
              <input type="text" name="username" class="form-control" placeholder="Username" required="" />
            </div>
            <div>
              <input type="password" name="password" class="form-control" placeholder="Password" required="" />
            </div>
            <div>
              <button type="submit" class="btn btn-default submit" name="login">Log in</button>
              <a class="reset_pass" href="#">Lost your password?</a>
            </div>

            <div class="clearfix"></div>

            <div class="separator">
              <p class="change_link">New to site?
                <a href="#signup" class="to_register"> Create Account </a>
              </p>

              <div class="clearfix"></div>
              <br />

              <div>
                <h1><i class="fa fa-user"></i></i> Wave Cafe</h1>
                <p>©2023 All Rights Reserved. Wave Cafe Admins</p>
              </div>
            </div>
          </form>
        </section>
      </div>

      <div id="register" class="animate form registration_form">
        <section class="login_content">
          <div style='color:green'>
            <?php echo $msg2; ?>
          </div>
          <form method="POST" enctype="multipart/form-data">
            <h1>Create Account</h1>
            <div>
              <input type="text" name="full_namer" class="form-control" placeholder="Fullname" required="" />
            </div>
            <div>
              <input type="text" name="usernamer" class="form-control" placeholder="Username" required="" />
            </div>
            <div>
              <input type="email" name="emailr" class="form-control" placeholder="Email" required="" />
            </div>
            <div>
              <input type="password" name="passwordr" class="form-control" placeholder="Password" required="" />
            </div>
            <div>
              <label for="profile_picture">Profile Picture:</label>
              <input type="file" name="profile_picture" id="profile_picture" accept="image/*">
            </div>
            <div>
              <button type="submit" name="sign_up" class="btn btn-default submit">Submit</button>
            </div>

            <div class="clearfix"></div>

            <div class="separator">
              <p class="change_link">Already a member ?
                <a href="#signin" class="to_register"> Log in </a>
              </p>

              <div class="clearfix"></div>
              <br />

              <div>
                <h1><i class="fa fa-user"></i></i> Wave Cafe Admin</h1>
                <p>©2023 All Rights Reserved. Wave Cafe Admins</p>
              </div>
            </div>
          </form>
        </section>
      </div>
    </div>
  </div>
</body>

</html>