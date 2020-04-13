<?php
include('menu.php');
include('LoginRequest.php');

$settings = new Settings();
$loginRequest = new LoginRequest(333333, "ADMIN", "Aa123456");
$response = $loginRequest->execute($settings);
$output = Helper::formattoJSONOutput($response);

print "<h3>Sonuç:</h3>";
echo "<pre>";
echo htmlspecialchars($output);
echo "</pre>";
