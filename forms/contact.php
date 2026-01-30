<?php

$receiving_email_address = "lv_ale@outlook.com";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  http_response_code(405);
  echo "Método no permitido";
  exit;
}

$name    = trim($_POST["name"] ?? "");
$email   = trim($_POST["email"] ?? "");
$subject = trim($_POST["subject"] ?? "");
$message = trim($_POST["message"] ?? "");

if ($name === "" || $subject === "" || $message === "" || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
  http_response_code(400);
  echo "Por favor completa todos los campos correctamente.";
  exit;
}

$email_subject = "Mensaje desde tu Portafolio: $subject";
$email_body  = "Nombre: $name\n";
$email_body .= "Email: $email\n\n";
$email_body .= "Mensaje:\n$message\n";

$headers  = "From: $name <$email>\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

if (mail($receiving_email_address, $email_subject, $email_body, $headers)) {
  echo "OK";
} else {
  http_response_code(500);
  echo "No se pudo enviar el mensaje. Intenta más tarde.";
}
