<?php
session_start();

$bdd = new PDO('mysql:localhost=8889;dbname=Camagru', 'root', 'root');

if (isset($_GET['id']) AND $_GET['id'] > 0)
{
  $getid = intval($_GET['id']);
  $requser = $bdd->prepare('SELECT * FROM users WHERE id=?');
  $requser->execute(array($getid));
  $userinfo = $requser->fetch();
?>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="profil.css" />
    <title> Camagru</title>
  </head>
  <body>
    <header>
      <h1>Bonjour <?php echo $userinfo['username']; ?></h1>
      <?php
      if (isset($_SESSION['id']) AND $userinfo['id'] == $_SESSION['id'])
      {
      ?>
      <a href="deconnexion.php"> Logout</a>
      <?php
      }
      ?>
    </header>
    <section id="parent">
      <aside id="webcam">
      <form method='POST' action="" />
      <input type="checkbox" name="dog" id="dog" /><label for ="dog"><img src="./images/chien.jpg"></label>
      <input type="checkbox" name="heart" id="heart" /><label for ="heart"><img src="./images/COEUR.png"></label>
      <input type="checkbox" name="snake" id="snake" /><label for ="snake"><img src="./images/serpent.png"></label>
      <input type="checkbox" name="cadre" id="cadre" /><label for ="cadre"><img src="./images/cadre.png"></label>
      </form>
      </br></br></br>
      <video id="video"></video>
      <button id="startbutton">Prendre une photo</button>
      <canvas id="canvas"></canvas>
    </aside>
    <aside id="pictures">
      <p>  My pictures </p>
      </aside>
    </section>
    <script type="text/javascript" src="./profil.js"></script>
  </body>
</html>
<?php
}
?>
