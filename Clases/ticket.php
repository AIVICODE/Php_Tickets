<?php
require_once "cliente.php";
require_once "evento.php";
require_once "pos.php";

class Ticket{
    private $id, $cantidad, $totalPago, $fechaCompra;
    private $pago; //el pos asociado
    private $cli; //el cliente que comrpo las entradas
    private $evento; //el evento en cuestion

    public function getId() { return $this->id; }
    public function getCant() { return $this->cantidad; }
    public function getTotPag() { return $this->totalPago; }
    public function getFecha() { return $this->fechaCompra; }
    public function getPago() { return $this->pago; }
    public function getCli() { return $this->cli; }
    public function getEvento() { return $this->evento; }
}
?>