function like(count, but, id_image) {
    var xhr = new XMLHttpRequest();

    // var test = document.getElementById(id_image).children;

    if (but.style.color == ''){
        but.style.color = 'rgb(119, 139, 166)';
    }
    else{
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
    xhr.send("id=" + id_image);
}

function over_like(){
    this.style.textDecoration='underline';
}

function out_like(){
    this.style.textDecoration='none';
}

function comment_img(comment, id_image){
  console.log(id_image);
  window.location.assign("comment.php?id_image=" + id_image);
}

function add_design(but, id_image){
  // console.log(id_image);
  but.id = "test_" + id_image;
  document.getElementById(but.id).classList.add("mystyle");
}

// function get_image_id_for2(element) {
//   while(element.class !== 'imageposition') {
//     element = element.parent;
//   }
//   return element.id;
// }

function get_image_id_for( element ) {
  if( element.className === "imageposition" ) {
    console.log(element.className);

     return element.id;
  } else {
    // console.log(element.parentElement);
     return get_image_id_for( element.parentElement );
  }
}

function likes_image(img, liked, nbr_likes, id, nbr_comments){
    var but = document.createElement("BUTTON");
    var img_like = document.createElement("img");
    var count = document.createElement("span");
    var comment = document.createElement("BUTTON");
    var img_comment = document.createElement("img");
    var nbr_com = document.createElement("span");

    if (liked)
    {
      but.style.color = 'rgb(119, 139, 166)';
    }
    else{
      but.style.color = '';
    }
    if (nbr_likes)
    {
      count.innerHTML = nbr_likes;
    }
    else{
      count.innerHTML = "";
    }
    if (nbr_comments)
    {
      nbr_com.innerHTML = nbr_comments;
    }
    else{
      nbr_com.innerHTML = "";
    }

    img_like.src = "./images/like.png";
    img_like.width = "15";
    img_like.height = "15";

    but.innerHTML = 'Like';
    but.onmouseover = over_like;
    but.onmouseout = out_like;

    document.addEventListener("DOMContentLoaded", function() {
      add_design(but, get_image_id_for(but));
    });

    but.addEventListener('click', function(){
        like(count, but, get_image_id_for(but));
    });

    count.style.margin = 3;

    comment.style.border = "none";
    comment.style.background = "none";
    comment.style.font= "inherit";
    comment.cursor = "pointer";
    comment.style.outline = "none";
    comment.innerHTML = 'Comment';
    comment.onmouseover = over_like;
    comment.onmouseout = out_like;

    img_comment.src = "./images/bubble.png";
    img_comment.width = "15";
    img_comment.height = "15";

    comment.addEventListener("click", function(){
      comment_img(comment, get_image_id_for( comment ));
    });


    img.parentElement.insertBefore(img_like, img);
    img.parentElement.insertBefore(but, img);
    img.parentElement.insertBefore(count, img);
    img.parentElement.insertBefore(img_comment, img);
    img.parentElement.insertBefore(comment, img);
    img.parentElement.insertBefore(nbr_com, img);
}
