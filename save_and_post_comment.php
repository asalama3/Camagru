<?php
session_start();

include ('init.php');


// try {
//     $bdd = new PDO('mysql:localhost=8889;dbname=camagru', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
// }
// catch (Exception $e)
// {
//     die('Erreur: ' . $e->getMessage());
// }

if (isset($_SESSION['id']) AND $_SESSION['id'] > 0 )
{
  $add_comment = $bdd->prepare('INSERT INTO comments(user_id, id_image, content) VALUES(?, ?, ?) ');
  $add_comment->execute(array($_SESSION['id'], intval($_POST['id']), htmlspecialchars($_POST['comment']) ));
}

// SELECT images.user_id FROM `images` INNER JOIN `comments` ON images.id_image=comments.id_image


$get_userid = $bdd->prepare('SELECT user_id FROM `comments` WHERE id_image=?;');
$get_userid->execute(array(intval($_POST['id'])));
while ($ret = $get_userid->fetch())
{
  $id = $ret['user_id'];
}
$get_username = $bdd->prepare('SELECT username from users WHERE user_id=? ');
$get_username->execute(array($id));
while ($username = $get_username->fetch())
{
  $final_username=base64_decode($username['username']);
}

$get_nbr_comments = $bdd->prepare("SELECT COUNT(*) AS 'com' FROM comments WHERE id_image=?");
$get_nbr_comments->execute(array(intval($_POST['id]'])));
  if($result = $get_nbr_comments->fetch())
  {
    $nbr = intval($result['com']);
  }


$data = [];
$data['nbr_comments'] = $nbr;
$data['username'] = $final_username;
$data['comment'] = $_POST['comment'];
$json = json_encode($data);

echo $json;

// echo back in json => ALL GOOD WITH JS
// json_encode()
// en JS : response['username']
// {"username" : $username, "comment" : }

$owner_id = $bdd->prepare('SELECT user_id FROM `images` WHERE id_image=?');
$owner_id->execute(array(intval($_POST['id'])));
if ($owner = $owner_id->fetch())
{
    $owner_set_id= $owner['user_id'];
}

$get_owner_email = $bdd->prepare('SELECT email from users WHERE user_id=?');
$get_owner_email->execute(array($owner_set_id));
if ($owner_info = $get_owner_email->fetch())
{
    $owner_set_email=$owner_info['email'];
}

// $req_owner_image = $bdd->prepare('SELECT user_id, email FROM images, users WHERE images.user_id = users.user_id');
// $req_owner_image->execute();
// $owner_img = $req_owner_image->fetch();

$mail = $owner_set_email;
$subject = 'New Comment';
$header='MIME-Version: 1.0' . "\r\n";
$header.='From:"andrea salama"<andreasalama2@gmail.com>'. "\r\n";
$header.='Content-Type:text/html; charset="utf-8"'. "\r\n";
$header.='Content-Transfer-Encoding: 8bit';
$message='
<html>
  <body>
    <div align="center">
      <p>Vous avez recu un nouveau commentaire sur une de vos photos </p>
    </div>
  </body>
</html>
';
mail($mail, $subject, $message, $header);
 ?>
