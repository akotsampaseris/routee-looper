<?php
/*

The User class is a simple class with only a __construct() method that
represents an object that normally would be stored on a database.

*/
class User {
  function __construct($name, $phone_number){
    $this->name = $name;
    $this->phone_number=$phone_number;
  }
}
?>
