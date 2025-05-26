<?php
class Usuario{
    private $id, $nombre, $email, $pass, $fechaReg, $img;
    
    public function getId() { return $id; }
    public function getNom() { return $nombre; }
    public function getEmail() { return $email; }
    public function getPass() { return $pass; }
    public function getFecha() { return $fechaReg; }
    public function getImg() { return $img; }
}
?>