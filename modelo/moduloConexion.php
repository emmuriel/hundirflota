<?php
function conexionBBDD(){
    $mysqli = new mysqli('127.0.0.1', "dewes", "dewes", "hf");
    if ($mysqli->connect_errno) {
        echo "Fallo al conectar a MySQL: " . $mysqli->connect_error;
    }
    else{
        return $mysqli;
    }
}
