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

$past_reservations_procedures = [];

foreach($all_reservations as $reservation) {
    $reservation_datetime = new DateTime($reservation['date'] . ' ' . $reservation['time']);

    if ($reservation_datetime < $current_time) {
        $past_reservations_procedures[] = $reservation["procedure_name"];
    }
}

$past_reservations_procedures = array_unique($past_reservations_procedures);

// Извличане на съществуващите оценки на потребителя
$ratings_query = "
    SELECT procedure_id, rating 
    FROM ratings 
    WHERE user_id = '$user_id'
";
$ratings_result = mysqli_query($conn, $ratings_query);
$user_ratings = [];

if ($ratings_result) {
    while ($row = mysqli_fetch_assoc($ratings_result)) {
        $user_ratings[$row['procedure_id']] = $row['rating'];
    }
}
?>

<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <title>Профил | Салон "MAO MAO"</title>
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

        .container--profile {
            max-width: 800px;
            margin: 50px auto;
        }

        @media screen and (min-width: 800px) {
            .container--profile {
                border: 1px solid #ccc;
                border-radius: 12px;
            }
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

        .stars {
            display: inline-flex;
            cursor: pointer;
            font-size: 2em;
            color: #ccc;
        }

        .stars span {
            transition: color 0.3s;
        }

        .stars span:hover {
            color: #f5c518;
        }

        .stars span.selected {
            color: #f5c518;
        }
    </style>
</head>
<body>

<div class="container container--profile">
    <?php if (isset($_SESSION['booking_success'])) {
        echo "<p class='success'>" . $_SESSION['booking_success'] . "</p>";
        unset($_SESSION['booking_success']);
    } ?>

    <h1 style="font-size: 2em; color: var(--dark-mint-green);">Здравейте, <?php echo htmlspecialchars($user_name); ?>!</h1>

    <div class="profile-info">
        <p style="margin-bottom: 10px;"><strong>Вашата информация</strong></p>
        <p><b>Име:</b> <?php echo htmlspecialchars($user_name); ?></p>
        <p><b>Имейл:</b> <?php echo htmlspecialchars($user_email); ?></p>
    </div>

    <br>

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

    <h2 style="font-size: 2em; color: var(--dark-mint-green);">Вашите Резервации</h2>
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
        <p>Нямате предстоящи резервации.</p>
    <?php endif; ?>

    <?php if (!empty($past_reservations_procedures)): ?>
        <br><br>
        <h2 style="font-size: 2em; color: var(--dark-mint-green);">Оценете услугите:</h2>
        <?php foreach ($past_reservations_procedures as $procedure): ?>
            <?php
            // Извличане на ID на процедурата
            $procedure_id_query = "SELECT id FROM procedures WHERE name = '" . mysqli_real_escape_string($conn, $procedure) . "'";
            $procedure_id_result = mysqli_query($conn, $procedure_id_query);
            $procedure_id_row = mysqli_fetch_assoc($procedure_id_result);
            $procedure_id = $procedure_id_row['id'];

            // Проверка за съществуваща оценка
            $current_rating = isset($user_ratings[$procedure_id]) ? $user_ratings[$procedure_id] : 0;
            ?>
            <div class="rating-container">
                <p><?= htmlspecialchars($procedure) ?></p>
                <form method="POST" action="rateService.php" class="rating-form">
                    <input type="hidden" name="procedure_id" value="<?= $procedure_id ?>">
                    <input type="hidden" name="rating" class="rating-value" value="<?= $current_rating ?>">
                    <div class="stars" data-procedure-id="<?= $procedure_id ?>">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <span data-value="<?= $i ?>" class="<?= $i <= $current_rating ? 'selected' : '' ?>">★</span>
                        <?php endfor; ?>
                    </div>
                    <button style="position: relative; top: -2px; padding: 5px 14px;" class="button--primary" type="submit">Оцени</button>
                </form>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const starsContainers = document.querySelectorAll('.stars');

        starsContainers.forEach(container => {
            const stars = container.querySelectorAll('span');
            const ratingInput = container.closest('form').querySelector('.rating-value');

            stars.forEach((star, index) => {
                star.addEventListener('click', () => {
                    const value = parseInt(star.getAttribute('data-value'));

                    ratingInput.value = value; // Записваме оценката в скритото поле
                    // Премахваме предишния избор
                    stars.forEach(s => s.classList.remove('selected'));

                    // Добавяме класа "selected" на избраните звезди
                    for (let i = 0; i < value; i++) {
                        stars[i].classList.add('selected');
                    }
                });

                star.addEventListener('mouseover', () => {
                    // Подчертаваме звездите при задържане на мишката
                    stars.forEach(s => s.classList.remove('selected'));
                    const value = parseInt(star.getAttribute('data-value'));
                    for (let i = 0; i < value; i++) {
                        stars[i].classList.add('selected');
                    }
                });

                container.addEventListener('mouseleave', () => {
                    // Връщаме избора при напускане на мишката
                    stars.forEach(s => s.classList.remove('selected'));
                    const value = parseInt(ratingInput.value);

                    if (value) {
                        for (let i = 0; i < value; i++) {
                            stars[i].classList.add('selected');
                        }
                    }
                });
            });
        });
    });
</script>

</body>
</html>