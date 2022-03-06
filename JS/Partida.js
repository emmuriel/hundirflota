//variable global
var transport = false;
var transport2 = false;
var transport3 = false;
var transport4 = false;
var transport5 = false;
var transport6 = false;

var turno_tiro;
var ganador;

//-------------------- instanciación el objeto XMLHttpRequest-------------------------

function getTransport() {


    if (window.XMLHttpRequest) {
        transport = new XMLHttpRequest();
    }
    else if (window.ActiveXObject) {
        try {
            transport = new ActiveXObject('Msxml2.XMLHTTP');  //Para el resto de navegadores
        }
        catch (err) {
            transport = new ActiveXObject('Microsoft.XMLHTTP'); //Para intenet explorer
        }
    }
}


//-------------------- instanciación el objeto XMLHttpRequest-------------------------

function getTransport2() {


    if (window.XMLHttpRequest) {
        transport2 = new XMLHttpRequest();
    }
    else if (window.ActiveXObject) {
        try {
            transport2 = new ActiveXObject('Msxml2.XMLHTTP');
        }
        catch (err) {
            transport2 = new ActiveXObject('Microsoft.XMLHTTP');
        }
    }
}
//-------------------- instanciación el objeto XMLHttpRequest-------------------------

function getTransport3() {


    if (window.XMLHttpRequest) {
        transport3 = new XMLHttpRequest();
    }
    else if (window.ActiveXObject) {
        try {
            transport3 = new ActiveXObject('Msxml2.XMLHTTP');
        }
        catch (err) {
            transport3= new ActiveXObject('Microsoft.XMLHTTP');
        }
    }
}

//-------------------- instanciación el objeto XMLHttpRequest-------------------------

function getTransport4() {


    if (window.XMLHttpRequest) {
        transport4 = new XMLHttpRequest();
    }
    else if (window.ActiveXObject) {
        try {
            transport4 = new ActiveXObject('Msxml2.XMLHTTP');
        }
        catch (err) {
            transport4= new ActiveXObject('Microsoft.XMLHTTP');
        }
    }
}
 
/*################################################################################################################

                             PETICION 1   : CARGA DATOS USUARIO
                                                
################################################################################################################*/


/*------------------------------------------------------------------------------------
Nombre: Carga_datos()
Proceso : hace una peticion al servidor para que carge los datos 
          iniciales del usuario
------------------------------------------------------------------------------------*/
function Carga_datos(){

 getTransport(); 
        if (transport) {
            
            transport.open('POST','Partida.php');
            transport.onreadystatechange = procesaPeticion_1;
            //cabecera
            transport.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            transport.send("peticion=1");//Enviar peticion
        }
}


/*------------------------------------------------------------------------------------
Nombre: procesaPeticion_1()
Proceso : Procesa la respuesta del servidor.
------------------------------------------------------------------------------------*/
function procesaPeticion_1(){
if (transport.readyState == 1) {

    }
    //Si ya se ha llegao al estado 4, en el que ya ha habido una respuesta del sevridor
    if (transport.readyState == 4) {

        if (transport.status == 404) {
            document.getElementById("lbl_error_usuario").innerHTML = "ERROR SERVIDOR";
            alert("error");
        }
        else if (transport.status == 200) {
        //Recoge el taxto que envie el servidor y llama a carga datos()
            var cadena_datos= transport.responseText;
            alert(transport.responseText)
             document.getElementById("Abandonar").visibility='hidden';
             cargar_datos_usu(cadena_datos);
            
        }
    }
}


function cargar_datos_usu(cadena){
 document.getElementById("datos_usuario").innerHTML=cadena;
  
}



/*################################################################################################################

                      PETICION 2   : CARGA PARTIDA NUEVA
                                                
################################################################################################################*/



/*------------------------------------------------------------------------------------
Nombre: Empezar_partida()
Proceso : hace una peticion al servidor para que genere una partida
------------------------------------------------------------------------------------*/

function Empezar_partida(){
 getTransport2(); //Abrir transport
        if (transport2) {

//            transport.open('GET', 'Default.aspx?opcion='+ opcion +'&random=' + Math.random()); //Manda por el metodo get, en el query la opcion seleccionada en el evento onchange del DDL
            
            transport2.open('POST','Partida.php');

            transport2.onreadystatechange = procesaPeticion_2;
            //cabecera
            transport2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    
             //Enviar opcion
            transport2.send( "peticion=2");
            
        }
}


