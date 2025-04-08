<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}include "config.php"; 

// Determine the sort option (default to 'rating_desc' if none is selected)
$sort_order = isset($_GET['sort']) ? $_GET['sort'] : 'rating_desc';

// Define the query based on the selected sort option
if ($sort_order == 'rating_asc') {
    $stmt = $conn->prepare("
        SELECT r.id, r.name, r.location, AVG(f.rating) AS average_rating
        FROM restaurants r
        LEFT JOIN feedback f ON r.id = f.restaurant_id
        GROUP BY r.id, r.name, r.location
        ORDER BY average_rating ASC
    ");
} elseif ($sort_order == 'rating_desc') {
    $stmt = $conn->prepare("
        SELECT r.id, r.name, r.location, AVG(f.rating) AS average_rating
        FROM restaurants r
        LEFT JOIN feedback f ON r.id = f.restaurant_id
        GROUP BY r.id, r.name, r.location
        ORDER BY average_rating DESC
    ");
} else {
    $stmt = $conn->prepare("
        SELECT r.id, r.name, r.location, AVG(f.rating) AS average_rating
        FROM restaurants r
        LEFT JOIN feedback f ON r.id = f.restaurant_id
        GROUP BY r.id, r.name, r.location
        ORDER BY r.name ASC
    ");
}

$stmt->execute();
$result = $stmt->get_result();

$is_admin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
?>

<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <title>Списък с ресторанти</title>
      <link rel="stylesheet" type="text/css" href="styles.css">

    <style>
        
        h2 {
            text-align: center;
            font-size: 2em;
            color: #444;
            margin-bottom: 20px;
        }
        .sort-menu {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
        }

        .sort-menu label {
            font-size: 1.2em;
            margin-right: 10px;
        }

        .sort-menu select {
            padding: 10px;
            font-size: 1.1em;
            border-radius: 5px;
            border: 1px solid #ccc;
            background-color: #fff;
            margin-right: 20px;
            cursor: pointer;
            width: 220px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
            font-size: 1.1em;
        }

        th {
            background-color: #f4f4f4;
            font-size: 1.2em;
        }

        td {
            font-size: 1.1em;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #eaeaea;
        }

        .restaurant-number {
            font-weight: bold;
            color: #444;
            font-size: 1.2em;
        }

    

       

        .no-restaurants {
            color: red;
            font-size: 1.1em;
            text-align: center;
            font-weight: bold;
        }

        /* Optional styling for the star rating */
        span {
            color: gold;
            font-size: 1.2em;
        }
    </style>
</head>
<body>


<div class="navbar">
    <a href="index.php">Начало</a>
    <a href="listRestaurants.php">Списък с Ресторанти</a>
    <a href="addReview.php">Напиши ревю</a>
    <a href="checkReview.php">Преглед на Ревюта</a>

    <?php if ($is_admin): ?>
        <a href="addRestaurant.php">Добави Ресторант</a>
        <a href="newWords.php">Добави Ключови Думи</a>
    <?php endif; ?>

    <a href="logout.php">Изход</a>
</div>

<h2>Списък с ресторанти</h2>

<div class="sort-menu">
    <label for="sort">Сортиране по:</label>
    <form method="get" action="listRestaurants.php">
        <select id="sort" name="sort" onchange="this.form.submit()">
            <option value="name_asc" <?php if (isset($_GET['sort']) && $_GET['sort'] == 'name_asc') echo 'selected'; ?>>A-Z</option>
            <option value="rating_asc" <?php if (isset($_GET['sort']) && $_GET['sort'] == 'rating_asc') echo 'selected'; ?>>Най-ниска оценка</option>
            <option value="rating_desc" <?php if (isset($_GET['sort']) && $_GET['sort'] == 'rating_desc') echo 'selected'; ?>>Най-висока оценка</option>
        </select>
    </form>
</div>

<?php
if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>#</th><th>Ресторант</th><th>Адрес</th><th>Средна оценка</th></tr>";

    $restaurant_number = 1;
    while ($row = $result->fetch_assoc()) {
        // Check if there's an average rating and set to 'Няма оценки' if no ratings
        $average_rating = $row['average_rating'] ? round($row['average_rating'], 1) : 'Няма оценки';
        
        echo "<tr>";
        echo "<td class='restaurant-number'>" . $restaurant_number . "</td>";
        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['location']) . "</td>";
        echo "<td>" . $average_rating . " <span>&#9733;</span></td>";  // Star icon after the rating
        echo "</tr>";

        $restaurant_number++; 
    }

    echo "</table>";
} else {
    echo "<p class='no-restaurants'>Няма налични ресторанти в базата данни.</p>";
}

$stmt->close();
?>

</body>
</html>
