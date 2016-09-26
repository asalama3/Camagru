<?php
try
{
    $bdd = new PDO('mysql:localhost=8889;dbname=Camagru', 'root', 'root');
}
catch (Exception $e)
{
    die('Erreur: ' . $e->getMessage());
}
error_reporting(-1);
ini_set('display_errors', 'On');
set_error_handler("var_dump");

include ('header.php');

$imgperpage = 10;
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
        <title>Camagru</title>
    </head>
    <body>
<div class="allimages">
<?php
//echo "<pre>";
//print_r($_SERVER);

$allimages = $bdd->prepare('SELECT * FROM images ORDER BY id_image DESC LIMIT '.$start.','.$imgperpage);
$allimages->execute(array());
$images = $allimages->fetch();
while($images = $allimages->fetch()) {
    echo "<div class=\"imageposition\"><img class=\"stylephoto\"  src=\"" . $images['name'] . "\" onload='like_image(this, git);' /></div>";
}
?>
    <div class="clear" style="clear: both;"></div>

</div>
<div class="pagination">
<?php
for($i=1;$i<=$totalpages;$i++) {
    if ($i == $currentpage) {
        echo $i . ' ';
    } else {
        echo '<a href="index.php?page=' . $i . '">' . $i . '</a> ';
    }
}
?>
</div>
<?php  include ('footer.php'); ?>

    </body>
</html>