<?php
function conectar(){
    $server = "localhost";
    $user = "frank";
    $pass = "1234";
    $db = "hphp_equipo6";
	$conn = mysqli_connect($server, $user, $pass, $db);
    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }
    //echo "Connected successfully";
	return $conn;
}

function desconectar($conn){
    mysqli_close($conn);
}

function modifico($conn, $sql){
	$resultado = mysqli_query($conn,$sql) or die ("Error al modificar el contenido dela base de datos");
}

function buscar($conn, $sql){
	$resultado = mysqli_query($conn,$sql) or die ("Error al buscar");
	return $resultado;
}

?>