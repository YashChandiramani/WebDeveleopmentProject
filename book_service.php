 


<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Database connection
$servername = "sql208.infinityfree.com";
$username = "if0_39793259";
$password = "rJ3eT21uNqGrd";
$database = "if0_39793259_cj_service_center"; 

        $conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($_SERVER["REQUEST_METHOD"] === "POST") {
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get and sanitize form data
$customer_name = strtoupper(trim($_POST['name']));
$customer_phone = trim($_POST['phone']);
$customer_email = trim($_POST['email_id']);
$registration_number = strtoupper(trim($_POST['vehicle']));
$company_name = trim($_POST['company_name']);
$model_name = trim($_POST['model_name']);
$service_chosen = trim($_POST['service_chosen']);
$preferred_date = $_POST['date'];
$payment_method = isset($_POST['payment']) ? strtolower(trim($_POST['payment'])) : 'on delivery';

// Step 1: Insert customer data
$insertCustomer = "INSERT INTO cj_customer (customer_name, customer_phone, customer_email_id)
                   VALUES (?, ?, ?)";
$stmt1 = $conn->prepare($insertCustomer);
$stmt1->bind_param("sss", $customer_name, $customer_phone, $customer_email);

if (!$stmt1->execute()) {
    echo "Error inserting customer data: " . $stmt1->error;
    exit();
}

// Step 2: Insert vehicle data
$date_of_booking_service = date('Y-m-d'); // today’s date

$insertVehicle = "INSERT INTO cj_vehicle (
                    registration_number,
                    company_name,
                    model_name,
                    date_of_booking_service,
                    preferred_date,
                    service_chosen
                  ) VALUES (?, ?, ?, ?, ?, ?)";

$stmt2 = $conn->prepare($insertVehicle);
$stmt2->bind_param("ssssss",
    $registration_number,
    $company_name,
    $model_name,
    $date_of_booking_service,
    $preferred_date,
    $service_chosen
);

if ($stmt2->execute()) {
    echo "<script>alert('Booking successful!'); window.location.href = 'index.html';</script>";
} else {
    echo "Error inserting vehicle data: " . $stmt2->error;
}

// Close connections
$stmt1->close();
$stmt2->close();
$conn->close();
} else {
    echo "Method not allowed";
}
?