/*------------------------------------------------------------------------------------
Nombre: procesaPeticion_2()
Proceso : Procesa la respuesta del servidor.
------------------------------------------------------------------------------------*/
function procesaPeticion_2(){

    //Si ya se ha llegao al estado 4, en el que ya ha habido una respuesta del sevridor
    if (transport2.readyState == 4) {

        if (transport2.status == 404) {
            document.getElementById("lbl_error_usuario").innerHTML = "ERROR SERVIDOR";
        }
        else if (transport2.status == 200) {
        //Si la peticion se ha reslizado con exito, pintar tablas
        var respuesta_server = transport2.responseText;
        if (respuesta_server.substring(0,5)=="Error")
        {
            //Redirecciona a la página de error
            location.href = "http://localhost/HF/Error.php";    
                
        }
            else
            {
                 cargar_partida(respuesta_server);
            }
        }
    }

}
/*******************************************************************
Nombre: cargar_partida()
Proceso al partir de la cadena de respuesta del servidor manda las 
        cadenas que obtiene a las funcion para pintar el tablero 
y manda al informacion del usuario a la funcion carga_datos

********************************************************************/
function cargar_partida(respuesta_server) {

var cadena_datos_usuario;
//forma un array de cadenas del cual solo nos interesa las 7 primeras (cod_usu, nombre_usu, partidas ganadas, tablero usu, tablero boot, turno)
var array_respuestas = respuesta_server.split("|");

//cargar usuario 
cadena_datos_usuario= "BIENVENIDO " + array_respuestas[1] + " Partidas Ganadas:" + array_respuestas[2] ;
cargar_datos_usu(cadena_datos_usuario);

//Cargar tableros
obtener_tablero(array_respuestas[3],1); //tablero_usuario
obtener_tablero(array_respuestas[4],2); //tablero_boot

//Cambiar el valor de la variable global turno tiro
turno_tiro= array_respuestas[5];
ganador= array_respuestas[6];
document.getElementById("Empezar").style.display='none';
document.getElementById("Abandonar").style.display='inline';



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
    var i,j,m;
    
    //recoge ele lemento tabla del formulario mediante la id
    var tabla = window.document.getElementById("tbl_boot");

        var cadenaDOM = '';
        
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



/*################################################################################################################

                      PETICION 3   : COMPRUEBA DISPARO   TURNO DEL USUARIO
                                                
################################################################################################################*/

/*------------------------------------------------------------------------------------
Nombre: Enviar jugada
Proceso: Manda a traves de un httpreques una peticion de tipo 3 al servidor
------------------------------------------------------------------------------------*/
function  Enviar_jugada(name_btn_pulsado){
var id_boton= new String (name_btn_pulsado);
var coordenadas= new Array();
coordenadas=id_boton.split("|");

 getTransport3(); //Abrir transport
        if (transport3) {

//            transport.open('GET', 'Default.aspx?opcion='+ opcion +'&random=' + Math.random()); //Manda por el metodo get, en el query la opcion seleccionada en el evento onchange del DDL
            
            transport3.open('POST','Partida.php');

            transport3.onreadystatechange = procesaPeticion_3;
            //cabecera
            transport3.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
           
             //Enviar opcion
             //Enviar tiro si le toca turno a jugador
             if (turno_tiro=="True"){
                 transport3.send("peticion=3&x=" + coordenadas[0] + "&y=" + coordenadas[1]);
            }
        }
}

/*------------------------------------------------------------------------------------
Nombre: eliminar_tablero
Proceso: Elimina todos los nodos hijos de las tablas
------------------------------------------------------------------------------------*/
function eliminar_tablero ()
{
var i,j;
var tabla_b= document.getElementById("tbl_boot");
var tabla_u= document.getElementById("tbl_usuario");

//Elimina las dos tablas
var tbody_b = tabla_b.firstChild;
var tbody_u= tabla_u.firstChild;


tabla_b.removeChild(tbody_b);
tabla_u.removeChild(tbody_u);

 
}
/*------------------------------------------------------------------------------------
Nombre: procesaPeticion_3()
Proceso : Procesa la respuesta del servidor.
------------------------------------------------------------------------------------*/
function procesaPeticion_3(){

    //Si ya se ha llegao al estado 4, en el que ya ha habido una respuesta del sevridor
    if (transport3.readyState == 4) {

        if (transport3.status == 404) {
            
        }
        else if (transport3.status == 200) {

                
        //LIMPIAR TABLA DE POSIBLES NODOS YA CREADOS
       eliminar_tablero();
        //Cargar nueva distribucion del tablero
         //Si la peticion se ha reslizado con exito, pintar tablas
        var respuesta_server = transport3.responseText;
        cargar_partida(respuesta_server);
        }
    }

}

/*################################################################################################################

                      PETICION 4   : RECARGA PARTIDA HASTA QUE EL TURNO SEA DEL USUARIO
                                                
################################################################################################################*/

/*------------------------------------------------------------------------------------
Nombre: turno_servidor
Proceso: Le hace una peticion al servidor de tipo 4 ( Servidor tira y devuelve el
resultado de su maniobra).
------------------------------------------------------------------------------------*/
function turno_servidor(){

 getTransport4(); //Abrir transport
        if (transport4) {
            
            transport4.open('POST','Partida.php');

            transport4.onreadystatechange = procesaPeticion_4;
            //cabecera
            transport4.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            

             //Enviar opcion
             //Enviar tiro si le toca turno al boot
             if (turno_tiro=="False"){
            transport4.send( "peticion=4");
            }

        }

}
/*------------------------------------------------------------------------------------
Nombre: procesaPeticion_4()
Proceso : Procesa la respuesta del servidor.
------------------------------------------------------------------------------------*/
function procesaPeticion_4(){


    //Si ya se ha llegao al estado 4, en el que ya ha habido una respuesta del sevridor
    if (transport4.readyState == 4) {

        if (transport4.status == 404) {
            alert("error");
        }
        else if (transport4.status == 200) {
        //LIMPIAR TABLA DE POSIBLES NODOS YA CREADOS
        eliminar_tablero();
        //Cargar nueva distribucion del tablero
         //Si la peticion se ha reslizado con exito, pintar tablas
        var respuesta_server = transport4.responseText;
        cargar_partida(respuesta_server);
        }
    }

}

/*################################################################################################################

                      PETICION 5   : TERMINAR PARTIDA
                                                
################################################################################################################*/

/*------------------------------------------------------------------------------------
Nombre: Terminar_partida()
Proceso : hace una peticion al servidor para que elimine la 
            partida que se esta jugando.
------------------------------------------------------------------------------------*/

function terminar_partida(){
 getTransport(); //Abrir transport
 
        if (transport) {
            transport.open('POST','Partida.aspx');

            transport.onreadystatechange = procesaRespuesta_peticion_5;
            //cabecera
            transport.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

             //Enviar opcion 5
            transport.send("peticion=5");
        }
}

/*------------------------------------------------------------------------------------
Nombre: procesaRespuesta_peticion5()
Proceso : Procesa la respuesta del servidor.

------------------------------------------------------------------------------------*/
function procesaRespuesta_peticion_5(){

    //Si ya se ha llegao al estado 4, en el que ya ha habido una respuesta del sevridor
    if (transport.readyState == 4){

        if (transport.status == 404) {
            alert("error");
        }
        else if (transport.status == 200) {  //Si la peticion se ha realizado con exito,recargar la página 
        window.location="http://localhost/HF/Partida.php"; 
        }
    }
}

/*################################################################################################################

                      PETICION 6   : CIERRA USUARIO
                                                
################################################################################################################*/


/*------------------------------------------------------------------------------------
Nombre: cierra_usuario()
Proceso: Le hace una peticion al servidor de tipo 6 (Elimina la partida d ela base de 
datos si la hubiera, cambia el estado de conexion y borra la sesion de usuario).
------------------------------------------------------------------------------------*/
function cierra_usuario(){

 getTransport(); //Abrir transport
        if (transport) {
            
            transport.open('POST','Partida.php');

            //cabecera
            transport.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            alert ("HASTA LA PRÓXIMA PARTIDA!!");            
             transport.send("peticion=6");
           
        }
}


/*################################################################################################################

                      PETICION 7   : TERMINAR PARTIDA Y SUMAR VICTORIA AL USUARIO
                                                
################################################################################################################*/


/*------------------------------------------------------------------------------------
Nombre: victoria_usuario()
Proceso: Le hace una peticion al servidor de tipo 7 (Elimina la partida d ela base de 
datos y suma la victoria al usuario, luego recarga la página).
------------------------------------------------------------------------------------*/
function victoria_usuario(){

 getTransport(); //Abrir transport
        if (transport) {
            
            transport.open('POST','Partida.php');
            transport.onreadystatechange = procesaPeticion_7;
            //Recoge la cabecera
            transport.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            
             transport.send("peticion=7");        
        }
}
/*------------------------------------------------------------------------------------
Nombre: procesaPeticion_7()
Proceso : Procesa la respuesta del servidor.
------------------------------------------------------------------------------------*/
function procesaPeticion_7(){


    //Si ya se ha llegao al estado 4, en el que ya ha habido una respuesta del sevridor
    if (transport.readyState == 4) {
        if (transport.status == 404) {
            alert("error");
        }
        else if (transport.status == 200) {   
        location.href = "http://localhost/HF/Partida.php";    //Recarga la pagina 
    }
}
}