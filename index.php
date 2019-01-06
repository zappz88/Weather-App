<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Weather App</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    </head>

    <body>
        <div id='main'></div>
        <button id='btn'>Click Me</button>
        <br><br>
        <form>
            City: <input type="text" id="city">
        </form>

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
                queryImperialGetString: function () {
                    let city = weather.fixInput('city');
                    let data = 'q=' + city;
                    return this.queryUrl + this.apiKey + "&" + this.unitImperial + '&' + data;
                },
                queryMetricGetString: function () {
                    let city = weather.fixInput('city');
                    let data = 'q=' + city;
                    return this.queryUrl + this.apiKey + "&" + this.unitMetric + '&' + data;
                },
                jsonFileConstructor: function (responseJSON) {
                    this.currentTemp = responseJSON.main.temp;
                    this.loTemp = responseJSON.main.temp_min;
                    this.hiTemp = responseJSON.main.temp_max;
                    this.pressure = responseJSON.main.pressure;
                    this.humidity = responseJSON.main.humidity;
                    this.windSpeed = responseJSON.wind.speed;
                    this.windDegree = responseJSON.wind.deg;
                    this.weatherId = responseJSON.weather[0].id;
                    this.weatherType = responseJSON.weather[0].main;
                    this.weatherDescription = responseJSON.weather[0].description;
                    this.weatherIcon = responseJSON.weather[0].icon;
                },
                fixInput: function (id) {
                    let input = document.getElementById(id).value.toLowerCase();
                    let inputSplit = input.split(" ");
                    let data = [];
                    for (x in inputSplit) {
                        var check = inputSplit[x][0].toUpperCase();
                        var newWord = inputSplit[x].replace(inputSplit[x][0], check);
                        data.push(newWord);
                    };
                    let fixedCity = data.join(" ");
                    return fixedCity;
                }
            };

            var btn = document.getElementById('btn');
            var submit = document.getElementById('submit');
            btn.addEventListener('click', loadWeatherDataGet);

            function loadWeatherDataGet() {
                xhr = new XMLHttpRequest();
                xhr.open('GET', weather.queryImperialGetString(), true);
                xhr.onload = function () {
                    if (xhr.status == 200) {
                        let obj = JSON.parse(xhr.responseText);
                        let file = new weather.jsonFileConstructor(obj);
                        main.innerHTML = file.hiTemp;
                    };
                };
                xhr.send();
            };

        </script>

    </body>

</html>
