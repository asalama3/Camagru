    var WebCamVideo = function(video, callback) {
        this.videoElement = video;
        var self = this;
        if (navigator.getUserMedia) {
            navigator.getUserMedia({ video: true }, function(stream) {
                self.videoElement.src = stream;
                self.videoElement.play();
            }, callback);
        } else if (navigator.webkitGetUserMedia) {
            navigator.webkitGetUserMedia({ video: true }, function(stream) {
                self.videoElement.src = window.webkitURL.createObjectURL(stream);
                self.videoElement.play();
            }, callback);
        }
    };
    WebCamVideo.prototype.getImage = function(type, width, height) {
        var type   = type || 'image/png',
            width  = width || this.videoElement.width,
            height = height || this.videoElement.height;
        var canvas  = document.createElement('canvas'),
            context = canvas.getContext('2d');
        canvas.width  = width;
        canvas.height = height;
        context.drawImage(this.videoElement, 0, 0, width, height);
        var image = new Image;
        image.src = canvas.toDataURL(type);
        return image;
    };

    window.addEventListener('DOMContentLoaded', function() {
        // Grab video and button elements.
        var video     = document.getElementById('video'),
            photo     = document.getElementById('photo'),
            container = document.getElementById('container');
        // Initliase the webcam video stream.
        var webcam = new WebCamVideo(video, function(error) {
            console.alert('Video Capture Error: ' + error.code);
        });
        // Capture an image from the webcam video stream.
        photo.addEventListener('click', function() {
            var image = webcam.getImage();
            image.style.width = '50%';

            if (container.children.length > 0) {
                container.insertBefore(image, container.firstChild);
            } else {
                container.appendChild(image);
            }
        });
        // Apply CSS filters to images.
        var filters = document.querySelectorAll('#filters > span');
        [].forEach.call(filters, function(span) {
          span.addEventListener('click', function() {
            var filter = span.innerHTML;
              style  = '';
            switch (filter) {
              case 'Sepia':
                style = './images/chien.png';
                break;
              case 'Grayscale':
                style = 'grayscale(100%)';
                break;
              case 'Brightness':
                style = 'brightness(0.35)';
                break;
              case 'Contrast':
                style = 'contrast(140%)';
                break;
              default:
                style = '';
            }
            var images = document.querySelectorAll('#container > img');
            [].forEach.call(images, function(img) {
              console.log(img);
              img.style.webkitFilter = style;
            });
          });
        });
    }, false);
