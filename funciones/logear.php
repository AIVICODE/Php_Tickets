<?php
include "sql.php";

$usr=$_POST["usr"];
$pass=$_POST["pass"];

$conn=conectar();
$sql="SELECT * FROM `usuario` WHERE `nombre` = '$usr' AND `contraseña` ='$pass'";

$res=buscar($conn,$sql);

if(mysqli_num_rows($res) == 1){
    echo "loggin exitoso";
} else { echo "nick o pass incorrectos"; }
desconectar($conn);
?>