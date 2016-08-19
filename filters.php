<?php
if(isset($_POST["submit"])) {

$stamp = imagecreatefrompng('./images/chien.png');
$im = imagecreatefrompng('./images/cadre.png');

$marge_right = 10;
$marge_bottom = 10;
$sx = imagesx($stamp);
$sy = imagesy($stamp);

imagecopy($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));

header('Content-type: image/png');
imagepng($im);
imagedestroy($im);
}
 ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <script type="text/javascript">
    function addoverlay(){
      $('.text').css("display","block");
    };
    </script>
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
    <link rel="stylesheet" href="./filters.css" media="screen" title="no title" charset="utf-8">
    <title></title>
  </head>
  <body>
    <div class="hero">
      <img src="http://lorempixel.com/output/city-q-c-960-480-4.jpg" alt="" id="image" />
      <div class="text">
      </div>
        <button id="addOverlay" onclick='addoverlay()'>Add Overlay</button>
        <!-- <p> <img src="./images/chien.png" alt="" /> </p> -->
    </div>
  </body>
</html>
