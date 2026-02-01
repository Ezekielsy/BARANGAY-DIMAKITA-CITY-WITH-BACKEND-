<?php
session_start();
include "db/config.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Administrator Login</title>
  
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      /* Gradient Background matching the main site */
      background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
      height: 100vh; /* Full viewport height */
      display: flex;
      align-items: center;
      justify-content: center;
    }

    /* Glassmorphism Card Effect */
    .login-card {
      background: rgba(255, 255, 255, 0.95);
      border-radius: 20px;
      box-shadow: 0 15px 35px rgba(0,0,0,0.2);
      border: none;
      overflow: hidden;
      width: 100%;
      max-width: 400px;
    }

    .login-header {
      background-color: #fff;
      padding: 30px 30px 10px 30px;
      text-align: center;
    }

    .icon-circle {
      width: 70px;
      height: 70px;
      background: #e3f2fd;
      color: #2a5298;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 2rem;
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

    /* Wrapper to hold the icon over the input */
    .input-group-custom {
      position: relative;
      margin-bottom: 20px;
    }
    
    .input-icon {
      position: absolute;
      left: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: #6c757d;
      z-index: 10;
    }

    .btn-login {
      background: #2a5298;
      border: none;
      padding: 12px;
      border-radius: 10px;
      font-weight: 600;
      letter-spacing: 1px;
      transition: all 0.3s;
      width: 100%;
      color: white;
    }
    
    .btn-login:hover {
      background: #1e3c72;
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(30, 60, 114, 0.3);
    }

    .footer-links {
      margin-top: 25px;
      text-align: center;
      font-size: 0.9rem;
    }
    
    .footer-links a {
      text-decoration: none;
      color: #2a5298;
      font-weight: 600;
    }
  </style>
</head>
<body>

<div class="container d-flex justify-content-center">
  
  <div class="card login-card p-4">
    
    <!-- Logo/Icon Section -->
    <div class="login-header">
      <div class="icon-circle">
        <i class="bi bi-shield-lock-fill"></i>
      </div>
      <h4 class="fw-bold text-dark">Admin Portal</h4>
      <p class="text-muted small">Barangay Dimakita System</p>
    </div>

    <div class="card-body">
      <form method="POST">
        
        <!-- Username -->
        <div class="input-group-custom">
          <i class="bi bi-person-fill input-icon"></i>
          <input type="text" name="user" class="form-control" placeholder="Username" required>
        </div>

        <!-- Password -->
        <div class="input-group-custom">
          <i class="bi bi-key-fill input-icon"></i>
          <input type="password" name="pass" class="form-control" placeholder="Password" required>
        </div>

        <!-- Login Button -->
        <button name="login" class="btn btn-login">
          LOGIN
        </button>
      </form>

      <!-- PHP Logic (Unchanged) -->
      <?php
      if (isset($_POST['login'])) {
        $u = mysqli_real_escape_string($conn,$_POST['user']);
        $p = $_POST['pass'];

        $res = mysqli_query($conn,"SELECT * FROM users WHERE username='$u'");
        if (mysqli_num_rows($res)==1) {
          $row = mysqli_fetch_assoc($res);

          if ($row['is_verified']==0) {
            echo "<div class='alert alert-warning mt-3 small text-center'><i class='bi bi-exclamation-triangle-fill'></i> Please verify your email first.</div>";
          } elseif (password_verify($p,$row['password'])) {
            $_SESSION['admin']=$row['id'];
            header("Location: admin.php");
            exit();
          } else {
             // Wrong password
             echo "<div class='alert alert-danger mt-3 small text-center'><i class='bi bi-x-circle-fill'></i> Invalid credentials.</div>";
          }
        } else {
             // Wrong username
             echo "<div class='alert alert-danger mt-3 small text-center'><i class='bi bi-x-circle-fill'></i> Invalid credentials.</div>";
        }
      }
      ?>

      <!-- Footer Links -->
      <div class="footer-links pt-3 border-top mt-3">
        <p class="text-muted small mb-1">New Administrator?</p>
        <a href="register.php">Register Account</a>
        <div class="mt-2">
            <a href="landingpage.php" class="text-secondary small"><i class="bi bi-arrow-left"></i> Back to Home</a>
        </div>
      </div>

    </div>
  </div>

</div>

</body>
</html>