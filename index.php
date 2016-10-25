<?php
session_start();
include ('init.php');


include ('header.php');

$imgperpage = 6;
$imgtotal = $bdd->prepare('SELECT * from images');
$imgtotal->execute(array());
$imgtotal = $imgtotal->rowCount();

$totalpages = ceil($imgtotal/$imgperpage);

if (isset($_GET['page']) AND !empty($_GET['page']) AND ctype_digit($_GET['page']) AND $_GET['page'] > 0 AND $_GET['page'] <= $totalpages)
{
    $currentpage = $_GET['page'];
}
else{
    $currentpage = 1;
}

$start = ($currentpage-1)*$imgperpage;
?>

<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="style.css" />
        <script type="text/javascript" src="./likes.js"></script>
        <title>Camagru</title>
    </head>
    <body>
      <div id="play" class="allimages">
<?php
//echo "<pre>";
//print_r($_SERVER);


$allimages = $bdd->prepare('SELECT * FROM images ORDER BY id_image DESC LIMIT '.$start.','.$imgperpage);
$allimages->execute();

while( $images = $allimages->fetch() )
{
    $alllikes = $bdd->prepare('SELECT * FROM likes where id_image=? and user_id=?' );
    $alllikes->execute( array($images['id_image'], $_SESSION['id'] ) );

    if ( $liked = $alllikes->fetch() ) {
      $ret = $liked['id_image'] != null ? 'true' : 'false';
    } else {
      $ret = "false";
    }

    $count = $bdd->prepare("SELECT COUNT(*) AS 'num' FROM likes WHERE id_image=?");
    $count->execute(array($images['id_image']));
    if($result = $count->fetch())
    {
      $ct = intval($result['num']);
    }

    $nbr_comments = $bdd->prepare("SELECT COUNT(*) AS 'com' FROM comments WHERE id_image=?");
    $nbr_comments->execute(array($images['id_image']));
    if($result = $nbr_comments->fetch())
    {
      $nbr = intval($result['com']);
    }

    $get_userid = $bdd->prepare('SELECT user_id FROM `images` WHERE id_image=?');
    $get_userid->execute(array(intval($images['id_image'])));
    if ($user = $get_userid->fetch())
    {
        $user_id= $user['user_id'];
    }

    $get_username = $bdd->prepare('SELECT username from users WHERE user_id=? ');
    $get_username->execute(array($user_id));
    if ($username = $get_username->fetch())
    {
        $usr_nm=base64_decode($username['username']);
    }

    echo "<div class=\"test\">" ;
    echo "<div class=\"imageposition\" id=\"" . $images['id_image'] . "\" >" ;
    echo "<img class=\"stylephoto\"  src=\"" . $images['name'] . "\" onload=" .'"'. "likes_image(this, ". $ret .", ". $ct .", " . $images['id_image'] .", " . $nbr . ", '$usr_nm');".'"'. ">";
    echo "</div>";
    echo "</div>";
}

?>
 <div class="clear" style="clear: both;"></div>
    <div class="pagination" style="height: 50px;">
        <?php
        for($i=1;$i<=$totalpages;$i++) {
            if ($i == $currentpage) {
                echo $i . ' ';
            } else {
                echo '<a class="pages" href="index.php?page=' . $i . '">' . $i . ' </a> ';
            }
        }
        ?>
    </div>
  </div>

    <?php  include ('footer.php'); ?>

  </body>
</html>
