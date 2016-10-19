function get_image_id_for_img( element ) {
  if( element.className === "comment_image" ) {
    console.log(element.className);
    console.log(element);
     return element.id;
  } else {
    // console.log(element.parentElement);
     return get_image_id_for_img( element.parentElement );
  }
}

function add_info(img, liked, nbr_likes, id, nbr_comments, owner){
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

    // window.addEventListener("DOMContentLoaded", function() {
    //   add_design(but, get_image_id_for_img(but));
    // });


      but.addEventListener('click', function(){
        like(count, but, get_image_id_for_img(but))
      });

    count.style.margin = 3;

    comment.style.border = "none";
    comment.style.background = "none";
    comment.style.font= "inherit";
    comment.style.outline = "none";
    comment.innerHTML = 'Comment';

    img_comment.src = "./images/bubble.png";
    img_comment.width = "15";
    img_comment.height = "15";

var child = document.createElement("span");
    child.innerHTML = owner;
    child.style.display= "block";
    // child.style.padding= "30";
    child.style.float="left";
    img.parentElement.appendChild(img_like, img);
    img.parentElement.appendChild(but, img);
    img.parentElement.appendChild(count, img);
    img.parentElement.appendChild(img_comment, img);
    img.parentElement.appendChild(comment, img);
    img.parentElement.appendChild(nbr_com, img);
    img.parentElement.appendChild(child, img);

}
