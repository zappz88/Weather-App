<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Weather App</title>
        <link rel="stylesheet" href="weatherappcss.css">
        <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
        <script src="skycons.js"></script>
    </head>

    <body>
        <div class="content">

            <div class="current">
                <div class="location">
                    <h1 id="location">Location</h1>
                    <canvas id="currentDayIcon"></canvas>
                </div>

                <div class="temperature">
                    <div class="degree-section">
                        <h2 id="temperature-degree" class="temperature-degree"></h2>
                        <span>F</span>
                    </div>
                    <div id="temperature-description" class="temperature-description"></div>
                </div>


            </div>

            <div id="info" class="info">

            </div>

            <div id="week" class="week">

            </div>


        </div>
        <script>
            let info = document.getElementById('info');
            let week = document.getElementById('week');
            
            $(document).ready(function () {
                $('body').addClass('show');
            });

            /*Initializer Function*/
            window.addEventListener('load', () => {
                let long;
                let lat;
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(position => {
                        long = position.coords.longitude;
                        lat = position.coords.latitude;

                        const proxy = 'https://cors-anywhere.herokuapp.com/';
                        const api = `${proxy}https://api.darksky.net/forecast/d571a1e2483b31605b94edaae84c647e/${lat},${long}`;

                        let xhr = new XMLHttpRequest();
                        xhr.onreadystatechange = function () {
                            if (this.readyState === 4 && this.status === 200) {
                                let obj = JSON.parse(this.responseText);
                                console.log(obj);
                                $('#temperature-degree').html(Math.round(obj.currently.apparentTemperature));
                                $('#location').html(obj.timezone);
                                $('#temperature-description').html(obj.currently.summary);
                                setIcons(obj.currently.icon, document.getElementById('currentDayIcon'));
                                for (let i = 0; i < obj.hourly.data.length; i++) {
                                    info.innerHTML += `<div id='hour${i + 1}' class='hourly'><canvas id='hourIcon${i + 1}'></canvas><h3 id='hourTemp${i + 1}'></h3><p id='hourSummary${i + 1}'></p></div>`;
                                    setIcons(obj.hourly.data[i].icon, document.getElementById(`hourIcon${i + 1}`));
                                    $(`#hourTemp${i + 1}`).html(Math.round(obj.hourly.data[i].temperature));
                                    $(`#hourSummary${i + 1}`).html(obj.hourly.data[i].summary);
                                }
                                for (let i = 0; i < obj.daily.data.length; i++) {
                                    week.innerHTML += `<div id='day${i + 1}' class='daily'><canvas id='dayIcon${i + 1}'></canvas><h2 id='dayTemp${i + 1}'></h2><p id='daySummary${i + 1}'></p></div>`;
                                    setIcons(obj.daily.data[i].icon, document.getElementById(`dayIcon${i + 1}`));
                                    $(`#dayTemp${i + 1}`).html(Math.round(obj.daily.data[i].temperatureMax));
                                    $(`#daySummary${i + 1}`).html(obj.daily.data[i].summary);
                                }

                                for (let i = 0; i < obj.daily.data.length; i++) {
                                    var data = info.innerHTML;
                                    $(`#day${i + 1}`).bind('mouseenter mouseleave', function () {
                                        $(this).toggleClass('easeIn');
                                        $(this).toggleClass('pointer');
                                        if(info.innerHTML === data){
                                            info.innerHTML = "<div class='showData'><canvas id='icon'></canvas><h3 id='tempMax'></h3><h3 id='tempMin'></h3><h3 id='precip'></h3></h3><h3 id='wind'></h3></div>";  
                                            setIcons(obj.daily.data[i].icon, document.getElementById('icon'));
                                            $('#tempMax').html("Hi " + Math.round(obj.daily.data[i].temperatureMax));
                                            $('#tempMin').html("Lo " + Math.round(obj.daily.data[i].temperatureMin));
                                            $('#precip').html("Precipitation " + obj.daily.data[i].precipProbability);
                                            $('#wind').html("WindSpeed " + obj.daily.data[i].windSpeed);
                                        }
                                        else{
                                            info.innerHTML = data;
                                        }
                                    });
                                };
                                
                                function setIcons(icon, iconId) {
                                    const skycons = new Skycons({color: 'white'});
                                    const currentIcon = icon.replace(/-/g, '_').toUpperCase();
                                    skycons.play();
                                    return skycons.set(iconId, Skycons[currentIcon]);
                                };
                            }
                        };
                        xhr.open("GET", api, true);
                        xhr.send();
                    });
                }
            });
            
        </script>

    </body>

</html>
