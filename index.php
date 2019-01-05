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
                iconLocation: "http://openweathermap.org/img/w/",
                showIcon: function (icon) {//icon is image file name
                    return "<img src='" + this.iconLocation + icon + '.png' + "'>";
                },
                queryImperialGetString: function(data) {
                    return this.queryUrl + this.apiKey + "&" + this.unitImperial + '&';
                },
                queryMetricGetString: function(data) {
                    return this.queryUrl + this.apiKey + "&" + this.unitMetric + '&' + data;
                },
                jsonFileConstructor: function(data) {
                    this.currentTemp = data.main.temp;
                    this.loTemp = data.main.temp_min;
                    this.hiTemp = data.main.temp_max;
                    this.pressure = data.main.pressure;
                    this.humidity = data.main.humidity;
                    this.windSpeed = data.wind.speed;
                    this.windDegree = data.wind.deg;
                    this.weatherId = data.weather[0].id;
                    this.weatherType = data.weather[0].main;
                    this.weatherDescription = data.weather[0].description;
                    this.weatherIcon = data.weather[0].icon;
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
                        let obj = JSON.parse(xhr.responseText);
                        let data = new weather.jsonFileConstructor(obj);
                        main.innerHTML = data.weatherDescription;

                    }
                }
                xhr.send();
            }
        </script>

    </body>

</html>
