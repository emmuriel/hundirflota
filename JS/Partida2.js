
var turno_tiro;
var ganador;
/**************************************************************************************************************************
Nombre: cargarDatosUsu()
Proceso: Manda una petición http asincrona a Partida.php (peticion 1) para obtener nombre y nuemro de victorias de usuario
        registrado en la session. Añade la respuesta en formato de texto al elemento <span id=datos_usuario> y lo hace visible 
*******************************************************************************************************************************/

function cargaDatosUsu(){   //Es llamada en la petición 1 
    let json= { 
        peticion : 1 };
    
    fetch('Partida.php', {
        method: 'POST', // *GET, POST, PUT, DELETE, etc.
        body: JSON.stringify(json), // must match 'Content-Type' header
        headers: {
            'Content-Type': 'application/json'// AQUI indicamos el formato
          }
    })
        .then(response => {
            if (response.status >= 200 && response.status < 300) {
                return Promise.resolve(response);
            }
            if (response.status==404){
                document.getElementById("lbl_error_usuario").innerHTML = "ERROR SERVIDOR";
                alert("error");
            }
            return Promise.reject(new Error(response.statusText));
        })
        .then(response => response.json()) // parse el response en texto plano
        .then(datos =>{
            let datosUsu=JSON.stringify(datos.datosUsu);
            //Tengo que hacer esto porque al pasar el JSON.stringfly Me da el resultado de cadena con comillas dobles (PQ??PREGUNTAR A PILAR)
            document.querySelector("#datos_usuario").textContent=datosUsu.split("\"").join(''); 
        })
        .catch(error => {
            // common error
            console.error(error);
            //console.log(json.datosUsu);
            return null;
        });
    }

