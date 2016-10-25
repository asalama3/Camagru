function delete_image() {
    var todel = this.parentElement;
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            todel.parentNode.removeChild(todel);
            // console.log(this.responseText);
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


    newdiv.style.width="20%";
    newdiv.style.display="inline-block";
    newdiv.style.margin="1%";
    newdiv.style.minWidth="400px";
    newdiv.style.textAlign="center";
    element.style.boxshadow = "2px 2px 2px #888888";
    element.style.padding = "10px";
    element.style.backgroundColor = "white"; 


    newdiv.appendChild(element);
    newdiv.appendChild(del);
    var currentdiv = document.getElementById("stack");
    currentdiv.insertBefore(newdiv, currentdiv.childNodes[0]);
}
