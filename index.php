<!DOCTYPE html>
<?php

$bdd = new PDO('mysql:localhost=8889;dbname=Camagru', 'root', 'root');

if(isset($_POST['inscription']))
{
  $pseudo = htmlspecialchars($_POST['pseudo']);
  $mail = htmlspecialchars($_POST['mail']);
  $mdp = sha1($_POST['mdp']);

  if (!empty($_POST['pseudo']) AND !empty($_POST['mail']) AND !empty($_POST['mdp']))
  {
    $pseudolength = strlen($pseudo);
    if ($pseudolength <= 255)
    {
      if (filter_var($mail, FILTER_VALIDATE_EMAIL))
      {
        $reqmail = $bdd->prepare("SELECT * FROM users WHERE email = ? ");
        $reqmail->execute(array($mail));
        $mailexists = $reqmail->rowCount();
        if ($mailexists == 0)
        {
          $insertuser = $bdd->prepare("INSERT INTO users(username, email, password) VALUES(?, ?, ?)");
          $insertuser->execute(array($pseudo, $mail, $mdp));
          $erreur = "Votre compte a bien été crée ! <a href=\"connexion.php\">Login</a>";
          header('Location: index.php');
        }
        else
        {
          $erreur = "Adresse mail déjà utilisée !";
        }
      }
    }
    else
    {
      $erreur = "Votre pseudo ne doit pas dépasser 255 caractères !";
    }
  }
  else
  {
    $erreur = "Tous les champs doivent être complétés !";
  }
}
?>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css" />
    <title>Camagru</title>
  </head>
  <body>
      <div id="register">
        <section id="formpage">
      <h1>Sign Up !</h1>
      <form method='POST' action="">
        <table align="center">
          <tr>
            <td>
              <input type="text" placeholder="Username" id="pseudo" name="pseudo" value="<?php if (isset($pseudo)) { echo $pseudo; } ?>" />
            </td>
          </tr>
          <tr>
            <td>
              <input type="email" placeholder="Email" id="mail" name="mail" value="<?php if (isset($mail)) { echo $mail; } ?>" />
            </td>
          </tr>
          <tr>
            <td>
              <input type="password" placeholder="Password" id="mdp" name="mdp" />
            </td>
          </tr>
        </table>
        <input type="submit" name="inscription" value="Je m'inscris !" id="submit" />
      </form>
      <?php
      if (isset($erreur))
      {
        echo '<font color="red">' .$erreur. "</font>";
      }
      ?>
    </section>
    </div>
  </body>
</html>
