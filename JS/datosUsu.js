function limpiaError(){
  let input_cPwd = document.querySelector("#currency-pwd");
  let input_nPwd = document.querySelector("#new-pwd");
  let input_rPwd = document.querySelector("#repeat-new-pwd");
  let divError = document.querySelector("#div-error");

  if (divError.hasChildNodes()){
    console.log(divError);
    console.log(divError.hasChildNodes());
   divError.removeChild(divError.firstChild); //limpia mensaje
  }
  input_cPwd.setAttribute ("class", "form-control bg-light text-dark border-primary");
  input_nPwd.setAttribute ("class", "form-control bg-light text-dark border-primary");
  input_rPwd.setAttribute ("class", "form-control bg-light text-dark border-primary");
}

/*********************************************************************************/

function validaFormChangePassword(){
  limpiaError();

  let error=0;
  let input_cPwd = document.querySelector("#currency-pwd");
  let input_nPwd = document.querySelector("#new-pwd");
  let input_rPwd = document.querySelector("#repeat-new-pwd");
  let divError = document.querySelector("#div-error");
  let error_mssg = document.createElement("p");
  error_mssg.setAttribute("class", "text-danger");

  
  /**Error vacios */
  if (!input_cPwd.value){
    error=1;
    input_cPwd.setAttribute ("class", "form-control bg-light text-dark border-danger");
  }
  if (!input_nPwd.value){
    error=1;
    input_nPwd.setAttribute ("class", "form-control bg-light text-dark border-danger");
  }
  if (!input_rPwd.value){
    error=1;
    input_rPwd.setAttribute ("class", "form-control bg-light text-dark border-danger");
  }

  if (error==1) {
    error_mssg.innerText="El campo está vacio";
    divError.appendChild(error_mssg);
  }
  /** Error: password no coinciden */

  if (input_nPwd.value!=input_rPwd.value){
    error==1
    input_nPwd.setAttribute ("class", "form-control bg-light text-dark border-danger");
    input_rPwd.setAttribute ("class", "form-control bg-light text-dark border-danger");
    error_mssg.innerText="Las contraseñas no coinciden";
    divError.appendChild(error_mssg);
  }

  /** Error : password no válida */
  if(error==0){
    const regex = /^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{8,16}$/;

    if (!regex.test(input_nPwd.value)) {
      error=1;
      input_nPwd.setAttribute ("class", "form-control bg-light text-dark border-danger");
      input_rPwd.setAttribute ("class", "form-control bg-light text-dark border-danger");
      error_mssg.innerText="La contraseña debe tener al entre 8 y 16 caracteres, al menos un dígito, al menos una minúscula, al menos una mayúscula.";
      divError.appendChild(error_mssg);
    }
  }
  
  return error;
}


/*********************************************************************************/

