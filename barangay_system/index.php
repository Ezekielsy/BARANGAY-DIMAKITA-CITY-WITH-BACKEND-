<?php
include "db/config.php";

// Initialize success variable
$success_control_no = "";

// Handle Form Submission (Request)
if (isset($_POST['submit'])) {
    $control_no = "BRGY-" . date("Y") . "-" . rand(10000,99999);
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $address  = mysqli_real_escape_string($conn, $_POST['address']);
    $contact  = mysqli_real_escape_string($conn, $_POST['contact']);
    $document = mysqli_real_escape_string($conn, $_POST['document_type']);
    $purpose  = mysqli_real_escape_string($conn, $_POST['purpose']);
    $valid_id = mysqli_real_escape_string($conn, $_POST['valid_id']);
    $valid_id_file = null;

    // Handle Valid ID file upload
    if(isset($_FILES['valid_id_file']) && $_FILES['valid_id_file']['error'] == 0) {
        $allowed_ext = ['jpg','jpeg','png'];
        $file_name = $_FILES['valid_id_file']['name'];
        $file_tmp  = $_FILES['valid_id_file']['tmp_name'];
        $file_size = $_FILES['valid_id_file']['size'];
        $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        if(in_array($ext, $allowed_ext) && $file_size <= 2*1024*1024){ // Max 2MB
            $new_name = uniqid('id_').".".$ext;
            $upload_dir = 'uploads/';
            if(!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);
            move_uploaded_file($file_tmp, $upload_dir.$new_name);
            $valid_id_file = $new_name;
        } else {
            echo "<script>alert('Invalid file type or size. Only JPG/PNG under 2MB allowed.');</script>";
        }
    } else {
        echo "<script>alert('Please upload a valid ID image.');</script>";
    }

    // Insert request into DB
    $sql = "INSERT INTO requests (control_no, fullname, address, contact, document_type, purpose, valid_id, valid_id_file)
            VALUES ('$control_no','$fullname','$address','$contact','$document','$purpose','$valid_id','$valid_id_file')";

    if (mysqli_query($conn, $sql)) {
        $success_control_no = $control_no;
    }
}

