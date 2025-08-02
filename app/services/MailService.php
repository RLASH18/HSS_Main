<?php

namespace app\services;

use app\core\Application;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class MailService
{
    /**
     * Sends an email using PHPMailer and SMTP configuration.
     * 
     * @param string $to      The recipient's email address
     * @param string $subject The subject of the email
     * @param string $body    The HTML body content of the email
     * 
     * @return bool           True if email was sent successfully, false otherwise
     */
    public static function send($to, $subject, $body)
    {
        $mail = new PHPMailer(true);

        // Retrieve mail configuration from the application config
        $config = Application::$app->config['mail'];

        try {
            // Configure PHPMailer to use SMTP
            $mail->isSMTP();                                         //Send using SMTP
            $mail->Host       = $config['host'];                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                //Enable SMTP authentication
            $mail->Username   = $config['username'];                 //SMTP username
            $mail->Password   = $config['password'];                 //SMTP password
            $mail->Port       = $config['port'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

            // Set sender and recipient details
            $mail->setFrom($config['from'], $config['from_name']);
            $mail->addAddress($to);

            // Set email content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $body;

            // Attempt to send the email
            return $mail->send();
        } catch (\Exception $e) {
            // Log or display the error if sending fails
            error_log("Mail sending failed: " . $e->getMessage());
            return false;
        }
    }
}
