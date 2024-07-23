const URL = "https://datos.vigo.org/";
const RESOURCE = "data/turismo/poi-lugares-gl.json";

doGetHTTPRequest(URL, RESOURCE, procesarDatosJson, procesarError);

var datosSevidor;
var datoSelect = [];

function procesarDatosJson(texto) {
  datosSevidor = JSON.parse(texto);

  datosSevidor.forEach((dato) => {
    crearCard(
      dato.image_uri,
      dato.title,
      dato.address,
      dato.postcode,
      dato.subcategoria,
      dato.description
    );
  });
  cargarSelet();
}

function procesarError(err) {
  console.log(err);
}

//filtrar por subcategoria
document.querySelector("#categoria").addEventListener("change", (evento) => {
  let texto = evento.target.value;
  console.log(texto);
  let categoriasFiltradas = datosSevidor.filter((dato) => {
    return dato.subcategoria && dato.subcategoria.includes(texto);
  });
  document.querySelector(".contenedor").innerHTML = "";
  console.log(texto);
  categoriasFiltradas.forEach((dato) => {
    crearCard(
      dato.image_uri,
      dato.title,
      dato.address,
      dato.postcode,
      dato.subcategoria,
      dato.description
    );
  });
});

//Filtra por nombre
document.querySelector("#iFiltro").addEventListener("keyup", () => {
  let texto = document.querySelector("#iFiltro").value;
  let datosFiltrados = datosSevidor.filter((dato) => {
    return dato.title.includes(texto);
  });
  document.querySelector(".contenedor").innerHTML = "";
  datosFiltrados.forEach((dato) => {
    crearCard(
      dato.image_uri,
      dato.title,
      dato.address,
      dato.postcode,
      dato.subcategoria,
      dato.description
    );
  });
});

function agregarSelect(array) {
  let select = document.querySelector("#categoria");
  array.forEach((dato) => {
    let option = document.createElement("option");
    option.value = dato;
    option.appendChild(document.createTextNode(dato));
    select.appendChild(option);
  });
}

function cargarSelet() {
  datosSevidor.forEach((dato) => {
    if (!datoSelect.includes(dato.subcategoria)) {
      datoSelect.push(dato.subcategoria);
    }
  });
  agregarSelect(datoSelect);
}

console.log(datoSelect);
