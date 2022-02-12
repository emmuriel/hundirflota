<?php
function conexion(){
    $mysqli = new mysqli('172.0.0.1', "dewes", "dewes", "HundirFlota");
    if ($mysqli->connect_errno) {
        echo "Fallo al conectar a MySQL: " . $mysqli->connect_error;
    }
    else{
        return $mysqli;
    }
}
?>