<?php
require "connection.php";

require "mail/SMTP.php";
require "mail/PHPMailer.php";
require "mail/Exception.php";

use PHPMailer\PHPMailer\PHPMailer;

if (isset($_GET["e"])) {

    $email = $_GET["e"];

    $rs = Database::search("SELECT* FROM `user` WHERE `email`='" . $email . "'");
    $n = $rs->num_rows;

    if ($n == 1) {

        $code = uniqid();

        Database::iud("UPDATE `user` SET `verification_code`='" . $code . "' WHERE `email`='" . $email . "'");

        $mail = new PHPMailer;
        $mail->IsSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'kalindus2002@gmail.com';
        $mail->Password = 'jstb geqi uvqz lhof';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->setFrom('kalindus2002@gmail.com', 'Reset Password');
        $mail->addReplyTo('kalindus2002@gmail.com', 'Reset Password');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'MobileMarven Forgot Password Verification Code';
        $bodyContent = '<h2 style="color:black;font-family:monospace">Your verification code is ' . $code . '</h2>';
        $mail->Body    = $bodyContent;

        if (!$mail->send()) {
            echo ("Verification Code Sending Failed.");
        } else {
            echo ("success");
        }
    } else {
        echo ("Invalid Email Address.");
    }
} else {
    echo ("Please enter your Email Address First.");
}
