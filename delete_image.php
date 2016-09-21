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
// ini_set('display_errors', 1);
// error_reporting(E_ALL);

if (isset($_SESSION['id']) AND $_SESSION['id'] > 0)
{
    $id_image = intval($_POST['id']);
    $delete_image = $bdd->prepare('DELETE FROM images WHERE id_image=? AND user_id=?');
    $delete_image->execute(array($id_image, $_SESSION['id']));
    echo "ok";
}
else
    echo "error";
?>