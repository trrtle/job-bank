<?php

// load dependencies
use PHPMailer\PHPMailer\PHPMailer;
require '../composer/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../composer/vendor/phpmailer/phpmailer/src/SMTP.php';
require '../composer/vendor/phpmailer/phpmailer/src/Exception.php';

function mailer($receiverMail, $receiverName, $subject, $message){

    $mail = new PHPMailer();

    // verbinden met Gmail
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'ssl';
    $mail->Host = MAIL_HOST;
    $mail->Port = MAIL_PORT;

    // Gmail authentication.
    $mail->Username = MAIL_USERNAME;
    $mail->Password = MAIL_SECRET;

    // Create Email.
    $mail->isHTML(true);
    $mail->setFrom(MAIL_USERNAME, SITENAME);
    $mail->Subject = $subject;
    $mail->CharSet = 'UTF-8';

    $message = '<body style="font-family: Verdana, Verdana, Geneva, sans-serif; font-size: 14px; color: #000000;">'
        . $message . '</body></html>';

    $mail->addAddress($receiverMail, $receiverName);
    $mail->Body = $message;

    if($mail->send()){
        return true;
    }else{
        return false;
    }
}

function registrationEmail($email, $username){

    $subject = "Nieuw account";
    $message = "Geachte $username uw account is aangemaakt.";

    mailer($email, $username, $subject, $message);
}
