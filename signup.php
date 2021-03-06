<?php

include ('init.php');


$array = explode("/", __DIR__);
$repo = $array[5];


if(isset($_POST['inscription']))
{
  $pseudo = base64_encode(htmlspecialchars($_POST['pseudo']));
  $mail = base64_encode(htmlspecialchars($_POST['mail']));


  $password_check = preg_match('/^\S*(?=\S{8,})(?=\S*[\d])\S*$/', $_POST['mdp']);

  if (!$password_check)
  {
    $erreur = "Your password must contain at least one number or must be at least 8 characters";
  }
else{

  $mdp = password_hash($_POST['mdp'], PASSWORD_BCRYPT);

  if (!empty($_POST['pseudo']) AND !empty($_POST['mail']) AND !empty($_POST['mdp']))
  {
    $pseudolength = strlen($pseudo);
    if ($pseudolength <= 255)
    {
      if (filter_var(base64_decode($mail), FILTER_VALIDATE_EMAIL))
      {
        $reqmail = $bdd->prepare("SELECT * FROM users WHERE email = ? ");
        $reqmail->execute(array($mail));
        $mailexists = $reqmail->rowCount();
        if ($mailexists == 0)
        {
          $requsername = $bdd->prepare("SELECT * FROM users WHERE username = ? ");
          $requsername->execute(array($pseudo));
          $usernameexists = $requsername->rowCount();
          if ($usernameexists == 0)
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
                <a href="http://'.$_SERVER["HTTP_HOST"].'/'.$repo.'/confirmation.php?username='.urldecode($pseudo).'&key='.$key.'">Confirmez votre compte !</a>
              </div>
            </body>
          </html>
          ';
          $decode_email = base64_decode($mail);
          mail($decode_email, $subject, $message, $header);

          $ok = "Your account is now created! </br>
          Please confirm your account by clicking on the link sent to your email: $decode_email";
        }else {
          $erreur = "Username already used!";
        }
        }
        else
        {
          $erreur = "Email address already used!";
        }
      }
      else{
        $erreur = "Invalid email";
      }
    }
    else
    {
      $erreur = "Your username can't be more than 192 characters !";
    }
  }
  else
  {
    $erreur = "Incomplete field!";
  }
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
    <h1><a href="index.php">C A M A G R U</a></h1>
    <ul>
<?php
?>
      <li><a href="signin.php">Sign in</a></li>
    </ul>
  </header>
      <div id="register">
        <div id="formpage">
      <form method='POST' action="">
        <img src="./images/sign_up.png"  />
        <table align="center">
          <tr>
            <td>
              <input type="text" placeholder="Username" id="pseudo" name="pseudo" value="<?php if (isset($pseudo)) { echo base64_decode($pseudo); } ?>" />
            </td>
          </tr>
          <tr>
            <td>
              <input type="email" placeholder="Email" id="mail" name="mail" value="<?php if (isset($mail)) { echo base64_decode($mail); } ?>" />
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
      if (isset($ok))
      {
        echo '<font color="green">' .$ok. "</font>";
      }
      ?>
    </div>
    </div>
  <?php  include ('footer.php'); ?>

  </body>
</html>
