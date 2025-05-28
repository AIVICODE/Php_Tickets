<?php
require_once "usuario.php";

class Organizador extends Usuario{

    private $eventosOrganizados = array();

    public function getEventos() { return $$eventosOrganizados; }

    public static function esOrganizador($conn, $usuario_id) {
        $res = mysqli_query($conn, "SELECT * FROM Organizador WHERE id = $usuario_id");
        $esOrg = mysqli_num_rows($res) > 0;
        return $esOrg;
    }

    public static function registrarOrganizador($conn, $id) {
        $sql = "INSERT INTO Organizador (id) VALUES ($id)";
        return mysqli_query($conn, $sql);
    }
}
?>