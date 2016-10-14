function menu() {
    var x = document.getElementById("myTopnav");
    if (x.className === "topnav") {
        x.className += " responsive";
        x.style.overflow="hidden";
    } else {
        x.className = "topnav";
        x.style.overflow="visible";
    }
}
