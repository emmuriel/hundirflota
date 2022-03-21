<?php
class JugadaBoot{
    #ESTABLECER VARIABLES QUE NECESITO
    Private $codUsu;  #que es el codigo de partida
    Private $ultimoAciertoX=0;
    Private $ultimoAciertoY=0;
    Private $ultimoDisparoX;
    Private $ultimoDisparoY;
    Private $siguientePosicion;
    Private $caminoElegido;
    Private $barco=[];  #cada linea.
    Private $flotaTocada= array(
        [0]=>2,
        [1]=>2,
        [2]=>3,
        [4]=>4,
        [5]=>5
    );
    Private $caminosDescartados=array(  #caminos
        "N"=>0,
        "S"=>0,
        "E"=>0,
        "W"=>0
    );
    Private $tableroenemigo=[]; // Al generar partida es un arrchar[100]-- todo a 0
    

/********************************************************************************
 * Abre agua en X a raíz de un disparo certero.
 *******************************************************************************/

    public function aguaAlrededor($x, $y){
        #CASOS PARTICULARES, BORDES Y ESQUINAS calculo + : 
        if ($x==0){ 
            if ($y!=0){ #Abre agua al SUR
                $tableroenemigo[$x+10 + ($y-1)]="#";  
                $tableroenemigo[$x+10 + ($y+1)]="#";
            }
            else{  #Abre agua al SUR-ESTE
                $tableroenemigo[$x+10 + ($y+1)]="#";
            }
        }
                
        if ($x==9){ #Abre agua al NORTE
            if($y!=9){
                $tableroenemigo[$x-10 + ($y-1)]="#";
                $tableroenemigo[$x-10 + ($y+1)]="#";

            }
            else{ #Abre agua al NOROESTE
                $tableroenemigo[$x-10 + ($y-1)]="#";
            }  
        }

        if ($y==0){ #BORDE West    -- ABRE AGUA al ESTE
            if ($x!=9){
                $tableroenemigo[$x-10 + ($y+1)]="#";
                $tableroenemigo[$x+10 + ($y+1)]="#";
            }
            else{
                $tableroenemigo[$x-10 + ($y+1)]="#";  //Esquina --abre agua al NOR-ESTE
            }
        }
        if ($y==9){ #Borde East -- abre agua al OESTE
            if ($x!=0){
                $tableroenemigo[$x-10 + ($y-1)]="#";
                $tableroenemigo[$x+10 + ($y-1)]="#";
            }
            else{ //Estamos en la esquina -- abre agua al SUR-OESTE
                $tableroenemigo[$x+10 + ($y-1)]="#";
            }
               
        }

        #Si no estamos en el borde del tablero. Abrir agua en cruz- Direccion de cuadrantes --aguja del reloj
        if ($x!=0 && $x!=9 && $y!=0 && $y!=9){ 
            $tableroenemigo[$x-10 + ($y+1)]="#"; #NOR-ESTE
            $tableroenemigo[$x+10 + ($y+1)]="#"; #SUR-ESTE
            $tableroenemigo[$x+10 + ($y-1)]="#"; #SUR-OESTE
            $tableroenemigo[$x-10 + ($y-1)]="#"; #NOR-OESTE


        }
    }
   
    public function bombasAround($coordenada){


    }
    /********************************************************************************
     * Descarta las direcciones que no son posibles a raiz de 2 coodenadas.
     *******************************************************************************/
    public function comprobarCruz($x,$y){

        #CASOS PARTICULARES, BORDES calculo + : 
        if ($x==0 || $tableroenemigo[$x + $y]=="#"){  #Descartar Norte
            $caminosDescartados["N"]=1;
        }
        if ($x==9 || $tableroenemigo[$x*20 + $y]=="#" ){ #Descartar Sur
            $caminosDescartados["S"]=1;
        }
        if ($y==0 || $tableroenemigo[$x*10 + ($y-1)]=="#"){ #Descartar West    <--
            $caminosDescartados["W"]=1;
        }
        if ($y==9 || $tableroenemigo[$x*10 + ($y+1)]=="#"){ #Descartar East  -->
            $caminosDescartados["E"]=1;
        }
    }

    /*Genera probabilidad
    Comprueba los caminos descartados. Genera las probabilidades que tiene cada camino no descartado de ser el correcto.
    Sobre ese valor se tomará una decision aleatoria.
     */
    public function generaProbabilidad(){
        $cont=4;
        foreach($caminosDescartados as $orientación){
            if ($orientacion==1){
                $cont--;
            }
        }

        return $cont;
    }




    public function decideOrientacion($coordenada){
        $ini=0;

        #Determinar primera jugada
        foreach($tableroenemigo as $pos){
            if ($pos!=0){
                $ini=1;
            }
        }

        if ($ini==0){
            comprobarCruz();
            $probables=generaProbabilidad();

            //generar aleatorio de probables

            

        }
        else{

        }
    }


    {
        # code...
    }
?>