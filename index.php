<?php

$SteamAPIKey = "CHANGE API KEY";

$error_url = "http://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
$error_url_test = $error_url . "?steamid=76561198180825569";
$error_url_server = $error_url . "?steamid=%s";

if (!isset($_GET["steamid"])) {
    die("
<br />Woops, you don't seem to be using the correct extension in the address bar to get the loading screen to work.
<br />
Please make sure it has the correct extension it should have ?steamid= at the end of it and look something like this: https://localhost/index.php?steamid=%s
<br />
<br />

You can use the link below which will automatically add a test steam id to see if your loading screen is configured properly
<br />
<a href='$error_url_test'>$error_url_test</a>
<br />
<br />

When setting your loading url please make sure you set the steam id to %s as shown in the link below
<br />
<a href='$error_url_server'>$error_url_server</a>

");
}

$steamid64 = $_GET["steamid"];

$url =
    "http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=" .
    $SteamAPIKey .
    "&steamids=" .
    $steamid64;
$json = file_get_contents($url);
$table2 = json_decode($json, true);
$table = $table2["response"]["players"][0];
?> <html>
  <!--DO NOT TOUCH THIS, THIS IS THE SYSTEM CODE OF THE LOADING SCREEN!-->

  <head>
    <meta charset="utf-8">
    <title>T-Moov Loading</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="icon" href="assets/img/favicon.ico" />
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@800&display=swap" rel="stylesheet">
  </head>

  <body>
    <div class="background">
      <div class="card-container">
        <span class="server">T-Moov</span>
        <div id=\"avatarimg\">
          <div class="round"><?php
   		  echo "<div id=\"avatarimg\">";
   		  echo "<img src=\"" . $table["avatarfull"] . "\" />";
   		  echo "</div>";
   		  ?></div>
        </div>
        <h3><?php
  	    echo "<p>Welcome, " . $table["personaname"] . "</p>";
   		echo "<p>" . $table["steamid"] . "</p>";
        ?></h3>
        <div class="buttons">
          <button class="primary"> SeriousRP </button>
        </div>
        <div class="skills">
          <h6>Skills</h6>
          <ul>
            <li>Map Custom</li>
            <li>Staff Fast</li>
            <li>Best Addons</li>
            <li>T-Tron Is A Best :)</li>
          </ul>
        </div>
      </div>
      <div class="other-container">
        <div id="player"></div>
        <div id="overlay"></div>
        <h1>LOADING :</h1>
        <h1>
          <div class="infotext" id="status">Retrieving information from the server...</div>
        </h1>
        <h1>YOU ARE LISTENING :</h1>
        <h1>
          <div class="infotext" id="music-name"></div>
        </h1>
      </div>
      <script src="assets/js/lib/jquery-2.1.1.min.js"></script>
      <script src="assets/js/lib/jquery.backstretch.min.js"></script>
      <script src="assets/js/config.js"></script>
      <script src="assets/js/t-moovloading.js"></script>
  </body>
  
</html>