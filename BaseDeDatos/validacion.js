document,addEventListener("DOMContentLoaded", function(){
    const form = document.getElementById("formulario-registro");
    
    form.addEventListener("submit", function(event){

        if(!validarFormulario()){
            event.preventDefault();
        }

    });
});

function validarFormulario(){
    const nombre = document.getElementById("nombre");
    const email = document.getElementById("email");
    const pasword =document.getElementById("password");

    if(nombre.value.trim()===""){
        alert("Por favor, pon bien el nombre , inutil")
        nombre.focus();
        return false;
    }
    if(nombre.value.trim()!=="Karnag"){
        alert("Por favor, pon bien el nombre , inutil")
        nombre.focus();
        return false;
    }
    if(email.value.trim()===""){
        alert("Por favor, pon bien el email , inutil")
        email.focus();
        return false;
    }
    
    const regexEmail= /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    
    if(!regexEmail.test(email.value)){
        alert("Por favor, no seas incompetente y pon bien el email valido");
        email.focus();
        return false;
    }
    if(pasword.value.trim().length<8){
        alert("Por favor, pon bien el pasword tiene que contener al menos 8 caracteres , inutil")
        pasword.focus();
        return false;
    }
    if(pasword.value.trim() !=="Karnag.86"){
        alert("Contraseña incorrecta")
        pasword.focus();
        return false;
    }
    return true;
}