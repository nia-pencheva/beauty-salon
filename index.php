<?php
session_start();
$is_logged_in = isset($_SESSION['id']) && $_SESSION['id'];

include "config.php";

$stmt = $conn->prepare("
    SELECT 
        p.*, 
        IFNULL(AVG(r.rating), 0) AS average_rating 
    FROM 
        procedures p
    LEFT JOIN 
        ratings r 
    ON 
        p.id = r.procedure_id
    GROUP BY 
        p.id
");
$stmt->execute();
$procedures = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

$conn->next_result();

$stmt = $conn->prepare("SELECT * FROM procedure_categories");
$stmt->execute();
$procedureCategories = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <title>Услуги | Салон "MAO MAO"</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        .container--procedures {
            max-width: 1000px;
            border-top: none;
            border-bottom: none;
        }

        .procedure-item {
            width: 100%;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            margin-bottom: 15px;
            border-bottom: 1px solid var(--light-gray);
            padding: 5px 0px;
            text-align: left;
        }

        .procedure-name {
            font-weight: bold;
            color: var(--dark-mint-green);
            font-size: 1em;
            text-overflow: ellipsis;
            overflow: hidden;
            white-space: nowrap;
        }

        @media screen and (min-width: 768px) {
            .procedure-name {
                font-size: 1.2em;
            }
        }

        .category-filter {
            display: flex;
            align-items: flex-start;
            width: 100%;
            margin-bottom: 20px;
        }

        .category-filter select {
            width: 200px;
            padding: 10px 5px;
            border-radius: 6px;
            border: 1px solid var(--light-gray);
            font-size: 1em;
            background-color: white;
            color: var(--dark-gray);
            cursor: pointer;
        }

        .category-filter select:focus {
            outline: none;
            border-color: var(--dark-pink);
        }

        .procedure-item.hidden {
            display: none;
        }
    </style>
</head>
<body>

    <!-- HEADER -->
    <?php include 'header.php'; ?>

    <!-- MAIN CONTENT -->
    <div class="content--centered-both">
        <div class="container container--procedures">
            <h1 style="font-size: 2em; color: var(--dark-mint-green);">Процедури</h1>
            <br><br>

            <div class="category-filter">
                <select id="categoryFilter">
                    <option value="all">Всички категории</option>
                    <?php foreach ($procedureCategories as $category): ?>
                        <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="procedures-list">
                <?php foreach ($procedures as $procedure): ?>
                    <div class="procedure-item" data-category="<?php echo $procedure['procedure_category_id']; ?>">
                        <div style="flex: 1; display: flex; flex-direction: column; gap: 5px;">
                            <p class="procedure-name"><?php echo $procedure['name']; ?></p>
                            <div style="display: flex; flex-direction: row; gap: 20px; align-items: center;">
                                
                                <p style="color: var(--dark-gray);"><?php echo $procedure['duration_minutes']; ?> мин.</p>
                                <p style="color: #ffcc66;">
                                    <?php if ($procedure['average_rating'] > 0): ?>
                                        <?php for ($i = 0; $i < 5; $i++): ?>
                                            <?php if ($i < round($procedure['average_rating'])): ?>
                                                <span>&#9733;</span> <!-- Filled star -->
                                            <?php else: ?>
                                                <span>&#9734;</span> <!-- Empty star -->
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                    <?php else: ?>
                                        <span style="color: var(--light-gray); font-size: 0.9em;">Няма оценки</span>
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>

                        <div style="display: flex; flex-direction: row; gap: 10px; align-items: center;">
                            <p style="font-weight: bold; color: var(--dark-pink)"><?php echo $procedure['price']; ?> лв.</p>
                            <a href="bookingRedirect.php?procedure_id=<?php echo $procedure['id']; ?>" class="basic-button">избери</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('categoryFilter').addEventListener('change', function() {
            const selectedCategory = this.value;
            const procedures = document.querySelectorAll('.procedure-item');

            procedures.forEach(procedure => {
                if (selectedCategory === 'all' || procedure.dataset.category === selectedCategory) {
                    procedure.classList.remove('hidden');
                } else {
                    procedure.classList.add('hidden');
                }
            });
        });
    </script>

</body>
</html>