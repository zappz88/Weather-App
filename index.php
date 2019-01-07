<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Weather App</title>
<!--        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>-->
    </head>

    <body>
        <div id='div_1'></div>
        <div id='div_2'></div>
        <div id='div_3'></div>
        <div id='div_4'></div>
        <div id='div_5'></div>
        <div id='div_6'></div>
        <div id='div_7'></div>
        <div id='div_8'></div>
        <div id='div_9'></div>

        <button id='btn1'>Get Weather</button>
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
                    let fixedInput = data.join(" ");
                    return fixedInput;
                }
            };
            
            var city = {
            file: ''
            };
           

            var btn1 = document.getElementById('btn1');
            btn1.addEventListener('click', weatherData);

            function weatherData() {
                xhr = new XMLHttpRequest();
                xhr.open('POST', weather.queryImperialGetString(), true);
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        let obj = JSON.parse(xhr.responseText);
                        let file = new weather.jsonFileConstructor(obj);
                        city.file = file;
                        document.getElementById('div_1').innerHTML = "Current Temp: " + city.file.currentTemp;
                        document.getElementById('div_2').innerHTML = "High: " + city.file.hiTemp;
                        document.getElementById('div_3').innerHTML = "Low: " +city.file.loTemp;
                        document.getElementById('div_4').innerHTML = "Humidity: " + city.file.humidity;
                        document.getElementById('div_5').innerHTML = "Weather Type: " + city.file.weatherType;
                        document.getElementById('div_9').innerHTML = "Weather Description: " + city.file.weatherDescription;
                        document.getElementById('div_6').innerHTML = weather.showIcon(city.file.weatherIcon);
                        document.getElementById('div_7').innerHTML = "Windspeed: " + city.file.windSpeed;
                        document.getElementById('div_8').innerHTML = "Wind Direction: " + city.file.windDegree;
                        document.getElementById('div_9').innerHTML = "Pressure: " + city.file.pressure;
                    };
                };
                xhr.send();
            };
            
            
        </script>

    </body>

</html>
