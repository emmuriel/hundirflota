


//variable global
var transport = false;
var usuario;



// instanciación el objeto XMLHttpRequest

function getTransport() {


    if (window.XMLHttpRequest) {
        transport = new XMLHttpRequest();
    }
    else if (window.ActiveXObject) {
        try {
            transport = new ActiveXObject('Msxml2.XMLHTTP');
        }
        catch (err) {
            transport = new ActiveXObject('Microsoft.XMLHTTP');
        }
    }
}

/*********************************************************************************************************
                                FUNCIONES DE LA PAGINA DEFAULT.htm
                              ****************************************
**********************************************************************************************************/

/****************************************************************
FUNCION: validar_login
PRoceso: Valida que los campos del form del login contengan
         algo.
*****************************************************************/
function validar_login(){
var texto1= window.document.getElementById("txt_usuario").value;
var texto2= window.document.getElementById("txt_password").value;
var error=0;

    if (texto1==""){
        //Mostrar mensaje de error
        
            //Mostrar mensaje de error
        document.getElementById("lbl_error_usuario").visible=true;
        document.getElementById("lbl_error_usuario").innerHTML="* Obligatorio"   ; 
        error=1; 
    }
    else
    {
     document.getElementById("lbl_error_usuario").innerHTML="";
    }
    
     if (texto2==""){
        //Mostrar mensaje de error
        document.getElementById("lbl_error_passw").visible=true;
        document.getElementById("lbl_error_passw").innerHTML = "* Obligatorio";
        
        error=1; 
    }
    else{
     document.getElementById("lbl_error_passw").innerHTML="";
    }

    if (error==0){

    //Si ninguno de los dos esta vacio llama a la funcion que envie los datos del login
    enviar_login();
           
    }
}


/**************************************************************************
Nombre: enviar_login
Proceso: Envía la informacion de los campos de texto a la página aspx.vb
         a través de un objeto httpRequest
***************************************************************************/
function enviar_login(){
var texto1= window.document.getElementById("txt_usuario").value;
var texto2= window.document.getElementById("txt_password").value;


        getTransport(); //Abrir transport
        if (transport) {

//            transport.open('GET', 'Default.aspx?opcion='+ opcion +'&random=' + Math.random()); //Manda por el metodo get, en el query la opcion seleccionada en el evento onchange del DDL
            
            transport.open('POST','Default.aspx');

            transport.onreadystatechange = procesaRespuesta_login;
            //cabecera
            transport.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            
  
             //Enviar opcion
            transport.send("peticion=1&u=" + texto1 + "&p=" + texto2);
        }

}

function procesaRespuesta_login() {


    if (transport.readyState == 1) {
        //Cambiar valor de la css para mostrar la capa que contiene el gif cargando
        //document.getElementById("mensaje_carga").style.display= 'inline';
    }

    //Si ya se ha llegao al estado 4, en el que ya ha habido una respuesta del sevridor
    if (transport.readyState == 4) {

        if (transport.status == 404) {
            document.getElementById("lbl_error_usuario").innerHTML = "ERROR SERVIDOR";
            
        }
        else if (transport.status == 200) {
        //Si el usuario se ha logeado con exito, redireccionar la pagina 
        if (transport.responseText.substring(0,1)=="1"){
           // location.href = "http://localhost:49306/HF%20usuarioVSboot/Partida.htm";  //url k pilla en casa
             location.href = "Partida.htm";    //url que pilla en clase mi sitio
          //  location.href = "http://localhost:1186/HF usuarioVSboot/Partida.htm"; 
        }
        else {

        
        //Cambiar el texto del label de error
        document.getElementById("lbl_error_usuario").innerHTML = "* Datos incorrectos";
      
            }
        }
    }
}

/****************************************************************
FUNCION: registrar()
PRoceso: Redirecciona a la página de registro.
*****************************************************************/
function registrar() {
  //  location.href = "http://localhost:1186/HF usuarioVSboot/Registro.htm"; 
   // location.href= "http://localhost:49306/HF%20usuarioVSboot/Registro.htm";  //url que pilla en casa

      location.href = "http://localhost:1094/HF usuarioVSboot/Registro.htm";  //url que pilla en clase
}


/*********************************************************************************************************
                                FUNCIONES DE LA PAGINA REGISTRO.htm
                              ****************************************
**********************************************************************************************************/


/****************************************************************
FUNCION: Valida_datos()
PRoceso: Valida que los campos del form del login contengan
         algo.
*****************************************************************/
function Valida_datos() {
var nombreusuario= document.getElementById("txt_usuario").value;
var contraseña =document.getElementById("txt_password").value;
var conf_contraseña= document.getElementById("txt_conf_pass").value;

//comporbar que ningunno este vacio
if (nombreusuario==""||conf_contraseña==""||contraseña=="")
{

document.getElementById("lbl_error").innerHTML="* Los campos son obligatorios"
}
else{
    if (conf_contraseña!=contraseña){

document.getElementById("lbl_error").innerHTML="* Las contraseñas no coinciden"
    }
   else{  //todo correcto
 
document.getElementById("lbl_error").innerHTML=""


    //Llama a transport para que inserte usuario en la BBDD
    enviar_registros();
    
   }

}

}
/**************************************************************************
Nombre:  enviar_registros()
Proceso: Envía la informacion de los campos de texto a la página aspx.vb
         a través de un objeto httpRequest
***************************************************************************/

function enviar_registros(){
var texto1= window.document.getElementById("txt_usuario").value;
var texto2= window.document.getElementById("txt_password").value;


        getTransport(); //Abrir transport
        if (transport) {

//            transport.open('GET', 'Default.aspx?opcion='+ opcion +'&random=' + Math.random()); //Manda por el metodo get, en el query la opcion seleccionada en el evento onchange del DDL
            
            transport.open('POST','Resgistro_usuario.aspx');

            transport.onreadystatechange = procesaRespuesta_registro;
            //cabecera
            transport.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

             //Enviar opcion
            transport.send("&u=" + texto1 + "&p=" + texto2);
        }

}

function procesaRespuesta_registro() {


    //Si ya se ha llegao al estado 4, en el que ya ha habido una respuesta del sevridor
    if (transport.readyState == 4) {

        if (transport.status == 404) {
            document.getElementById("lbl_error").innerHTML = "ERROR SERVIDOR";
            alert("error");
        }
        else if (transport.status == 200) {
        
        
               
               
        //Si el usuario se ha logeado con exito, redireccionar la pagina 
        if (transport.responseText.substring(0,1)=="1"){
            location.href = "Partida.htm";    //url que pilla en clase
           // location.href= "http://localhost:49306/HF%20usuarioVSboot/Partida.htm";                                //url que pilla en casa
           // location.href = "http://localhost:1186/HF usuarioVSboot/Partida.htm";  
        }
 
         if (transport.responseText.substring(0,1)=="2"){
        
                //Cambiar el texto del label de error
                document.getElementById("lbl_error").innerHTML = "* El usuario ya existe.";
            }
         if (transport.responseText.substring(0,1)=="3"){
                  document.getElementById("lbl_error").innerHTML = "* Error registro.Reintentelo.";
           }
            
        }
    }
}