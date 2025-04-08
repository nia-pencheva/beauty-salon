<?php
session_start();

// Destroy all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect to the home page with a success message in the URL
header('Location: index.php?logout=success');
exit;
?>
