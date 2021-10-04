<?php
/*

The Looper class is used to automate the repetition of the API calls
in specific time intervals and for a specified number of iterations.

It has a special method that allows us to convert the time interval units given
by the user to seconds, which are then used in the sleep() method that
represents the interval time. Options: hours, minutes and seconds.

It also has the main runLooper() method that constructs the loop that allows us
to repeat the API calls as needed by the user.

*/
class Looper {
  function __construct($method, $iterations, $interval, $units="seconds"){
    $this->method = $method;
    $this->iterations = $iterations;
    $this->interval = $interval;
    $this->units = $units;
    $this->interval_in_seconds = $this->convertToSeconds();
  }

  function convertToSeconds(){
    switch($this->units){
      case "hours":
        $interval_in_seconds = $this->interval*3600;
        return $interval_in_seconds;
      case "minutes":
        $interval_in_seconds = $this->interval*60;
        return $interval_in_seconds;
      case "seconds":
        return $this->interval;
      case "milliseconds":
        $interval_in_seconds = $this->interval/1000;
        return $interval_in_seconds;
    }
  }

  function runLooper(){
    for($i=0;$i<$this->iterations;$i++){
      $this->method->run();
      sleep($this->interval_in_seconds);
    }
  }

}

?>