/**************************************************************************************************************************
Nombre: cargarPartida()
Proceso: A partir de la cadena de respuesta del servidor manda las cadenas que obtiene a las funcion para pintar los
*******************************************************************************************************************************/
function cargarPartida(respuesta_server) {

    var cadena_datos_usuario;
    //forma un array de cadenas del cual solo nos interesa las 7 primeras (cod_usu, nombre_usu, partidas ganadas, tablero usu, tablero boot, turno)
    var array_respuestas = respuesta_server.split("|");
    
    /*cargar usuario 
    cadena_datos_usuario= "BIENVENIDO " + array_respuestas[1] + " Partidas Ganadas:" + array_respuestas[2] ;
    cargar_datos_usu(cadena_datos_usuario);*/
    
    //Cargar tableros
    obtener_tablero(array_respuestas[3],1); //tablero_usuario
    obtener_tablero(array_respuestas[4],2); //tablero_boot
    
    //Cambiar el valor de la variable global turno tiro
    turno_tiro= array_respuestas[5];
    ganador= array_respuestas[6];
    document.querySelector("#Empezar").style.display='none';
    document.querySelector("#Abandonar").style.display='inline';
    
    
    
    //Comprobar ganador
        switch (ganador){
            case '0':
                if (turno_tiro=="False"){  //Espera 4 segundos y hacer peticion a la pagina para recargar
                setTimeout("turno_servidor()",1000) ;
                }
                    else{ //limpia el intervalo
                        clearTimeout();
                    }
            break;
            case '1':
                //Mostrar mensaje de victoria
                alert ("ENORABUENA!!! Has ganado!!");
                
                //Ejecutar la peticion 7 (Sumar victoria a la cuenta de usuario y terminar partida)
                victoria_usuario();
                
            break;
            case'2':
                //Mostrar mensaje de victoria
                alert ("GAME OVER! Perdedor!!");
                //Ejecutar peticion 5 (Terminar partida)
                
                
            break;
        }
    
    }
    
    
    /*------------------------------------------------------------------------------------
    Nombre: obtener_tablero
    Proceso: A partir de una cadena de 100 caracteres inicializa una matriz de caracteres
    ------------------------------------------------------------------------------------*/
    
     function obtener_tablero(cadena_tab,jugador){
            var i,j;
            var arr_cad= new Array();
            var cadena = new String(cadena_tab);
    
            //Pasar la cadena a array de caracteres
            arr_cad= cadena.split("");
        // Crear <tbody> y añadirla como hijo de <table>
        var miTbody = document.createElement("tbody");
        
    
            //Recorrer cadena
            for(i=0;i<=9;i++){
      
            var nuevo_fila = document.createElement("tr");
       
            var indice= i+1;
            nuevo_fila.setAttribute("id",indice.toString());
            
                for (j=0;j<=9;j++){
                      
                    /*Hablando de posiciones, en el array unidimensional, el contador i establece el valor de la unidad y el contador
                    j el valor de la decena,juntos (j*10 + i)obtienen la posicion en el array_cadena que corresponde insertar en la matriz
                     de (i)(j)*/
                     var nueva_celda = document.createElement("td");
                     
                     nueva_celda.name= ((j+1)+"|"+(i+1));
                     
                     
                     if (jugador==2){  //Si el tablero es el de tirar dle jugador
                  
                     //asignar estilo segun el contenido del array para esa casilla
                     switch (arr_cad[i * 10 + j]){
                     
                         case '0': //agua no explotada
                         
                             var nuevo_boton = document.createElement("input");
                             nuevo_boton.type= "button";
                             nuevo_boton.value= "";
                             nuevo_boton.name= (i+1) + "|" +(j+1);
                             nuevo_boton.setAttribute("class", "btn_0");
                             nuevo_boton.onclick = function() { Enviar_jugada(this.name) };
                                             //Crear boton con los atributos y el manejador
                           //  nuevo_boton.onclick = function () {Enviar_jugada(this.name)}; //En el evento onclick le enviamos 
                         break;
                         
                         
                         case '1': //barco no explotado
                         
                           //Crear boton con los atributos y el manejador
                            var nuevo_boton = document.createElement("input");
                            nuevo_boton.type= "button";
                            nuevo_boton.value= "";
                            nuevo_boton.name= (i+1) + "|" +(j+1);
                            nuevo_boton.setAttribute("class", "btn_0");
                            nuevo_boton.onclick = function() { Enviar_jugada(this.name) };
                          //  nuevo_boton.onclick = function () {Enviar_jugada(this.name)}; //En el evento onclick le enviamos 
                         break;
                         
                          case 'N': //barco no explotado
                         
                            var nuevo_boton = document.createElement("input");
                            nuevo_boton.type= "button";
                            nuevo_boton.value= "";
                            nuevo_boton.name= (i+1) + "|" +(j+1);
                            nuevo_boton.setAttribute("class", "btn_0");
                            nuevo_boton.onclick = function() { Enviar_jugada(this.name) };
                             
                         break;
                         
                                              
                         case 'S': //barco no explotado
                         
                             var nuevo_boton = document.createElement("input");
                            nuevo_boton.type= "button";
                            nuevo_boton.value= "";
                            nuevo_boton.name= (i+1) + "|" +(j+1);
                            nuevo_boton.setAttribute("class", "btn_0");
                            nuevo_boton.onclick = function() { Enviar_jugada(this.name) };
                             
                         break;
                         
                                              
                         case 'W': //barco no explotado
                         
                            var nuevo_boton = document.createElement("input");
                            nuevo_boton.type= "button";
                            nuevo_boton.value= "";
                            nuevo_boton.name= (i+1) + "|" +(j+1);
                            nuevo_boton.setAttribute("class", "btn_0");
                            nuevo_boton.onclick = function() { Enviar_jugada(this.name) };
                             
                         break;
                         
                                              
                         case 'E': //barco no explotado
                         
                            var nuevo_boton = document.createElement("input");
                            nuevo_boton.type= "button";
                            nuevo_boton.value= "";
                            nuevo_boton.name= (i+1) + "|" +(j+1);
                            nuevo_boton.setAttribute("class", "btn_0");
                            nuevo_boton.onclick = function() { Enviar_jugada(this.name) };
                             
                         break;
                         
                                                                                    
                         case '2': //barco no explotado
                         
                            var nuevo_boton = document.createElement("input");
                            nuevo_boton.type= "button";
                            nuevo_boton.value= "";
                            nuevo_boton.name= (i+1) + "|" +(j+1);
                            nuevo_boton.setAttribute("class", "btn_0");
                            nuevo_boton.onclick = function() { Enviar_jugada(this.name) };
                             
                         break;
                         
                         case '#': //agua explotada
                            var nuevo_boton = document.createElement("input");
                            nuevo_boton.type= "button";
                            nuevo_boton.value= "";
                            nuevo_boton.name= (i+1) + "|" +(j+1);
                           nuevo_boton.setAttribute("class","btn_agua");
                         break;
                         
                         case 'x': //barco explotado
                                             
                            var nuevo_boton = document.createElement("input");
                            nuevo_boton.type= "button";
                            nuevo_boton.value= "";
                            nuevo_boton.name= (i+1) + "|" +(j+1);
                         
                           nuevo_boton.setAttribute("class","btn_x");
                         break;
                     }
                       //añadir celda a fila
                    nueva_celda.appendChild(nuevo_boton);  
                    }
                    else if (jugador==1){ //La tabla pertenece al boo
                    
                    switch (arr_cad[i * 10 + j]){
                         case '0': //agua no explotada
                           var nuevo_boton = document.createElement("input");
                            nuevo_boton.type= "button";
                            nuevo_boton.value= "";
                            nuevo_boton.name= (i+1) + "|" +(j+1);
                            nuevo_boton.setAttribute("class","btn_0");
                             
                         break;
                         
                         case 'N': //barco no explotado
                         
                            var nuevo_boton = document.createElement("input");
                            nuevo_boton.type= "button";
                            nuevo_boton.value= "";
                            nuevo_boton.name= (i+1) + "|" +(j+1);
                           nuevo_boton.setAttribute("class","btn_N");
                             
                         break;
                         
                                              
                         case 'S': //barco no explotado
                         
                            var nuevo_boton = document.createElement("input");
                            nuevo_boton.type= "button";
                            nuevo_boton.value= "";
                            nuevo_boton.name= (i+1) + "|" +(j+1);
                           nuevo_boton.setAttribute("class","btn_S");
                             
                         break;
                         
                                              
                         case 'W': //barco no explotado
                         
                            var nuevo_boton = document.createElement("input");
                            nuevo_boton.type= "button";
                            nuevo_boton.value= "";
                            nuevo_boton.name= (i+1) + "|" +(j+1);
                           nuevo_boton.setAttribute("class","btn_W");
                             
                         break;
                         
                                              
                         case 'E': //barco no explotado
                         
                            var nuevo_boton = document.createElement("input");
                            nuevo_boton.type= "button";
                            nuevo_boton.value= "";
                            nuevo_boton.name= (i+1) + "|" +(j+1);
                           nuevo_boton.setAttribute("class","btn_E");
                             
                         break;
                         
                                              
                         case '1': //barco no explotado
                         
                            var nuevo_boton = document.createElement("input");
                            nuevo_boton.type= "button";
                            nuevo_boton.value= "";
                            nuevo_boton.name= (i+1) + "|" +(j+1);
                           nuevo_boton.setAttribute("class","btn_1");
                             
                         break;
                         
                                              
                         case '2': //barco no explotado
                         
                            var nuevo_boton = document.createElement("input");
                            nuevo_boton.type= "button";
                            nuevo_boton.value= "";
                            nuevo_boton.name= (i+1) + "|" +(j+1);
                           nuevo_boton.setAttribute("class","btn_2");
                             
                         break;
                         
       
                         
                         case '#': //agua explotada
                            var nuevo_boton = document.createElement("input");
                            nuevo_boton.type= "button";
                            nuevo_boton.value= "";
                            nuevo_boton.name= i + "|" +j;
                           nuevo_boton.setAttribute("class","btn_agua");
                         break;
                         
                         case 'x': //barco explotado
                            var nuevo_boton = document.createElement("input");
                            nuevo_boton.type= "button";
                            nuevo_boton.value= "";
                            nuevo_boton.name= (i+1) + "|" +(j+1);
                           nuevo_boton.setAttribute("class","btn_x");
                         break;
                     }
                      nueva_celda.appendChild(nuevo_boton);
                    }//fin stwic
                            nuevo_fila.appendChild(nueva_celda);       
                }//fin for j
                
                miTbody.appendChild(nuevo_fila);
                
    
            } //for i
            
                    if (jugador==1){
             //añadir fila a tabla usuario
             
             document.getElementById("tbl_usuario").appendChild(miTbody);    
           }
           else if (jugador==2){
           document.getElementById("tbl_boot").appendChild(miTbody); 
           }
    }
    
    
    
