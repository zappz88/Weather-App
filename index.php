<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Ajax</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    </head>

    <body>
        <div id='main'></div>
        <button id='btn'>Click Me</button>

        <script>
            var weather = {
                url: 'http://api.openweathermap.org/data/2.5/weather',
                queryUrl: 'http://api.openweathermap.org/data/2.5/weather?',
                apiKey: 'APPID=14d451ce4404a3a3d48f1e04d36b5e4a',
                unitImperial: 'units=imperial',
                unitMetric: 'units=metric',
                queryImperialGetString: function () {
                    return weather.queryUrl + weather.apiKey + "&" + weather.unitImperial + '&';
                },
                queryMetricGetString: function (data) {
                    return weather.queryUrl + weather.apiKey + "&" + weather.unitMetric + '&' + data;
                }
            };

            var btn = document.getElementById('btn');

            btn.addEventListener('click', loadWeatherDataGet);


            function loadWeatherDataGet() {
//                var data = document.getElementById('form').value;
                xhr = new XMLHttpRequest();
                xhr.open('GET', weather.queryImperialGetString() + "id=5045020", true);
                xhr.onload = function () {
                    if (xhr.status == 200) {
                        console.log(JSON.parse(xhr.responseText));
                    }
                }
                xhr.send();
            }
        </script>

    </body>

</html>