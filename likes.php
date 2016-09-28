<?php
session_start();
try
{
    $bdd = new PDO('mysql:localhost=8889;dbname=Camagru', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

if (isset($_SESSION['id']) AND $_SESSION['id'] > 0) {
    $requser = $bdd->prepare("SELECT user_id, id_image FROM likes WHERE user_id=? AND id_image=?");
    $requser->execute(array($_SESSION['id'], $_POST['id']));
//    $requser->closeCursor();
    if ($ret = $requser->fetch()) {
        $del_like = $bdd->prepare("DELETE FROM likes WHERE user_id=? AND id_image=?");
        $del_like->execute(array($_SESSION['id'], $_POST['id']));
//        $del_like->closeCursor();
    } else {
        $add_like = $bdd->prepare("INSERT INTO likes(user_id, id_image) VALUES(?, ?)");
        $add_like->execute(array($_SESSION['id'], $_POST['id']));
//        $add_like->closeCursor();
    }
}
else
    echo "error_php";
}

catch (Exception $e)
{
    die('Erreur: ' . $e->getMessage());
}




// if button is liked, delete from likes
// get all likes and condition if the number of likes is more than 1 show the total if not write "be the first person to like this pic

?>

<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="likes.css" />
    <title> Camagru</title>
</head>
<body>


</body>
</html>
