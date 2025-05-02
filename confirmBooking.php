<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php?redirect=" . urlencode($_SERVER['REQUEST_URI']));
    exit;
}

include "config.php";

// Get procedure details
if (isset($_GET['procedure_id']) && isset($_GET['date']) && isset($_GET['time'])) {
    $procedure_id = $_GET['procedure_id'];
    $date = $_GET['date'];
    $time = $_GET['time'];

    $stmt = $conn->prepare("SELECT * FROM procedures WHERE id = ?");
    $stmt->bind_param("i", $procedure_id);
    $stmt->execute();
    $procedure = $stmt->get_result()->fetch_assoc();
    $stmt->close();
} else {
    header("Location: bookingAvailability.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <title>Потвърждение на резервацията | Салон "MAO MAO"</title>
    <link rel="stylesheet" type="text/css" href="styles.css">

    <style>
        .container--confirm-booking {
            display: flex;
            flex-direction: column;
            align-items: center;
            max-width: 800px;
            margin: 50px auto;
        }

        .confirmation-details {
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            text-align: left;
        }

        .confirmation-details p {
            margin: 10px 0;
            font-size: 1.1em;
        }

        .confirmation-actions {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 30px;
        }

        @media screen and (min-width: 800px) {
            .container--confirm-booking {
                border: 1px solid #ccc;
                border-radius: 12px;
            }
        }
    </style>    
</head>
<body>
    <div class="content--centered-both">
        <div class="container container--confirm-booking">
            <h2>Потвърждение на резервацията</h2>
            <div class="confirmation-details">
                <p><strong>Процедура:</strong> <?php echo htmlspecialchars($procedure['name']); ?></p>
                <p><strong>Дата:</strong> <?php echo htmlspecialchars($date); ?></p>
                <p><strong>Час:</strong> <?php echo htmlspecialchars($time); ?></p>
                <p><strong>Цена:</strong> <?php echo number_format($procedure['price'], 2); ?> лв.</p>
            </div>
            
            <div class="confirmation-actions">
                <form action="bookAppointment.php" method="POST">
                    <input type="hidden" name="procedure_id" value="<?php echo $procedure_id; ?>">
                    <input type="hidden" name="date" value="<?php echo $date; ?>">
                    <input type="hidden" name="time" value="<?php echo $time; ?>">
                    <button type="submit" class="button button--primary">Потвърди резервацията</button>
                </form>
                <a href="bookingAvailability.php?procedure_id=<?= $procedure_id ?>" class="button button--secondary">Отказ</a>
            </div>
        </div>
    </div>
</body>
</html>