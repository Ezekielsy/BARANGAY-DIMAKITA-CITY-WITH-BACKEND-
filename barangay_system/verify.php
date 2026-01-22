<?php
include "db/config.php";
$success=false;

if(isset($_GET['code'])){
  $code=$_GET['code'];
  $res=mysqli_query($conn,
    "SELECT * FROM users WHERE verification_code='$code' AND is_verified=0");
  if(mysqli_num_rows($res)==1){
    mysqli_query($conn,
      "UPDATE users SET is_verified=1,verification_code=NULL WHERE verification_code='$code'");
    $success=true;
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Email Verification</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body{font-family:'Segoe UI',Tahoma,sans-serif;background:#f4f6f9}
    .card{border:none;border-radius:1rem}
  </style>
</head>
<body>

<div class="container d-flex justify-content-center align-items-center vh-100">
  <div class="card shadow text-center p-4" style="max-width:420px">

    <?php if($success): ?>
      <h4 class="fw-bold text-success">Email Verified</h4>
      <p>Your account has been successfully activated.</p>
      <a href="login.php" class="btn btn-primary w-100">
        Proceed to Login
      </a>
    <?php else: ?>
      <h4 class="fw-bold text-danger">Verification Failed</h4>
      <p>Invalid or expired verification link.</p>
      <a href="login.php" class="btn btn-secondary w-100">
        Back to Login
      </a>
    <?php endif; ?>

  </div>
</div>

</body>
</html>
