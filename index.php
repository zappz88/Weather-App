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
                
                <div id="location" class="location">
                    
                    <h1 id="currentLocation">Location</h1>
                    <canvas id="currentDayIcon"></canvas>
                    
                </div>

                <div class="temperature">
                    
                    <h3 id="temperature-degree" class="degree-section">
                        
                    </h3>
                    
                    <h3 id="temperature-description" class="temperature-description">
                        
                    </h3>
                </div>


            </div>

            <div id="info" class="info">

            </div>

            <div id="week" class="week">

            </div>


        </div>
        <script>
            const info = document.getElementById('info');
            const week = document.getElementById('week');
            
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
                                $('#currentLocation').html(obj.timezone);
                                $('#temperature-description').html(obj.currently.summary);
                                setIcons(obj.currently.icon, document.getElementById('currentDayIcon'));
                                
                                for (let i = 0; i < obj.hourly.data.length; i++) {
                                    info.innerHTML += `<div id='hour${i + 1}' class='hourly'><canvas id='hourIcon${i + 1}'></canvas><h3 id='hourTemp${i + 1}'></h3><p id='hourSummary${i + 1}'></p><p id='time${i + 1}'></p></div>`;
                                    setIcons(obj.hourly.data[i].icon, document.getElementById(`hourIcon${i + 1}`));
                                    $(`#hourTemp${i + 1}`).html(Math.round(obj.hourly.data[i].temperature));
                                    $(`#hourSummary${i + 1}`).html(obj.hourly.data[i].summary);
                                    $(`#time${i + 1}`).html(getHour(obj.hourly.data[i].time));
                                }
                                
                                for (let i = 0; i < obj.daily.data.length; i++) {
                                    week.innerHTML += `<div id='day${i + 1}' class='daily'><p id='weekDay${i + 1}'></p><canvas id='dayIcon${i + 1}'></canvas><h2 id='dayTemp${i + 1}'></h2><p id='daySummary${i + 1}'></p></div>`;
                                    setIcons(obj.daily.data[i].icon, document.getElementById(`dayIcon${i + 1}`));
                                    $(`#dayTemp${i + 1}`).html(Math.round(obj.daily.data[i].temperatureMax));
                                    $(`#daySummary${i + 1}`).html(obj.daily.data[i].summary);
                                    $(`#weekDay${i + 1}`).html(getDay(obj.daily.data[i].time));
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
                                            $('#wind').html("WindSpeed " + obj.daily.data[i].precipProbability);
                                        }
                                        else{
                                            info.innerHTML = data;
                                        }
                                    });
                                };
                                
                                function setIcons(icon, iconId) {
                                    let skycons = new Skycons({color: 'white'});
                                    let currentIcon = icon.replace(/-/g, '_').toUpperCase();
                                    skycons.play();
                                    return skycons.set(iconId, Skycons[currentIcon]);
                                };
                                
                                function getHour(unixTime){
                                    let date = new Date(unixTime * 1000);
                                    if(date.getHours() > 12){
                                        return (date.getHours() - 12) + 'pm';
                                    }
                                    return date.getHours() + 'am';
                                }
                                
                                function getDay(unixTime){
                                    let date = new Date(unixTime * 1000);
                                    switch(date.getDay()){
                                        case 0:
                                            return "Sunday";
                                            break;
                                        case 1:
                                            return "Monday";
                                            break;
                                        case 2:
                                            return "Tuesday";
                                            break;
                                        case 3:
                                            return "Wednesday";
                                            break;
                                        case 4:
                                            return "Thursday";
                                            break;
                                        case 5:
                                            return "Friday";
                                            break;
                                        case 6:
                                            return "Saturday";
                                            break;
                                    }
                                }
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
