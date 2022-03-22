<?php
require_once("moduloConexion.php");
require_once("clases.php");
class controlPartida
{

    /*
    ''-------------------------------------------------------------------------------------
    '' Nombre: dispara_señr_servidor
    '' Proceso: Simula un sistema de inteligencia...recorre la matriz del tablero del
    ''          usuario leyendo los valores # y X.
                dE MOMENTO DIAPARA ALEATORIAMENTE. PROXIMAMENTE IMPLEMENTAREMOS UN ARBOL DE DECISIONES
    '' Entradas: Ninguna
    '' Salidas: Una cadena que representa a la matriz de tablero
    ''------------------------------------------------------------------------------------- */
    public function dispara_señr_servidor($codUsu)
    {
        $posicion_correcta = 0; //bool

        #OBTENER MATRIZ-Tablero DE USUARIO
        $partida = self::obtenerPartida($codUsu);
        //Pasar la cadena a array de caracteres
        $arr_cad = str_split($partida->getTablero1());

        //Recorrer array pasandolo a tablero
        /*Hablando de posiciones,en el array unidimensional, el contador i establece el valor de la unidad y el contador
        j el valor de la decena,juntos (j*10 + i) establece lo que en una matriz con 2 for seria:

        for ($i = 0; $i < 9; $i++) {
            for ($j = 0; $j < 9; $j++) {
                $matriz[$i][$j] = $arr_cad[$i * 10 + $j];
            }
        }   Pero con un array dimesional y el calculo del indice mencionado podemos solucionar el problema sin necesidad de 
            darle más carga de trabajo al servidor, aunque nosotros los humanos entendamos mejor las coordenadas en una matriz */

        while ($posicion_correcta == 0) {
            $x = self::getCoordenada(10);
            $y = self::getCoordenada(10);
            if ($arr_cad[$x * 10 + $y] == "#" || $arr_cad[$x * 10 + $y] == "x") {   //No es correcto si la posición ha sido bombardeada
                $posicion_correcta = 0;
            } else {
                $posicion_correcta = 1;
            }
        }
        self::tomaBombazo($codUsu, $x, $y);

        # $cadTabl;
        #return $cadTabl;
    }
    /*''-------------------------------------------------------------------------------------
    '' Nombre: totalTableros
    '' Proceso: Hace una cosulta a la tabla HF_tablero en la BBDD para contar el numero de registros.
    '' Entradas: Ninguna
    '' Salidas: Un entero que corresponde al total de registros de la tabla HF_tableros
    ''------------------------------------------------------------------------------------- */
    public function totalTableros()
    {
        $conexion = conexionBBDD();
        $resultado = $conexion->query("SELECT COUNT(*) FROM hf_tablero");
        if ($resultado) {
            $fila = $resultado->fetch_row();
            $total = $fila[0];

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
    public function getTablero()
    {
        $cadTabl = null;
        $numReg = self::totalTableros();  //Obtenermos el rango del aleatorio
        $aleatorio = rand(1, $numReg);    //Genera un aletorio dentro del rango
        $conexion = conexionBBDD();
        $resultado = $conexion->query("SELECT tablero FROM hf_tablero WHERE codTablero=$aleatorio");
        if ($resultado) {
            $fila = $resultado->fetch_row();
            $cadTabl = $fila[0];
            $resultado->close(); // cerrar el resultset 
        } else {
            echo "El tablero mandado está fuera de rango o la consulta está generando error\n";
            echo "El codTablero = $aleatorio ";
        }
        //$resultado->close(); // cerrar el resultset 
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
    public function crearPartidaBoot($codUsu)
    {

        $cadTUsu = "";  // String
        $cadTBoot = "";  // String
        $exito = false;

        if ($cadTUsu == "" | $cadTBoot=="") {
            //Tomar los tableros de la BBDD
            $cadTUsu =  self::getTablero();
            $cadTBoot = self::getTablero();
        }
        //echo "Tablero Usu: ". $cadTUsu . "Tablero Boot: ". $cadTBoot."\n";

        $exito = self::regPartidaBoot($codUsu, $cadTUsu, $cadTBoot);
        return $exito;
    }
    /*  '-------------------------------------------------------------------------------------
    ' Nombre: regPartidaBoot
    ' Proceso: Registra una partida en la Base de datos.
    ' Entradas: El codigo de usuario, el tablero del usuario y  el tablero del boot
    ' Salidas: Un boolean (True si la partida se ha creado con exito y False delo contrario)
    '-------------------------------------------------------------------------------------*/
    public function regPartidaBoot($codUsu, $cadTablUsu, $cadTabBoot)
    {
        $exito = false;
        $turnoAleario =1; //$aleatorio = rand(0, 1); //Turno aleatorio
        $conexion = conexionBBDD();
        $resultado = $conexion->query("INSERT INTO hf_partidaBoot (codUsu,tablero1,tablero2,turno) VALUES ('".$codUsu."','".$cadTablUsu."','".$cadTabBoot."','".$turnoAleario."')");
        if ($resultado) {
            $exito = true;
        } else {
            echo "Ha ocurrido un error al generar la Partida;";
            echo "$codUsu,$cadTablUsu,$cadTabBoot,$turnoAleario";
        }
       // $resultado->close(); // cerrar el resultset 
        $conexion->close(); //cerrar conexion

        return $exito;
    }

    /*'-------------------------------------------------------------------------------------
    ' Nombre: obtenerPartida
    ' Proceso: Consulta en la BBDD si existe una partida creada con el codigo de jugador
    '           y devuleve un objeto partida inicializado con los datos.
    ' Entradas: un enterio(codigo usuario)
    ' Salidas: Un objeto de tipo cls_partida
    '-------------------------------------------------------------------------------------*/
    public function obtenerPartida($codUsu)
    {
        $conexion = conexionBBDD();
        $resultado = $conexion->query("SELECT tablero1,tablero2,turno FROM hf_partidaboot WHERE codUsu=$codUsu");
        if ($resultado) {
            $fila = $resultado->fetch_row();
            if(isset($fila)){
                $obPartida = new Partida($codUsu, $fila[0], $fila[1], $fila[2]);
            }
            else{
                echo "No se ha podido obtener la partida para el usuario $codUsu o simpelmente no existe";
                $obPartida = new Partida(null, null, null, null); 
            }
            
            
            $resultado->close(); // cerrar el resultset 
        } else {
            echo "No se ha podido obtener la partida para el usuario $codUsu o simpelmente no existe";
            $obPartida = new Partida(null, null, null, null);
        }
        //$resultado->close();
        $conexion->close(); //cerrar conexion

        return $obPartida;
    }
    /*
    '-------------------------------------------------------------------------------------
    ' Nombre: borraPartida
    ' Proceso: Elimina de la tabla HF_partidas de la BBDD una partida dado el codigo del 
    '           usuario
    ' Entradas: un enterio(codigo usuario)
    ' Salidas: Ninguna, modifica la BBDD
    '------------------------------------------------------------------------------------- */
    public function borraPartida($codUsu)
    {
        $conexion = conexionBBDD();
        $conexion->query("DELETE FROM hf_partidaboot WHERE codUsu=$codUsu");
        $conexion->close(); //cerrar conexion

    }
    /*   '-------------------------------------------------------------------------------------
    ' Nombre: tomaBombazo
    ' Proceso: A traves del codigo del usuario y de 
    '           los valores de las coordenadas del bombazo.
    '           Cambia el valor de la coordenada dependiendo de du contenido.
    '           Si el contenido de la coordenada es agua, actualiza el valor turno de la
    '           tabla de partida
    ' Entradas: El codigo de usuario, 2 enteros (coordenadas)
    ' Salidas:  Cambia la cadena tablero de la BBDD y actualiza turno segun se acierte o no y el
                jugador que esté jugando.
    '------------------------------------------------------------------------------------- */
    public function tomaBombazo($codUsu, $x, $y)
    {
        $cadena_tablero = "";
        #Comprobar turno

        #abrir conexion
        $conexion = conexionBBDD();
        $resultado = $conexion->query("SELECT turno, tablero1, tablero2 FROM hf_partidaBoot WHERE codUsu=$codUsu");
        $resultado->data_seek(0);
        while ($fila = $resultado->fetch_assoc()) { //Si el usuario tiene partida. Carga tableros y turno
            $turno  = intval($fila['turno'],10);
            $tableroUsu   = $fila['tablero1'];
            $tableroBoot   = $fila['tablero2'];
        }
        $conexion->close();

        #SI EL TURNO ERA DEL JUGADOR comprobar coordenadas en tablero2 
        if ($turno == 1) {

            $acierto = self::ejecutarDisparo($tableroBoot, $x, $y);
            if ($acierto == 1) {
                $nuevo_turno = 1;  //Turno sigue en jugador
            } else {
                $nuevo_turno = 0; //Turno pasa a señor_servidor
            }
        } else { # turno==0 TURNO DE SERVIDOR: comprobar coodenadas en $tableroUsu
            $acierto = self::ejecutarDisparo($tableroUsu, $x, $y);
            if ($acierto == 1) {
                $nuevo_turno = 0;  //Turno sigue en señor_servidor
            } else {
                $nuevo_turno = 1; //Turno pasa a jugador
            }
        }
        
        //echo "el turno es". $nuevo_turno;

        #abrir conexion, actualizar la partida
        $conexion = conexionBBDD();
        $resultado = $conexion->query("UPDATE hf_partidaBoot SET tablero1='" . $tableroUsu . "' , tablero2 = '" . $tableroBoot . "', turno='" . $nuevo_turno . "' WHERE codUsu=$codUsu");
        $conexion->close();
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
    public function ejecutarDisparo(&$cadTabl, $x, $y)
    {
        $diana = 0;
        $cadena = ""; //String
        #Pasar la cadena a array de caracteres
        $cpCadTabl=$cadTabl;
        $arr_cad = str_split($cpCadTabl);

        $posicion= $arr_cad[$x * 10 + $y];
        switch ($posicion){
             #COMPROBAR DISPARO
            case "0":
                $arr_cad[$x * 10 + $y] = "#";  //AGUA
                $diana = 0;
                break;

            case "1":
                $arr_cad[$x * 10 + $y] = "x"; //TOCADO'
                $diana = 1;
                break;
            case "2":
                $arr_cad[$x * 10 + $y] = "x"; //TOCADO'
                $diana = 1;
                break;
            case "N":
                $arr_cad[$x * 10 + $y] = "x"; //TOCADO'
                $diana = 1;
                break;

            case "S":
                $arr_cad[$x * 10 + $y] = "x"; //TOCADO'
                $diana = 1;
                break;
            case "W":
                $arr_cad[$x * 10 + $y] = "x"; //TOCADO'
                $diana = 1;
                break;
            case "E":
                $arr_cad[$x * 10 + $y] = "x"; //TOCADO'
                $diana = 1;
                break;
        }

             #VOLVER A PASAR MATRIZ A CADENA contatenando caracteres
             for ($i = 0; $i <100; $i++) { 
                
                    $cadena .= $arr_cad[$i];
            }
        $cadTabl = $cadena;  #SOBRESCRIBIR LA CADENA DE ENTRADA/SALIDA (* pasada por referencia)

       // echo "\nLa cadena generada al final es :".$cadTabl;
       // echo "\n Diana es == a :". $diana; //--------------------------------   TEST COONDUCTOR

        return $diana;
    }
    /* '-------------------------------------------------------------------------------------
    ' Nombre: get coordenada
    ' Proceso: genera aleatoriamente un numero entre 0 y 9
    ' Entradas: un entero
    ' Salidas: Un entero
    '-------------------------------------------------------------------------------------*/
    public function getCoordenada($num)
    {
        $aleatorio = rand(1, $num);
        $aleatorio = $aleatorio - 1;
        return $aleatorio;
    }
    /*    '-------------------------------------------------------------------------------------
    ' Nombre: partidaExiste
    ' Proceso: Consulta en la BBDD si existe una partida creada con el codigo de jugador 
    ' Entradas: un enterio(codigo usuario)
    ' Salidas: Un booleano, True si el usuario ya esta juagndo una partida, false sino
    '------------------------------------------------------------------------------------- */
    public function partidaExiste($codUsu)
    {
        $existe=false;
        $conexion = conexionBBDD();
        $resultado = $conexion->query("SELECT codUsu,tablero1,tablero2,turno FROM hf_partidaBoot WHERE codUsu=$codUsu");
        $resultado->data_seek(0);
        while ($fila = $resultado->fetch_assoc()) { //Si el usuario tiene partida. Carga tableros y turno
            $existe = true;
        }
        return $existe;
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
        $ganador = true;
        $arr_cad = array(100);

        #Pasar la cadena a array de caracteres
        $arr_cad = str_split($cadTabl);
        for ($i = 0; $i <= 99; $i++) {
            if ($arr_cad[$i] == "1" || $arr_cad[$i] == "2" || $arr_cad[$i] == "N" || $arr_cad[$i] == "S" || $arr_cad[$i] == "W" || $arr_cad[$i] == "E") {
                $ganador = false;
            }
        }
        return $ganador;
    }
    /* '-------------------------------------------------------------------------------------
    ' Nombre: mascaraTablero
    ' Proceso: Recorre un array generado con la cadena del tablero, e inicializa otro solo con 
                casilla explotadas y sin explotar. Este array es el que se envia al cliente como
                array contrincante, evitando revelar las posiciones reales de los objetivos.
    ' Entradas: una cadena
    ' Salidas: Una cadena
    '------------------------------------------------------------------------------------- */
    public function mascaraTablero($cadTabl){
        $arrBD= str_split($cadTabl);
        $mascara="";
 
    
        for ($i=0;$i<100;$i++){
            if ($arrBD[$i]=="x"||$arrBD[$i]=="0"||$arrBD[$i]=="#"){
                $mascara .=$arrBD[$i];           
            }
            else{
                $mascara .="0";   //Lo mmarcará todo como sin explotar
            }
        }
        return $mascara;
    }
}
