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
  if($json['peticion']==1){  //request: Datos usuario
    $respuesta=array();
    $datos= array('nombre'=>$obUsu->getNombre(), 'victorias'=>$obUsu->getPuntuacion(),'conexiones'=>$obUsu->getConexion());
    $respuesta[0]=$datos;

    echo json_encode($respuesta,JSON_FORCE_OBJECT);
  }
  if($json['peticion']==2){ //request: Cambio password
 
    
    if (!$json['cPwd']  || !$json['nPwd'] ){
      $error= 5; //Campos vacios
    }else {
      $currencyPwd=$json['cPwd'];
      $newPwd=$json['nPwd'];
      $ctrlUsu = new ControlUsuario();
      $error=$ctrlUsu->cambiarPwd($obUsu->getCodUsu(),$currencyPwd, $newPwd);

    }
    $respuesta=array(); //response
    $datos= array('error'=>$error);
    $respuesta[0]=$datos;
    echo json_encode($respuesta,JSON_FORCE_OBJECT);

  }

}
else{
    session_destroy();
    setcookie('HundirFlota','',time()-100);
    header("Location: index.php");
}
?>