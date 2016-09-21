<?php
session_start();
try
{
    $bdd = new PDO('mysql:localhost=8889;dbname=camagru', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch (Exception $e)
{
    die('Erreur: ' . $e->getMessage());
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
    <h1>ALBUM</h1>
    <?php
    if (isset($_SESSION['id']) AND $userinfo['id'] == $_SESSION['id'])
    ?>
    <ul>
        <li><a href="deconnexion.php">Sign Out</a></li>
        <li><a href="profil.php">Mon Profil</a></li>
    </ul>
</header>
<div class="pictures">
    <h2><p>Album...</p></h2>
    <div id="stackbis" class="playground">
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
</body>
</html>
