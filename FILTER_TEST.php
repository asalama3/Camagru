
<html lang="en">
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="./FILTER_TEST.css" media="screen" title="no title" charset="utf-8">
    <title>Image from Webcam</title>
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>

    <script type="text/javascript">
    function addoverlay(){
      $('.text').css("display","block");
    };
    </script>
</head>
<body>
  <div class="hero">
    <video id="video" width="640" height="480" autoplay></video>
    <div class="text">
      </div>
      <input type="checkbox" name="dog" id="dog" onclick='addoverlay()'/><label for ="dog"><img src="./images/chien.png"></label>
    </div>
    <canvas id="canvas" width="320" height="240" style="display: none;"></canvas>
    <p class="button" id="photo">Take Photo</p>

    <p id="filters">
    	Apply Filter:
	    <span id="filter-none">None</span>
    	<span id="filter-sepia" ><img src="./images/chien.png" /></span>
    	<span id="filter-grayscale">Grayscale</span>
    	<span id="filter-grayscale">Brightness</span>
    	<span id="filter-grayscale">Contrast</span>
    </p>
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
