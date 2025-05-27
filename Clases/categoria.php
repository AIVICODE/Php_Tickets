<?php
class Categoria{
    public $id, $desc;
    public $eventos = array(); //eventos con esta categoria
    public function getId() { return $this->id; }
    public function getDesc() { return $this->desc; }
}
?>