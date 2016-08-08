<?php
session_start();
try
{
  $bdd = new PDO('mysql:localhost=8889;dbname=Camagru', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch (Exception $e)
{
  die('Erreur: ' . $e->getMessage());
}
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (isset($_GET['id']) AND $_GET['id'] > 0)
{
  $getid = intval($_GET['id']);
  $requser = $bdd->prepare('SELECT * FROM users WHERE id=?');
  $requser->execute(array($getid));
  $userinfo = $requser->fetch();
}
?>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="profil.css" />
    <title> Camagru</title>
  </head>
  <body>
    <header>
      <h1>Welcome <?php echo $userinfo['username']; ?></h1>
      <?php
      if (isset($_SESSION['id']) AND $userinfo['id'] == $_SESSION['id'])
      {
      ?>
      <a href="deconnexion.php"><img src="./images/logout2.png"></a>
      <?php
      }
      ?>
    </header>
    <div id="parent">
      <aside id="webcam">
      <form method='POST' action="" />
      <input type="checkbox" name="dog" id="dog" /><label for ="dog"><img src="./images/chien.png"></label>
      <input type="checkbox" name="heart" id="heart" /><label for ="heart"><img src="./images/COEUR.png"></label>
      <input type="checkbox" name="snake" id="snake" /><label for ="snake"><img src="./images/serpent.png"></label>
      <input type="checkbox" name="cadre" id="cadre" /><label for ="cadre"><img src="./images/cadre.png"></label>
      </form>
      </br></br></br>
      <video id="video"></video>
      <button id="startbutton">Prendre une photo</button>
      <canvas id="canvas"></canvas>
    </aside>
    <aside id="pictures">
      <p>  My pictures </p>
      </aside>
    </div>
    <div id="upload">
      <table>
        <tr>
          <td>
            <form name="upload" method="post" action="" enctype="multipart/form-data">
              <input type="file" name="file_upload" />
              <input type="submit" name="submit" value="Upload" />
            </form>
          </td>
        </tr>
        <tr>
          <td>
  <?php
        if(!empty($_FILES['file_upload']['name']))
        {
          $file_tmp = $_FILES['file_upload']['tmp_name'];
          $file_name = $_FILES['file_upload']['name'];

          list($file_width, $file_height, $file_type, $file_attr)=getimagesize($file_tmp);

          $file_max_size = 5000000;
          $file_max_height = 24480;
          $file_max_width = 32640;

          $file_path = './Pictures/';

          $file_ext = substr($file_name, strrpos($file_name, '.')+1);

          $file_date = date("Ymdhis");
          $file_new_name = $file_date.".".$file_ext;

          if(!empty($file_tmp) && is_uploaded_file($file_tmp))
          {
            if(filesize($file_tmp) < $file_max_size)
            {
              if($file_ext == "gif" || $file_ext == "jpeg" || $file_ext == "png" || $file_ext == "jpg")
              {
                if(($file_width <= $file_max_width) && ($file_height <= $file_max_height))
                {
                  if(move_uploaded_file($file_tmp, $file_path.$file_new_name))
                  {
                    $insertimage = $bdd->prepare("INSERT INTO images(user_id, id_image, lien_image) VALUES(?, ?, ?)");
                    $insertimage->execute(array($_SESSION['id'], '', $file_path.$file_new_name));
                    echo "File uploaded ! <br/>";
                  }
                  else
                    echo "File could not be uploaded </br>";
                }
                else
                  echo "File too big >/br>";
              }
              else
                echo "Wrong file format </br>";
            }
            else
              echo "File too heavy </br>";
          }
          else
            echo "No file to upload </br>";
          }

    ?>
          </td>
        </tr>
        <tr>
          <td>
            <?php
            $allimages = $bdd->prepare("SELECT * FROM images WHERE user_id= ?");
            $allimages->execute(array($_SESSION['id']));
            while($user_image = $allimages->fetch())
            {
              ?>
              <img src="<?php echo $user_image['lien_image'];?>" />
            <?php
            }
            ?>
            </td>
          </tr>
      </table>
    </div>
    <script type="text/javascript" src="./profil.js"></script>
  </body>
</html>
