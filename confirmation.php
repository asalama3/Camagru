<?php

include ('init.php');

// try
// {
//   $bdd = new PDO('mysql:localhost=8889;dbname=Camagru', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
// }
// catch (Exception $e)
// {
//   die('Erreur: ' . $e->getMessage());
// }

if (isset($_GET['username']) && isset($_GET['key']) && !empty($_GET['username']) && !empty($_GET['key']))
{

  $pseudo = htmlspecialchars(urldecode($_GET['username']));
  $key = $_GET['key'];

  $requser = $bdd->prepare("SELECT * FROM users WHERE username=? AND confirmkey = ?");
  $requser->execute(array($pseudo, $key));
  $userexists = $requser->rowCount();
  if ($userexists == 1)
  {
    $user = $requser->fetch();
    if ($user['confirm'] == 0)
    {
      $updateuser = $bdd->prepare("UPDATE users SET confirm = 1 WHERE username= ? AND confirmkey = ?");
      $updateuser->execute(array($pseudo, $key));
      $message = 'Your account is now created!';
    }
    else
    {
      $message = "Your account has already been created!";
    }
  }
  else
  {
    echo "User doesn't exist!";
  }
}
 ?>
<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="confirmation.css" />
    <meta charset="utf-8">
    <title>Confirmation de compte</title>
  </head>
  <body>
    <header>
      <h1>C A M A G R U</h1>
    </header>
    <div class="confirm">
      <p> <?php echo $message; ?> </p>
      <a href="signin.php">Login</a>
    </div>
      <?php  include ('footer.php'); ?>
  </body>
</html>
