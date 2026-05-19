 <?php
session_start();
session_unset();
session_destroy();

// Redirect to homepage with logout success
header("Location: index.html?logout=success");
exit();
?