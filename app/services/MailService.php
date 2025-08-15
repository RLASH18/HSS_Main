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

            // Auto-embed local images
            $body = self::embedLocalImages($mail, $body);

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

    /**
     * Scans the email body for <img> tags with local file paths
     * and embeds them into the email as inline images using CID.
     * External HTTP(S) images are ignored.
     * 
     * @param          PHPMailer $mail The PHPMailer instance to attach images to
     * @param string   $body The HTML body containing image references
     * 
     * @return string  The modified HTML body with CID-based image sources
     */
    private static function embedLocalImages(PHPMailer $mail, string $body): string
    {
        return preg_replace_callback(
            '/<img\s+[^>]*src=["\']([^"\']+)["\']/i',

            function ($matches) use ($mail) {
                $src = $matches[1];
                // Skip external images
                if (preg_match('/^https?:\/\//i', $src)) {
                    return $matches[0];
                }

                // Embed local image and replace src with CID
                $path = Application::$ROOT_DIR . '/' . ltrim($src, '/');
                if (file_exists($path)) {
                    $cid = uniqid('img_');
                    $mail->addEmbeddedImage($path, $cid);
                    return str_replace($src, "cid:$cid", $matches[0]);
                }
                return $matches[0];
            },
            $body
        );
    }
}
