<?php
require_once("moduloConexion.php");
require_once("clases.php");
class ControlUsuario
{

  /*--------------------------------------------------------------------------------------------------------
    ' Nombre:   registrarUsuario
    ' Proceso:  Inserta un nuevo usuario en la BBDD. Comprobando que no se exista ya ninguna con ese nombre
    ' Entradas: Un objeto usuario
    ' Salidas:  Devuelve un booleano (True si la operacion ocurre algun error, False de lo contrario)
    -------------------------------------------------------------------------------------------------------- */
  public function registrarUsuario(Usuario $nuevoUsuario)
  {

    $conexion = conexionBBDD();

    mysqli_set_charset($conexion, "utf8");
    $nombre=$nuevoUsuario->getNombre();
    $mail=$nuevoUsuario->getEmail();
    $pwd=$nuevoUsuario->getPwd();
    $victorias=0;
    $estado=0;
    $conexiones=0;


    $consulta = 'INSERT INTO usuario (usuario,email, pwd, victorias,estado,conexiones) VALUES (?,?,?,?,?,?)';
    $resultado = mysqli_prepare($conexion, $consulta);
    $ok = mysqli_stmt_bind_param($resultado, "sssiii", $nombre, $mail, $pwd, $victorias, $estado, $conexiones);
    $ok_exe = mysqli_stmt_execute($resultado);
 
    if ($ok_exe == false) {
     echo "<div class='parrafada'><p class='error'>Ha ocurrido un error al registrar el formulario en la BBDD.Registro no guardado</p></div>";  //Controla el error
    } 
    $conexion->close(); //cerrar conexion

  }

  /*-----------------------------------------------------------------------------------------
    ' Nombre:   login
    ' Proceso:  Busca un usuario dado de alta en la BBDD
    ' Entradas: Dos cadenas (nombre usuario y contraseña)
    ' Salidas:  Devuelve un objeto usuario en caso de encontrarse en la BBDD  o un objeto
    '            usuario con código_usuario 0 en caso contrario, o código_usuario -1 en caso
                de que el usuario exista pero la contraseña sea incorrecta
                
    '----------------------------------------------------------------------------------------- */
  public function login(String $nomUsu, String $pwd)
  {
    $entradaSanitizada = htmlspecialchars($nomUsu);
    $conexion = conexionBBDD();
    $cadena_escapada = mysqli_real_escape_string($conexion, $entradaSanitizada); //Seguridad para evitar inyeccion SQL
    $consulta = "SELECT codUsu,usuario,email,pwd,victorias,estado,conexiones FROM usuario WHERE usuario=?";
    $resultado = mysqli_prepare($conexion, $consulta);
    $ok = mysqli_stmt_bind_param($resultado, "s", $cadena_escapada);
    $ok_exe = mysqli_stmt_execute($resultado);

    if ($ok_exe == false) {
      echo "<span>Ha ocurrido un error al hacer la consulta en la BBDD.</span>";  //Controla el error
    } else {
      $ok = mysqli_stmt_bind_result($resultado, $db_codUsu, $db_usu, $db_mail, $db_hash, $db_victorias, $db_estado, $dbconexiones);
      if ($ok == false) { //Controlar error
        echo "<span>Ha ocurrido un error al hacer la consulta en la BBDD.</span>";  //Controla el error          
      } else {
        $busqueda = false;
        while (mysqli_stmt_fetch($resultado)) { //La consulta devuelve valores, comprobar contraseña
          $busqueda = true;
          //Comprueba contraseña   
          if (password_verify($pwd, $db_hash)) { //éxito-->Cargamos los datos en memoria con un objeto Usuario
            $objUsuario = new Usuario($db_codUsu, $db_usu, $db_mail, $db_hash, $db_victorias, $db_estado,$dbconexiones);

            //$errorEstado=self::cambiarEstado($db_codUsu, 1);  //Actualiza el estado del usuario
            $cod = $objUsuario->getCodUsu();
            //echo   "EL codigo es $cod <br />";
          } else {
            $objUsuario = new Usuario(-1, null, null, null, null, null, 0); #esto es una solucion cutre a la no sobrecarga de constructores.
        
          }
        }
        if ($busqueda == false) {
          //echo "<br><span>El usuario no existe </span>";
          $objUsuario = new Usuario(0, null, null, null, null, null, null);
        }
        mysqli_stmt_close($resultado);
      }
    }

    $conexion->close(); //cerrar conexion
    return $objUsuario;
  }

