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
        if ($f_){

        }
        //Contraseña con patrón seguro
        //Nombre de usuario válido
        //Nombre de usuario ya existe en la BBDD
        //Formato de correo válido
        //Correo ya existe ya existe en la BBDD
        //Contraseñas iguales

        if (!preg_match())

        
        
        $ok;
    }




?>