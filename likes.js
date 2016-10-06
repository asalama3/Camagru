function like(count, but) {
    var xhr = new XMLHttpRequest();

    // console.log(but);
    // console.log(count);

    if (but.style.color == ''){
    // if (this.innerHTML == 'like') {
    //     this.innerHTML = 'like';
        but.style.color = 'rgb(119, 139, 166)';

    }
    else{
        // this.innerHTML = 'like';
        but.style.color = '';
      //  console.log(but.id);
        // document.getElementById(this.id).disabled = '';

    }
    xhr.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
        console.log(this.responseText);
        // check if count is a number
        //     console.dir(but.firstElementChild);
            count.innerHTML = this.responseText;

        }
    };
    xhr.open("POST", "likes.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("id=" + but.id);
}

function over_like(){
    this.style.textDecoration='underline';
}

function out_like(){
    this.style.textDecoration='none';
}

function comment_img(){
  window.location.assign("comment.php");
  // this.background = 'red';
  // return false;
}

function likes_image(img, liked, nbr_likes, id){
    var but = document.createElement("BUTTON");
    var img_like = document.createElement("img");
    var count = document.createElement("span");
    var comment = document.createElement("BUTTON");
    var img_comment = document.createElement("img");
    // console.log(liked);
    if (liked)
    {
      but.style.color = 'rgb(119, 139, 166)';
    }
    else{
      // console.log(but);
      but.style.color = '';
    }
    if (nbr_likes)
    {
      count.innerHTML = nbr_likes;
    }
    else{
      count.innerHTML = "";
    }
    // count.style.backgroundColor = 'red';
    img_like.src = "./images/like.png";
    img_like.width = "15";
    img_like.height = "15";
    but.id = id;
    but.innerHTML = 'Like';
    but.onmouseover = over_like;
    but.onmouseout = out_like;
    // document.getElementById(but.id).className.add("like_button");
    // but.idName="like_button"; // find a way to add css separated from js in .css
    but.style.background = "none";
    but.style.border= "none";
    but.style.padding = "0 !important";
    but.style.font= "inherit";
    but.cursor = "pointer";
    but.style.outline = "none";
    but.style.textDecoration.hover = "underline";
    but.style.outlineOffset = "0";
        // var el = document.getElementById(id);
        // el.classList.add("mystyle");
    but.addEventListener('click', function(){
        like(count, but);
    });

    count.style.margin = 3;
    // comment.id = 'test';
    comment.innerHTML = 'Comment';
    comment.style.border = "none";
    comment.style.background = "none";
    comment.style.font= "inherit";
    comment.cursor = "pointer";
    comment.style.outline = "none";

    img_comment.src = "./images/bubble.png";
    img_comment.width = "15";
    img_comment.height = "15";
    comment.onmouseover = over_like;
    comment.onmouseout = out_like;
    // comment.addEventListener('click', function(){
      // comment_img(id);
    // });
    comment.addEventListener("click", comment_img);

    // comment.onclick = comment_img;

    img.parentElement.insertBefore(img_like, img);
    img.parentElement.insertBefore(but, img);
    img.parentElement.insertBefore(count, img);
    img.parentElement.insertBefore(img_comment, img);
    img.parentElement.insertBefore(comment, img);

}

// add count total of all likes without asking the sessionid and add it to another count (sql request) to the function likes_image
// make button colored if the count_nbr is greater than 1 means its liked already by the user (sessionid)
// on click make sure the counttotal is adding up correctly
