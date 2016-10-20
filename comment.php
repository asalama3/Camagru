<?php
session_start();

include ('init.php');


// error_reporting(-1);
// ini_set('display_errors', 'On');
// set_error_handler("var_dump");


if (!isset($_SESSION['id']))
{
    header('Location: signin.php');
}
 ?>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="comment.css" />
    <script type="text/javascript" src="./likes.js"></script>
    <script type="text/javascript" src="./add_likes_and_comments.js"></script>

    <title>Camagru</title>
  </head>
  <body>
    <header>
      <h1><a href="index.php">C A M A G R U</a></h1>
        <ul class="topnav" id="myTopnav">
          <li><a href="" style="padding-top: 36px; pointer-events: none;
         cursor: default; "></a></li>
          <li><a href="signout.php" class="menu">Sign Out</a></li>
          <li><a href="profil.php" class="menu">Shooting</a></li>
          <li><a href="index.php" class="menu">Gallery</a></li>
          <li class="icon">
              <a href="javascript:void(0);" onclick="menu()" style="height: 20px;">&#9776;</a>
          </li>
        </ul>
    </header>
  <div class="clear" style="clear: both;"></div>
  <div class="container">

<?php
if (isset($_SESSION['id']))
{

  $alllikes = $bdd->prepare('SELECT * FROM likes where id_image=? and user_id=?' );
  $alllikes->execute( array(intval($_GET['id_image']), $_SESSION['id'] ) );

  if ( $liked = $alllikes->fetch() ) {
    $ret = $liked['id_image'] != null ? 'true' : 'false';
  } else {
    $ret = "false";
  }

  $count = $bdd->prepare("SELECT COUNT(*) AS 'num' FROM likes WHERE id_image=?");
  $count->execute(array(intval($_GET['id_image'])));
  if($result = $count->fetch())
  {
    $ct = intval($result['num']);
  }

  $nbr_comments = $bdd->prepare("SELECT COUNT(*) AS 'com' FROM comments WHERE id_image=?");
  $nbr_comments->execute(array(intval($_GET['id_image'])));
  if($result = $nbr_comments->fetch())
  {
    $nbr = intval($result['com']);
  }

    $get_userid = $bdd->prepare('SELECT user_id FROM `images` WHERE id_image=?');
    $get_userid->execute(array(intval($_GET['id_image'])));
    if ($user = $get_userid->fetch())
    {
        $user_id= $user['user_id'];
    }

    $get_username = $bdd->prepare('SELECT username from users WHERE user_id=?');
    $get_username->execute(array($user_id));
    if ($username = $get_username->fetch())
    {
        $usr_nm=$username['username'];
    }

  $id = intval($_GET['id_image']);
  $image = $bdd->prepare('SELECT * FROM images WHERE id_image=?');
  $image->execute(array($id));
  $img = $image->fetch();


  echo "<div class=\"comment_image\" >" ;
  echo "<img class=\"style\" src=\"" . $img['name'] . "\" onload= " .'"'. "add_info(this, ". $ret .", ". $ct .", " . $_GET['id_image'] .", " . $nbr . ", '$usr_nm');".'"'.">";
  echo "</div>" ;

  $allcomments = $bdd->prepare('SELECT * FROM comments WHERE id_image=?');
  $allcomments->execute(array($_GET['id_image']));
  // echo $_GET['id_image'];
  // $display = $allcomments->fetch();

  while ($display = $allcomments->fetch())
  {
    $get_useridbis = $bdd->prepare('SELECT user_id FROM `comments` WHERE id_image=?');
    $get_useridbis->execute(array(intval($_GET['id_image'])));
    if ($user_com = $getuseridbis->fetch())
    {
        $usr_id= $user_com['user_id'];
    }

    $get_usernm = $bdd->prepare('SELECT username from users WHERE user_id=?');
    $get_usernm->execute(array($usr_id));
    if ($usernamecom = $get_usernm->fetch())
    {
        $usr_nm=$usernamecom['username'];
    }
  $user_name_styled = '<a style="font-weight: bold;">'.$usr_nm.'</a>';

    echo "<div class=\"comments\" />";
    echo $user_name_styled . ':'. $display['content'];
    echo "</div>";
    
  }
}
?>

<div class="end_of_file">
<div class="tryout" id= "<?php echo $_GET['id_image']; ?>" /> 
    <input type="text" placeholder="Write a comment..."  name="comment" id="comment"/>
    <input type="submit" name="submit" value="Submit" id="submit_comment"/>
  </div>
</div>
    <?php  include ('footer.php'); ?>
  </body>
    <script type="text/javascript" src="./comments.js"></script>
    <script type="text/javascript" src="./header.js"></script>

</html>
