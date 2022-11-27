<?php

class Partida{

    Private $jug1;   //Integer
    Private $tablero1;  //String
    Private $tablero2; //String
    Private $turno;  //Boolean


    /*Constructores */
    public function __construct($codJug,$tablero1,$tablero2,$turno){

        $this->jug1=$codJug;
        $this->tablero1=$tablero1;
        $this->tablero2=$tablero2;
        $this->turno=$turno;
    
    }
    //GETERS
    public function getJug1(){
        return $this->jug1;
    }
    public function getTablero1(){
        return $this->tablero1;
    }
    public function getTablero2(){
        return $this->tablero2;
    }
    public function getTurno(){
        return $this->turno;
    }

    //SETTERS
    public function setJug1($codJug){
         $this->jug1=$codJug;
    }
    public function setTablero1($tablero){
        $this->tablero1=$tablero;
    }
    public function setTablero2($tablero){
        $this->tablero2=$tablero;
    }
    public function setTurno($trn){
        $this->turno=$trn;
    }
} 

/********************************************************************************
 * Clase Usuario-> define una clase Usuario cuyos atributos coinciden
 * con los campos de la tabla hf_usuario de la BBDD
********************************************************************************/

class Usuario{
    Private $cod_usu; //Integer
    Private $nombre; //String
    Private $email; //string
    Private $contrasenia; //String
    Private $puntuacion = 0;//Integer
    Private $conexiones = 0; 
    Private $estado = 0; //Integer

    /*Constructores */
    public function __construct($codUsu,$nombre,$mail,$pwd,$puntuacion,$estado, $numconex){

        $this->cod_usu=$codUsu;
        $this->nombre=$nombre;
        $this->email=$mail;
        $this->contrasenia=$pwd;
        $this->puntuacion=$puntuacion;
        $this->conexiones=$numconex;
        $this->estado=$estado;
    
    }

    //GETERS
    public function getCodUsu(){
        return $this->cod_usu;
    }
    public function getNombre(){
        return $this->nombre;
    }
    public function getEmail(){
        return $this->email;
    }
    public function getPwd(){
        return $this->contrasenia;
    }
    public function getPuntuacion(){
        return $this->puntuacion;
    }
    public function getEstado(){
        return $this->estado;
    }
    public function getConexion(){
        return $this->conexiones;
    }

    //SETTERS
    public function setCodUsu($codUsu){
         $this->cod_usu=$codUsu;
    }
    public function setNombre($nombre){
        $this->nombre=$nombre;
    }
    public function setEmail($email){
        $this->email=$email;
    }
    public function setPwd($pwd){
        $this->contrasenia=$pwd;
    }
    public function setPuntuacion($ptos){
        $this->puntuacion=$ptos;
    }
    public function setEstado($estado){
        $this->estado=$estado;
    }
}


/********************************************************************************
 * Clase CerebroServidor-> Implementa una lógica de juego del lado del servidor 
 * para una partida contra un usuario.
********************************************************************************/

class CerebroServidor{
    //Array unidimesional de caracteres que se inicializa en */ se actualiza con 0/1 equivale a true/false
    Private $TableroLogico=array("?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?");
    Private $ultimas_5jug=array(); //Array bidimensional de objetos jugadas
    Private $ultima=-1; 
    Private $acierto=-1;
    private $lineaDeAcierto=array(); //Array unidimensional que guarda las posiciones de la linea de acierto
    private $rumbo= 0;
    private $siguientePetardazo=-1;
    /*Constructores */
    public function __construct(){}

    //GETERS
    public function getTLogico(){
        return $this->TableroLogico;
    }
    public function getUltimas5jugadas(){
        return $this->ultimas_5jug;
    }
    public function getmapabarcosDescubiertos(){
        return $this->emailmapabarcosDescubiertos;
    }
    public function getlineaDeAcierto(){
        return $this->lineaDeAcierto;
    }
    public function getrumbo(){
        return $this->rumbo;
    }
    public function getSiguientePetardazo(){
        return $this->siguientePetardazo;
    }
    public function getAcierto(){
        return $this->acierto;
    }
    public function getUltima(){
        return $this->ultima;
    }

    //SETTERS
    public function setTLogico($tl){
         $this->TableroLogico=$tl;
    }
    public function setUltimas5jugadas($ultimas_5jug){
        $this->ultimas_5jug=$ultimas_5jug;
    }
    public function setmapabarcosDescubiertos($mapabarcosDescubiertos){
        $this->mapabarcosDescubierto=$mapabarcosDescubiertos;
    }
    public function setlineaDeAcierto($lineaDeAcierto){
        $this->lineaDeAcierto=$lineaDeAcierto;
    }
 
    //METODOS:
    /*****************************************************************************************
    Nombre: dondeEstoy()
    Entradas: 1 entero. Una posición en el array unidimensional.
    Salidas: 1 Entero. Simboliza el lugar "lógico" conceptualmente hablando del tablero de esta posicion.
                    
    Mapa conceptual:             Mapa Conceptual resumen: 
                                                        
                                                0- Zona centro. Al menos una casilla alrededor
            1222222223          1 2 2 2 3       1- Esquina Superior Izquierda
            8999999994          8 9 9 9 4       2- Borde Superior
            8900000094          8 9 0 9 4       3- Esquina Superior Derecha
            8900000094          8 9 9 9 4       4- Borde Lateral Derecho
            8900000094          7 6 6 6 5       5- Esquina Inferior Derecha   
            8900000094                          6- Borde Inferior    
            8900000094                          7- Esquina Inferior Izquierda
            8900000094                          8- Borde Lateral Izquierdo
            8999999994                          9- Posición pre-Borde
            7666666665
    */

    public function dondeEstoy($posicion){
        $posicionConceptual=0; //Por defecto estamos en zona 0
        if ($posicion==0){        
            $posicionConceptual=1;
        /*}else if   ($posicion>11&&$posicion<=18 || $posicion>=81 && $posicion<=88 || 
                    $posicion%10==1 && $posicion!=1 && $posicion!=91 ||  
                    $posicion%10==8 && $posicion!=8 && $posicion!=98){
            $posicionConceptual=9;  */
        }else if ($posicion>0&&$posicion<9){
            $posicionConceptual=2;
        }else if ($posicion==9){ 
            $posicionConceptual=3;     
        }else if($posicion==90){
            $posicionConceptual=7;
        }else if ($posicion>90&&$posicion<99){
            $posicionConceptual=6;
        }else if($posicion==99){
            $posicionConceptual=5;
        }else if(intval($posicion/10)==0){  
            $posicionConceptual=8;
        }else if($posicion%10==9){  
            $posicionConceptual=4;
        }   


        return $posicionConceptual;
    }

    //ACTUALIZADORES:

    /*****************************************************************************************
    Nombre: aguaDiagonal()
    Entradas: 1 entero. Que simboliza la posición en el array Tablero lógico en la que se ha efectuado un disparo con resultado certero.
    Salidas: No tiene, actualiza el tablero lógico eliminando como posibles posiciones las posiciones
             contiguas en diagonal de la posición pasada por valor 
    */

    public function aguaDiagonal($posicion){
        
        $aquiEstoy=self::dondeEstoy($posicion);
        //Las diagonales
        $d1=-11;
        $d2=-9;
        $d3=+11;
        $d4=+9;


            switch ($aquiEstoy){
                case 1: //Esquina Sup Izquierda
                    $d3+=$posicion;
                    $this->TableroLogico[$d3]="*";
                break;
                case 2: //Borde Sup
                    $d3+=$posicion;
                    $d4+=$posicion;
                    $this->TableroLogico[$d3]="*";
                    $this->TableroLogico[$d4]="*";
                break;
                case 3: //Esquina Sup Derecha
                    $d4+=$posicion;
                    $this->TableroLogico[$d4]="*";
                break;
                case 4: //Borde Derecho
                    $d1+=$posicion;
                    $d4+=$posicion;
                    $this->TableroLogico[$d1]="*";
                    $this->TableroLogico[$d4]="*";
                break;
                case 5: //Esquina Inf Derecha
                    $d1+=$posicion;
                    $this->TableroLogico[$d1]="*";
                break;
                case 6: //Borde Inferior
                    $d1+=$posicion;
                    $d2+=$posicion;
                    $this->TableroLogico[$d1]="*";
                    $this->TableroLogico[$d2]="*";
                break;
                case 7: //Esquina Inf Izquierda
                    $d2+=$posicion;
                    $this->TableroLogico[$d2]="*";
                break;
                case 8: //Borde Izquierdo
                    $d2+=$posicion;
                    $d3+=$posicion;
                    $this->TableroLogico[$d2]="*";
                    $this->TableroLogico[$d3]="*";
                break;
                default: //Zona central
                    $d1+=$posicion;
                    $d2+=$posicion;
                    $d3+=$posicion;
                    $d4+=$posicion;
                    $this->TableroLogico[$d1]="*";
                    $this->TableroLogico[$d2]="*";
                    $this->TableroLogico[$d3]="*";
                    $this->TableroLogico[$d4]="*";
                break;
            }
    }



