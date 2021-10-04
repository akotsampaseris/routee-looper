<?php
/*

The Method class defines the main method that is to be run in the script.
It has a run() method which, when executed, represents the core
functionality of our program. It was created in order to be passed as an
argument in the Looper class and be run for a number of iterations
in specific intervals.

*/

class Method{
  function __construct($user, $city, $open_weather_map_client, $routee_client){
    $this->user = $user;
    $this->city = $city;
    $this->open_weather_map_client = $open_weather_map_client;
    $this->routee_client = $routee_client;
  }

  function run(){
    $this->city->setTemperature($this->open_weather_map_client->getTemperature($this->city));
    $this->routee_client->sendSMS($this->user, $this->city);
  }
}
?>
