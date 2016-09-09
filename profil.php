<?php
session_start();
try
{
  $bdd = new PDO('mysql:localhost=8889;dbname=Camagru', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch (Exception $e)
{
  die('Erreur: ' . $e->getMessage());
}
// ini_set('display_errors', 1);
// error_reporting(E_ALL);

if (isset($_GET['id']) AND $_GET['id'] > 0)
{
  $getid = intval($_GET['id']);
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
      while($user_image = $allimages->fetch())
      {
      ?>
      <img src="<?php echo $user_image['lien_image'];?>" />
      <?php }

      // if (isset($_POST['img'])) {
        // $img = base64_decode(substr(explode(";",$_POST['img'])[1], 7));
// }

if (isset($_POST['img'])) {

            define('uploads/');
           $img = $_POST['img'];
           $img = str_replace('data:image/png;base64,', '', $img);
           $img = str_replace(' ', '+', $img);
           $data = base64_decode($img);
           $file = UPLOADS_ . uniqid() . '.png';
           $success = file_put_contents($file, $data);
           echo $file;
            print $success ? $file : 'Unable to save the file.';
}

      ?>
    </div>
    <div class="margin">
      <p>
        <div id="filterButtons"></div>
      </p>
        <button id="startButton">Start webcam</button>
        <button id="photoButton" name="submit">Take photo</button>
    </div>
    <form id="1" name="upload" method="post" action="sendpic.php" enctype="multipart/form-data">
      <input type="file" name="file_upload" id="file" class="inputfile" />
      <label for="file" id="select">Choose file</label>
    <input type="submit" name="submit2" value="Upload" id="choose" />
    </form>
    <?php echo $_GET['erreur']; ?>
<p id="effect">
  Choose an effect for your photo:
</p>
    <form method='POST' action="" />
          <input class="radio" type="radio" name="dog" id="dog" onclick="filter()" /><label for ="dog"><img src="./images/chien.png"></label>
          <input class="radio" type="radio" name="dog" id="heart" onclick="filter()"/><label for ="heart"><img src="./images/COEUR.png"></label>
          <input class="radio" type="radio" name="dog" id="snake" onclick="filter()"/><label for ="snake"><img src="./images/serpent.png"></label>
          <input class="radio" type="radio" name="dog" id="cadre" onclick="filter()"/><label for ="cadre"><img src="./images/cadre.png"></label>
          </form>

    <input type="radio" name="optionsRadios" value="option1" />
    <input type="radio" name="optionsRadios"  value="option2" />
    <script type="text/javascript" src="./profil.js"></script>
    <script>
      function handleClick(myRadio) {
        alert('New value: ' + myRadio.value);
      }
    </script>
  </body>
</html>
