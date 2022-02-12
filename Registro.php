<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Usuario</title>
    <link href="CSS/principal.css" rel="stylesheet" type="text/css" />
    <script src="JS/Formulario.js" type="text/javascript"></script>
</head>
<body id= "cuerpo" class="fondo_pag">
<form id="form1" method="POST" action="Registro.php">
    <div>
    <!--nombre de usuario -->
    <p>
        <label id="lbl_nombre">Tu nombre de usuario: </label>
    </p>  
        <input type="text" id="txt_nombre"> 
    </p>  
        <label id="lbl_error_nombre" visible="false"></label>
    </p>  
     <!--contraseña -->
    <p>
        <label id="lbl_password">Tu contraseña: </label>
    </p>  
        <input type="password" id="txt_password">
        <label id="lbl_error_password" visible="false"></label>
    </p>  
     <!--Confirmación contraseña --> 
        <p>
        <label id="lbl_conf_pass" >Confirma tu contraseña:</label>
        <input type="password" id="txt_conf_pass">
        <label id="lbl_error_confpass" visible="false"></label>
    </p> 
         <!--boton registrar ahora--> 
        <p>
            <input type="submit" id="btn_registro" value="Registrar" />
    </p>   
    </div>
    </form>
</body>
</html>

<?php
/*************************************************************************************************************************** */
  require_once("appData/clases.php");
  require_once("appData/controlador_partida.php");
  require_once("appData/controlador_usuario.php");
  require_once("appData/moduloConexion.php");
?>