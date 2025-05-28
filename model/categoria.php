<?php
class Categoria{
    public $id, $desc;
    public $eventos = array(); //eventos con esta categoria
    public function getId() { return $this->id; }
    public function getDesc() { return $this->desc; }
    
    public static function obtenerCategoriasConEventos($conn) {
        $categorias = array();
        $resCat = mysqli_query($conn, 'SELECT * FROM Categoria');
        while ($row = mysqli_fetch_assoc($resCat)) {
            $cat = new Categoria();
            $cat->id = $row['id'];
            $cat->desc = $row['descripcion'];
            $cat->eventos = array();
            $resEv = mysqli_query($conn, 'SELECT * FROM Evento WHERE categoria_id = ' . intval($row['id']));
            while ($rowEv = mysqli_fetch_assoc($resEv)) {
                $ev = new Evento();
                $ev->id = $rowEv['id'];
                $ev->titulo = $rowEv['titulo'];
                $ev->desc = $rowEv['descripcion'];
                $ev->fecha = $rowEv['fecha'];
                $ev->lugar = $rowEv['lugar'];
                $cat->eventos[] = $ev;
            }
            $categorias[] = $cat;
        }
        return $categorias;
    }
}
?>