<?php
include "config.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['id'])) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['id'];
    $procedure_id = (int)$_POST['procedure_id'];
    $rating = (int)$_POST['rating'];

    if ($rating < 1 || $rating > 5) {
        echo "Невалидна оценка.";
        exit();
    }

    // Проверка дали вече съществува оценка
    $check_query = "
        SELECT id FROM ratings 
        WHERE user_id = '$user_id' AND procedure_id = '$procedure_id'
    ";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // Презаписване на съществуващата оценка
        $update_query = "
            UPDATE ratings 
            SET rating = '$rating'
            WHERE user_id = '$user_id' AND procedure_id = '$procedure_id'
        ";
        mysqli_query($conn, $update_query);
    } else {
        // Добавяне на нова оценка
        $insert_query = "
            INSERT INTO ratings (user_id, procedure_id, rating) 
            VALUES ('$user_id', '$procedure_id', '$rating')
        ";
        mysqli_query($conn, $insert_query);
    }

    $_SESSION['rating_success'] = "Вашата оценка беше записана успешно!";
    header('Location: profile.php');
    exit();
}
?>