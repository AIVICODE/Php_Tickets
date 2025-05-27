<?php
require_once "usuario.php";
include "eventos.php";

class Organizador extends Usuario{

    private $eventosOrganizados = array();

    public function getEventos() { return $$eventosOrganizados; }
}
?>