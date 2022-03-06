<?php session_start(); ?>
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
            <input name="txt_usuario" type="text"  class="txt_campo_intro" />
            <span id="lbl_error_usuario" class="lbl_form" visible="false"></span><br/>
             <input name="txt_password"  type="password"  class="txt_campo_intro" />
             <span id="lbl_error_passw" class="lbl_form" visible="false" ></span>
 
</div>
    <p>
    <input name="entrar" class="btn_entrar"  type="submit" value="" onclick="validar_login()" />
    <input name="registrar" class="btn_nuevo"  type="submit" value="" onclick="registrar()" />
    </p>
</form>
</body>
</html>

<?php
/********************************************************************************************************************* */
    require_once("appData/clases.php");
    //require_once("appData/controlador_partida.php");
    require_once("appData/controlador_usuario.php");
    require_once("appData/moduloConexion.php");

    if(isset($_POST['entrar'])){  #Login
        
        if (empty($_POST['txt_usuario']) || empty($_POST['txt_password'])){ //Validación de datos de entrada
            echo "<span>Todos los campos son obligatorios</span>";
        }
        else{
            extract($_POST, EXTR_PREFIX_ALL, 'S');
            $ctrlUsu= new ControlUsuario();
            $obUsu= $ctrlUsu->login($S_txt_usuario,$S_txt_password);  //devuelve un usuario
                if ($obUsu->getCodusu()<=0){ //el usuario / contraseña incorrectos
                    
                    echo "<span>El usuario o la contraseña son incorrectos</span>";
                }
                    else{
                        #AKI DEBERIAMOS MACHACAR LA SESION ANTIGUA DE LA BBD CON LA NUEVA SESION PARA EVITAR DOBLES LOGEOS
                        #Esto se implementará más adelante, modificacion de la BBDD
                    
                        #Cargar usuario en Session serializando y redireccionar a partida
                        $_SESSION['usuario']= serialize($obUsu) ;
                        
                        header("Location: https://localhost/HF/Partida.php");
                    }
                }
        }
    
    if (isset($_POST['registrar'])){ #Registro
        header("Location: https://localhost/HF/Registro.php");
    }
?>