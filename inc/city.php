<?php
/*

The city class is a simple class with a __construct() method that
represents an object that normally would be stored on a database.
It also has a setTemperature() method which allows us to refresh the temperature
of the specified city.

*/
class City {
  function __construct($name, $id){
    $this->name = $name;
    $this->id   = $id;
  }

  function setTemperature($temperature){
    $this->temperature=$temperature;
  }
}
?>
