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
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 465;

    // Gmail authentication.
    $mail->Username='Turtledev94@gmail.com';
    $mail->Password='Asdf1234!';

    // Create Email.
    $mail->isHTML(true);
    $mail->setFrom('Turtledev94@gmail.com', "Naam");
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
