<?php
session_start();
print_r($_SESSION);
try
{
  $bdd = new PDO('mysql:localhost=8889;dbname=camagru', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch (Exception $e)
{
  die('Erreur: ' . $e->getMessage());
}
// ini_set('display_errors', 1);
// error_reporting(E_ALL);

if (isset($_SESSION['id']) AND $_SESSION['id'] > 0)
{
  $getid = intval($_SESSION['id']);
  $requser = $bdd->prepare('SELECT * FROM users WHERE id=?');
  $requser->execute(array($getid));
  $userinfo = $requser->fetch();
}
?>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="profil.css" />
    <title> Camagru</title>
  </head>
  <body>
    <header>
      <h1>Welcome <?php echo $userinfo['username']; ?></h1>
      <?php
      if (isset($_SESSION['id']) AND $userinfo['id'] == $_SESSION['id'])
      {
      ?>
      <a href="deconnexion.php"><img src="./images/logout2.png"></a>
      <?php
      }
      ?>
    </header>
    <h2>MY ALBUM</h2>
    <div id="video-box" style="position: relative; overflow: hidden; width: 400px; height: 320px; margin: 0;">
        <video id="video" width="400" height="320"></video>
    </div>
    <canvas id="canvas" width="400" height="320" style="display: none;"></canvas>
    <div id="stack" class="playground" style="background-color: darkgray;">
      <?php
        $allimages = $bdd->prepare("SELECT * FROM images WHERE user_id= ?");
        $allimages->execute(array($_SESSION['id']));
      $user_image = $allimages->fetch();
      while($user_image = $allimages->fetch())
      {
      echo "<img class=\"monstyle\" src=\"" . $user_image['name'] . "\" />";
      }
?>


    </div>
<!--    <div class="margin">-->

        <p id="filterButtons"></p>

        <button id="startButton">Start webcam</button>
        <button id="photoButton" name="submit">Take photo</button>
<!--    </div>-->
    <form id="r" method="POST" action="sendpic.php" name="upload" enctype="multipart/form-data" onchange="display_name(this)" onsubmit="return submitForm(this);">
      <input type="file" name="file_upload" id="file" class="inputfile"/>
      <label for="file" id="select">Choose file</label>
    <input type="submit" name="submit" value="Upload" id="choose"/>
    </form>
    <div id="message" ></div>
    <br>
<span id="effect">
  Choose an effect for your photo:
</span>
    <form method='POST' action="" />
          <input class="radio" type="radio" name="dog" id="./images/dog.png" onclick="ffilter()" /><label for ="dog"><img src="./images/dog.png" class="filt"></label>
          <input class="radio" type="radio" name="dog" id="./images/heart.png" onclick="ffilter()"/><label for ="heart"><img src="./images/heart.png" class="filt"></label>
          <input class="radio" type="radio" name="dog" id="./images/snake.png" onclick="ffilter()"/><label for ="snake"><img src="./images/snake.png" class="filt"></label>
          <input class="radio" type="radio" name="dog" id="./images/moustache.png" onclick="ffilter()"/><label for ="moustache"><img src="./images/moustache.png" class="filt"></label>
          <input class="radio" type="radio" name="dog" id="./images/panda.png" onclick="ffilter()"/><label for ="panda"><img src="./images/panda.png" class="filt"></label>
          <input class="radio" type="radio" name="dog" id="./images/masksmall.png" onclick="ffilter()"/><label for ="masksmall"><img src="./images/masksmall.png" class="filt"></label>
          <input class="radio" type="radio" name="dog" id="./images/ironman.png" onclick="ffilter()"/><label for ="ironman"><img src="./images/ironman.png" class="filt"></label>
          </form>
    <script type="text/javascript" src="./profil.js"></script>

  </body>
</html>
