<?php
// FILTERS ON UPLOADS // GUIDE
// sendpic.php: change to imagecreatefromstring
// je recois une chaine de caracteres de donnees. verifier la taille first and then si ok imagecreatefromstring
// apply filtre (appeler save_img.php) change html
// save to database en base64 comme toutes les photos ac le filtres


//TO FINISH//
// Un fichier config/setup.php, capable de créer ou recréer le schéma de la base de
//  données, en utilisant les infos contenues dans le fichier config/database.php.
// change max width dans header dans chaque file
// footer ac un body en min height: 100%





// IMPOSSIBLE, LAST PB //
// page gallery: pagination se cache en responsive sous le footer: ajouter une height worked dunno why
// page comment: les comments vont en dessous du footer apres plusieurs comments
// page comment: avoir le session id des que je click sur submit comme en refresh page
// forgotpasswd: server redirection not working + review code
// add js filter on video?
// double check database file situation with PDO in each file
// on ne sait pas a qui appartient les photos dans la gallery : ajouter le owner de la photo
// dans comments : ajouter les likes et comments en dessous de photo et owner de la photo
// delete image: error post // message d'erreur pop up peur importe pb dans la delete

// au sign up je peux me connecter sans passer par l'email de confirmation de compte... bloquer
// when deleting account, delete EVERYTHING (comments, likes, pictures .... from user) DONEE


// file pour les likes apres le DOM is ready
// diviser file likes.js pour avoir les likes et comments dans commentaire page juste le total uniquement comment non clickable et likes peu etre clicke
?>
