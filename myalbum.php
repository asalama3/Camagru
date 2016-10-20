<?php
session_start();

include ('init.php');

// try
// {
//     $bdd = new PDO('mysql:localhost=8889;dbname=camagru', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
// }
// catch (Exception $e)
// {
//     die('Erreur: ' . $e->getMessage());
// }

if (!isset($_SESSION['id']))
{
header('Location: signin.php');
}
?>

<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="./myalbum.css" />
    <title> Camagru</title>
    <script type="text/javascript" src="./delete_image.js"></script>
  </head>
  <body>
    <header>
      <h1>C A M A G R U</h1>
        <ul class="topnav" id="myTopnav">
          <li><a href="" style="padding-top: 36px; pointer-events: none;
         cursor: default; "></a></li>
         <li><a href="signout.php">Sign Out</a></li>
         <li><a href="profil.php">My Profile</a></li>
         <li><a href="index.php">Gallery</a></li>
         <li class="icon">
          <a href="javascript:void(0);" onclick="menu()">&#9776;</a>
        </li>
      </ul>
    </header>
    <div class="pictures">
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
        if (!$user_image = $allimages->fetch())
        {
          echo "Your album is empty...";
          // echo "<div class=\"big\" />";
          // echo "</div>";
        }
        ?>
      </div>
    </div>

<?php  include ('footer.php'); ?>

  </body>
    <script type="text/javascript" src="./header.js"></script>
</html>
