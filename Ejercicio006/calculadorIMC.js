

function calcularIMC(kg, cm){
    let imc=kg/((cm/100)**2);

    
    return imc.toFixed(2);
}
function resultado(imc){
    if(imc<=18){
        return'Come mas estas muy flaco';
    }else if(imc>=28){
        return'Deja de traragar que vas a explotar';
    }else{
        return'Sigue asi mozalbete';
    }
}