  /* '---------------------------------------------------------------------------------------------------
    ' Nombre: usuarioRegistrado
    ' Proceso: Comprueba si el nombre de un usuario ya esta registrado
    ' Entradas: Una cadena que contenga el nombre de usuario
    ' Salidas: Devuelve un booleano (True si el usuario ya esta registrado, False de lo contrario)
    '--------------------------------------------------------------------------------------------------- */
  public function usuarioRegistrado($nomUsu)
  {
    $entradaSanitizada = htmlspecialchars($nomUsu);
    $conexion = conexionBBDD();
    $cadena_escapada = mysqli_real_escape_string($conexion, $entradaSanitizada); //Seguridad para evitar inyecciones SQL

    $consulta = "SELECT codUsu FROM usuario WHERE usuario =?";
    $resultado = mysqli_prepare($conexion, $consulta);
    $ok = mysqli_stmt_bind_param($resultado, "s", $cadena_escapada);
    $ok_exe = mysqli_stmt_execute($resultado);

    if ($ok_exe == false) {
      echo "<span>Ha ocurrido un error al hacer la consulta en la BBDD.</span>";  //Controla el error
    } else {
      $ok = mysqli_stmt_bind_result($resultado, $db_codUsu);
      if ($ok == false) { //Controlar error
        echo "<span>Ha ocurrido un error al hacer la consulta en la BBDD.</span>";  //Controla el error          
      } else {
        $registrado = false;
        while (mysqli_stmt_fetch($resultado)) {
          $registrado = true;
        }
        if ($registrado == false) {
          //echo "<br><span>El usuario no existe </span>";
        }
        mysqli_stmt_close($resultado);
      }
    }
    $conexion->close(); //cerrar conexion
    return $registrado;
  }
  /* '---------------------------------------------------------------------------------------------------
    ' Nombre: emailRegistrado
    ' Proceso: Comprueba si una doreccion de email de un usuario ya esta registrado
    ' Entradas: Una cadena que contenga la direccion de email
    ' Salidas: Devuelve un booleano (True si la direccion ya esta registrado, False de lo contrario)
    '--------------------------------------------------------------------------------------------------- */
  public function emailRegistrado($email)
  {
    $entradaSanitizada = htmlspecialchars($email);
    $conexion = conexionBBDD();
    $cadena_escapada = mysqli_real_escape_string($conexion, $entradaSanitizada); //Seguridad para evitar inyecciones SQL

    $consulta = "SELECT codUsu FROM usuario WHERE email =?";
    $resultado = mysqli_prepare($conexion, $consulta);
    $ok = mysqli_stmt_bind_param($resultado, "s", $cadena_escapada);
    $ok_exe = mysqli_stmt_execute($resultado);

    if ($ok_exe == false) {
      echo "<span>Ha ocurrido un error al hacer la consulta en la BBDD.</span>";  //Controla el error
    } else {
      $ok = mysqli_stmt_bind_result($resultado, $db_codUsu);
      if ($ok == false) { //Controlar error
        echo "<span>Ha ocurrido un error al hacer la consulta en la BBDD.</span>";  //Controla el error          
      } else {
        $registrado = false;
        while (mysqli_stmt_fetch($resultado)) {
          $registrado = true;
        }
        if ($registrado == false) {
          //echo "<br><span>El usuario no existe </span>";
        }
        mysqli_stmt_close($resultado);
      }
    }
    $conexion->close(); //cerrar conexion
    return $registrado;
  }
  /*'-------------------------------------------------------------------------------------
    ' Nombre: delUsuario 
    ' Proceso: Elimina un usuario existente en la base de datos.
    ' Entradas: El código de un usuario a eliminar.
    ' Salidas: Si ocurre alguna excepcion la lanza.
    '-------------------------------------------------------------------------------------*/
  public function delUsuario($nomUsu)
  {
    $entradaSanitizada = htmlspecialchars($nomUsu);
    $conexion = conexionBBDD();
    $cadena_escapada = mysqli_real_escape_string($conexion, $entradaSanitizada); //Seguridad para evitar inyecciones SQL

    $consulta = "DELETE FROM usuario WHERE usuario =?";
    $resultado = mysqli_prepare($conexion, $consulta);
    $ok = mysqli_stmt_bind_param($resultado, "s", $cadena_escapada);
    $ok_exe = mysqli_stmt_execute($resultado);

    if ($ok_exe == false) {
      echo "<span>Ha ocurrido un error al hacer la consulta en la BBDD.</span>";  //Controla el error
    } else {
      $ok = mysqli_stmt_bind_result($resultado, $db_codUsu);
      if ($ok == false) { //Controlar error
        echo "<span>Ha ocurrido un error al eliminar al usuario.</span>";  //Controla el error          
      } else {
        $registrado = false;
        while (mysqli_stmt_fetch($resultado)) {
          $registrado = true;
        }
        if ($registrado == false) {
          echo "<br><span>El usuario no existe </span>";
        }
        mysqli_stmt_close($resultado);
      }
    }
    $conexion->close(); //cerrar conexion
  }

