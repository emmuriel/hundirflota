<?php 
session_name("HundirFlota");
session_start();
header('Content-Type: application/json');

/************************************************************************************************************ */
require_once("modelo/clases.php");
require_once("modelo/controlador_partida.php");
require_once("modelo/controlador_usuario.php");
require_once("modelo/moduloConexion.php");
require_once("control/funciones.php");

//Controlar que el usuario esté logeado
if ($_SESSION['usuario']) {
  $obUsu = unserialize($_SESSION['usuario']); # Deserializacion del objeto Usuario.
  $json= json_decode(file_get_contents('php://input'),true);  

  if (isset($json['peticion'])) {      #PROCESAR JSON
    $ctrlPartida = new controlPartida();
    $peticion=$json['peticion'];

    switch ($peticion) {
      case 1:  #CARGAR DATOS USUARIO
        $datosUsu = utf8_encode('BIENVENID@@ ' . $obUsu->getNombre() . '!!  Total Partidas Ganadas:  ' . $obUsu->getPuntuacion());
        $response = array ("datosUsu"=>$datosUsu);
        echo json_encode($response,JSON_FORCE_OBJECT,512); // al array hay que forzarlo a ser objeto
        break;

      case "2": #CREAR NUEVA PARTIDA
      
        //Comprueba que ya no haya una partida jugandose

        $existePartida = $ctrlPartida->partidaExiste($obUsu->getCodUsu());
        if (!$existePartida) {
          //Empieza partida
          $ctrlPartida->crearPartidaBoot($obUsu->getCodUsu());
          $partida = $ctrlPartida->obtenerPartida($obUsu->getCodUsu());
           
          responseJson($obUsu, $partida, "0");
        }else{
          $partida = $ctrlPartida->obtenerPartida($obUsu->getCodUsu());
        
          responseJson($obUsu, $partida, "0");
        }
        break;

      case "3": #PROCESAR DISPARO USUARIO
        
        $x=$json['x'];   //Recoge las coodenadas mandadas x json
        $y=$json['y'];
        procesarComprobacionDisparo($obUsu,$x,$y);
        break;


      case "4": #PROCESAR RECARGA... dispara señor servidor...

        $ganador;
        $car_gan;
        $ctrlPartida->dispara_señr_servidor($obUsu->getCodUsu());
        $partidaActualizada = $ctrlPartida->obtenerPartida($obUsu->ggetCodUsu());

        #Comprobar ganador
        $ganador = $ctrlPartida->comprobarGanador($partidaActualizada->getTablero1());

        if ($ganador == true) {
          $car_gan = "2";  //Gana señor servidor
        } else {
          $car_gan = "0";  //No hay ganador
        }
        responseJson($obUsu, $partidaActualizada, $car_gan);  #Response server

        break;

      case "5": #ABANDONAR PARTIDA
        $ctrlPartida->borraPartida($obUsu->getCodUsu());
        $ok=1;
        $oka= array ("ok"=>$ok);
          echo json_encode($oka, JSON_FORCE_OBJECT,3);  #Response server
        break;

      case "6": #ABANDONAR PARTIDA  Y CERRAR SESION
        $ctrlPartida->borraPartida($obUsu->getCodUsu());
        $ctrlUsu = new ControlUsuario();
        $erro = $ctrlUsu->cambiarEstado($obUsu->getCodUsu(), 0);
        logout();
        json_encode("bye");    #response server
 
        break;

      case "7": #TERMINAR PARTIDA Y SUMAR VICTORIA AL USUARIO
        $ctrlPartida->borraPartida($obUsu->getCodUsu());
        $ctrlUsu = new ControlUsuario();
        $ctrlUsu->upVictorias($obUsu->getCodUsu());

        break;
    }
  } else { # Peticiones NO Ajax
    if (isset($_POST['salir'])) {
      $ctrlUsu = new ControlUsuario();
      $ctrlUsu->cambiarEstado($obUsu->getCodUsu(), 0); //Cambiar estado en BBDD a no conectado
      logout();
    }

  }
} else {
  header("Location: https://localhost/HF/Error.php");
}


?>