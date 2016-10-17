function add_design(but, id_image){
  // console.log(id_image);
  but.id = "test_" + id_image;
  document.getElementById(but.id).classList.add("mystyle");
}

function get_image_id_for( element ) {
  if( element.className === "imageposition" ) {
    console.log(element.className);

     return element.id;
  } else {
    // console.log(element.parentElement);
     return get_image_id_for( element.parentElement );
  }
}
