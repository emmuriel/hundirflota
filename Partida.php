<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Partida</title>
    <link href="CSS/principal.css" rel="stylesheet" type="text/css" />
    <script src="JS/Partida.js" type="text/javascript"></script>
</head>
<body onunload="cierra_usuario()">
    <form id="formulario" class="formulario_partida" action="Partida.php"  method="POST">
    <!--Div para la cabecera -->
        <div id= "cabecera" class="cabecera">
        <span id="datos_usuario" visible="false" class="datos_usu"></span>
        </div>
      <!--Div para la botones -->  
    
            <table id="tbl_usuario" class="tabla_usu"></table>
            <input id="Empezar" type="submit" class="btn_empezar" value=""  onclick="Empezar_partida()"  />
            <input id="Abandonar"  class="btn_abandonar" type="submit" value="" onclick="terminar_partida()"  />
            <table id="tbl_boot" class="tabla_boot"></table>
  
    </form>
</body>
</html>


<?php
/************************************************************************************************************ */
  require_once("modelo/clases.php");
  require_once("modelo/controlador_partida.php");
  require_once("modelo/controlador_usuario.php");
  require_once("modelo/moduloConexion.php");

  //Controlar que el usuario esté logeado
  if ($_SESSION['usuario']){
    $obUsu=unserialize($_SESSION['usuario']); # Deserializacion del objeto.
    echo "<form id='logout' action='index.php' method='POST'><input type='submit' class='submit' name='salir' value='Cerrar sesion'></form><br><br><br>";
    echo "<div><p class='titulo'>Bienvenid@  ".$obUsu->getNombre()."!!</p></div>";

    if (isset($_POST['peticion'])){      #PROCESAR PETICIONES AJAX
      $ctrlPartida=New controlPartida();
      $peticion = json_decode($_POST['peticion']); 
      
      switch ($peticion){
        case "1" :  #CARGAR DATOS USUARIO

        $datosUsu = "BIENVENIDO ".$obUsu->getNombre()."  Total Partidas Ganadas: " . $obUsu->getPuntuacion()."";
        json_encode($datosUsu);

          break;
        case "2" : #CREAR NUEVA PARTIDA
        /* Consulta con el codigo de usuario si ya esxiste una partida creada y si no existe la crea. Una vez creada llama a otra funcion para crear el documento
         xml(futuro JSON) con los datos de usuario y de la partida que se le envia al cliente.*/
            $existePartida; //Boleano
            //Comprueba que ya no haya una partida jugandose
            $existePartida = $ctrlPartida->partidaExiste($obUsu->getCod());
            if (!$existePartida){
              //Empieza partida
              $ctrlPartida->crearPartidaBoot($obUsu->getCod());
              $partida=$ctrlPartida->obtenerPartida($obUsu->getCod());

              //Crear el XML /JSONcon los datos del usuario y de la partida y si el usuario es ganador 
              crearCadena($obUsu, $partida, "0");
            }
          break;
        case "3" : #PROCESAR DISPARO USUARIO
              procesarComprobacionDisparo($obUsu);
          break;
  
        case "4" : #PROCESAR RECARGA... dispara señor servidor...

          $ganador;
          $car_gan;
          $ctrlPartida->dispara_señr_servidor($obUsu->getCod());
          $partidaActualizada=$ctrlPartida->obtenerPartida($obUsu->getCod());

          #Comprobar ganador
          $ganador = $ctrlPartida->comprobarGanador($partidaActualizada->getTablero1());

          if($ganador==true){
              $car_gan = "2";  //Gana señor servidor
            }
            else{
              $car_gan = "0";  //No hay ganador
            }
          crearCadena($obUsu, $partidaActualizada,$car_gan);  //Crear httpResponse

          break;

        case "5" : #ABANDONAR PARTIDA
          $ctrlPartida->borraPartida($obUsu->getCod());

          break;

        case "6" : #ABANDONAR PARTIDA  Y CERRAR SESION
          $ctrlPartida->borraPartida($obUsu->getCod());
          $ctrlUsu=new ControlUsuario();
          $erro=$ctrlUsu->cambiarEstado($obUsu->getCod(),0);
          logout();
          json_encode("bye");
        
          break;
    
        case "7" : #TERMINAR PARTIDA Y SUMAR VICTORIA AL USUARIO
        $ctrlPartida->borraPartida($obUsu->getCod());
        $ctrlUsu=new ControlUsuario();
        $ctrlUsu->upVictorias($obUsu->getCod());
          
          break;

      } 
    }
    else { # Peticiones NO Ajax
      if(isset($_POST['salir'])) {  
        $ctrlUsu= new ControlUsuario ();
        $ctrlUsu->cambiarEstado($obUsu->getCodUsu(), 0); //Cambiar estado en BBDD a no conectado
        logout(); 
      }
    } 
 }
  else { 
    header("Location: https://localhost/HF/Error.php");
  }


?>