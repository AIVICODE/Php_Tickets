<?php
class Categoria{
    
    private $id, $desc;
    private $eventos = array(); //eventos con esta categoria
    
    public function getId() { return $id; }
    public function getDesc() { return $desc; }
}
?>