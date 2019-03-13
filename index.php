<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Weather App</title>
        <link rel="stylesheet" href="weatherappcss.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    </head>

    <body>
        <!--        <div id="grid-container">-->
        <div id="header-banner">
            <div id="header">WeatherApp</div>
        </div>

        <div id='div_search'> 
            <form>
                City: <input type="text" id="city">
            </form>
            <button id='btn1'>Get Weather</button>
        </div>

        <div id="main-content">
            <div id='div_1'></div>
            <div id='div_2'></div>
            <div id='div_3'></div>
            <div id='div_4'></div>
            <div id='div_5'></div>
            <div id='div_6'></div>
            <div id='div_7'></div>
            <div id='div_8'></div>
            <div id='div_9'></div>
        </div>


        <!--        </div>-->
        <script>
            //Global object/variable declaration
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
                    return this.queryUrl + this.apiKey + "&" + this.unitImperial + '&';
                },
                queryMetricGetString: function () {
                    let data = 'q=' + fixInput('city');
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
                }
            };



            var images = {
                snow: 'https://www.trbimg.com/img-5aa059f5/turbine/bs-md-weather-20180305',
                sunny: 'http://www.cubaweather.org/images/weather-photos/large/Sunny-morning-east-Matanzas-city-Cuba-20170131-1080.jpg',
                rain: 'https://i.pinimg.com/originals/23/d8/ab/23d8ab1eebc72a123cebc80ce32b43d8.jpg'
            };

            var errors = {
                error400: "Bad Request.",
                error401: "Authentication Failed.",
                error403: "Forbidden.",
                error404: "File not found."
            };

            var city = {
                file: ''
            };

            //Global function declaration
            function fixInput(id) {
                let input = document.getElementById(id).value.toLowerCase();
                let inputSplit = input.split(" ");
                let data = [];
                for (x in inputSplit) {
                    var check = inputSplit[x][0].toUpperCase();
                    var newWord = inputSplit[x].replace(inputSplit[x][0], check);
                    data.push(newWord);
                }
                ;
                let fixedInput = data.join(" ");
                return fixedInput;
            }
            ;

            function weatherData() {
                xhr = new XMLHttpRequest();
                let data = 'q=' + fixInput('city');
                xhr.open('POST', weather.queryImperialGetString() + data, true);


                xhr.onload = function () {
                    if (this.status == 200) {
                        let obj = JSON.parse(xhr.responseText);
                        let file = new weather.jsonFileConstructor(obj);
                        city.file = file;
                        document.getElementById('div_1').innerHTML = "Current Temp: " + city.file.currentTemp;
                        document.getElementById('div_2').innerHTML = "High: " + city.file.hiTemp;
                        document.getElementById('div_3').innerHTML = "Low: " + city.file.loTemp;
                        document.getElementById('div_4').innerHTML = "Humidity: " + city.file.humidity;
                        document.getElementById('div_5').innerHTML = "Weather Type: " + city.file.weatherType;
                        document.getElementById('div_9').innerHTML = "Weather Description: " + city.file.weatherDescription;
                        document.getElementById('div_6').innerHTML = weather.showIcon(city.file.weatherIcon);
                        document.getElementById('div_7').innerHTML = "Windspeed: " + city.file.windSpeed;
                        document.getElementById('div_8').innerHTML = "Wind Direction: " + city.file.windDegree;
                        document.getElementById('div_9').innerHTML = "Pressure: " + city.file.pressure;
                        background();
                    }
                    ;
                    if (this.status == 400) {
                        document.getElementById('div_1').innerHTML = errors.error400;
                        document.getElementById('div_2').innerHTML = "";
                        document.getElementById('div_3').innerHTML = "";
                        document.getElementById('div_4').innerHTML = "";
                        document.getElementById('div_5').innerHTML = "";
                        document.getElementById('div_9').innerHTML = "";
                        document.getElementById('div_6').innerHTML = "";
                        document.getElementById('div_7').innerHTML = "";
                        document.getElementById('div_8').innerHTML = "";
                        document.getElementById('div_9').innerHTML = "";
                    }
                    ;
                    if (this.status == 401) {
                        document.getElementById('div_1').innerHTML = errors.error401;
                        document.getElementById('div_2').innerHTML = "";
                        document.getElementById('div_3').innerHTML = "";
                        document.getElementById('div_4').innerHTML = "";
                        document.getElementById('div_5').innerHTML = "";
                        document.getElementById('div_9').innerHTML = "";
                        document.getElementById('div_6').innerHTML = "";
                        document.getElementById('div_7').innerHTML = "";
                        document.getElementById('div_8').innerHTML = "";
                        document.getElementById('div_9').innerHTML = "";
                    }
                    ;
                    if (this.status == 403) {
                        document.getElementById('div_1').innerHTML = errors.error403;
                        document.getElementById('div_2').innerHTML = "";
                        document.getElementById('div_3').innerHTML = "";
                        document.getElementById('div_4').innerHTML = "";
                        document.getElementById('div_5').innerHTML = "";
                        document.getElementById('div_9').innerHTML = "";
                        document.getElementById('div_6').innerHTML = "";
                        document.getElementById('div_7').innerHTML = "";
                        document.getElementById('div_8').innerHTML = "";
                        document.getElementById('div_9').innerHTML = "";
                    }
                    ;
                    if (this.status == 404) {
                        document.getElementById('div_1').innerHTML = errors.error404;
                        document.getElementById('div_2').innerHTML = "";
                        document.getElementById('div_3').innerHTML = "";
                        document.getElementById('div_4').innerHTML = "";
                        document.getElementById('div_5').innerHTML = "";
                        document.getElementById('div_9').innerHTML = "";
                        document.getElementById('div_6').innerHTML = "";
                        document.getElementById('div_7').innerHTML = "";
                        document.getElementById('div_8').innerHTML = "";
                        document.getElementById('div_9').innerHTML = "";
                    }
                    ;
                };
                xhr.send();
            }
            ;

//            function mapper(obj, mapFn){
//                 return Object.keys(obj).reduce(function(result, key){
//                     result[key] = mapFn(obj[key]);
//                     return result;
//                 }, {});
//             }

            const mapper = (obj, mapFn) => Object.keys(obj).reduce((result, key) => {
                    result[key] = mapFn(obj)[key];
                    return result;
                }, {});

//            var newImages = mapper(images, function (value) {
//                return value;
//            });

            var newImages = mapper(images, (value) => value);

            console.log(newImages);

            //Button renaming and activity assignment
            var btn1 = document.getElementById('btn1');
            btn1.addEventListener('click', weatherData);

            function background() {
                Object.keys(newImages).map((key) => newImages[key] = 'url(' + '"' + newImages[key] + '"' + ')');
                switch (city.file.icon) {
                    case "11d":
                        $("#main-content").css('background-image', url("https://i.ytimg.com/vi/HfAUQ2nzW7I/maxresdefault.jpg"));
                        document.body.style.color = white;
                        break;
                    case "09d":
                        $("#main-content").css('background-image', newImages.rain);
                        break;
                    case "10d":
                        $("#main-content").css('background-image', newImages.rain);
                        break;
                    case "13d":
                        $("#main-content").css('background-image', newImages.rain);
                        break;
                    case "50d":
                        $("#main-content").css('background-image', newImages.rain);
                        break;
                    case "01d":
                        $("#main-content").css('background-image', url("https://i.ytimg.com/vi/HfAUQ2nzW7I/maxresdefault.jpg"));
                        break;
                }
            }


        </script>

    </body>

</html>
