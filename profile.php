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

// Join query to fetch procedure details
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
$reservations = mysqli_fetch_all($reservation_result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <title>Профил | Салон за Красота</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        /* 🎨 Color Palette Reference */
        /* Adjusting for colors provided */
        :root {
            --light-pink: #f9cccf;
            --hover-pink: #e8aeb7;
            --highlight-green: #a1d8bb;
            --button-hover-green: #7db89e;
            --main-background: #fff9f7;
            --white: #ffffff;
            --dark-text: #444444;
            --border-color: #ccc;
        }

        /* Add custom styles for the profile page */
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

        /* "Вашата информация" - no centering, applied colors */
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

        /* "Вашите Резервации" - Pink color */
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
    </style>
</head>
<body>

    <!-- MAIN CONTENT -->
    <div class="container">
        <h1>Здравейте, <?php echo htmlspecialchars($user_name); ?>!</h1>

        <div class="profile-info">
            <p><strong>Вашата информация -</strong></p>
            <p>Име: <?php echo htmlspecialchars($user_name); ?></p>
            <p>Имейл: <?php echo htmlspecialchars($user_email); ?></p>
        </div>

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
