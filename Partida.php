<?php
session_name('HF');
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Partida</title>
    <link href="CSS/principal.css" rel="stylesheet" type="text/css" />
    <script src="JS/Partida.js" type="text/javascript"></script>
</head>
<body onunload="cierra_usuario()">
    <form id="formulario" class="formulario_partida" action="Partida.php"  method="POST">
    <!--Div para la cabecera -->
        <div id= "cabecera" class="cabecera">
        <span id="datos_usuario" visible="false" class="datos_usu"></span>
        </div>
      <!--Div para la botones -->  
    
            <table id="tbl_usuario" class="tabla_usu"></table>
            <input id="Empezar" type="submit" class="btn_empezar" value=""  onclick="Empezar_partida()"  />
            <input id="Abandonar"  class="btn_abandonar" type="submit" value="" onclick="terminar_partida()"  />
            <table id="tbl_boot" class="tabla_boot"></table>
  
    </form>
</body>
</html>


<?php
/************************************************************************************************************ */
  require_once("appData/clases.php");
  require_once("appData/controlador_partida.php");
  require_once("appData/controlador_usuario.php");
  require_once("appData/moduloConexion.php");

  //Controlar que el usuario esté logeado
  if ($_SESSION['token']&&$_SESSION['usu']){
    echo "<p>Total de conexiones:". $_SESSION['tconex'] ." </p><br>";
    echo "<form id='logout' action='validado.php' method='POST'><input type='submit' class='submit' name='salir' value='Cerrar sesion'></form><br><br><br>";
    echo "<div><p class='titulo'>Bienvenid@  ". $_SESSION['usu']."!!</p></div>";
   
 }
  else {
    header("Location: https://localhost/HF/error.php");
  }

  if(isset($_POST['salir'])) {
      logout();
  
}
?>