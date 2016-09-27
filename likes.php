<?php
try
{
    $bdd = new PDO('mysql:localhost=8889;dbname=Camagru', 'root', 'root');
}
catch (Exception $e)
{
    die('Erreur: ' . $e->getMessage());
}

if (isset($_SESSION['id']) AND $_SESSION['id'] > 0) {
    $requser = $bdd->prepare("SELECT user_id, id_image FROM likes WHERE VALUES(?, ?)");
    $requser->execute(array($_SESSION['id'], $_POST['id']));

    if ($ret = $requser->fetch()) {
        $add_like = $bdd->prepare("DELETE FROM likes(id_image, user_id) WHERE VALUES(?, ?)");
        $add_like->execute(array($_POST['id'], $_SESSION['id']));
    } else {
        $add_like = $bdd->prepare("INSERT INTO likes(id_image, user_id) WHERE VALUES(?, ?)");
        $add_like->execute(array($_POST['id'], $_SESSION['id']));
    }
    echo "ok";
}
else
    echo "error";

// if button is liked, delete from likes
// get all likes and condition if the number of likes is more than 1 show the total if not write "be the first person to like this pic

?>