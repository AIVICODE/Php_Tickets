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

    public static function usuarioEsOrganizador($conn, $usuario_id) {
        $res = mysqli_query($conn, "SELECT * FROM Organizador WHERE id = $usuario_id");
        return mysqli_num_rows($res) > 0;
    }
    public static function obtenerCategorias($conn) {
        $categorias = array();
        $resCat = mysqli_query($conn, 'SELECT * FROM Categoria');
        while ($row = mysqli_fetch_assoc($resCat)) {
            $categorias[] = $row;
        }
        return $categorias;
    }
    public static function getEventoDisponible($conn, $evento_id) {
        $resEv = mysqli_query($conn, "SELECT * FROM Evento WHERE id = $evento_id AND fecha > NOW()");
        if ($rowEv = mysqli_fetch_assoc($resEv)) {
            $evento = new Evento();
            $evento->id = $rowEv['id'];
            $evento->titulo = $rowEv['titulo'];
            $evento->desc = $rowEv['descripcion'];
            $evento->fecha = $rowEv['fecha'];
            $evento->lugar = $rowEv['lugar'];
            $evento->precio = $rowEv['precio'];
            $evento->cupo = $rowEv['cupo'];
            $evento->estado = $rowEv['estado'];
            return $evento;
        }
        return null;
    }
    public function crearEvento($conn, $titulo, $descripcion, $fecha, $lugar, $precio, $cupo, $estado, $organizador_id, $categoria_id) {
        $sql = "INSERT INTO Evento (titulo, descripcion, fecha, lugar, precio, cupo, estado, organizador_id, categoria_id) VALUES ('$titulo', '$descripcion', '$fecha', '$lugar', $precio, $cupo, '$estado', $organizador_id, $categoria_id)";
        if (mysqli_query($conn, $sql)) {
            $evento_id = mysqli_insert_id($conn);
            return ['ok' => true, 'evento_id' => $evento_id];
        } else {
            return ['ok' => false];
        }
    }
}
?>