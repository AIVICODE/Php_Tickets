<?php
class Usuario{
    private $id, $nombre, $email, $pass, $fechaReg, $img;
    
    public function getId() { return $this->id; }
    public function getNom() { return $this->nombre; }
    public function getEmail() { return $this->email; }
    public function getPass() { return $this->pass; }
    public function getFecha() { return $this->fechaReg; }
    public function getImg() { return $this->img; }
}
?>