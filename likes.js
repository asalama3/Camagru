function like(){
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
        tmp = this.responseText;

        }
        else{
            // error
        }
    };
    xhr.open("POST", "likes.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("id=" + this.id);
}

function like_image(img, id){
    var but = document.createElement("BUTTON");
    but.innerHTML = 'Like';
    but.id = id;
    but.onclick = like;
    img.parentElement.insertBefore(but, img);
}