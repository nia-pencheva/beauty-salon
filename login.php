<?php 
session_start();
include "config.php"; // Include the database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!empty($username) && !empty($password)) {
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                $_SESSION['logged_in'] = true;
                $_SESSION['username'] = $user['username'];
                $_SESSION['id'] = $user['id'];
                //$_SESSION['role'] = $user['role']; // Store the role in the session

                
                header('Location: index.php'); // User dashboard
                
                exit;
            } else {
                $error = "Грешно потребителско име или парола. <br><a href='register.php'>Регистрирайте се тук</a>";
            }
        } else {
            $error = "Потребителят не съществува. <br><a href='register.php'>Регистрирайте се тук</a>";
        }
        $stmt->close();
    } else {
        $error = "Моля, попълнете всички полета!";
    }
}

?>

<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход</title>
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
            max-width: 400px;
        }

        h1 {
            font-size: 2em;
            margin-bottom: 20px;
            color: #007bff;
        }

        form {
            text-align: left;
        }

        label {
            font-size: 1.1em;
            margin-bottom: 8px;
            display: block;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1em;
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            color: #fff;
            font-size: 1.1em;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        p {
            font-size: 0.9em;
            color: #ff0000;
            margin-top: 10px;
        }

        .success {
            color: #28a745;
            font-size: 1.1em;
            margin-top: 20px;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Вход</h1>
        <form method="post" action="login.php">
            <label for="username">Потребителско име:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Парола:</label>
            <input type="password" id="password" name="password" required>
            <input type="submit" value="Влез">
        </form>
        
        <!-- Display error message if login fails -->
        <?php if (isset($error)): ?>
            <p><?php echo $error; ?></p>
        <?php endif; ?>

        <!-- Optionally, display a success message if the user has logged out successfully -->
        <?php if (isset($_SESSION['logout_message'])): ?>
            <p class="success"><?php echo $_SESSION['logout_message']; unset($_SESSION['logout_message']); ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
