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


        // navigator.getUserMedia = (navigator.getUserMedia || navigator.mozGetUserMedia ||
        //   navigator.webkitGetUserMedia ||
        //   navigator.mediaDevices.getUserMedia ||
        //   navigator.msGetUserMedia);
        //
        // if (navigator.getUserMedia) {
        //   function gotStream(stream) {
        //     if (navigator.mozGetUserMedia) {
        //       video.mozSrcObject = stream;
        //     } else {
        //       var vendorURL = window.URL || window.webkitURL;
        //       video.src = vendorURL.createObjectURL(stream);
        //     }
        //     video.play();
        //   }
        //
        //   function error(message) {
        //     console.log(message);
        //   }
        //
        //   function start() {
        //     this.disabled = true;
        //     navigator.getUserMedia( {
        //
        //       audio: false,
        //       video: {
        //         mandatory: {
        //           maxWidth: 320,
        //           maxHeight: 240
        //         }
        //       }
        //     },
        //     gotStream,
        //     error);
        //   }


    // Older browsers might not implement mediaDevices at all, so we set an empty object first
    if (navigator.mediaDevices === undefined) {
      navigator.mediaDevices = {};
    }

    // Some browsers partially implement mediaDevices. We can't just assign an object
    // with getUserMedia as it would overwrite existing properties.
    // Here, we will just add the getUserMedia property if it's missing.
    if (navigator.mediaDevices.getUserMedia === undefined) {
      navigator.mediaDevices.getUserMedia = function(constraints) {

        // First get ahold of the legacy getUserMedia, if present
        var getUserMedia = (navigator.getUserMedia ||
          navigator.webkitGetUserMedia ||
          navigator.mozGetUserMedia || navigator.mediaDevices.getUserMedia ||
            navigator.msGetUserMedia);

        // Some browsers just don't implement it - return a rejected promise with an error
        // to keep a consistent interface
        if (!getUserMedia) {
          return Promise.reject(new Error('getUserMedia is not implemented in this browser'));
        }

        // Otherwise, wrap the call to the old navigator.getUserMedia with a Promise
        return new Promise(function(resolve, reject) {
          getUserMedia.call(navigator, constraints, resolve, reject);
        });
      }
    }

    navigator.mediaDevices.getUserMedia({ audio: false, video: true })
    .then(function(stream) {
      var video = document.querySelector('video');
      // Older browsers may not have srcObject
      video.src = window.URL.createObjectURL(stream);
      video.onloadedmetadata = function(e) {
        video.play();
      };
    })
    .catch(function(err) {
      alert(err.name + ": " + err.message);
    });




      function takePhoto() {
          if (filter) {
              canvasContext.drawImage(video, 0, 0, 400, 320);
              var element = document.createElement("img");
              var im = canvas.toDataURL('image/png');
              element.style.boxshadow = "2px 2px 2px #888888";
              element.style.padding = "10px";
              element.style.backgroundColor = "white";
              element.style.filter = video.style.filter;
              element.style.webkitFilter = video.style.webkitFilter;
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
      }

        function ffilter(event) {
          document.getElementById("photoButton").disabled = false;
          document.getElementById("photoButton").addEventListener('click', takePhoto);

            filter = event.target.id;

            if (filter != oldfilter) {
                if (oldfilter)
                {
                  var test = document.getElementById('ffff' + oldfilter);
                  document.getElementById("video-box").removeChild(test);
                }
                var test = document.createElement("img");
                test.src = filter;
                test.id = 'ffff' + filter;
                test.style.top = 3;
                test.style.right = 11;

                // if (test.src == null)
                // {
                  // test.style.visibility = "hidden";
                // }
                if (test.id == "ffff")
                {
                  test.style.display = "none";

                }
                document.getElementById("video-box").appendChild(test);
                oldfilter = filter;
            }
        }

         var label = document.getElementsByTagName('LI');
        for (var i = 0; i < label.length; i++) {
            label[i].onclick = ffilter;
        }


      var draggedElement;
      var x, y, z = 0;

      function dragStart(e) {
        draggedElement = e.target;
        x = e.clientX - draggedElement.offsetLeft;
        y = e.clientY - draggedElement.offsetTop;
        e.dataTransfer.setDragImage(draggedElement, x, y);
      }
      function drop(e) {
        z++;
        // draggedElement.style.left = (e.clientX - x) + "px";
        // draggedElement.style.top = (e.clientY - y) + "px";
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

      // window.onload = start;
      // document.getElementById("photoButton").addEventListener('click', takePhoto);

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
        return null;
      };

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
    // } else {
      // document.getElementById("photoButton").disabled = true;

      // alert("Sorry, you can't capture video from your webcam in this web browser. Try the latest desktop version of Firefox, Chrome or Opera.");
    // }
  })();

function submitForm(oFormElement) {
    var xhr = new XMLHttpRequest();
    xhr.onload = function () {
        var element = document.getElementById("message");
        var resp = this.responseText;
        // console.log(resp);
        if ((resp == 'No file selected') || (resp == 'No filter selected') || (resp == 'Wrong file format') || (resp == 'Too large file') || (resp == 'Bad filter')) {
            alert(resp);
            document.getElementById("select").innerHTML = "Choose file";
            return;
        }
        else {
            if (filter) {
                var img = document.createElement("img");
                img.src = resp.split("&")[0];

                XXX(img, resp.split("&")[1]);

                element.innerHTML = "SUCCESS!!";
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
        fform.append("filter", filter);
        xhr.send(fform);
        oFormElement.reset();
        return false;
    }


function func(){
    document.getElementById("message").innerHTML="";
    document.getElementById("select").innerHTML = "Choose file";
}

function display_name() {
    document.getElementById("select").innerHTML = document.getElementById('file').value.replace(/.*\\/g, "");
}
