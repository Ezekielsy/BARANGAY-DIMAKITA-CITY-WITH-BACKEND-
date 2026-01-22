<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: login.php");
  exit();
}

include "db/config.php";

// CHECK IF ID IS PASSED
if (!isset($_GET['id']) || empty($_GET['id'])) {
  header("Location: admin.php");
  exit();
}

$id = intval($_GET['id']);

// FETCH REQUEST
$res = mysqli_query($conn, "SELECT * FROM requests WHERE id=$id");

if (!$res || mysqli_num_rows($res) == 0) {
  header("Location: admin.php");
  exit();
}

$row = mysqli_fetch_assoc($res);

// HANDLE FORM SUBMISSION
if (isset($_POST['update'])) {

    // Get and escape inputs
    $status  = mysqli_real_escape_string($conn, $_POST['status']);
    $remarks = mysqli_real_escape_string($conn, $_POST['admin_remarks']);

    // Prepare update query
    $sql = "UPDATE requests
            SET status='$status', admin_remarks='$remarks'
            WHERE id=$id";

    // Execute and check
    if (mysqli_query($conn, $sql)) {
        $msg = "Request updated successfully!";
    } else {
        $error = "Update failed: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Update Request</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<nav class="navbar navbar-dark bg-dark">
  <div class="container">
    <span class="navbar-brand fw-bold">Barangay Document System</span>
  </div>
</nav>

<div class="container mt-5">
  <div class="card shadow rounded-4">
    <div class="card-body">

      <h4 class="fw-bold mb-3">Request Details</h4>

      <?php if (isset($msg)): ?>
        <div class="alert alert-success"><?= $msg ?></div>
      <?php endif; ?>

      <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
      <?php endif; ?>

      <p><strong>Control No:</strong> <?= htmlspecialchars($row['control_no']) ?></p>
      <p><strong>Name:</strong> <?= htmlspecialchars($row['fullname']) ?></p>
      <p><strong>Address:</strong><br><?= nl2br(htmlspecialchars($row['address'])) ?></p>
      <p><strong>Contact:</strong> <?= htmlspecialchars($row['contact']) ?></p>
      <p><strong>Document:</strong> <?= htmlspecialchars($row['document_type']) ?></p>
      <p><strong>Purpose:</strong><br><?= nl2br(htmlspecialchars($row['purpose'])) ?></p>
      <p><strong>Valid ID:</strong> <?= htmlspecialchars($row['valid_id']) ?></p>

      <hr>

      <!-- UPDATE FORM -->
      <form method="POST">

        <label class="form-label">Status</label>
        <select name="status" class="form-select mb-3" required>
          <option value="Pending" <?= $row['status']=="Pending" ? "selected" : "" ?>>Pending</option>
          <option value="Approved" <?= $row['status']=="Approved" ? "selected" : "" ?>>Approved</option>
          <option value="Released" <?= $row['status']=="Released" ? "selected" : "" ?>>Released</option>
          <option value="Rejected" <?= $row['status']=="Rejected" ? "selected" : "" ?>>Rejected</option>
        </select>

        <label class="form-label">Admin Remarks</label>
        <textarea name="admin_remarks" class="form-control mb-3" rows="4"><?= htmlspecialchars($row['admin_remarks']) ?></textarea>

        <button name="update" class="btn btn-primary w-100">Save Changes</button>
      </form>

      <a href="admin.php" class="btn btn-secondary mt-3 w-100">Back to Dashboard</a>

    </div>
  </div>
</div>

<footer class="text-center mt-5 text-muted">
  © 2026 Barangay Document System
</footer>

</body>
</html>
