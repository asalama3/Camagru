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
    <video id="video"></video>
    <video id="video" width="320" height="240"></video>
    <canvas id="canvas" width="320" height="240" style="display: none;"></canvas>
    <div id="stack" class="playground" style="background-color: darkgray;">
      <?php
        $allimages = $bdd->prepare("SELECT * FROM images WHERE user_id= ?");
        $allimages->execute(array($_SESSION['id']));
      $user_image = $allimages->fetch();
      while($user_image = $allimages->fetch())
      {
        echo "<img src=\"" . $user_image['name'] . "\" />";
        // ajouter style css a l'image final //
      }



//if (isset($_POST['img'])) {
//
//            define('uploads/');
//           $img = $_POST['img'];
//           $img = str_replace('data:image/png;base64,', '', $img);
//           $img = str_replace(' ', '+', $img);
//           $data = base64_decode($img);
//           $file = UPLOADS_ . uniqid() . '.png';
//           $success = file_put_contents($file, $data);
//           echo $file;
//            print $success ? $file : 'Unable to save the file.';
//}
//
//      ?>
    </div>
    <div class="margin">
      <p>
        <div id="filterButtons"></div>
      </p>
        <button id="startButton">Start webcam</button>
        <button id="photoButton" name="submit">Take photo</button>
    </div>
    <form id="1" method="POST" action="sendpic.php" name="upload" enctype="multipart/form-data" onchange="display_name(this)" onsubmit="return submitForm(this);">
      <input type="file" name="file_upload" id="file" class="inputfile"/>
      <label for="file" id="select">Choose file</label>
    <input type="submit" name="submit" value="Upload" id="choose"/>
    </form>
    <div id="message" ></div>
<p id="effect">
  Choose an effect for your photo:
</p>
    <form method='POST' action="" />
          <input class="radio" type="radio" name="dog" id="dog" onclick="ffilter()" /><label for ="dog"><img src="./images/dog.png"></label>
          <input class="radio" type="radio" name="dog" id="heart" onclick="ffilter()"/><label for ="heart"><img src="./images/heart.png"></label>
          <input class="radio" type="radio" name="dog" id="snake" onclick="ffilter()"/><label for ="snake"><img src="./images/snake.png"></label>
          <input class="radio" type="radio" name="dog" id="meme" onclick="ffilter()"/><label for ="meme"><img src="./images/meme.png"></label>
          <input class="radio" type="radio" name="dog" id="moustache" onclick="ffilter()"/><label for ="moustache"><img src="./images/moustache.png"></label>
          <input class="radio" type="radio" name="dog" id="panda" onclick="ffilter()"/><label for ="panda"><img src="./images/panda.png"></label>
          <input class="radio" type="radio" name="dog" id="masksmall" onclick="ffilter()"/><label for ="masksmall"><img src="./images/masksmall.png"></label>
          <input class="radio" type="radio" name="dog" id="ironman" onclick="ffilter()"/><label for ="ironman"><img src="./images/ironman.png"></label>

          </form>

    <script type="text/javascript" src="./profil.js"></script>

  </body>
</html>
