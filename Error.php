<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Error</title>
  <link href="CSS/index.css" rel="stylesheet" type="text/css" />
  <link rel="icon" href="images/favicon.ico" type="image/png" />

</head>

<body>

  </form>
  <div class='contenedor'>
    <form id='error' class='formulario_intro' method="POST" action='error.php'>
      <div id='login' class='ghost'>
        <h3>ERROR!!</h3>
        <p>
          <span>No tienes acceso a la aplicación</span>
        </p>
        <p><a href="index.php">Login</a></p>
        <p><a href='Registro.php'>Quiero registrarme</a></p>

        </p>
      </div>
    </form>
  </div>

</html>

<?php
/*************************************************************************************************************************** */
if (isset($_POST['aceptar'])) {
  header("Location: https://localhost/HF/index.php");
}
if (isset($_POST['registrar'])) {
  header("Location: https://localhost/HF/Registro.php");
}
?>