  /*'-------------------------------------------------------------------------------------
    ' Nombre: obtenerRanking
    ' Proceso: Hace una consulta en la Base de Datos para obtener las puntuaciones de los
                usuarios ordenado de mayor a menor. El resultado es almacenado en buffer
    ' Entradas: El nombre de un usuario existente.
    ' Salidas: Un array asociativo con el nombre y puntuación de los 10 usuarios con la puntuacion
                más alta.
    '-------------------------------------------------------------------------------------*/
  public function getRanking()
  {
    $ranking=array();
    $conexion = conexionBBDD();
    
    mysqli_set_charset($conexion, "utf8");
    $consulta='SELECT usuario, victorias FROM usuario ORDER BY victorias DESC';
    $resultado = mysqli_query($conexion , $consulta);
    if (mysqli_num_rows($resultado) > 0){   
      $i=0;
      while ($fila = mysqli_fetch_assoc($resultado)) {
        $ranking[$i]=["nombre"=>$fila["usuario"], "victorias"=>$fila["victorias"]];
        $i++;
      }
    }
      else{
        $ranking[0]=["nombre"=>-1];
      }

    $conexion->close(); //cerrar conexion
    return $ranking;
  }

  /*'-------------------------------------------------------------------------------------
    ' Nombre: upVictorias
    ' Proceso: Hace una consulta en la Base de Datos para obtener la puntuación de un 
    '          usuario y seguidamente la actualiza con el nuevo valor. 
    ' Entradas: El código de un usuario existente y los puntos que ha ganado.
    ' Salidas: Un booleano (False si la operación se realiza con exito, True si hay error)
    '------------------------------------------------------------------------------------- */
  public function upVictorias($codUsu)
  {
    //Select del numero de victorias
    $entradaSanitizada = htmlspecialchars($codUsu);
    $conexion = conexionBBDD();
    $nombreUsu = mysqli_real_escape_string($conexion, $entradaSanitizada); //Seguridad para evitar inyecciones SQL
    $resultado = $conexion->query("SELECT victorias FROM usuario WHERE codUsu=$nombreUsu");
    if ($resultado->data_seek(0)){
    while ($fila = $resultado->fetch_assoc()) {
      $victorias = $fila['victorias'];
    }
    //Actualiza el numero de victorias
    $victorias++;
    $conexion = conexionBBDD();
    $resultado = $conexion->query("UPDATE usuario SET victorias=$victorias WHERE codUsu=$codUsu");
    $conexion->close(); //cerrar conexion
  }
}

