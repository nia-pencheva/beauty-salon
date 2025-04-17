<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(!isset($_SESSION['id'])) {
    header('Location: index.php');
}

?>

<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <title>Изберете час</title>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="styles.css">

    <style>
        .container--booking-availability {
            max-width: 600px;
        }

        @media screen and (min-width: 600px) {
            .container--booking-availability {
                border: 1px solid #ccc;
                border-radius: 12px;
            }
        }

        #datepicker-label-br {
            display: inline-block;
        }

        #datepicker {
            margin-top: 10px;
            background-color: var(--cream);
            border: 1px solid var(--light-gray);
            padding: 5px;
            border-radius: 6px;
        }

        #times {
            display: grid;
            width: max-content;
            grid-template-columns: repeat(3, 1fr);
            margin: 40px auto 0px;
            gap: 10px;
        }

        .time-element {
            width: 80px;
            padding: 5px;
            border-radius: 6px;
        }

        .time-element--active {
            color: var(--dark-gray);
            text-decoration: none;
            border: 1px solid var(--dark-gray);
        }

        .time-element--active:hover {
            background-color: #e1dfdf;
        }

        .time-element--inactive {
            color: var(--light-gray);
            border: 1px solid var(--light-gray);
        }

        .ui-state-highlight, .ui-widget-content .ui-state-highlight, .ui-widget-header .ui-state-highlight {
            background-color: var(--light-pink);
        }

        .ui-datepicker .ui-datepicker-calendar .ui-datepicker-current-day a {
            background-color: var(--light-mint-green);
            border: 1px solid var(--dark-gray);
        }

        @media screen and (min-width: 400px) {
            #datepicker {
                margin-top: 0;
            }
            
            #datepicker-label-br {
                display: none;
            }
        }

        @media screen and (min-width: 450px) {
            #times {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        @media screen and (min-width: 600px) {
            #times {
                grid-template-columns: repeat(5, 1fr);
            }
        }
    </style>
</head>

<body>
    <div class="content--centered-both">
        <div class="container container--booking-availability">
            <!-- <input
                id="date-picker"
                type="date"
            /> -->

            <label id="datepicker-label" for="datepicker">Изберете дата: </label>
            <br id="datepicker-label-br">
            <input type="text" id="datepicker">

            <div id="times"></div>
        </div>
    </div>
    
    <script>
        let datePicker = $("#datepicker");
        let times = document.getElementById('times');
        let timeElement;

        datePicker.datepicker({
            beforeShowDay: $.datepicker.noWeekends,
            dateFormat: "dd.mm.yy",
            minDate: 0
        });

        datePicker.datepicker('setDate', new Date());
        fetchAvailableHours();

        datePicker.on('change', fetchAvailableHours);

        function fetchAvailableHours() {
            axios.get('availableHoursFetcher.php', {
                params: {
                    procedure_id: 1,
                    date: datePicker.val().split('.').reverse().join('-')
                }
            })
            .then(function(response) {
                times.innerHTML = "";

                response.data.forEach(function(time) {
                    createTimeElement(time);
                    times.appendChild(timeElement);
                });
            });
        }

        function createTimeElement(time) {
            timeElement = document.createElement("a");
            timeElement.classList.add('time-element');
            timeElement.innerText = time.time;

            if(time.available) {
                timeElement.href = "/book.php";
                timeElement.classList.add('time-element--active');
            }
            else {
                timeElement.classList.add('time-element--inactive');
            }
        }
    </script>
</body>
</html>
