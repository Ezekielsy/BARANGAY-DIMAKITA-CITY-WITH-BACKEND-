<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome to Brgy Dimakita Online Portal</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  
  <style>
    /* ROOT COLORS */
    :root {
      --primary-color: #2a5298;
      --secondary-color: #1e3c72;
      --accent-color: #00c6ff;
    }

    body {
      font-family: 'Poppins', sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f4f7f6;
      color: #333;
      overflow-x: hidden;
    }

    /* HERO SECTION */
    .hero {
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
      color: white;
      padding: 0 20px;
    }

    .hero h1 {
      font-weight: 700;
      font-size: 3rem;
      margin-bottom: 20px;
    }

    .hero p {
      font-size: 1.2rem;
      margin-bottom: 30px;
      opacity: 0.85;
    }

    .btn-primary {
      background-color: white;
      color: var(--primary-color);
      padding: 12px 30px;
      border-radius: 30px;
      font-weight: 600;
      transition: all 0.3s;
    }

    .btn-primary:hover {
      background-color: var(--accent-color);
      color: white;
      transform: translateY(-3px);
      box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    /* FADE-IN ANIMATION */
    .fade-in {
      opacity: 0;
      transform: translateY(20px);
      animation: fadeInUp 1s forwards;
      animation-play-state: running;
    }

    .fade-in.delay-1 { animation-delay: 0.3s; }
    .fade-in.delay-2 { animation-delay: 0.6s; }
    .fade-in.delay-3 { animation-delay: 0.9s; }

    @keyframes fadeInUp {
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* SERVICES PREVIEW */
    .services {
      padding: 80px 20px;
      background-color: #fff;
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
    .services h5 { font-weight: 600; margin-bottom: 10px; }
    .services p { font-size: 0.9rem; color: #666; }

    /* FOOTER */
    footer {
      background: #343a40;
      color: #adb5bd;
      padding: 40px 0;
      text-align: center;
    }

    @media(max-width:768px){
      .hero h1 { font-size: 2.2rem; }
      .hero p { font-size: 1rem; }
    }

  </style>
</head>
<body>


  <!-- HERO SECTION -->
  <section class="hero">
    <div>
      <h1 class="fade-in delay-1">Welcome to Barangay Dimakita Online Portal</h1>
      <p class="fade-in delay-2">Fast, transparent, and convenient document processing for all residents.</p>
      <a href="index.php" class="btn btn-primary fade-in delay-3">Go to Portal</a>
    </div>
  </section>

  <!-- SERVICES PREVIEW -->
  <section class="services container">
    <div class="text-center mb-5 fade-in delay-1">
      <span class="badge bg-primary mb-3 px-3 py-2 rounded-pill text-uppercase" style="letter-spacing:2px; font-size:0.8rem;">Services</span>
      <h2 class="fw-bold">Our Services</h2>
      <p class="text-muted small">Quick overview of the documents you can request online</p>
    </div>

    <div class="row g-4">
      <div class="col-md-4 fade-in delay-2">
        <div class="service-card">
          <div class="icon-box"><i class="bi bi-file-earmark-text"></i></div>
          <h5>Certifications</h5>
          <p>Request Barangay Clearance, Residency, or Indigency Certificates easily online.</p>
        </div>
      </div>
      <div class="col-md-4 fade-in delay-3">
        <div class="service-card">
          <div class="icon-box"><i class="bi bi-person-vcard"></i></div>
          <h5>Barangay ID</h5>
          <p>Apply for a new Barangay ID or renew your existing one conveniently online.</p>
        </div>
      </div>
      <div class="col-md-4 fade-in delay-3">
        <div class="service-card">
          <div class="icon-box"><i class="bi bi-shield-check"></i></div>
          <h5>Reports & Blotter</h5>
          <p>File incident reports or request blotter copies securely through the portal.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- FOOTER -->
  <footer>
    <p class="mb-0 small">&copy; <?php echo date("Y"); ?> Barangay Dimakita. All rights reserved.</p>
  </footer>

  <!-- BOOTSTRAP JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
