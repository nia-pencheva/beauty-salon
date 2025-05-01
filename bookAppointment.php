<?php
session_start();

// Проверка дали потребителят е влязъл
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

include 'config.php';

// Обработваме заявката за записване на час
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['id'];
    $service_id = $_POST['service_id']; // Избрана услуга
    $appointment_time = $_POST['appointment_time']; // Избрано време

    // Проверка дали часът е в работното време
    $appointment_timestamp = strtotime($appointment_time);
    $day_of_week = date('w', $appointment_timestamp);
    $hour_of_day = date('H', $appointment_timestamp);

    // Проверка дали времето е между 9:00 и 18:00 в работни дни
    if ($day_of_week >= 1 && $day_of_week <= 5 && $hour_of_day >= 9 && $hour_of_day < 18) {
        // Проверка дали вече има записан час
        $stmt = $conn->prepare("SELECT * FROM appointments WHERE user_id = ? AND service_id = ? AND appointment_time = ?");
        $stmt->bind_param("iis", $user_id, $service_id, $appointment_time);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<div class='error-message'>Вече имате запазен час за тази услуга в избраното време.</div>";
        } else {
            // Записваме новия час в базата данни
            $stmt = $conn->prepare("INSERT INTO appointments (user_id, service_id, appointment_time) VALUES (?, ?, ?)");
            $stmt->bind_param("iis", $user_id, $service_id, $appointment_time);

            if ($stmt->execute()) {
                echo "<div class='success-message'>Часът беше успешно записан!</div>";
            } else {
                echo "<div class='error-message'>Грешка при записване на часа: " . $stmt->error . "</div>";
            }
        }

        $stmt->close();
    } else {
        echo "<div class='error-message'>Часът трябва да бъде в работното време (Понеделник - Петък, 9:00 - 18:00).</div>";
    }
}

// Извличаме всички записани часове за потребителя
$user_id = $_SESSION['id'];
$sql = "SELECT a.id, a.appointment_time, s.name AS service_name 
        FROM appointments a 
        JOIN cosmetic_services s ON a.service_id = s.id 
        WHERE a.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <title>Записване на час</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            padding: 40px;
        }

        h1 {
            color: #7db89e;
            font-size: 2.5em;
            text-align: center;
            margin-bottom: 40px;
        }

        .form-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border: 1px solid #e0e0e0;
        }

        label {
            font-weight: bold;
            margin-bottom: 10px;
            display: block;
        }

        select, input[type="datetime-local"] {
            width: 100%;
            padding: 12px;
            border-radius: 6px;
            border: 1px solid #ccc;
            margin-bottom: 20px;
            font-size: 1rem;
        }

        button {
            background-color: #a1d8bb;
            color: white;
            font-weight: bold;
            padding: 12px 24px;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100%;
        }

        button:hover {
            background-color: #7db89e;
        }

        .success-message {
            background-color: #eaf5ec;
            color: #33691e;
            border: 1px solid #c5e1a5;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 6px;
            font-size: 1.1rem;
        }

        .error-message {
            background-color: #f9cccf;
            color: #b71c1c;
            border: 1px solid #f44336;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 6px;
            font-size: 1.1rem;
        }

        .appointments-list {
            margin-top: 30px;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .appointments-list table {
            width: 100%;
            border-collapse: collapse;
        }

        .appointments-list table, th, td {
            border: 1px solid #ccc;
            text-align: center;
        }

        .appointments-list th, td {
            padding: 12px;
            font-size: 1rem;
        }

        .back-button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #a1d8bb;
            color: white;
            font-weight: bold;
            text-decoration: none;
            border-radius: 8px;
            transition: background-color 0.3s;
            text-align: center;
            margin-top: 20px;
        }

        .back-button:hover {
            background-color: #7db89e;
        }
    </style>
</head>
<body>

    <h1>Записване на час</h1>

    <!-- Формата за записване на час -->
    <div class="form-container">
        <form action="bookAppointment.php" method="POST">
            <label for="service_id">Изберете услуга:</label>
            <select name="service_id" id="service_id" required>
                <?php
                // Извличаме услугите от базата данни
                $result = $conn->query("SELECT id, name FROM cosmetic_services");
                while ($service = $result->fetch_assoc()) {
                    echo "<option value='{$service['id']}'>{$service['name']}</option>";
                }
                ?>
            </select>

            <label for="appointment_time">Изберете дата и час:</label>
            <input type="datetime-local" name="appointment_time" id="appointment_time" required>

            <button type="submit">Запази час</button>
        </form>
    </div>

   
    <a href="index.php" class="back-button">Върни се към главното меню</a>

</body>
</html>
