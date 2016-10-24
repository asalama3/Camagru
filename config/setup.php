<?php
// variable de database dans pdo //
include ('database.php');

try
{
    $bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch (Exception $e)
{
    die('Erreur: ' . $e->getMessage());
}


try {
    $req = "CREATE DATABASE IF NOT EXISTS $database DEFAULT CHARACTER SET utf8";
    $bdd->exec($req);
    }
catch (PDOException $e)
{
    die('Erreur: ' . $e->getMessage());
}
$_DBNAME = 'dbname=' . $database;

try {
    $req = "USE $database";
    $bdd->exec($req);
    }
catch (PDOException $e)
{
    die('Erreur: ' . $e->getMessage());
}


try {
    $user = "CREATE TABLE IF NOT EXISTS users (
                      user_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                      username VARCHAR(45) NULL,
                      email VARCHAR(255) NULL,
                      password VARCHAR(255) NULL,
                      confirmkey VARCHAR(255) NULL,
                      confirm INT (1) NULL,
                      UNIQUE INDEX username_UNIQUE (username ASC),
                      UNIQUE INDEX email_UNIQUE (email ASC))";

$bdd->exec($user);

}
catch (PDOException $e)
{
    die('Erreur: ' . $e->getMessage());
}

try {
    $images = "CREATE TABLE IF NOT EXISTS images (
                      id_image INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                      user_id INT (11) NOT NULL,
                      lien_image VARCHAR(1000) NOT NULL,
                      created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
                      name MEDIUMTEXT NOT NULL,
                      FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE)";


    $bdd->exec($images);

}
catch (PDOException $e)
{
    die('Erreur: ' . $e->getMessage());
}

try {
    $pass = "CREATE TABLE IF NOT EXISTS forgotpasswd (
                      id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                      email VARCHAR(255) NOT NULL,
                      code INT(11) NOT NULL,
                      confirm  INT(11) NULL)";

    $bdd->exec($pass);
}
catch (PDOException $e)
{
    die('Erreur: ' . $e->getMessage());
}

try {
    $like = "CREATE TABLE IF NOT EXISTS likes (
                      id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
                      user_id INT(11) NOT NULL,
                      id_image INT(11) NOT NULL)";

    $bdd->exec($like);
}
catch (PDOException $e)
{
    die('Erreur: ' . $e->getMessage());
}

try {
    $comments = "CREATE TABLE IF NOT EXISTS comments (
      id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
      user_id INT(11) NOT NULL,
      id_image INT(11) NOT NULL,
      content TEXT NOT NULL,
      FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
      FOREIGN KEY (id_image) REFERENCES images(id_image) ON DELETE CASCADE)";


    $bdd->exec($comments);

}
catch (PDOException $e)
{
    die('Erreur: ' . $e->getMessage());
}

?>
