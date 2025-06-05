<?php
require_once '../model/categoria.php';
require_once '../model/evento.php';
require_once '../model/organizador.php';
require_once '../model/cliente.php';
require_once '../conection/sql.php';

function obtenerCategoriasConEventos() {
    $conn = conectar();
    $categorias = Categoria::obtenerCategoriasConEventos($conn);
    desconectar($conn);
    return $categorias;
}

function esOrganizador($usuario_id) {
    $conn = conectar();
    $esOrg = Organizador::esOrganizador($conn, $usuario_id);
    desconectar($conn);
    return $esOrg;
}

function esCliente($usuario_id) {
    $conn = conectar();
    $esCliente = Cliente::esCliente($conn, $usuario_id);
    desconectar($conn);
    return $esCliente;
}

function buscarEventosPorTituloOCategoria($buscar) {
    $conn = conectar();
    $categorias = array();
    $buscar = mysqli_real_escape_string($conn, $buscar);
    // Buscar categorías que coincidan con el texto
    $resCat = mysqli_query($conn, "SELECT * FROM Categoria WHERE descripcion LIKE '%$buscar%'");
    while ($row = mysqli_fetch_assoc($resCat)) {
        $cat = new Categoria();
        $cat->id = $row['id'];
        $cat->desc = $row['descripcion'];
        $cat->eventos = array();
        // Buscar eventos de esta categoría que coincidan con el texto
        $resEv = mysqli_query($conn, "SELECT * FROM Evento WHERE categoria_id = " . intval($row['id']) . " AND (titulo LIKE '%$buscar%' OR descripcion LIKE '%$buscar%')");
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
    // También buscar eventos que coincidan pero cuya categoría no coincida
    $resEv = mysqli_query($conn, "SELECT * FROM Evento WHERE (titulo LIKE '%$buscar%' OR descripcion LIKE '%$buscar%')");
    $catIdsIncluidos = array_map(function($c) { return $c->id; }, $categorias);
    while ($rowEv = mysqli_fetch_assoc($resEv)) {
        $catId = $rowEv['categoria_id'];
        if (!in_array($catId, $catIdsIncluidos)) {
            // Obtener la categoría
            $resCat2 = mysqli_query($conn, "SELECT * FROM Categoria WHERE id = $catId");
            if ($rowCat2 = mysqli_fetch_assoc($resCat2)) {
                $cat = new Categoria();
                $cat->id = $rowCat2['id'];
                $cat->desc = $rowCat2['descripcion'];
                $cat->eventos = array();
                $categorias[] = $cat;
                $catIdsIncluidos[] = $catId;
            }
        }
        // Agregar el evento a la categoría correspondiente
        foreach ($categorias as $cat) {
            if ($cat->id == $catId) {
                $ev = new Evento();
                $ev->id = $rowEv['id'];
                $ev->titulo = $rowEv['titulo'];
                $ev->desc = $rowEv['descripcion'];
                $ev->fecha = $rowEv['fecha'];
                $ev->lugar = $rowEv['lugar'];
                $cat->eventos[] = $ev;
                break;
            }
        }
    }
    desconectar($conn);
    return $categorias;
}
