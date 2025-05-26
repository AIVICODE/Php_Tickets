<?php
include "cliente.php";
include "evento.php";
include "pos.php";

class Ticket{
    
    private $id, $cantidad, $totalPago, $fechaCompra;
    private $pago; //el pos asociado
    private $cli; //el cliente que comrpo las entradas
    private $evento; //el evento en cuestion

    public function getId() { return $id; }
    public function getCant() { return $cantidad; }
    public function getTotPag() { return $totalPago; }
    public function getFecha() { return $fechaCompra; }
    public function getPago() { return $pago; }
    public function getCli() { return $cli; }
    public function getEvento() { return $evento; }
}
?>