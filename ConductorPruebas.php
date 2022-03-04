<?php
/**Esta página de preubas solo sirve para instanciar objetos y probar resultados de métodos de foma sencilla */

?>

<?php

//PRUEBA RESULTADOS DE CONSULTAS:
          require_once("modelo/controlador_partida.php");
          require_once("modelo/moduloConexion.php");
        
            echo "pruebas\n";
            $ctrl=new controlPartida();
            $cadTablero=$ctrl->getTablero();
            echo "cadena resultado=\n $cadTablero";
?>