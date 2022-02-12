<?php 

    function logout(){
        session_destroy();
        unset($_SESSION['token']);
        unset($_SESSION['usu']);
        header('Location:https://localhost/index.php'); //redirige a index.php
    }

    function asignaSesion(){
        $_SESSION['token']= password_hash($_POST['pwd'], CRYPT_SHA256);
        $_SESSION['usu']=$_POST['usuario'];
    }
?>