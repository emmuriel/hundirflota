<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Principal</title>
    <link href="CSS/principal.css" rel="stylesheet" type="text/css" />
    <script src="JS/Partida.js" type="text/javascript"></script>
</head>


<body onunload="cierra_usuario()">
<div id="score">

</div>
<div id="Conectados">
<form id="formulario" class="formulario_principal" action="Principal.php"  method="POST">
    <!--Div para la cabecera -->
        <div id= "cabecera" class="cabecera">
        <span id="datos_usuario" visible="false" class="datos_usu"></span>
        </div>
      <!--Div para la botones --> 
            <input id="Jugar" type="submit" value="Jugar" />
</form>
</div>



  
</body>
</html>