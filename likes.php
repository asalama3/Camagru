<?php
session_start();

include ('init.php');

// echo $_SESSION['id'];
// echo $_POST['id'];

if (isset($_SESSION['id']) AND $_SESSION['id'] > 0) {
    $requser = $bdd->prepare("SELECT user_id, id_image FROM likes WHERE user_id=? AND id_image=?");
    $requser->execute(array($_SESSION['id'], intval($_POST['id'])));
    if ($ret = $requser->fetch()) {
        $del_like = $bdd->prepare("DELETE FROM likes WHERE user_id=? AND id_image=?");
        $del_like->execute(array($_SESSION['id'], intval($_POST['id'])));
    } else {
        $add_like = $bdd->prepare("INSERT INTO likes(user_id, id_image) VALUES(?, ?)");
        $add_like->execute(array($_SESSION['id'], intval($_POST['id'])));
    }
}
else{
   echo "Please sign in to like this picture";
   return ;
}

$count_likes = $bdd->prepare("SELECT COUNT(*) AS 'count_nbr' FROM likes WHERE id_image=?");
$count_likes->execute(array(intval($_POST['id'])));
// echo $result['count_nbr'];

if($result = $count_likes->fetch()) {
    if (intval($result['count_nbr']) > 0)
        echo intval($result['count_nbr']);
    else
        echo "";
}
?>
