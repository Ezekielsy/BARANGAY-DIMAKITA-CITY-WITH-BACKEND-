<?php
session_start();
include "db/config.php";
?>
<!DOCTYPE html>
<html>
<head>
  <title>Administrator Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body{font-family:'Segoe UI',Tahoma,sans-serif;background:#f4f6f9}
    .page-title{font-weight:700;letter-spacing:.6px}
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

          <h4 class="page-title text-center mb-1">Administrator Login</h4>
          <p class="text-muted text-center small mb-3">
            Authorized personnel only
          </p>

          <form method="POST">
            <input type="text" name="user" class="form-control mb-3"
              placeholder="Username" required>
            <input type="password" name="pass" class="form-control mb-3"
              placeholder="Password" required>

            <button name="login" class="btn btn-dark w-100">
              Login
            </button>
          </form>

          <p class="text-center mt-3 small">
            No account?
            <a href="register.php">Register here</a>
          </p>

          <?php
          if (isset($_POST['login'])) {
            $u = mysqli_real_escape_string($conn,$_POST['user']);
            $p = $_POST['pass'];

            $res = mysqli_query($conn,"SELECT * FROM users WHERE username='$u'");
            if (mysqli_num_rows($res)==1) {
              $row = mysqli_fetch_assoc($res);

              if ($row['is_verified']==0) {
                echo "<div class='alert alert-warning mt-3'>
                Please verify your email before logging in.
                </div>";
              } elseif (password_verify($p,$row['password'])) {
                $_SESSION['admin']=$row['id'];
                header("Location: admin.php");
                exit();
              }
            }
            echo "<div class='alert alert-danger mt-3'>
            Invalid username or password.
            </div>";
          }
          ?>

        </div>
      </div>

    </div>
  </div>
</div>

</body>
</html>
