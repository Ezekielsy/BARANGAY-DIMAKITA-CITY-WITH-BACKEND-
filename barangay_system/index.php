<?php
include "db/config.php";
?>
<!DOCTYPE html>
<html>
<head>
  <title>Barangay Document System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      font-family: 'Segoe UI', Tahoma, sans-serif;
      background-color: #f4f6f9;
    }
    .navbar-brand {
      letter-spacing: .5px;
    }
    .page-title {
      font-weight: 700;
      letter-spacing: .6px;
    }
    .card {
      border: none;
      border-radius: 1rem;
    }
    .form-control, .form-select {
      border-radius: .6rem;
    }
    .alert {
      border-radius: .6rem;
    }
    footer {
      font-size: .85rem;
      color: #6c757d;
    }
  </style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <span class="navbar-brand fw-bold">
      Barangay Dimakita, Lupalok City
    </span>

    <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="nav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link" href="#request">Request</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#track" onclick="showTrack()">Track</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- REQUEST FORM -->
<div class="container mt-5" id="request">
  <div class="row justify-content-center">
    <div class="col-md-7">

      <div class="card shadow">
        <div class="card-body p-4">

          <div class="text-center mb-4">
            <h4 class="page-title">Barangay Document Request</h4>
            <p class="text-muted small mb-0">
              Official Online Request System of Barangay Dimakita
            </p>
          </div>

          <form method="POST">

            <input type="text" name="fullname" class="form-control mb-3"
              placeholder="Full Name" required>

            <textarea name="address" class="form-control mb-3"
              placeholder="Complete Address" required></textarea>

            <input type="text" name="contact" class="form-control mb-3"
              placeholder="Contact Number" required>

            <!-- DOCUMENT TYPE -->
            <select name="document_type" id="document_type"
              class="form-select mb-2" required onchange="showTime()">
              <option value="">-- Select Document --</option>
              <option value="Barangay Clearance">Barangay Clearance</option>
              <option value="Barangay Certificate">Barangay Certificate</option>
              <option value="Certificate of Residency">Certificate of Residency</option>
              <option value="Certificate of Indigency">Certificate of Indigency</option>
              <option value="Certificate of Good Moral Character">Certificate of Good Moral Character</option>
              <option value="Business Clearance">Business Clearance</option>
              <option value="Barangay Business Permit">Barangay Business Permit</option>
              <option value="Barangay ID Application">Barangay ID Application</option>
              <option value="Barangay ID Renewal">Barangay ID Renewal</option>
              <option value="Senior Citizen Certification">Senior Citizen Certification</option>
              <option value="PWD Certification">PWD Certification</option>
              <option value="Blotter Report Request">Blotter Report Request</option>
              <option value="Incident Report">Incident Report</option>
            </select>

            <!-- PROCESSING TIME -->
            <div id="processing_time" class="alert alert-info d-none mb-3"></div>

            <textarea name="purpose" class="form-control mb-3"
              placeholder="Purpose of Request" required></textarea>

            <select name="valid_id" class="form-select mb-3" required>
              <option value="">-- Valid ID Presented --</option>
              <option>Barangay ID</option>
              <option>National ID</option>
              <option>Voter's ID</option>
              <option>Driver's License</option>
            </select>

            <button name="submit" class="btn btn-primary w-100">
              Submit Request
            </button>
          </form>

          <?php
          if (isset($_POST['submit'])) {

            $control_no = "BRGY-" . date("Y") . "-" . rand(10000,99999);

            $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
            $address  = mysqli_real_escape_string($conn, $_POST['address']);
            $contact  = mysqli_real_escape_string($conn, $_POST['contact']);
            $document = mysqli_real_escape_string($conn, $_POST['document_type']);
            $purpose  = mysqli_real_escape_string($conn, $_POST['purpose']);
            $valid_id = mysqli_real_escape_string($conn, $_POST['valid_id']);

            $sql = "INSERT INTO requests
              (control_no, fullname, address, contact, document_type, purpose, valid_id)
              VALUES
              ('$control_no','$fullname','$address','$contact','$document','$purpose','$valid_id')";

            if (mysqli_query($conn, $sql)) {
              echo "
              <div class='alert alert-success mt-4 text-center'>
                <h5 class='fw-bold mb-2'>Request Successfully Submitted</h5>
                <p class='mb-1'>Please keep your control number for tracking.</p>
                <p class='fw-bold'>Control No: $control_no</p>
              </div>";
            }
          }
          ?>

        </div>
      </div>

    </div>
  </div>
</div>

<!-- TRACK REQUEST -->
<div class="container mt-5 <?php echo isset($_POST['track']) ? '' : 'd-none'; ?>" id="track">
  <div class="row justify-content-center">
    <div class="col-md-5">

      <div class="card shadow">
        <div class="card-body p-4 text-center">

          <h4 class="page-title mb-1">Track Your Request</h4>
          <p class="text-muted small mb-3">
            Enter your control number to check request status
          </p>

          <form method="POST">
            <input type="text" name="track_no"
              class="form-control mb-3"
              placeholder="Enter Control Number" required>

            <button name="track" class="btn btn-success w-100">
              Track Request
            </button>
          </form>

          <?php
          if (isset($_POST['track'])) {
            $code = mysqli_real_escape_string($conn, $_POST['track_no']);

            $res = mysqli_query($conn,
              "SELECT status FROM requests WHERE control_no='$code'");

            if (mysqli_num_rows($res) > 0) {
              $row = mysqli_fetch_assoc($res);

              $badge = "bg-warning";
              if ($row['status']=="Approved") $badge="bg-success";
              if ($row['status']=="Released") $badge="bg-primary";

              echo "
              <div class='alert alert-light mt-3'>
                Status:
                <span class='badge $badge'>{$row['status']}</span>
              </div>";
            } else {
              echo "
              <div class='alert alert-danger mt-3'>
                Control Number Not Found
              </div>";
            }
          }
          ?>

        </div>
      </div>

    </div>
  </div>
</div>

<footer class="text-center mt-5 mb-3">
  © 2026 Barangay Document System
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
function showTrack() {
  let t = document.getElementById("track");
  t.classList.remove("d-none");
  t.scrollIntoView({ behavior: "smooth" });
}

function showTime() {
  let doc = document.getElementById("document_type").value;
  let box = document.getElementById("processing_time");

  let times = {
    "Barangay Clearance": "1 working day",
    "Barangay Certificate": "Same day release",
    "Certificate of Residency": "1–2 working days",
    "Certificate of Indigency": "1–2 working days",
    "Certificate of Good Moral Character": "2 working days",
    "Business Clearance": "2–3 working days",
    "Barangay Business Permit": "3–5 working days",
    "Barangay ID Application": "5–7 working days",
    "Barangay ID Renewal": "3–5 working days",
    "Senior Citizen Certification": "1–2 working days",
    "PWD Certification": "1–2 working days",
    "Blotter Report Request": "2–3 working days",
    "Incident Report": "2–3 working days"
  };

  if (times[doc]) {
    box.innerHTML = `
      <strong>Estimated Processing Time</strong><br>
      <span class="text-muted">${times[doc]}</span>
    `;
    box.classList.remove("d-none");
  } else {
    box.classList.add("d-none");
  }
}
</script>

</body>
</html>
