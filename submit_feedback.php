 <?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve and sanitize input
    $name = trim($_POST['name']);
    $email_id = trim($_POST['email_id']);
    $rating = intval($_POST['rating']);
    $message = trim($_POST['message']);

    // Validate all fields
    if (!empty($name) && !empty($email_id) && !empty($rating) && !empty($message)) {
        if (!filter_var($email_id, FILTER_VALIDATE_EMAIL)) {
            die("Invalid email format.");
        }

        // DB connection parameters
        $servername = "sql208.infinityfree.com";
        $username = "if0_39793259";
        $password = "rJ3eT21uNqGrd";
        $database = "if0_39793259_cj_service_center"; 

        $conn = new mysqli($servername, $username, $password, $database);

        // Check connection
        if ($conn->connect_error) {
    die("❌ Connection failed: (" . $conn->connect_errno . ") " . $conn->connect_error);
}

        // Prepare and execute SQL statement
        $stmt = $conn->prepare("INSERT INTO feedback (name, email_id, rating, message) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssis", $name, $email_id, $rating, $message);

        if ($stmt->execute()) {
            echo "<h2>✅ Thank you for your feedback, $name!</h2>";
            echo "<p><a href='feedback_form.html'>Submit another response</a></p>";
        } else {
            echo "❌ Error submitting feedback: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "⚠ All fields are required.";
    }
} else {
    echo "Invalid request.";
}
?