function formPwd () {
  let divCard=document.querySelector("#card-body");
  if (divCard.hasChildNodes()) {
    divCard.removeChild(divCard.firstChild); //Elimina el elemento anterior si lo hubiera
  }
  let divBody = document.createElement("div"); //Div Body
  divBody.setAttribute("id", "divBody");
 

  let titleCard = document.createElement("h5"); //Card Title
  titleCard.setAttribute("class", "card-title");
  titleCard.innerHTML="<i class='fa-sharp fa-solid fa-key'> Cambiar password</i>";
  divBody.appendChild(titleCard);
  /* Crea el form */
  const formChange = document.createElement ("form");
  
  /* Crea los label e input  password */

  let divCpwd = document.createElement('div'); //Contraseña actual
  divCpwd.setAttribute('id', "divCpwd");
  divCpwd.setAttribute('class', "mb-3");
  
  let labelCpwd = document.createElement("label"); 
  labelCpwd.setAttribute("for", "currency-pwd");
  labelCpwd.setAttribute("class", "text-dark");
  labelCpwd.innerText="Contraseña actual : ";

  let inputCpwd = document.createElement("input");
  inputCpwd.setAttribute("type", "password");
  inputCpwd.setAttribute("class", "form-control bg-light text-dark border-primary");
  inputCpwd.setAttribute("name", "currency-pwd");
  inputCpwd.setAttribute("id", "currency-pwd");
  inputCpwd.setAttribute("autocomplete","new-password");

  inputCpwd.addEventListener('focus',()=>{
    inputCpwd.value="";
    inputCpwd.setAttribute("class", "form-control bg-light text-dark border-primary");
  });

  divCpwd.appendChild(labelCpwd);
  divCpwd.appendChild(inputCpwd);
  formChange.appendChild(divCpwd);


  let divNpwd = document.createElement('div'); //Nueva contraseña
  divNpwd.setAttribute('id', "divNpwd");
  divNpwd.setAttribute('class', "mb-3");
  
  let labelNpwd = document.createElement("label"); 
  labelNpwd.setAttribute("for", "new-pwd");
  labelNpwd.setAttribute("class", "text-dark");
  labelNpwd.innerText="Nueva contraseña : ";

  let inputNpwd = document.createElement("input");
  inputNpwd.setAttribute("type", "password");
  inputNpwd.setAttribute("class", "form-control bg-light text-dark border-primary");
  inputNpwd.setAttribute("name", "new-pwd");
  inputNpwd.setAttribute("id", "new-pwd");
  inputNpwd.setAttribute("autocomplete","new-password");

  inputNpwd.addEventListener('focus',()=>{
    inputNpwd.value="";
    inputNpwd.setAttribute("class", "form-control bg-light text-dark border-primary");
  });

  divNpwd.appendChild(labelNpwd);
  divNpwd.appendChild(inputNpwd);
  formChange.appendChild(divNpwd);

  let divRpwd = document.createElement('div'); //Repetir Nueva contraseña
  divRpwd.setAttribute('id', "divRpwd");
  divRpwd.setAttribute('class', "mb-3");
  
  let labelRpwd = document.createElement("label"); 
  labelRpwd.setAttribute("for", "new-pwd");
  labelRpwd.setAttribute("class", "text-dark");
  labelRpwd.innerText="Repite nueva contraseña : ";

  let inputRpwd = document.createElement("input");
  inputRpwd.setAttribute("type", "password");
  inputRpwd.setAttribute("class", "form-control bg-light text-dark border-primary");
  inputRpwd.setAttribute("name", "repeat-new-pwd");
  inputRpwd.setAttribute("id", "repeat-new-pwd");
  inputRpwd.setAttribute("autocomplete","new-password");

  inputRpwd.addEventListener('focus',()=>{
    inputRpwd.value="";
    inputRpwd.setAttribute("class", "form-control bg-light text-dark border-primary");
  });

  divRpwd.appendChild(labelRpwd);
  divRpwd.appendChild(inputRpwd);
  formChange.appendChild(divRpwd);

  let divError = document.createElement('div');   //div error
  divError.setAttribute('id', "div-error");
  divError.setAttribute('class', "form-text mb-3 text-danger");
  formChange.appendChild(divError);

  let changePwdBoton=document.createElement("button"); //Boton cambiar contraseña
  changePwdBoton.setAttribute('class', "btn btn-primary");
  changePwdBoton.type = 'button'; 

  changePwdBoton.innerText = 'Cambiar';
  changePwdBoton.addEventListener('click', ()=>{   //Listener boton cambiar contraseña
      let error =validaFormChangePassword();
      if (error==0){
       changePwd();
      }        
  });
  formChange.appendChild(changePwdBoton);
  divBody.appendChild(formChange);   //Añadir Form al divCard
  divCard.appendChild(divBody);
}


