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
$json = preg_replace("/&filter=.*/", "", $json);
$unencodedData = base64_decode($json);

$dest = imagecreatefromstring($unencodedData);

// $file = imagecreate(100, 100);
$file = "./images/".$_POST['filter'].".png";
$ff = imagecreatefrompng($file);
$src = resize_imagepng($ff, 200, 200);
imagepng($src, $src);
// $image_info = getimagesize($ff);

imagecopy($dest, $src, 140, 30, 0, 0, 560, 420);

// grace a echo on envoie une reponse a l'ajaax, ma photo finale
// ob sert a convertir mon image en string pour ensuite la reconvertir en base64 pour l'envoyer a ajax et la save
// dans database.

ob_start();
imagepng($dest);
$contents =  ob_get_contents();
ob_end_clean();
echo 'data:image/png;base64,' . base64_encode($contents);

$req = $bdd->prepare("INSERT INTO images(name, lien_image, user_id) VALUES(?, ?, ?)");
$req->execute(array('data:image/png;base64,' . base64_encode($contents), "salut", $_SESSION['id']));

 ?>
