function get_image_id( element ) {
  if (element.className == "tryout")
  {
    console.log(element.id);
    return element.id;
  }
  else
  {
    return get_image_id(element.parentElement);
  }
}

function LeaveComment( id_image ){
  var comment = document.createElement("div");
  var test = document.getElementById("comment");

  var xhr = new XMLHttpRequest();
  var content = document.getElementById("comment").value;
  console.log(content); //ca fonctionne
  console.log(id_image);
  if (content){
  xhr.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
      console.log(this.responseText);
      // document.getElementById("comment").value = "";
      // comment.innerHTML = this.responseText;
      // console.log(comment);


      data = JSON.parse(xhr.responseText);
      console.log("comment : " + data['comment']);
      console.log("user : " + data['username']);
      console.log("nbr_com : " + data['nbr_comments']);

      comment.innerHTML = "<a style='font-weight: bold; font-size: 20px; margin-top: 10px; display: inline-block;'>" + data['username'] + "</a>" + ":" + "<a style='font-size: 20px;'>" + data['comment'] + "</a>";
      // get count from function like in add likes and comments.js
      test.parentElement.insertBefore(comment, test);
      document.getElementById("comment").value = "";
    }
  }
  xhr.open("POST", "save_and_post_comment.php", true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send("comment=" + content + "&id=" + id_image);

  }
  else
  {
    alert("Please write a comment!");
    return ;
  }
}

var toto = document.getElementById("submit_comment");
// console.log(toto);
toto.addEventListener("click", function(){
  LeaveComment(get_image_id(toto));
});