/*****************************************************************************************/
    /*  PROCESO: Recorre los nodos de tipo 1 de una tabla que esta dentro de un formulario   */
    /*           mostrando con un alert todos                                                */
    /*****************************************************************************************/
    
    function recorre_nodos_tabla() {
        let i,j,m;
        
        //recoge ele lemento tabla del formulario mediante la id
        let tabla = window.document.getElementById("tbl_boot");
    
            let cadenaDOM = '';
            
            //SI la tabla tiene hijos
            if (tabla.hasChildNodes) 
            {         
                //recorre el array creado metiendo en cadena el nombre de cada nodo mas un salto de linea
                for (i = 0; i < tabla.childNodes.length; i++) {
                
                    cadenaDOM = cadenaDOM + tabla.childNodes[i].nodeName + '\n';
    
                    /*var tabla_hijo = tabla.childNodes[i];  */
                    
                    //recorre el array para los hijos de los hijos
    
                        for (j=0; j<tabla.childNodes[i].childNodes.length ;j++)
                        {
                            //concatena la cadena que se mostrara en el alert
                                cadenaDOM = cadenaDOM + tabla.childNodes[i].childNodes[j].nodeName;
                       
                            
                        //y recorre los hijos d elos hijos de los hijos (lo que deberian ser los TD de la tabla)
                             //  var tabla_nietos = tabla_hijo.childNodes[j];
                                
    
                            for (m = 0; m < tabla.childNodes[i].childNodes[j].childNodes.length; m++) {
                                
                                //concatena la cadena que se mostrara en el alert
                                    cadenaDOM = cadenaDOM + tabla.childNodes[i].childNodes[j].childNodes[m].nodeName;
                      
                            }//fin_for indice i
                
                        }//Fin for indice j      
             
                } //fin for indice m  
                //Muestra con un alert los elementos
                alert(cadenaDOM);
            }//fin If
        }//fin_function
    
    

