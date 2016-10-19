function get_image_id( element ) {
  if (element.className == "comment_image")
  {
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
      document.getElementById("comment").value = "";
      comment.innerHTML = this.responseText;
      console.log(comment);

      // add user name with session id and ":"//
      test.parentElement.insertBefore(comment, test);
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