 <?php
session_start();

if (!isset($_SESSION['emp_id']) || !isset($_SESSION['emp_name'])) {
    header("Location: employee_login.html");
    exit();
}

// Connect to DB
    $servername = "sql208.infinityfree.com";
    $username = "if0_39793259";
    $password = "rJ3eT21uNqGrd";
    $database = "if0_39793259_cj_service_center"; 
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Add new customer
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_customer'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $stmt = $conn->prepare("INSERT INTO cj_customer (customer_name, customer_email_id, customer_phone) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $phone);
    $stmt->execute();
    $stmt->close();
}

//Delete Customer
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_customer'])) {
    $id = $_POST['customer_id'];

    $stmt = $conn->prepare("DELETE FROM cj_customer WHERE customer_id=?");
    $stmt->bind_param("s", $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "<div class='alert alert-success text-center'>Customer deleted successfully.</div>";
    } else {
        echo "<div class='alert alert-danger text-center'>No matching customer found.</div>";
    }

    $stmt->close();
}

//Update Customer
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_customer'])) {
    $id = $_POST['customer_id'];
    $name = $_POST['customer_name'];
    $email = $_POST['customer_email_id'];
    $phone = $_POST['customer_phone'];


    $stmt = $conn->prepare("UPDATE cj_customer SET customer_name = ?, customer_email_id = ?, customer_phone = ? WHERE customer_id = ?");
    $stmt->bind_param("ssss", $name, $email,$phone, $id);
    $stmt->execute();
    if ($stmt->affected_rows > 0) {
        echo "<div class='alert alert-success text-center'>Customer updated successfully.</div>";
    } else {
        echo "<div class='alert alert-danger text-center'>No matching customer found.</div>";
    }

    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Customer Management - C&J Vehicle Service Center</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
      margin-top: 30px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
  </style>
</head>
<body>
<header class="navbar navbar-expand-lg navbar-dark bg-dark px-4">
  <a href="employee_dashboard.php" class="navbar-brand d-flex align-items-center">
    <img src="images/logo.png" alt="Logo" width="50" height="50" />
    <span class="ms-2 brand-name">C&J Vehicle Service Center</span>
  </a>
  <nav class="collapse navbar-collapse justify-content-end" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item"><a class="nav-link text-white" href="employee_dashboard.php">Dashboard</a></li>
      <li class="nav-item"><a class="nav-link text-white" href="logout.php">Logout</a></li>
    </ul>
  </nav>
</header>

<div class="container">
  <div class="dashboard-box">
    <h2 class="text-center mb-4">Customer Management</h2>

    <!-- Add Customer -->
    <form method="POST" class="row g-3 mb-5">
      <input type="hidden" name="add_customer" value="1">
      <div class="col-md-4"><input type="text" name="name" class="form-control" placeholder="Customer Name" required></div>
      <div class="col-md-4"><input type="email" name="email" class="form-control" placeholder="Email ID" required></div>
      <div class="col-md-4"><input type="text" name="phone" class="form-control" placeholder="Phone Number" required></div>
      <div class="col-12 d-grid">
        <button type="submit" class="btn btn-dark">Add Customer</button>
      </div>
    </form>

  <!--Delete Customer-->
    <form method="POST" class="row g-3 mb-5">
  <input type="hidden" name="delete_customer" value="1">

  <div class="col-md-4">
    <input type="text" name="customer_id" class="form-control" placeholder="id" required>
  </div>

  <div class="col-12 d-grid">
    <button type="submit" class="btn btn-dark">Delete Customer</button>
  </div>
</form>


<!--Update Customer-->
    <form method="POST" class="row g-3 mb-5">
  <input type="hidden" name="update_customer" value="1">

  <div class="col-md-4">
    <input type="text" name="customer_id" class="form-control" placeholder="ID" required>
  </div>

  <div class="col-md-4">
    <input type="text" name="customer_name" class="form-control" placeholder="Customer Name" required>
  </div>

  <div class="col-md-4">
    <input type="text" name="customer_phone" class="form-control" placeholder="Phone Number" required>
  </div>

  <div class="col-md-4">
    <input type="text" name="customer_email_id" class="form-control" placeholder="Email ID" required>
  </div>

  <div class="col-12 d-grid">
    <button type="submit" class="btn btn-dark">Update Customer</button>
  </div>
</form>


    <!-- Customer List -->
    <div class="table-responsive">
      <table class="table table-bordered table-striped">
        <thead class="table-dark">
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email ID</th>
            <th>Phone</th>
            <th>Created At</th>
          </tr>
        </thead>
        <tbody>
        <?php
        $result = $conn->query("SELECT * FROM cj_customer ORDER BY customer_id DESC");
        while ($row = $result->fetch_assoc()) {
          echo "<tr>
            <td>{$row['customer_id']}</td>
            <td>{$row['customer_name']}</td>
            <td>{$row['customer_email_id']}</td>
            <td>{$row['customer_phone']}</td>
            <td>{$row['created_at']}</td>
          </tr>";
        }
        ?>
        </tbody>
      </table>
    </div>

  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html