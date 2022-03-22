<?php
session_name("HundirFlota");
session_start(); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="CSS/index.css" rel="stylesheet" type="text/css" />
    <link rel="icon" href="images/favicon.ico" type="image/png" />
    <script defer type="text/javascript" src="JS/Formulario.js"></script>

    <title>Login</title>
</head>

<body>
<div class='contenedor'>
      <form id='form1' class='formulario_intro' method='POST' action='index.php'>
          <div id='login' class='ghost'>
              <h3>Login</h3>
              <p>
                  <label for='txt_usuario'>Usuario</label>
                  <input name='txt_usuario' type='text' />
              </p>
              <p> <label for='txt_password'>Contraseña</label>
                  <input name='txt_password' type='password' />
              </p>
              <p><button name='entrar' type='submit' value='Entrar'>Entrar</button></p>
              <a href='Registro.php'>Quiero registrarme</a>
          </div>
      </form>
      </div>
</body>

</html>

<?php
/********************************************************************************************************************* */
require_once("modelo/clases.php");
require_once("modelo/controlador_usuario.php");
require_once("modelo/moduloConexion.php");


    if (isset($_POST['entrar'])) {  #Login

        if (empty($_POST['txt_usuario']) || empty($_POST['txt_password'])) { //Validación de datos de entrada
            echo "<div class='ghosti'><span class='error'>Error ** Todos los campos son obligatorios</span></div>";
        } else {
            extract($_POST, EXTR_PREFIX_ALL, 'S');
            $ctrlUsu = new ControlUsuario();
            //Sanitizacion de las variables pasada por POST
            $nombreOk= htmlspecialchars($S_txt_usuario); #elimina caracteres especiales HTML --Evita ataques XSS
            $nombreOk=htmlentities($nombreOk, ENT_QUOTES); #elimina comillas dobles y simples --evita SQLInjection
            $passOK= htmlspecialchars($S_txt_password);
            $passOK=htmlentities($passOK, ENT_QUOTES);
            $obUsu = $ctrlUsu->login($nombreOk, $passOK);  //devuelve un usuario
            if ($obUsu->getCodusu() <= 0) { //el usuario / contraseña incorrectos

                echo "<div class='ghosti'><span class='error'>Error ** El usuario o la contraseña son incorrectos</span></div>";
            } else {
                #AKI DEBERIAMOS MACHACAR LA SESION ANTIGUA DE LA BBD CON LA NUEVA SESION PARA EVITAR DOBLES LOGEOS
                #Esto se implementará más adelante, modificacion de la BBDD

                #Cargar usuario en Session serializando y redireccionar a partida
                $_SESSION['usuario'] = serialize($obUsu);
                header("Location: https://localhost/HF/Partida.html");
            }
        }
    }

    if (isset($_POST['registrar'])) { #Registro
        header("Location: https://localhost/HF/Registro.php");
    }


?>