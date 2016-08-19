<?php
// Création des instances d'image
$dest = imagecreatefrompng('./images/cadre.png');
$src = imagecreatefromjpeg('./images/chien.jpg');

// Copie et fusionne
imagecopymerge($dest, $src, 40, 40, 50, 30, 200, 270, 75);

// Affichage et libération de la mémoire
header('Content-Type: image/png');
imagegif($dest);

imagedestroy($dest);
imagedestroy($src);
?>
