function like(count, but, id_image) {
    var xhr = new XMLHttpRequest();


    xhr.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
        console.log(this.responseText);
        // check if count is a number
        //     console.dir(but.firstElementChild);
        if (this.responseText === "please sign in")
        {
          alert(this.responseText);
        }
        else{
          count.innerHTML = this.responseText;
          if (but.style.color == ''){
              but.style.color = 'rgb(119, 139, 166)';
              but.outlineoffset = '0';

          }
          else{
              but.style.color = '';
            //  console.log(but.id);
          }
          }
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

function likes_image(img, liked, nbr_likes, id, nbr_comments, owner){
    var but = document.createElement("BUTTON");
    var img_like = document.createElement("img");
    var count = document.createElement("span");
    var comment = document.createElement("BUTTON");
    var img_comment = document.createElement("img");
    var nbr_com = document.createElement("span");
    var owner_obj = document.createElement("span");

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


    img.style.cursor="pointer";
    img.addEventListener("click", function(){
      comment_img(comment, get_image_id_for( comment ));
    });

    img.parentElement.appendChild(img_like, img);
    img.parentElement.appendChild(but, img);
    img.parentElement.appendChild(count, img);
    img.parentElement.appendChild(img_comment, img);
    img.parentElement.appendChild(comment, img);
    img.parentElement.appendChild(nbr_com, img);
    var child = document.createElement("span");
    child.innerHTML = owner;
    child.style.display= "block";
    // child.style.padding= "30";
    child.style.float="left";
    img.parentElement.appendChild(child, img);
    // document.body.appendChild(owner);
}
