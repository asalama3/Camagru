<?php

$mail = new PHPMailer();

$mail->From     = "andreasalama2@gmail.com";
$mail->FromName = "Andrea Salama";
$mail->addReplyTo("andreasalama2@gmail.com", "Reply Address");
$mail->Subject  = "Subject Text";
$mail->Body     = "This is a sample basic text email using PHPMailer.";

if($mail->send()) {
    // Success! Redirect to a thank you page. Use the
    // POST/REDIRECT/GET pattern to prevent form resubmissions
    // when a user refreshes the page.

    header('Location: connexion.php', true, 303);
    exit;
}
else {
    echo "Mailer Error: " . $mail->ErrorInfo;
}
