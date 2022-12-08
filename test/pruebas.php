<?php
/*************************************************************************************************************************** */
/*$num=99;
$x=$num/10;
$y=$num%10;
echo "Numero: ".$num. ", X vale" . $x." Y vale" .$y;
$num=0;
$x=$num/10;
$y=$num%10;
echo "Numero: ".$num. ", X vale" . $x." ,Y vale" .$y;
$num=62;
$x=$num/10;
$y=$num%10;
echo "Numero: ".$num. ", X vale" . $x." Y vale" .$y;
$num=1;*/



 function UltimaPosicionOtroExtremo($posIni,&$rumbo){
    $TableroLogico=array("?","?","?","?","?","?","?","?","?","?","?","?","?","0","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","*","0","*","?","?","?","?","?","?","?","*","1","*","?","?","?","?","?","?","?","*","1","*","?","?","?","?","?","?","?","*","?","*","?","?","?","?","?","?","?","?","?","0","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?","?"); 
    
    $posFinal=$posIni;
         //Estos bucles no ejecutan nada en su interior, recorren el array para obtener un indice
         switch ($rumbo){
             case 12: //N
                
                 for ($i=$posIni; $i<99 && $TableroLogico[$i]=="1"; $i+=10){
                     $posFinal=$posFinal+10;
                 
                 }          
                 //Reajuste del incide/contador y rumbo
                 if ($i>99){ //Controlar error de indexacion de array
                        //Asumimos que la ruta llega a un callejon sin salida. BARCO HUNDIDO
                        $posFinal=-1;
                        $rumbo=0;
                 }else if ($TableroLogico[$i]=="?"){
                     $rumbo=6;  //S
                     $posFinal=$posFinal-10;
                 }else{
                     //Asumimos que la ruta llega a un callejon sin salida. BARCO HUNDIDO
                     $posFinal=-1;
                     $rumbo=0;
                 }
            

             break;
             case 6:
                 for ($i=$posIni; $i>0 && $TableroLogico[$i]=="1"; $i-=10 ){
                     $posFinal=$posFinal-10;
                 }          
                 //Reajuste del incide/contador y rumbo
                 if ($i<0){ //Controlar error de indexacion de array
                        //Asumimos que la ruta llega a un callejon sin salida. BARCO HUNDIDO
                        $posFinal=-1;
                        $rumbo=0;
                 }else if ($TableroLogico[$i]=="?"){
                     $rumbo=12;  //N
                     $posFinal=$posFinal+10;
                 }else{
                     //Asumimos que la ruta llega a un callejon sin salida. BARCO HUNDIDO
                     $posFinal=-1;
                     $rumbo=0;
                 }
            
             break;
             case 3:
                 for ($i=$posIni; intval($i/10) == intval($posIni/10) && $TableroLogico[$i]=="1"; $i-- ){
                     $posFinal--;
                 }     
                 $posFinal++; 
                   
                 //Reajuste del incide/contador y rumbo
                 if (intval($i/10) != intval($posIni/10)){ //Controlar error de indexacion de array
                        //Asumimos que la ruta llega a un callejon sin salida. BARCO HUNDIDO
                        $posFinal=-1;
                        $rumbo=0;
                 }else if ($TableroLogico[$i]=="?"){
                     $rumbo=9;  //W
                 }else{
                     //Asumimos que la ruta llega a un callejon sin salida. BARCO HUNDIDO
                     $posFinal=-1;
                     $rumbo=0;
                 }
                 
                 break;
             case 9:
                 for ($i=$posIni; intval($i/10) == intval($posIni/10) && $TableroLogico[$i]=="1"; $i++ ){
                     $posFinal++;
                 }  
                 $posFinal--;      
                 echo "posfinal".$posFinal."|| intval i ".intval($i/10)."|| intval posIni " .intval($posIni/10). "|| ";    
                 //Reajuste del incide/contador y rumbo
                 if (intval($i/10) != intval($posIni/10)){ //Controlar error de indexacion de array
                        //Asumimos que la ruta llega a un callejon sin salida. BARCO HUNDIDO
                        $posFinal=-1;
                        $rumbo=0;
                 }else if ($TableroLogico[$i]=="?"){
                     
                     $rumbo=3;  //W
                 }else{
                     //Asumimos que la ruta llega a un callejon sin salida. BARCO HUNDIDO
                     $posFinal=-1;
                     $rumbo=0;
                 }
             break;
         }
     return $posFinal;
 }


 $pos=58;
 $rumbo=6;

 $posfinal=UltimaPosicionOtroExtremo($pos,$rumbo);

echo $posfinal." rumbo: ".$rumbo;


?>