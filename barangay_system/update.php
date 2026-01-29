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

    // Auto-fill remarks for Approved and Released if empty
    if (($status == "Approved" || $status == "Released") && empty(trim($remarks))) {
        if ($status == "Approved") {
            $remarks = "Request approved by Barangay Admin.";
        } elseif ($status == "Released") {
            $remarks = "Request is ready for release. Applicant may claim at the Barangay.";
        }
    }

    // Prepare update query
    $sql = "UPDATE requests
            SET status='$status', admin_remarks='$remarks'
            WHERE id=$id";

    // Execute and check
    if (mysqli_query($conn, $sql)) {
        // Refresh row data to show updated status immediately
        $row['status'] = $status;
        $row['admin_remarks'] = $remarks; 
        $msg = "Request updated successfully!";
    } else {
        $error = "Update failed: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Update Request</title>
  
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f4f7f6;
    }
    .navbar-custom {
      background: linear-gradient(90deg, #1e3c72 0%, #2a5298 100%);
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    .card {
      border: none;
      border-radius: 15px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.05);
      overflow: hidden;
    }
    .card-header-custom {
      background-color: #fff;
      border-bottom: 1px solid #eee;
      padding: 20px 25px;
    }
    .info-group {
      margin-bottom: 15px;
      padding-bottom: 15px;
      border-bottom: 1px dashed #eee;
    }
    .info-group:last-child {
      border-bottom: none;
    }
    .info-label {
      font-size: 0.8rem;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      color: #6c757d;
      font-weight: 600;
      margin-bottom: 5px;
      display: block;
    }
    .info-value {
      font-weight: 500;
      color: #2c3e50;
    }
    .form-control, .form-select {
      border-radius: 10px;
      padding: 12px;
      border: 1px solid #dee2e6;
    }
    .form-control:focus, .form-select:focus {
      border-color: #2a5298;
      box-shadow: 0 0 0 4px rgba(42, 82, 152, 0.1);
    }
    .btn-update {
      background: #2a5298;
      border: none;
      border-radius: 10px;
      padding: 12px;
      font-weight: 600;
      transition: all 0.3s;
    }
    .btn-update:hover {
      background: #1e3c72;
      transform: translateY(-2px);
    }
    .uploaded-id img {
      max-width: 100%;
      border: 1px solid #ccc;
      border-radius: 10px;
      margin-top: 10px;
    }
  </style>
</head>

<body>

<nav class="navbar navbar-dark navbar-custom sticky-top mb-5">
  <div class="container">
    <span class="navbar-brand fw-bold">
      <i class="bi bi-speedometer2 me-2"></i> Admin Portal
    </span>
    <a href="admin.php" class="btn btn-sm btn-outline-light rounded-pill px-3">
      <i class="bi bi-arrow-left"></i> Back to Dashboard
    </a>
  </div>
</nav>

<div class="container pb-5">
  <div class="row g-4">
    
    <!-- LEFT COLUMN: REQUEST INFO -->
    <div class="col-lg-7">
      <div class="card h-100">
        <div class="card-header-custom">
          <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-file-text me-2 text-primary"></i> Request Details</h5>
        </div>
        <div class="card-body p-4">
          
          <div class="d-flex justify-content-between align-items-start mb-4">
             <div>
               <span class="badge bg-primary bg-opacity-10 text-primary mb-1">Control Number</span>
               <h3 class="fw-bold text-dark letter-spacing-1"><?= htmlspecialchars($row['control_no']) ?></h3>
             </div>
             <div class="text-end">
                <small class="text-muted d-block">Document Type</small>
                <span class="fw-bold text-primary"><?= htmlspecialchars($row['document_type']) ?></span>
             </div>
          </div>

          <div class="info-group">
             <span class="info-label"><i class="bi bi-person me-1"></i> Full Name</span>
             <div class="info-value fs-5"><?= htmlspecialchars($row['fullname']) ?></div>
          </div>

          <div class="row">
            <div class="col-md-6">
                <div class="info-group">
                    <span class="info-label"><i class="bi bi-phone me-1"></i> Contact Number</span>
                    <div class="info-value"><?= htmlspecialchars($row['contact']) ?></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="info-group">
                    <span class="info-label"><i class="bi bi-person-badge me-1"></i> Valid ID Presented</span>
                    <div class="info-value"><?= htmlspecialchars($row['valid_id']) ?></div>

                    <?php if (!empty($row['valid_id_file']) && file_exists('uploads/'.$row['valid_id_file'])): ?>
                        <div class="uploaded-id">
                            <img src="uploads/<?= htmlspecialchars($row['valid_id_file']) ?>" alt="Uploaded Valid ID">
                            <a href="uploads/<?= htmlspecialchars($row['valid_id_file']) ?>" target="_blank" class="btn btn-sm btn-outline-primary mt-2">View Full ID</a>
                        </div>
                    <?php else: ?>
                        <small class="text-muted d-block mt-1">No uploaded ID file found.</small>
                    <?php endif; ?>
                </div>
            </div>
          </div>

          <div class="info-group">
             <span class="info-label"><i class="bi bi-geo-alt me-1"></i> Address</span>
             <div class="info-value"><?= nl2br(htmlspecialchars($row['address'])) ?></div>
          </div>

          <div class="info-group">
             <span class="info-label"><i class="bi bi-card-text me-1"></i> Purpose</span>
             <div class="info-value bg-light p-3 rounded text-secondary border">
                 <?= nl2br(htmlspecialchars($row['purpose'])) ?>
             </div>
          </div>

        </div>
      </div>
    </div>

    <!-- RIGHT COLUMN: UPDATE FORM -->
    <div class="col-lg-5">
      <div class="card">
        <div class="card-header-custom bg-light">
          <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-gear-fill me-2 text-secondary"></i> Process Request</h5>
        </div>
        <div class="card-body p-4">

          <?php if (isset($msg)): ?>
            <div class="alert alert-success d-flex align-items-center mb-4 border-0 shadow-sm">
                <i class="bi bi-check-circle-fill me-2 fs-4"></i>
                <div><?= $msg ?></div>
            </div>
          <?php endif; ?>

          <?php if (isset($error)): ?>
            <div class="alert alert-danger d-flex align-items-center mb-4">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-4"></i>
                <div><?= $error ?></div>
            </div>
          <?php endif; ?>

          <form method="POST">
            
            <div class="mb-4">
                <label class="form-label fw-bold text-secondary small">UPDATE STATUS</label>
                <select name="status" id="status_select" class="form-select form-select-lg" required onchange="autoRemarks()">
                  <option value="Pending" <?= $row['status']=="Pending" ? "selected" : "" ?>>Pending</option>
                  <option value="Approved" <?= $row['status']=="Approved" ? "selected" : "" ?>>Approved</option>
                  <option value="Released" <?= $row['status']=="Released" ? "selected" : "" ?>>Released</option>
                  <option value="Declined" <?= $row['status']=="Declined" ? "selected" : "" ?>>Declined</option>
                </select>
                <div class="form-text">Update the current stage of this request.</div>
            </div>

            <div class="mb-4" id="remarks_container">
                <label class="form-label fw-bold text-secondary small">ADMIN REMARKS / NOTES</label>

                <!-- Dropdown for declined reasons -->
                <select id="decline_reasons" class="form-select mb-2 d-none" onchange="fillDeclineReason()">
                    <option value="">Select reason</option>
                    <option value="Incomplete requirements">Incomplete requirements</option>
                    <option value="Invalid ID presented">Invalid ID presented</option>
                    <option value="Other">Other (type manually)</option>
                </select>

                <textarea name="admin_remarks" id="admin_remarks" class="form-control" rows="5" placeholder="Add notes for the applicant or internal records..."><?= htmlspecialchars($row['admin_remarks']) ?></textarea>
            </div>

            <button name="update" class="btn btn-primary btn-update w-100 mb-3">
              <i class="bi bi-save me-2"></i> Save Changes
            </button>
            
            <a href="admin.php" class="btn btn-outline-secondary w-100 border-0">
               Cancel & Return
            </a>

          </form>

        </div>
      </div>
    </div>

  </div>
</div>

<footer class="text-center mt-5 mb-4 text-muted small">
  © 2026 Barangay Document System
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
function autoRemarks() {
    const status = document.getElementById('status_select').value;
    const remarks = document.getElementById('admin_remarks');
    const declineDropdown = document.getElementById('decline_reasons');

    if (status === "Approved") {
        remarks.value = "Request approved by Barangay Admin.";
        declineDropdown.classList.add('d-none');
    } else if (status === "Released") {
        remarks.value = "Request is ready for release. Applicant may claim at the Barangay.";
        declineDropdown.classList.add('d-none');
    } else if (status === "Declined") {
        remarks.value = "";
        declineDropdown.classList.remove('d-none');
    } else {
        remarks.value = "";
        declineDropdown.classList.add('d-none');
    }
}

function fillDeclineReason() {
    const dropdown = document.getElementById('decline_reasons');
    const remarks = document.getElementById('admin_remarks');
    const value = dropdown.value;

    if (value === "Other") {
        remarks.value = "";
        remarks.placeholder = "Type custom reason here...";
    } else {
        remarks.value = value;
        remarks.placeholder = "";
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', autoRemarks);
</script>

</body>
</html>
