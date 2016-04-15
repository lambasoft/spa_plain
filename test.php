<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 4/15/16
 * Time: 2:43 PM
 */
require_once("vendor/autoload.php");
// Check configuration for SMTP parameters
$mail = new \PHPMailer;
$mail->isSMTP();
$mail->Host = "server187.web-hosting.com";
$mail->SMTPAuth = true;
$mail->Username = "no-reply@spaadvisor.me";
$mail->Password = "sp@_123";
$mail->Port = "465";
$mail->SMTPSecure = 'ssl';


$mail->From = "no-reply@spaadvisor.me";
$mail->FromName = "Hello";
$mail->addAddress("lambasoftwares@gmail.com");
$mail->isHTML(true);

$mail->Subject = "Subject Here";
$mail->Body = "Body Here";
$mail->AltBody = "Alt Body here";
//send the message, check for errors
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent!";
}