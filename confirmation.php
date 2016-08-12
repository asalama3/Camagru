<?php
try
{
  $bdd = new PDO('mysql:localhost=8889;dbname=Camagru', 'root', 'root');
}
catch (Exception $e)
{
  die('Erreur: ' . $e->getMessage());
}

if (isset($_GET['username']) && isset($_GET['key']) && !empty($_GET['username']) && !empty($_GET['key']))
{

  $pseudo = htmlspecialchars(urldecode($_GET['username']));
  $key = intval($_GET['key']);

  $requser = $bdd->prepare("SELECT * FROM users WHERE username=? AND confirmkey = ?");
  $requser->execute(array($pseudo, $key));
  $userexists = $requser->rowCount();

  if ($userexists == 1)
  {
    $user = $requser->fetch();
    if ($user['confirm'] == 0)
    {
      $updateuser = $bdd->prepare("UPDATE users SET confirm = 1 WHERE username= ? AND confirmkey = ?");
      $updateuser->execute(array($pseudo, $key)); ?>
      <div class = "confirm">
       Votre compte a bien été confirmé !
      <a href="connexion.php">Login</a>
      </div>
      <?php
    }
    else
    {?>
      <div class = "confirm">
       Votre compte a déjà été confirmé !
      <a href="connexion.php">Login</a>
    </div>
      <?php
    }
  }
  else
  {
    echo "L'utilisateur n'existe pas!";
  }
}
 ?>
<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="confirmation.css" />
    </style>
    <meta charset="utf-8">
    <title>Confirmation de compte</title>
  </head>
  <body>

  </body>
</html>
