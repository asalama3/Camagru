<?php
session_start();
//print_r($_SESSION);
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
      <script type="text/javascript" src="./delete_image.js"></script>
  </head>
  <body>
    <header>
        <?php
        if (isset($_SESSION['id']) && $_SESSION['id'] == true) {
            echo "<h1> Welcome, " . $_SESSION['username'] . "! </h1>";
        } else {
            echo "<a onload='alertlog();'>del </a>";
            exit;
        }
        ?>
        <ul>
            <li><a href="signout.php">Sign Out</a></li>
            <li><a href="myalbum.php">My Album</a></li>
        </ul>
    </header>
    <div class="left-col">
        <div class="camera">
            <div id="video-box" style="overflow: hidden; position: relative;">
                <video id="video" style="width: 100%"></video>
            </div>
            <canvas id="canvas" width="400" height="320" style="display: none;"></canvas>
        </div>
        <div class="up">
            <form id="r" method="POST" action="sendpic.php" name="upload" enctype="multipart/form-data" onchange="display_name(this)" onsubmit="return submitForm(this);">
                <input type="file" name="file_upload" id="file" class="inputfile"/>
                <label for="file" id="select">Choose file</label>
                <input type="submit" name="submit" value="Upload" id="choose"/>
            </form>
            <button id="photoButton" name="submit">Take photo</button>

        </div>
        <div id="message" ></div>
<!--        <div class="button_cam">-->
<!--            <button id="photoButton" name="submit">Take photo</button>-->
<!--        </div>-->

        <div class="filters">
            <ul>
                <?php $filters = array('dog', 'heart', 'snake', 'moustache', 'panda', 'masksmall', 'ironman');?>
                <?php foreach ($filters as $filter) :?>
                    <li>
                        <label  for="./images/<?=$filter?>.png" ><img src="./images/<?=$filter?>.png" id="./images/<?=$filter?>.png" ></label>
                        <!--                    <input class="radio" type="radio" name="dog" id="./images/--><?//=$filter?><!--.png"  />-->
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        </form>
            <div id="filterButtons">
                <span id="text">
                    Add a special effect?</span>
            </div>

    </div>
    <div class="right-col">
        <h2><p>Album...</p></h2>
        <div id="stack" class="playground">
            <?php
            $allimages = $bdd->prepare("SELECT * FROM images WHERE user_id= ?");
            $allimages->execute(array($_SESSION['id']));
            $user_image = $allimages->fetch();
            while($user_image = $allimages->fetch())
            {
                echo "<img src=\"" . $user_image['name'] . "\" onload='XXX(this, " . $user_image['id_image'] . ");' />";
            }
            ?>

        </div>
    </div>
  <div class="clear" style="clear: both;"></div>
    <?php  include ('footer.php'); ?>

  </body>
  <script type="text/javascript" src="./profil.js"></script>
</html>
