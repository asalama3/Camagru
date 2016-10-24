<?php
session_start();

include ('init.php');

if (!isset($_SESSION['id']))
{
  header('Location: ./signin.php');
  return;
}


if (isset($_SESSION['id']) AND $_SESSION['id'] > 0)
{
  $getid = intval($_SESSION['id']);
  $requser = $bdd->prepare('SELECT * FROM users WHERE user_id=?');
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
        <?php echo "<h1> Welcome to Camagru, " . $_SESSION['username'] . "! </h1>"; ?>
        <ul class="topnav" id="myTopnav">
          <li><a href="" style="padding-top: 36px; pointer-events: none;
           cursor: default; "></a></li>
          <li><a href="delete_account.php" onclick="return confirm('Are you sure?')">Delete Account</a></li>
          <li><a href="signout.php">Sign Out</a></li>
          <li><a href="index.php">Gallery</a></li>
          <li class="icon">
            <a href="javascript:void(0);" onclick="menu()" style="height: 20px;">&#9776;</a>
          </li>
        </ul>
    </header>
    <div class="clear" style="clear: both;"></div>

    <div id="all">
        <div class="camera">
            <div id="video-box">
                <video id="video" style="width: 100%"></video>
            </div>
            <canvas id="canvas" width="400" height="320" style="display: none;"></canvas>
        </div>
        <div class="photo_buttons">
            <div id="loading">
              <form id="display_name" method="POST" action="sendpic.php" name="upload" enctype="multipart/form-data" onchange="display_name(this)" onsubmit="return submitForm(this);">
                <input type="file" name="file_upload" id="file" class="inputfile"/>
                <label for="file" id="select">Choose file</label>
                <input type="submit" name="submit" value="Upload" id="choose"/>
              </form>
            </div>
            <button id="photoButton" name="submit">Take photo</button>
            <div id="message" ></div>
        </div>
        <div id="centered">
        <div class="filters">
            <ul><?php $filters = array('dog', 'heart', 'Banana', 'yoshi', 'panda', 'objet', 'apple', 'Donkey_Kong' );?><?php foreach ($filters as $filter) :?><li>
                        <label  for="./images/<?=$filter?>.png" ><img src="./images/<?=$filter?>.png" id="./images/<?=$filter?>.png" ></label>
                    </li><?php endforeach; ?>
            </ul>
        </div>
      </div>
      <div id="color_filter">
          <div id="filterButtons">
            <span id="text">
              Wish to add a special effect?</span>
          </div>
        </div>
        <h2><p>S N A P S...</p></h2>
          <div id="stack" class="playground">
            <?php
            $allimages = $bdd->prepare("SELECT * FROM images WHERE user_id= ?");
            $allimages->execute(array($_SESSION['id']));
            $user_image = $allimages->fetch();
            while($user_image = $allimages->fetch())
            {
              echo "<div class=\"mini\">" ;
              echo "<img class=\"photo_style\" src=\"" . $user_image['name'] . "\" onload='XXX(this, " . $user_image['id_image'] . ");' />";
              echo "</div>";

            }
            ?>
        </div>
    <div class="clear" style="clear: both;"></div>
  </div>
    <?php  include ('footer.php'); ?>
</body>
  <script type="text/javascript" src="./profil.js"></script>
  <script type="text/javascript" src="./header.js"></script>
</html>
