<?php

function auth() {

    $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.orange.com/oauth/v3/token',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => 'grant_type=client_credentials',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/x-www-form-urlencoded',
    'Authorization: Basic TW5WUHJ6d1V6M3JJOUdoeTlNYmU5Y0pwbWoydXRaU2Y6bDNhdkFSNWpMcVJHbmp6ag==',
    'Accept: application/json'
  ),
));

$response = curl_exec($curl);

$data =  json_decode($response , true);
curl_close($curl);
return $data['access_token'] ;
}

