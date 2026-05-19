 <?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['emp_id']) || !isset($_SESSION['emp_name'])) {
    header("Location: employee_login.html");
    exit();
}

// DB connection
    $servername = "sql208.infinityfree.com";
    $username = "if0_39793259";
    $password = "rJ3eT21uNqGrd";
    $database = "if0_39793259_cj_service_center"; 
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Feedback message
$alertMessage = "";

// Add vehicle
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_vehicle'])) {
    $reg = $_POST['registration_number'];
    $com = $_POST['company_name'];
    $mod = $_POST['model_name'];
    $dobs = $_POST['date_of_booking_service'];
    $pd = $_POST['preferred_date'];
    $sc = $_POST['service_chosen'];
    $sa = $_POST['service_amount'];
    $status = $_POST['status'];
    $payment = $_POST['payment_status'];

    $stmt = $conn->prepare("INSERT INTO cj_vehicle 
        (registration_number, company_name, model_name, date_of_booking_service, preferred_date, service_chosen, service_amount,status, payment_status) 
        VALUES (?,?, ?,?,?,?, ?,?,?)");
    $stmt->bind_param("sssssssss", $reg, $com,$mod,$dobs,$pd,$sc,$sa, $status, $payment);
    
    if ($stmt->execute()) {
        $alertMessage = "<div class='alert alert-success text-center'>Vehicle Added Successfully.</div>";
    } else {
        $alertMessage = "<div class='alert alert-danger text-center'>Error Adding Vehicle.</div>";
    }
    $stmt->close();
}

// Delete vehicle
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_vehicle'])) {
    $reg = $_POST['registration_number'];

    $stmt = $conn->prepare("DELETE FROM cj_vehicle WHERE registration_number=?");
    $stmt->bind_param("s", $reg);
    
    if ($stmt->execute()) {
        $alertMessage = "<div class='alert alert-success text-center'>Vehicle Deleted Successfully.</div>";
    } else {
        $alertMessage = "<div class='alert alert-danger text-center'>Error Deleting Vehicle.</div>";
    }
    $stmt->close();
}


//Update Vehicle
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_vehicle'])) {
    $reg = $_POST['registration_number'];
    $status = $_POST['status'];
    $payment = $_POST['payment_status'];


    $stmt = $conn->prepare("UPDATE cj_vehicle SET  status = ?, payment_status = ? WHERE registration_number = ?");
    $stmt->bind_param("sss", $status, $payment,$reg);
    $stmt->execute();
    if ($stmt->affected_rows > 0) {
        echo "<div class='alert alert-success text-center'>Vehicle Updated Successfully.</div>";
    } else {
        echo "<div class='alert alert-danger text-center'>No matching vehicle found.</div>";
    }

    $stmt->close();
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Vehicle Management - C&J Service Center</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

  <style>
    body {
      font-family: 'Roboto', sans-serif;
      background-color: #f8f9fa;
    }
    .brand-name {
      font-family: 'Pacifico', cursive;
    }
    .dashboard-box {
      background: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      margin-top: 30px;
    }
    table th, table td {
      vertical-align: middle;
    }
    .form-select-sm {
      padding: 0.25rem;
      font-size: 0.8rem;
    }
  </style>
</head>

<body>
  <!-- Navbar -->
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
        <li class="nav-item"><a class="nav-link text-white" href="employee_dashboard.php">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="logout.php">Logout</a></li>
      </ul>
    </nav>
  </header>

  <div class="container">
    <div class="dashboard-box">
      <h2 class="text-center mb-4">Vehicle Management</h2>

      <?php echo $alertMessage; ?>

      <!-- Add Vehicle Form -->
      <form method="POST" class="row g-3 mb-5">
        <input type="hidden" name="add_vehicle" value="1">
        <div class="col-md-4"><input type="text" name="registration_number" class="form-control" placeholder="Registration Number" required></div>
        <div class="col-md-4"><input type="text" name="company_name" class="form-control" placeholder="Company Name" required></div>
        <div class="col-md-4"><input type="text" name="model_name" class="form-control" placeholder="Model Name" required></div>
        <div class="col-md-4"><input type="date" name="date_of_booking_service" class="form-control" required></div>
        <div class="col-md-4"><input type="date" name="preferred_date" class="form-control"></div>
        <div class="col-md-4">
          <select name="service_chosen" class="form-select" required>
            <option selected disabled>Service</option>
            <option>Oil Change</option>
            <option>General Service</option>
            <option>Battery Service</option>
          </select>
        </div>
        <div class="col-md-4">
          <select name="status" class="form-select">
            <option value="pending">Pending</option>
            <option value="in_progress">In Progress</option>
            <option value="completed">Completed</option>
          </select>
        </div>
        <div class="col-md-4">
          <select name="payment_status" class="form-select">
            <option value="unpaid">Unpaid</option>
            <option value="paid">Paid</option>
          </select>
        </div>
        <div class="col-md-4 d-grid">
          <button type="submit" class="btn btn-dark">Add Vehicle</button>
        </div>
      </form>



      <!--Delete Vehicle Form-->
    <form method="POST" class="row g-3 mb-5">
  <input type="hidden" name="delete_vehicle" value="1">

  <div class="col-md-4">
    <input type="text" name="registration_number" class="form-control" placeholder="Registration Number" required>
  </div>

  <div class="col-12 d-grid">
    <button type="submit" class="btn btn-dark">Delete Vehicle Service Data</button>
  </div>
</form>

<!--Update Vehicle Form-->
    <form method="POST" class="row g-3 mb-5">
  <input type="hidden" name="update_vehicle" value="1">

  <div class="col-md-4">
    <input type="text" name="registration_number" class="form-control" placeholder="Registration Number" required>
  </div>

<div class="col-md-4">
          <select name="status" class="form-select">
            <option value="pending">Pending</option>
            <option value="in_progress">In Progress</option>
            <option value="completed">Completed</option>
          </select>
        </div>
        <div class="col-md-4">
          <select name="payment_status" class="form-select">
            <option value="unpaid">Unpaid</option>
            <option value="paid">Paid</option>
          </select>
        </div>
        <div class="col-md-4 d-grid">
          <button type="submit" class="btn btn-dark">Update Vehicle</button>
        </div>
      </form>


      <!-- Customer List -->
    <div class="table-responsive">
      <table class="table table-bordered table-striped">
        <thead class="table-dark">
          <tr>
            <th>Registration Number</th>
            <th>Company Name</th>
            <th>Model Name</th>
            <th>Date of Booking Service</th>
            <th>Preferred Date</th>
            <th>Service Choosen</th>
            <th>Service Amount</th>
            <th>Status</th>
            <th>Payment Status</th>
          </tr>
        </thead>
        <tbody>
        <?php
        $result = $conn->query("SELECT * FROM cj_vehicle ORDER BY date_of_booking_service DESC");
        while ($row = $result->fetch_assoc()) {
          echo "<tr>
            <td>{$row['registration_number']}</td>
            <td>{$row['company_name']}</td>
            <td>{$row['model_name']}</td>
            <td>{$row['date_of_booking_service']}</td>
            <td>{$row['preferred_date']}</td>
            <td>{$row['service_chosen']}</td>
            <td>{$row['service_amount']}</td>
            <td>{$row['status']}</td>
            <td>{$row['payment_status']}</td>
          </tr>";
        }
        ?>
        </tbody>
      </table>
    </div>

  </div>
</div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>