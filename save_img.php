<?php
session_start();

include ('init.php');

error_reporting(-1);
ini_set('display_errors', 'On');
set_error_handler("var_dump");

$json = file_get_contents("php://input");
$json = str_replace('data:image/png;base64,', "", $json);
$json = preg_replace("/&filter=.*/", "", $json);
$unencodedData = base64_decode($json);

set_error_handler(function ($no, $msg, $file, $line) {
    throw new ErrorException($msg, 0, $no, $file, $line);
});
try {
    $dest = @imagecreatefromstring($unencodedData);
} catch (Exception $e) {
    return ;
}

$file = $_POST['filter'];
$file = preg_replace("/.*\//", "", $file); // remplacer tout ce quil y a jusqua le / par rien pur garder le nom du file


if ($file) {
    set_error_handler(function ($no, $msg, $file, $line) {
    throw new ErrorException($msg, 0, $no, $file, $line);
});
try {
        $src = imagecreatefrompng("./images/" . $file);
    }
    catch (Exception $e)
    {
        return ;
    }

    $width = imagesx($src);
    $height = imagesy($src);

    set_error_handler(function ($no, $msg, $file, $line) {
    throw new ErrorException($msg, 0, $no, $file, $line);
});
try {
        imagecopy($dest, $src, 225, 10, 0, 0, $width, $height);
    }
    catch (Exception $e)
    {
        return ;
    }
}
else{
    echo "Bad filter";
    exit;
}


ob_start();
imagepng($dest);
$contents =  ob_get_contents();
ob_end_clean();
echo 'data:image/png;base64,' . base64_encode($contents);

$req = $bdd->prepare("INSERT INTO images(name, lien_image, user_id) VALUES(?, ?, ?)");
$req->execute(array('data:image/png;base64,' . base64_encode($contents), "salut", $_SESSION['id']));
$req = $bdd->prepare("SELECT id_image FROM images WHERE user_id=? ORDER BY created_at DESC LIMIT 1");
$req->execute(array($_SESSION['id']));
print_r("&" . $req->fetch()['id_image']);
 ?>
