<?php
session_start();

// Check if the user is logged in by verifying if 'user_id' exists in the session
$is_logged_in = isset($_SESSION['user_id']) && $_SESSION['user_id'];

// Check if the user is an admin
$is_admin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
?>

<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <title>Управление на Ресторанти</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #f3f4f7, #dce0e6);
            color: #333;
        }

        .container {
            text-align: center;
            padding: 40px;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }

        h1 {
            font-size: 2em;
            margin-bottom: 20px;
            color: #007bff;
        }

        a {
            display: inline-block;
            margin: 15px 10px;
            padding: 12px 24px;
            text-decoration: none;
            color: #fff;
            background-color: #007bff;
            border-radius: 8px;
            font-weight: bold;
            transition: background-color 0.3s ease;
            font-size: 1.1em;
        }

        a:hover {
            background-color: #0056b3;
        }

        .description {
            font-size: 1.2em;
            margin-bottom: 30px;
        }

        .logout-message {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            padding: 15px;
            margin: 20px auto;
            text-align: center;
            border-radius: 5px;
            width: 80%;
            max-width: 600px;
            font-size: 1.1em;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Управление на Ресторанти</h1>
        <p class="description">Добре дошли в системата за управление. 
            Тук можете да добавяте нови ресторанти, да разглеждате съществуващи и да 
            четете ревюта от други потребители!</p>

        <?php if (isset($_GET['logout']) && $_GET['logout'] == 'success'): ?>
            <div class="logout-message">Вие излязохте успешно от системата.</div>
        <?php endif; ?>

        <?php if (!$is_logged_in): ?>
            <a href="login.php">Влезте в системата</a>
            <a href="register.php">Регистрация</a>
        <?php else: ?>
            <a href="listRestaurants.php">Списък с ресторанти</a>
            <a href="checkReview.php">Преглед на ревю за ресторант</a>
            <a href="addReview.php">Добави ревю за ресторант</a>
            
            <?php if ($is_admin): ?>
            <a href="addRestaurant.php">Добави ресторант</a><br>
                <a href="newWords.php">Добави ключови думи</a>
            <?php endif; ?>

            <br>
            <a href="logout.php">Изход</a>
        <?php endif; ?>
    </div>

</body>
</html>
