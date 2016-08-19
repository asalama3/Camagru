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
// ini_set('display_errors', 1);
// error_reporting(E_ALL);

      if(!empty($_FILES['file_upload']['name']))
      {
        $message = $_SESSION['message'];
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
                  $message= "File uploaded !";
                }
                else
                  $message= "File could not be uploaded";
              }
              else
                $message= "File too big";
            }
            else
              $message= "Wrong file format";
          }
          else
            $message = "File too heavy";
        }
        else
          $message = "No file to upload";
        }
        else {
          $message = "No file to upload";
        }
        empty($_FILES);
        $url = 'http://localhost:8888/Camagru/profil.php';
          echo '<script>window.location = "'.$url.'?erreur='.$message.'";</script>';

  ?>
