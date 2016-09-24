<?php
   require_once 'Mail.php';
   function send_mail($recipient,$subject,$body){

          $host = "andreasalama2@gmail.com";
          $username = "andreasalama2@gmail.com";
          $password = "password";
          $port = 25;

          $headers = array ('From' => "Your agent <andreasalama2@gmail.com>",
            'To' => $recipient,
            'Subject' => $subject
          );

          $smtp = Mail::factory(
           'smtp',
            array ('host' => $host,
              'auth' => true,
              'port' => $port,
              'username' => $username,
              'password' => $password)
          );
          $smtp->send($recipient, $headers, $body);
     }
  ?>
