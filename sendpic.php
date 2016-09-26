<?php
session_start();
try
{
  $bdd = new PDO('mysql:localhost=8889;dbname=camagru', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch (Exception $e)
{
  die('Erreur: ' . $e->getMessage());
}
// ini_set('display_errors', 1);
// error_reporting(E_ALL);

//$test = file_get_contents("php://input");


$upload_file = $_FILES['file_upload']['tmp_name'];

$imageFileType = pathinfo($_FILES['file_upload']['name'],PATHINFO_EXTENSION);
if (empty($imageFileType))
{
  $message = "No file selected";
}
else {
  if ($imageFileType == "jpeg") {
    $dest = imagecreatefromjpeg($upload_file);
  } else if ($imageFileType == "png") {
    $dest = imagecreatefrompng($upload_file);
  } else if ($imageFileType == "jpg") {
    $dest = imagecreatefromjpeg($upload_file);
  } else if ($imageFileType == "gif") {
    $dest = imagecreatefromgif($upload_file);
  } else {
    $message = "Wrong file format";
  }
}


if ($_FILES["file_upload"]["size"] > 500000)
{
  $message = "Too large file";
}

//print_r($_POST['filter']);
if (empty($_POST['filter']))
{
  $message = "No filter selected";
}

if (!empty($message)) {
  echo $message;
  return;
}
else{
list($width, $height) = getimagesize($upload_file);

//$image = imagecreate(420, 340);

$image = imagecreatetruecolor(400, 320);
$trans_colour = imagecolorallocatealpha($image, 0, 0, 0, 127);
imagefill($image, 0, 0, $trans_colour);


imagecopyresampled($image, $dest, 0, 0, 0, 0, 400, 320, $width, $height);


$file = $_POST['filter'];
$src = imagecreatefrompng($file);

imagecopy($image, $src, 140, 30, 0, 0, 150, 150);

// grace a echo on envoie une reponse a l'ajaax, ma photo finale
// ob sert a convertir mon image en string pour ensuite la reconvertir en base64 pour l'envoyer a ajax et la save
// dans database.


ob_start();
imagejpeg($image);
$contents =  ob_get_contents();
ob_end_clean();
echo 'data:image/png;base64,' . base64_encode($contents);

    $req = $bdd->prepare("INSERT INTO images(name, lien_image, user_id) VALUES(?, ?, ?)");
    $req->execute(array('data:image/png;base64,' . base64_encode($contents), "salut", $_SESSION['id']));

    $req = $bdd->prepare("SELECT id_image FROM images WHERE user_id=? ORDER BY created_at DESC LIMIT 1");
    $req->execute(array($_SESSION['id']));
    print_r($req->fetch()['id_image']);
    return;
}






//
//      if(!empty($_FILES['file_upload']['name']))
//      {
//        $message = $_SESSION['message'];
//        $file_tmp = $_FILES['file_upload']['tmp_name'];
//        $file_name = $_FILES['file_upload']['name'];
//
//        list($file_width, $file_height, $file_type, $file_attr)=getimagesize($file_tmp);
//
//        $file_max_size = 5000000;
//        $file_max_height = 24480;
//        $file_max_width = 32640;
//
//        $file_path = './pictures/';
//
//        $file_ext = substr($file_name, strrpos($file_name, '.')+1);
//
//        $file_date = date("Ymdhis");
//        $file_new_name = $file_date.".".$file_ext;
//
//        if(!empty($file_tmp) && is_uploaded_file($file_tmp))
//        {
//          if(filesize($file_tmp) < $file_max_size)
//          {
//            if($file_ext == "gif" || $file_ext == "jpeg" || $file_ext == "png" || $file_ext == "jpg")
//            {
//              if(($file_width <= $file_max_width) && ($file_height <= $file_max_height))
//              {
//                if(move_uploaded_file($file_tmp, $file_path.$file_new_name))
//                {
//                  try {
//                    $insertimage = $bdd->prepare("INSERT INTO images(user_id, lien_image, name) VALUES(?, ?, ?)");
//                    $insertimage->execute(array($_SESSION['id'], 'salut', $file_path . $file_new_name));
//                      }
//                  catch (PDOException $e)
//                  {
//                    die('Erreur: ' . $e->getMessage());
//                  }
//                     $message= "File uploaded !";
//                }
//                else
//                  $message= "File could not be uploaded";
//              }
//              else
//                $message= "File too big";
//            }
//            else
//              $message= "Wrong file format";
//          }
//          else
//            $message = "File too heavy";
//        }
//        else
//          $message = "No file to upload";
//        }
//        else {
//          $message = "No file to upload";
//        }
//
//       echo $message;
//
//        empty($_FILES);
        // header('Location: '.$_SERVER["HTTP_HOST"].'/Camagru/profil.php'.'?erreur='.$message);

//       if (!empty($message))
//       {
//          echo "<script type='text/javascript'>alert('$message');</script>";
//        }
//       $url = '/Camagru/profil.php';
//         echo '<script>window.location = "'.$url.'";</script>';

  ?>
