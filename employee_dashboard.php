 <?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['emp_id']) || !isset($_SESSION['emp_name'])) {
    header("Location: employee_login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Employee Dashboard - C&J Vehicle Service Center</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="css/style.css" />

  <style>
    .logo-container {
  display: flex;
  align-items: center;
  gap:10px;
    }

.logo {
  height: auto;
  width: 150px;
  margin-right: 10px;
}

    body {
      font-family: 'Roboto', sans-serif;
      background-color: #f1f1f1;
    }
    .brand-name, h1 {
      font-family: 'Pacifico', cursive;
    }
    .dashboard-box {
      margin-top: 40px;
      background: #fff;
      border-radius: 10px;
      padding: 40px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
  </style>
</head>

<body>

  <!-- Header -->
  <header class="navbar navbar-expand-lg navbar-dark bg-dark px-4">
    <a href="employee_dashboard.php" class="navbar-brand d-flex align-items-center">
      <img src="images/logo.png" alt="Logo" width="50" height="50" />
      <span class="ms-2 brand-name">C&J Vehicle Service Center</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <nav class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link text-white" href="index.html" target="_blank">Home</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="about.html" target="_blank">About Us</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="contact.html" target="_blank">Contact</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="faq.html" target="_blank">FAQ</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="feedback_form.html" target="_blank">Feedback</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="book_service.html" target="_blank">Book Service</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="track.html" target="_blank">Track Status</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
      </ul>
    </nav>
  </header>

  <!-- Dashboard Content -->
  <div class="container">
    <div class="dashboard-box text-center">
      <h1>Hello, <?php echo htmlspecialchars($_SESSION['emp_name']); ?>!</h1>
      <p class="lead mt-3">Welcome to your employee dashboard.</p>
      <p>You can now manage <strong>Vehicle</strong> and <strong>Customer</strong> records below.</p>

      <!-- Action Buttons -->
      <div class="mt-4">
        <a href="vehicle_management.php" class="btn btn-dark btn-lg me-3">
          <i class="fas fa-car"></i> Manage Vehicles
        </a>
        <a href="customer_management.php" class="btn btn-outline-dark btn-lg">
          <i class="fas fa-users"></i> Manage Customers
        </a>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html