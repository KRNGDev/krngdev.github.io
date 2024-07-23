function crearCard(
  imagen,
  titulo,
  direccion,
  codPostal,
  subCategoria,
  descripcion
) {
  //<div class="monumento">
  let divMonumento = document.createElement("div");
  divMonumento.classList.add("monumento");
  document.querySelector(".contenedor").appendChild(divMonumento);

  //<div class="imagen">
  let divImagen = document.createElement("div");
  divImagen.classList.add("imagen");
  divMonumento.appendChild(divImagen);

  //<img src="../ejercicio028_restaurante/imagen/r1.jpg"
  let imgFoto = document.createElement("img");

  imgFoto.src = imagen === null ? "/imagen/null.webp" : imagen;
  imgFoto.alt = "Monumento";
  divImagen.appendChild(imgFoto);

  //<ul class="datos">
  let divDatos = document.createElement("div");
  divDatos.classList.add("datos");
  divMonumento.appendChild(divDatos);

  // <li><h2>Nombre</h3></li>
  let liNombre = document.createElement("li");
  divDatos.appendChild(liNombre);
  let h2Nombre = document.createElement("h2");
  h2Nombre.appendChild(document.createTextNode(titulo));
  liNombre.appendChild(h2Nombre);
  //  <li><h4>direccion</h4></li>
  let liDireccion = document.createElement("li");
  divDatos.appendChild(liDireccion);
  let h4Direccion = document.createElement("h4");
  h4Direccion.appendChild(document.createTextNode(direccion));
  liNombre.appendChild(h4Direccion);

  //<li>Subcategoria</li>
  let liSubcategoria = document.createElement("li");
  liSubcategoria.appendChild(document.createTextNode(subCategoria));
  divDatos.appendChild(liSubcategoria);

  //<li>28043</li>
  let liCodPostal = document.createElement("li");
  liCodPostal.appendChild(document.createTextNode(codPostal));
  divDatos.appendChild(liCodPostal);

  //<li><fieldset><legend>Descripcion</legend>Obra del arquitecto Desiderio Pernas, es una gran plataforma sobre la que están situadas tres anclas de navíos hundidos en la Batalla de Rande, librada en la Ría de Vigo en 1702 entre la armada anglo-holandesa y una flota  hispana y francesa.</fieldset></li>
  let liDescripcion = document.createElement("li");
  divDatos.appendChild(liDescripcion);
  let fieldDescripcion = document.createElement("fieldset");
  fieldDescripcion.appendChild(document.createTextNode(descripcion));
  liDescripcion.appendChild(fieldDescripcion);
  let legendDescripcion = document.createElement("legend");
  legendDescripcion.appendChild(document.createTextNode("Descripcion"));
  fieldDescripcion.appendChild(legendDescripcion);
}
