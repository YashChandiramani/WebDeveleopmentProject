 <?php
$servername = "sql208.infinityfree.com";
$username = "if0_39793259";
$password = "rJ3eT21uNqGrd";
$database = "if0_39793259_cj_service_center"; 

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT name, rating, message, created_at FROM feedback ORDER BY created_at DESC LIMIT 1";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Use real Unicode stars
    $stars = str_repeat("★", intval($row['rating'])) . str_repeat("☆", 5 - intval($row['rating']));

    // Output card
    echo '
    <div style="max-width: 500px; margin: 40px auto; padding: 20px; background-color: #f8f9fa; border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); font-family: Arial, sans-serif;">
        <h3 style="font-family: Pacifico, cursive; text-align: center; color: #ffc107;">What Our Customers Say</h3>
        <h5 style="text-align: center; color: #333; font-size:22">' . htmlspecialchars($row['name']) . '</h5>
        <p style="font-style: italic; text-align: center;">"' . htmlspecialchars($row['message']) . '"</p>
        <p style="text-align: center; color: #ffc107; font-size: 20px;">' . $stars . '</p>
        <p style="text-align: center; color: #666;">Submitted on: ' . date("d M Y", strtotime($row['created_at'])) . '</p>
    </div>';
  // Return Button 
  echo '
        <div style="display: flex; justify-content: center; align-items: center; width: 100%; margin: 40px 0;">
  <a href="feedback_form.html" 
     class="btn"
     style="background-color: #f4a261; color: black;  padding: 12px 30px; text-align: center;
     font-family: Pacifico, cursive;">
    Return to Feedback Form
  </a>
</div>';


}
?