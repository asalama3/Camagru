function like() {
    var xhr = new XMLHttpRequest();
    // var btn = document.getElementById("BUTTON");

    if (this.innerHTML == 'like') {
        // this.innerHTML = 'Unlike';
        this.style.color = '';

    }
    else {
        this.innerHTML = 'like';
        this.style.color = 'rgb(88, 144, 255)';
        console.log(this.id);
        document.getElementById(this.id).disabled = '';

    }
    xhr.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
        console.log(this.responseText);

        }
        else{
            console.log('errorrrr');
        }
    };
    xhr.open("POST", "likes.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("id=" + this.id);
}

function like_image(img, id){
    var but = document.createElement("BUTTON");
    var img_like = document.createElement("img");

    img_like.src = "./images/like.png";
    img_like.width = "15";
    img_like.height = "15";

    but.innerHTML = 'Like';
    // but.idName="like_button"; // find a way to add css separated from js in .css
    but.style.background = "none";
    but.style.border= "none";
    but.style.padding = "0 !important";
    but.style.font= "inherit";
    but.cursor = "pointer";
    but.style.outline = "none";
    // but.style.textDecoration = "underline";
    but.style.outlineOffset = "0";

    but.id = id;
    but.onclick = like;
    img.parentElement.insertBefore(img_like, img);
    img.parentElement.insertBefore(but, img);

}