// Check if tracking form submitted
$track_result = null;
$show_track_section = false;
if (isset($_POST['track'])) {
    $show_track_section = true; // Show track section
    $code = mysqli_real_escape_string($conn, $_POST['track_no']);
    $res = mysqli_query($conn, "SELECT status, valid_id_file, admin_remarks FROM requests WHERE control_no='$code'");

    if (mysqli_num_rows($res) > 0) {
        $track_result = mysqli_fetch_assoc($res);
    } else {
        $track_result = false; // Not found
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Barangay Document System</title>
  
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

  <style>
    :root {
      --primary-color: #2a5298;
      --secondary-color: #1e3c72;
      --accent-color: #00c6ff;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f4f7f6;
      color: #333;
      overflow-x: hidden;
    }

    .hero {
      background: linear-gradient(135deg, var(--secondary-color) 0%, var(--primary-color) 100%);
      color: white;
      padding: 100px 0 80px;
      margin-bottom: 50px;
      border-bottom-left-radius: 50px;
      border-bottom-right-radius: 50px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    
    .hero h1 { font-weight: 700; font-size: 3rem; margin-bottom: 20px; }

    .btn-hero {
      background-color: white;
      color: var(--primary-color);
      padding: 12px 30px;
      border-radius: 30px;
      font-weight: 600;
      transition: all 0.3s;
    }
    .btn-hero:hover {
      background-color: var(--accent-color);
      color: white;
      transform: translateY(-3px);
      box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    .service-card {
      background: white;
      border-radius: 20px;
      padding: 30px;
      text-align: center;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      height: 100%;
      border: 1px solid #eee;
    }
    .service-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 15px 30px rgba(0,0,0,0.08);
      border-color: var(--accent-color);
    }
    .icon-box { font-size: 2.5rem; color: var(--primary-color); margin-bottom: 15px; }

    .main-card { border: none; border-radius: 20px; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08); overflow: hidden; }
    .form-control, .form-select {
      border-radius: 10px;
      padding: 12px;
      background-color: #f8f9fa;
      border: 1px solid #e9ecef;
    }
    .form-control:focus, .form-select:focus {
      background-color: #fff;
      border-color: var(--primary-color);
      box-shadow: 0 0 0 4px rgba(42, 82, 152, 0.1);
    }

    footer { background: #343a40; color: #adb5bd; padding: 40px 0; margin-top: 80px; }

    /* Fade-in animation */
    .fade-in-up { animation: fadeInUp 0.8s ease-out; }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
  </style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-transparent position-absolute w-100" style="z-index: 9;">
  <div class="container mt-2">
    <a class="navbar-brand fw-bold" href="landingpage.php">
      <i class="bi bi-building-fill"></i> Brgy. Dimakita
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="nav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="#services">Services</a></li>
        <li class="nav-item"><a class="nav-link" href="#request_section" onclick="showRequestForm()">Request</a></li>
        <li class="nav-item"><a class="nav-link" href="#track_section" onclick="showTrack()">Track Status</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- HERO SECTION -->
<header class="hero text-center d-flex align-items-center">
  <div class="container fade-in-up">
    <span class="badge bg-white text-primary mb-3 px-3 py-2 rounded-pill text-uppercase" style="letter-spacing: 2px; font-size: 0.8rem;">E-Government Services</span>
    <h1>Barangay Online Portal</h1>
    <p class="lead opacity-75 mb-4 col-md-8 mx-auto">
      Experience fast, transparent, and convenient document processing for the people of Lupalok City.
    </p>
    <div class="d-flex justify-content-center gap-3">
      <a href="javascript:void(0)" class="btn btn-hero shadow" onclick="showRequestForm()">Request Document</a>
      <a href="#track_section" onclick="showTrack()" class="btn btn-outline-light rounded-pill px-4 py-2 fw-bold" style="border-width: 2px;">Track Status</a>
    </div>
  </div>
</header>

<!-- SERVICES GRID -->
<div class="container mb-5" id="services">
  <div class="row g-4">
    <div class="col-md-4">
      <div class="service-card">
        <div class="icon-box"><i class="bi bi-file-earmark-text"></i></div>
        <h5 class="fw-bold">Certifications</h5>
        <p class="text-muted small">Easily request Barangay Clearance, Indigency, and Residency certificates.</p>
      </div>
    </div>
    <div class="col-md-4">
      <div class="service-card">
        <div class="icon-box"><i class="bi bi-person-vcard"></i></div>
        <h5 class="fw-bold">Barangay ID</h5>
        <p class="text-muted small">Apply for a new ID or renew your existing valid Barangay identification.</p>
      </div>
    </div>
    <div class="col-md-4">
      <div class="service-card">
        <div class="icon-box"><i class="bi bi-shield-check"></i></div>
        <h5 class="fw-bold">Reports & Blotter</h5>
        <p class="text-muted small">File incident reports or request blotter copies securely online.</p>
      </div>
    </div>
  </div>
</div>

<!-- MAIN CONTENT AREA -->
<div class="container" id="request_section">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <!-- Request Form Card -->
      <div class="card main-card mb-5 bg-white <?php echo isset($_POST['submit']) ? '' : 'd-none'; ?>" id="request_form_card">

        
        <!-- SUCCESS STATE -->
        <?php if ($success_control_no != ""): ?>
          <div class="card-body p-5 text-center fade-in-up">
            <div class="mb-4">
              <i class="bi bi-check-circle-fill text-success" style="font-size: 5rem;"></i>
            </div>
            <h2 class="fw-bold text-dark">Request Submitted!</h2>
            <p class="text-muted mb-4">Your document request is now being processed.</p>
            
            <div class="alert alert-success d-inline-block px-5 py-3 rounded-4 border-success">
              <small class="text-uppercase fw-bold opacity-75">Your Control Number</small>
              <div class="display-6 fw-bold mt-1" style="letter-spacing: 2px;">
                <?php echo $success_control_no; ?>
              </div>
            </div>
            
            <p class="text-muted mt-3 small">Please take a screenshot or save this number.</p>
            
            <div class="mt-5">
              <a href="index.php" class="btn btn-outline-primary rounded-pill px-4">Submit Another Request</a>
            </div>
          </div>

        <!-- FORM STATE -->
        <?php else: ?>
          <div class="card-body p-5 fade-in-up">
            <div class="d-flex align-items-center mb-4">
               <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                 <i class="bi bi-pencil-fill"></i>
               </div>
               <div>
                 <h4 class="fw-bold mb-0">Fill Out Request Form</h4>
                 <small class="text-muted">Please provide accurate details.</small>
               </div>
            </div>
            
            <form method="POST" enctype="multipart/form-data">
              <div class="row g-3">
                <div class="col-md-12">
                   <label class="form-label small text-muted fw-bold">FULL NAME</label>
                   <input type="text" name="fullname" class="form-control" placeholder="First Middle Last" required>
                </div>

                <div class="col-md-6">
                   <label class="form-label small text-muted fw-bold">CONTACT NO.</label>
                   <input type="text" name="contact" class="form-control" placeholder="09XX-XXX-XXXX" required>
                </div>
                
                <div class="col-md-6">
                   <label class="form-label small text-muted fw-bold">VALID ID TYPE</label>
                   <select name="valid_id" class="form-select" required>
                      <option value="">-- Select ID --</option>
                      <option>Barangay ID</option>
                      <option>National ID</option>
                      <option>Voter's ID</option>
                      <option>Driver's License</option>
                    </select>
                </div>

                <div class="col-md-6">
                   <label class="form-label small text-muted fw-bold">UPLOAD YOUR ID</label>
                   <input type="file" name="valid_id_file" class="form-control" accept=".jpg,.jpeg,.png" required>
                   <small class="text-muted">Max size 2MB. JPG/PNG only.</small>
                </div>

                <div class="col-md-6">
                   <label class="form-label small text-muted fw-bold">ADDRESS</label>
                   <input type="text" name="address" class="form-control" placeholder="House No., Street, Purok" required>
                </div>

                <div class="col-md-12">
                    <hr class="my-4 text-muted opacity-25">
                </div>

                <div class="col-md-12">
                    <label class="form-label small text-muted fw-bold">DOCUMENT NEEDED</label>
                    <select name="document_type" id="document_type" class="form-select form-select-lg mb-2 border-primary" required onchange="showTime()">
                      <option value="">-- Choose Document --</option>
                      <option value="Barangay Clearance">Barangay Clearance</option>
                      <option value="Barangay Certificate">Barangay Certificate</option>
                      <option value="Certificate of Residency">Certificate of Residency</option>
                      <option value="Certificate of Indigency">Certificate of Indigency</option>
                      <option value="Certificate of Good Moral Character">Good Moral Character</option>
                      <option value="Business Clearance">Business Clearance</option>
                      <option value="Barangay Business Permit">Barangay Business Permit</option>
                      <option value="Barangay ID Application">Barangay ID Application</option>
                      <option value="Barangay ID Renewal">Barangay ID Renewal</option>
                      <option value="Senior Citizen Certification">Senior Citizen Certification</option>
                      <option value="PWD Certification">PWD Certification</option>
                      <option value="Blotter Report Request">Blotter Report Request</option>
                      <option value="Incident Report">Incident Report</option>
                    </select>

                    <div id="processing_time" class="alert alert-info d-none d-flex align-items-center py-2">
                        <i class="bi bi-clock me-2"></i>
                        <span id="time_text" class="small fw-bold"></span>
                    </div>
                </div>

                <div class="col-md-12">
                   <label class="form-label small text-muted fw-bold">PURPOSE</label>
                   <textarea name="purpose" class="form-control" rows="2" placeholder="Where will you use this document?" required></textarea>
                </div>
                
                <div class="col-12 mt-4">
                  <button name="submit" class="btn btn-primary w-100 py-3 fw-bold rounded-3 shadow-sm">
                    Submit Request <i class="bi bi-arrow-right ms-2"></i>
                  </button>
                </div>
              </div>
            </form>
          </div>
        <?php endif; ?>
        
      </div>
    </div>
  </div>
</div>

<!-- TRACK SECTION -->
<div class="container pb-5 <?php echo isset($_POST['track']) ? '' : 'd-none'; ?>" id="track_section">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card main-card border-top border-4 border-success">
        <div class="card-body p-5 text-center">
          <h4 class="fw-bold mb-3">Track Your Request</h4>

          <form method="POST">
            <div class="input-group mb-3">
              <input type="text" name="track_no"
                     class="form-control form-control-lg"
                     placeholder="Enter Control No."
                     value="<?php echo isset($_POST['track_no']) ? htmlspecialchars($_POST['track_no']) : ''; ?>"
                     required>
              <button name="track" class="btn btn-success px-4">Search</button>
            </div>
          </form>

          <?php
          if (isset($_POST['track'])) {
              $code = mysqli_real_escape_string($conn, $_POST['track_no']);
              $res = mysqli_query($conn, "SELECT status, valid_id_file, admin_remarks FROM requests WHERE control_no='$code'");

              if (mysqli_num_rows($res) > 0) {
                  $row = mysqli_fetch_assoc($res);
                  $status = $row['status'];
                  $badge_class = "bg-warning";
                  if($status=="Approved") $badge_class="bg-success";
                  if($status=="Released") $badge_class="bg-primary";

                  echo "<div class='alert $badge_class mt-3 fw-bold'>Status: $status</div>";
                  if(!empty($row['admin_remarks'])) echo "<div class='text-muted small mt-1'>Remarks: ".$row['admin_remarks']."</div>";
              } else {
                  echo "<div class='alert alert-danger mt-3'>Control Number not found.</div>";
              }
          }
          ?>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- FOOTER -->
<footer class="text-center">
  <p class="mb-0">&copy; <?php echo date('Y'); ?> Barangay Dimakita. All rights reserved.</p>
</footer>

<!-- SCRIPTS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
  // Show Request Form
  function showRequestForm(){
    const card = document.getElementById('request_form_card');
    if(card.classList.contains('d-none')){
      card.classList.remove('d-none');
      card.scrollIntoView({behavior: 'smooth'});
    }
  }

  // Show Track Section
  function showTrack(){
    const trackSection = document.getElementById('track_section');
    if(trackSection.classList.contains('d-none')){
      trackSection.classList.remove('d-none');
      trackSection.scrollIntoView({behavior: 'smooth'});
    }
  }

  // Show Estimated Processing Time
  function showTime(){
    const doc = document.getElementById('document_type').value;
    const timeDiv = document.getElementById('processing_time');
    const timeText = document.getElementById('time_text');
    let msg = "";
    switch(doc){
      case "Barangay Clearance": msg="Processing: 1-2 business days"; break;
      case "Certificate of Residency": msg="Processing: 1 day"; break;
      case "Barangay ID Application":
      case "Barangay ID Renewal": msg="Processing: 3-5 business days"; break;
      case "Blotter Report Request":
      case "Incident Report": msg="Processing: 2-3 business days"; break;
      default: msg="Processing: 1-2 business days";
    }
    if(doc==""){
      timeDiv.classList.add('d-none');
    } else {
      timeDiv.classList.remove('d-none');
      timeText.textContent = msg;
    }
  }
</script>

</body> 
<script>
<?php if (isset($_POST['submit'])): ?>
document.addEventListener("DOMContentLoaded", function () {
    const card = document.getElementById("request_form_card");
    if(card){
        card.classList.remove("d-none");
        card.scrollIntoView({ behavior: "smooth" });
    }
});
<?php endif; ?>
</script>

</html>
