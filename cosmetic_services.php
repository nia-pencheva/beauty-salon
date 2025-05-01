<?php
include 'config.php';

// Извличане на услугите заедно с категорията и описание
$result = $conn->query("SELECT id, name, description, price, time_length, category FROM cosmetic_services");

?>

<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <title>Услуги - Салон за Красота</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            margin-top: 20px;
        }
        table th, table td {
            padding: 12px;
            border: 1px solid #ccc;
        }
        table th {
            background-color: #f9cccf;
        }
        .category {
            font-weight: bold;
            color: #7db89e;
        }
        .description {
            color: #555; /* За да се подчертае текста */
        }

        a.button {
            display: inline-block;
            margin: 20px auto;
            padding: 12px 24px;
            background-color: #a1d8bb;
            color: #ffffff;
            font-weight: bold;
            text-decoration: none;
            border-radius: 8px;
            transition: background-color 0.3s ease;
            text-align: center;
        }

        a.button:hover {
            background-color: #7db89e;
        }

    </style>
</head>
<body>

<h1>Списък с Услуги</h1>

<table>
    <tr>
        <th>Име на Услугата</th>
        <th>Описание</th>
        <th>Категория</th>
        <th>Времетраене (мин)</th>
        <th>Цена (лв)</th>
    </tr>
    
    <?php while($service = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($service['name']) ?></td>
            <td class="category"><?= htmlspecialchars($service['category']) ?></td>
            <td class="description"><?= htmlspecialchars($service['description']) ?></td>
            <td><?= htmlspecialchars($service['time_length']) ?> мин</td>
            <td><?= htmlspecialchars(number_format($service['price'], 2)) ?> лв</td>
        </tr>
    <?php endwhile; ?>
</table>

<a href="index.php" class="button">Върни се към главното меню</a>

</body>
</html>
