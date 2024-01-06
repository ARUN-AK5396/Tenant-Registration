<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

// Initialize PHPMailer
$mail = new PHPMailer(true);

try {
    // SMTP Configuration
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'thedeveloper.arun@gmail.com'; // Your Gmail email
    $mail->Password = 'cwxhnvjzjslobmel'; // Your Gmail password
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    // Email content
    $mail->setFrom('thedeveloper.arun@gmail.com', 'Tenant Registration');
    $mail->addAddress($_POST['email']);
    $mail->isHTML(true);
    $mail->Subject = 'QR Code Attachment';
    $mail->Body = 'Please find your QR code attached below.';

    $tenantId = $_POST['tenantId']; 
    $filename = 'temp/tenant_' . $tenantId . '.png'; // Path to the existing QR code file

    // Attach existing QR code to the email
    $mail->addAttachment($filename, 'Tenant_QR.png');

    // Send email
    $mail->send();
    http_response_code(200);
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    http_response_code(500);
}
?>
