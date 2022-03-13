<?php

/**Esta página de preubas solo sirve para instanciar objetos y probar resultados de métodos de foma sencilla */

?>

<?php

//PRUEBA RESULTADOS DE CONSULTAS:
require_once("modelo/controlador_partida.php");
require_once("modelo/moduloConexion.php");

/*echo "pruebas\n";
$ctrlPartida = new controlPartida();
$cadTablero = $ctrlPartida->getTablero();
echo "cadena resultado=\n $cadTablero";

$existePartida = $ctrlPartida->partidaExiste(7);
echo "\n";

echo $existePartida;
if (empty($existePartida)){
    echo "vacio";
}
if(isset($existePartida)){
    echo "eta ini";
}
if($existePartida===false){
    echo "Es estrictamente falso";
}
if (is_bool($existePartida)){
    echo "Es booleano";
    if ($existePartida==false){
        echo "y ademas falso";
    }
}*/
/*if (!$existePartida) {
  //Empieza partida
  $exito=$ctrlPartida->crearPartidaBoot(7);
  if ($exito){
    $partida = $ctrlPartida->obtenerPartida(7);
    //Crear el XML /JSONcon los datos del usuario y de la partida y si el usuario es ganador 
    echo $partida->getTablero1() . "|" . $partida->getTablero2() . "|" . $partida->getTurno() . "|";
   
}
  /*$respuesta= array("usuario"=>7,
                    "partida"=>array(
                            "t1"=>$partida->getTablero1(),
                            "t2"=> $partida->getTablero2(),
                            "turno"=> $partida->getTurno()),
                    "ganador"=>0);

                    foreach ($respuesta as $valor){
                        echo $valor;
                      }*/

//}
                      $ctrlPartida->borraPartida(7);

?>