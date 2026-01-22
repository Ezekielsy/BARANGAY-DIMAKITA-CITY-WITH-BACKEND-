<?php
include "db/config.php";
?>
<!DOCTYPE html>
<html>
<head>
  <title>Register Account</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body{font-family:'Segoe UI',Tahoma,sans-serif;background:#f4f6f9}
    .page-title{font-weight:700}
    .card{border:none;border-radius:1rem}
  </style>
</head>
<body>

<nav class="navbar navbar-dark bg-dark">
  <div class="container">
    <span class="navbar-brand fw-bold">Barangay Dimakita System</span>
  </div>
</nav>

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-4">

      <div class="card shadow">
        <div class="card-body p-4">

          <h4 class="page-title text-center mb-1">
            Create Administrator Account
          </h4>
          <p class="text-muted text-center small mb-3">
            Email verification is required
          </p>

          <form method="POST">
            <input name="fullname" class="form-control mb-3" placeholder="Full Name" required>
            <input name="email" type="email" class="form-control mb-3" placeholder="Email" required>
            <input name="username" class="form-control mb-3" placeholder="Username" required>
            <input name="password" type="password" class="form-control mb-3" placeholder="Password" required>
            <button name="register" class="btn btn-primary w-100">
              Register
            </button>
          </form>

          <?php
          if(isset($_POST['register'])){
            $code = md5(rand());
            $pass = password_hash($_POST['password'],PASSWORD_DEFAULT);

            mysqli_query($conn,"INSERT INTO users
            (fullname,email,username,password,verification_code)
            VALUES
            ('$_POST[fullname]','$_POST[email]','$_POST[username]','$pass','$code')");

            echo "<div class='alert alert-info mt-3'>
            <strong>Email Verification Required</strong><br>
            <a href='verify.php?code=$code'>Click here to verify your account</a>
            </div>";
          }
          ?>

          <p class="text-center small mt-3">
            <a href='login.php'>Back to Login</a>
          </p>

        </div>
      </div>

    </div>
  </div>
</div>

</body>
</html>
