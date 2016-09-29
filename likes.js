function like() {
    var xhr = new XMLHttpRequest();
    // var btn = document.getElementById("BUTTON");

    if (this.style.color == ''){
    // if (this.innerHTML == 'like') {
    //     this.innerHTML = 'like';
        this.style.color = 'rgb(119, 139, 166)';

    }
    else{
        // this.innerHTML = 'like';
        this.style.color = '';
        console.log(this.id);
        // document.getElementById(this.id).disabled = '';

    }
    xhr.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
        console.log(this.responseText);
        }
    };
    xhr.open("POST", "likes.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("id=" + this.id);
}

function over_like(){
    this.style.textDecoration='underline';
}

function out_like(){
    this.style.textDecoration='none';
}

function likes_image(img, id){
    var but = document.createElement("BUTTON");
    var img_like = document.createElement("img");
    img_like.src = "./images/like.png";
    img_like.width = "15";
    img_like.height = "15";
    but.id = id;
    but.innerHTML = 'like';
    but.onmouseover = over_like;
    but.onmouseout = out_like;

    // document.getElementById(but.id).className.add("like_button");
    but.idName="like_button"; // find a way to add css separated from js in .css
    but.style.background = "none";
    but.style.border= "none";
    but.style.padding = "0 !important";
    but.style.font= "inherit";
    but.cursor = "pointer";
    but.style.outline = "none";
    // but.style.textDecoration.hover = "underline";
    but.style.outlineOffset = "0";

    but.onclick = like;
    img.parentElement.insertBefore(img_like, img);
    img.parentElement.insertBefore(but, img);

}