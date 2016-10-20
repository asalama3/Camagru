<?php
session_start();

include ('init.php');


if (isset($_SESSION['id']) AND $_SESSION['id'] > 0)
{
    $id_image = intval($_POST['id']);
    $delete_image = $bdd->prepare('DELETE FROM images WHERE id_image=? AND user_id=?');
    $delete_image->execute(array($id_image, $_SESSION['id']));
    echo "ok";
}
?>
