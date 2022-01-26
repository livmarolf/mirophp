<?php

require_once "lib/jwt.php";

$token = getjwt($_GET["client_id"], $_GET["code"]);


//Get Board

$curl = curl_init();

curl_setopt_array($curl, [
  CURLOPT_URL => "https://api.miro.com/v1/boards/uXjVOSxd-VE%3D/widgets/",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => [
    "Accept: application/json",
    "Authorization: Bearer $token"
  ],
]);

$board_response = json_decode(curl_exec($curl));
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
  exit();
}
//uXjVOSxd-VE%3D
//List all team members

$curl = curl_init();

$team_id = $_GET["team_id"];

curl_setopt_array($curl, [
  CURLOPT_URL => "https://api.miro.com/v1/teams/$team_id/user-connections?limit=10&offset=0",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => [
    "Accept: application/json",
    "Authorization: Bearer $token"
  ],
]);

$team_response = json_decode(curl_exec($curl));
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
  exit();
} 



?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style>
    li {
      background-color: var(--bg-color);
    }
  </style>
</head>
<body>
  <h1>
    Dashboard
  </h1>
  <h2>
    Widgets
  </h2>
  <ul>
    <?php
      foreach ($board_response->data as $widget) {
        if ($widget->type == "sticker") {
          echo "
          <li style=\" --bg-color:".$widget->style->backgroundColor."\">
            ".$widget->text."
          </li>
          ";
        }
      }
      ?>
      </ul>
      <h2>
        Team Members
      </h2>
      <ul>
        
      <?php
      foreach ($team_response->data as $member) {
          echo "
          <li>
            ".$member->user->name." (".$member->role.")
            
          </li>
          ";
      }
    ?>
  </ul>
</body>
</html>

