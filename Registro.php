
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Usuario</title>
    <link href="CSS/Formulario1.css" rel="stylesheet" type="text/css" />
    <link rel="icon" href="images/favicon.ico" type="image/png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">

</head>

<body class="bg-dark" >
    
    <div class="container min-vw-25">
        <div class="row">
            <div class="col">
                <div class="mb-3">
                    
                    <h1 class="cabecera text-light text-center"><img class="img-logo" src="./images/logo.png" alt="logo-barco"/> Hundir<span>Flota</span></h1>
                </div>
                <form id="form1" method="POST" action="Registro.php" class="shadow-lg p-5 pt-0 pb-1 m-4 mt-1 mb-0">
                    <h2 class="text-light text-center p-2">Nuevo Usuario</h2>
                    <div class="mb-3">
                        <label for="txt_email" class="form-label text-light" id="lbl_email">Correo electronico: </label>
                        <input type="email" class="form-control bg-dark text-light border-primary" name="email" id="txt_email" aria-describedby="Introduce un email">
                    </div>
                    <!--nombre de usuario -->
                    <div class="mb-3">
                        <label for="nombreUsu" class="form-label text-light">Nombre para el usuario: </label>
                        <input type="text" class="form-control bg-dark text-light border-primary" id="nombreUsu"  name="nombre">
                       <!-- <div class="valid-feedback">esta todo ok</div>
                        <div class="invalid-feedback">esta un pokito mal</div> -->
                    </div>
                    <div>
                        <label for="txt_password" class="form-label text-light">Tu contraseña:  </label>
                        <input type="password" class="form-control bg-dark text-light border-primary" name="password" id="txt_password" autocomplete="new-password">
                    </div>
                        <div id="txt_password" class="form-text mb-3">
                        La contraseña debe contener al menos un caracter numérico y una letra mayuscula-minuscula.
                      </div>
                    <div class="mb-3">
                        <label for="txt_conf_pass" class="form-label text-light">Repite la contraseña: </label>
                        <input type="password" class="form-control bg-dark text-light border-primary" name="confirmacion" id="txt_conf_pass" autocomplete="new-password">
                    </div>
                    <!--boton registrar ahora-->
                    <button type="submit" class="btn btn-primary" name="registrar" id="registrar" value="Registrarse">Registrarse</button>
                 
                    <div class="contact-info text-light mt-3 p-3">
                        <h4>Más info</h4>
                        <ul>
                            
                            <li>  Escríbenos a<i>&raquo</i>hundirlaflotawm@outlook.es</li>
                        </ul>
                    </div>
                </form>
            </div>
        </div> 
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>

<?php
/*************************************************************************************************************************** */
require_once("modelo/clases.php");
require_once("control/funciones.php");
require_once("modelo/controlador_usuario.php");
require_once("modelo/moduloConexion.php");

if (isset($_POST['registrar'])) {
    extract($_POST, EXTR_PREFIX_ALL, 'f');
    $ok = validaFormReg();
    if ($ok == false) { //Error
        // echo "<p><span>Usuario no registrado</span></p>";
    } else {
        if ($f_password === $f_confirmacion) {
            //Encriptar contraseña
            $hash = password_hash($f_password, CRYPT_SHA256);
            //Crea Usuario
            $nuevoUsu = new Usuario(null, $f_nombre, $f_email, $hash, 0, 0, 0);
            //Registra Usuario
            $ctrlUsu = new ControlUsuario();
            $ctrlUsu->registrarUsuario($nuevoUsu);
            header("Location:Registrado.html");
        } else {
            echo "<div class='ghosti'><span class='error'>Error:Las contraseñas no coinciden</span></div>";
        }
    }
}
?>