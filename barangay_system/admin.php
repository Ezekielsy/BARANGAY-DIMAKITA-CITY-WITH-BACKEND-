<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: login.php");
  exit();
}
include "db/config.php";

// Fetch Stats (Logic Unchanged)
$pending = mysqli_fetch_assoc(mysqli_query($conn,
  "SELECT COUNT(*) total FROM requests WHERE status='Pending'"))['total'];
$approved = mysqli_fetch_assoc(mysqli_query($conn,
  "SELECT COUNT(*) total FROM requests WHERE status='Approved'"))['total'];
$released = mysqli_fetch_assoc(mysqli_query($conn,
  "SELECT COUNT(*) total FROM requests WHERE status='Released'"))['total'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Administrator Dashboard</title>
  
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f4f7f6;
    }
    
    /* Navbar Gradient */
    .navbar-custom {
      background: linear-gradient(90deg, #1e3c72 0%, #2a5298 100%);
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    /* Stats Cards */
    .stat-card {
      border: none;
      border-radius: 15px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.05);
      transition: transform 0.3s;
      background: #fff;
      overflow: hidden;
    }
    .stat-card:hover {
      transform: translateY(-5px);
    }
    .icon-box {
      width: 50px;
      height: 50px;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.5rem;
    }

    /* Table Styling */
    .table-card {
      border: none;
      border-radius: 15px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.05);
      overflow: hidden; /* Keeps header corners rounded */
    }
    .table thead th {
      background-color: #2c3e50;
      color: #fff;
      font-weight: 500;
      text-transform: uppercase;
      font-size: 0.85rem;
      letter-spacing: 0.5px;
      padding: 15px;
      border: none;
    }
    .table tbody td {
      padding: 15px;
      vertical-align: middle;
      font-size: 0.95rem;
    }
    
    /* Buttons */
    .btn-action {
      border-radius: 50px;
      padding: 5px 15px;
      font-size: 0.85rem;
    }
  </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-dark navbar-custom sticky-top">
  <div class="container d-flex justify-content-between align-items-center">
    <span class="navbar-brand fw-bold">
      <i class="bi bi-speedometer2 me-2"></i> Admin Dashboard
    </span>
    
    <div class="d-flex align-items-center gap-3">
        <span class="text-white small d-none d-md-block opacity-75">Welcome, Administrator</span>
        <form action="logout.php" method="POST" class="m-0">
          <button class="btn btn-sm btn-light rounded-pill px-3 fw-bold text-primary">
            <i class="bi bi-box-arrow-right"></i> Logout
          </button>
        </form>
    </div>
  </div>
</nav>

<div class="container mt-5 mb-5">
  
  <div class="d-flex justify-content-between align-items-end mb-4">
      <div>
          <h3 class="fw-bold text-dark mb-1">Overview</h3>
          <p class="text-muted small mb-0">Monitor request status and activity.</p>
      </div>
      <div class="text-muted small">
          Today: <?php echo date("F j, Y"); ?>
      </div>
  </div>

  <!-- STATS CARDS -->
  <div class="row g-4 mb-5">
    <!-- Pending -->
    <div class="col-md-4">
      <div class="card stat-card border-start border-5 border-warning">
        <div class="card-body p-4 d-flex align-items-center justify-content-between">
          <div>
            <h6 class="text-muted small text-uppercase fw-bold mb-1">Pending Requests</h6>
            <h2 class="fw-bold text-dark mb-0"><?= $pending ?></h2>
          </div>
          <div class="icon-box bg-warning bg-opacity-10 text-warning">
            <i class="bi bi-hourglass-split"></i>
          </div>
        </div>
      </div>
    </div>

    <!-- Approved -->
    <div class="col-md-4">
      <div class="card stat-card border-start border-5 border-success">
        <div class="card-body p-4 d-flex align-items-center justify-content-between">
          <div>
            <h6 class="text-muted small text-uppercase fw-bold mb-1">Approved</h6>
            <h2 class="fw-bold text-dark mb-0"><?= $approved ?></h2>
          </div>
          <div class="icon-box bg-success bg-opacity-10 text-success">
            <i class="bi bi-check-circle-fill"></i>
          </div>
        </div>
      </div>
    </div>

    <!-- Released -->
    <div class="col-md-4">
      <div class="card stat-card border-start border-5 border-primary">
        <div class="card-body p-4 d-flex align-items-center justify-content-between">
          <div>
            <h6 class="text-muted small text-uppercase fw-bold mb-1">Released</h6>
            <h2 class="fw-bold text-dark mb-0"><?= $released ?></h2>
          </div>
          <div class="icon-box bg-primary bg-opacity-10 text-primary">
            <i class="bi bi-folder-check"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- RECENT REQUESTS TABLE -->
  <h5 class="fw-bold text-dark mb-3">Recent Requests</h5>
  <div class="card table-card bg-white">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover mb-0">
          <thead>
            <tr>
              <th class="ps-4">Control No</th>
              <th>Requester Name</th>
              <th>Document Type</th>
              <th>Current Status</th>
              <th class="text-center">Action</th>
            </tr>
          </thead>
          <tbody>
          <?php
          $res = mysqli_query($conn,"SELECT * FROM requests ORDER BY id DESC");
          
          if(mysqli_num_rows($res) > 0) {
              while($r=mysqli_fetch_assoc($res)){
                // Visual Logic for Badges (Does not change DB data)
                $badge_class = "bg-secondary";
                $icon = "bi-circle";
                
                if($r['status'] == 'Pending') { 
                    $badge_class = "bg-warning text-dark"; 
                    $icon = "bi-hourglass-split";
                }
                elseif($r['status'] == 'Approved') { 
                    $badge_class = "bg-success"; 
                    $icon = "bi-check-circle";
                }
                elseif($r['status'] == 'Released') { 
                    $badge_class = "bg-primary"; 
                    $icon = "bi-check-all";
                }
                elseif($r['status'] == 'Declined') { 
                    $badge_class = "bg-danger"; 
                    $icon = "bi-x-circle";
                }

                echo "<tr>
                <td class='ps-4 fw-bold text-primary'>{$r['control_no']}</td>
                <td class='fw-bold text-secondary'>{$r['fullname']}</td>
                <td><small class='d-block text-muted'>{$r['document_type']}</small></td>
                <td>
                    <span class='badge rounded-pill $badge_class px-3 py-2'>
                        <i class='bi $icon me-1'></i> {$r['status']}
                    </span>
                </td>
                <td class='text-center'>
                  <a href='update.php?id={$r['id']}'
                  class='btn btn-outline-dark btn-action btn-sm'>
                    <i class='bi bi-pencil-square'></i> Manage
                  </a>
                </td>
                </tr>";
              }
          } else {
              echo "<tr><td colspan='5' class='text-center py-4 text-muted'>No requests found</td></tr>";
          }
          ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>