    /*Entradas: 2 enteros. Posición del último disparo y si ha sido acierto o no (0/1) */
    public function updtTlogico($posicion,$acierto){

        $this->TableroLogico[$posicion]=strval($acierto); //Actualiza tablero lógico
        $this->ultima=$posicion;
        $this->acierto=$acierto;
        if ($acierto == 1){
            //Metodos lógicos -- Agua en las diagonales
                self::AguaDiagonal($posicion);    //Actualiza tablero lógico
                
        }
    
        self::brujula($posicion,$acierto); //Determina rumbo y siguiente posicion
    }
/*Ejecuta el siguiente tiro anotado. Si el atributo tiene valor -1 es que es el primer disparo y es añleatorio 
*/
    public function ProximaJugada(){ 
        if ($this->siguientePetardazo==-1){
            $posicion= self::calculaPosicionAleatoria();
        }else  {
            $posicion= $this->siguientePetardazo; 
        }
        return $posicion;

    } 
/*Devuelve una posicion aletoria del tablero logico que aun no se ha seleccionado*/
    public function calculaPosicionAleatoria(){
        do{
            $pos= rand(0, 99);
            $pos=$pos;
        }while ( $this->TableroLogico[$pos]!="?");
        return $pos;
    }

/**Nombre: UltimaPosicionOtroExtremo()
 Recorre el array del tablero logico desde una posicion dada en sentido opuesto al rumbo guardado. 
 
 * Entrada: (Una posicion del array)
 * Salidas: 1 entero.    Devuelve: * 1 entero positivo con la última posición verdadera si la siguiente es "?"
 *                                 * -1 entero negativo (-1) si despues de la última posición verdadera era la última explotable.
 * 
*/
    public function UltimaPosicionOtroExtremo($posIni){
       $posFinal=$posIni;
            //Estos bucles no ejecutan nada en su interior, recorren el array para obtener un indice
            switch ($this->rumbo){
                case 12: //N
                   
                    for ($i=$posIni; $i<99 && $this->TableroLogico[$i]=="1"; $i+=10){
                        $posFinal=$posFinal+10;
                    
                    }          
                    //Reajuste del incide/contador y rumbo
                    if ($i>99){ //Controlar error de indexacion de array
                           //Asumimos que la ruta llega a un callejon sin salida. BARCO HUNDIDO
                           $posFinal=-1;
                           $this->rumbo=0;
                    }else if ($this->TableroLogico[$i]=="?"){
                        $this->rumbo=6;  //S
                        $posFinal=$posFinal-10;
                    }else{
                        //Asumimos que la ruta llega a un callejon sin salida. BARCO HUNDIDO
                        $posFinal=-1;
                        $this->rumbo=0;
                    }
               

                break;
                case 6:
                    for ($i=$posIni; $i>0 && $this->TableroLogico[$i]=="1"; $i-=10 ){
                        $posFinal=$posFinal-10;
                    }          
                    //Reajuste del incide/contador y rumbo
                    if ($i<0){ //Controlar error de indexacion de array
                           //Asumimos que la ruta llega a un callejon sin salida. BARCO HUNDIDO
                           $posFinal=-1;
                           $this->rumbo=0;
                    }else if ($this->TableroLogico[$i]=="?"){
                        $this->rumbo=12;  //N
                        $posFinal=$posFinal+10;
                    }else{
                        //Asumimos que la ruta llega a un callejon sin salida. BARCO HUNDIDO
                        $posFinal=-1;
                        $this->rumbo=0;
                    }
               
                break;
                case 3:
                    for ($i=$posIni; intval($i/10) == intval($posIni/10) && $this->TableroLogico[$i]=="1"; $i-- ){
                        $posFinal--;
                    }     
                    $posFinal++;     
                    //Reajuste del incide/contador y rumbo
                    if (intval($i/10) != intval($posIni/10)){ //Controlar error de indexacion de array
                           //Asumimos que la ruta llega a un callejon sin salida. BARCO HUNDIDO
                           $posFinal=-1;
                           $this->rumbo=0;
                    }else if ($this->TableroLogico[$i]=="?"){
                        $this->rumbo=9;  //W
                    }else{
                        //Asumimos que la ruta llega a un callejon sin salida. BARCO HUNDIDO
                        $posFinal=-1;
                        $this->rumbo=0;
                    }
                    
                    break;
                case 9:
                    for ($i=$posIni; intval($i/10) == intval($posIni/10) && $this->TableroLogico[$i]=="1"; $i++ ){
                        $posFinal++;
                    }
                    $posFinal=$posFinal--;          
                    //Reajuste del incide/contador y rumbo
                    if (intval($i/10) != intval($posIni/10)){ //Controlar error de indexacion de array
                           //Asumimos que la ruta llega a un callejon sin salida. BARCO HUNDIDO
                           $posFinal=-1;
                           $this->rumbo=0;
                    }else if ($this->TableroLogico[$i]=="?"){
                        
                        $this->rumbo=3;  //E
                    }else{
                        //Asumimos que la ruta llega a un callejon sin salida. BARCO HUNDIDO
                        $posFinal=-1;
                        $this->rumbo=0;
                    }
                break;
            }
        return $posFinal;
    }



/*Actualiza/Inicializa el atributo linea de acierto */
    public function inputLineaAcierto($pos){
        $tam=count($this->lineaDeAcierto);
        if ($tam==0){
            $this->lineaDeAcierto[0]=$pos;
        }
        else{
            $this->lineaDeAcierto[$tam]=$pos;
        }
        
    }
/*Analiza las jugadas anteriores y determina la dirección (Norte,Sur,Este,Woeste) que tendrá la próxima jugada
Entradas: 1 enteros con la posicion 
Salidas: no tiene*/

