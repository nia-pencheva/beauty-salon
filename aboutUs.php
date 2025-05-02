<?php
session_start();
$is_logged_in = isset($_SESSION['id']) && $_SESSION['id'];
?>

<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <title>За нас | Салон "MAO MAO"</title>

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="styles.css">

    <style>
        .container--about-us {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 50px;
            max-width: 1200px;
            margin: 50px auto;
        }

        .container--about-us div {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        #beauty-salon-img {
            max-width: 500px;
            width: 100%;
        }

        .about-us__details {
            text-align: center;
            font-size: 18px;
        }

        .about-us__details p {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        #about-us__heading {
            font-size: 32px;
            padding-bottom: 20px;
            color: var(--dark-pink);
        }

        .about-us__details__label {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: bold;
            color: var(--dark-pink);
        }

        /* @media screen and (min-width: 768px) {
            .about-us__details {
                font-size: 18px;
            }

            #about-us__heading {
                font-size: 36px;
            }
        } */

        @media screen and (min-width: 1100px) {
            .container--about-us {
                flex-direction: row;
            }

            #beauty-salon-img {
                max-width: 600px;
            }

            .about-us__details {
                text-align: left;
            }

            .about-us__details p {
                flex-direction: row;
            }
        }

        @media screen and (min-width: 1200px) {
            .container--about-us {
                border: 1px solid #ccc;
                border-radius: 12px;
            }
        }
    </style>
</head>
<body>
    <!-- HEADER -->
    <?php include 'header.php'; ?>

    <div class="container container--about-us">
        <div>
            <img
                id="beauty-salon-img" 
                src="./images/beauty-salon-inside.png" 
            />
        </div>

        <div class="about-us__details">
            <h1 id="about-us__heading">Салон "MAO MAO"</h1>
            <p>
                <span class="about-us__details__label">
                    <img 
                        style="height: 20px;"
                        src="./images/location.png" 
                    />
                    Адрес:
                </span>
                ул. "Морски бриз" №24, Варна
            </p>
            <p>
                <span class="about-us__details__label">
                    <img 
                        style="height: 18px; padding-left: 2px;"
                        src="./images/phone.png" 
                    />
                    Телефон:
                </span>
                +3594307501158
            </p>
            <p>
                <span class="about-us__details__label">
                    <img 
                        style="height: 18px; padding-right: 2px;"
                        src="./images/working-hours.png" 
                    />
                    Работно време:
                </span>
                Понеделник - Петък, 9:00 - 18:00 
            </p>
        </div>
    </div>
</body>
</html>