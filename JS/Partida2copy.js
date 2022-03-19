var turno_tiro;
var ganador;
var mp3explosion = 'data:audio/mp3;base64, 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';

function sonidoExplosion(event) {
  var audio = new Audio();
  audio.src = mp3explosion;
  audio.play();
}

function sonidoExplosion2(event) {
  var audio = new Audio();
  audio.src = mp3explosion2;
  audio.play();
}



/**************************************************************************************************************************
Nombre: cargarDatosUsu()
Proceso: Manda una petición http asincrona a Partida.php (peticion 1) para obtener nombre y nuemro de victorias de usuario
        registrado en la session. Añade la respuesta en formato de texto al elemento <span id=datos_usuario> y lo hace visible 
*******************************************************************************************************************************/

function cargaDatosUsu() {
  //Es llamada en la petición 1
  let json = {
    peticion: 1,
  };

  fetch("Partida.php", {
    method: "POST", // *GET, POST, PUT, DELETE, etc.
    body: JSON.stringify(json), // must match 'Content-Type' header
    headers: {
      "Content-Type": "application/json", // AQUI indicamos el formato
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
    .then((response) => response.json()) // parse el response en texto plano
    .then((datos) => {
      let datosUsu = JSON.stringify(datos.datosUsu);
      //Tengo que hacer esto porque al pasar el JSON.stringfly Me da el resultado de cadena con comillas dobles (PQ??PREGUNTAR A PILAR)
      document.querySelector("#datos_usuario").textContent = datosUsu.split('"').join("");
    })
    .catch((error) => {
      // common error
      console.error(error);
      //console.log(json.datosUsu);
      return null;
    });
}

/**************************************************************************************************************************
Nombre: abandonarPartida(){
Proceso: Manda una peticion 5 al servidor. Abandonar partida. Esta funcion es llamada desde el evento click del boton abandonar
        y desde la funcion cuando el servidor gana la partida.
*******************************************************************************************************************************/
function abandonarPartida(){
  let json = {
    peticion: 5,
  };

  fetch("Partida.php", {
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
    .then((response) => response.json()) // parsea la respuesta en texto plano
    .then((datos) => {
      let ok = JSON.stringify(datos.ok);
      if (ok==1){

        window.location="http://localhost/HF/Partida.html"; 
      }
    })
    .catch((error) => {
      console.error(error);
      return null;
    });


}

/*------------------------------------------------------------------------------------
    Nombre: eliminar_tableros
    Proceso: Elimina todos los nodos hijos de las tablas
    ------------------------------------------------------------------------------------*/
    function eliminar_tableros() {
      var i, j;
      var tabla_b = document.getElementById("tbl_boot");
      var tabla_u = document.getElementById("tbl_usuario");
    
      //Elimina las dos tablas
      var tbody_b = tabla_b.firstChild;
      var tbody_u = tabla_u.firstChild;
    
      tabla_b.removeChild(tbody_b);
      tabla_u.removeChild(tbody_u);
    }
    
 //################################### PETICION 4  : Tira servidor  ###################################################*/
/*---------------------------------------------------------------------------------------------------------------------
Nombre: turno_servidor
Proceso: Le hace una peticion al servidor de tipo 4 ( Servidor tira y devuelve el resultado de su maniobra).
-----------------------------------------------------------------------------------------------------------------------*/
function turno_servidor(){

  let json = {
    peticion: 4,
  };

  fetch("Partida.php", {
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
    .then((response) => response.json()) // parsea la respuesta en texto plano
    .then((datos) => {

      //Machacamos variables globales con los valores devueltos, paseandolos a enteros porque las cadenas me estan dando problemas
      let gan=JSON.stringify(datos.ganador);
      let turno =JSON.stringify(datos.turno);
      ganador=  parseInt(gan.split('"').join(""),10);
      turno_tiro= parseInt(turno.split('"').join(""),10);
      //Eliminar tableros
      eliminar_tableros();
      //Cargar partida
      let cadT = JSON.stringify(datos.partida);
      sonidoExplosion(); 
      reloadPartida(cadT.split('"').join("")); 
    })
    .catch((error) => {
      console.error(error);
      return null;
    });
 
 }
 /*############################## PETICION 7 ######################################## */
 /*------------------------------------------------------------------------------------
Nombre: victoria_usuario()
Proceso: Le hace una peticion al servidor de tipo 7 (Elimina la partida d ela base de 
datos y suma la victoria al usuario, luego recarga la página).
------------------------------------------------------------------------------------*/
function victoria_usuario(){   
  let json = {
    peticion: 7,
  };

  fetch("Partida.php", {
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
    .then((response) => response.json()) //Aki no deberia llegar
    .then((datos) => {
      let ok = JSON.stringify(datos.ok);
      if (ok==1){
        cargaDatosUsu();
        //Cambiar visibilidad de los botones
      document.querySelector("#Empezar").style.display = "inline";
      document.querySelector("#Abandonar").style.display = "none";
        location.href = "http://localhost/HF/Partida.html";    //Recarga la pagina 
      }
    })
    .catch((error) => {
      console.error(error);
    return null;
  });
}

/**************************************************************************************************************************
Nombre: reloadPartida()
Proceso: A partir de la cadena de respuesta del servidor manda las cadenas que obtiene a las funcion para pintar los tablero.
        Tambien es quien gestiona el turno de los jugadores y cambia los estilos.
*******************************************************************************************************************************/
function reloadPartida(cadTabl) {
    let arrTabl = cadTabl.split("|");
 
    //Cargar tableros
    obtener_tablero(arrTabl[0], 1); //tablero_usuario
    obtener_tablero(arrTabl[1], 2); //tablero_boot

    //Cambiar visibilidad de los botones
    document.querySelector("#Empezar").style.display = "none";
    document.querySelector("#Abandonar").style.display = "inline";
   
    //Comprobar ganador --variables globales parseadas a enteros
    switch (ganador) {
      case 0:
        if (turno_tiro == 0) {
          //Aqui deberiamos gestionar el tema de los estilos
          //-->Añadir transparencia sobre la tabla servidor y marco rojo sobre la de usuario
          document.querySelector("#tbl_usuario").classList.remove("tabla_usu");
          document.querySelector("#tbl_usuario").classList.add("tU_red");
          document.querySelector("#tbl_boot").classList.remove("tB_red");
          document.querySelector("#tbl_boot").classList.add("tabla_boot");

          //Espera 2 segundos y hacer peticion a la pagina para recargar !!!!!!!!!!!!!!!!!!!!!!!!!!!!!
          setTimeout("turno_servidor()", 2000);               //  RECARGA PARTIDA HASTA QUE EL TURNO SEA DEL USUArio
        } else {
          //limpia el intervalo
          clearTimeout();
          //Quitar estilo de tabla usuario y ponerlo sobre la tabal boot
          document.querySelector("#tbl_usuario").classList.remove("tU_red");
          document.querySelector("#tbl_usuario").classList.add("tabla_usu");
          document.querySelector("#tbl_boot").classList.remove("tabla_boot");
          document.querySelector("#tbl_boot").classList.add("tB_red");


        }
        break;
      case 1:
        //Mostrar mensaje de victoria
        alert("ENORABUENA!!! Has ganado !!");
  
        //############### peticion 7 #################### (Sumar victoria a la cuenta de usuario y terminar partida)
        victoria_usuario();
  
        break;
      case 2:
        //Mostrar mensaje de victoria
        alert("ERES UN LOOSER DE SECANO!!");
        //Ejecutar peticion 5 (Terminar partida)
        abandonarPartida();
        break;
    }
  }
  
/*############################### peticion : 3 ###############################*/

/*------------------------------------------------------------------------------------
Nombre: Enviar jugada
Proceso: Manda a traves de una peticion asíncrona un Json al servidor con numero de peticion y coordenadas
         del boton pulsado.
------------------------------------------------------------------------------------*/
function Enviar_jugada(name_btn_pulsado) {
  let id_boton = new String(name_btn_pulsado);
  let coordenadas = new Array();
  coordenadas = id_boton.split("|");

  //alert ("entra en envia jugada. el nombr edle boton pulsado es "+coordenadas[0]+"|"+coordenadas[1]);
  //alert("ganador = "+typeof(ganador));
  //alert("turno_tiro = "+typeof(turno_tiro));


  if (turno_tiro==1) {  //Si el turno es del Jugador se hace la petición al server
    let json = {
      peticion: 3,
      x: coordenadas[0],
      y: coordenadas[1],
    };
    fetch("Partida.php", {
      method: "POST",
      body: JSON.stringify(json), // convierte el objeto json a un Json de texto de verdad
      headers: {
        "Content-Type": "application/json", // AQUI indicamos el formato
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
        
        let gan=JSON.stringify(datos.ganador);       //Actualizar las variables globales
        let turno =JSON.stringify(datos.turno);
        ganador=  parseInt(gan.split('"').join(""),10);
        turno_tiro= parseInt(turno.split('"').join(""),10);

        eliminar_tableros();                        //Elimina los tableros y carga partida con nueva respuesta
        let cadT = JSON.stringify(datos.partida);
        reloadPartida(cadT.split('"').join(""));
      })
      .catch((error) => {
        // common error
        console.error(error);
        return null;
      });
 }
 else{ //aqui podemos poner algun estilo para "bloquear" al jugador... si tira sin ser tu turno de todas maneras no hará nada

 }
}



/*------------------------------------------------------------------------------------
    Nombre: obtener_tablero
    Proceso: A partir de una cadena de 100 caracteres inicializa una matriz de caracteres
    ------------------------------------------------------------------------------------*/

function obtener_tablero(cadena_tab, jugador) {
  let i, j;
  let arr_cad = new Array();
  let cadena = new String(cadena_tab);

  //Pasar la cadena a array de caracteres
  arr_cad = cadena.split("");
  // Crear <tbody> y añadirla como hijo de <table>
  let miTbody = document.createElement("tbody");

  //Recorrer cadena
  for (i = 0; i <= 9; i++) {
    let nuevo_fila = document.createElement("tr");
    let indice = i + 1;
    nuevo_fila.setAttribute("id", indice.toString());

    for (j = 0; j <= 9; j++) {
      /*Hablando de posiciones, en el array unidimensional, el contador i establece el valor de la unidad y el contador
                    j el valor de la decena,juntos (j*10 + i)obtienen la posicion en el array_cadena que corresponde insertar en la matriz
                     de (i)(j)*/
      let nueva_celda = document.createElement("td");

      nueva_celda.name = j + 1 + "|" + (i + 1);

      if (jugador == 2) {  // JUGADOR 2--> TABLA SERVIDOR. Se añade el disparador del evento "click" para que el jugador pueda Enviar disparos

        let nuevo_boton = document.createElement("input");
        nuevo_boton.type = "button";
        nuevo_boton.value = "";
        nuevo_boton.name = i + 1 + "|" + (j + 1);
        //asignar estilo segun el contenido del array para esa casilla
        switch (arr_cad[i * 10 + j]) {
          case "0": //agua no explotada
          
            nuevo_boton.setAttribute("id", "btnTabServer");
            nuevo_boton.addEventListener('click', (evt)=>{sonidoExplosion(); Enviar_jugada(evt.target.name)}); //Añadir manejador de evento click
           
            break;

          case "1": //barco no explotado

            nuevo_boton.setAttribute("id", "btnTabServer");
            nuevo_boton.addEventListener('click', (evt)=>{sonidoExplosion(); Enviar_jugada(evt.target.name)}); //Añadir manejador de evento click
            break;

          case "N": //barco no explotado -popa-proa NORTE

            nuevo_boton.setAttribute("id", "btnTabServer");
            nuevo_boton.addEventListener('click', (evt)=>{sonidoExplosion();  Enviar_jugada(evt.target.name)}); //Añadir manejador de evento click

            break;

          case "S": //barco no explotado -popa-proa SUR
         
            nuevo_boton.setAttribute("id", "btnTabServer");
            nuevo_boton.addEventListener('click', (evt)=>{sonidoExplosion(); Enviar_jugada(evt.target.name)}); //Añadir manejador de evento click

            break;

          case "W": //barco no explotado -popa-proa WEST

            nuevo_boton.setAttribute("id", "btnTabServer");
            nuevo_boton.addEventListener('click', (evt)=>{sonidoExplosion(); Enviar_jugada(evt.target.name)}); //Añadir manejador de evento click

            break;

          case "E": //barco no explotado -popa-proa EAST

            nuevo_boton.setAttribute("id", "btnTabServer");
            nuevo_boton.addEventListener('click', (evt)=>{sonidoExplosion(); Enviar_jugada(evt.target.name)}); //Añadir manejador de evento click

            break;

          case "2": //barco no explotado -cuerpocentral

            nuevo_boton.setAttribute("id", "btnTabServer");
            nuevo_boton.addEventListener('click', (evt)=>{sonidoExplosion(); Enviar_jugada(evt.target.name)}); //Añadir manejador de evento click

            break;

          case "#": //agua explotada
       
            nuevo_boton.setAttribute("class", "btn_agua");
            break;

          case "x": //barco explotado

            nuevo_boton.setAttribute("class", "btn_x");
            break;
        }
        //añadir celda a fila
        nueva_celda.appendChild(nuevo_boton);
      } else if (jugador == 1) {    //=> TABLERO DE USUARIO. NO TIENE EVENTOS
        
        let nuevo_boton = document.createElement("input");
        nuevo_boton.type = "button";
        nuevo_boton.value = "";
        switch (arr_cad[i * 10 + j]) {
          case "0": //agua no explotada
            nuevo_boton.setAttribute("class", "btn_0");

            break;

          case "N": //barco no explotado
            nuevo_boton.setAttribute("class", "btn_N");

            break;

          case "S": //barco no explotado
            nuevo_boton.setAttribute("class", "btn_S");

            break;

          case "W": //barco no explotado
            nuevo_boton.setAttribute("class", "btn_W");

            break;

          case "E": //barco no explotado

            nuevo_boton.setAttribute("class", "btn_E");

            break;

          case "1": //barco no explotado

            nuevo_boton.setAttribute("class", "btn_1");

            break;

          case "2": //barco no explotado

            nuevo_boton.setAttribute("class", "btn_2");

            break;

          case "#": //agua explotada

            nuevo_boton.setAttribute("class", "btn_agua");
            break;

          case "x": //barco explotado

            nuevo_boton.setAttribute("class", "btn_x");
            break;
        }
        nueva_celda.appendChild(nuevo_boton);
      } //fin stwic
      nuevo_fila.appendChild(nueva_celda);
    } //fin for j

    miTbody.appendChild(nuevo_fila);
  } //for i

  if (jugador == 1) {
    //añadir fila a tabla usuario

    document.getElementById("tbl_usuario").appendChild(miTbody);
  } else if (jugador == 2) {
    document.getElementById("tbl_boot").appendChild(miTbody);
  }
}

/*****************************************************************************************/
/*  PROCESO: Recorre los nodos de tipo 1 de una tabla que esta dentro de un formulario   */
/*           mostrando con un alert todos                                                */
/*****************************************************************************************/

function recorre_nodos_tabla() {
  let i, j, m;

  //recoge ele lemento tabla del formulario mediante la id
  let tabla = window.document.getElementById("tbl_boot");

  let cadenaDOM = "";

  //SI la tabla tiene hijos
  if (tabla.hasChildNodes) {
    //recorre el array creado metiendo en cadena el nombre de cada nodo mas un salto de linea
    for (i = 0; i < tabla.childNodes.length; i++) {
      cadenaDOM = cadenaDOM + tabla.childNodes[i].nodeName + "\n";

      /*var tabla_hijo = tabla.childNodes[i];  */

      //recorre el array para los hijos de los hijos

      for (j = 0; j < tabla.childNodes[i].childNodes.length; j++) {
        //concatena la cadena que se mostrara en el alert
        cadenaDOM = cadenaDOM + tabla.childNodes[i].childNodes[j].nodeName;

        //y recorre los hijos d elos hijos de los hijos (lo que deberian ser los TD de la tabla)
        //  var tabla_nietos = tabla_hijo.childNodes[j];

        for (
          m = 0;
          m < tabla.childNodes[i].childNodes[j].childNodes.length;
          m++
        ) {
          //concatena la cadena que se mostrara en el alert
          cadenaDOM =
            cadenaDOM +
            tabla.childNodes[i].childNodes[j].childNodes[m].nodeName;
        } //fin_for indice i
      } //Fin for indice j
    } //fin for indice m
    //Muestra con un alert los elementos
    alert(cadenaDOM);
  } //fin If
} //fin_function

/***************************************||||||| MANEJADORES DE EVENTOS |||||||**************************************************/

document.addEventListener("DOMContentLoaded", () => {
  /*############################### peticion : 1 Cargar datos de usuario ###############################*/

  cargaDatosUsu();
  /*############################### peticion : 2 Nueva partida ###############################*/

  document.querySelector("#Empezar").addEventListener("click", (e) => {
    e.preventDefault(); //Cortamos el envio del formulario
    let json = {
      peticion: 2,
    };

    fetch("Partida.php", {
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
      .then((response) => response.json()) // parsea la respuesta en texto plano
      .then((datos) => {

        //Machacamos variables globales con los valores devueltos, paseandolos a enteros porque las cadenas me estan dando problemas
        let gan=JSON.stringify(datos.ganador);
        let turno =JSON.stringify(datos.turno);
        ganador=  parseInt(gan.split('"').join(""),10);
        turno_tiro= parseInt(turno.split('"').join(""),10);

        //Cargar partida
        let cadT = JSON.stringify(datos.partida);
        reloadPartida(cadT.split('"').join("")); //Manda la cadena sin ""
      })
      .catch((error) => {
        console.error(error);
        return null;
      });
  });

  /*############################### peticion : 5 Abandonar partida sin salir de la sesion ###############################*/
  document.querySelector("#Abandonar").addEventListener("click", (evt) => {
    evt.preventDefault(); //Cortamos el envio del formulario
    abandonarPartida();
    

  });
  /*------------------------------------------------------------------------------------
  Nombre: cierra_usuario()
  Proceso: Le hace una peticion al servidor de tipo 6 (Elimina la partida d ela base de 
  datos si la hubiera, cambia el estado de conexion y borra la sesion de usuario).
  ------------------------------------------------------------------------------------*/
  document.querySelector("body").addEventListener('unload',(evt)=>{
    let confirmacion= prompt("Estás seguro de que desea cerrar la aplicación?");
    if (confirmacion==false){
      evt.preventDefault(); //Cortamos el envio del formulario
    }
    else{
      alert ("HASTA LA PRÓXIMA PARTIDA !! ");  
      let json = {
        peticion: 6,
      };

      fetch("Partida.php", {
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
        .then((response) => response.json()) //Aki no deberia llegar
        .then((datos) => {
          let ok = JSON.stringify(datos.ok);
          if (ok==1){
            
          }
        })
        .catch((error) => {
          console.error(error);
        return null;
      });
    }
  });

}); //DOMContentLoaded