  /*  '---------------------------------------------------------------------------------------------------
    ' Nombre: cambiarEstado
    ' Proceso: Actualiza el valor del campo estado en la BBDD. Este campo puede tomar 3 valores
          -0 no conectado
          -1 conectado sin partida en curso
          - 2 Conectado con partida en curso
    ' Entradas: El código de usuario.
    ' Salidas: codigo de error: 0--todo ok, 1--error al actualizar, 2--Numero de estado incorrecto.
    '--------------------------------------------------------------------------------------------------- */
  public function cambiarEstado($codUsu, $estado)
  {
    if ($estado < 0 || $estado > 2) {
      $error = 2;
    } else {

      //Actualiza el estado
      $conexion = conexionBBDD();
      $resultado = $conexion->query("UPDATE usuario SET estado=$estado WHERE codUsu=$codUsu");
      $conexion->close(); //cerrar conexion

    }
    return $error;
  }



    /*  '---------------------------------------------------------------------------------------------------
    ' Nombre: cambiarPwd
    ' Proceso: Actualiza el valor del campo pwd. Primero comprueba que la contraseña anterior es igual
              al valor pasado por parámetro
    ' Entradas: El código de usuario, contraseña anterior, nueva contraseña.
    ' Salidas: codigo de error: 0--todo ok, 1--error al actualizar, 2--contraseña actual incorrecta.
    '--------------------------------------------------------------------------------------------------- */
    public function cambiarPwd($codUsu, $currentPwd, $newPwd)
    {
      $errorCompare = self::comparePwd($codUsu, $currentPwd);
      if ($errorCompare==0){
        $hash = password_hash($newPwd, CRYPT_SHA256);
        //Actualiza el estado
        $conexion = conexionBBDD();
        $resultado = $conexion->query("UPDATE usuario SET pwd='". $hash ."' WHERE codUsu=$codUsu");
        $conexion->close(); //cerrar conexion
        $error=0;
      } else{
        $error=4;
      }
      return $error;
    }
/*-----------------------------------------------------------------------------------------
    ' Nombre:   comparePwd
    ' Proceso:  compara la contraseña de un usuario con una pasada por parámetro
    ' Entradas: Código de usuario y contraseña
    ' Salidas:  Devuelve un booleano, true si coincide, false si no coincide o el usuario no existe
                
    '----------------------------------------------------------------------------------------- */
    public function comparePwd($codUsu, $currentPwd)
    {
      $entradaSanitizada = htmlspecialchars($codUsu);
      $conexion = conexionBBDD();
      $cadena_escapada = mysqli_real_escape_string($conexion, $entradaSanitizada); //Seguridad para evitar inyeccion SQL
      $consulta = "SELECT pwd FROM usuario WHERE codUsu=?";
      $resultado = mysqli_prepare($conexion, $consulta);
      $ok = mysqli_stmt_bind_param($resultado, "i", $cadena_escapada);
      $ok_exe = mysqli_stmt_execute($resultado);
  
      if ($ok_exe == false) {
        $error=1;  //Controla el error
      } else {
        $ok = mysqli_stmt_bind_result($resultado, $db_hash);
        if ($ok == false) { //Controlar error
          $error=1; 
        } else {
          $busqueda = false;
          while (mysqli_stmt_fetch($resultado)) { //La consulta devuelve valores, comprobar contraseña
            $busqueda = true;
            //Comprueba contraseña   
            if (password_verify($currentPwd, $db_hash)) { //éxito-->Cargamos los datos en memoria con un objeto Usuario
              $error=0;
            } else {
              $error=4;       
            }
          }
          if ($busqueda == false) {
            $error=1;
          }
          mysqli_stmt_close($resultado);
        }
      }
      $conexion->close(); //cerrar conexion
      return $error;
    }
}
