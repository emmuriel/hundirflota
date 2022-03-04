<?php
require_once("moduloConexion.php");
require_once("clases.php");
class controlPartida{

    /*
    ''-------------------------------------------------------------------------------------
    '' Nombre: dispara_señr_servidor
    '' Proceso: Simula un sistema de inteligencia...recorre la matriz del tablero del
    ''          usuario leyendo los valores # y X.
    '' Entradas: Ninguna
    '' Salidas: Una cadena que representa a la matriz de tablero
    ''------------------------------------------------------------------------------------- */
    public function dispara_señr_servidor ()
    {
       # $cadTabl;
        #return $cadTabl;
    }

        /*''-------------------------------------------------------------------------------------
    '' Nombre: generarTablero
    '' Proceso: 
    '' Entradas: Ninguna
    '' Salidas: Una cadena que representa a la matriz de tablero
    ''------------------------------------------------------------------------------------- */
    public function generarTablero (){
        
    }
    
        /*''-------------------------------------------------------------------------------------
    '' Nombre: totalTableros
    '' Proceso: Hace una cosulta a la tabla HF_tablero en la BBDD para contar el numero de registros.
    '' Entradas: Ninguna
    '' Salidas: Un entero que corresponde al total de registros de la tabla HF_tableros
    ''------------------------------------------------------------------------------------- */
    public function totalTableros (){
        $conexion=conexionBBDD();
        $resultado=$conexion->query ("SELECT COUNT(*) FROM hf_tablero");   
        if ($resultado) {
            $fila = $resultado->fetch_row();
            $total=$fila[0];
            
            $resultado->close(); // cerrar el resultset 
        }
          $conexion->close(); //cerrar conexion

        return $total;
    }
    /*''-------------------------------------------------------------------------------------
    '' Nombre: getTablero
    '' Proceso: Hace una consulta a la BBDD y extrae una cadena aleatoria de la tabla HF_tableros
    '' Entradas: Ninguna
    '' Salidas: Una cadena que representa a la matriz de tablero o null si el rango si ocurre error
    ''------------------------------------------------------------------------------------- */
    public function getTablero (){
        $cadTabl=null;
        $numReg=self::totalTableros();  //Obtenermos el rango del aleatorio
        $aleatorio= rand(1,$numReg);    //Genera un aletorio dentro del rango
        $conexion=conexionBBDD();
        $resultado=$conexion->query ("SELECT tablero FROM hf_tablero WHERE codTablero=$aleatorio");   
        if ($resultado) {
            $fila = $resultado->fetch_row();
            $cadTabl=$fila[0]; 
            
            $resultado->close(); // cerrar el resultset 
        }
        else {
            echo "El tablero mandado está fuera de rango o la consulta está generando error\n";
            echo "El codTablero = $aleatorio ";
        }
          $conexion->close(); //cerrar conexion

        return $cadTabl;
    }
    /*
    '-------------------------------------------------------------------------------------
    ' Nombre: crearPartidaBoot
    ' Proceso: Genera automáticamente una partida con el usuario que lo solicita y la registra en la
    '           Base de datos.
    ' Entradas: El codigo del usuario
    ' Salidas: Un boolean (True si la partida se ha creado con exito y False delo contrario)
    '------------------------------------------------------------------------------------- */
    public function crearPartidaBoot()
    {
        $exito;
        return $exito;
    }
    /*  '-------------------------------------------------------------------------------------
    ' Nombre: regPartidaBoot
    ' Proceso: Registra una partida en la Base de datos.
    ' Entradas: El codigo de usuario, el tablero del usuario y  el tablero del boot
    ' Salidas: Un boolean (True si la partida se ha creado con exito y False delo contrario)
    '-------------------------------------------------------------------------------------*/
    public function regPartidaBoot($codUsu, $cadTablUsu, $cadTabBoot){
        $exito;
        return $exito;
    }
    /*   '-------------------------------------------------------------------------------------
    ' Nombre: tomaBombazo
    ' Proceso: A traves del codigo del usuario y de 
    '           los valores de las coordenadas del bombazo.
    '           Cambia el valor de la coordenada dependiendo de du contenido.
    '           Si el contenido de la coordenada es agua, actualiza el valor turno de la
    '           tabla de partida
    ' Entradas: El codigo de usuario, 2 enteros (coordenadas)
    ' Salidas:  Cambia la cadena tablero de la BBDD y actualiza turno
    '------------------------------------------------------------------------------------- */
    public function tomaBombazo ($codUsu, $x, $y){

    }
    
    /* '-------------------------------------------------------------------------------------
    ' Nombre: ejecutarDisparo
    ' Proceso: A partir de una cadena de 100 caracteres crea una matriz de caracteres, comprueba
    '           la coordenada x, y , actualiza la cadena con el valor que le corresponde al 
    '           disparo y devuele true si acierta y false si falla el bombazo.
    ' Entradas: Una cadena por referencia, y dos enteros por valor(coordenadas disparo)
    ' Salidas: la cadena actualizada que se pasa por referencia y es de entrada/salida
    '           un booleano (True si el disparo ha dado en el blanco)(false de lo 
    '           contrario)
    '------------------------------------------------------------------------------------- */
    public function ejecutarDisparo (&$cadTabl, $x, $y)
    {
        $diana;
        return $diana;
    }
    /* '-------------------------------------------------------------------------------------
    ' Nombre: get coordenada
    ' Proceso: genera aleatoriamente un numero entre 0 y 9
    ' Entradas: un entero
    ' Salidas: Un entero
    '-------------------------------------------------------------------------------------*/
    public function getCoordenada ($num)
    {
        $num2;
        return $num2;
    }
    /*    '-------------------------------------------------------------------------------------
    ' Nombre: partidaExiste
    ' Proceso: Consulta en la BBDD si existe una partida creada con el codigo de jugador 
    ' Entradas: un enterio(codigo usuario)
    ' Salidas: Un booleano, True si el usuario ya esta juagndo una partida, false sino
    '------------------------------------------------------------------------------------- */
    public function partidaExiste ($codUsu){
        $existe;
        return $existe;
    }

    /*
    '-------------------------------------------------------------------------------------
    ' Nombre: borraPartida
    ' Proceso: Elimina de la tabla HF_partidas de la BBDD una partida dado el codigo del 
    '           usuario
    ' Entradas: un enterio(codigo usuario)
    ' Salidas: Ninguna, modifica la BBDD
    '------------------------------------------------------------------------------------- */
    public function borraPartida ($codUsu)
    {

    }
    /* '-------------------------------------------------------------------------------------
    ' Nombre: comprobarGanador
    ' Proceso: Recorre un array generado con la cadena del tablero, determinando si aun
    '           existe una casilla de barco sin explotar (caracter "1")
    ' Entradas: una cadena
    ' Salidas: Un booleano, True si no existen casillas con el caracter "1", False de lo 
    '           contrario.
    '------------------------------------------------------------------------------------- */
    public function comprobarGanador($cadTabl)
    {
        $ganador;
        return $ganador;

    }
    /* 
    '-------------------------------------------------------------------------------------
    ' Nombre: obtenerPartida
    ' Proceso: Consulta en la BBDD si existe una partida creada con el codigo de jugador
    '           y devuleve un objeto partida inicializado con los datos.
    ' Entradas: un enterio(codigo usuario)
    ' Salidas: Un objeto de tipo cls_partida
    '-------------------------------------------------------------------------------------*/
    public function obtenerPartida ($codUsu)
    {
        $obPartida;
        return $obPartida;
    }



    /* */
    /* */
}

?> 