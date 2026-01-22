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
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Email Verification</title>
  
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      /* Same gradient as login/index for consistency */
      background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .card {
      border: none;
      border-radius: 20px;
      box-shadow: 0 15px 35px rgba(0,0,0,0.2);
      overflow: hidden;
      width: 100%;
      max-width: 450px;
    }

    .icon-box {
      font-size: 5rem;
      margin-bottom: 20px;
      animation: popIn 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .btn-primary {
      background: #2a5298;
      border: none;
      padding: 12px;
      border-radius: 10px;
      font-weight: 600;
      transition: all 0.3s;
    }
    .btn-primary:hover {
      background: #1e3c72;
      transform: translateY(-2px);
    }

    @keyframes popIn {
      0% { opacity: 0; transform: scale(0.5); }
      100% { opacity: 1; transform: scale(1); }
    }
  </style>
</head>
<body>

<div class="container d-flex justify-content-center">
  <div class="card p-5 text-center">

    <?php if($success): ?>
      
      <!-- SUCCESS STATE -->
      <div class="mb-4">
        <div class="icon-box text-success">
          <i class="bi bi-check-circle-fill"></i>
        </div>
        <h3 class="fw-bold text-dark">Verification Successful!</h3>
        <p class="text-muted">
          Your email has been verified. You now have full access to the Administrator Dashboard.
        </p>
      </div>
      
      <a href="login.php" class="btn btn-primary w-100 shadow-sm">
        <i class="bi bi-box-arrow-in-right me-2"></i> Proceed to Login
      </a>

    <?php else: ?>
      
      <!-- FAILURE STATE -->
      <div class="mb-4">
        <div class="icon-box text-danger opacity-75">
          <i class="bi bi-x-circle-fill"></i>
        </div>
        <h3 class="fw-bold text-dark">Verification Failed</h3>
        <p class="text-muted">
          The verification link is invalid, expired, or the account has already been activated.
        </p>
      </div>

      <a href="login.php" class="btn btn-outline-secondary w-100 rounded-3">
        <i class="bi bi-arrow-left me-2"></i> Return to Login
      </a>

    <?php endif; ?>

  </div>
</div>

</body>
</html>