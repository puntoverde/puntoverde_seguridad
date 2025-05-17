<?php

namespace App\Util;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class Mailer
{

    public static function  SendEmail($correo,$remitente,$asunto="No Asunto",$mensaje="No Mensaje",$files=[])
    {
        // Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_OFF;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.ionos.mx';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'notificaciones@puntoverdeleon.com.mx';                     // SMTP username
            $mail->Password   = 'noti-p.verde753';                               // SMTP password
            $mail->CharSet    = 'UTF-8';    // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            //Recipients
            $mail->setFrom('notificaciones@puntoverdeleon.com.mx', 'Clave Solicitud Ingreso');
            $mail->addAddress($correo, $remitente);     // Add a recipient


            // Content
            $mail->isHTML(false);                                  // Set email format to HTML
            $mail->Subject = $asunto;
            $mail->Body    = $mensaje;


            $envio = $mail->send();
            return $envio;
        } catch (Exception $e) {
            echo  "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            return false;
        }
    }

    public static function SendEmailHtml($correo,$remitente,$asunto="No Asunto",$template="default.html",$info=[],$files=[])
    {
        // Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //template
            $base_path=__DIR__."/../../storage/template_email";
            $message = file_get_contents($base_path.DIRECTORY_SEPARATOR.$template);
            foreach($info as $key=>$value){
                $message = str_replace('%'.$key.'%', $value, $message); 
                // $message = str_replace('%testusername%', $username, $message); 
            }

            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_OFF;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.ionos.mx';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'notificaciones@puntoverdeleon.com.mx';                     // SMTP username
            $mail->Password   = 'noti-p.verde753';                               // SMTP password
            $mail->CharSet    = 'UTF-8';    // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            //Recipients
            $mail->setFrom('notificaciones@puntoverdeleon.com.mx', 'Club Deportivo Punto Verde de León');
            $mail->addAddress($correo, $remitente);     // Add a recipient


            foreach($files as $key=>$value)
            {
                $extencion=pathinfo($value, PATHINFO_EXTENSION);
                // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
                // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
                $mail->addAttachment($base_path.DIRECTORY_SEPARATOR.$value,$key.".".$extencion);    //Optional name
            }


            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $asunto;
            // $mail->Body    = $mensaje;
            // $mail->Body=$message;
            //mensaje en html y el segundo partametro es el path esto sirve para meter imagenes en la etiqueta html
            $mail->msgHTML($message,__DIR__."/../../storage");


            $envio = $mail->send();
            return $envio;
        } catch (Exception $e) {
            echo  "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            return false;
        }
    }
}
