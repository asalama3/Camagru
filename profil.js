var filter_nbr = 0;
var filter = null;
var oldfilter = null;


(function() {
    // A button for each filter will be created dynamically
    var filters = [  {
      name: "Blur",
      filter: "blur(3px)"
    }, {
      name: "Black & White",
      filter: "grayscale(100%)"
    }, {
        name: "Reset",
        filter: ""
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

      // function getRandomNumberWithMax (max) {
      //   return Math.floor(Math.random() * max);
      // }

      function takePhoto() {
          if (filter) {
              canvasContext.drawImage(video, 0, 0, 400, 320);
              var element = document.createElement("img");
              var im = canvas.toDataURL('image/png');
              // var angle = getRandomNumberWithMax(30) - 15;
              // element.style.transform="rotate(" + angle + "deg)";
              // element.style.top = getRandomNumberWithMax(50) + "px";
              // element.style.left = getRandomNumberWithMax(50) + "px";
              // element.style.zIndex = z;
              element.style.boxshadow = "2px 2px 2px #888888";
              element.style.padding = "10px";
              element.style.backgroundColor = "white";
              element.style.filter = video.style.filter;
              element.style.webkitFilter = video.style.webkitFilter;
              // element.className = "photo";
              element.addEventListener('dragstart', dragStart, false);

               var xhr = new XMLHttpRequest();
              xhr.onreadystatechange = function() {
                  if (this.readyState == 4 && this.status == 200) {
                      tmp = this.responseText;
                      if (tmp == 'Bad filter'){
                          alert(resp);
                          return;
                      }
                      element.src = tmp.split("&")[0];
                      XXX(element, tmp.split("&")[1]);
                  }

              };
              xhr.open("POST", "save_img.php", true);
              xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
              xhr.send(im +"&filter=" + filter);

          }
          else
          {
              alert('Please select a filter');
          }
      }

        function ffilter(event) {
            if (filter_nbr == 1) {
                var test = document.getElementById('ffff' + filter);
                document.getElementById("video-box").removeChild(test);
                filter = null;
                filter_nbr = 0;
            }
            filter = event.target.id;
            console.log("filter is : " + filter);

            if (filter != oldfilter) {

                var test = document.createElement("img");
                test.src = filter;
                test.id = 'ffff' + filter;
                test.style.width = '130px';
                test.style.height = '130px';
                test.style.position = 'absolute';
                test.style.top = 0;
                test.style.left = 0;
                // test.draggable = true;
                test.addEventListener('dragstart', dragStart, false);
                document.getElementById("video-box").appendChild(test);
                filter_nbr = 1;
                oldfilter = filter;
            }
            else {
                oldfilter = null;
            }
        }

         var label = document.getElementsByTagName('LI');
        for (var i = 0; i < label.length; i++) {
            label[i].onclick = ffilter;
        }



        // display filter on camera
        // attention au cursor
        // effacer l;ancier filtre sil y en a un
        // si un filtre est selectionner le removechild avant de reclicker.
        // clientx clienty filter mouseup 0-100 inside div;





      var draggedElement;
      var x, y, z = 0;

      function dragStart(e) {
        draggedElement = e.target;
        x = e.clientX - draggedElement.offsetLeft;
        y = e.clientY - draggedElement.offsetTop;
        e.dataTransfer.setDragImage(draggedElement, x, y);
      }
//function drop, dragenter, dragover jouent sur les filtres//
      function drop(e) {
        z++;
        draggedElement.style.left = (e.clientX - x) + "px";
        draggedElement.style.top = (e.clientY - y) + "px";
        // draggedElement.style.zIndex = z;
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

      window.onload = start;
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
      document.getElementById("photoButton").disabled = true;

      alert("Sorry, you can't capture video from your webcam in this web browser. Try the latest desktop version of Firefox, Chrome or Opera.");
    }

     // window.location = "profil.php?element="+element;


    //function to get all images in stack and XXX's them
  })();

function submitForm(oFormElement) {
    var xhr = new XMLHttpRequest();
    xhr.onload = function () {
        var element = document.getElementById("message"); // display message on html
        var resp = this.responseText;
        console.log(resp);
         // console.dir(resp.split("&"));
        if ((resp == 'No file selected') || (resp == 'No filter selected') || (resp == 'Wrong file format') || (resp == 'Too large file') || (resp == 'Bad filter')) {
            alert(resp);
            document.getElementById("select").innerHTML = "Choose file";
            return;
        }
        else {
            if (filter) {
                console.log("salut");
                var img = document.createElement("img");
                img.src = resp.split("&")[0];

                // img.src = tmp;
                XXX(img, resp.split("&")[1]);

                element.innerHTML = "SUCCESS!!!";
                window.setTimeout(func, 3000);
            }
            else {
                alert('Please select a filter');
                document.getElementById("select").innerHTML = "Choose file";
                return;
            }
        }
    }

        xhr.open(oFormElement.method, oFormElement.action, true);
       var fform = new FormData(oFormElement);
        // console.log(filter);
        fform.append("filter", filter);
        xhr.send(fform);
        oFormElement.reset();
        return false;
    }


function func(){
  console.log("func");
    document.getElementById("message").innerHTML="";
    document.getElementById("select").innerHTML = "Choose file";
}

function display_name() {
    document.getElementById("select").innerHTML = document.getElementById('file').value.replace(/.*\\/g, "");
}
