<?php
include "config.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$is_logged_in = isset($_SESSION['id']);

if (!$is_logged_in) {
    header('Location: index.php');
    exit();
}

include "header.php";

$user_id = $_SESSION['id'];
$query = "SELECT full_name, email FROM users WHERE id = '$user_id'";
$result = mysqli_query($conn, $query);

if ($result) {
    $user = mysqli_fetch_assoc($result);
    $user_name = $user['full_name'];
    $user_email = $user['email'];
} else {
    echo "Error fetching user details.";
    exit();
}

$current_time = new DateTime();

$reservation_query = "
    SELECT 
        bp.date, 
        bp.time, 
        p.name AS procedure_name, 
        p.duration_minutes, 
        p.price
    FROM 
        booked_procedures bp
    INNER JOIN procedures p ON bp.procedure_id = p.id
    WHERE bp.user_id = '$user_id'";

$reservation_result = mysqli_query($conn, $reservation_query);
$all_reservations = mysqli_fetch_all($reservation_result, MYSQLI_ASSOC);
$reservations = [];

foreach ($all_reservations as $reservation) {
    $reservation_datetime = new DateTime($reservation['date'] . ' ' . $reservation['time']);

 
    if ($reservation_datetime > $current_time) {
        $reservations[] = $reservation;
    }
}


$upcoming_reservations = [];
foreach ($reservations as $reservation) {
    $reservation_datetime = new DateTime($reservation['date'] . ' ' . $reservation['time']);
    $interval = $current_time->diff($reservation_datetime);

    if ($interval->invert == 0 && $interval->days == 0 && $interval->h < 24) {
        $upcoming_reservations[] = $reservation;
    }
}
?>

<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <title>Профил | Салон за Красота</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        :root {
            --light-pink: #f9cccf;
            --hover-pink: #e8aeb7;
            --highlight-green: #a1d8bb;
            --button-hover-green: #7db89e;
            --main-background: #fff9f7;
            --white: #ffffff;
            --dark-text: #444444;
            --border-color: #ccc;
            --light-red: #f4aaaa;
        }

        body {
            background-color: var(--main-background);
            color: var(--dark-text);
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 40px;
            background-color: var(--white);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        h1 {
            font-size: 2.5em;
            margin-bottom: 20px;
            color: #7db89e;
        }

        .profile-info {
            margin: 20px 0;
            text-align: left;
            font-size: 1.2em;
        }

        .profile-info p {
            color: var(--dark-text);
        }

        .profile-info strong {
            color: #7db89e;
        }

        h2 {
            font-size: 2.5em;
            margin-bottom: 20px;
            color: #7db89e;
        }

        .reservation-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .reservation-table th, .reservation-table td {
            padding: 10px;
            border: 1px solid var(--border-color);
            text-align: left;
        }

        .reservation-table th {
            background-color: var(--light-pink);
        }

        .button {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 24px;
            background-color: var(--highlight-green);
            color: var(--white);
            font-weight: bold;
            text-decoration: none;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: var(--button-hover-green);
        }

        /* Important reminder styles */
        .important-reminder {
            border: 2px solid var(--light-red);
            background-color: #fff0f0;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 30px;
            box-shadow: 0 0 12px rgba(244, 170, 170, 0.6);
            animation: pulseReminder 2s infinite;
        }

        .important-reminder h2 {
            color: #d9534f;
            font-size: 2em;
            margin-bottom: 10px;
        }

        .upcoming-events-table {
            width: 100%;
            border-collapse: collapse;
            background-color: #ffe5e5;
            border: 1px solid var(--light-red);
        }

        .upcoming-events-table th, .upcoming-events-table td {
            padding: 12px;
            border: 1px solid var(--light-red);
            text-align: left;
        }

        .upcoming-events-table th {
            background-color: var(--light-red);
            color: white;
        }

        @keyframes pulseReminder {
            0% {
                box-shadow: 0 0 10px rgba(244, 170, 170, 0.4);
            }
            50% {
                box-shadow: 0 0 20px rgba(244, 170, 170, 0.9);
            }
            100% {
                box-shadow: 0 0 10px rgba(244, 170, 170, 0.4);
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Здравейте, <?php echo htmlspecialchars($user_name); ?>!</h1>

    <div class="profile-info">
        <p><strong>Вашата информация -</strong></p>
        <p>Име: <?php echo htmlspecialchars($user_name); ?></p>
        <p>Имейл: <?php echo htmlspecialchars($user_email); ?></p>
    </div>

    <?php if (count($upcoming_reservations) > 0): ?>
        <div class="important-reminder">
            <h2>Предстоящи събития</h2>
            <table class="upcoming-events-table">
                <tr>
                    <th>Дата</th>
                    <th>Час</th>
                    <th>Услуга</th>
                    <th>Продължителност (мин)</th>
                    <th>Цена</th>
                </tr>
                <?php foreach ($upcoming_reservations as $event): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($event['date']); ?></td>
                        <td><?php echo htmlspecialchars($event['time']); ?></td>
                        <td><?php echo htmlspecialchars($event['procedure_name']); ?></td>
                        <td><?php echo htmlspecialchars($event['duration_minutes']); ?> мин</td>
                        <td><?php echo htmlspecialchars($event['price']); ?> лв</td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    <?php endif; ?>

    <h2>Вашите Резервации</h2>
    <?php if (count($reservations) > 0): ?>
        <table class="reservation-table">
            <tr>
                <th>Дата</th>
                <th>Час</th>
                <th>Услуга</th>
                <th>Продължителност (мин)</th>
                <th>Цена</th>
            </tr>
            <?php foreach ($reservations as $reservation): ?>
                <tr>
                    <td><?php echo htmlspecialchars($reservation['date']); ?></td>
                    <td><?php echo htmlspecialchars($reservation['time']); ?></td>
                    <td><?php echo htmlspecialchars($reservation['procedure_name']); ?></td>
                    <td><?php echo htmlspecialchars($reservation['duration_minutes']); ?> мин</td>
                    <td><?php echo htmlspecialchars($reservation['price']); ?> лв</td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>Нямате направени резервации.</p>
    <?php endif; ?>

    <a href="bookingAvailability.php" class="button">Запази нов час</a>
</div>

</body>
</html>
