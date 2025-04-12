<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <title>Изберете час</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <style>
        #times {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
        }
    </style>
</head>

<body>
    <input
        id="date-picker"
        type="date"
    />

    <div id="times"></div>

    <script>
        let datePicker = document.getElementById('date-picker');
        let times = document.getElementById('times');
        let timeElement;

        datePicker.addEventListener('change', function() {
            axios.get('availableHoursFetcher.php', {
                params: {
                    procedure_id: 1,
                    date: datePicker.value
                }
            })
            .then(function(response) {
                times.innerHTML = "";

                response.data.forEach(function(time) {
                    createTimeElement(time);
                    times.appendChild(timeElement);
                });
            });
        });

        function createTimeElement(time) {
            timeElement = document.createElement("a");
            timeElement.innerText = time.time;

            if(time.available) {
                timeElement.href = "/book.php";
            }
        }
    </script>
</body>
</html>
