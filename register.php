<?php
session_start();
include "config.php"; // Include the database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $full_name = $_POST['full_name'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Ensure all fields are filled
    if (!empty($username) && !empty($email)&& !empty($full_name) && !empty($confirm_password)) {
        // Check if passwords match
        if ($password !== $confirm_password) {
            $error = "Паролите не съвпадат!";
        } else {
            // Hash the password for security
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Check if the username already exists
            $check_sql = "SELECT * FROM users WHERE username = ?";
            $stmt = $conn->prepare($check_sql);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $error = "Потребителското име вече съществува.";
            } else {
                // Insert the new user into the database
                $sql = "INSERT INTO users (username, email, full_name, password) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssss", $username, $email, $full_name, $hashed_password);

                if ($stmt->execute()) {
                    $_SESSION['register_success'] = "Успешна регистрация! Моля, влезте в системата.";
                    header('Location: login.php');
                    exit;
                } else {
                    $error = "Грешка при регистрация: " . $stmt->error;
                }
            }
            $stmt->close();
        }
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
    <title>Регистрация</title>
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
            margin-top: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="password"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            font-size: 1.1em;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .error {
            color: red;
            margin-top: 10px;
            font-size: 0.9em;
        }

        .success {
            color: green;
            margin-top: 10px;
            font-size: 1em;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Регистрация</h1>
        <form method="post" action="register.php">
            <label for="username">Име и фамилия:</label>
            <input type="text" id="full_name" name="full_name" required>
            
            <label for="username">Потребителско име:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="username"> Имейл:</label>
            <input type="text" id="email" name="email" required>
            
            <label for="password">Парола:</label>
            <input type="password" id="password" name="password" required>
            
            <label for="confirm_password">Потвърдете паролата:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
            
            <input type="submit" value="Регистрирай се">
        </form>
        
        <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
        <?php if (isset($_SESSION['register_success'])) { echo "<p class='success'>" . $_SESSION['register_success'] . "</p>"; unset($_SESSION['register_success']); } ?>
    </div>
</body>
</html>
