<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/autoload.php';

class MailService
{

    public static function sendPasswordResetEmail($email, $token)
    {
        $mail = new PHPMailer(true);

        try {
            $host = "smtp.gmail.com";
            $username = "mariam.bouhassoune40@gmail.com";
            $password = "tokv hrqb vlqa bcyf";
            $port = 587;
            $mailfromaddress = "mariam.bouhassoune40@gmail.com";

            $resetLink = "http://localhost/reset-password?token=" . urlencode($token);
            // Configuration SMTP
            $mail->isSMTP();
            $mail->Host = $host;
            $mail->SMTPAuth = true;
            $mail->Username = $username;
            $mail->Password = $password;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = $port;

            // Destinataire
            $mail->setFrom($mailfromaddress, 'Support');
            $mail->addAddress($email);

            // Contenu
            $mail->isHTML(true);
            $mail->Subject = 'Changement de votre mot de passe';
            $mail->Body = "Cliquez sur ce lien pour réinitialiser votre mot de passe : <a href='$resetLink'>$resetLink</a>";
            $mail->AltBody = "Copiez et collez ce lien dans votre navigateur : $resetLink";
            $mail->send();
        } catch (Exception $e) {
            error_log("Erreur d'envoi d'email : " . $mail->ErrorInfo);
        }
    }
}
