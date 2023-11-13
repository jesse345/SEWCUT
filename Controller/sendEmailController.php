<?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require '../vendor/autoload.php';

    function sendEmail($username,$email,$verification_code,$header){
        $mail = new PHPMailer(true);
        try {           
            //Enable verbose debug output
            $mail->SMTPDebug = 0;//SMTP::DEBUG_SERVER;
            
            //Send using SMTP
            $mail->isSMTP();
            
            //Set the SMTP server to send through
            $mail->Host = 'smtp.gmail.com';
            
            //Enable SMTP authentication
            $mail->SMTPAuth = true;
            
            //SMTP username
            $mail->Username = 'sewcut.web@gmail.com';
            
            //SMTP password
            $mail->Password = 'znmmwdlemkrxbqcb';
            
            //Enable TLS encryption;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

            //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
            $mail->Port = 587;

            //Recipients
            $mail->setFrom('sewcut.web@gmail.com', 'Sewcut Official');

            //Add a recipient
            $mail->addAddress("$email",  "$username");

            //Set email format to HTML
            $mail->isHTML(true);

            $mail->Subject = 'Email verification';
            $mail->Body    = '<p>Your verification code is: <b style="font-size: 30px;">' . $verification_code . '</b></p>';

            $mail->send();
            $header;
            exit();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
?>