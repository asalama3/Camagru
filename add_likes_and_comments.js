function add_info(img, owner){
var child = document.createElement("span");
    child.innerHTML = owner;
    child.style.display= "block";
    child.style.float="left";

    img.parentElement.appendChild(child, img);

}
