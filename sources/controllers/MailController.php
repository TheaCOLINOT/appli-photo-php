<?php
 
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../core/Session.php';
require_once __DIR__ . '/../core/Router.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailController {

    public static function post() {
        $mail = new PHPMailer(true); 
        $host= getenv('MAIL_HOST');
        $username= getenv('MAIL_USERNAME');
        $password= getenv('MAIL_PASSWORD');
        $port= getenv('MAIL_PORT');
        $mailfromaddress= getenv('MAIL_FROM_ADDRESS');

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = trim($_POST['email']);
            
            // Vérifier si l'email existe
            $pdo = Database::getInstance();
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if ($user) {
                // Générer un token sécurisé
                $token = bin2hex(random_bytes(50));
                
                // Stocker le token en base
                $stmt = $pdo->prepare("UPDATE users SET reset_token = ? WHERE email = ?");
                $stmt->execute([$token, $email]);

                $base_url = Config::get('app.base_url');
                $reset_link = "{$base_url}/reset_password.php?token={$token}";
                $reset_link = "http://localhost/reset_password.php?token=$token";
                // Envoyer l'email avec PHPMailer
                $mail = new PHPMailer(true); // Passing `true` enables exceptions

                try {
                    // Server settings
                    $mail->isSMTP();
                    $mail->Host = $host; // Set the SMTP server to send through
                    $mail->SMTPAuth = true;
                    $mail->Username = $username; // SMTP username
                    $mail->Password = $password; // SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = $port;

                    // Recipients
                    $mail->setFrom($username, 'Mailer');
                    $mail->addAddress($email);

                    // Content
                    $mail->isHTML(true);
                    $mail->Subject = 'Password Reset';
                    $mail->Body    = "Cliquez sur ce lien pour réinitialiser votre mot de passe : <a href='$reset_link'>$reset_link</a>";
                    $mail->AltBody = "Cliquez sur ce lien pour réinitialiser votre mot de passe : $reset_link";

                    $mail->send();
                    echo 'Email de réinitialisation envoyé.';
                } catch (Exception $e) {
                    echo "Erreur lors de l'envoi de l'email. Mailer Error: {$mail->ErrorInfo}. Exception: {$e->getMessage()}";
                }
                echo "Lien de réinitialisation : <a href='$reset_link'>$reset_link</a>";

            } else {
                echo "Email non trouvé.";
            }
        }
    }

    public static function passwordResetEmail() {
        $mail = new PHPMailer(true); 
        $host="smtp.gmail.com";
        $username="mariam.bouhassoune40@gmail.com";
        $password="tokv hrqb vlqa bcyf";
        $port=587;
        $mailfromaddress= "mariam.bouhassoune40@gmail.com";

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = $host; // Set the SMTP server to send through
            $mail->SMTPAuth = true;
            $mail->Username = $username; // SMTP username
            $mail->Password = $password; // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = $port;
            $mail->SMTPDebug = 2; // Affiche les logs détaillés
            $mail->Debugoutput = 'html';
            
            // Display mail settings as array
            $mailSettings = [
                'Host' => $mail->Host,
                'SMTPAuth' => $mail->SMTPAuth,
                'Username' => $mail->Username,
                'Password' => "Lovecode$1", // Hidden for security
                'SMTPSecure' => $mail->SMTPSecure,
                'Port' => $mail->Port
            ];
            echo '<pre>';
            print_r($mailSettings);
            echo '</pre>';
            // Recipients
            $mail->setFrom($mailfromaddress, 'Mailer');
            $mail->addAddress($username , 'Recipient Name');

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Here is the subject';
            $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}. Exception: {$e->getMessage()}";
        }
    }
}