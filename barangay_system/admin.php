<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: login.php");
  exit();
}
include "db/config.php";

$pending = mysqli_fetch_assoc(mysqli_query($conn,
  "SELECT COUNT(*) total FROM requests WHERE status='Pending'"))['total'];
$approved = mysqli_fetch_assoc(mysqli_query($conn,
  "SELECT COUNT(*) total FROM requests WHERE status='Approved'"))['total'];
$released = mysqli_fetch_assoc(mysqli_query($conn,
  "SELECT COUNT(*) total FROM requests WHERE status='Released'"))['total'];
?>
<!DOCTYPE html>
<html>
<head>
  <title>Administrator Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body{font-family:'Segoe UI',Tahoma,sans-serif;background:#f4f6f9}
    .page-title{font-weight:700}
    .card{border:none;border-radius:1rem}
  </style>
</head>
<body>

<nav class="navbar navbar-dark bg-dark">
  <div class="container d-flex justify-content-between">
    <span class="navbar-brand fw-bold">Barangay Dimakita System</span>
    <form action="logout.php" method="POST">
      <button class="btn btn-outline-light btn-sm">Logout</button>
    </form>
  </div>
</nav>

<div class="container mt-4">
  <h4 class="page-title mb-1">Administrator Dashboard</h4>
  <p class="text-muted small mb-3">
    Monitor and manage barangay document requests
  </p>

  <div class="row mb-4">
    <div class="col-md-4">
      <div class="card shadow text-center">
        <div class="card-body">
          <h6 class="text-muted">Pending</h6>
          <h2 class="text-warning"><?= $pending ?></h2>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card shadow text-center">
        <div class="card-body">
          <h6 class="text-muted">Approved</h6>
          <h2 class="text-success"><?= $approved ?></h2>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card shadow text-center">
        <div class="card-body">
          <h6 class="text-muted">Released</h6>
          <h2 class="text-primary"><?= $released ?></h2>
        </div>
      </div>
    </div>
  </div>

  <div class="card shadow">
    <div class="card-body">
      <table class="table table-hover align-middle">
        <thead class="table-dark">
          <tr>
            <th>Control No</th>
            <th>Requester</th>
            <th>Document</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
        <?php
        $res = mysqli_query($conn,"SELECT * FROM requests ORDER BY id DESC");
        while($r=mysqli_fetch_assoc($res)){
          echo "<tr>
          <td>{$r['control_no']}</td>
          <td>{$r['fullname']}</td>
          <td>{$r['document_type']}</td>
          <td><span class='badge bg-warning'>{$r['status']}</span></td>
          <td>
            <a href='update.php?id={$r['id']}'
            class='btn btn-sm btn-outline-primary'>Update</a>
          </td>
          </tr>";
        }
        ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

</body>
</html>
