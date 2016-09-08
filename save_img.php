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

$json = file_get_contents("php://input");
$json = str_replace('data:image/png;base64', "", $json);
$unencodedData = base64_decode($json);

$dest = imagecreatefromstring($unencodedData);

$file = "images/filters/".$_GET['filter'].".png";

if ($_GET['filter'] == 'dog')
{
    imagecopy();
}
else if ($_GET['filter'] == 'heart')
{
    imagecopy();
}
else if ($_GET['filter'] == 'cadre')
{
    imagecopy();
}
else
    imagecopy();

// merge filtres, trouver un moyen sans get les filtres //




$photo = $bdd->prepare("INSERT INTO images(name, lien_image) VALUES(?, ?)");
$photo->execute(array($json, "salut"));

 ?>
