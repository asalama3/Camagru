<?php
include ('config/database.php');
include ('config/setup.php');

try
{
    $bdd = new PDO($DATA_CONNECT, $DB_USER, $DB_PASSWORD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch (Exception $e)
{
    die('Erreur: ' . $e->getMessage());
}
?>