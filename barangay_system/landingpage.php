<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Web-Based Barangay Document Request and Tracking System for Barangay Dimakita, San Lupalok City</title>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>
:root{
  --primary:#2a5298;
  --secondary:#1e3c72;
  --accent:#00c6ff;
}

body{
  font-family:'Poppins',sans-serif;
  background:#0f172a;
  overflow-x:hidden;
  color:#fff;
}

/* ===== HERO ===== */
.hero{
  height:100vh;
  display:flex;
  align-items:center;
  justify-content:center;
  position:relative;
  overflow:hidden;
}

/* ===== ABSTRACT BLOBS ===== */
.blob{
  position:absolute;
  border-radius:50%;
  filter:blur(80px);
  opacity:.45;
  animation: floatBlob 14s infinite alternate;
}

.blob.one{
  width:550px;
  height:550px;
  background:#00c6ff;
  top:-150px;
  left:-150px;
}

.blob.two{
  width:450px;
  height:450px;
  background:#4f46e5;
  bottom:-150px;
  right:-100px;
  animation-duration:18s;
}

.blob.three{
  width:350px;
  height:350px;
  background:#38bdf8;
  top:30%;
  right:10%;
  animation-duration:22s;
}

@keyframes floatBlob{
  0%{transform:translate(0,0)}
  50%{transform:translate(80px,-60px)}
  100%{transform:translate(-60px,40px)}
}

/* ===== GLASS CARD ===== */
.glass{
  backdrop-filter: blur(18px);
  -webkit-backdrop-filter: blur(18px);
  background:rgba(255,255,255,.12);
  border-radius:25px;
  padding:60px 50px;
  border:1px solid rgba(255,255,255,.25);
  box-shadow:0 30px 60px rgba(0,0,0,.4);
  text-align:center;
  animation: popIn 1.2s ease forwards;
}

@keyframes popIn{
  from{opacity:0; transform:scale(.85) translateY(40px)}
  to{opacity:1; transform:scale(1) translateY(0)}
}

.glass h1{
  font-size:3rem;
  font-weight:700;
}

.glass p{
  font-size:1.2rem;
  opacity:.85;
}

/* ===== BUTTON ===== */
.btn-portal{
  background:linear-gradient(120deg,#00c6ff,#4f46e5);
  border:none;
  padding:14px 38px;
  border-radius:30px;
  font-weight:600;
  color:#fff;
  position:relative;
  overflow:hidden;
  transition:.4s;
}

.btn-portal::after{
  content:"";
  position:absolute;
  inset:0;
  background:linear-gradient(120deg,transparent,rgba(255,255,255,.6),transparent);
  transform:translateX(-100%);
  transition:.6s;
}

.btn-portal:hover::after{
  transform:translateX(100%);
}

.btn-portal:hover{
  transform:translateY(-4px) scale(1.05);
  box-shadow:0 15px 35px rgba(0,0,0,.4);
}

/* ===== SERVICES ===== */
.services{
  padding:120px 20px;
  background:#f8fafc;
  color:#111;
}

.service-card{
  background:white;
  border-radius:22px;
  padding:35px;
  text-align:center;
  box-shadow:0 15px 30px rgba(0,0,0,.08);
  transition:.5s;
}

.service-card:hover{
  transform:translateY(-18px) rotateX(6deg);
  box-shadow:0 30px 50px rgba(0,0,0,.15);
}

.icon-box{
  font-size:3rem;
  color:var(--primary);
  margin-bottom:15px;
}

/* ===== FOOTER ===== */
footer{
  background:#020617;
  color:#94a3b8;
  padding:40px 0;
}

/* MOBILE */
@media(max-width:768px){
  .glass h1{font-size:2.2rem}
  .glass p{font-size:1rem}
}

/* ===== DARK SERVICES ===== */
.services-dark{
  padding:120px 20px;
  background:radial-gradient(circle at top, #1e293b, #020617);
  position:relative;
  overflow:hidden;
}

/* subtle background glow */
.services-dark::before{
  content:"";
  position:absolute;
  width:500px;
  height:500px;
  background:#00c6ff;
  opacity:.15;
  filter:blur(140px);
  top:-150px;
  left:-150px;
}

.glow-badge{
  background:linear-gradient(120deg,#00c6ff,#4f46e5);
  letter-spacing:2px;
  font-size:.75rem;
}

/* glass cards */
.service-glass{
  background:rgba(255,255,255,.1);
  backdrop-filter:blur(14px);
  -webkit-backdrop-filter:blur(14px);
  border-radius:22px;
  padding:40px 30px;
  text-align:center;
  color:#fff;
  border:1px solid rgba(255,255,255,.18);
  box-shadow:0 25px 50px rgba(0,0,0,.45);
  transition:.6s;
}

.service-glass h5{
  font-weight:600;
  margin-top:15px;
}

.service-glass p{
  font-size:.9rem;
  opacity:.75;
}

/* icon glow */
.icon-glow{
  font-size:3rem;
  color:#38bdf8;
  text-shadow:0 0 25px rgba(56,189,248,.8);
}

/* hover effect */
.service-glass:hover{
  transform:translateY(-20px) scale(1.03);
  box-shadow:0 40px 80px rgba(0,0,0,.6);
  border-color:#38bdf8;
}


</style>
</head>

<body>

<!-- HERO -->
<section class="hero">

  <!-- BLOBS -->
  <div class="blob one"></div>
  <div class="blob two"></div>
  <div class="blob three"></div>

  <!-- GLASS CONTENT -->
  <div class="glass">
    <h1>Web-Based Barangay Document Request & Tracking System</h1>
    <p class="mt-3">
      For Barangay Dimakita, San Lupalok City – fast, transparent, and convenient document processing for all residents.
    </p>
    <a href="index.php" class="btn btn-portal mt-4">Go to Portal</a>
  </div>



</section>

<!-- SERVICES -->
<section class="services-dark">
  <div class="container">

    <div class="text-center mb-5">
      <span class="badge glow-badge mb-3 px-3 py-2 rounded-pill text-uppercase">
        Services
      </span>
      <h2 class="fw-bold text-white">Our Services</h2>
      <p class="text-light opacity-75 small">
        Quick overview of the documents you can request online
      </p>
    </div>

    <div class="row g-4">
      <div class="col-md-4">
        <div class="service-glass">
          <div class="icon-glow"><i class="bi bi-file-earmark-text"></i></div>
          <h5>Certifications</h5>
          <p>Barangay Clearance, Residency & Indigency Certificates</p>
        </div>
      </div>

      <div class="col-md-4">
        <div class="service-glass">
          <div class="icon-glow"><i class="bi bi-person-vcard"></i></div>
          <h5>Barangay ID</h5>
          <p>New Application & Renewal made easy online</p>
        </div>
      </div>

      <div class="col-md-4">
        <div class="service-glass">
          <div class="icon-glow"><i class="bi bi-shield-check"></i></div>
          <h5>Reports & Blotter</h5>
          <p>Incident reports & blotter requests securely processed</p>
        </div>
      </div>
    </div>

  </div>
</section>


<!-- FOOTER -->
<footer class="text-center">
  <p class="mb-0 small">&copy; <?php echo date("Y"); ?> Barangay Dimakita. All rights reserved.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
