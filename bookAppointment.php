<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php?redirect=" . urlencode($_SERVER['REQUEST_URI']));
    exit;
}

include "config.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['id'];
    $procedure_id = $_POST['procedure_id'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $datetime = $date . ' ' . $time;

    try {
        $stmt = $conn->prepare("INSERT INTO booked_procedures 
                                (user_id, procedure_id, `date`, `time`) 
                                VALUES (?, ?, ?, ?)");
                                
        $stmt->bind_param("iiss", $user_id, $procedure_id, $date, $time);
        
        if (!$stmt->execute()) {
            throw new Exception("Грешка при запазване на час: " . $stmt->error);
        }
        
        $_SESSION['booking_success'] = "Резервацията е направена успешно!";
        header("Location: profile.php");
        exit;

    } catch (Exception $e) {
        $conn->rollback();
        header("Location: bookingAvailability.php?procedure_id=$procedure_id&error=" . urlencode($e->getMessage()));
        exit;
    } finally {
        if (isset($stmt)) {
            $stmt->close();
        }
    }
}
