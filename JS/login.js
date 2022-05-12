function vacios(e){
    let camposVacios=0;

    if (document.querySelector("#txt_usuario").value==""){
        document.querySelector("#txt_usuario").classList.add("border-danger");
        camposVacios=1;
        let error= document.querySelector("#error");
        error.innerText="Olvidaste introducir algún campo";
        error.classList.add("text-danger");
        e.preventDefault(); //Cortamos el envio del formulario
    }
    if (document.querySelector("#txt_password").value==""){
        document.querySelector("#txt_password").classList.add("border-danger");
        camposVacios=1;
        let error= document.querySelector("#error");
        error.innerText="Olvidaste introducir algún campo";
        error.classList.add("text-danger");
        e.preventDefault(); //Cortamos el envio del formulario
    }

    return camposVacios;
}



document.addEventListener("DOMContentLoaded", () => {
    document.querySelector("#entrar").addEventListener("click", (e) => {
      
    error=vacios(e); //Valida los vacios antes de enviar
    });
});