//APIKEY
var url = "/api/weather.json";

//Adding data to the elements with a certain ID
var setTextById = function (id, value){
    var element = document.getElementById(id);
    var text = document.createTextNode(value);
    element.appendChild(text);
}

window.addEventListener('load',function () {
  var image = "http://openweathermap.org/img/w/"
  var extension = ".png"
  var ajax = new XMLHttpRequest();
  ajax.onreadystatechange = function () {
    if(ajax.readyState == 4 && ajax.status == 200){
      var json = JSON.parse(ajax.responseText);
      var image1 = document.getElementById('img_c');
      var image2 = document.getElementById('img_n');

      setTextById('location', "Weather in " +json.city['name'] + ', ' + json.city['country']);

      image1.src = ( image + json.list[0].weather[0].icon +  extension);
      image2.src = ( image + json.list[1].weather[0].icon +  extension);
/*
      setTextById('temp_c', (json.list[0].main['temp']).toFixed(0) + ' °C');
      setTextById('temp_n', (json.list[1].main['temp']).toFixed(0) + ' °C');

      setTextById('windspeed_c', 'Wind: '+ ((json.list[0].wind['speed'])*3.6).toFixed(0)+ ' km/h');
      setTextById('windspeed_n', 'Wind: '+ ((json.list[1].wind['speed'])*3,6).toFixed(0)+ ' km/h');
*/

for(var i = 0; i<2; i++){
          setTextById('temp_' + i, (json.list[i].main['temp']).toFixed(0) + ' °C' );                        //Getting temperature
          setTextById('windspeed_' + i, 'Wind: '+ ((json.list[i].wind['speed'])*3.6).toFixed(0)+ ' km/h');  //Getting windspeed
      }

/*
      setTextById('temp_c', (json.list[0].main['temp']).toFixed(0) + ' °C');
      setTextById('temp_n', (json.list[1].main['temp']).toFixed(0) + ' °C');
      setTextById('windspeed_c', 'Wind: '+ ((json.list[0].wind['speed'])*3.6).toFixed(0)+ ' km/h');
      setTextById('windspeed_n', 'Wind: '+ ((json.list[1].wind['speed'])*3,6).toFixed(0)+ ' km/h');

*/


      if(json.list[0].rain != null){
          if(json.list[0].rain['3h'] != null){
              setTextById('precipC_c', "Precipitation: " + (json.list[0].rain['3h']) + " mm");
          } else{
              setTextById('precipC_c', "Precipitation: 0 mm   ");
          }
      } else {
          setTextById('precipC_c', "Precipitation: No info from openweathermap");
      }

      if(json.list[1].rain != null){
          if(json.list[1].rain['3h'] != null){
              setTextById('precipC_n', "Precipitation: " + (json.list[1].rain['3h']) + " mm");
          } else{
              setTextById('precipC_n', "Precipitation: 0 mm");
          }
      } else {
          setTextById('precipC_n', "Precipitation: No info from openweathermap");
      }
    }
  }
  ajax.open('GET', url, true);    //Request
  ajax.send();                    //Zenden van de request
});
