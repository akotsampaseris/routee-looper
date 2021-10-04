<?php
/*

This is the main file, where all the functionality of our code is collected.
We instantiate all of our custom classes and initialize them with example data.
The runLooper() method the starts the loop making all the API calls.

*/
include 'inc/method.php';
include 'inc/user.php';
include 'inc/city.php';
include 'inc/open_weather_map_client.php';
include 'inc/routee_client.php';
include 'inc/looper.php';
include 'inc/settings.php';

// Instantiate the OpenWeatherMapClient
$open_weather_map_client = new OpenWeatherMapClient;
$open_weather_map_client->setAPIKey($settings["open_weather_map_api_key"]);

// Instantiate the RouteeClient
$routee_client = new RouteeClient;
$routee_client->setAPIKey($settings["routee_api_key"]);
$routee_client->runAuthentication();

// Instatiate a User and a City object with example data
$user = new User($name=$settings["user_name"], $phone_number = $settings["user_phone_number"]);
$city = new City($name=$settings["city_name"], $id=$settings["city_id"]);

// Define the main method and the looper
$method = new Method($user, $city, $open_weather_map_client, $routee_client);
$looper = new Looper($method, $iterations=10, $interval=10, $units='minutes');

// Start running the loop
$looper->runLooper();
?>
