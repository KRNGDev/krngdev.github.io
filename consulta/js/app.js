const URL = "https://datos.vigo.org/";
const RESOURCE = "data/turismo/poi-monumentos-es.json";

doGetHTTPRequest(URL, RESOURCE, procesarDatosJson, procesarError);
var datosSevidor;

function procesarDatosJson(texto) {
  datosSevidor = JSON.parse(texto);
  console.log(datosSevidor);
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
}

function procesarError(err) {
  console.log(err);
}

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
