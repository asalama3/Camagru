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

if (isset($_GET['section']))
{
  $section = htmlspecialchars($_GET['section']);
}
else {
  $section = "";
}

if (isset($_POST['recup_submit'], $_POST['recup_mail']))
{
  if (!empty($_POST['recup_mail']))
  {
    $recup_mail = htmlspecialchars($_POST['recup_mail']);
    if (filter_var($recup_mail, FILTER_VALIDATE_EMAIL))
    {
      $mailexists = $bdd->prepare('SELECT id, username FROM users WHERE email = ?');
      $mailexists->execute(array($recup_mail));
      $mailexists_count = $mailexists->rowCount();
      if ($mailexists_count == 1)
      {
        $pseudo = $mailexists->fetch();
        $pseudo = $pseudo['username'];
        $_SESSION['recup_mail'] = $recup_mail;
        $recup_code = "";
        for ($i=0; $i < 8 ; $i++)
        {
          $recup_code .= mt_rand(0,9);
        }

        $mail_recup_exists = $bdd->prepare('SELECT id FROM forgotpasswd WHERE email = ?');
        $mail_recup_exists->execute(array($recup_mail));
        $mail_recup_exists = $mail_recup_exists->rowCount();
        if ($mail_recup_exists == 1)
        {
          $recup_insert = $bdd->prepare('UPDATE forgotpasswd SET code = ? WHERE email = ?');
          $recup_insert->execute(array($recup_code, $recup_mail));
        }
        else
        {
          $recup_insert = $bdd->prepare('INSERT INTO forgotpasswd(email, code) VALUES (?,?)');
          $recup_insert->execute(array($recup_mail, $recup_code));
        }
        $subject = 'Récupération de Mot de Passe';
        $header= 'MIME-Version: 1.0' . "\r\n";
        $header.='From:"andreasalama2@gmail.com"<andreasalama2@gmail.com>'. "\r\n";
        $header.='Content-Type:text/html; charset="utf-8"'. "\r\n";
        $header.='Content-Transfer-Encoding: 8bit';
        $message='
        <html>
        <head>
          <title>Récuperation de mot de passe </title>
          <meta charset="utf-8" />
        </head>
            <body>
              <div align="center">
                Bonjour '.$pseudo.',
                Voici votre code de récupération: <b>'.$recup_code.'</b><br />
                Cliquez <a href="http://localhost:8888/Camagru/forgotyourpasswd.php?section=code" >ici</a> pour réinitialiser votre mot de passe.
            </div>
          </body>
        </html>
        ';
        mail($recup_mail, $subject, $message, $header);
        header("Location:http://localhost:8888/Camagru/forgotyourpasswd.php?section=code");
      }
      else
      {
        $erreur = "Cette adresse mail n'est pas enregistree";
      }
    }
    else
    {
      $erreur = "adresse mail invalide";
    }
  }
  else
  {
    $erreur = "Veuillez entrer votre adresse mail.";
  }
}

if (isset($_POST['check_submit'], $_POST['check_code']))
{
    if (!empty($_POST['check_code']))
  {
    $check_code = htmlspecialchars($_POST['check_code']);
    $check_req = $bdd->prepare('SELECT id FROM forgotpasswd WHERE email = ? AND code = ?');
    $check_req->execute(array($_SESSION['recup_mail'], $check_code));
    $check_req = $check_req->rowCount();
    if ($check_req == 1){
      $up_req = $bdd->prepare('UPDATE forgotpasswd SET confirm = 1 WHERE email = ?');
      $up_req->execute(array($_SESSION['recup_mail']));
      header("Location: http://localhost:8888/Camagru/forgotyourpasswd.php?section=changepasswd");
    }
    else {
      $erreur = "Code invalide";
    }
  }
  else {
    $erreur = "Veuillez entrer votre code de confirmation";
  }
}

if (isset($_POST['change_submit']))
{
  if (isset($_POST['change_passwd'], $_POST['change_passwdc']))
  {
    $check_confirm = $bdd->prepare('SELECT confirm FROM forgotpasswd WHERE email = ?');
    $check_confirm->execute(array($_SESSION['recup_mail']));
    $check_confirm = $check_confirm->fetch();
    $check_confirm = $check_confirm['confirm'];
    if ($check_confirm == 1)
    {
      $passwd = htmlspecialchars($_POST['change_passwd']);
      $passwdc = htmlspecialchars($_POST['change_passwdc']);
      if (!empty($passwd) AND !empty($passwdc))
      {
        if ($passwd == $passwdc)
        {
          $passwd = sha1($passwd);
          $insert_passwd = $bdd->prepare('UPDATE users SET password = ? WHERE email = ?');
          $insert_passwd->execute(array($passwd, $_SESSION['recup_mail']));
          $del_req = $bdd->prepare('DELETE FROM forgotpasswd WHERE email = ?');
          $del_req->execute(array($_SESSION['recup_mail']));
          header("Location: http://localhost:8888/Camagru/connexion.php");
        }
        else {
          $erreur = "Vos mots de passes ne correspondent pas";
        }
      }
      else {
        $erreur = "Veuillez remplir tous les champs";
      }
    }
    else {
      $erreur = "Veuillez valider votre mail grace au code de verification qui vous a ete envoye par mail";
    }
  }
  else{
    $erreur = "Veuillez remplir tous les champs";
  }
}
 ?>
 <!DOCTYPE html>
 <html>
   <head>
     <link rel="stylesheet" href="forgotyourpasswd.css" />
     <meta charset="utf-8">
     <title>Forgot your Password</title>
   </head>
   <body>
     <h2 align ="center">Récupération de Votre Mot de Passe</h2>
     <div align="center">
     <?php if ($section == 'code'){ ?>
       <h4>Un code de vérification vous a été envoyé par mail:</h4>
       <form class="forgot_passwd" action="" method="post">
         <input type="text" name="check_code" placeholder="Code de vérification" class="change"></br></br>
         <input type="submit" name="check_submit" value="Valider" class="button">
       </form>
       <?php } elseif ($section == "changepasswd") { ?>
         <h4>Nouveau Mot de Passe :</h4>
         <form class="forgot_passwd" action="" method="post">
           <input type="password" name="change_passwd" placeholder="Nouveau Mot De Passe" class="change"></br>
           <input type="password" name="change_passwdc" placeholder="Confirmation du Nouveau Mot de Passe" class="change"></br></br>
           <input type="submit" name="change_submit" value="Valider" class="button">
         </form>
       <?php } else {?>
       <form class="forgot_passwd" action="" method="post">
         <input type="email" name="recup_mail" placeholder="Email" class="change"></br></br>
         <input type="submit" name="recup_submit" value="Valider" class="button">
       </form>
       <?php } ?>
       <?php
       if (isset($erreur))
       {
         echo $erreur;
       }
       else
       {
         echo "<br />";
       }
        ?>
     </div>
   </body>
 </html>
