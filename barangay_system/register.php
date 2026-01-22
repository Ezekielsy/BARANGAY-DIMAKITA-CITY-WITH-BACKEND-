<?php
include "db/config.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register Account</title>
  
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      /* Same gradient as Login for seamless transition */
      background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px 0;
    }

    .card {
      border: none;
      border-radius: 20px;
      box-shadow: 0 15px 35px rgba(0,0,0,0.2);
      overflow: hidden;
      width: 100%;
      max-width: 450px;
    }

    .card-header-custom {
      background: #fff;
      padding: 30px 30px 10px;
      text-align: center;
    }

    .icon-circle {
      width: 60px;
      height: 60px;
      background: #e3f2fd;
      color: #2a5298;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.8rem;
      margin: 0 auto 15px;
    }

    .form-control {
      border-radius: 10px;
      padding: 12px;
      padding-left: 45px; /* Space for icon */
      background-color: #f8f9fa;
      border: 1px solid #e9ecef;
      transition: all 0.3s;
    }

    .form-control:focus {
      background-color: #fff;
      border-color: #2a5298;
      box-shadow: 0 0 0 4px rgba(42, 82, 152, 0.1);
    }

    /* Input Icon Positioning */
    .input-group-custom {
      position: relative;
      margin-bottom: 15px;
    }
    .input-icon {
      position: absolute;
      left: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: #6c757d;
      z-index: 10;
    }

    .btn-register {
      background: #2a5298;
      border: none;
      padding: 12px;
      border-radius: 10px;
      font-weight: 600;
      letter-spacing: 0.5px;
      transition: all 0.3s;
      width: 100%;
      color: white;
      margin-top: 10px;
    }
    
    .btn-register:hover {
      background: #1e3c72;
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(30, 60, 114, 0.3);
    }

    a {
      text-decoration: none;
      color: #2a5298;
      font-weight: 600;
    }
  </style>
</head>
<body>

<div class="container d-flex justify-content-center">
    
  <div class="card p-2">
    
    <div class="card-header-custom">
      <div class="icon-circle">
        <i class="bi bi-person-plus-fill"></i>
      </div>
      <h4 class="fw-bold text-dark">Create Admin Account</h4>
      <p class="text-muted small">Verification is required after registration.</p>
    </div>

    <div class="card-body px-4 pb-4">

      <form method="POST">
        
        <!-- Full Name -->
        <div class="input-group-custom">
          <i class="bi bi-person-vcard input-icon"></i>
          <input name="fullname" class="form-control" placeholder="Full Name" required>
        </div>

        <!-- Email -->
        <div class="input-group-custom">
          <i class="bi bi-envelope-at input-icon"></i>
          <input name="email" type="email" class="form-control" placeholder="Email Address" required>
        </div>

        <!-- Username -->
        <div class="input-group-custom">
          <i class="bi bi-person input-icon"></i>
          <input name="username" class="form-control" placeholder="Username" required>
        </div>

        <!-- Password -->
        <div class="input-group-custom">
          <i class="bi bi-lock input-icon"></i>
          <input name="password" type="password" class="form-control" placeholder="Password" required>
        </div>

        <button name="register" class="btn btn-register">
          Create Account
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

        // Improved Alert Styling
        echo "
        <div class='alert alert-success mt-4 border-0 shadow-sm'>
          <div class='d-flex'>
             <div class='me-3'><i class='bi bi-send-check-fill fs-3'></i></div>
             <div>
                <strong>Verify Your Email</strong><br>
                <span class='small'>For exhibit purposes, verify instantly:</span><br>
                <a href='verify.php?code=$code' class='fw-bold text-decoration-underline text-success'>Click to Verify Account</a>
             </div>
          </div>
        </div>";
      }
      ?>

      <div class="text-center mt-4 pt-3 border-top">
        <span class="text-muted small">Already have an account?</span>
        <div class="mt-1">
            <a href='login.php'><i class="bi bi-arrow-left"></i> Back to Login</a>
        </div>
      </div>

    </div>
  </div>

</div>

</body>
</html>