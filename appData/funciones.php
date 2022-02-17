<?php 
  /*'-------------------------------------------------------------------------------------
    ' Nombre: logout
    ' Proceso: Realiza el proceso de logout de la aplicación. Elimina la variable de sessión del
                usuario y borra el valor de $_SESSION. Luego redirige a la página de incio.
    ' Entradas: No tiene, toma los valores de $_SESSION
    ' Salidas: No tiene
    '-------------------------------------------------------------------------------------*/

    function logout(){
        session_destroy();
        unset($_SESSION['usuario']);
        header('Location:https://localhost/index.php'); //redirige a index.php
    }


  /*'-------------------------------------------------------------------------------------
    ' Nombre: validaFormReg
    ' Proceso: Realiza el proceso de validación del formalio de registro de usuario
    ' Entradas: No tiene, toma los valores de $_POST
    ' Salidas: Un booleano, true- si todo está ok
                            false- en caso de haber algun error
    '-------------------------------------------------------------------------------------*/
    function validaFormReg(){

        extract($_POST, EXTR_PREFIX_ALL, 'f');

        $ok=true;
        //Campos vacíos
        if (empty($f_nombre) ||empty($f_email) || empty($f_password) || empty($f_confirmacion)){
          $ok=false;
          echo "<p><span>**Error: Todos los campos son obligarios</span></p>";
        }
        else{
        //Nombre de usuario válido
        //Formato de correo válido 
        //Contraseña segura
        
        $ok=false;
        echo "<p><span>**Error:La contraseña debe tener al entre 8 y 16 caracteres, al menos un dígito, al menos una minúscula, al menos una mayúscula y al menos un caracter no alfanumérico</span></p>";
        }
        
        if ($ok==true){
          //Nombre de usuario ya existe en la BBDD
          $ctrl=new ControlUsuario();
        if($ctrl->usuarioRegistrado($f_nombre)){
          $ok=false;
          echo "<p><span>**Error: El nombre de usuario ya existe</span></p>";
        }
        
        //Correo ya existe ya existe en la BBDD
        if($ctrl->emailRegistrado($f_mail)){
          $ok=false;
          echo "<p><span>**Error: La dirección de correo ya está registrada</span></p>";
        }
        }

        return $ok;
    }
 /*'-------------------------------------------------------------------------------------
    ' Nombre: pssSecure()
    ' Proceso: Valida mediante expresiones regulares si una contraseña es segura en base a 
              los siguientes requisitos:
              Debe tener: mayuscula, minuscula, un caracter numérico al menos, un caracter especial al menos
              Longitud mínima 8 caracteres, longitud maxima 16;
    ' Entradas: Una cadena, que es la contraseña, pasada por valor
    ' Salidas: Un booleano, true- si todo está ok
                            false- en caso no cumplir con los requisitos
    '-------------------------------------------------------------------------------------*/
function passSecure($pass){
  $ok=true;
  if(!preg_match_all("/^(?=.*\d)(?=.*[\u0021-\u002b\u003c-\u0040])(?=.*[A-Z])(?=.*[a-z])\S{8,16}$/",$pass)){
    $ok=false;
  }
  return $ok;
}
 /*'-------------------------------------------------------------------------------------
    ' Nombre: usuValido()
    ' Proceso: Valida mediante expresiones regulares
                si un nombre de usuario es válido atendiendo a los siguientes requisitos:
               - Debe empezar por dos letra
               - Debe contener al menos dos letras
               -puede contener los caracteres - _ /
               -Puede contener digitos
               -Longitud mínima: 2 caracteres,
               -Longitud máxima: Lo que ponga en la BBDD (en nuestro caso 35 caracteres)
    ' Entradas: Una cadena, que es la contraseña, pasada por valor
    ' Salidas: Un booleano, true- si todo está ok
                            false- en caso no cumplir con los requisitos
    '-------------------------------------------------------------------------------------*/
function usuValido($nomUsu){
  $ok=true;
  if(!preg_match_all("/^[a-z]+[a-z]+(-_\/)*(1-9)*\i{2,35}$/",$nomUsu)){
  } 
  return $ok;
}


/*
function emailValido($email){
  $ok=true;

}*/


?>