    public function brujula($pos,$resultado){

        $zonaMapa=self::dondeEstoy($pos);

        //Estas variables son en realidad constantes, las uso sin más motivo que hacer las comprensible el codigo
        $movArriba=-10;
        $movAbajo=10;

        switch ($resultado){
            case 0: //ERROR   -- recalcular jugada
                switch ($zonaMapa){ 
                    case 0:
                        switch($this->rumbo){
                            case 0:
                                    $this->siguientePetardazo=self::calculaPosicionAleatoria();
                            break;
                            case 12: 

                                if ($pos>=80&&$pos<=89){
                                    if ($this->TableroLogico[$pos+$movAbajo]=="1"){
                                        $posExtremo=self::UltimaPosicionOtroExtremo($pos+$movAbajo);
                                        if ($posExtremo<0){ 
                                        $this->rumbo=0;
                                        $this->siguientePetardazo=self::calculaPosicionAleatoria();
                                        }else{
                                            if ($this->TableroLogico[$posExtremo+$movAbajo]=="?"){
                                                $this->siguientePetardazo=$posExtremo+$movAbajo;
                                                $this->rumbo=6;
                                            }
                                        }  
                                    } else if ($this->TableroLogico[$pos+$movAbajo+1]=="?"){  //ESTE??                           
                                        $this->rumbo=3;   
                                        $this->siguientePetardazo=$pos+$movAbajo+1;

                                    }else if ($this->TableroLogico[$pos+$movAbajo-1]=="?"){ // OESTE??
                                        $this->rumbo=9;  
                                        $this->siguientePetardazo=$pos+$movAbajo-1; 
                                    }else{ //Por lógica este bloque no deberia ejecutarse nunca pero lo pongo para prevenir un infinito
                                        $this->rumbo=0;
                                        $this->siguientePetardazo=self::calculaPosicionAleatoria();
                                    }
                                }else if ($this->TableroLogico[$pos+$movAbajo]=="1"&& $this->TableroLogico[$pos+$movAbajo+$movAbajo]=="1"){  //Comprueba el otro extremo
                                            $posExtremo=self::UltimaPosicionOtroExtremo($pos+$movAbajo);
                                        if ($posExtremo<0){ 
                                        $this->rumbo=0;
                                        $this->siguientePetardazo=self::calculaPosicionAleatoria();
                                        }else{
                                            if ($this->TableroLogico[$posExtremo+$movAbajo]=="?"){
                                                $this->siguientePetardazo=$posExtremo+$movAbajo;
                                                $this->rumbo=6;
                                            }
                                        }   
                                        
                                    }else if ($this->TableroLogico[$pos+$movAbajo+1]=="?"){  //ESTE??                           
                                            $this->rumbo=3;   
                                            $this->siguientePetardazo=$pos+$movAbajo+1;

                                    }else if ($this->TableroLogico[$pos+$movAbajo-1]=="?"){ // OESTE??
                                            $this->rumbo=9;  
                                             $this->siguientePetardazo=$pos+$movAbajo-1; 
                                    }else{ //Por lógica este bloque no deberia ejecutarse nunca pero lo pongo para prevenir un infinito
                                        $this->rumbo=0;
                                        $this->siguientePetardazo=self::calculaPosicionAleatoria();
                                    }
                               
                                
                            break;
                            case 6: //RUMBO SUR
                               
                                    if ($this->TableroLogico[$pos+$movArriba]=="1" && $this->TableroLogico[$pos+($movArriba*2)]){  //Comprueba el otro extremo                                   
                                            $posExtremo=self::UltimaPosicionOtroExtremo($pos+$movArriba);
                                        if ($posExtremo<0){ 
                                            $this->rumbo=0;
                                            $this->siguientePetardazo=self::calculaPosicionAleatoria();
                                        }else{
                                            $this->siguientePetardazo=$posExtremo+$movArriba;
                                            $this->rumbo=12;
                                        }
                                    }else if ($this->TableroLogico[$pos+$movArriba+1]=="?"){  //ESTE??                           
                                            $this->rumbo=3;   
                                            $this->siguientePetardazo=$pos+$movArriba+1;  
                                    }else if ($this->TableroLogico[$pos+$movArriba-1]=="?"){ // oESTE??
                                        $this->rumbo=9;  
                                             $this->siguientePetardazo=$pos+$movArriba-1; 
                                    }else{ //Por lógica este bloque no deberia ejecutarse nunca pero lo pongo para prevenir un infinito
                                        $this->rumbo=0;
                                        $this->siguientePetardazo=self::calculaPosicionAleatoria();
                                    }
                            break;
                            case 9:

                                    if ($this->TableroLogico[$pos+1]=="1" &&$this->TableroLogico[$pos+2]=="1"){  //Comprueba el otro este
                                            $posExtremo=self::UltimaPosicionOtroExtremo($pos+1);
                                        if ($posExtremo<0){ 
                                            $this->rumbo=0;
                                            $this->siguientePetardazo=self::calculaPosicionAleatoria();
                                        }else{
                                            $this->siguientePetardazo=$posExtremo+1;
                                            $this->rumbo=3;
                                        }
                                }else if ($this->TableroLogico[$pos+1+$movArriba]=="?"){  //NORTE??                           
                                            $this->rumbo=12;   
                                            $this->siguientePetardazo=$pos+$movArriba+1;  
                                        }else if ($this->TableroLogico[$pos+1]=="?"){ // ESTE??
                                            $this->rumbo=3;  
                                            $this->siguientePetardazo=$pos; 
                                        }else if ($this->TableroLogico[$pos+$movAbajo+1]=="?"){ // SUR??
                                            $this->rumbo=6;  
                                            $this->siguientePetardazo=$pos+$movAbajo+1; 
                                        }else{ //Por lógica este bloque no deberia ejecutarse nunca pero lo pongo para prevenir un infinito
                                            $this->rumbo=0;
                                            $this->siguientePetardazo=self::calculaPosicionAleatoria();
                                        }
                            break;
                            case 3:
                                if ($this->TableroLogico[$pos-1]=="1" && $this->TableroLogico[$pos-2]=="1" ){  //Comprueba el otro este
                                        $posExtremo=self::UltimaPosicionOtroExtremo($pos-1);
                            
                                    if ($posExtremo<0){ 
                                        $this->rumbo=0;
                                        $this->siguientePetardazo=self::calculaPosicionAleatoria();
                                    }else{
                                        $this->siguientePetardazo=$posExtremo-1;
                                        $this->rumbo=9;
                                    }
                                }else if ($this->TableroLogico[$pos+$movArriba-1]=="?"){  //NORTE??                           
                                        $this->rumbo=12;   
                                        $this->siguientePetardazo=$pos+$movArriba-1;  
                                }else if ($this->TableroLogico[$pos+$movAbajo-1]=="?"){ // SUR??
                                        $this->rumbo=6;  
                                        $this->siguientePetardazo=$pos+$movAbajo-1; 
                                }else{ //Por lógica este bloque no deberia ejecutarse nunca pero lo pongo para prevenir un infinito
                                        $this->rumbo=0;
                                        $this->siguientePetardazo=self::calculaPosicionAleatoria();
                                }
                            break;
                        }
                    break;
                    case 1: //ERROR-ZONA Esquina SUP.IZQUIERDA
                        switch($this->rumbo){
                            case 0:
                                    $this->siguientePetardazo=self::calculaPosicionAleatoria();
                            break;
                            case 12: 
                                    if ($this->TableroLogico[$pos+$movAbajo]=="1"&&$this->TableroLogico[$pos+($movAbajo*2)]=="1"){  //Comprueba extremo SUR
                                    $posExtremo=self::UltimaPosicionOtroExtremo($pos+$movAbajo);

                                        if ($posExtremo<0){ 
                                        $this->rumbo=0;
                                        $this->siguientePetardazo=self::calculaPosicionAleatoria();
                                        }else{
                                            $this->siguientePetardazo=$posExtremo+$movAbajo;
                                            $this->rumbo=6;
                                        }
                                    }else if ($this->TableroLogico[$pos+$movAbajo+1]=="?"){  //OESTE??                           
                                            $this->rumbo=9;   
                                            $this->siguientePetardazo=$pos+$movAbajo+1;  
                                    }else if ($this->TableroLogico[$pos+$movAbajo-1]=="?"){ // ESTE??
                                        $this->rumbo=3;  
                                             $this->siguientePetardazo=$pos+$movAbajo-1; 
                                    }else{ //Por lógica este bloque no deberia ejecutarse nunca pero lo pongo para prevenir un infinito
                                        $this->rumbo=0;
                                        $this->siguientePetardazo=self::calculaPosicionAleatoria();

                                    }
                                
                            break;

                            case 9:
                                if ($this->TableroLogico[$pos+1]=="1"&&$this->TableroLogico[$pos+2]=="1"){  //Comprueba el otro extremo
                                    $posExtremo=self::UltimaPosicionOtroExtremo($pos+1);

                                    if ($posExtremo<0){ 
                                        $this->rumbo=0;
                                        $this->siguientePetardazo=self::calculaPosicionAleatoria();
                                    }else{
                                        $this->siguientePetardazo=$posExtremo-1;
                                        $this->rumbo=3;
                                    }
                                }else if ($this->TableroLogico[$pos-1]=="?"){ // ESTE??
                                        $this->rumbo=3;  
                                        $this->siguientePetardazo=$pos--; 
                                }else if ($this->TableroLogico[$pos+$movAbajo-1]=="?"){ // SUR??
                                        $this->rumbo=6;  
                                        $this->siguientePetardazo=$pos+$movAbajo-1; 
                                }else{ //Por lógica este bloque no deberia ejecutarse nunca pero lo pongo para prevenir un infinito
                                        $this->rumbo=0;
                                        $this->siguientePetardazo=self::calculaPosicionAleatoria();
                                }
                            break;
                            
                        }
                    break;
                    case 2: //ERROR-ZONA Esquina BORDE SUP                       
                        switch($this->rumbo){
                        case 0:
                                $this->siguientePetardazo=self::calculaPosicionAleatoria();
                        break;
                        case 12: 
                                if ($this->TableroLogico[$pos+$movAbajo]=="1"&&$this->TableroLogico[$pos+($movAbajo*2)]=="1"){  //Comprueba extremo SUR
                                $posExtremo=self::UltimaPosicionOtroExtremo($pos+$movAbajo);

                                    if ($posExtremo<0){ 
                                    $this->rumbo=0;
                                    $this->siguientePetardazo=self::calculaPosicionAleatoria();
                                    }else{
                                        $this->siguientePetardazo=$posExtremo+$movAbajo;
                                        $this->rumbo=6;
                                    }
                                }else if ($this->TableroLogico[$pos+$movAbajo+1]=="?"){  //ESTE??                           
                                        $this->rumbo=3;   
                                        $this->siguientePetardazo=$pos+$movAbajo+1;   
                                }else if ($this->TableroLogico[$pos+$movAbajo-1]=="?"){ // OESTE??
                                    $this->rumbo=9;  
                                         $this->siguientePetardazo=$pos+$movAbajo-1; 
                                }else{ //Por lógica este bloque no deberia ejecutarse nunca pero lo pongo para prevenir un infinito
                                    $this->rumbo=0;
                                    $this->siguientePetardazo=self::calculaPosicionAleatoria();

                                }
                            
                        break;
                        case 9:
                            if ($this->TableroLogico[$pos+1]=="1"&&$this->TableroLogico[$pos+2]=="1"){  //Comprueba extremo ESTE
                                $posExtremo=self::UltimaPosicionOtroExtremo($pos+1);

                                    if ($posExtremo<0){ 
                                    $this->rumbo=0;
                                    $this->siguientePetardazo=self::calculaPosicionAleatoria();
                                    }else{
                                        $this->siguientePetardazo=$posExtremo+1;
                                        $this->rumbo=3;
                                    }
                            }else if ($this->TableroLogico[$pos+$movAbajo+1]=="?"){ // SUR??
                                $this->rumbo=6;  
                                $this->siguientePetardazo=$pos+$movAbajo+1; 
                            }else{ //Por lógica este bloque no deberia ejecutarse nunca pero lo pongo para prevenir un infinito
                                $this->rumbo=0;
                                $this->siguientePetardazo=self::calculaPosicionAleatoria();
                            }
                        break;
                        case 3:
                            if ($this->TableroLogico[$pos-1]=="1"&&$this->TableroLogico[$pos-2]=="1"){  //Comprueba EXTREMO OESTE
                                $posExtremo=self::UltimaPosicionOtroExtremo($pos-1);

                                    if ($posExtremo<0){ 
                                    $this->rumbo=0;
                                    $this->siguientePetardazo=self::calculaPosicionAleatoria();
                                    }else{
                                        $this->siguientePetardazo=$posExtremo-1;
                                        $this->rumbo=9;
                                    }

                            }else if ($this->TableroLogico[$pos+$movAbajo-1]=="?"){ // SUR??
                                $this->rumbo=6;  
                                $this->siguientePetardazo=$pos+$movAbajo-1; 
                            }else{ //Por lógica este bloque no deberia ejecutarse nunca pero lo pongo para prevenir un infinito
                                $this->rumbo=0;
                                $this->siguientePetardazo=self::calculaPosicionAleatoria();
                            }
                        break;
                    }
                    break;
                    case 3://ERROR-ZONA Esquina SUP.DERECHA
                        switch($this->rumbo){
                            case 0:
                                    $this->siguientePetardazo=self::calculaPosicionAleatoria();
                            break;
                            case 12:  //Rumbo norte
                                    if ($this->TableroLogico[$pos+$movAbajo]=="1"&&$this->TableroLogico[$pos+($movAbajo*2)]=="1"){  //Comprueba el otro ectremo
                                    $posExtremo=self::UltimaPosicionOtroExtremo($pos+$movAbajo);

                                        if ($posExtremo<0){ 
                                        $this->rumbo=0;
                                        $this->siguientePetardazo=self::calculaPosicionAleatoria();
                                        }else{
                                            $this->siguientePetardazo=$posExtremo+$movAbajo;
                                            $this->rumbo=6;
                                        }
                                    }else if ($this->TableroLogico[$pos+$movAbajo+1]=="?"){  //OESTE??                           
                                            $this->rumbo=9;   
                                            $this->siguientePetardazo=$movAbajo+1;  
                                    }else{ //Por lógica este bloque no deberia ejecutarse nunca pero lo pongo para prevenir un infinito
                                        $this->rumbo=0;
                                        $this->siguientePetardazo=self::calculaPosicionAleatoria();

                                    }
                                
                            break;

                            case 3://Rumbo ESTE
                                if ($this->TableroLogico[$pos-1]=="1" && $this->TableroLogico[$pos-2]=="1"){  //Comprueba Extremo Oeste
                                    $posExtremo=self::UltimaPosicionOtroExtremo($pos-1);

                                        if ($posExtremo<0){ 
                                        $this->rumb=0;
                                        $this->siguientePetardazo=self::calculaPosicionAleatoria();
                                        }else{
                                            $this->siguientePetardazo=$posExtremo-1;
                                            $this->rumbo=9;
                                        }
                                }else if ($this->TableroLogico[$pos-1+$movAbajo]=="?"){ // SUR??
                                    $this->rumbo=6;  
                                    $this->siguientePetardazo=$pos-1+$movAbajo; 
                                }else{ //Por lógica este bloque no deberia ejecutarse nunca pero lo pongo para prevenir un infinito
                                            $this->rumbo=0;
                                            $this->siguientePetardazo=self::calculaPosicionAleatoria();
                                }
                            break;
                        }
                    case 4://ERROR- Zona BORDE DERECHO
                        switch($this->rumbo){
                            case 0: //Sin rumbo
                                    $this->siguientePetardazo=self::calculaPosicionAleatoria();
                            break;
                            case 12: //Rumbo Norte
                                    if ($this->TableroLogico[$pos+$movAbajo]=="1"  && $this->TableroLogico[$pos+($movAbajo*2)]=="1"){  //Comprueba extremo SUR
                                    $posExtremo=self::UltimaPosicionOtroExtremo($pos+$movAbajo);

                                        if ($posExtremo<0){ 
                                        $this->rumb=0;
                                        $this->siguientePetardazo=self::calculaPosicionAleatoria();
                                        }else{
                                            $this->siguientePetardazo=$posExtremo+$movAbajo;
                                            $this->rumbo=6;
                                        }
                                    }else if ($this->TableroLogico[$pos+$movAbajo-1]=="?"){  //OESTE??                           
                                            $this->rumbo=9;   
                                            $this->siguientePetardazo=$pos+$movAbajo-1;  
                                    }else{ //Por lógica este bloque no deberia ejecutarse nunca pero lo pongo para prevenir un infinito
                                        $this->rumbo=0;
                                        $this->siguientePetardazo=self::calculaPosicionAleatoria();

                                    }
                                
                            break;
                            case 6://Rumbo SUR
                                if ($this->TableroLogico[$pos+$movArriba]=="1" && $this->TableroLogico[$pos+($movArriba*2)]=="1"){  //Comprueba el otro extremo
                                    $posExtremo=self::UltimaPosicionOtroExtremo($pos+$movArriba);

                                        if ($posExtremo<0){ 
                                        $this->rumbo=0;
                                        $this->siguientePetardazo=self::calculaPosicionAleatoria();
                                        }else{
                                            $this->siguientePetardazo=$posExtremo+$movArriba;
                                            $this->rumbo=12;
                                        }
                                    }else if ($this->TableroLogico[$pos+$movArriba-1]=="?"){  //OESTE??                           
                                            $this->rumbo=9;   
                                            $this->siguientePetardazo=$pos+$movArriba-1;  
                                    }else{ //Por lógica este bloque no deberia ejecutarse nunca pero lo pongo para prevenir un infinito
                                        $this->rumbo=0;
                                        $this->siguientePetardazo=self::calculaPosicionAleatoria();
                                    }
                            break;
                            case 3://Venias rumbo Este
                                if ($this->TableroLogico[$pos-1]=="1" && $this->TableroLogico[$pos-2]=="1"){  //Comprueba extremo OESTE
                                    $posExtremo=self::UltimaPosicionOtroExtremo($pos-1);

                                        if ($posExtremo<0){ 
                                        $this->rumbo=0;
                                        $this->siguientePetardazo=self::calculaPosicionAleatoria();
                                        }else{
                                            $this->siguientePetardazo=$posExtremo-1;
                                            $this->rumbo=9;
                                        }
                                }else if ($this->TableroLogico[$pos-1+$movArriba]=="?"){  //NORTE??                           
                                            $this->rumbo=12;   
                                            $this->siguientePetardazo=$pos-1+$movArriba;  
                                        }else if ($this->TableroLogico[$pos-1+$movAbajo]=="?"){ // SUR??
                                            $this->rumbo=6;  
                                            $this->siguientePetardazo=$pos-1+$movAbajo; 
                                        }else{ //Por lógica este bloque no deberia ejecutarse nunca pero lo pongo para prevenir un infinito
                                            $this->rumbo=0;
                                            $this->siguientePetardazo=self::calculaPosicionAleatoria();
                                        }
                            break;
                        }
                    break;
                    case 5://ERROR-Zona Esquina INF.DERECHA
                        switch($this->rumbo){
                            case 0: //Sin rumbo
                                    $this->siguientePetardazo=self::calculaPosicionAleatoria();
                            break;

                            case 6://Vienes de la posicion norte
                                if ($this->TableroLogico[$pos+$movArriba]=="1" && $this->TableroLogico[$pos+($movArriba*2)]=="1"){  //Comprueba el otro extremo
                                    $posExtremo=self::UltimaPosicionOtroExtremo($pos+$movArriba);

                                        if ($posExtremo<0){ 
                                        $this->rumbo=0;
                                        $this->siguientePetardazo=self::calculaPosicionAleatoria();
                                        }else{
                                            $this->siguientePetardazo=$posExtremo+$movArriba;
                                            $this->rumbo=12;
                                        }
                                    }else if ($this->TableroLogico[$pos+$movArriba-1]=="?"){  //OESTE??                           
                                            $this->rumbo=9;   
                                            $this->siguientePetardazo=$pos+$movArriba-1;  
                                    }else{ //Por lógica este bloque no deberia ejecutarse nunca pero lo pongo para prevenir un infinito
                                        $this->rumbo=0;
                                        $this->siguientePetardazo=self::calculaPosicionAleatoria();
                                    }
                            break;

                            case 3://Rumbo ESTE- Venias de la posicion Oeste
                                if ($this->TableroLogico[$pos-1]=="1" && $this->TableroLogico[$pos-2]=="1"){  //Comprueba el otro extremo
                                    $posExtremo=self::UltimaPosicionOtroExtremo($pos-1);

                                        if ($posExtremo<0){ 
                                        $this->rumbo=0;
                                        $this->siguientePetardazo=self::calculaPosicionAleatoria();
                                        }else{
                                            $this->siguientePetardazo=$posExtremo-1;
                                            $this->rumbo=9;
                                        }
                                }else if ($this->TableroLogico[$pos+$movArriba]=="?"){  //NORTE??                           
                                    $this->rumbo=12;   
                                    $this->siguientePetardazo=$pos+$movArriba;  

                                }else{ //Por lógica este bloque no deberia ejecutarse nunca pero lo pongo para prevenir un infinito
                                    $this->rumbo=0;
                                    $this->siguientePetardazo=self::calculaPosicionAleatoria();
                                }
                            break;
                        }
                    break;
                    case 6: //ERROR-Zona BORDE INFERIOR
                        switch($this->rumbo){
                            case 0: //Sin rumbo
                                    $this->siguientePetardazo=self::calculaPosicionAleatoria();
                            break;
                            case 6: //Rumbo Sur - Vienes de posición Norte
                                if ($this->TableroLogico[$pos+$movArriba]=="1" && $this->TableroLogico[$pos+($movArriba*2)]=="1"){  //Comprueba el otro extremo
                                    $posExtremo=self::UltimaPosicionOtroExtremo($pos+$movArriba);

                                        if ($posExtremo<0){ 
                                        $this->rumbo=0;
                                        $this->siguientePetardazo=self::calculaPosicionAleatoria();
                                        }else{
                                            $this->siguientePetardazo=$posExtremo+$movArriba;
                                            $this->rumbo=12;
                                        }
                                    }else if ($this->TableroLogico[$pos-1+$movArriba]=="?"){  //OESTE??                           
                                            $this->rumbo=9;   
                                            $this->siguientePetardazo=$pos-1+$movArriba;  
                                    }else if ($this->TableroLogico[$pos+1+$movArriba]=="?"){ // ESTE??
                                        $this->rumbo=3;  
                                             $this->siguientePetardazo=$pos+1+$movArriba; 
                                    }else{ //Por lógica este bloque no deberia ejecutarse nunca pero lo pongo para prevenir un infinito
                                        $this->rumbo=0;
                                        $this->siguientePetardazo=self::calculaPosicionAleatoria();
                                    }
                            break;
                            case 9://Rumbo Oeste -> Posicion Este es la anterior
                                if ($this->TableroLogico[$pos+1]=="1" && $this->TableroLogico[$pos+2]=="1"){  //Comprueba extremo ESTE
                                    $posExtremo=self::UltimaPosicionOtroExtremo($pos+1);

                                        if ($posExtremo<0){ 
                                        $this->rumbo=0;
                                        $this->siguientePetardazo=self::calculaPosicionAleatoria();
                                        }else{
                                            $this->siguientePetardazo=$posExtremo+1;
                                            $this->rumbo=3;
                                        }
                                }else if ($this->TableroLogico[$pos+$movArriba-1]=="?"){  //NORTE??                           
                                            $this->rumbo=12;   
                                            $this->siguientePetardazo=$pos+$movArriba-1; 
                                        }else{ //Por lógica este bloque no deberia ejecutarse nunca pero lo pongo para prevenir un infinito
                                            $this->rumbo=0;
                                            $this->siguientePetardazo=self::calculaPosicionAleatoria();
                                        }
                            break;
                            case 3://Rumbo Este ->Posicion oeste es la anterior
                                if ($this->TableroLogico[$pos-1]=="1" && $this->TableroLogico[$pos-2]=="1"){  //Comprueba extremo OESTE
                                    $posExtremo=self::UltimaPosicionOtroExtremo($pos-1);

                                        if ($posExtremo<0){ 
                                        $this->rumbo=0;
                                        $this->siguientePetardazo=self::calculaPosicionAleatoria();
                                        }else{
                                            $this->siguientePetardazo=$posExtremo-1;
                                            $this->rumbo=9;
                                        }
                                }else if ($this->TableroLogico[$pos+$movArriba-1]=="?"){  //NORTE??                           
                                            $this->rumbo=12;   
                                            $this->siguientePetardazo=$pos+$movArriba-1;  

                                        }else{ //Por lógica este bloque no deberia ejecutarse nunca pero lo pongo para prevenir un infinito
                                            $this->rumbo=0;
                                            $this->siguientePetardazo=self::calculaPosicionAleatoria();
                                        }
                            break;
                        }
                    break;
                    case 7://ERROR-Zona Esquina INFERIOR DERECHA
                        switch($this->rumbo){
                            case 0: //Sin rumbo
                                    $this->siguientePetardazo=self::calculaPosicionAleatoria();
                            break;
                            case 6://Rumbo Sur -> Posicion Norte es la anterior
                                if ($this->TableroLogico[$pos+$movArriba]=="1" && $this->TableroLogico[$pos+($movArriba*2)]=="1"){  //Comprueba extremo NORTE
                                    $posExtremo=self::UltimaPosicionOtroExtremo($pos+$movArriba);

                                        if ($posExtremo<0){ 
                                        $this->rumbo=0;
                                        $this->siguientePetardazo=self::calculaPosicionAleatoria();
                                        }else{
                                            $this->siguientePetardazo=$posExtremo+$movArriba;
                                            $this->rumbo=12;
                                        }
                                }else if ($this->TableroLogico[$pos-1]=="?"){ // ESTE??
                                    $this->rumbo=3;  
                                    $this->siguientePetardazo=$pos--; 
                                }else{ //Por lógica este bloque no deberia ejecutarse nunca pero lo pongo para prevenir un infinito
                                    $this->rumbo=0;
                                    $this->siguientePetardazo=self::calculaPosicionAleatoria();
                                }
                            break;
                            case 9: //Rumbo Oeste -> Posición Este es la anterior
                                if ($this->TableroLogico[$pos+1]=="1" && $this->TableroLogico[$pos+2]=="1"){  //Comprueba extremo ESTE
                                    $posExtremo=self::UltimaPosicionOtroExtremo($pos+1);

                                        if ($posExtremo<0){ 
                                        $this->rumbo=0;
                                        $this->siguientePetardazo=self::calculaPosicionAleatoria();
                                        }else{
                                            $this->siguientePetardazo=$posExtremo+1;
                                            $this->rumbo=3;
                                        }
                                }else if ($this->TableroLogico[$pos+$movArriba+1]=="?"){  //NORTE??                           
                                    $this->rumbo=12;   
                                    $this->siguientePetardazo=$pos+$movArriba+1;  
                                }else{ //Por lógica este bloque no deberia ejecutarse nunca pero lo pongo para prevenir un infinito
                                    $this->rumbo=0;
                                    $this->siguientePetardazo=self::calculaPosicionAleatoria();
                                }
                            break;
                        }
                    break;
                    case 8: //ERROR- Zona BORDE LATERAL IZQUIERDO                       
                        switch($this->rumbo){
                        case 0: //SIn rumbo
                                $this->siguientePetardazo=self::calculaPosicionAleatoria();
                        break;
                        case 12: //Rumbo Norte -> Posición Sur es la anterior
                                if ($this->TableroLogico[$pos+$movAbajo]=="1" && $this->TableroLogico[$pos+($movAbajo*2)]=="1"){  //Comprueba extremo SUR
                                $posExtremo=self::UltimaPosicionOtroExtremo($pos+$movAbajo);

                                    if ($posExtremo<0){ 
                                    $this->rumbo=0;
                                    $this->siguientePetardazo=self::calculaPosicionAleatoria();
                                    }else{
                                        $this->siguientePetardazo=$posExtremo+$movAbajo;
                                        $this->rumbo=6;
                                    }
                                }else if ($this->TableroLogico[$pos+1]=="?"){ // ESTE??
                                    $this->rumbo=3;  
                                         $this->siguientePetardazo=$pos+1; 
                                }else{ //Por lógica este bloque no deberia ejecutarse nunca pero lo pongo para prevenir un infinito
                                    $this->rumbo=0;
                                    $this->siguientePetardazo=self::calculaPosicionAleatoria();

                                }
                            
                        break;
                        case 6://Rumbo Sur -> Posicion Norte es la anterior
                            if ($this->TableroLogico[$pos+$movArriba]=="1" && $this->TableroLogico[$pos+($movArriba*2)]=="1"){  //Comprueba extremo Norte
                                $posExtremo=self::UltimaPosicionOtroExtremo($pos+$movArriba);

                                    if ($posExtremo<0){ 
                                    $this->rumbo=0;
                                    $this->siguientePetardazo=self::calculaPosicionAleatoria();
                                    }else{
                                        $this->siguientePetardazo=$posExtremo+$movArriba;
                                        $this->rumbo=12;
                                    }
                            }else if ($this->TableroLogico[$pos+1+$movArriba]=="?"){ // ESTE??
                                $this->rumbo=3;  
                                $this->siguientePetardazo=$pos+1+$movArriba; 
                            }else{ //Por lógica este bloque no deberia ejecutarse nunca pero lo pongo para prevenir un infinito
                                $this->rumbo=0;
                                $this->siguientePetardazo=self::calculaPosicionAleatoria();
                            }
                        break;
                        case 9://Rumbo Oeste -> Posicion Este es la anterior
                            if ($this->TableroLogico[$pos+1]=="1" && $this->TableroLogico[$pos+2]=="1"){  //Comprueba el otro extremo
                                $posExtremo=self::UltimaPosicionOtroExtremo($pos+1);

                                    if ($posExtremo<0){ 
                                    $this->rumbo=0;
                                    $this->siguientePetardazo=self::calculaPosicionAleatoria();
                                    }else{
                                        $this->siguientePetardazo=$posExtremo--;
                                        $this->rumbo=3;
                                    }
                            }else if ($this->TableroLogico[$pos+$movArriba+1]=="?"){  //NORTE??                           
                                $this->rumbo=12;   
                                $this->siguientePetardazo=$pos+$movArriba+1;  
                            }else if ($this->TableroLogico[$pos+$movAbajo+1]=="?"){ // SUR??
                                        $this->rumbo=6;  
                                        $this->siguientePetardazo=$pos+$movAbajo+1; 
                                    }else{ //Por lógica este bloque no deberia ejecutarse nunca pero lo pongo para prevenir un infinito
                                        $this->rumbo=0;
                                        $this->siguientePetardazo=self::calculaPosicionAleatoria();
                                    }
                        break;
                    }
                    break;

                }
            break;

            case 1 : //ACIERTO 
                switch ($zonaMapa){ 
                    case 0: //ACIERTO-ZONA CENTRAL Seguir rumbo
                        switch($this->rumbo){
                            case 0:
                                if ($this->TableroLogico[$pos-10]=="?"){
                                    $this->rumbo=12; # Fija Norte
                                    $this->siguientePetardazo=$pos-10;
                                }else if ($this->TableroLogico[$pos+1]=="?"){
                                    $this->rumbo=3; # Fija Este
                                    $this->siguientePetardazo=$pos+1;
                                }else if ($this->TableroLogico[$pos+10]=="?"){
                                    $this->rumbo=6; # Fija Sur
                                    $this->siguientePetardazo=$pos+10;
                                }else if ($this->TableroLogico[$pos-1]=="?"){
                                    $this->rumbo=9; # Fija Oeste
                                    $this->siguientePetardazo=$pos-1;
                                }   
                         
                            break;

                            case 12: # Sigue linea  NORTE
                                if ($this->TableroLogico[$pos-10]=="?"){
                                    $this->siguientePetardazo=$pos-10;
                                }else{
                                    $posExtremo=self::UltimaPosicionOtroExtremo($pos);   
                                    if ($posExtremo<0){
                                        $this->rumbo=0;
                                        $pos=self::calculaPosicionAleatoria();
                                    }else{
                                        $this->rumbo=6;
                                        $this->siguientePetardazo=$posExtremo;
                                    }
                                } 
                            break;
                            case 6:  # Sigue linea SUR
                            if ($this->TableroLogico[$pos+10]=="?"){
                                $this->siguientePetardazo=$pos+10;
                            }else{
                                $posExtremo=self::UltimaPosicionOtroExtremo($pos);   
                                if ($posExtremo<0){
                                    $this->rumbo=0;
                                    $pos=self::calculaPosicionAleatoria();
                                }else{
                                    $this->rumbo=12;
                                    $this->siguientePetardazo=$posExtremo;
                                }
                            } 
                           
                            break;
                            case 3:  # Sigue linea ESTE
                                
                                if ($this->TableroLogico[$pos+1]=="?"){
                                    $this->siguientePetardazo=$pos+1;
                                }else{
                                    $posExtremo=self::UltimaPosicionOtroExtremo($pos);   
                                    if ($posExtremo<0){
                                        $this->rumbo=0;
                                        $pos=self::calculaPosicionAleatoria();
                                    }else{
                                        $this->rumbo=6;
                                        $this->siguientePetardazo=$posExtremo-1;
                                    }
                                } 
                            break;
                            case 9:  # Sigue linea SUR
                            if ($this->TableroLogico[$pos-1]=="?"){
                                $this->siguientePetardazo=$pos-1;
                            }else{
                                $posExtremo=self::UltimaPosicionOtroExtremo($pos);   
                                if ($posExtremo<0){
                                    $this->rumbo=0;
                                    $pos=self::calculaPosicionAleatoria();
                                }else{
                                    $this->rumbo=6;
                                    $this->siguientePetardazo=$posExtremo;
                                }
                            } 
                            break;
                        }
                    break;
                    case 1: //ACIERTO Esquina SUP.IZQ
                        switch($this->rumbo){
                            case 0:                 //Reorienta S/W

                                if ($this->TableroLogico[$pos+1]=="?"){
                                    $this->rumbo=3;
                                    $this->siguientePetardazo=$pos+1; //Este
                                }else if ($this->TableroLogico[$pos+$movAbajo]=="?"){
                                    $this->rumbo=6;
                                    $this->siguientePetardazo=$pos+$movAbajo;  //Sur
                                }
                                else{ //Por si acaso algo falla tira aleatorio
                                    $this->siguientePetardazo=self::calculaPosicionAleatoria();
                                }          
                            break;
                            case 12: //Rumbo Norte- Posición Sur anterior

                                $posExtremo=self::UltimaPosicionOtroExtremo($pos); //Comprueba extremo Sur

                                if ($posExtremo<0){ //Barco hundido
                                    $this->rumbo=0;
                                    $this->siguientePetardazo=self::calculaPosicionAleatoria();
                                }else{ 
                                    $this->rumbo=6; //Sigue linea Sur
                                    $this->siguientePetardazo=$posExtremo;//+$movAbajo;
                                }
                            break;
                            case 9: //Rumbo OESTE- Posición ESTE anterior
                                
                                $posExtremo=self::UltimaPosicionOtroExtremo($pos); //Comprobar extremo Este

                                if ($posExtremo<0){ //Barco hundido
                                    $this->rumbo=0;
                                    $this->siguientePetardazo=self::calculaPosicionAleatoria();
                                }else{
                                    $this->rumbo=3;
                                    $this->siguientePetardazo=$posExtremo; //+1;
                                }
                            break;
                        }
                    break;
                    case 2: //ACIERTO BORDE SUP

                        switch($this->rumbo){
                            case 0:                 //Reorienta hacia E/S/W

                                if ($this->TableroLogico[$pos+1]=="?"){
                                    $this->rumbo=3;
                                    $this->siguientePetardazo=$pos+1; 
                                }else if ($this->TableroLogico[$pos+$movAbajo]=="?"){
                                    $this->rumbo=6;
                                    $this->siguientePetardazo=$pos+$movAbajo; 
                                }
                                else if ($this->TableroLogico[$pos-1]=="?") {     
                                        $this->rumbo=6;
                                        $this->siguientePetardazo=$pos-1;
                                }else{
                                     //Por si acaso algo falla ... tira aleatorio
                                     $this->siguientePetardazo=self::calculaPosicionAleatoria();
                                }       
                            break;
                            case 12: //Rumbo Norte
                                
                                $posExtremo=self::UltimaPosicionOtroExtremo($pos); //Comprobar Extremo Sur

                                if ($posExtremo<0){ //Barco hundido
                                    $this->rumbo=0;
                                    $this->siguientePetardazo=self::calculaPosicionAleatoria();
                                }else{
                                    $this->rumbo=6; //Sigue la linea por el Sur
                                    $this->siguientePetardazo=$posExtremo+$movAbajo;
                                }
                            break;

                            case 3: //Rumbo Este -> Posicion Oeste es la anterior

                                //Comprueba tablero lógico 
                                if($this->TableroLogico[$pos+1]=="?"){
                                    $this->siguientePetardazo=$pos+1;
                                }else{
                                    $posExtremo=self::UltimaPosicionOtroExtremo($pos); //Comprobar extremo OESTE
                                    if ($posExtremo<0){ //Barco hundido
                                        $this->rumbo=0;
                                        $this->siguientePetardazo=self::calculaPosicionAleatoria();
                                    }else{
                                        $this->rumbo=9; //Sigue linea Oeste
                                        $this->siguientePetardazo=$posExtremo-1; // Yo entiendo que es -1, pero me adelanta 2
                                    }         
                                }
                            break;

                            case 9:  //Rumbo Oeste -> Posicion Este es la anterior 
                           //Comprueba el rumbo  
                                if($this->TableroLogico[$pos-1]=="?"){
                                     $this->siguientePetardazo=$pos-1;
                                }else{
                                    $posExtremo=self::UltimaPosicionOtroExtremo($pos); //Comprueba extremo Este 
                                    if ($posExtremo<0){ //Barco hundido
                                        $this->rumbo=0;
                                        $this->siguientePetardazo=self::calculaPosicionAleatoria();
                                    }else{
                                        $this->rumbo=3; //Sigue linea por el Este
                                        $this->siguientePetardazo=$posExtremo;
                                }
                                }
                            break;
                        }

                    break;
                    case 3://ACIERTO ESQUINA SUP. DERECHA
                        switch($this->rumbo){
                            case 0:                 //Reorienta S/W

                                if ($this->TableroLogico[$pos+$movAbajo]=="?"){
                                    $this->rumbo=6;
                                    $this->siguientePetardazo=$pos+$movAbajo; //Una abajo 
                                }else if ($this->TableroLogico[$pos-1]=="?"){
                                    $this->rumbo=9;
                                    $this->siguientePetardazo=$pos-1; //Una a la izquierda
                                }
                                else{ //Por si acaso algo falla tira aleatorio
                                    $this->siguientePetardazo=self::calculaPosicionAleatoria();
                                }          
                            break;
                            case 12: //Rumbo Norte -> Posicion Sur es la anterior 
                                
                                $posExtremo=self::UltimaPosicionOtroExtremo($pos); //Comprobar el extremo Sur

                                if ($posExtremo<0){ //Barco hundido
                                    $this->rumbo=0;
                                    $this->siguientePetardazo=self::calculaPosicionAleatoria();
                                }else{
                                    $this->rumbo=6; //Sigue linea al Sur
                                    $this->siguientePetardazo=$posExtremo+$movAbajo;
                                }
                            break;
                            case 3: //Rumbo Este -> Posicion anterior: Oeste
                                $posExtremo=self::UltimaPosicionOtroExtremo($pos); //Comprobar extremo Oeste

                                if ($posExtremo<0){ //Barco hundido
                                    $this->rumbo=0;
                                    $this->siguientePetardazo=self::calculaPosicionAleatoria();
                                }else{
                                    $this->rumbo=9;
                                    $this->siguientePetardazo=$posExtremo-1;
                                }
                            break;
                        }
                    break;
                    case 4://ACIERTO BORDE LATERAL DERECHO
                        
                        switch($this->rumbo){
                            case 0:                 //Reorienta hacia N/S/W

                                if ($this->TableroLogico[$pos+$movArriba]=="?"){
                                    $this->rumbo=12;
                                    $this->siguientePetardazo=$pos+$movArriba; 
                                }
                                else if ($this->TableroLogico[$pos+$movAbajo]=="?") {     
                                        $this->rumbo=6;
                                        $this->siguientePetardazo=$pos+$movAbajo;
                                }else if ($this->TableroLogico[$pos-1]=="?"){
                                    $this->rumbo=9;
                                    $this->siguientePetardazo=$pos-1; 
                                }else{
                                     //Por si acaso algo falla tira aleatorio
                                     $this->siguientePetardazo=self::calculaPosicionAleatoria();
                                }       
                            break;
                            case 12:  //Rumbo Norte -> Posicion Sur es la anterior

                                if($this->TableroLogico[$pos+$movArriba]=="?"){ //Comprueba linea norte
                                    $this->siguientePetardazo=$pos+$movArriba;
                               }else{
                                    //Recalcula 
                                    $posExtremo=self::UltimaPosicionOtroExtremo($pos); //Comprueba linea sur 

                                    if ($posExtremo<0){ //Barco hundido
                                        $this->rumbo=0;
                                        $this->siguientePetardazo=self::calculaPosicionAleatoria();
                                    }else{
                                        $this->rumbo=6;
                                        $this->siguientePetardazo=$posExtremo+$movAbajo;
                                    }
                                }
                            break;

                            case 3: //Rumbo ESTE -> Podicion anterior: Oeste
                                //Comprueba tablero lógico 
                                    $posExtremo=self::UltimaPosicionOtroExtremo($pos); //Comprobar extremo OESTE
                                    if ($posExtremo<0){ //Barco hundido
                                        $this->rumbo=0;
                                        $this->siguientePetardazo=self::calculaPosicionAleatoria();
                                    }else{
                                        $this->rumbo=9; //Sigue linea por el OESTE
                                        $this->siguientePetardazo=$posExtremo-1;
                                    }         
                                
                            break;

                            case 6:  //Rumbo Sur -> Posicion Anterior: Norte
                           
                                if($this->TableroLogico[$pos+$movAbajo]=="?"){ //Comprobar linea Sur 
                                     $this->siguientePetardazo=$pos+$movAbajo;
                                }else{
                                    $posExtremo=self::UltimaPosicionOtroExtremo($pos); //Comprobar Extremo Norte
                                    if ($posExtremo<0){ //Barco hundido
                                        $this->rumbo=0;
                                        $this->siguientePetardazo=self::calculaPosicionAleatoria();
                                    }else{
                                        $this->rumbo=12; //Seguir linea por el Norte
                                        $this->siguientePetardazo=$posExtremo+$movArriba;
                                    }
                                }
                            break;
                        }
                    break;
                    case 5://Esquina INF.DERECHA
                        switch($this->rumbo){
                            case 0:                 //Reorienta hacia N/W

                                if ($this->TableroLogico[$pos+$movArriba]=="?"){
                                    $this->rumbo=12;
                                    $this->siguientePetardazo=$pos+$movArriba; //Arriba 
                                }else if ($this->TableroLogico[$pos-1]=="?"){
                                    $this->rumbo=9;
                                    $this->siguientePetardazo=$pos-1; //Una a la derecha 
                                }
                                else{ //Por si acaso algo falla tira aleatorio
                                    $this->siguientePetardazo=self::calculaPosicionAleatoria();
                                }          
                            break;
                            case 6: //Fin del tablero y del barco 
                                //Recalcula 
                                $posExtremo=self::UltimaPosicionOtroExtremo($pos);

                                if ($posExtremo<0){ //Barco hundido
                                    $this->rumbo=0;
                                    $this->siguientePetardazo=self::calculaPosicionAleatoria();
                                }else{
                                    $this->rumbo=12;
                                    $this->siguientePetardazo=$posExtremo+$movArriba;
                                }
                            break;
                            case 3: //Fin del tablero y del barco 
                                //Recalcula 
                                $posExtremo=self::UltimaPosicionOtroExtremo($pos);

                                if ($posExtremo<0){ //Barco hundido
                                    $this->rumbo=0;
                                    $this->siguientePetardazo=self::calculaPosicionAleatoria();
                                }else{
                                    $this->rumbo=9;
                                    $this->siguientePetardazo=$posExtremo-1;
                                }
                            break;
                        }
                    break;
                    case 6: //ACIERTO- Zona Borde Inferior
                        
                        switch($this->rumbo){
                            case 0:                 //Reorienta hacia E/N/W

                                if ($this->TableroLogico[$pos+$movArriba]=="?"){
                                    $this->rumbo=12;
                                    $this->siguientePetardazo=$pos+$movArriba;
                                    
                                }else if ($this->TableroLogico[$pos+1]=="?"){
                                    $this->rumbo=3;
                                    $this->siguientePetardazo=$pos+1; //Una a la derecha 
                                }
                                else if ($this->TableroLogico[$pos-1]=="?") {     
                                        $this->rumbo=9;
                                        $this->siguientePetardazo=$pos-1; //Arriba 
                                }else{
                                     //Por si acaso algo falla tira aleatorio
                                     $this->siguientePetardazo=self::calculaPosicionAleatoria();
                                }       
                            break;
                            case 6:  //Rumbo Sur-> Ultima posicion al Norte
                                 
                                $posExtremo=self::UltimaPosicionOtroExtremo($pos);

                                if ($posExtremo<0){ //Barco hundido
                                    $this->rumbo=0;
                                    $this->siguientePetardazo=self::calculaPosicionAleatoria();
                                }else{
                                    $this->rumbo=12; //Sigue linea norte
                                    $this->siguientePetardazo=$posExtremo+$movArriba; 
                                }
                            break;

                            case 3: //Rumbo Este-> Ultima posicion al Oeste

                                //Comprueba tablero lógico 
                                if($this->TableroLogico[$pos+1]=="?"){
                                    $this->siguientePetardazo=$pos+1;
                                }else{
                                    $posExtremo=self::UltimaPosicionOtroExtremo($pos);
                                    if ($posExtremo<0){ //Barco hundido
                                        $this->rumbo=0;
                                        $this->siguientePetardazo=self::calculaPosicionAleatoria();
                                    }else{
                                        $this->rumbo=9;
                                        $this->siguientePetardazo=$posExtremo-1;
                                    }         
                                }
                            break;

                            case 9:  //Rumbo Oeste-> Ultima posicion al Este
                           
                                if($this->TableroLogico[$pos-1]=="?"){
                                     $this->siguientePetardazo=$pos-1;
                                }else{
                                    $posExtremo=self::UltimaPosicionOtroExtremo($pos);
                                if ($posExtremo<0){ //Barco hundido
                                    $this->rumbo=0;
                                    $this->siguientePetardazo=self::calculaPosicionAleatoria();
                                }else{
                                    $this->rumbo=3;
                                    $this->siguientePetardazo=$posExtremo-1;
                                }
                            }
                            break;
                        }

                    break;
                    case 7://ESQUINA INF. IZQ
                        switch($this->rumbo){
                            case 0: //Reorienta hacia N/W

                                if ($this->TableroLogico[$pos+$movArriba]=="?"){
                                    $this->rumbo=12;
                                    $this->siguientePetardazo=$pos+$movArriba; //Arriba 
                                }else if ($this->TableroLogico[$pos+1]=="?"){
                                    $this->rumbo=3;
                                    $this->siguientePetardazo=$pos+1; //Una a la derecha 
                                }
                                else{ //Por si acaso algo falla tira aleatorio
                                    $this->siguientePetardazo=self::calculaPosicionAleatoria();
                                }          
                            break;
                            case 6: //Rumbo Sur -> Posicion Norte anterior
                                
                                $posExtremo=self::UltimaPosicionOtroExtremo($pos);

                                if ($posExtremo<0){ //Barco hundido
                                    $this->rumbo=0;
                                    $this->siguientePetardazo=self::calculaPosicionAleatoria();
                                }else{
                                    $this->rumbo=12; //Sigue la linea al Norte
                                    $this->siguientePetardazo=$posExtremo+$movArriba;
                                }
                            break;
                            case 9: //Fin del tablero y del barco 
                                //Recalcula 
                                $posExtremo=self::UltimaPosicionOtroExtremo($pos);

                                if ($posExtremo<0){ //Barco hundido
                                    $this->rumbo=0;
                                    $this->siguientePetardazo=self::calculaPosicionAleatoria();
                                }else{
                                    $this->rumbo=3; //Sigue la linea al Este
                                    $this->siguientePetardazo=$posExtremo+1;
                                }
                            break;
                        }         
                    break;
                    case 8: //ACIERTO- Zona Lateral Izquierda
                        switch($this->rumbo){
                            case 0:                 //Reorienta hacia N/S/E
                                if ($this->TableroLogico[$pos+$movArriba]=="?"){
                                    $this->rumbo=12;
                                    $this->siguientePetardazo=$pos+$movArriba; 
                                }else if ($this->TableroLogico[$pos+1]=="?"){
                                    $this->rumbo=3;
                                    $this->siguientePetardazo=$pos+1; 
                                }                
                                else if ($this->TableroLogico[$pos+$movAbajo]=="?") {     
                                        $this->rumbo=6;
                                        $this->siguientePetardazo=$pos+$movAbajo;}
                                else{
                                     //Por si acaso algo falla tira aleatorio
                                     $this->siguientePetardazo=self::calculaPosicionAleatoria();
                                }       
                            break;
                            case 12: //Rumbo Norte -> Posicion Sur es la última

                                if($this->TableroLogico[$pos-1]=="?"){
                                    $this->siguientePetardazo=$pos-1;
                               }else{
                                    
                                    $posExtremo=self::UltimaPosicionOtroExtremo($pos);

                                    if ($posExtremo<0){ //Barco hundido
                                        $this->rumbo=0;
                                        $this->siguientePetardazo=self::calculaPosicionAleatoria();
                                    }else{
                                        $this->rumbo=6; //Continua linea por el Sur
                                        $this->siguientePetardazo=$posExtremo+$movAbajo;
                                    }
                                }
                            break;

                            case 9: //Rumbo Oeste -> Posicion Este es la última
                                
                                if($this->TableroLogico[$pos-1]=="?"){
                                    $this->siguientePetardazo=$pos-1;
                                }else{
                                    $posExtremo=self::UltimaPosicionOtroExtremo($pos);
                                    if ($posExtremo<0){ //Barco hundido
                                        $this->rumbo=0;
                                        $this->siguientePetardazo=self::calculaPosicionAleatoria();
                                    }else{
                                        $this->rumbo=3; //Continua la linea por el Este
                                        $this->siguientePetardazo=$posExtremo+1;
                                    }         
                                }
                            break;

                            case 6:  //Rumbo Oeste -> Posicion Este es la última
                           
                                if($this->TableroLogico[$pos-1]=="?"){
                                     $this->siguientePetardazo=$pos-1;
                                }else{
                                    $posExtremo=self::UltimaPosicionOtroExtremo($pos);
                                    if ($posExtremo<0){ //Barco hundido
                                        $this->rumbo=0;
                                        $this->siguientePetardazo=self::calculaPosicionAleatoria();
                                    }else{
                                        $this->rumbo=3;
                                        $this->siguientePetardazo=$posExtremo+1;
                                    }
                                }
                            break;
                        }
                    break;

                }
        
            break;
           

        }
    }



/*Actualiza/Inicializa el atributo ultimas_5jug, con la jugada recien ejecutada y su resultado.
            Si el resultado es 1 (true), 
Entradas: 2 enteros
Salidas: no tiene*/
    public function GuardarUltimaJugada($pos,$resultado){

        //Actualiza el Tablero Lógico con los valores que recibe de controlador_partida::EjecutarDisparo()
        self::updtTlogico($pos,$resultado);
       /* $tam=count($this->ultimas_5jug);
        switch ($tam){
            case 0:
                $this->ultimas_5jug[0]=array($pos,$resultado);
            break;
            case 5:
                array_shift($this->ultimas_5jug); 
                array_push($this->lineaDeAcierto, array($pos, $resultado));
            break;

            default:
                $this->lineaDeAcierto[$tam]=array($pos,$resultado);
                //array_push($this->lineaDeAcierto, array($pos, $resultado));
            break;
        }

        if ($resultado==1){
            self::inputLineaAcierto($pos);
            
        }*/

        

    }
 
}