/*********************************************************************************/
function drawDatosUsu(datos){
  let divCard=document.querySelector("#card-body");
  if (divCard.hasChildNodes()) {
    divCard.removeChild(divCard.firstChild); //Elimina el elemento anterior si lo hubiera
  }

  let divBody = document.createElement("div"); //Div Body
  divBody.setAttribute("id", "divBody");

  let titleCard = document.createElement("h5"); //Card Title
  titleCard.setAttribute("class", "card-title");
  titleCard.innerHTML="<i class='fa-solid fa-user'>  Datos de usuario</i>";

  let articulo=document.createElement("article");
 

  // Agregar los datos del JSON al artículo -->
  let usu = document.createElement("p");
    usu.innerText = `Nombre de usuario: ${datos[0].nombre}`;
    articulo.appendChild(usu);
    let vict = document.createElement("p");
    vict.innerText = `Número de victorias: ${datos[0].victorias}`;
    articulo.appendChild(vict);

    /*let texto = document.createElement("p");
    texto.setAttribute("class", "text-primary");
    texto.innerText = "Opciones de contraseña ";
    articulo.appendChild(texto);*/

    let texto2 = document.createElement("p");
    texto2.setAttribute("class", "text-primary");
    texto2.innerText = "Cambiar contraseña";
    articulo.appendChild(texto2);


    let changePwdBoton=document.createElement("button");
    changePwdBoton.type = 'button'; 
    changePwdBoton.setAttribute('name', "btn-changePwd");
    changePwdBoton.setAttribute('id', "btn-changePwd");
    changePwdBoton.setAttribute('class', "btn btn-primary");
    changePwdBoton.innerText = 'Cambiar';
    changePwdBoton.addEventListener('click', ()=>{
      formPwd();        
    });
    divBody.appendChild(titleCard);
    divBody.appendChild(articulo);
    divBody.appendChild(changePwdBoton);
    divCard.appendChild(divBody);



}

/*********************************************************************************/

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
          drawDatosUsu(datos);
        
    })
        .catch((error) => {
          console.error(error);
          return null;
        });
}

/*********************************************************************************/

function changePwd(){
  const input_cPwd = document.querySelector('#currency-pwd');
  const input_nPwd = document.querySelector('#new-pwd');

  let json = {  //Request-body
      peticion: 2,
      cPwd: input_cPwd.value,
      nPwd: input_nPwd.value,
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
            document.getElementById("lbl_error_usuario").innerHTML ="ERROR SERVIDOR";
            alert("error");
          }
        return Promise.reject(new Error(response.statusText));

      })
      .then((response) => response.json()) 
      .then((datos) => {

        if (datos[0].error==0){ //Pwd cambiada
          let divCardBody=document.querySelector("#card-body");
          if (divCardBody.hasChildNodes()) {
            divCardBody.removeChild(divCardBody.firstChild); //Elimina formulario
          }
            let divBody=document.createElement('div');
            divBody.setAttribute('id','divBody');
            
            let success_mssg=document.createElement("p");
            success_mssg.innerText = "Tu contraseña ha sido actualizada.";
            divBody.appendChild(success_mssg);
            let okBoton=document.createElement("button");
            okBoton.type = 'button';
            okBoton.setAttribute("class","btn btn-primary");
            okBoton.innerText = 'ok!';
            okBoton.addEventListener('click', ()=>{
              datosUsu();        
            });
            divBody.appendChild(okBoton);
            divCardBody.appendChild(divBody);

        } else if (datos[0].error==4 ||datos[0].error==1){  //Error contraseñas no coinciden

          let divError=document.querySelector("#div-error");  //Elimina divError
          if (divError.hasChildNodes()) {
            divError.removeChild(divError.firstChild);
          }
          
          input_cPwd.setAttribute("class","form-control bg-light text-dark border-danger" )
          let error_mssg=document.createElement("span");
          error_mssg.innerText= "Error Contraseña actual erronea";
          divError.appendChild(error_mssg);
        }  
  })
      .catch((error) => {
        console.error(error);
        return null;
      });
}

/******************************* LISTENERS DOM ***********************************/

document.addEventListener("DOMContentLoaded", () => {
  datosUsu(); //Visualizar datos de usuario
});


