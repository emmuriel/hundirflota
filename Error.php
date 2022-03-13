<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Error</title>
  <link href="CSS/principal.css" rel="stylesheet" type="text/css" />
  <link  rel="icon"   href="images/favicon.ico" type="image/png" />

</head>

<body>
  <form class="pag_error" method="POST" action="error.php">
    <input type="submit" name="aceptar" value="" class="btn_aceptar" />
    <input type="submit" name="registrar" value="" class="btn_registrar" />

  </form>

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