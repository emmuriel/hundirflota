        
<?php
$posicion=91;
        $posicionConceptual=0; //Por defecto estamos en zona 0
        if ($posicion==0){        
            $posicionConceptual=1;
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
        }else if(intval($posicion%10)==0){  
            $posicionConceptual=8;
        }else if($posicion%10==9){  
            $posicionConceptual=4;
        }  

        echo $posicionConceptual;

        ?>