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
        background-color: #fff9f7; /* Main background */
        color: #444444; /* Text color */
    }

    .navbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #f9cccf; /* Header background */
        padding: 15px 30px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        position: sticky;
        top: 0;
        z-index: 1000;
    }

    .navbar a {
        margin: 0 12px;
        text-decoration: none;
        color: #444444;
        font-weight: 600;
        transition: color 0.3s ease, background-color 0.3s ease;
        padding: 8px 14px;
        border-radius: 6px;
    }

    .navbar a:hover {
        background-color: #e8aeb7; /* Header buttons hover */
        color: white;
    }

    .container {
        max-width: 600px;
        margin: 50px auto;
        padding: 40px;
        background-color: #ffffff; /* Card background */
        border: 1px solid #ccc;     /* Border */
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        text-align: center;
    }

    h1 {
        font-size: 2.5em;
        margin-bottom: 20px;
        color: #e8aeb7; /* Accent color */
    }

    .description {
        font-size: 1.2em;
        margin-bottom: 30px;
        color: #444444;
    }

    a.button {
        display: inline-block;
        margin: 10px 10px;
        padding: 12px 24px;
        background-color: #a1d8bb; /* Button highlight */
        color: #ffffff;
        font-weight: bold;
        text-decoration: none;
        border-radius: 8px;
        transition: background-color 0.3s ease;
    }

    a.button:hover {
        background-color: #7db89e; /* Button hover */
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
</style>
</head>
<body>

    <div class="navbar">
        <div>
            <a href="#">Услуги</a>
            <a href="#">За нас</a>
            <a href="#">Галерия</a>
            <a href="#">Контакти</a>
        </div>
        <div>
            <?php if ($is_logged_in): ?>
                <a href="#">Профил</a>
                <a href="logout.php">Изход</a>
            <?php else: ?>
                <a href="login.php">Вход</a>
                <a href="register.php">Регистрация</a>
            <?php endif; ?>
        </div>
    </div>

    <div class="container">
        <h1>Салон за Красота "Елеганс"</h1>
        <p class="description">
            Добре дошли в нашия салон за красота! Тук можете да запишете час, 
            да разгледате нашите услуги и да споделите вашето мнение.
        </p>

        <?php if (isset($_GET['logout']) && $_GET['logout'] == 'success'): ?>
            <div class="logout-message">Успешно излязохте от системата.</div>
        <?php endif; ?>

        <?php if (!$is_logged_in): ?>
            <a href="login.php" class="button">Вход</a>
            <a href="register.php" class="button">Регистрация</a>
        <?php else: ?>
            <a href="listServices.php" class="button">Нашите Услуги</a>
            <a href="bookAppointment.php" class="button">Запази час</a>
            <a href="addReview.php" class="button">Остави мнение</a>
            <br>
            <a href="logout.php" class="button">Изход</a>
        <?php endif; ?>
    </div>

</body>
</html>
