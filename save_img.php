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

//var_dump($_POST);
die;
$photo = file_get_contents("php://input");
$photo = str_replace('data:image/png;base64', "", $photo);
$unencodedData = base64_decode($photo);

$dest = imagecreatefromstring($unencodedData);

$file = "./images/".$_POST['filter'].".png";
$src = imagecreatefrompng($file);


imagecopy($dest, $src, 152, 78, 0 , 560, 420);


imagejpeg($dest);


//if ($_GET['filter'] == 'dog')
//{
//    imagecopy();
//}
//else if ($_GET['filter'] == 'heart')
//{
//    imagecopy();
//}
//else if ($_GET['filter'] == 'cadre')
//{
//    imagecopy();
//}

// merge filtres, trouver un moyen sans get les filtres //
// save filters dans database et les recup en requet sql //
    //$photo_insert = $bdd->prepare("SELECT * FROM filters WHERE ... ")



$photo = $bdd->prepare("INSERT INTO images(name, lien_image) VALUES(?, ?)");
$photo->execute(array($json, "salut"));

 ?>
