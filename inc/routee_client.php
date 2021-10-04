<?php
/*

The RouteeClient class defines the API used in the Routee app, by AMD Telecom.

The setAPIKey($api_key) method stores the base_64-encoded string,
made up using the application ID and the secret key given by Routee.

The runAuthentication() method makes a POST request that authenticates
the validity of the given $api_key. In case of an error, it is printed on
the console. If successful, it returns a success message.

The sendSMS($user, $city, $temp_limit) method is responsible for sending
an SMS to the phone number specified in the $user object. The message is defined
after comparing the temperature of the given $city to the $temp_limit set by
the user.

*/
class RouteeClient {
  function setAPIKey($api_key){
    $this->api_key = $api_key;
  }

  function runAuthentication(){
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://auth.routee.net/oauth/token",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => "grant_type=client_credentials",
      CURLOPT_HTTPHEADER => array(
        "authorization: Basic {$this->api_key}",
        "content-type: application/x-www-form-urlencoded"
      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      echo "cURL Error #:" . $err;
    } else {
      $decoded_response = json_decode($response, true);
      $this->access_token = $decoded_response["access_token"];
      echo("Routee authentication successful!\n");
    };
  }

  function sendSMS($user, $city, $temp_limit=20){
    if ($city->temperature > $temp_limit){
      $message = "Hi, {$user->name}! The temperature in {$city->name} is {$city->temperature}, which is above {$temp_limit} degrees Celsius!";
    } elseif ($city->temperature < $temp_limit){
      $message = "Hi, {$user->name}! The temperature in {$city->name} is {$city->temperature}, which is below {$temp_limit} degrees Celsius!";
    } elseif ($city->temperature == $temp_limit){
      $message = "Hi, {$user->name}! The temperature in {$city->name} is {$city->temperature} exactly!";
    } else {
      $message = "Hi, {$user->name}! There has been an error! Please, try again later!";
    };

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://connect.routee.net/sms",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => "{ \"body\": \"{$message}\",\"to\" : \"{$user->phone_number}\",\"from\": \"amdTelecom\"}",
      CURLOPT_HTTPHEADER => array(
        "authorization: Bearer {$this->access_token}",
        "content-type: application/json"
      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      echo "cURL Error #:" . $err;
    } else {
      echo("SMS sent successfully!\n");
    }
  }
};

?>
