<?php
include "db/config.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Register Account</title>

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet" />

  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
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
      padding: 12px 12px 12px 45px;
      background-color: #f8f9fa;
    }
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
    }
    .btn-register {
      background: #2a5298;
      color: #fff;
      border-radius: 10px;
      padding: 12px;
      width: 100%;
      font-weight: 600;
      border: none;
      transition: background-color 0.3s;
    }
    .btn-register:hover {
      background: #1e3c72;
    }
  </style>
</head>
<body>

<div class="d-flex align-items-center justify-content-center min-vh-100 w-100">
  <div class="card p-3" style="max-width: 450px; width: 100%;">
    <div class="text-center mb-3">
      <div class="icon-circle">
        <i class="bi bi-person-plus-fill"></i>
      </div>
      <h4 class="fw-bold text-dark">Create Admin Account</h4>
      <p class="text-muted small">Verification is required after registration.</p>
    </div>

    <div class="card-body">
      <form method="POST" novalidate>
        <div class="input-group-custom">
          <i class="bi bi-person-vcard input-icon"></i>
          <input name="fullname" class="form-control" placeholder="Full Name" required />
        </div>

        <div class="input-group-custom">
          <i class="bi bi-envelope-at input-icon"></i>
          <input name="email" type="email" class="form-control" placeholder="Email Address" required />
        </div>

        <div class="input-group-custom">
          <i class="bi bi-person input-icon"></i>
          <input name="username" class="form-control" placeholder="Username" required />
        </div>

        <div class="input-group-custom">
          <i class="bi bi-lock input-icon"></i>
          <input name="password" type="password" class="form-control" placeholder="Password" required />
          <small class="text-muted">Password must be at least 8 characters</small>
        </div>

        <button name="register" class="btn btn-register">Create Account</button>
      </form>

<?php
if (isset($_POST['register'])) {

    // Sanitize inputs (basic)
    $fullname = trim(mysqli_real_escape_string($conn, $_POST['fullname']));
    $email = trim(mysqli_real_escape_string($conn, $_POST['email']));
    $username = trim(mysqli_real_escape_string($conn, $_POST['username']));
    $password_raw = $_POST['password'];

    // Validation
    $allowedDomain = '@brgdimakita.com';

    // Check domain restriction
    if (!str_ends_with($email, $allowedDomain)) {
        echo "
        <div class='alert alert-danger mt-4'>
          <strong>Registration Failed!</strong><br>
          Only <b>$allowedDomain</b> email addresses are allowed.
        </div>";
        exit;
    }

    // Check password length
    if (strlen($password_raw) < 8) {
        echo "
        <div class='alert alert-danger mt-4'>
          <strong>Registration Failed!</strong><br>
          Password must be at least 8 characters long.
        </div>";
        exit;
    }

    // Check duplicate email
    $checkEmailQuery = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $checkEmailQuery);
    if (mysqli_num_rows($result) > 0) {
        echo "
        <div class='alert alert-danger mt-4'>
          <strong>Registration Failed!</strong><br>
          Email <b>$email</b> is already registered.
        </div>";
        exit;
    }

    // Everything good, insert user
    $password = password_hash($password_raw, PASSWORD_DEFAULT);
    $code = md5(rand());

    mysqli_query($conn, "INSERT INTO users
        (fullname, email, username, password, verification_code, is_verified)
        VALUES
        ('$fullname', '$email', '$username', '$password', '$code', 0)");

    echo "
    <div class='alert alert-success mt-4'>
      <strong>Verify Your Email</strong><br>
      <span class='small'>For exhibit purposes, verify instantly:</span><br>
      <a href='verify.php?code=$code' class='fw-bold text-success'>
        Click to Verify Account
      </a>
    </div>";
}
?>

      <div class="text-center mt-4 pt-3 border-top">
        <span class="text-muted small">Already have an account?</span><br />
        <a href='login.php'><i class="bi bi-arrow-left"></i> Back to Login</a>
      </div>
    </div>
  </div>
</div>

</body>
</html>
