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

//var_dump($_POST);
//die;
$json = file_get_contents("php://input");
$json = str_replace('data:image/png;base64,', "", $json);
//$unencodedData = base64_decode($photo);

//$dest = imagecreatefromstring($unencodedData);

//$file = "./images/".$_POST['filter'].".png";
//$src = imagecreatefrompng($file);


//imagecopy($dest, $src, 152, 78, 0 , 560, 420);


//imagejpeg($dest);




$req = $bdd->prepare("INSERT INTO images(name, lien_image) VALUES(?, ?)");
$req->execute(array($json, "salut"));

 ?>
