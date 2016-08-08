<?php
ini_set('error_reporting', E_ALL);
 ini_set('display_errors', 1);


if(isset($_POST['mailform']))
{
$to = 'andreasalama2@gmail.com';
$subject = 'test';
$header='MIME-Version: 1.0' . "\r\n";
$header.='From:"andreasalama2@gmail.com"<andreasalama2@gmail.com>'. "\r\n";
$header.='Content-Type:text/html; charset="utf-8"'. "\r\n";
$header.='Content-Transfer-Encoding: 8bit';

$message='
<html>
<body>
<div>
J\'anvoye ce mail avec php.
</div>
</body>
</html>
';

if(mail($to, $subject, $message, $header))
{
  echo "envoye!";
}
else
{
    echo "echec";
  }

}
?>
<form method="POST" action="">
  <input type="submit" value="recevoir un mail" name="mailform"/>
</form>
