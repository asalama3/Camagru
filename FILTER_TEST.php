
<html lang="en">
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="./FILTER_TEST.css" media="screen" title="no title" charset="utf-8">
    <title>Image from Webcam</title>
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>

    <script type="text/javascript">

    var allRadios = document.getElementsByName('re');
       var booRadio;
       var x = 0;
       for(x = 0; x < allRadios.length; x++){

           allRadios[x].onclick = function() {
               if(booRadio == this){
                   this.checked = false;
                   booRadio = null;
               }else{
                   booRadio = this;
               }
           };
       };

      //    function addoverlay(button){
      //      var x = button.id;
      //      switch (x) {
      //        case '1':
      //           addoverlaydog(x);
      //         break;
      //        case '2':
      //           addoverlaycoeur(x);
      //         break;
      //         case '3':
      //           addoverlaycadre(x);
      //           break;
      //         default:
      //         return false;
      //         }
      // };
      // function addoverlaydog(){
      //    $('.text').css("display","block");
      //   };
      //   function addoverlaycoeur(){
      //     $('.textcoeur').css("display","block");
      //   };
      //   function addoverlaycadre(){
      //     $('.textcadre').css("display","block");
      //   };

      //  function addoverlaydog(){
      //    $('.text').css("display","block");
      //  };
      //  document.getElementById('text').innerHTML = '';
       //
      //  function addoverlaycoeur(){
      //    $('.textcoeur').css("display","block");
      //  };
      //  document.getElementById('textcoeur').innerHTML = '';
       //
      //  function addoverlaycadre(){
      //    $('.textcadre').css("display","block");
      //  };
      //  document.getElementById('textcadre').innerHTML = '';
       //

       $('input[type=radio]').change(function() {
    $("video").removeClass();
    if($(this).val() == "zero"){
        $('video').addClass('text');
    }
    else if($(this).val() == "one"){
        $('video').addClass('textcoeur');
    }
    else if($(this).val() == "two"){
        $('video').addClass('textcadre');
    }
});
    </script>
</head>
<body>
  <div class="hero">
    <video id="video" width="640" height="480" autoplay></video>
    <!-- <div class="text">
      </div>
      <div class="textcoeur">
      </div>
      <div class="textcadre">
      </div> -->
      <!-- <input type="checkbox" name="dog" id="dog" onclick='addoverlay()'/><label for ="dog"><img src="./images/chien.png"></label> -->
      <input type="radio" name="re" value="zero" id="1" /><label for ="dog"><img src="./images/chien.png"></label>
      <input type="radio" name="re" value="one" id="2" /><label for ="heart"><img src="./images/COEUR.png"></label>
      <input type="radio" name="re" value = "two" id="3" /><label for ="cadre"><img src="./images/cadre.png"></label>
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
