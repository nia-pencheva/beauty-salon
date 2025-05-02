<?php
session_start();
$is_logged_in = isset($_SESSION['id']) && $_SESSION['id'];

$_SESSION['procedure_id'] = $_GET['procedure_id'] ?? null;

if(!$is_logged_in) {
    header("Location: login.php?redirect=bookingRedirect.php?procedure_id=".$_SESSION['procedure_id']);
    exit;
}
else {
    header('Location: bookingAvailability.php?procedure_id='.$_SESSION['procedure_id']);
}