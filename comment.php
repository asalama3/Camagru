<?php
session_start();
try
{
    $bdd = new PDO('mysql:localhost=8889;dbname=camagru', 'root', 'root');
}
catch (Exception $e)
{
    die('Erreur: ' . $e->getMessage());
}
error_reporting(-1);
ini_set('display_errors', 'On');
set_error_handler("var_dump");

if (!isset($_SESSION['id']))
{
    alert('Please sign in before leaving a comment');
    header('Location: signin.php');
}
else{
  
}



// request to get the right picture to comment



 ?>
