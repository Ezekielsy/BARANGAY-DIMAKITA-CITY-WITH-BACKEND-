<?php
session_start();
include "db/config.php";

if (!isset($_SESSION['admin'])) {
  header("Location: login.php");
  exit();
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Change Password</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<nav class="navbar navbar-dark bg-dark">
  <div class="container d-flex justify-content-between">
    <span class="navbar-brand fw-bold">Barangay System</span>
    <a href="admin.php" class="btn btn-outline-light btn-sm">Back</a>
  </div>
</nav>

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-4">

      <div class="card shadow rounded-4">
        <div class="card-body p-4">

          <h4 class="fw-bold text-center mb-3">Change Password</h4>

          <form method="POST">
            <input type="password" name="old" class="form-control mb-3" placeholder="Old Password" required>
            <input type="password" name="new" class="form-control mb-3" placeholder="New Password" required>
            <button name="change" class="btn btn-warning w-100">Change</button>
          </form>

          <?php
          if (isset($_POST['change'])) {
            $id = $_SESSION['admin'];

            $res = mysqli_query($conn,
              "SELECT password FROM users WHERE id=$id");
            $row = mysqli_fetch_assoc($res);

            if (password_verify($_POST['old'], $row['password'])) {
              $newPass = password_hash($_POST['new'], PASSWORD_DEFAULT);
              mysqli_query($conn,
                "UPDATE users SET password='$newPass' WHERE id=$id");

              echo "<div class='alert alert-success mt-3'>Password Updated</div>";
            } else {
              echo "<div class='alert alert-danger mt-3'>Wrong Old Password</div>";
            }
          }
          ?>

        </div>
      </div>

    </div>
  </div>
</div>

<footer class="text-center mt-5 text-muted">
  © 2026 Barangay Document System
</footer>

</body>
</html>
