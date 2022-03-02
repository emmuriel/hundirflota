<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Usuario</title>
    <link href="CSS/registro.css" rel="stylesheet" type="text/css" />
    <script src="JS/Formulario.js" type="text/javascript"></script>
</head>
<body>
<div>
<form id="form1" class="formulario_registro" method="POST" action="Registro2.php">
  
    <!--email -->
    <p>
        <label id="lbl_email">Correo electronico: </label> 
        <input type="email" name="email" id="txt_email">
    </p> 
    <p>
        <span id="lbl_error_email" visible="false"></span>
    </p> 

    <!--nombre de usuario -->
    <p>
        <label id="lbl_nombre">Nombre de usuario: </label> 
        <input type="text" name="nombre" id="txt_nombre">
    </p> 
    <p>
        <span id="lbl_error_nombre" visible="false"></span>
    </p>  
     <!--contraseña -->
    <p>
        <label id="lbl_password">Tu contraseña: </label>
    </p>  
        <input type="password" name="password" id="txt_password">
        <span id="lbl_error_password" visible="false"></span>
    </p>  
     <!--Confirmación contraseña --> 
        <p>
        <label id="lbl_conf_pass" >Confirma tu contraseña:</label>
        <input type="password" name="confirmacion" id="txt_conf_pass">
        <span id="lbl_error_confpass" visible="false"></span>
    </p> 
    
         <!--boton registrar ahora--> 
        <input type="submit" name="registrar" id="registrar"  value="Registrarse" />
   
    
    </form>
    </div>
</body>
</html>

<?php
/*************************************************************************************************************************** */
  require_once("control/clases.php");
  require_once("modelo/funciones.php");
  require_once("modelo/controlador_usuario.php");
  require_once("modelo/moduloConexion.php");

    if(isset($_POST['registrar'])) {
        extract($_POST, EXTR_PREFIX_ALL, 'f');
        $ok=validaFormReg();
        if ($ok==false){ //Error
           // echo "<p><span>Usuario no registrado</span></p>";
        }
        else{
            if ($f_password===$f_confirmacion){
            //Encriptar contraseña
            $hash=password_hash($f_password, CRYPT_SHA256);
            //Crea Usuario
            $nuevoUsu= new Usuario(null,$f_nombre,$f_email,$hash,0,0,0);
            //Registra Usuario
            $ctrlUsu= new ControlUsuario();
            $ctrlUsu->registrarUsuario($nuevoUsu);

            }
            else{
                echo "<p><span>Error:Las contraseñas no coinciden</span></p>";
            }
        
        }

}

?>