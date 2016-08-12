<?php
error_reporting(-1);
ini_set('display_errors', 'On');
set_error_handler("var_dump");


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
test php.
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
