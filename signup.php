<?php
try
{
  $bdd = new PDO('mysql:localhost=8889;dbname=Camagru', 'root', 'root');
}
catch (Exception $e)
{
  die('Erreur: ' . $e->getMessage());
}
error_reporting(-1);
ini_set('display_errors', 'On');
set_error_handler("var_dump");
if(isset($_POST['inscription']))
{
  $pseudo = htmlspecialchars($_POST['pseudo']);
  $mail = htmlspecialchars($_POST['mail']);
  $mdp = password_hash($_POST['mdp'], PASSWORD_BCRYPT);

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
          $keylength = 12;
          $key = "";
          for($i=1;$i<$keylength;$i++)
          {
            $key .= mt_rand(0, 9);
          }
          $insertuser = $bdd->prepare("INSERT INTO users(username, email, password, confirmkey) VALUES(?, ?, ?, ?)");
          $insertuser->execute(array($pseudo, $mail, $mdp, $key));

          $subject = 'Confirmation de compte';
          $header='MIME-Version: 1.0' . "\r\n";
          $header.='From:"andreasalama2@gmail.com"<andreasalama2@gmail.com>'. "\r\n";
          $header.='Content-Type:text/html; charset="utf-8"'. "\r\n";
          $header.='Content-Transfer-Encoding: 8bit';
          $message='
          <html>
            <body>
              <div align="center">
                <a href="http://'.$_SERVER["HTTP_HOST"].'/Camagru/confirmation.php?username='.urldecode($pseudo).'&key='.$key.'">Confirmez votre compte !</a>
              </div>
            </body>
          </html>
          ';

         mail($mail, $subject, $message, $header);

          $erreur = "Your account is now created! </br>
          Please confirm your account by clicking on the link sent to your email: .$mail.";
        }
        else
        {
          $erreur = "Email address already used!";
        }
      }
    }
    else
    {
      $erreur = "Your username can't be more than 255 characters !";
    }
  }
  else
  {
    $erreur = "Incomplete field! !";
  }
}
?>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="signup.css" />
    <title>Camagru</title>
  </head>
  <body>
  <header>
    <h1>CAMAGRU</h1>
    <ul>
      <li><a href="signin.php">Sign in</a></li>
    </ul>
  </header>
      <div id="register">
        <div id="formpage">
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
        <input type="submit" name="inscription" value="Sign up !" id="submit" />
      </form>
      <?php
      if (isset($erreur))
      {
        echo '<font color="red">' .$erreur. "</font>";
      }
      ?>
    </div>
    </div>
  <?php  include ('footer.php'); ?>

  </body>
</html>
