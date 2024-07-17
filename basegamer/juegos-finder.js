const API_KEY = "f2a5c6418f9c4d67b53f6707a745f97a";
const SERVER_URL = "https://api.rawg.io/api";
const PORT = 443;

document.querySelector("#buscar").addEventListener("click", (e) => {
  document.querySelector("#juegos").innerHTML = "";
  getVideojuegos();
});

function getVideojuegos() {
  const tituloBuscado = document.querySelector("#nombre").value;
  doGetHTTPRequest(
    SERVER_URL,
    `games?key=${API_KEY}&search=${tituloBuscado}`,
    processData,
    processError
  );
}

function processData(data) {
  const juegos = JSON.parse(data);
  juegos.results.forEach((juego) => {
    generarCardJuego(juego);
  });
}

function generarCardJuego(juego) {
  document.querySelector("#juegos").innerHTML += ` <div class="juego">
            <img src="${juego.background_image}"">
            <div class="titulo">${juego.name}</div>
            <div class="genero">${juego.genres[0]?.name}</div>
            <div class="plataforma">${generarPlataformas(juego)}</div>
            <div class="desarrollador">${juego.desarrollador}</div>
            <div class="anno">${juego.esrb_rating?.name}</div>
        </div>`;
}

function generarPlataformas(juego) {
  if (!Array.isArray(juego.platforms)) {
    return "Plataformas desconocidas";
  }
  return juego.platforms
    .map((objeto) => objeto?.platform?.name)
    .filter((name) => name)
    .join(", ");
}
function processError(error) {
  console.log(error);
}
