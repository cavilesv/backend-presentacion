<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require __DIR__ . '/vendor/phpmailer/phpmailer/src/Exception.php';
require __DIR__ . '/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require __DIR__ . '/vendor/phpmailer/phpmailer/src/SMTP.php';

$mail = new PHPMailer(true);

//VARIABLES:

// Obtiene el cuerpo bruto de la solicitud
$json = file_get_contents('php://input');
// Decodifica el JSON en un arreglo asociativo
$data = json_decode($json, true);

$nombre_remitente = html_entity_decode($data["nombreRemitente"]);
$correo_electronico = html_entity_decode($data["correoElectronico"]);
$mensaje = html_entity_decode($data["mensaje"]);

try {
    // Configuración del servidor
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'cristofer.aviles.v@gmail.com';        // 🔑 Tu correo Gmail
    $mail->Password   = 'jpne karo xkkf aolx';      // 🔐 Clave de aplicación, no tu contraseña normal
   
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Configuración del remitente y destinatario
    $mail->setFrom('cristofer.aviles.v@gmail.com', );
    $mail->addAddress('cristofer.aviles.v@gmail.com', utf8_decode('Cristofer Avilés Vega'));
    $mail->addAddress($correo_electronico, utf8_decode($nombre_remitente));

    // Contenido del correo
    $mail->isHTML(true);
    $mail->Subject = utf8_decode("Mensaje enviado por " . $nombre_remitente);
    $mail->Body    = $mensaje ;
    //$mail->AltBody = 'Este correo fue enviado exitosamente usando PHPMailer';
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;

    $mail->Debugoutput = 'html';

    // Enviar
    $mail->send();
    echo 'Mensaje enviado correctamente';
} catch (Exception $e) {
   
    echo "Error al enviar el mensaje: {$e->errorMessage()}";
} 
?>