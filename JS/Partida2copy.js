var turno_tiro;
var ganador;
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
Nombre: reloadPartida()
Proceso: A partir de la cadena de respuesta del servidor manda las cadenas que obtiene a las funcion para pintar los
*******************************************************************************************************************************/
function reloadPartida(cadTabl, ganador) {
    let arrTabl = cadTabl.split("|");
 
    //Cargar tableros
    obtener_tablero(arrTabl[0], 1); //tablero_usuario
    obtener_tablero(arrTabl[1], 2); //tablero_boot

    //Cambiar visibilidad de los botones
    document.querySelector("#Empezar").style.display = "none";
    document.querySelector("#Abandonar").style.display = "inline";
  
    //Comprobar ganador
    switch (ganador) {
      case "0":
        if (turno_tiro == 0) {
          //Espera 4 segundos y hacer peticion a la pagina para recargar !!!!!!!!!!!!!!!!!!!!!!!!!!!!!
          setTimeout("turno_servidor()", 1000);
        } else {
          //limpia el intervalo
          clearTimeout();
        }
        break;
      case "1":
        //Mostrar mensaje de victoria
        alert("ENORABUENA!!! Has ganado !!");
  
        //############### peticion 7 #################### (Sumar victoria a la cuenta de usuario y terminar partida)
        victoria_usuario();
  
        break;
      case "2":
        //Mostrar mensaje de victoria
        alert("ERES UN LOOSER DE SECANO!!");
        //Ejecutar peticion 5 (Terminar partida)
  
        break;
    }
  }
  
/*############################### peticion : 3 ###############################*/
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
      
/*------------------------------------------------------------------------------------
Nombre: Enviar jugada
Proceso: Manda a traves de una peticion asíncrona un Json al servidor con numero de peticion y coordenadas
         del boton pulsado.
------------------------------------------------------------------------------------*/
function Enviar_jugada(name_btn_pulsado) {
  let id_boton = new String(name_btn_pulsado);
  let coordenadas = new Array();
  coordenadas = id_boton.split("|");

  alert ("entra en envia jugada. el nombr edle boton pulsado es "+coordenadas[0]+"|"+coordenadas[1]);
  let json = {
    peticion: 3,
    x: coordenadas[0],
    y: coordenadas[1],
  };

  alert(JSON.stringify(json));
  alert ("turno: " +turno_tiro);

  if (turno_tiro==true) {  //Si el turno es del Jugador se hace la petición al server
    alert("es true");
  }
  else{
    if (turno_tiro==1){
      alert("es entero");

    }
    else{
      if(turno_tiro=="1"){
        alert("es cadena");
      }
      else{
        alert("nosé que coño es ya");
      }
    }
  }
    alert("entramos en turno tiro");

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
        
        ganador = JSON.stringify(datos.ganador);    //Actualiza variables globales
        turno_tiro = JSON.stringify(datos.turno);

        eliminar_tableros();                        //Elimina los tableros y carga partida con nueva respuesta
        let cadT = JSON.stringify(datos.partida);
        reloadPartida(cadT.split('"').join(""));
      })
      .catch((error) => {
        // common error
        console.error(error);
        //console.log(json.datosUsu);
        return null;
      });
 // }
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

        //Si el tablero es el de tirar dle jugador
        let nuevo_boton = document.createElement("input");
        nuevo_boton.type = "button";
        nuevo_boton.value = "";
        nuevo_boton.name = i + 1 + "|" + (j + 1);
        //asignar estilo segun el contenido del array para esa casilla
        switch (arr_cad[i * 10 + j]) {
          case "0": //agua no explotada
          
            nuevo_boton.setAttribute("id", "btnTabServer");
            nuevo_boton.addEventListener('click', (evt)=>{Enviar_jugada(evt.target.name)}); //Añadir manejador de evento click
           
            break;

          case "1": //barco no explotado

            nuevo_boton.setAttribute("id", "btnTabServer");
            nuevo_boton.addEventListener('click', (evt)=>{Enviar_jugada(evt.target.name)}); //Añadir manejador de evento click
            break;

          case "N": //barco no explotado -popa-proa NORTE

            nuevo_boton.setAttribute("id", "btnTabServer");
            nuevo_boton.addEventListener('click', (evt)=>{Enviar_jugada(evt.target.name)}); //Añadir manejador de evento click

            break;

          case "S": //barco no explotado -popa-proa SUR
         
            nuevo_boton.setAttribute("id", "btnTabServer");
            nuevo_boton.addEventListener('click', (evt)=>{Enviar_jugada(evt.target.name)}); //Añadir manejador de evento click

            break;

          case "W": //barco no explotado -popa-proa WEST

            nuevo_boton.setAttribute("id", "btnTabServer");
            nuevo_boton.addEventListener('click', (evt)=>{Enviar_jugada(evt.target.name)}); //Añadir manejador de evento click

            break;

          case "E": //barco no explotado -popa-proa EAST

            nuevo_boton.setAttribute("id", "btnTabServer");
            nuevo_boton.addEventListener('click', (evt)=>{Enviar_jugada(evt.target.name)}); //Añadir manejador de evento click

            break;

          case "2": //barco no explotado -cuerpocentral

            nuevo_boton.setAttribute("id", "btnTabServer");
            nuevo_boton.addEventListener('click', (evt)=>{Enviar_jugada(evt.target.name)}); //Añadir manejador de evento click

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
      } else if (jugador == 1) {
        //La tabla pertenece al boot
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

        //Machacamos variables globales con los valores devueltos
        ganador=JSON.stringify(datos.ganador);
        turno_tiro =JSON.stringify(datos.turno);
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
  document.querySelector("#Abandonar").addEventListener("click", (e) => {
    e.preventDefault(); //Cortamos el envio del formulario
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



});

});



//document.addEventListener("unload",()=>{  //peticion });
