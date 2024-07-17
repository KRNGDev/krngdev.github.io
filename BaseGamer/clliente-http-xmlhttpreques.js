

function getVideojuegos(url,port,recurso){
    const client = new XMLHttpRequest();

    client.addEventListener("readystatechange",()=>{
        const isDone = client.readyState===4;
        const isOk= client.status ===200;

        if(isDone&& isOk){
            mostrarDatos(client.responseText );
        }else if (isDone && !isOk){
            mostarPaginaError(client.status);
        }
    });

    client.open("GET",`${url}:${port}/${recurso}`);
    client.send();
}


function mostrarDatos(datos){
    let juegos=JSON.parse(datos);
    juegos.forEach(juego => {
        let card= ` <div class="juego">
            <img src="${juego.imagen}"">
            <div class="titulo">${juego.titulo}</div>
            <div class="genero">${juego.genero}</div>
            <div class="plataforma">${juego.plataformas}</div>
            <div class="desarrollador">${juego.desarrollador}</div>
            <div class="anno">${juego.anno}</div>
        </div>`;
        document.querySelector("#juegos").innerHTML+=card;
    });
    
}
function mostarPaginaError(error){

}

getVideojuegos("http://localhost",5500,"/ejercicio021_superejercicio/datos.json");