<?php
require_once "categoria.php";
require_once "ticket.php";

class Evento{
    public $id, $titulo, $desc, $img, $fecha, $lugar, $precio, $cupo, $estado;
    public $categorias = array(); //categorias del evento
    public $entradas = array(); //los tickets comprados para el evento
    public function getId() { return $this->id; }
    public function getTit() { return $this->titulo; }
    public function getDesc() { return $this->desc; }
    public function getImg() { return $this->img; }
    public function getFecha() { return $this->fecha; }
    public function getLugar() { return $this->lugar; }
    public function getPrecio() { return $this->precio; }
    public function getCupo() { return $this->cupo; }
    public function getEstado() { return $this->estado; }
    public function getCat() { return $this->categorias; }
    public function getEntradas() { return $this->entradas; }
}
?>