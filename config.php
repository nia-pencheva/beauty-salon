<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'restaurantreview';

$conn = new mysqli($host, $user, $password, $dbname);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if ($conn->connect_error) {
    error_log("Database connection failed: " . $conn->connect_error);
    echo "An error occurred while connecting to the database.";
    exit;
}

?>

