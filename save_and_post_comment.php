<?php
session_start();
try {
    $bdd = new PDO('mysql:localhost=8889;dbname=camagru', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch (Exception $e)
{
    die('Erreur: ' . $e->getMessage());
}

if (isset($_SESSION['id']) AND $_SESSION['id'] > 0 )
{
  $add_comment = $bdd->prepare('INSERT INTO comments(user_id, id_image, content) VALUES(?, ?, ?) ');
  $add_comment->execute(array($_SESSION['id'], intval($_POST['id']), htmlspecialchars($_POST['comment']) ));
}

echo(htmlspecialchars($_POST['comment']));

$req_owner_image = $bdd->prepare('SELECT user_id, email FROM comments, users WHERE comments.user_id = users.id');
$req_owner_image->execute();
$owner_img = $req_owner_image->fetch();

$mail = $owner_img['email'];
$subject = 'New Comment';
$header='MIME-Version: 1.0' . "\r\n";
$header.='From:"andreasalama2@gmail.com"<andreasalama2@gmail.com>'. "\r\n";
$header.='Content-Type:text/html; charset="utf-8"'. "\r\n";
$header.='Content-Transfer-Encoding: 8bit';
$message='
<html>
  <body>
    <div align="center">
      <p>Vous avez recu un nouveau commentaire sur la photo : id number...+ content of commentaire </p>
    </div>
  </body>
</html>
';

mail($mail, $subject, $message, $header);
 ?>
