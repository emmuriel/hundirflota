<?php
session_name("HundirFlota");
session_start(); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="icon" href="images/favicon.ico" type="image/png" />
    <link rel="stylesheet" type="text/css" href="CSS/styles.css"/>
    <link rel="stylesheet" type="text/css" href="CSS/index.css"/>
    <script src="JS/login.js" type="text/javascript"></script>
</head>

<body class="bg-dark">
      <section>
          <div class="row  g-0">
            <div class="col-lg-7 mt-5">
                <div id="carouselExampleDark" class="carousel carousel-dark slide mt-5" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active" data-bs-interval="10000">
                        <img src="images/s2.png" class="d-block h-100 w-100" alt="Carrusel1">
                        <div class="carousel-caption d-none d-md-block">
                            <h5 class="text-light font-weight-bold">Entra y juega!</h5>
                            <p class="text-light">El mítico juego de Batalla Naval</p>
                        </div>
                        </div>
                        <div class="carousel-item" data-bs-interval="2000">
                        <img src="images/s1.png" class="d-block h-100 w-100" alt="Carrusel2">
                        <div class="carousel-caption d-none d-md-block">
                            <h5 class="text-light font-weight-bold">Prueba tu nivel de estrategia</h5>
                            <p class="text-light">Totalmente gratuito y sin cosas raras</p>
                        </div>
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
            
            <div class="col-lg-5 flex-column align-items-end min-vh-75">
                <div class="px-lg-5 pt-lg-4 pb-lg-3 p-4 w-100 mb-auto">
                    <img src="./images/logo.png" class="img-fluid" >
                </div>
                <div class="px-lg-5 py-lg-4 p-4 w-100 align-self-center">
                    <h1 class="text-light font-weight-bold">Bienvenido piratilla!!</h1>
                    <form id='form1' method='POST' action='index.php'> <!--formulario -->
                        <div class="mb-3">
                            <label for="txt_usuario" class="form-label text-light">Usuario</label>
                            <input type="text" class="form-control bg-dark border-primary text-light" id="txt_usuario" name='txt_usuario'>
                        </div>
                        <div class="mb-3">
                            <label for="txt_password" class="form-label text-light">Password</label>
                            <input type="password" class="form-control bg-dark border-primary text-light" id="txt_password" name="txt_password">
                        </div> 
                        <div class="mb-3">
                            <span class="text-danger m-1" id="error" ></span>
                        </div>
                        <button type="submit" class="btn btn-primary mt-1" name='entrar' id="entrar">Entrar</button>
                    </form>
            
                <div class="text-center p-5 mt-auto">
                    <span class="text-light m-2" >¿Aún no estas registrado?</span>
                    <a href='Registro.php'>Quiero registrarme</a>
                </div>
            </div>
          
        </div>
      </section>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
     
</body>

</html>
<?php
//header('Content-Type: application/json');
/********************************************************************************************************************* */
require_once("modelo/clases.php");
require_once("modelo/controlador_usuario.php");
require_once("modelo/moduloConexion.php");

     
    if (isset($_POST['entrar'])) {  #Login

        if (empty($_POST['txt_usuario']) || empty($_POST['txt_password'])) { //Validación de datos de entrada
            echo "<div class='ghosti'><span class='error'>Error ** Los campos son obligatorios</span></div>";
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
                echo '<script type="text/javascript">window.location.assign("Partida.html");</script>';
            }
        }
    }


    //Petición ajax
    if (isset($json['peticion'])) {

        if ($json['peticion']==1){
            $ctrlUsu = new ControlUsuario();
            //Sanitizacion de las variables pasada por POST
            $nombreOk= htmlspecialchars($json['usu']); #elimina caracteres especiales HTML --Evita ataques XSS
            $nombreOk=htmlentities($nombreOk, ENT_QUOTES); #elimina comillas dobles y simples --evita SQLInjection
            $passOK= htmlspecialchars($json['pss']);
            $passOK=htmlentities($passOK, ENT_QUOTES);
            $obUsu = $ctrlUsu->login($nombreOk, $passOK);  //devuelve un usuario
            if ($obUsu->getCodusu() <= 0) { //el usuario / contraseña incorrectos
                $res=array("respuesta"=>2);
                echo json_encode($res, JSON_FORCE_OBJECT,3);
            } else {
              
                #Cargar usuario en Session serializando. el js redirecciona la partida
                $_SESSION['usuario'] = serialize($obUsu);
                $res=array("respuesta"=>1);
                echo json_encode($res, JSON_FORCE_OBJECT,3);
            }
        }

    }


?>