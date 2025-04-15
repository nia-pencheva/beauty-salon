<?php
session_start();
$is_logged_in = isset($_SESSION['id']) && $_SESSION['id'];
?>

<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <title>Салон за Красота</title>
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

    body {
        font-family: 'Segoe UI', sans-serif;
        margin: 0;
        padding: 0;
        background-color: #fff9f7;
        color: #444444;
    }

    header {
        background-color: #f9cccf;
        padding: 15px 30px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        position: sticky;
        top: 0;
        z-index: 1000;
    }

    .header-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
    }

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
        border: 1px solid #ccc;
        font-size: 1em;
        background-color: #ffffff;
    }

    .nav-menu {
        display: flex;
        gap: 15px;
        align-items: center;
    }

    .nav-menu a {
        text-decoration: none;
        color: #444444;
        font-weight: 600;
        padding: 8px 14px;
        border-radius: 6px;
        transition: background-color 0.3s ease;
    }

    .nav-menu a:hover {
        background-color: #e8aeb7;
        color: white;
    }

    .container {
        max-width: 600px;
        margin: 50px auto;
        padding: 40px;
        background-color: #ffffff;
        border: 1px solid #ccc;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        text-align: center;
    }

    h1 {
        font-size: 2.5em;
        margin-bottom: 20px;
        color: #e8aeb7;
    }

    .description {
        font-size: 1.2em;
        margin-bottom: 30px;
    }

    a.button {
        display: inline-block;
        margin: 10px 10px;
        padding: 12px 24px;
        background-color: #a1d8bb;
        color: #ffffff;
        font-weight: bold;
        text-decoration: none;
        border-radius: 8px;
        transition: background-color 0.3s ease;
    }

    a.button:hover {
        background-color: #7db89e;
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
        .header-container {
            flex-direction: column;
            align-items: flex-start;
        }

        .search-bar {
            width: 100%;
            padding: 10px 0;
        }

        .nav-menu {
            flex-wrap: wrap;
            justify-content: center;
            width: 100%;
        }

        .nav-menu a {
            margin-bottom: 5px;
        }
    }
    </style>
</head>
<body>

    <!-- HEADER -->
    <header>
        <div class="header-container">
           
            <div class="nav-menu">
                <a href="#">Услуги</a>
                <a href="#">За нас</a>
                <?php if ($is_logged_in): ?>
                    <a href="profile.php">Профил</a>
                    <a href="logout.php">Изход</a>
                <?php else: ?>
                    <a href="profile.php">Профил</a>
                    <a href="login.php">Вход</a>
                <?php endif; ?>
            </div>
        </div>
    </header>

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
