(function() {
    // A button for each filter will be created dynamically
    var filters = [ {
      name: "Reset",
      filter: ""
    }, {
      name: "Blur",
      filter: "blur(3px)"
    }, {
      name: "BnW",
      filter: "grayscale(100%)"
    }];

    var video = document.getElementById('video');
    var canvas = document.getElementById('canvas');
    var canvasContext = canvas.getContext('2d');

    navigator.getUserMedia = (navigator.getUserMedia ||
      navigator.webkitGetUserMedia ||
      navigator.mozGetUserMedia ||
      navigator.msGetUserMedia);

    if (navigator.getUserMedia) {
      function gotStream(stream) {
        if (navigator.mozGetUserMedia) {
          video.mozSrcObject = stream;
        } else {
          var vendorURL = window.URL || window.webkitURL;
          video.src = vendorURL.createObjectURL(stream);
        }
        video.play();
      }

      function error(message) {
        console.log(message);
      }

      function start() {
        this.disabled = true;
        navigator.getUserMedia( {
          audio: false,
          video: {
            mandatory: {
              maxWidth: 320,
              maxHeight: 240
            }
          }
        },
        gotStream,
        error);
      }

      function getRandomNumberWithMax (max) {
        return Math.floor(Math.random() * max);
      }

      function takePhoto(data_uri) {
        canvasContext.drawImage(video, 0, 0, 320, 240);
        var element = document.createElement("img");
        element.src = canvas.toDataURL();
        var angle = getRandomNumberWithMax(30) - 15;
        element.style.transform="rotate(" + angle + "deg)";
        element.style.top = getRandomNumberWithMax(50) + "px";
        element.style.left = getRandomNumberWithMax(50) + "px";
        element.style.zIndex = z;
        element.style.filter = video.style.filter;
        element.style.webkitFilter = video.style.webkitFilter;
        element.className = "photo";
        element.addEventListener('dragstart', dragStart, false);

        var file = document.getElementById("stack").appendChild(element);
        var formdata = new FormData();
        formdata.append("stack", file);
        var ajax = new XMLHttpRequest();
        ajax.addEventListener("load", function(event) { uploadcomplete(event);}, false);
        ajax.open("POST", "profil.php");
        ajax.send(formdata);
      }
      function uploadcomplete(event){
          document.getElementById("loading").innerHTML="";
          var image_return=event.target.responseText;
          var showup=document.getElementById("uploaded").src=image_return;
      }

//test save images in php//
      // Webcam.snap( function(data_uri) {
      //        var raw_image_data = data_uri.replace(/^data\:image\/\w+\;base64\,/, '');
      //
      //        document.getElementById('photo_upload').value = raw_image_data;
      //        document.getElementById('myform').submit();
      //    } );
//


      var draggedElement;
      var x, y, z = 0;

      function dragStart(e) {
        draggedElement = e.target;
        x = e.clientX - draggedElement.offsetLeft;
        y = e.clientY - draggedElement.offsetTop;
        e.dataTransfer.setDragImage(draggedElement, x-340, y);
      }
//function drop, dragenter, dragover jouent sur les filtres//
      function drop(e) {
        z++;
        draggedElement.style.left = (e.clientX - x - 30) + "px";
        draggedElement.style.top = (e.clientY - y - 30) + "px";
        draggedElement.style.zIndex = z;
        if (e.stopPropagation) {
          e.stopPropagation();
        }
        e.preventDefault();
        return false;
      }

      function dragEnter(e) {
        e.preventDefault();
        return true;
      }

      function dragOver(e) {
        e.preventDefault();
      }

      document.getElementById("startButton").addEventListener('click', start);
      document.getElementById("photoButton").addEventListener('click', takePhoto);

      var container = document.body;
      container.addEventListener('drop', drop, false);
      container.addEventListener('dragenter', dragEnter, false);
      container.addEventListener('dragover', dragOver, false);


      function findFilterByName (filterArray, name) {
        for(var i = 0; i < filterArray.length; i++) {
          if(filterArray[i].name === name) {
            return filterArray[i];
          }
        }
        // Not found
        return null;
      };

//filtres//
      thisBrowserSupportsCssFilters = function () {
        var prefixes = " -webkit- -moz- -o- -ms- ".split(" ");
        var el = document.createElement('div');
        el.style.cssText = prefixes.join('filter:blur(2px); ');
        return !!el.style.length && ((document.documentMode === undefined || document.documentMode > 9));
      };

      if(thisBrowserSupportsCssFilters()) {
        var buttonsDiv = document.getElementById("filterButtons");

        filters.forEach(function(item){
          var button = document.createElement("button");
          button.id = item.name;
          button.innerHTML = item.name;
          // This will cause a re-flow of the page but I don't care
          buttonsDiv.appendChild(button);
        });

        function filterClicked (event) {
          event = event || window.event;
          var target = event.target || event.srcElement;
          if(target.nodeName === "BUTTON") {
            var filter = findFilterByName(filters, target.id);
            if(filter) {
              video.style.filter = filter.filter;
              video.style.webkitFilter = filter.filter;
            }
          }
        };
        buttonsDiv.addEventListener("click", filterClicked, false);
      }
//end filtres//
    } else {
      document.getElementById("startButton").disabled = true;
      document.getElementById("photoButton").disabled = true;

      alert("Sorry, you can't capture video from your webcam in this web browser. Try the latest desktop version of Firefox, Chrome or Opera.");
    }


    // window.location = "profil.php?element="+element;


  })();
