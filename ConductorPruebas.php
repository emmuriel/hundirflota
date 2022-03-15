<?php

/**Esta página es un conductor para preubas solo sirve para instanciar 
 * Su razon de ser es instanciar objetos y probar resultados de métodos de forma sencilla e independiente
 * para su depuración*/

?>

<?php

//PRUEBA RESULTADOS DE CONSULTAS:
require_once("modelo/controlador_partida.php");
require_once("modelo/controlador_usuario.php");
require_once("modelo/clases.php");
require_once("modelo/moduloConexion.php");
require_once("control/funciones.php");

/*echo "pruebas\n";
$ctrlPartida = new controlPartida();
$cadTablero = $ctrlPartida->getTablero();
echo "cadena resultado=\n $cadTablero";

//¿QUE COJONES DEVUELVE EXACTAMENTE EXISTE PARTIDA??? En teoria un booleano literal pero no me lo imprime con un echo
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
//PROBANDO JSON RESPUESTA  >>Solucionado<<
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

//BORRAR PARTIDA BBDD
$ctrlPartida= new controlPartida();
$ctrlPartida->borraPartida(1);
               
               
// USUARIO POR CODIGO
    // $obUsu= new Usuario (1, null ,null,null, null , null, null);



 //PROBANDO EJECUTAR DISPARO  >>> Solucionado <<<
               $ctrlPartida= new controlPartida();
               $cadenaRef="W111E000000000000000WE0000000000000000000000000000N00000000020000N000020N00S00N02020000020S0S00000S0"; //Un tablero cualquiera
               $cadOriginal=$cadenaRef;
               
               $acierto=$ctrlPartida->ejecutarDisparo($cadenaRef,0,7);  //Probar coodenadas

?>