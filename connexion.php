<?php
session_start();
try
{
  $bdd = new PDO('mysql:localhost=8889;dbname=Camagru', 'root', 'root');
}
catch (Exception $e)
{
  die('Erreur: ' . $e->getMessage());
}

if (isset($_POST['formconnect']))
{
  $mailconnect = htmlspecialchars($_POST['mailconnect']);
  $mdpconnect = sha1($_POST['mdpconnect']);
  if (!empty($mailconnect) AND !empty($mdpconnect))
  {
    $requser = $bdd->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
    $requser->execute(array($mailconnect, $mdpconnect));
    $userexists = $requser->rowCount();
    if ($userexists == 1)
    {
      $userinfo = $requser->fetch();
      $_SESSION['id'] = $userinfo['id'];
      $_SESSION['username'] = $userinfo['username'];
      $_SESSION['email'] = $userinfo['email'];
      header("Location: ./profil.php?id=".$_SESSION['id']);
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
        </table>
        <input type="submit" name="formconnect" value="Sign in" id="button"  />
      </form>
      <?php
      if (isset($erreur))
      {
        echo '<font color="red">' .$erreur. "</font>";
      }
      ?>
      <div class="forgotpasswd">
        <p>Forgot Password? <a href="./forgotyourpasswd.php">Click here to reset your password!</a></p>
      </div>
      <div class="member">
        <p> Not a member yet ? <a href="./index.php">Sign up !</a></p>
      </div>
  </section>
    </div>
    <footer>
    </footer>
  </body>
</html>



//echo '<a href="'.$file_path.$file_new_name.'"><img src="'.$file_path.$file_new_name.'"'.$style.'></a></br />';
///$style = "style='height:500px ; width: 500px'"; ?>
