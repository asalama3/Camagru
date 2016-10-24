<?php
session_start();

include ('init.php');

error_reporting(-1);
ini_set('display_errors', 'On');
// set_error_handler("var_dump");

//  print_r($result);


if (isset($_POST['formconnect'])) {
  $mailconnect = base64_encode(htmlspecialchars($_POST['mailconnect']));
  $mdpconnect = $_POST['mdpconnect'];

  $confirm = $bdd->prepare('SELECT confirm FROM users WHERE email=?');
  $confirm->execute(array($mailconnect));
  $result = $confirm->fetch();


  $hash = $bdd->prepare("SELECT password FROM users WHERE email = ?");
  $hash->execute(array($mailconnect));
  $test = $hash->fetch();
  $hsh = $test[0];
  if (empty($mailconnect) || empty($mdpconnect))
  {
    $erreur = "Incomplete Fields";
  }
  if (password_verify($mdpconnect, $hsh)) {
    if ($result['confirm'])
    {
    if (!empty($mailconnect) AND !empty($mdpconnect)) {
      $requser = $bdd->prepare("SELECT * FROM users WHERE email = ?");
      $requser->execute(array($mailconnect));
      $userexists = $requser->rowCount();
      if ($userexists == 1) {
        $userinfo = $requser->fetch();
        $_SESSION['id'] = $userinfo['user_id'];
        $_SESSION['username'] = base64_decode($userinfo['username']);
        $_SESSION['email'] = base64_decode($userinfo['email']);
        header("Location: ./profil.php?user_id=" . $_SESSION['id']);
      }
    }
      else
        {
          $erreur = "Incomplete Fields";
        }
    }
    else
    {
      session_destroy();
      $erreur = "Your account was not validated";
    }
  }
  else
  {
    $erreur = "Invalid email or password";
  }
}

?>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="signin.css" />
    <title> Camagru</title>
  </head>
  <body>
    <header>
      <h1>C A M A G R U</h1>
        <ul>
          <li><a href="signup.php">Sign Up</a></li>
        </ul>
    </header>
    <div id="container">
        <form method='POST' action="">
          <img src="./images/polaroid_cam3.png"  />
          <table align="center">
            <tr>
              <td>
                  <input type="email" name="mailconnect" placeholder="Email" id="email" />
              </td>
            </tr>
            <tr>
              <td>
                <input type="password" name="mdpconnect" placeholder="Password" id="password" />
              </td>
            </tr>
            <tr>
              <td>
                <a href="./forgotyourpasswd.php" id="pass">Forgot Password?</a>
              </td>
            </tr>

        </table>

        <input type="submit" name="formconnect" value="Sign in" id="button"  />

        <?php

        if (isset($erreur))
        {
          // echo '<font color="red">' .$erreur. "</font>";
          echo "<p style='color:red;'>" .$erreur. "</p>";
        }
        ?>
      </form>
  </div>
    <?php  include ('footer.php'); ?>
  </body>
</html>
