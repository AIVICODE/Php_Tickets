<?php
include "usuario.php";
include "ticket.php";

class Cliente extends Usuario{
    
    private $ticketComprados = array();

    public function getTickets() { return $ticketComprados; }
}
?>