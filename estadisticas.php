<?php
session_name("HundirFlota");
session_start();
header('Content-Type: application/json');

require_once("modelo/clases.php");
require_once("modelo/controlador_partida.php");
require_once("modelo/controlador_usuario.php");
require_once("modelo/moduloConexion.php");


//Controlar que el usuario esté logeado
if ($_SESSION['usuario']) {
  $obUsu = unserialize($_SESSION['usuario']); # Deserializacion del objeto Usuario.
  $json= json_decode(file_get_contents('php://input'),true); 
  switch($json['peticion']){ 
    case 1: //ranking
        $mnjUsu=new ControlUsuario();
        $ranking=$mnjUsu->getRanking();
        echo json_encode($ranking, JSON_FORCE_OBJECT);
    break;
    case 2: //Ratio

    break;

  }

}
else{
    session_destroy();
    setcookie('HundirFlota','',time()-100);
    header("Location: Error.php");
}
?>