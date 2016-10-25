<?php
session_start();

include ('init.php');

//
// error_reporting(-1);
// ini_set('display_errors', 'On');
// set_error_handler("var_dump");


if (!isset($_SESSION['id']))
{
    header('Location: signin.php');
    exit();
}
 ?>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="comment.css" />
    <script type="text/javascript" src="./likes.js"></script>
    <script type="text/javascript" src="./insert_owner_and_comment.js"></script>

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
$get_id_image = $bdd->prepare('SELECT id_image FROM images WHERE id_image=?');
$get_id_image->execute(array(intval($_GET['id_image'])));
if ($verify_id_image = $get_id_image->fetch())
{
  $id_img = $verify_id_image['id_image'];
}
else{
  echo '<script>window.location = "index.php";</script>';
}

if (isset($_SESSION['id']))
{
    $get_userid = $bdd->prepare('SELECT user_id FROM `images` WHERE id_image=?');
    $get_userid->execute(array($id_img));
    if ($user = $get_userid->fetch())
    {
        $user_id= $user['user_id'];
    }

    $get_username = $bdd->prepare('SELECT username from users WHERE user_id=?');
    $get_username->execute(array($user_id));
    if ($username = $get_username->fetch())
    {
        $usr_nm=base64_decode($username['username']);
    }
  $id = intval($_GET['id_image']);
  $image = $bdd->prepare('SELECT * FROM images WHERE id_image=?');
  $image->execute(array($id));
  $img = $image->fetch();

  echo "<div class=\"comment_image\">" ;
  echo "<img class=\"style\" src=\"" . $img['name'] .  "\" onload= " .'"'. "add_info(this, '$usr_nm');".'"'.">";
  echo "</div>" ;
  echo "<div style='clear:both;'>";
  echo "</div>" ;

  $allcom = $bdd->prepare('SELECT * FROM comments WHERE id_image=?');
  $allcom->execute(array($_GET['id_image']));
  $display = $allcom->fetchAll(PDO::FETCH_ASSOC);

  foreach ($display as $com){
    $username = $bdd->prepare('SELECT username FROM users WHERE user_id=?');
    $username->execute(array($com["user_id"]));
    $result = $username->fetch()[0];
    $decode_username = base64_decode($result);
    $user_name_styled = "<span style='font-weight: bold;'>".$decode_username."</span>";

    echo "<div class=\"comments\" />";
    echo $user_name_styled . ':'.$com['content'];
    echo "</div>";
  }
}
?>

<div class="end_of_file">
<div class="tryout" id= "<?php echo $id_img; ?>" />
    <input type="text" placeholder="Write a comment..."  name="comment" id="comment"/>
    <input type="submit" name="submit" value="Submit" id="submit_comment"/>
  </div>
</div>
    <?php  include ('footer.php'); ?>
  </body>
    <script type="text/javascript" src="./comments.js"></script>
    <script type="text/javascript" src="./header.js"></script>

</html>
