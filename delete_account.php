<?php
session_start();

include ('init.php');


if (!isset($_SESSION['id']))
{
    header('Location: signin.php');
}
if (isset($_SESSION['id']) AND $_SESSION['id'] > 0)
{
    $getid = intval($_SESSION['id']);
    $deluser = $bdd->prepare('DELETE FROM users WHERE user_id=?');
    $deluser->execute(array($getid));
    $delimg = $bdd->prepare('DELETE FROM images WHERE user_id=?');
    $delimg->execute(array($getid));
    $dellikes = $bdd->prepare('DELETE FROM likes WHERE user_id=?');
    $dellikes->execute(array($getid));
    $delcom = $bdd->prepare('DELETE FROM comments WHERE user_id=?');
    $delcom->execute(array($getid));
}

header('Location: signup.php');
?>
