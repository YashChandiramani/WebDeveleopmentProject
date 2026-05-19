 <?php
$vehicleData = null;
$message = "";


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["registration_number"])) {
    $registration = trim($_POST["registration_number"]);

    $servername = "sql208.infinityfree.com";
    $username = "if0_39793259";
    $password = "rJ3eT21uNqGrd";
    $database = "if0_39793259_cj_service_center"; 

    // Connect to your MySQL database
   $conn = new mysqli($servername, $username, $password, $database); // <-- Update DB name if needed

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to fetch vehicle data
    $stmt = $conn->prepare("SELECT * FROM cj_vehicle WHERE registration_number = ?");
    $stmt->bind_param("s", $registration);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $vehicleData = $result->fetch_assoc();
    } else {
        $message = "No record found for Registration Number: <strong>" . htmlspecialchars($registration) . "</strong>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Service Status Result - C&J</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body {
      font-family: 'Roboto', sans-serif;
      background-color: #f8f9fa;
      padding: 40px;
      text-align: center;
    }

    .result-card {
      max-width: 600px;
      margin: 0 auto;
      background-color: #fff;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }

    .result-card h2 {
      font-family: 'Pacifico', cursive;
      margin-bottom: 20px;
    }

    .result-table {
      width: 100%;
      text-align: left;
      margin-top: 20px;
    }

    .result-table td {
      padding: 8px 0;
      font-size: 16px;
    }

    .status-label {
      font-weight: bold;
      color: #f4a261;
    }

    .message {
      color: red;
      font-size: 18px;
      margin-top: 20px;
    }

    a.button {
      display: inline-block;
      margin-top: 25px;
      background-color: #e76f51;
      color: white;
      text-decoration: none;
      padding: 10px 20px;
      border-radius: 8px;
      font-size: 16px;
    }

    a.button:hover {
      background-color: #f4a261;
    }
  </style>
</head>
<body>

  <div class="result-card">
    <h2>Service Status</h2>

    <?php if ($vehicleData): ?>
      <table class="result-table">
        <tr>
          <td class="status-label">Registration Number:</td>
          <td><?= htmlspecialchars($vehicleData['registration_number']) ?></td>
        </tr>
        <tr>
          <td class="status-label">Company:</td>
          <td><?= htmlspecialchars($vehicleData['company_name']) ?></td>
        </tr>
        <tr>
          <td class="status-label">Model:</td>
          <td><?= htmlspecialchars($vehicleData['model_name']) ?></td>
        </tr>
        <tr>
          <td class="status-label">Booking Date:</td>
          <td><?= htmlspecialchars($vehicleData['date_of_booking_service']) ?></td>
        </tr>
        <tr>
          <td class="status-label">Preferred Date:</td>
          <td><?= htmlspecialchars($vehicleData['preferred_date']) ?></td>
        </tr>
        <tr>
          <td class="status-label">Service Chosen:</td>
          <td><?= htmlspecialchars($vehicleData['service_chosen']) ?></td>
        </tr>
        <tr>
          <td class="status-label">Service Amount:</td>
          <td>₹<?= htmlspecialchars($vehicleData['service_amount']) ?></td>
        </tr>
        <tr>
          <td class="status-label">Service Status:</td>
          <td><?= htmlspecialchars($vehicleData['status']) ?></td>
        </tr>
        <tr>
          <td class="status-label">Payment Status:</td>
          <td><?= htmlspecialchars($vehicleData['payment_status']) ?></td>
        </tr>
      </table>
    <?php else: ?>
      <p class="message"><?= $message ?></p>
    <?php endif; ?>

    <a class="button" href="track.html">← Back to Tracking</a>
  </div>

</body>
</html