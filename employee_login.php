 <?php
session_start();

// Database connection
$servername = "sql208.infinityfree.com";
$username = "if0_39793259";
$password = "rJ3eT21uNqGrd";
$database = "if0_39793259_cj_service_center"; 

        $conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form inputs safely
$emp_id = mysqli_real_escape_string($conn, $_POST['emp_id']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

// Check if employee exists
$sql = "SELECT * FROM cj_employee WHERE id = '$emp_id' LIMIT 1";
$result = $conn->query($sql);

if ($result && $result->num_rows === 1) {
    $row = $result->fetch_assoc();

    if ($row['password'] === $password) {
        // Login success
        $_SESSION['emp_id'] = $row['id'];
        $_SESSION['emp_name'] = $row['name'];
        header("Location: employee_dashboard.php");
        exit();
    } else {
        // Wrong password
        echo "<script>alert('Incorrect password'); window.location.href='employee_login.html';</script>";
    }
} else {
    // No such employee
    echo "<script>alert('Employee ID not found'); window.location.href='employee_login.html';</script>";
}

$conn->close();
?