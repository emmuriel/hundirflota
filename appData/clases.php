<?php

class Partida{

    Private $jug1;   //Integer
    Private $tablero1;  //String
    Private $tablero2; //String
    Private $turno;  //Boolean


    /*Constructores */
    public function __construct($codJug,$tablero1,$tablero2,$turno){

        $this->jug1=$codJug;
        $this->tablero1=$tablero1;
        $this->tablero2=$tablero2;
        $this->turno=$turno;
    
    }
    //GETERS
    public function getJug1(){
        return $this->jug1;
    }
    public function getTablero1(){
        return $this->tablero1;
    }
    public function getTablero2(){
        return $this->tablero2;
    }
    public function getTurno(){
        return $this->turno;
    }

    //SETTERS
    public function setJug1($codJug){
         $this->jug1=$codJug;
    }
    public function setTablero1($tablero){
        $this->tablero1=$tablero;
    }
    public function setTablero2($tablero){
        $this->tablero2=$tablero;
    }
    public function setTurno($trn){
        $this->turno=$trn;
    }
} 

class PartidaMultiple extends Partida{
    Private $sesion; //String Variable de sesión
    Private $codPartida; //Integer
    Private $jug2; //Integer
    Private $tablero1;  //String
    Private $tablero2; //String
    Private $turno;  //Boolean


    /*Constructores */
    public function __construct($codJug1,$codJug2,$tablero1,$tablero2,$turno){
        
        $this->jug1=$codJug1;
        $this->jug2=$codJug2;
        $this->tablero1=$tablero1;
        $this->tablero2=$tablero2;
        $this->turno=$turno;
    
    }
    //GETERS
    public function getJug1(){
        return $this->jug1;
    }
    public function getTablero1(){
        return $this->tablero1;
    }
    public function getTablero2(){
        return $this->tablero2;
    }
    public function getTurno(){
        return $this->turno;
    }

    //SETTERS
    public function setJug1($codJug){
         $this->jug1=$codJug;
    }
    public function setTablero1($tablero){
        $this->tablero1=$tablero;
    }
    public function setTablero2($tablero){
        $this->tablero2=$tablero;
    }
    public function setTurno($trn){
        $this->turno=$trn;
    }
} 

class Usuario{
    Private $cod_usu; //Integer
    Private $nombre; //String
    Private $contrasenia; //String
    Private $puntuacion;//Integer

    /*Constructores */
    public function __construct0($codUsu,$nombre,$pwd,$puntuacion){

        $this->cod_usu=$codUsu;
        $this->nombre=$nombre;
        $this->contrasenia=$pwd;
        $this->puntuacion=$puntuacion;
    
    }
    /*Constructores */
    public function __construct1($codUsu){

        $this->cod_usu=$codUsu;
    
    
    }
    //GETERS
    public function getCodUsu(){
        return $this->cod_usu;
    }
    public function getNombre(){
        return $this->nombre;
    }
    public function getPwd(){
        return $this->contrasenia;
    }
    public function getPuntuacion(){
        return $this->puntuacion;
    }

    //SETTERS
    public function setCodUsu($codUsu){
         $this->cod_usu=$codUsu;
    }
    public function setNombre($nombre){
        $this->nombre=$nombre;
    }
    public function setPwd($pwd){
        $this->contrasenia=$pwd;
    }
    public function setTurno($ptos){
        $this->puntuacion=$ptos;
    }
} 
?>