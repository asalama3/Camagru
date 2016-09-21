<?php
session_start();
try
{
  $bdd = new PDO('mysql:localhost=8889;dbname=camagru', 'root', 'root');
}
catch (Exception $e)
{
  die('Erreur: ' . $e->getMessage());
}



if (isset($_POST['formconnect'])) {
  $mailconnect = htmlspecialchars($_POST['mailconnect']);
  $mdpconnect = $_POST['mdpconnect'];

  $hash = $bdd->prepare("SELECT password FROM users WHERE email = ?");
  $hash->execute(array($mailconnect));
  $test = $hash->fetch();
  $hsh = $test[0];
  if (password_verify($mdpconnect, $hsh)) {


    if (!empty($mailconnect) AND !empty($mdpconnect)) {
      $requser = $bdd->prepare("SELECT * FROM users WHERE email = ?");
      $requser->execute(array($mailconnect));
      $userexists = $requser->rowCount();
      if ($userexists == 1) {
        $userinfo = $requser->fetch();
        $_SESSION['id'] = $userinfo['id'];
        $_SESSION['username'] = $userinfo['username'];
        $_SESSION['email'] = $userinfo['email'];
        header("Location: ./profil.php?id=" . $_SESSION['id']);
      }
    }
      else
        {
          $erreur = "Mauvais email ou mot de passe";
        }
    }
  else
  {
    $erreur = "Tous les champs doivent etre completes !";
  }
}
?>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="connexion.css" />
    <title> Camagru</title>
  </head>
  <body>
  <header>

    <h1>CAMAGRU</h1>
    <ul>
      <li><a href="signup.php">Sign Up</a></li>
<!--      <li><a href="connexion.php">Sign in</a></li>-->
    </ul>

  </header>

    <div id="picture">
      <section id="formpage">
        <img src="./images/polaroid_cam3.png"  />
        <form method='POST' action="">
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
      </form>
      <?php
      if (isset($erreur))
      {
        echo '<font color="red">' .$erreur. "</font>";
      }
      ?>
<!--      <div class="forgotpasswd">-->
<!--        <p>Forgot Password? <a href="./forgotyourpasswd.php">Click here to reset your password!</a></p>-->
<!--      </div>-->
<!--      <div class="member">-->
<!--        <p> Not a member yet ? <a href="signup.php">Sign up !</a></p>-->
<!--      </div>-->
  </section>
    </div>
    <footer>
    </footer>
  </body>
</html>
