function getVideojuegos(nombre) {
  const promise = fetch(`${urlJuegos}${nombre}`);
  promise
    .then((response) => response.text())
    .then((data) => {
      mostrarDatos(data);
    });
}

function mostrarDatos(datos) {
  let juegos = JSON.parse(datos);
  console.log(juegos);
  juegos.results.forEach((juego) => {
    let card = ` <div class="juego">
            <img src="${juego.background_image}"">
            <div class="titulo">${juego.name}</div>
            <div class="genero">${juego.genres[0]?.name}</div>
            <div class="plataforma">${generarPlataformas(juego)}</div>
            <div class="desarrollador">${juego.desarrollador}</div>
            <div class="anno">${juego.esrb_rating?.name}</div>
        </div>`;
    document.querySelector("#juegos").innerHTML += card;
  });
}
function mostarPaginaError(error) {}
document.querySelector("#buscar").addEventListener("click", (e) => {
  let nombre = document.querySelector("#nombre").value;
  document.querySelector("#juegos").innerHTML = "";
  getVideojuegos(nombre);
});

function generarPlataformas(juego) {
  if (!Array.isArray(juego.platforms)) {
    return "Plataformas desconocidas";
  }
  return juego.platforms
    .map((objeto) => objeto?.platform?.name)
    .filter((name) => name)
    .join(", ");
}
let urlPeliculas = "https://www.omdbapi.com/?apikey=fbdb846b&s=";
let urlJuegos =
  "https://api.rawg.io/api/games?key=f2a5c6418f9c4d67b53f6707a745f97a&search=";
