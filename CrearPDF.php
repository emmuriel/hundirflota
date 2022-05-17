<?php
session_name("HundirFlota");
session_start();

require_once("modelo/clases.php");
require_once("modelo/controlador_partida.php");
require_once("modelo/controlador_usuario.php");
require_once("modelo/moduloConexion.php");
require_once("lib/fpdf/fpdf.php");

//Controlar que el usuario esté logeado
if ($_SESSION['usuario']) {
  $obUsu = unserialize($_SESSION['usuario']); # Deserializacion del objeto Usuario.
            $manUsu= new ControlUsuario();
            $ranking= $manUsu->getRanking();

            $pdf=new FPDF();
            $pdf->AddPage();
            $pdf->SetFont('Arial','I',12);
            $pdf->Image("images/cabecera.jpg",30,8,150,30);
            $pdf->Ln(30);
            $pdf->Cell(20);
            $pdf->Cell(40,10,utf8_decode('WebSite: www.HF.org'),0,20,'C');
            $pdf->SetFont('Arial','B',16);
            $pdf->Ln(10);
            $pdf->Cell(22);
            $pdf->Cell(0,10,utf8_decode('DATOS DE USUARIO'),1,40,'C');
            $pdf->SetFont('Arial','',11);
            $pdf->Cell(0,10,utf8_decode('Nombre de Usuario: '.$obUsu->getNombre()),0,10,'center');
            $pdf->Cell(0,10,utf8_decode('Numero de victorias: '.$obUsu->getPuntuacion()),0,10,'center');;
            $pdf->Cell(0,10,utf8_decode('Fecha de documento: '.date('d-m-Y H:i:s')),0,10,'center');
            $pdf->SetFont('Arial','B',16);
            $pdf->Ln(10);
            $pdf->Cell(22);
            $pdf->Cell(100,10,utf8_decode('Ranking Jugadores'),1,40,'C');
            $pdf->SetFont('Arial','B',11);
            $pdf->Cell(50,10,"Usuario",1,0,'C',0);    
            $pdf->Cell(50,10,"Partidas ganadas",1,0,'C');
            $pdf->SetFont('Arial','',11);
            $pdf->Ln(10);
            $pdf->Cell(22);
            foreach ($ranking as $jugador){
                
                $pdf->Cell(50,10,$jugador['nombre'],1,0,'C',0);
                $pdf->Cell(50,10,$jugador['victorias'],1,0,'C',0);
                $pdf->Ln(10);
                $pdf->Cell(22);
            }
            


            $pdf->Output();
            

}
else{
    session_destroy();
    setcookie('HundirFlota','',time()-100);
    header("Location: Error.php");
}
?>