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

 ?>
