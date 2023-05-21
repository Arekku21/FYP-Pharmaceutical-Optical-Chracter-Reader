<?php

use PHPMailer\PHPMailer\PHPMailer; 
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class sendEmail {
        
    function send($code) {

        require 'PHPMailer/src/Exception.php';
        require 'PHPMailer/src/PHPMailer.php';
        require 'PHPMailer/src/SMTP.php';

        // create object of PHPMailer class with boolean parameter which sets/unsets exception.
        $mail = new PHPMailer(true);                              

        try {
            $mail->isSMTP(); // using SMTP protocol       
            $mail->Mailer = "smtp";                        
            $mail->Host = 'smtp.gmail.com'; // SMTP host as gmail 
            $mail->SMTPDebug  = 0;
            $mail->SMTPAuth = true;  // enable smtp authentication                             
            $mail->Username = 'cache5834@gmail.com';  // sender gmail host              
            $mail->Password = 'omaiqemnfoaxtzoj'; // sender gmail host password     
            $mail->SMTPSecure = "tls";
            $mail->Port = 587;   // port for SMTP     
            $mail->isHTML(true); 

            $to = $_POST['email'];
            $subject = "Email Verification";
            $message = 'Please click this button to verify your account: <a href=http://localhost/Pharmacy_Management_System/registration/verify.php?code='.$code.'>Verify</a>' ;
            $headers = "From: your-email@example.com";

            $mail->setFrom('your-email@example.com', 'Your Name');
            $mail->addAddress($to);

            $mail->Subject = $subject;
            $mail->Body    = $message;

            $mail->send();
          
            error_reporting(0);

            echo 'Message has been sent';

        } catch (Exception $e) { // handle error.
            echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }
        
    }
}

$sendMl = new sendEmail();

?>
