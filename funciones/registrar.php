<?php
include "sql.php";

$usr=$_POST["usr"];
$pass=$_POST["pass"];

$conn=conectar();
$sql= "insert into usuario (nombre,contraseña) values ('$usr','$pass')";
modifico($conn,$sql);
desconectar($conn);
header("location: ../index.html");
?>