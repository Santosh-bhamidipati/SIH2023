<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'C:/sih ke web/Harsha/PHPMailer-master/src/Exception.php';
require 'C:/sih ke web/Harsha/PHPMailer-master/src/PHPMailer.php';
require 'C:/sih ke web/Harsha/PHPMailer-master/src/SMTP.php';

$name = $_POST['name'];
$email = $_POST['email'];
$otp = rand(100000, 999999);

$_SESSION['otp'] = $otp;
$_SESSION['otp_time'] = time();

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'h82070303@gmail.com';
    $mail->Password = 'xtpwmqkbuvmpzbws';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('h82070303@gmail.com', 'Codecrafters');
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = 'OTP for Sign Up';
    $mail->Body = strtoupper($name) . ", your OTP is: $otp<br>(OTP is only valid for 3 minutes)";

    $mail->send();

} catch (Exception $e) {
    echo "Error sending OTP: {$mail->ErrorInfo}";
}
?>
