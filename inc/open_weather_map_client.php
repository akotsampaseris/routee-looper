<?php
/*

The OpenWeatherMapClient class defines the API used by Open Weather Map.
Its method getTemperature($city) creates a GET request which returns
the current temperature in the city, represented by the $city variable.

*/
class OpenWeatherMapClient {
  function setAPIKey($api_key){
    $this->api_key = $api_key;
  }

  function getTemperature($city){
    $url = "api.openweathermap.org/data/2.5/weather?id={$city->id}&appid={$this->api_key}&units=metric";

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $json = curl_exec($curl);
    curl_close($curl);

    $output = json_decode($json, true);
    $temperature = ceil($output['main']['temp']);

    return $temperature;
  }
}
?>
