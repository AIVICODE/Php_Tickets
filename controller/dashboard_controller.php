<?php
// dashboard_controller.php: obtiene categorías y eventos asociados
require_once '../model/categoria.php';
require_once '../model/evento.php';
require_once '../conection/sql.php';

function obtenerCategoriasConEventos() {
    $conn = conectar();
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
    desconectar($conn);
    return $categorias;
}

function esOrganizador($usuario_id) {
    $conn = conectar();
    $res = mysqli_query($conn, "SELECT * FROM Organizador WHERE id = $usuario_id");
    $esOrg = mysqli_num_rows($res) > 0;
    desconectar($conn);
    return $esOrg;
}
