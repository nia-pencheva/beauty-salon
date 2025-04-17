<?php
session_start();
$is_logged_in = isset($_SESSION['id']) && $_SESSION['id'];
?>

<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <title>Салон за Красота</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
    /* 🎨 Color Palette Reference:
        #f9cccf – Header
        #e8aeb7 – Header buttons hover
        #a1d8bb – Highlights/buttons
        #7db89e – Button hover
        #fff9f7 – Background main
        #ffffff – Fields
        #444444 – Text
        #ccc – Borders
    */

    .logo img {
        height: 48px;
    }

    .search-bar {
        flex: 1;
        display: flex;
        justify-content: center;
        padding: 10px 20px;
    }

    .search-bar input {
        width: 100%;
        max-width: 400px;
        padding: 10px 15px;
        border-radius: 6px;
        border: 1px solid var(--light-gray);
        font-size: 1em;
        background-color: #ffffff;
    }

    .container {
        max-width: 600px;
        margin: 50px auto;
        padding: 40px;
        background-color: #ffffff;
        border: 1px solid var(--light-gray);
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        text-align: center;
    }

    h1 {
        font-size: 2.5em;
        margin-bottom: 20px;
        color: var(--dark-pink);
    }

    .description {
        font-size: 1.2em;
        margin-bottom: 30px;
    }

    a.button {
        display: inline-block;
        margin: 10px 10px;
        padding: 12px 24px;
        background-color: var(--light-mint-green);
        color: #ffffff;
        font-weight: bold;
        text-decoration: none;
        border-radius: 8px;
        transition: background-color 0.3s ease;
    }

    a.button:hover {
        background-color: var(--dark-mint-green);
    }

    .logout-message {
        background-color: #eaf5ec;
        color: #33691e;
        border: 1px solid #c5e1a5;
        padding: 15px;
        margin: 20px auto;
        border-radius: 6px;
        width: 80%;
        max-width: 600px;
        font-size: 1.1em;
    }

    @media (max-width: 768px) {
        .search-bar {
            width: 100%;
            padding: 10px 0;
        }
    }
    </style>
</head>
<body>

    <!-- HEADER -->
    <?php include 'header.php'; ?>

    <!-- MAIN CONTENT -->
    <div class="container">
        <h1>Салон за Красота</h1>
        <p class="description">
        </p>

        <?php if (isset($_GET['logout']) && $_GET['logout'] == 'success'): ?>
            <div class="logout-message">Успешно излязохте от системата.</div>
        <?php endif; ?>

        <?php if (!$is_logged_in): ?>
            <a href="bookAppointment.php" class="button">Запази час</a>
        <?php else: ?>
            <a href="bookAppointment.php" class="button">Запази час</a>
        <?php endif; ?>
    </div>

</body>
</html>