/***************************************||||||| MANEJADORES DE EVENTOS |||||||**************************************************/

document.addEventListener("DOMContentLoaded",()=>{
/*############################### peticion : 1 ###############################*/   
    
cargaDatosUsu();                                                    
    
    /*############################### peticion : 2 ###############################*/

    document.querySelector("#Empezar").addEventListener("click", (e)=> {
            e.preventDefault(); //Cortamos el envio del formulario
            let json = {
                peticion: 2
            };

            fetch('Partida.php', {
                method: 'POST',
                body: JSON.stringify(json),
                headers: {
                    'Content-Type': 'application/json'
                }
            })
                .then(response => {
                    if (response.status >= 200 && response.status < 300) {
                        return Promise.resolve(response);
                    }
                    return Promise.reject(new Error(response.statusText));
                    if (response.status==404){
                        document.getElementById("lbl_error_usuario").innerHTML = "ERROR SERVIDOR";
                        alert("error");
                    }
                })
                .then(response => response.json()) // parsea la respuesta en texto plano
                .then(datos => {
                    let partida = JSON.stringify(datos.partida);
                    cargarPartida(partida.split("\"").join('')); //Manda la cadena sin ""
                })
                .catch(error => {
                    console.error(error);
                    return null;
                });
    });
});
 
//document.addEventListener("unload",()=>{  //peticion });


