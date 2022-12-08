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
    public function dispara_señr_servidor($codUsu,$cerebritoServidor)
    {
        $posicion_correcta = 0; //bool

        #OBTENER MATRIZ-Tablero DE USUARIO
        $partida = self::obtenerPartida($codUsu);
        //Pasar la cadena a array de caracteres
        $arr_cad = str_split($partida->getTablero1());

        /*Pongamosle talento al servidor */
        
        $posicion=$cerebritoServidor->ProximaJugada();
        $x=intval($posicion/10);
        $y=$posicion%10;
        self::tomaBombazo($codUsu, $x, $y, $cerebritoServidor);


        # $cadTabl;
        #return $cadTabl;
    }
    /*''-------------------------------------------------------------------------------------
    '' Nombre: totalTableros
    '' Proceso: Hace una cosulta a la tabla HF_tablero en la BBDD para contar el numero de registros.
    '' Entradas: Ninguna
    '' Salidas: Un entero que corresponde al total de registros de la tabla HF_tableros
    ''------------------------------------------------------------------------------------- */
    private function totalTableros()
    {
        $conexion = conexionBBDD();
        $resultado = $conexion->query("SELECT COUNT(*) FROM TableroSistema");
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
    private function getTablero()
    {
        $cadTabl = null;
        $numReg = self::totalTableros();  //Obtenermos el rango del aleatorio
        $aleatorio = rand(1, $numReg);    //Genera un aletorio dentro del rango
        $conexion = conexionBBDD();
        $resultado = $conexion->query("SELECT tablero FROM TableroSistema WHERE codTablero=$aleatorio");
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
    public function crearPartidaBoot($codJug1)
    {
        $codJug2=1; //El server
        $cadTUsu = "";  // String
        $cadTBoot = "";  // String
        $exito = false;

        if ($cadTUsu == "" | $cadTBoot=="") {
            //Tomar los tableros de la BBDD
            $cadTUsu =  self::getTablero();
            $cadTBoot = self::getTablero();
        }

        $exito = self::regPartidaBoot($codJug1,$codJug2, $cadTUsu, $cadTBoot);
        return $exito;
    }
    /*  '-------------------------------------------------------------------------------------
    ' Nombre: regPartidaBoot
    ' Proceso: Registra una partida en la Base de datos.
    ' Entradas: El codigo de usuario jugador 1,codigo de usuario jugador 1, el tablero del usuario y  el tablero del boot
    ' Salidas: Entero (Codigo de la partida creda o null si no se ha creado)
    '-------------------------------------------------------------------------------------*/
    public function regPartidaBoot($codJug1,$codJug2,$cadTablUsu, $cadTabBoot)
    {

        $exito=false;
        $turnoAleario =1; //$aleatorio = rand(0, 1); //Turno aleatorio
        $conexion = conexionBBDD();
        $resultado = $conexion->query("CALL regPartida(".$codJug1.",".$codJug2.",'".$cadTablUsu."','".$cadTabBoot."',".$turnoAleario.")");
        if ($resultado) {
            $fila = $resultado->fetch_row();
            $codPartida = $fila[0];
            $resultado->close();
        } else {
            echo "Ha ocurrido un error al generar la Partida;";
            echo "$codJug1,$cadTablUsu,$cadTabBoot,$turnoAleario";
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
        $codServer=1;
        $conexion = conexionBBDD();
        $obPartida = new Partida(null,null,null, null, null, null);
        $count=0;
        $resultado = $conexion->query("SELECT
        partida.codPartida AS codPartida,
        partida.turno AS turno,
        tableros.idJug AS idJug,
        tableros.tablero AS tablero
    FROM partida 
    INNER JOIN tableropartida AS tableros on partida.codPartida = tableros.codPartida
    WHERE partida.jug1=".$codUsu.";");
        if ($resultado) {         
            while ($fila = $resultado->fetch_array(MYSQLI_ASSOC)) { //Si el usuario tiene partida. Carga tableros y turno
               
                if ($fila['idJug']==1){
                    $codPartida= intval($fila['codPartida'],10);
                    $turno  = intval($fila['turno'],10);
                    $tableroUsu  = $fila['tablero'];
                }
                if ($fila['idJug']==2){
                    $tableroBoot  = $fila['tablero'];
                }

            }
         
                $obPartida = new Partida($codPartida,$codUsu,$codServer,$tableroUsu,$tableroBoot,$turno);
                //echo "Objeto partida: $codPartida,$codUsu,$codServer,$tableroUsu,$tableroBoot,$turno";
            
            
            $resultado->close(); // cerrar el resultset 
        } else {
            echo "No se ha podido obtener la partida para el usuario $codUsu o simpelmente no existe";
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
    ' Entradas: un entero(codigo usuario)
    ' Salidas: Ninguna, modifica la BBDD
    '------------------------------------------------------------------------------------- */
    public function borraPartida($codUsu)
    {
        $conexion = conexionBBDD();
        $conexion->query("DELETE FROM partida WHERE jug1=$codUsu");
        $conexion->close(); //cerrar conexion

    }
    /*   '-------------------------------------------------------------------------------------
    ' Nombre: tomaBombazo
    ' Proceso: A traves del codigo del usuario y de 
    '           los valores de las coordenadas del bombazo.
    '           Cambia el valor de la coordenada dependiendo de du contenido.
    '           Si el contenido de la coordenada es agua, actualiza el valor turno de la
    '           tabla de partida
    ' Entradas: El codigo de partida, 2 enteros (coordenadas), un objeto de tipo CerebroServidor.
    ' Salidas:  Cambia la cadena tablero de la BBDD y actualiza turno segun se acierte o no y el
                jugador que esté jugando.
    '------------------------------------------------------------------------------------- */
    public function tomaBombazo($codUsu, $x, $y, $SSerebritoSServidor)
    {
        $cadena_tablero = "";
        #Comprobar turno

        #abrir conexion
        $conexion = conexionBBDD();
        $resultado = $conexion->query("SELECT
        partida.turno AS turno,
        tableros.idJug AS idJug,
        tableros.tablero AS tablero
        FROM partida 
        INNER JOIN tableropartida AS tableros on partida.codPartida = tableros.codPartida
        WHERE partida.jug1=".$codUsu.";");
         if ($resultado) {         
            while ($fila = $resultado->fetch_array(MYSQLI_ASSOC)) { //Si el usuario tiene partida. Carga tableros y turno
               
                if ($fila['idJug']==1){
                    $turno  = intval($fila['turno'],10);
                    $tableroUsu  = $fila['tablero'];
                }
                if ($fila['idJug']==2){
                    $tableroBoot  = $fila['tablero'];
                }
        }  }
        $conexion->close();

        #SI EL TURNO ERA DEL JUGADOR comprobar coordenadas en tablero2 
        if ($turno == 1) {

            $acierto = self::ejecutarDisparo($tableroBoot, $x, $y);
            if ($acierto == 1) {
                $nuevo_turno = 1;  //jugador
            } else {
                $nuevo_turno = 0; //señor_servidor
            }
        } else { # turno==0 TURNO DE SERVIDOR: comprobar coodenadas en $tableroUsu
            $acierto = self::ejecutarDisparo($tableroUsu, $x, $y);
            
            //Actualizamos la memoria del Objeto servidor pa q el pobreSSito "sepa" si ha acertado y pueda hacer sus cávalas
            $SSerebritoSServidor->updtTlogico($x*10+$y, $acierto);
            $_SESSION['serverBrain'] = serialize($SSerebritoSServidor);
            //Actualizar turno
            if ($acierto == 1) {
                $nuevo_turno = 0;  //señor_servidor
            } else {
                $nuevo_turno = 1; //jugador
            }
           
        }
        #abrir conexion, actualizar la partida 
        $conexion = conexionBBDD();
        $codServer=1;
        $resultado = $conexion->query("SELECT codPartida FROM partida WHERE jug1=".$codUsu." AND jug2=".$codServer.";");
        if ($resultado){
            $fila = $resultado->fetch_row();
            $codPartida = $fila[0];
            #abrir conexion, actualizar la partida 
            $conexion = conexionBBDD();
            $resultado = $conexion->query("CALL updtPartida(".$codPartida.",'" . $tableroUsu . "','" . $tableroBoot . "'," . $nuevo_turno.");");
        }
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
        $resultado = $conexion->query("SELECT codPartida FROM partida WHERE jug1=$codUsu");
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
