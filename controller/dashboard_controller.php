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
