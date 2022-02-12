<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="CSS/principal.css" rel="stylesheet" type="text/css" />
    <script defer type="text/javascript" src="JS/Formulario.js"></script>

    <title>Login</title>
</head>
<body>
<form id="form1" class="formulario_intro"  method="POST" action="index.php">

<div id="mensaje_carga" class="text_box">
            <div id="div_carga"class="cargando">
        <img alt="loading" src="images/loading.gif"  />
</div> 
            <input id="txt_usuario" type="text"  class="txt_campo_intro" />
            <span id="lbl_error_usuario" visible="false"></span><br/>
             <input id="txt_password"  type="password"  class="txt_campo_intro" />
             <span id="lbl_error_passw" visible="false" ></span>
 
    
    <p>
    <input id="btn_entrar" class="btn_entrar"  type="submit" value="" onclick="validar_login()" />
    <input id="btn_nuevo" class="btn_nuevo"  type="submit" value="" onclick="registrar()" />
    </p>
</form>
</body>
</html>

<?php
/********************************************************************************************************************* */
    require_once("appData/clases.php");
    require_once("appData/controlador_partida.php");
    require_once("appData/controlador_usuario.php");
    require_once("appData/moduloConexion.php");


?>