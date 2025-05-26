<?php
include "categoria.php";
include "ticket.php";

class Evento{
    
    private $id, $titulo, $desc, $img, $fecha, $lugar, $precio, $cupo, $estado;
    private $categorias = array(); //categorias del evento
    private $entradas = array(); //los tickets comprados para el evento
    
    public function getId() { return $id; }
    public function getTit() { return $titulo; }
    public function getDesc() { return $desc; }
    public function getImg() { return $img; }
    public function getFecha() { return $fecha; }
    public function getLugar() { return $lugar; }
    public function getPrecio() { return $precio; }
    public function getCupo() { return $cupo; }
    public function getEstado() { return $estado; }
    public function getCat() { return $categorias; }
    public function getEntradas() { return $entradas; }
}
?>