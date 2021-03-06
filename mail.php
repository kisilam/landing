<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

define('MY_APP', true);
include 'config/config.php';

// Load Composer's autoloader
require 'vendor/autoload.php';

$full_name = $_GET['name'];
$telephone = $_GET['phone']; 
// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'mail1.kupuy.top'; 
    $mail->Username   = $mailUsername;                     // SMTP username
    $mail->Password   = $mailPassword;                     // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                                 // SMTP password
//    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
    $mail->Port       = 25;


    $mail->CharSet = 'UTF-8';                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('sale@kraski.ooo', 'Kraski.ooo');
    $mail->addAddress('info@kraski.ooo', 'Продажы Краски');     // Add a recipient
//    $mail->addAddress('ellen@example.com');               // Name is optional
    $mail->addReplyTo('sale@kraski.ooo', 'Information');
//    $mail->addCC('cc@example.com');
//    $mail->addBCC('bcc@example.com');

    // Attachments
//    $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Запрос обратного звонка на сайте kiev.kraski.ooo';
    $mail->Body    = 'Добрый день. Меня зовут <b>' . $full_name . '</b>, перезвоните мне на номер <b>' . $telephone . '</b> для уточнение подробностей';
    $mail->AltBody = 'Добрый день. Меня зовут ' . $full_name . ', перезвоните мне на номер ' . $telephone . ' для уточнение подробностей';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}