<?php
?>

<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="header.css" />
    <title>Camagru</title>
    <script type="text/javascript" src="./header.js"></script>
</head>
<header>
    <h1>C A M A G R U</h1>
    <ul class="topnav" id="myTopnav">
        <li><a href="" style="padding-top: 36px; pointer-events: none;
       cursor: default; "></a></li>
       <?php if (isset($_SESSION['id'])){ ?>
        <li><a href="signout.php">Sign Out</a></li>
        <?php } ?>
        <?php if (!isset($_SESSION['id'])){ ?>
        <li><a href="signup.php">Sign Up</a></li>
        <li><a href="signin.php">Sign in</a></li>
        <?php } ?>
        <?php if (isset($_SESSION['id'])){ ?>
        <li><a href="profil.php">Shooting</a></li>
        <?php } ?>

        <!-- <li><a href="myalbum.php">My Album</a></li> -->
        <li class="icon">
          <a href="javascript:void(0);" onclick="menu()" style="height: 20px;">&#9776;</a>
        </li>
    </ul>
</header>
  <div class="clear" style="clear: both;"></div>
</html>
