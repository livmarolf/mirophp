<?php


function getjwt($client_id, $code)
{

  $client_secret = getenv("CLIENT_SECRET");

  $curl = curl_init();

  curl_setopt_array($curl, [
    CURLOPT_URL => "https://api.miro.com/v1/oauth/token?grant_type=authorization_code&client_id=$client_id&client_secret=$client_secret&code=$code&redirect_uri=http://localhost:8000/dashboard.php",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_HTTPHEADER => [
      "Accept: application/json"
    ],
  ]);

  $response = curl_exec($curl);
  $err = curl_error($curl);

  curl_close($curl);

  if ($err) {
    echo "cURL Error #:" . $err;
    exit();
  } else {
    return json_decode($response)->access_token;
  }
}
