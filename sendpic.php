<?php
session_start();

include ('init.php');


$upload_file = $_FILES['file_upload']['tmp_name'];


$imageFileType = pathinfo($_FILES['file_upload']['name'],PATHINFO_EXTENSION);
if (empty($imageFileType))
{
    echo "No file selected";
    exit();
}
else {
  if ($imageFileType == "jpeg" || $imageFileType == "JPEG") {
    $dest = imagecreatefromjpeg($upload_file);
  } else if ($imageFileType == "png" || $imageFileType == "PNG") {
    $dest = imagecreatefrompng($upload_file);
  } else if ($imageFileType == "jpg" || $imageFileType == "JPG") {
    $dest = imagecreatefromjpeg($upload_file);
  } else if ($imageFileType == "gif" || $imageFileType == "GIF") {
    $dest = imagecreatefromgif($upload_file);
  } else {
      echo "Wrong file format";
      exit();
  }
}

if ($_FILES["file_upload"]["size"] > 500000)
{
  echo "Too large file";
    exit();
}

if ($_POST['filter'] == "null")
{
    echo "No filter selected";
    exit();
}

list($width, $height) = getimagesize($upload_file);

//$image = imagecreate(420, 340);

$image = imagecreatetruecolor(400, 320);
$trans_colour = imagecolorallocatealpha($image, 0, 0, 0, 127);
imagefill($image, 0, 0, $trans_colour);


imagecopyresampled($image, $dest, 0, 0, 0, 0, 400, 320, $width, $height);

$file = $_POST['filter'];
$file = preg_replace("/.*\//", "", $file);

if ($file) {
    $src = imagecreatefrompng("./images/" . $file);
    imagecopy($image, $src, 140, 30, 0, 0, 150, 150);
}
else{
    echo "Bad filter";
    exit();
}


ob_start();
imagejpeg($image);
$contents =  ob_get_contents();
ob_end_clean();
echo 'data:image/png;base64,' . base64_encode($contents);

    $req = $bdd->prepare("INSERT INTO images(name, lien_image, user_id) VALUES(?, ?, ?)");
    $req->execute(array('data:image/png;base64,' . base64_encode($contents), "salut", $_SESSION['id']));

    $req = $bdd->prepare("SELECT id_image FROM images WHERE user_id=? ORDER BY created_at DESC LIMIT 1");
    $req->execute(array($_SESSION['id']));
    print_r('&' . $req->fetch()['id_image']);
    return;

?>
