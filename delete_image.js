function delete_image() {
    var todel = this.parentElement;
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            todel.parentNode.removeChild(todel);
        }
        else{
            // error
        }
    };
    xhr.open("POST", "delete_image.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("id=" + this.id);
}

function XXX(element, id){
    var newdiv = document.createElement("DIV");
    var del = document.createElement("BUTTON");
    del.innerHTML = 'Delete Picture';
    del.id = id;
    del.onclick = delete_image;


    // newdiv.style.width="30";


    newdiv.appendChild(del);
    newdiv.appendChild(element);
    var currentdiv = document.getElementById("stack");
    currentdiv.insertBefore(newdiv, currentdiv.childNodes[0]);
}

// window.onload=function alertlog(){
//     window.alert("Please log in first to see this page");
//     location="signin.php";
//
//     return(false);
// }
