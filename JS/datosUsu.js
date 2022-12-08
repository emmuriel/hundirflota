function datosUsu(){
    let json = {
        peticion: 1,
      };
  
      fetch("UserData.php", {
        method: "POST",
        body: JSON.stringify(json),
        headers: {

          "Content-Type": "application/json",
        },
      })
        .then((response) => {
          if (response.status >= 200 && response.status < 300) {
            return Promise.resolve(response);
          }
          if (response.status == 404) {
              document.getElementById("lbl_error_usuario").innerHTML =
                "ERROR SERVIDOR";
              alert("error");
            }
          return Promise.reject(new Error(response.statusText));
  
        })
        .then((response) => response.json()) 
        .then((datos) => {
        // Agregar datos al Div
        let div=document.querySelector("#datosUsu");
        if (div.hasChildNodes()) {
          div.removeChild(div.childNodes[0]); //Elimina el elemento anterior si lo hubiera
        }
       
          let articulo=document.createElement("article");
            div.appendChild(articulo);

          // Agregar los datos del JSON al artículo -->
          let usu = document.createElement("p");
            usu.innerText = `Nombre de usuario: ${datos[0].nombre}`;
            articulo.appendChild(usu);
          let vict = document.createElement("p");
            vict.innerText = `Número de victorias: ${datos[0].victorias}`;
            articulo.appendChild(vict);
        
    })
        .catch((error) => {
          console.error(error);
          return null;
        });
}
document.addEventListener("DOMContentLoaded", () => {
  datosUsu(); //Visualizar datos de usuario
});