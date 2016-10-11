function get_image_id( element ) {
if (element.className == "comment_image")
{
  return element.id;
}
else {
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

  // comment.style.color = "red";
  // comment.style.backgroundColor = "red";

  xhr.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
      console.log(this.responseText);
      document.getElementById("comment").value = "";
      comment.innerHTML = this.responseText;
      console.log(comment);
      test.parentElement.insertBefore(comment, test);

    }
}
  xhr.open("POST", "save_and_post_comment.php", true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send("comment=" + content + "&id=" + id_image);

}

var toto = document.getElementById("submit_comment");
// console.log(toto);
toto.addEventListener("click", function(){
  LeaveComment(get_image_id(toto));
});

function myFunction() {
    var x = document.getElementById("myTopnav");
    if (x.className === "topnav") {
        x.className += " responsive";
    } else {
        x.className = "topnav";
    }
}
