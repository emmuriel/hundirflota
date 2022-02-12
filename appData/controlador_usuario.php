<?php
require("moduloConexion.php");
class ControlUsuario{

    /*--------------------------------------------------------------------------------------------------------
    ' Nombre:   registrarUsuario
    ' Proceso:  Inserta un nuevo usuario en la BBDD. Comprobando que no se exista ya ninguna con ese nombre
    ' Entradas: Un objeto usuario
    ' Salidas:  Devuelve un booleano (True si la operacion ocurre algun error, False de lo contrario)
    -------------------------------------------------------------------------------------------------------- */
    public function registrarUsuario (Usuario $nuevoUsuario){
        
        $conexion=conexion();
        mysqli_set_charset($conexion, "utf8");  
        $hash=password_hash($nuevoUsuario->getPwd(), CRYPT_SHA256); 
        $consulta = 'INSERT INTO (nombre, pwd, victorias) FROM hf_usuario VALUES (?,?,?)';
        $resultado = mysqli_prepare($conexion , $consulta);       
        $ok=mysqli_stmt_bind_param($resultado,"ssi",$nuevoUsuario->getNombre(),$hash,$nuevoUsuario->getPuntuacion());    
        $ok_exe= mysqli_stmt_execute($resultado);                 

        if ($ok_exe==false){
            echo "<div class='parrafada'><p class='error'>Ha ocurrido un error al registrar el formulario en la BBDD.Registro no guardado</p></div>";  //Controla el error
        }
        else{ //ASOCIAR VARIABLES A LOS VALORES DEVUELTOS DE LA CONSULTA EN EL RESULT_SET
            echo "<div class='parrafada'><p class='exito'>Comercial registrado</p></div>";  
        }
        $conexion->close(); //cerrar conexion
    }

    /*-----------------------------------------------------------------------------------------
    ' Nombre:   login
    ' Proceso:  Busca un usuario dado de alta en la BBDD
    ' Entradas: Dos cadenas (nombre usuario y contraseña)
    ' Salidas:  Devuelve un objeto usuario en caso de encontrarse en la BBDD  o un objeto
    '            usuario con código_usuario 0 en caso contrario.
    '----------------------------------------------------------------------------------------- */
    public function Login(String $nomUsu,String $pwd){
        $entradaSanitizada=htmlspecialchars($nomUsu);
        $conexion=conexion();
        $cadena_escapada=mysqli_real_escape_string($conexion, $entradaSanitizada); //Seguridad para evitar inyeccion SQL
        $consulta = "SELECT codUsu,nombre, pwd, victorias FROM hf_usuario WHERE nombre =?";   
        $resultado = mysqli_prepare ($conexion , $consulta);       
        $ok = mysqli_stmt_bind_param($resultado ,"s", $cadena_escapada);    
        $ok_exe= mysqli_stmt_execute($resultado);                 
      
          if ($ok_exe==false){
              echo "<span>Ha ocurrido un error al hacer la consulta en la BBDD.</span>";  //Controla el error
          }
          else{ 
              $ok=mysqli_stmt_bind_result($resultado, $db_codUsu,$db_usu,$db_hash,$db_victorias);
                if ($ok==false){ //Controlar error
                      echo "<span>Ha ocurrido un error al hacer la consulta en la BBDD.</span>";  //Controla el error          
                    }
                    else{  
                      $busqueda=false;
                          while (mysqli_stmt_fetch($resultado)) { //La consulta devuelve valores, comprobar contraseña
                              $busqueda=true;
                              //Comprueba contraseña   
                              if (password_verify($pwd,$db_hash)){ //éxito-->Cargamos los datos en memoria con un objeto Usuario
                                $objUsuario= new Usuario($db_codUsu,$db_usu,$db_hash,$db_victorias);
                              }
                              else{ $error=1; }         
                          }
                          if ($busqueda==false){
                                //echo "<br><span>El usuario no existe </span>";
                                $objUsuario= new Usuario(0);
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
        $entradaSanitizada=htmlspecialchars($nomUsu);
        $conexion=conexion();
        $cadena_escapada=mysqli_real_escape_string($conexion, $entradaSanitizada); //Seguridad para evitar inyecciones SQL

        $consulta = "SELECT codUsu,nombre, pwd, victoria FROM hf_usuario WHERE nombre =?";   
        $resultado = mysqli_prepare ($conexion , $consulta);       
        $ok = mysqli_stmt_bind_param($resultado ,"s", $cadena_escapada);    
        $ok_exe= mysqli_stmt_execute($resultado);                 
      
          if ($ok_exe==false){
              echo "<span>Ha ocurrido un error al hacer la consulta en la BBDD.</span>";  //Controla el error
          }
          else{ 
              $ok=mysqli_stmt_bind_result($resultado, $db_codUsu);
                if ($ok==false){ //Controlar error
                      echo "<span>Ha ocurrido un error al hacer la consulta en la BBDD.</span>";  //Controla el error          
                    }
                    else{  
                        $registrado=false;
                          while (mysqli_stmt_fetch($resultado)) { 
                            $registrado=true;       
                          }
                          if ($registrado==false){
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
        $entradaSanitizada=htmlspecialchars($nomUsu);
        $conexion=conexion();
        $cadena_escapada=mysqli_real_escape_string($conexion, $entradaSanitizada); //Seguridad para evitar inyecciones SQL

        $consulta = "DELETE FROM hf_usuario WHERE nombre =?";   
        $resultado = mysqli_prepare ($conexion , $consulta);       
        $ok = mysqli_stmt_bind_param($resultado ,"s", $cadena_escapada);    
        $ok_exe= mysqli_stmt_execute($resultado);   
        
        if ($ok_exe==false){
            echo "<span>Ha ocurrido un error al hacer la consulta en la BBDD.</span>";  //Controla el error
        }
        else{ 
            $ok=mysqli_stmt_bind_result($resultado, $db_codUsu);
              if ($ok==false){ //Controlar error
                    echo "<span>Ha ocurrido un error al eliminar al usuario.</span>";  //Controla el error          
                  }
                  else{  
                      $registrado=false;
                        while (mysqli_stmt_fetch($resultado)) { 
                          $registrado=true;       
                        }
                        if ($registrado==false){
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
    public function getRanking(){
        
        $conexion=conexion();
        $resultado = $conexion->query("SELECT nombre, victorias FROM hf_usuario ORDER BY victorias DES");
        $resultado->data_seek(0);

        while ($fila = $resultado->fetch_assoc()) {
            $ranking=$fila;
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
    public function upVictorias($nomUsu)
    {
        //Select del numero de victorias
        $entradaSanitizada=htmlspecialchars($nomUsu);
        $conexion=conexion();
        $nombreUsu=mysqli_real_escape_string($conexion, $entradaSanitizada); //Seguridad para evitar inyecciones SQL
        $resultado = $conexion->query("SELECT victorias FROM hf_usuario WHERE nombre=$nombreUsu");
        $resultado->data_seek(0);
        while ($fila = $resultado->fetch_assoc()) {
            $victorias=$fila['victorias'];
        }
        
        //Actualiza el numero de victorias
        $victorias++;
        $conexion=conexion();
        $resultado = $conexion->query("UPDATE hf_usuario SET victorias=$victorias FROM hf_usuario WHERE nombre=$nomUsu");
        $resultado->data_seek(0);
        while ($fila = $resultado->fetch_assoc()) {
            //Partidas actualizadas
            $error=false;
        }
        $conexion->close(); //cerrar conexion
        return $error;
    }
}
