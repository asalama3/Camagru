
<html lang="en">
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="./FILTER_TEST.css" media="screen" title="no title" charset="utf-8">
    <title>Image from Webcam</title>
    <!-- <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script> -->
    <script type="text/javascript">

       //
      //  function addoverlaydog(){
      //     $('.filter').css('opacity', 0);
      //     // check kell radio button is checked
      //     $('.CORRECT RADIO BUTTON').css('opacity', 100);
      //    };
      function addoverlaydog(){
        $('.text').css("display","block");
      };
    </script>
</head>
<body>
  <div class="hero">
  <!-- move inline css to .css -->
    <video id="video" width="640" height="480" autoplay></video>
        <!-- <img class="chien filter" src="./images/chien.png" style="
    position: absolute;
    top: 20%;
    left: 58%;
    opacity: 0;
    z-index: 999;
">
<img class="heart filter" src="./images/chien.png" style="
    position: absolute;
    top: 20%;
    left: 58%;
    opacity: 0;
    z-index: 999;
">
<img class="cadre filter" src="./images/chien.png" style="
    position: absolute;
    top: 20%;
    left: 58%;
    opacity: 0;
    z-index: 999;
"> -->

    <div class="text">
      </div>
      <div class="textcoeur">
      </div>
      <div class="textcadre">
      </div>
       <input type="checkbox" name="dog" id="dog" onclick='addoverlaydog()'/><label for ="dog"><img src="./images/chien.png"></label>
       <input type="checkbox" name="heart" /><label for ="heart"><img src="./images/COEUR.png"></label>
       <input type="checkbox" name="cadre" /><label for ="cadre"><img src="./images/cadre.png"></label>
    </div>
    <canvas id="canvas" width="320" height="240" style="display: none;"></canvas>
    <p class="button" id="photo">Take Photo</p>
    <div id="container"></div>
    <script type="text/javascript" src="./FILTER_TEST.js"></script>
</body>
</html>


<!--
<div class="hero">
  <video id="video" width="640" height="480" autoplay></video>
  <div class="text">
    </div>
    <button id="addOverlay" onclick='addoverlay()'>Add Overlay</button>
  </div> -->
