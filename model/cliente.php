<?php
require_once "usuario.php";
require_once "ticket.php";

class Cliente extends Usuario{
    
    private $ticketComprados = array();

    public function getTickets() { return $this->ticketComprados; }
}
?>