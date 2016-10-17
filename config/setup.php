<?php

try
{
    $bdd = new PDO('mysql:localhost=8889', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch (Exception $e)
{
    die('Erreur: ' . $e->getMessage());
}


try {
    $database = 'camagru';
    $req = "CREATE DATABASE IF NOT EXISTS $database DEFAULT CHARACTER SET utf8";
    $bdd->exec($req);
    }
catch (PDOException $e)
{
    die('Erreur: ' . $e->getMessage());
}
try {
    $user = "CREATE TABLE IF NOT EXISTS camagru.users (
                      id INT NOT NULL AUTO_INCREMENT,
                      username VARCHAR(45) NULL,
                      email VARCHAR(255) NULL,
                      password VARCHAR(255) NULL,
                      confirmkey VARCHAR(255) NULL,
                      confirm INT (1) NULL,
                      PRIMARY KEY (id),
                      UNIQUE INDEX username_UNIQUE (username ASC),
                      UNIQUE INDEX email_UNIQUE (email ASC))";

$bdd->exec($user);

}
catch (PDOException $e)
{
    die('Erreur: ' . $e->getMessage());
}

try {
    $images = "CREATE TABLE IF NOT EXISTS camagru.images (
                      id_image INT NOT NULL AUTO_INCREMENT,
                      user_id INT (11) NOT NULL,
                      lien_image VARCHAR(1000) NOT NULL,
                      created_at DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
                      PRIMARY KEY (id_image),
                      name MEDIUMTEXT NOT NULL)";


    $bdd->exec($images);

}
catch (PDOException $e)
{
    die('Erreur: ' . $e->getMessage());
}

try {
    $pass = "CREATE TABLE IF NOT EXISTS camagru.forgotpasswd (
                      id INT(11) NOT NULL AUTO_INCREMENT,
                      email VARCHAR(255) NOT NULL,
                      code INT(11) NOT NULL,
                      confirm  INT(11) NOT NULL,
                      PRIMARY KEY (id))";

    $bdd->exec($pass);
}
catch (PDOException $e)
{
    die('Erreur: ' . $e->getMessage());
}

try {
    $like = "CREATE TABLE IF NOT EXISTS camagru.likes (
                      user_id INT(11) NOT NULL,
                      id_image INT(11) NOT NULL)";

    $bdd->exec($like);
}
catch (PDOException $e)
{
    die('Erreur: ' . $e->getMessage());
}

try {
    $comments = "CREATE TABLE IF NOT EXISTS camagru.comments (
      user_id INT(11) NOT NULL,
      id_image INT(11) NOT NULL,
      content TEXT NOT NULL,
      id INT NOT NULL AUTO_INCREMENT,
      PRIMARY KEY (id))";

    $bdd->exec($comments);

}
catch (PDOException $e)
{
    die('Erreur: ' . $e->getMessage());
}


echo 'ok';
?>
